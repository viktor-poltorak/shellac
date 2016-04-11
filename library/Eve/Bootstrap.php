<?php

/**
 * 	Bootstrapper script
 *
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @package Eve
 * @license  GPLv3
 */
class Bootstrap
{

    /**
     * @var Zend_Controller_Front
     */
    protected $_controller;

    /**
     * @var Zend_Controller_Router_Rewrite
     */
    protected $_router;

    /**
     * @var SimpleXMLObject
     */
    protected $_project_config;

    public function __construct()
    {
        $this->_project_config = simplexml_load_file('configs/project.xml')->project;
        $this->_setIncludes();

        $this->_controller = Zend_Controller_Front::getInstance();
        $this->_router = $this->_controller->getRouter();
    }

    public function init()
    {
        // detect, is we are currently in debug mode
        if (file_exists('debug')) {
            define('DEBUG', true);
            error_reporting(E_ALL ^ E_STRICT ^ E_DEPRECATED); // all errors exept notices
        } else {
            error_reporting(0);    // no any errors
            define('DEBUG', false);
        }

        if ((int) $this->_project_config->templater->disable_internal_renderer) {
            $this->disableInternalRenderer();
        }

        $this->setLocale((string) $this->_project_config->global->locale);
    }

    public function setLocale($locale)
    {
        setlocale(LC_ALL, $locale);
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function disableInternalRenderer()
    {
        Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
        $this->_controller->setParam('noViewRenderer', true);
    }

    public static function getConfig($file, $section = 'configuration')
    {
        $index = str_replace('.', '', $file);
        if (Zend_Registry::isRegistered($index)) {
            return Zend_Registry::get($index);
        }

        Zend_Loader::loadClass('Zend_Config_Xml');
        $config = new Zend_Config_Xml('configs/' . $file, $section);
        Zend_Registry::set($index, $config);

        return $config;
    }

    private function _setIncludes()
    {
        foreach ($this->_project_config->paths->path as $path) {
            $paths[] = (string) $path;
        }

        $paths = PATH_SEPARATOR . implode(PATH_SEPARATOR, $paths);

        set_include_path(get_include_path() . $paths);
    }

    public function startSession()
    {
        Zend_Session::setOptions(array(
            'save_path' => 'tmp/session',
            'remember_me_seconds' => 864000      // Remember me 10 days
        ));
        Zend_Session::start();
    }

    public function getDb()
    {
        $postfix = '';
        if (file_exists('_server')) {
            $postfix = trim(file_get_contents('_server'));
        }

        $config = $this->getConfig('database.xml', 'database' . $postfix);

        $adapter = Zend_Db::factory($config);
        $adapter->setFetchMode(Zend_Db::FETCH_OBJ);
        $adapter->query("SET NAMES utf8");

        Zend_Db_Table_Abstract::setDefaultAdapter($adapter);

        return $adapter;
    }

    public function getTemplater()
    {

        $adapter = (string) $this->_project_config->templater->adapter;

        if (file_exists('library/Eve/Templater/Adapter/' . $adapter . '.php')) {

            $options = (array) $this->_project_config->templater->options;

            $class = 'Eve_Templater_Adapter_' . $adapter;
            $adapter = new $class($options);

            Zend_Registry::set('templater', $adapter);

            return $adapter;
        } else {
            throw new Exception('No adapter found.');
        }
    }

    public function getCacher()
    {
        $options = $this->getConfig('cache.xml', 'options');

        return Zend_Cache::factory('Core', 'File', $options->global->frontend->toArray(), $options->backend->toArray());
    }

    public function addApplications()
    {
        $moduleSession = new Zend_Session_Namespace('modules');
        $modules = $moduleSession->modules;

        if (!$modules || DEBUG) {
            $dir = opendir('application/modules/');
            $modules = array();
            while ($subDir = readdir($dir)) {
                if (!strstr($subDir, '.') && $subDir != 'default')
                    $modules[] = $subDir;
            }
            $moduleSession->modules = $modules;
        }

        $this->_controller->setControllerDirectory('application/modules/default/', 'default');

        foreach ((array) $modules as $module) {
            $this->_controller->addControllerDirectory('application/modules/' . $module . '/', $module);
        }
    }

    public function addRoute($name, $route, $module, $controller, $action, $varNames = array())
    {
        $this->_router->addRoute($name, new Zend_Controller_Router_Route_Regex(
                $route, array(
            'module' => $module,
            'controller' => $controller,
            'action' => $action
                ), $varNames
        ));
    }

    public function dispatch()
    {
        if (defined('DEBUG')) {
            $this->_controller->throwExceptions(true);
        }
        $this->_controller->returnResponse(true);
        $this->_controller->registerPlugin(new Eve_Plugin_Dispatcher());

        $afterDispatching = $this->_controller->dispatch();

        return $afterDispatching->sendResponse();
    }

}
