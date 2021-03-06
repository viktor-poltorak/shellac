<?php

abstract class Eve_Model_Abstract extends Zend_Db_Table_Abstract
{

    /**
     * @var string
     */
    protected $_name;

    /**
     * users table
     *
     * @var string
     */
    protected $_table_users = Eve_Enum_Tables::USERS;

    /**
     * primary key
     *
     * @var string
     */
    protected $_primary;

    /**
     *
     * @var string
     */
    protected $_lang;

    public function __construct($config = array())
    {
        $this->_lang = Zend_Registry::get('Lang')->getCurrentCode();
        parent::__construct($config);
    }

    public function getTableName()
    {
        return $this->_name;
    }

    public function getPrimaryKey()
    {
        return $this->_primary;
    }

    /**
     * get count of records
     * @param string optional $where
     */
    public function getTotal($where = false)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name, 'COUNT(*) AS count');

        if ($where)
            $select->where($where);

        return $select->query()->fetchObject()->count;
    }

    /**
     * get item base on identity and value
     *
     * @param string $identity
     * @param mixed $value
     * @return array
     */
    public function get($identity, $value)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name);
        $select->where($this->getAdapter()->quoteInto($this->_name . '.' . $identity . ' = ?', $value));

        return $select->query()->fetchObject();
    }

    /**
     * get all records
     *
     * @param int $limit
     * @param int $page
     * @param string $where
     * @return array
     */
    public function getAll($limit = false, $page = false, $where = false, $order = false, $langFilter = true)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name);

        if ($limit) {
            $select->limitPage($page, $limit);
        }

        if ($order) {
            $select->order($order);
        }

        if ($where)
            $select->where($where);

        if ($langFilter) {
            $select->where('lang=?', $this->_lang);
        }

        return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
    }

    /**
     * load a single item by id
     *
     * @param int $id
     * @return array
     */
    public function load($id)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name);
        $select->where($this->getAdapter()->quoteInto($this->_id_field . ' = ?', $id));

        return $select->query()->fetchObject();
    }

    /**
     * 	delete a record
     * @param int $id
     * @return bool | int
     */
    public function delete($id)
    {
        return $this->getAdapter()->delete($this->_name, $this->getAdapter()->quoteInto($this->_id_field . ' = ?', $id));
    }

    /**
     * 	insert a bind of values into table
     * returns last_insert_id
     * @param array $bind
     * @return int
     */
    public function insert(array $bind)
    {
        $this->getAdapter()->insert($this->_name, $bind);

        return $this->getAdapter()->lastInsertId($this->_name);
    }

    /**
     * 	update table with a bind where $id is primary key
     * @param array $bind
     * @param int $id
     * @return bool | int
     */
    public function update(array $bind, $id)
    {
        return $this->getAdapter()->update($this->_name, $bind, $this->getAdapter()->quoteInto($this->_id_field . ' = ?', $id));
    }

    public function getLatest($limit, $page = 1)
    {
        $select = $this->getAdapter()->select();
        $select->from($this->_name);
        $select->limitPage($page, $limit);
        $select->order('added_date DESC');

        return $select->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }

    /**
     * 	update views count
     * @param int $id
     */
    public function updateView($id)
    {
        return $this->getAdapter()->query(
                        'UPDATE `' . $this->_name . '`
				SET `views` = `views`+1
				WHERE `' . $this->_id_field . '` = ' . $id
        );
    }

    public function deleteByCategory($id)
    {
        return $this->getAdapter()->delete($this->_name, $this->getAdapter()->quoteInto('category_id = ?', $id));
    }

    public function deleteBy($identity, $value)
    {
        return $this->getAdapter()->delete($this->_name, $this->getAdapter()->quoteInto($identity . ' = ?', $value));
    }

    /**
     * 	wrapper for adapter
     * @param string $text
     * @param string|int $value
     * @return string
     */
    public function quoteInto($text, $value)
    {
        return $this->getAdapter()->quoteInto($text, $value);
    }

}
