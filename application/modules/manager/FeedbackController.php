<?php

class Manager_FeedbackController extends Eve_Controller_AdminAction
{

    /**
     * @var Pages
     */
    protected $_feedback;
    protected $allowedRoles = array(
        'admins',
        'editors'
    );

    public function init()
    {
        parent::init();
        $this->_feedback = new Feedback();
    }

    public function indexAction()
    {
        $this->_assign('posts', $this->_feedback->getAll());
        $this->_display('feedback/index.tpl');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if (!$id)
            $this->_redirect('/manager/feedback/');

        $this->_feedback->delete($id);
        $this->_redirect('/manager/feedback/');
    }

    public function visibleAction()
    {
        $id = (int) $this->_request->id;
        if (!$id)
            $this->_redirect('/manager/feedback/');

        $feedback = $this->_feedback->load($id);

        if(!$feedback){
            $this->_redirect('/manager/feedback/');
        }

        if($feedback->visible == 0){
            $this->_feedback->setVisible($id);
        } else {
            $this->_feedback->setVisible($id, false);
        }

        $this->_redirect('/manager/feedback/');
    }

}