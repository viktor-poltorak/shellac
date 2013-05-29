<?php

class Feedback_IndexController extends Eve_Controller_Action
{

    /**
     * @var Pages
     */
    protected $_feedback;

    public function init()
    {
        parent::init();
        $this->_feedback = new Feedback();
    }    

    public function indexAction()
    {
        $this->_assign('posts', $this->_feedback->getVisible());
        if($this->_hasParam('complete')){
            $this->_assign('successMessage', t('Thanks for you response'));
        }
        $this->_display('feedback/view.tpl');
    }

    public function postAction()
    {
        $error = false;

        $username = strip_tags(trim($this->_request->username));
        $this->_setParam('username', $username);
        if (empty($username)) {
            $this->_assign('feedback_name_error', t('Name can\'t be empty'));
            $error = true;
        }

        $email = strip_tags(trim($this->_request->email));
        $this->_setParam('email', $email);
        $validator = new Zend_Validate_EmailAddress();

        if (!$validator->isValid($email)) {
            $this->_assign('feedback_email_error', t('Invalid email'));
            $error = true;
        }
        
        $text = strip_tags(trim($this->_request->text));
        $this->_setParam('text', $text);
        if (empty($text)) {
            $this->_assign('feedback_text_error', t('Text can\'t be empty'));
            $error = true;
        }

        if ($error) {
            $this->_assign('request', $this->_request);
            $this->_forward('index');
        } else {
            $this->_feedback->insert(array('username' => $username, 'email' => $email, 'text' => nl2br($text)));
            $this->_redirect('/feedback?complete=true');
        }
        
        $this->_forward('index');
    }

}