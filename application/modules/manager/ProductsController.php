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

    public function indexAction()
    {
        $this->_assign('products', $this->_products->getAll($this->_lang->getCurrentCode()));
        $this->_assign('tab', 'index');
        $this->_display('products/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('categories', $this->_categories->getAll());
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('products/edit.tpl');
    }

    public function saveAction()
    {
        $langs = $this->_lang->getAll();
        $category_id = (int) $this->_request->category_id;

        if ($category_id == 0) {
            $errors = $this->errors->products->no_category;
        }

        $bind = array(
            'category_id' => $category_id
        );

        if ($_FILES['image']) {
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $uploader->addValidator('IsImage', true);
            $fileName = $uploader->getFileName(null, false);
            $newImageName = md5($fileName);
            $type = explode('.', $fileName);
            $type = strtolower(array_pop($type));

            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $newImageName . '.' . $type,
                'overwrite' => true)
            );

            $image = $uploader->receive();
            if ($image) {
                $fileName = $uploader->getFileName(null, false);

                if ($this->_request->id) {
                    $product = $this->_products->load($this->_request->id);
                    if ($fileName != $product->image) {
                        $this->deleteImage($product->image);
                    }
                }

                $bind['image'] = $fileName;
            }
        }

        if ($errors) {
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            if ($this->_request->id) {
                $id = (int) $this->_request->id;
                if (!$id) {
                    $this->_redirect('/manager/products');
                }
                $this->_products->update($bind, $id);
            } else {
                $id = $this->_products->insert($bind);
            }

            $this->_products->deleteInfo($id);

            foreach ($langs as $lang) {

                $title = (isset($this->_request->title[$lang->id])) ? $this->_request->title[$lang->id] : '';
                $title = trim(strip_tags($title));

                $description = (isset($this->_request->description[$lang->id])) ? $this->_request->description[$lang->id] : '';
                $description = trim(strip_tags($description));
                $description = stripslashes($description);
                $description = preg_replace('/width=\"\d+\"/i', "", $description);
                $description = preg_replace('/height=\"\d+\"/i', "", $description);

                $meta = (isset($this->_request->meta[$lang->id])) ? $this->_request->meta[$lang->id] : '';
                $meta = trim(strip_tags($meta));

                $keywords = (isset($this->_request->keywords[$lang->id])) ? $this->_request->keywords[$lang->id] : '';
                $keywords = trim(strip_tags($keywords));

                $bind = array(
                    'product_id' => $id,
                    'lang' => $lang->id,
                    'title' => $title,
                    'description' => $description,
                    'meta' => $meta,
                    'keywords' => $keywords
                );

                $this->_products->insertInfo($bind);
            }

            $this->_redirect('/manager/products');
        }
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

        foreach ($infos as $info) {
            $item->title[$info->lang] = $info->title;
            $item->description[$info->lang] = $info->description;
            $item->meta[$info->lang] = $info->meta;
            $item->keywords[$info->lang] = $info->keywords;
        }

        $this->_assign('categories', $categories);
        $this->_assign('request', $item);
        $this->_display('products/edit.tpl');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $product = $this->_products->load($id);
            $this->deleteImage($product->image);
            $this->_products->deleteInfo($id);
            $this->_products->delete($id);
        }
        $this->_redirect('/manager/products');
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

}
