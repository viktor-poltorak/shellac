<?php

class Product_IndexController extends Eve_Controller_Action
{

    /**
     *
     * @var Products
     */
    protected $_products;

    /**
     *
     * @var Categories
     */
    protected $_categories;

    public function init()
    {
        parent::init();
        $this->_products = new Products();
        $this->_categories = new Categories();
    }

    public function indexAction()
    {
        $this->_redirect('/');
    }

    public function viewAction()
    {
        $id = $this->_request->id;

        if (!$id) {
            $this->_redirect('/');
        }

        $product = $this->_products->load($id);

        $product = $this->_calcDiscount($product);
        $this->_products->updateView($id);
        $leftMenu = $this->_categories->getByParentId($product->category_id);
        if (!$leftMenu) {
            $leftMenu = $this->_categories->getByParentId(0);
        }

        $this->_assign('enableBack', 1);

        $this->_assign('leftMenu', $leftMenu);

        $this->_assign('product', $product);
        $this->_display('products/view.tpl');
    }

}
