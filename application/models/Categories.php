<?php

class Categories extends Eve_Model_Abstract
{

    /**
     * news table
     *
     * @var string
     */
    public $_name = 'product_categories';
    protected $_id_field = 'category_id';

    public function getAll()
    {
        return $this->select()->query()->fetchAll();
    }

    public function getByParentId($pid)
    {
        $select = $this->select();
        $select->where('parent_id=?', $pid);
        return $select->query()->fetchAll();
    }

    public function getParent($id)
    {
        $select = $this->select();
        $select->where('parent_id = (select parent_id from product_categories where category_id = ?)', $id);
        return $select->query()->fetchAll();
    }

    public function getParentId($id)
    {
        $select = $this->select();
        $select->where('category_id = ?', $id);
        $result = $select->query()->fetchObject();
        if ($result) {
            return $result->parent_id;
        } else {
            return false;
        }
    }
    
}
