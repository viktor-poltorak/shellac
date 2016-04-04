<?php

class IndexController extends Eve_Controller_Action
{

    /**
     * @var Pages
     */
    protected $_pages;

    public function init()
    {
        parent::init();
        $this->_pages = new Pages();
    }

    public function indexAction()
    {
        $this->_assign('indexPage', 1);

        $this->_assign('page', $this->_pages->getByLink('Main_page.html', $this->_lang->getCurrentCode()));

        /* BANNERS* */
        $bannersModel = new Banners();
        $this->_assign('banners', $bannersModel->getAll($this->_lang->getCurrentCode()));

        $this->_display('pages/view.tpl');
    }

    public function productAction()
    {
        $id = (int) $this->_getParam('id');

        if ($id == 0) {
            $this->_redirect('/404');
        }
        $model = new Products();
        $product = $model->load($id, $this->_lang->getCurrentCode());

        if (!$product) {
            $this->_redirect('/404');
        }
        if (empty($product->visible)) {
            $this->_redirect('/404');
        }

        $settings = new Settings();

        $this->_setPageTitle($settings->getByName('title') . ' : ' . $product->title);
        $this->_assign('keywords', $product->keywords);
        $this->_assign('meta', $product->meta);
        $this->_assign('curCat', $product->category_id);
        $this->_assign('product', $product);
        $this->_display('products/show.tpl');
    }

    public function categoryAction()
    {
        $id = (int) $this->_getParam('id');

        if ($id == 0) {
            $this->_redirect('/404');
        }
        $model = new Products();
        $products = $model->getAll($this->_lang->getCurrentCode(), 'all', $id, true);
        $this->_assign('products', $products);
        $this->_assign('curCat', $id);
        $this->_display('products/list.tpl');
    }

}
