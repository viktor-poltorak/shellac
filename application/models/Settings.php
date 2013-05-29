<?php
	class Settings extends Eve_Model_Abstract {
		/**
		 * news table
		 *
		 * @var string
		 */
		public $_name = 'settings';

		protected $_id_field = 'setting_id';
		
		public function getAll() {
			$select = $this->select();
			return $select->query()->fetchAll();
		}

		public function getByName($name){
			$select = $this->select();
			$select->where('name=?', $name);
			$result = $select->query()->fetchObject();

			if($result){
				return $result->value;
			} else {
				return false;
			}
		}
	}