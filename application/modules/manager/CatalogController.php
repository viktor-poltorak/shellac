<?php

class Manager_CatalogController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Categories
     */
    protected $_categories;

    /**
     *
     * @var array
     */
    protected $allowedRoles = array(
        'admins'
    );

    public function init()
    {
        parent::init();
        $this->_categories = new Categories();
        $this->_products = new Products();
    }

    public function indexAction()
    {
        $maxOrder = $this->_categories->getMaxOrder();
        if (empty($maxOrder)) {
            $this->_categories->updateOrder();
        }


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
        $this->_display('catalog/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('catalog/edit.tpl');
    }

    public function createItemAction()
    {
        $params = $this->_request->getPost();

        if (isset($params['name_ru'])) {
            if (empty($params['name'])) {
                $params['name'] = $params['name_ru'];
            }
            if (empty($params['name_ua'])) {
                $params['name_ua'] = $params['name'];
            }
        }

        if (empty($params['name'])) {
            $errors[] = $this->errors->name_must_be_set;
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $bind = array(
                'name' => $params['name'],
                'name_ru' => $params['name_ru'],
                'name_ua' => $params['name_ua'],
                'order' => $this->_categories->getMaxOrder() + 1,
            );
            $this->_categories->insert($bind);
            $this->_redirect('/manager/catalog');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id)) {
            $this->_redirect('/manager/catalog/');
        }
        $item = $this->_categories->load($id);
        $this->_assign('request', $item);
        $this->_display('catalog/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $bind = array(
                'name' => $this->_request->name,
                'name_ru' => $this->_request->name_ru,
                'name_ua' => $this->_request->name_ua,
                'description' => $this->_request->description,
                'description_ru' => $this->_request->description_ru,
                'description_ua' => $this->_request->description_ua
            );
            $this->_categories->update($bind, $id);
        }
        $this->_redirect('/manager/catalog');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $this->_categories->delete($id);
        }
        $this->_redirect('/manager/catalog');
    }

    public function updateOrderAction()
    {
        $orders = $this->_request->orders;
        header('Content-Type: application/json');
        if (empty($orders)) {
            echo json_encode(array(
                'status' => false,
            ));
            return;
        }

        foreach ($orders as $index => $id) {
            $this->_categories->update(array('order' => $index), $id);
        }

        echo json_encode(array(
            'status' => true,
        ));
    }
}
