<?php

/**
 * Generic controller
 *
 * @version 0.2
 * @package Eve
 * @license  GPLv3
 */
class Eve_Controller_Action extends Zend_Controller_Action
{

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    public $db;

    /**
     * @var Eve_Templater_Adapter_Interface
     */
    protected $_templater;

    /**
     * @var Zend_Controller_Request_Http
     */
    protected $_request;
    protected $_is_logged = false;
    protected $_user_role = 0;
    protected $_skin;
    protected $_perPage = 25;

    /**
     * @var Zend_Cache_Core_File
     */
    protected $_cache;

    /**
     *
     * @var Eve_Languages
     */
    protected $_lang;

    /**
     *
     * @var array
     */
    protected $_languages;

    public function init()
    {
        $this->db = Zend_Registry::get('db');
        $this->_templater = Zend_Registry::get('templater');
        $this->_request = $this->getRequest();
        $this->_lang = Zend_Registry::get('Lang');
        $this->errors = new Zend_Config_Xml('configs/errors.xml', 'errors');
        $this->messages = new Zend_Config_Xml('configs/messages.xml', 'messages');


        $this->_languages = $this->_lang->getAll();
        $this->_assign('languages', $this->_languages);

        $this->_assign('currentLang', $this->_lang->getCurrentCode());

        // set default site skin
        $skins = new Skins();
        $this->_setSkin($skins->getDefault()->alias);

        if (Auth::isLogged()) {
            $this->_updateLastSeen(Auth::getAuthInfo()->user_id);
            $this->_user_id = Auth::getAuthInfo()->user_id;
            $this->_is_logged = true;

            if (Auth::getAuthInfo()->role_id == 1) {
                $this->_user_role = 1;
                $this->_assign('role', 'admin');
            }

            $users = new Users();
            $this->_assign('authUser', $users->load($this->_user_id));
            $this->_assign('isLogged', true);
        }
    }

    protected function _isLogged()
    {
        return (bool) $this->_is_logged;
    }

    protected function _isAjax()
    {
        return (bool) $this->getRequest()->isXmlHttpRequest();
    }

    protected function _getEmailTemplate($template)
    {
        return array(
            'subject' => $this->_templater->fetch('mail/subjects/' . $template . '.tpl'),
            'body' => $this->_templater->fetch('mail/' . $template . '.tpl')
        );
    }

    protected function _setPageTitle($title)
    {
        $this->_assign('pageTitle', $title);
    }

    protected function _addScripts($bind)
    {
        $this->_assign('js', $bind);
    }

    protected function _updateLastSeen($userId)
    {
        $users = new Users();

        $users->update(array(
            'last_seen' => new Zend_Db_Expr('NOW()')
                ), $userId);
    }

    protected function _setSkin($name)
    {
        $this->_skin = $name;
        $this->_templater->setOption('template_dir', 'application/views/' . $name);
        $this->_assign('skin_path', 'skins/' . $name);
    }

    protected function _getSkin()
    {
        return $this->_skin;
    }

    protected function _assign($param, $val)
    {
        $this->_templater->assign($param, $val);
    }

    protected function _display($template)
    {
        $this->_templater->assign('template', $template);
        $this->_templater->display('layout/index.tpl');
    }

    protected function _show($template)
    {
        $this->_templater->assign('template', $template);
        $this->_templater->display('layout/lite.tpl');
    }

    protected function _fetch($template)
    {
        return $this->_templater->fetch($template);
    }

    protected function _showTemplate($template)
    {
        $this->_templater->display($template);
    }

}
