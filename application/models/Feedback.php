<?php

class Feedback extends Eve_Model_Abstract
{

    protected $_id_field = 'id';
    /**
     * @var string
     */
    public $_name = 'feedback';

    public function init()
    {
        parent::init();
    }

    public function insert($bind)
    {
        $bind['date'] = new Zend_Db_Expr('NOW()');
        return parent::insert($bind);
    }

    public function getAll()
    {
        return parent::getAll(false, false, false, 'date', false);
    }

    public function getVisible()
    {
        $select = $this->select();
        $select->where('visible = 1');
        return $select->query()->fetchAll();
    }

    public function setVisible($id, $visibility = true)
    {
        if ($visibility) {
            $bind = array("visible" => 1);
        } else {
            $bind = array("visible" => 0);
        }

        return $this->update($bind, $id);
    }

}