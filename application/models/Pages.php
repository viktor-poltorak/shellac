<?php

class Pages extends Eve_Model_Abstract
{

    protected $_name = Eve_Enum_Tables::PAGES;
    protected $_table_categories = Eve_Enum_Tables::PAGES_CATEGORY;
    protected $_table_users = Eve_Enum_Tables::USERS;
    /**
     * Info table
     *
     * @var string
     */
    public $_info = 'pages_info';
    protected $_id_field = 'page_id';

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

    public function get($id)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' AS p');
        $select->joinLeft($this->_table_users . ' AS u',
                'p.user_id = u.user_id', array('first_name', 'last_name', 'user_id', 'gender')
        );
        $select->where($this->_id_field . ' = ?', $id);
        return $select->query()->fetchObject();
    }

    public function getByLink($link, $lang = false)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' AS p');
        $select->where('link = ?', $link);

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
        $where = $this->getAdapter()->quoteInto($this->_id_field .'= ?', $id);
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
        $select->join($this->_info . ' as i', 'p.page_id = i.page_id' . $langCond);

        if ($limit != 'all') {
            $select->limit($limit);
        }
        return $select->query()->fetchAll();
    }

    public function getMore($limit, $category_id = false)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name, array(
            'page_id'
        ));

        if ($category_id)
            $select->where($this->getAdapter()->quoteInto('category_id = ?', $category_id));

        $select->limit(4);
        $select->order('date_posted DESC');

        $result = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

        $ids = array();

        foreach ($result as $item) {
            $ids[] = $item->page_id;
        }


        $select = $this->getAdapter()->select();
        $select->from($this->_name);
        $select->where('page_id NOT IN (' . implode(',', $ids) . ')');

        if ($category_id)
            $select->where($this->getAdapter()->quoteInto('category_id = ?', $category_id));

        $select->limit(4);
        $select->order('date_posted DESC');

        return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
    }

    public function getByCategory($categoryId, $limit = false, $page = 1)
    {

        $select = $this->getAdapter()->select();
        $select->from($this->_name . ' AS p');
        $select->joinLeft($this->_table_users . ' AS u',
                'p.user_id = u.user_id', array('first_name', 'last_name', 'user_id', 'gender')
        );
        $select->joinLeft($this->_table_categories . ' AS c',
                'p.category_id = c.category_id'
        );
        $select->order('p.date_posted desc');
        $select->where('p.category_id = ?', $categoryId);

        if ($limit)
            $select->limitPage($page, $limit);

        $articles = $select->query()->fetchAll(Zend_Db::FETCH_OBJ);

        foreach ($articles as $key => $article) {
            $articles[$key]->annotation = str_replace('../../..', '', $article->annotation);
            $articles[$key]->body = str_replace('../../..', '', $article->body);
        }

        return $articles;
    }

    public function deleteMatchedPages($ids)
    {
        $sql = 'DELETE FROM ' . $this->_name . ' WHERE publication_id IN (' . implode(',', $ids) . ')';

        return $this->getAdapter()->query($sql)->execute();
    }

    public function fetchPagesByCategories($ids, $fields = array('*'), $limit = false, $order = false)
    {

        $select = $this->getAdapter()->select();
        $select->from($this->_name, implode(',', $fields));
        $select->where('category_id IN (' . implode(',', $ids) . ')');

        if ($limit)
            $select->limit($limit);

        if ($order)
            $select->order($order);

        return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }

    public function fetchByCategories($ids, $limit)
    {

        $select = $this->getAdapter()->select();
        $select->from($this->_name);
        $select->where('category_id IN (' . implode(',', $ids) . ')');

        return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }

}