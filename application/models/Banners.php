<?php

class Banners extends Eve_Model_Abstract
{

    /**
     * products table
     *
     * @var string
     */
    public $_name = 'banners';
    /**
     * Info table
     *
     * @var string
     */
    public $_info = 'banners_info';
    protected $_id_field = 'id';

    public function load($id, $lang = 'en')
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' as p');
        $select->where('p.' . $this->_id_field . ' = ?', $id);

        $langCond = $this->getAdapter()->quoteInto(' AND info.lang=?', $lang);

        $select->joinInner($this->_info . ' as info',
                'info.' . $this->_id_field . '=' . 'p.' . $this->_id_field
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
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->getAdapter()->delete($this->_info, $where);
    }

    public function insertInfo($bind)
    {
        return $this->getAdapter()->insert($this->_info, $bind);
    }

    public function getAll($lang = 'en', $limit = 'all')
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' as p');
        $langCond = $this->getAdapter()->quoteInto(' AND i.lang=?', $lang);
        $select->join($this->_info . ' as i', 'p.id = i.id' . $langCond);

        if ($limit != 'all') {
            $select->limit($limit);
        }
        return $select->query()->fetchAll();
    }

}