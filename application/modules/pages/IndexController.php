<?php

class Pages_IndexController extends Eve_Controller_Action
{

    /**
     * @var Pages
     */
    protected $_pages;
    protected $_page;
    /**
     *
     * @var Categories
     */
    protected $_categories;

    public function init()
    {
        parent::init();
        $this->_pages = new Pages();
        $this->_page = $this->_request->getParam('page', 1);
        $this->_assign('js', (array) 'pages');
    }

    public function indexAction()
    {
        $this->_redirect('/404/');
    }

    public function viewAction()
    {
        $link = $this->_request->link;
        $item = $this->_pages->getByLink($link . '.html', $this->_lang->getCurrentCode());
        if (!$item)
            $this->_redirect('/404/');

        $this->_pages->updateView($item->page_id);
        $this->_setPageTitle($item->title);
        $this->_assign('page', $item);

        $this->_assign('keywords', $item->keywords);

        $this->_display('pages/view.tpl');
    }
}