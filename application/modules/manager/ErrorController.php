<?php
	Zend_Loader::loadClass('Eve_Controller_Action');
	
	class Manager_ErrorController extends Eve_Controller_Action {
		
		public function deniedAction() {
			$this->smarty->assign('errors', $this->errors->access_denied);
			$this->smarty->display('manager/inc/error.tpl');
		}
		
	}