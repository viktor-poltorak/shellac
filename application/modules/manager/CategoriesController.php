<?php

class Manager_CategoriesController extends Eve_Controller_AdminAction
{

    protected $_categories;
    protected $allowedRoles = array(
        'admins'
    );

    public function init()
    {
        parent::init();
        $this->_categories = new Categories();
    }

    public function indexAction()
    {
        $categories = $this->_categories->getAll();
        $curLang = $this->_lang->getCurrentCode();
        foreach ($categories as &$cat) {
            if ($curLang != 'en') {
                $name = 'name_' . $curLang;
                $cat->name = $cat->$name;
            }
        }

        $this->_assign('categories', $categories);

        $this->_assign('tab', 'index');
        $this->_display('categories/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('categories/edit.tpl');
    }

    public function createItemAction()
    {
        if ($this->_request->name == '') {
            $errors[] = $this->errors->name_must_be_set;
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $bind = array('name' => $this->_request->name,
                'name_ru' => $this->_request->name_ru,
                'name_ua' => $this->_request->name_ua);
            $this->_categories->insert($bind);
            $this->_redirect('/manager/categories');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/categories/');
        $item = $this->_categories->load($id);
        $this->_assign('request', $item);
        $this->_display('categories/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $bind = array('name' => $this->_request->name,
                'name_ru' => $this->_request->name_ru,
                'name_ua' => $this->_request->name_ua);
            $this->_categories->update($bind, $id);
        }
        $this->_redirect('/manager/categories');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $this->_categories->delete($id);
        }
        $this->_redirect('/manager/categories');
    }

}
