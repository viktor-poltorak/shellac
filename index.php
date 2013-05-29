<?php
//Index file
require_once './library/Eve/Bootstrap.php';

$boot = new Bootstrap();
$boot->init();    // initialize bootstrapper
$boot->startSession();  //start session
$boot->addApplications(); //add modules

$templater = $boot->getTemplater();
$db = $boot->getDb();

Zend_Registry::set('db', $db);
Zend_Registry::set('templater', $templater);


require_once './library/Eve/Routes.php';

if (file_exists('maintenance')) {
    $templater->display('maintenance.tpl');
    exit;
}

try {
    $boot->dispatch();
} catch (Exception $e) {
    if (DEBUG) {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode(array(
                'error' => true,
                'message' => join('br />', (array) $e->getMessage())
            ));
        } else {
            $templater->assign('errors', (array) ($e->getMessage() . '<br />' . $e->getFile() . '<br />' . $e->getLine()));
            $templater->assign('template', 'error.tpl');
            $templater->setOption('template_dir', 'application/views/default');
            $templater->display('layout/index.tpl');
        }
    } else {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode(array(
                'error' => true,
                'message' => 'Invalid action.'
            ));
        } else {
            header('Location: /404-not-found/');
        }
    }
}

function __autoload($class)
{
    if (class_exists('Zend_Loader')) {
        Zend_Loader::loadClass($class);
    } else {
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass($class);
    }
}

/**
 * Helper function for translating. Cheap and sleazy hack to maintain
 * string readability.
 * @param $messageid
 * @param mixed $replacement
 * @example MX_Message::addStatus(t('%1$d words was added', count($pairs)));
 */
function t($messageid, $replacement = array())
{
    if (Zend_Registry::isRegistered('translate')) {
        $t = Zend_Registry::get('translate');
        if ($t->isTranslated($messageid)) {
            $translatedMessage = $t->translate($messageid);
            if (!empty($replacement)) {
                if (!is_array($replacement))
                    $replacement = array($replacement);
                return vsprintf($translatedMessage, $replacement);
            } else {
                return $translatedMessage;
            }
        }
    }
    if (!empty($replacement)) {
        if (!is_array($replacement))
            $replacement = array($replacement);
        return vsprintf($messageid, $replacement);
    }
    return $messageid;
}
