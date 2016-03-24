<?php

class Products extends Eve_Model_Abstract
{

    /**
     * products table
     *
     * @var string
     */
    public $_name = 'products';

    /**
     * Info table
     *
     * @var string
     */
    public $_info = 'products_info';
    protected $_id_field = 'product_id';

    public function load($id, $lang = 'en')
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' as p');
        $select->where('p.' . $this->_id_field . ' = ?', $id);

        $langCond = $this->getAdapter()->quoteInto(' AND info.lang=?', $lang);

        $select->joinInner($this->_info . ' as info', 'info.' . $this->_id_field . '=' . 'p.' . $this->_id_field
                . $langCond
        );
        return $select->query()->fetchObject();
    }

    public function getAllInfo($id)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_info);
        $select->where($this->_id_field . '=?', $id);
        return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }

    public function deleteInfo($id)
    {
        $where = $this->getAdapter()->quoteInto('product_id = ?', $id);
        return $this->getAdapter()->delete($this->_info, $where);
    }

    public function insertInfo($bind)
    {
        return $this->getAdapter()->insert($this->_info, $bind);
    }

    public function getAll($lang = 'en', $limit = 'all', $catId = false)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' as p');
        $langCond = $this->getAdapter()->quoteInto(' AND i.lang=?', $lang);
        $select->join($this->_info . ' as i', 'p.product_id = i.product_id' . $langCond);

        if ($catId) {
            $select->where('p.category_id = ?', $catId);
        }

        if ($limit != 'all') {
            $select->limit($limit);
        }
        $select->order('order');
        return $select->query()->fetchAll();
    }

    public function getByCatId($catId, $limit = 15)
    {
        $select = $this->select();
        $select->where('category_id=?', $catId);
        $select->limit($limit);
        $select->order('order');
        return $select->query()->fetchAll();
    }

    public function getMaxOrder($catId)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' as p', 'MAX(p.order) as order');
        $select->where('p.category_id = ?', $catId);
        $order = $select->query()->fetchColumn(0);
        return (int) $order;
    }

    public function updateOrder($calId)
    {
        $select = $this->select();
        $select->where('category_id=?', $calId);
        $products = $select->query()->fetchAll(Zend_Db::FETCH_ASSOC);

        foreach ($products as $index => $category) {
            $category['order'] = $index;
            $this->update($category, $category[$this->_id_field]);
        }
        return true;
    }

}
