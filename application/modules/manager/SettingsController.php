<?php

class Manager_SettingsController extends Eve_Controller_AdminAction
{

    protected $_settings;
    protected $allowedRoles = array(
        'admins'
    );
    protected $_dir_images = 'images/uploads/';

    public function init()
    {
        parent::init();

        $this->_settings = new Settings();
    }

    public function indexAction()
    {
        $this->_assign('settings', $this->_settings->getAll());
        $this->_assign('tab', 'index');
        $this->_display('settings/index.tpl');
    }

    public function addAction()
    {
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('settings/edit.tpl');
    }

    public function createItemAction()
    {
        if ($this->_request->name == '' || $this->_request->value == '') {
            $errors[] = "Не все поля заполнены";
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $bind = array(
                'name' => $this->_request->name,
                'value' => $this->_request->value,
                'lock' => $this->_request->lock
            );
            $this->_settings->insert($bind);
            $this->_redirect('/manager/settings');
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;
        if ((!$id)) {
            $this->_redirect('/manager/settings/');
        }

        $item = $this->_settings->load($id);
        if ($item->type === 'file') {
            $item->value = $this->_dir_images . $item->value;
        }
        $this->_assign('request', $item);
        $this->_display('settings/edit.tpl');
    }

    public function saveAction()
    {
        $id = (int) $this->_request->id;

        if ($id) {
            $item = $this->_settings->load($id);

            if ($item->type === 'file') {
                $value = $this->processImage('value');

                if ($value && !empty($item->value)) {
                    if (file_exists($this->_dir_images . $item->value)) {
                        unlink(file_exists($this->_dir_images . $item->value));
                    }
                }
            } else {
                $value = $this->_request->value;
            }

            $bind = array(
                'name' => $this->_request->name,
                'value' => $value,
                'lock' => $this->_request->lock
            );
            $this->_settings->update($bind, $id);
        }

        $this->_redirect('/manager/settings');
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;

        if ($id) {
            $this->_settings->delete($id);
        }

        $this->_redirect('/manager/settings');
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
                return $uploader->getFileName($name, false);
            }
        }
        return false;
    }

}
