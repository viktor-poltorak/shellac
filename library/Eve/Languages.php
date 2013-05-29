<?php

/**
 * 
 * @author Viktor Poltorak
 * 2011 Jan
 *
 */
class Eve_Languages extends Zend_Db_Table_Abstract
{

    /**
     *
     * @var string
     */
    protected $_name = 'languages';
    /**
     *
     * @var stdClass
     */
    protected $_default;
    /**
     *
     * @var stdClass
     */
    protected $_current;
    /**
     *
     * @var Zend_Session_Namespace
     */
    protected $_sessionStorage;

    /**
     * Default constructor
     *
     * Param example:
     * array('code'=>'en') - will be set current language on en
     *
     * @param array $config
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->_sessionStorage = new Zend_Session_Namespace('language');

        //Init default language
        if ($this->_sessionStorage->default) {
            $this->_default = $this->_sessionStorage->default;
        } else {
            $select = $this->select();
            $select->where('extends = ?', 'default');
            $this->_default = $select->query()->fetchObject();
            $this->_sessionStorage->default = $this->_default;
        }

        //If we have set current language
        if (isset($config['code'])) {
            $select = $this->select();
            $select->where('id = ?', $config['code']);
            $this->_current = $select->query()->fetchObject();
            if($this->_current){
                $this->_sessionStorage->current = $this->_current;
            }
        }

        //If language stored in session
        if (!$this->_current && $this->_sessionStorage->current) {
            $this->_current = $this->_sessionStorage->current;
        } elseif(!$this->_current) {
            $this->_current = $this->_default;
        }
    }

    /**
     * Set current language
     *
     * @param string | stdClass $lang
     */
    public function setCurrentLanguage($lang)
    {
        //Check for param type
        if ($lang instanceof stdClass) {
            $this->_current = $lang;
            $this->_sessionStorage->current = $lang;
        } else {
            $lang = (string) $lang;
            if ($lang != '') {
                $langObj = $this->getByCode($lang);
                if ($langObj) {
                    $this->_current = $langObj;
                    $this->_sessionStorage->current = $langObj;
                }
            }
        }
    }

    /**
     * Get language object by code
     *
     * @param string $code
     * @return stdClass | bool
     */
    public function getByCode($code)
    {
        return $this->select()->where('id = ?', $code)->query()->fetchObject();
    }

    /**
     * return default language object
     *
     * @return stdClass
     */
    public function getDefault()
    {
        return $this->_default;
    }

    /**
     * return default language code
     *
     * @return string
     */
    public function getDefaultCode()
    {
        return $this->_default->id;
    }

    /**
     * Return current language object
     *
     * @return stdClass
     */
    public function getCurrent()
    {
        return $this->_current;
    }

    /**
     * Return current language code
     *
     * @return string
     */
    public function getCurrentCode()
    {
        return $this->_current->id;
    }

    /**
     * Return all available languages
     *
     * @return array
     */
    public function getAll()
    {
        return $this->select()->query()->fetchAll();
    }

}