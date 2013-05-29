<?php
class Product_IndexController extends Eve_Controller_Action {

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

	public function init() {
		parent::init();
		$this->_products = new Products();
		$this->_categories = new Categories();
	}

	public function indexAction() {
		$this->_redirect('/');
	}

	public function viewAction(){
		$id = $this->_request->id;

		if(!$id){
			$this->_redirect('/');
		}
		
		$product = $this->_products->load($id);

		$product = $this->_calcDiscount($product);

		$this->_products->updateView($id);


		$leftMenu = $this->_categories->getByParentId($product->category_id);
		if(!$leftMenu){
			$leftMenu = $this->_categories->getByParentId(0);
		}

		$this->_assign('enableBack', 1);

		$this->_assign('leftMenu', $leftMenu);

		$basket = new Eve_Basket();
		$this->_assign('inBasket', $basket->inBasket($id));
		
		$this->_assign('product', $product);
		$this->_display('products/view.tpl');
	}

	protected function _calcDiscount($products){
		$settings = new Settings();
		$currency = $settings->getByName('dollar');
		$currency = str_replace(array('.',','), '', $currency);
		if($products){
			if(is_array($products)){
				foreach($products as &$v){
					if($v->discount > 0){
						$v->price = str_replace('.', "", $v->price);
						$v->price -= ($v->price/100)*$v->discount;
						$v->price = number_format($v->price, 0, ',','.');
					}
					if($currency) $v->dollar = round(str_replace(array('.',','), '', $v->price)*$currency);
				}
			} else {
				if($products->discount > 0){
					$products->price = str_replace('.', "", $products->price);
					$products->price -= ($products->price/100)*$products->discount;
					$products->price = number_format($products->price, 0, ',','.');
				}
				if($currency) $products->dollar = round($products->price*$currency);
			}
		}
		return $products;
	}
}