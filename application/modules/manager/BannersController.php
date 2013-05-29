<?php

class Manager_BannersController extends Eve_Controller_AdminAction
{

    protected $_banners;
    protected $allowedRoles = array(
        'admins'
    );
    protected $_dir_images = 'images/banners/';

    public function init()
    {
        parent::init();
        $this->_banners = new Banners();
    }

    public function indexAction()
    {
        $banners = $this->_banners->getAll($this->_lang->getCurrentCode());
           
        $this->_assign('banners', $banners);

        $this->_assign('tab', 'index');
        $this->_display('banners/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('banners/edit.tpl');
    }

    public function saveAction()
    {
        $langs = $this->_lang->getAll();

        if ($_FILES['image'] && $_FILES['image']['name'] != 'name') {
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

                Eve_Image::resize($this->_dir_images . $fileName, 138, 78, $this->_dir_images . $fileName, false);

                if ($this->_request->id) {
                    $banner = $this->_banners->load($this->_request->id);
                    if ($fileName != $banner->image) {
                        $this->deleteImage($banner->image);
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
                if (!$id)
                    $this->_redirect('/manager/banners');
                if(isset($bind)){
                    $this->_banners->update($bind, $id);
                }
            } else {
                $id = $this->_banners->insert($bind);
            }

            $this->_banners->deleteInfo($id);

            foreach ($langs as $lang) {

                $title = (isset($this->_request->title[$lang->id])) ? $this->_request->title[$lang->id] : '';
                $title = trim(strip_tags($title));

                $text = (isset($this->_request->text[$lang->id])) ? $this->_request->text[$lang->id] : '';
                $text = trim(strip_tags($text));
                $text = stripslashes($text);
                $text = preg_replace('/width=\"\d+\"/i', "", $text);
                $text = preg_replace('/height=\"\d+\"/i', "", $text);

                $bind = array(
                    'id' => $id,
                    'lang' => $lang->id,
                    'title' => $title,
                    'text' => $text
                );

                $this->_banners->insertInfo($bind);
            }
            $this->_redirect('/manager/banners');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id))
            $this->_redirect('/manager/banners/');
        $item = $this->_banners->load($id);

        $curLang = $this->_lang->getCurrentCode();       

        $infos = $this->_banners->getAllInfo($id);

        $item->title = array();
        $item->text = array();

        foreach ($infos as $info) {
            $item->title[$info->lang] = $info->title;
            $item->text[$info->lang] = $info->text;
        }

        $this->_assign('request', $item);
        $this->_display('banners/edit.tpl');

    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if ($id) {
            $banner = $this->_banners->load($id);
            $this->deleteImage($banner->image);
            $this->_banners->delete($id);
            $this->_banners->deleteInfo($id);
        }
        $this->_redirect('/manager/banners');
    }

    protected function deleteImage($image)
    {
        if ($image == '')
            return;
        $image1 = $this->_dir_images . $image;
        if (file_exists($image1)) {
            unlink($image1);
        }
    }

}