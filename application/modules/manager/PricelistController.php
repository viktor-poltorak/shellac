<?php
	class Manager_PricelistController extends Eve_Controller_AdminAction {

		protected $allowedRoles = array(
			'admins'
		);

	
		protected $_dir_upload = 'upload/';

			
		public function init() {
			parent::init();
		}
	
		public function indexAction() {
			$this->_display('pricelist/index.tpl');
		}

		public function saveAction(){			
			if ($_FILES['pricelist']) {
				$uploader = new Zend_File_Transfer_Adapter_Http();
				$uploader->setDestination($this->_dir_upload);								
				
				$uploader->addFilter('Rename', array(
					'target' => $this->_dir_upload .'priceList.xls',
					'overwrite' => true)
				);
				
				$priceList = $uploader->receive();
			}		
			$this->_redirect('/manager/pricelist');
		}
	}