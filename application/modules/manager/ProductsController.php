<?php

class Manager_ProductsController extends Eve_Controller_AdminAction
{

    /**
     *
     * @var Products
     */
    protected $_products;
    protected $allowedRoles = array(
        'admins'
    );

    /**
     *
     * @var Categories
     */
    protected $_categories;
    protected $_dir_images = 'images/products/';

    public function init()
    {
        parent::init();
        $this->_products = new Products();
        $this->_categories = new Categories();
        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));
    }

    public function listAction()
    {
        $categoryId = $this->_request->id;
        $category = $this->_categories->load($categoryId);
        $this->_assign('category', $category);

        $maxOrder = $this->_products->getMaxOrder($categoryId);
        if (empty($maxOrder)) {
            $this->_products->updateOrder($categoryId);
        }

        $this->_request->setParam('category_id', $categoryId);
        $this->_assign('request', $this->_request);
        $this->_assign('category_id', $categoryId);
        $this->_assign('products', $this->_products->getAll($this->_lang->getCurrentCode(), 'all', $categoryId));
        $this->_assign('tab', 'index');
        $this->_display('products/index.tpl');
    }

    public function indexAction()
    {
        $this->_assign('products', $this->_products->getAll($this->_lang->getCurrentCode()));
        $this->_assign('tab', 'index');
        $this->_display('products/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('category_id', $this->_request->category_id);
        $this->_assign('categories', $this->_categories->getAll());
        $this->_assign('request', $this->_request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('products/edit.tpl');
    }

    public function saveAction()
    {
        $langs = $this->_lang->getAll();
        $categoryId = (int) $this->_request->category_id;
        $errors = array();
        if ($categoryId == 0) {
            $errors = $this->errors->products->no_category;
        }

        $bind = array(
            'category_id' => $categoryId,
            'price' => $this->_request->price,
        );

        $image = $this->processImage('image');
        if ($image) {
            $bind['image'] = $image;
        }
        $image = $this->processImage('image_1');
        if ($image) {
            $bind['image_1'] = $image;
        }
        $image = $this->processImage('image_2');
        if ($image) {
            $bind['image_2'] = $image;
        }

        if ($errors) {
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            return $this->_forward('add');
        }

        if ($this->_request->id) {
            $id = (int) $this->_request->id;
            if (!$id) {
                $this->_redirect('/manager/products/id/' . $categoryId);
            }
            $this->_products->update($bind, $id);
        } else {
            $bind['order'] = $this->_products->getMaxOrder($categoryId) + 1;
            $id = $this->_products->insert($bind);
            $this->_request->setParam('id', $id);
        }

        $this->_products->deleteInfo($id);

        foreach ($langs as $lang) {
            $title = (isset($this->_request->title[$lang->id])) ? $this->_request->title[$lang->id] : '';
            $title = trim(strip_tags($title));

            $description = (isset($this->_request->description[$lang->id])) ? $this->_request->description[$lang->id] : '';
            $description = trim($description);
            $description = strip_tags($description);

            $fullDescription = (isset($this->_request->full_description[$lang->id])) ? $this->_request->full_description[$lang->id] : '';
            $fullDescription = trim($fullDescription);
            $fullDescription = stripslashes($fullDescription);

            $meta = (isset($this->_request->meta[$lang->id])) ? $this->_request->meta[$lang->id] : '';
            $meta = trim(strip_tags($meta));

            $keywords = (isset($this->_request->keywords[$lang->id])) ? $this->_request->keywords[$lang->id] : '';
            $keywords = trim(strip_tags($keywords));

            $bind = array(
                'product_id' => $id,
                'lang' => $lang->id,
                'title' => $title,
                'description' => $description,
                'full_description' => $fullDescription,
                'meta' => $meta,
                'keywords' => $keywords
            );

            $this->_products->insertInfo($bind);
        }

        $this->_redirect('/manager/products/edit/id/' . $this->_request->id);
    }

    public function processImage($name)
    {
        if (!empty($_FILES[$name]) && !empty($_FILES[$name]['tmp_name'])) {
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            // $uploader->addValidator('IsImage', true);
            $fileName = $uploader->getFileName($name, false);
            $newImageName = uniqid();
            $type = explode('.', $fileName);
            $type = strtolower(array_pop($type));

            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $newImageName . '.' . $type,
                'overwrite' => true)
            );

            $image = $uploader->receive($name);

            if ($image) {
                $fileName = $uploader->getFileName($name, false);

                if ($this->_request->id) {
                    $product = $this->_products->load($this->_request->id);
                    if ($fileName != $product->{$name}) {
                        $this->deleteImage($product->{$name});
                    }
                }

                return $fileName;
            }
        }
        return false;
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id)) {
            $this->_redirect('/manager/products/');
        }
        $item = $this->_products->load($id);

        $categories = $this->_categories->getAll();
        $curLang = $this->_lang->getCurrentCode();
        foreach ($categories as &$cat) {
            if ($curLang != 'en') {
                $name = 'name_' . $curLang;
                $cat->name = $cat->$name;
            }
        }

        $infos = $this->_products->getAllInfo($id);

        $item->title = array();
        $item->description = array();
        $item->meta = array();
        $item->keywords = array();
        $item->full_description = array();

        foreach ($infos as $info) {
            $item->title[$info->lang] = $info->title;
            $item->description[$info->lang] = strip_tags($info->description);
            $item->full_description[$info->lang] = $info->full_description;
            $item->meta[$info->lang] = $info->meta;
            $item->keywords[$info->lang] = $info->keywords;
        }

        $this->_assign('category_id', $item->category_id);
        $this->_assign('categories', $categories);
        $this->_assign('request', $item);
        $this->_display('products/edit.tpl');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $product = $this->_products->load($id);
            $catId = $product->category_id;
            $this->deleteImage($product->image);
            $this->_products->deleteInfo($id);
            $this->_products->delete($id);
            $this->_redirect('/manager/products/list/id/' . $catId);
        }
        $this->_redirect('/404');
    }

    protected function deleteImage($image)
    {
        if ($image == '') {
            return;
        }
        $image1 = $this->_dir_images . $image;
        $image2 = $this->_dir_images . 'small_' . $image;
        if (file_exists($image1)) {
            unlink($image1);
        }
        if (file_exists($image2)) {
            unlink($image2);
        }
    }

    public function updateOrderAction()
    {
        $orders = $this->_request->orders;

        if (empty($orders)) {
            echo json_encode(array(
                'status' => false,
            ));
            return;
        }

        foreach ($orders as $index => $id) {
            $this->_products->update(array('order' => $index), $id);
        }

        echo json_encode(array(
            'status' => true,
        ));
    }

}
