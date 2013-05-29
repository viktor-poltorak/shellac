<?php
$boot->getController()->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
                'module'     => 'error',
                'controller' => 'index',
                'action'     => 'page-not-found'
)));	

$boot->addRoute('loginScreen', 'login', 'auth', 'index', 'index');
$boot->addRoute('loginPerform', 'auth/login', 'auth', 'index', 'login');
$boot->addRoute('logoutAction', 'logout', 'auth', 'index', 'logout');
$boot->addRoute('notfound', '404-not-found', 'error', 'index', 'page-not-found');
$boot->addRoute('notfound2', '404', 'error', 'index', 'page-not-found');

$boot->addRoute('viewPage', 'content/(.*).html', 'pages', 'index', 'view', array (1 => 'link'));

$boot->addRoute('showCategory', 'category/(\d+)', 'default', 'index', 'category', array(1 => 'id'));

$boot->addRoute('feedback', 'feedback', 'feedback', 'index', 'index');
$boot->addRoute('feedbackPost', 'feedback/post', 'feedback', 'index', 'post');
