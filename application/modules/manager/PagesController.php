<?php

class Manager_PagesController extends Eve_Controller_AdminAction
{

    /**
     * @var Pages
     */
    protected $_pages;
    protected $allowedRoles = array(
        'admins',
        'editors'
    );
    /**
     * @var Eve_Model_Category
     */
    protected $_category;
    protected $_dir_images = Eve_Enum_Paths::PAGES_CATEGORIES_ICONS;

    public function init()
    {
        parent::init();

        $this->_pages = new Pages();
        $this->_category = new Eve_Model_Category();
        $this->_category->setTable(Eve_Enum_Tables::PAGES_CATEGORY);

        $this->_dir_images = $this->_dir_images;

        $this->_assign('js', array(
            'manage/categories'
        ));
    }

    public function indexAction()
    {

        $pages = $this->_pages->getAll($this->_lang->getCurrentCode());

        $this->_assign('tab', 'index');
        $this->_assign('pages', $pages);
        $this->_display('pages/index.tpl');
    }

    public function viewAction()
    {
        $id = (int) $this->_request->id;

        if ((!$id))
            $this->_redirect('/manager/pages/');

        $page = $this->_pages->load($id);

        $this->_assign('page', $page);
        $this->_display('pages/view.tpl');
    }

    public function addAction()
    {
        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));

        $this->_assign('tab', 'add');
        $this->_assign('request', $this->_request->request);
        $this->_assign('errors', $this->_request->errors);
        $this->_display('pages/add.tpl');
    }

    public function createAction()
    {
        $langs = $this->_lang->getAll();

        $link = trim(strip_tags($this->_request->link));
        if (!$link)
            $errors[] = $this->errors->pages->no_link;

        foreach ($langs as $lang) {
            $title = trim(strip_tags($this->_request->title[$lang->id]));
            $body = trim($this->_request->body[$lang->id]);
            $description = trim(strip_tags($this->_request->description[$lang->id]));
            $keywords = trim(strip_tags($this->_request->keywords[$lang->id]));

            if (!$title)
                $errors[] = $this->errors->pages->no_title;

            if (!$body)
                $errors[] = $this->errors->pages->no_body;

            if (!$description)
                $errors[] = $this->errors->pages->no_description;
            if (!$keywords)
                $errors[] = $this->errors->pages->no_keywords;

            $bind[] = array(
                'body' => $body,
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
                'lang' => $lang->id
            );
        }


        if ($errors) {
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('add');
        } else {
            $id = $this->_pages->insert(array(
                        'user_id' => Auth::getAuthInfo()->user_id,
                        'link' => $link,
                        'date_posted' => new Zend_Db_Expr('NOW()')
                    ));

            $this->_pages->deleteInfo($id);
            foreach ($bind as $data) {
                $data['page_id'] = $id;
                $this->_pages->insertInfo($data);
            }

            $this->_redirect('manager/pages/view/id/' . $id);
        }
    }

    public function editAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/pages/');

        $this->_assign('js', array(
            'libs/tiny_mce/tiny_mce',
            'tiny_mce_init'
        ));

        $item = $this->_pages->load($id);
        $item->title = array();
        $item->description = array();
        $item->body = array();
        $item->keywords = array();

        $curLang = $this->_lang->getCurrentCode();
        $infos = $this->_pages->getAllInfo($id);

        foreach ($infos as $info) {
            $item->title[$info->lang] = $info->title;
            $item->description[$info->lang] = $info->description;
            $item->body[$info->lang] = $info->body;
            $item->keywords[$info->lang] = $info->keywords;
        }

        $this->_assign('errors', $this->_request->errors);
        $this->_assign('request', $item);
        $this->_display('pages/edit.tpl');
    }

    public function updateAction()
    {
        $id = (int) $this->_request->id;
        if (!$id)
            $this->_redirect('/manager/pages/');

        $langs = $this->_lang->getAll();

        $link = trim(strip_tags($this->_request->link));
        if (!$link)
            $errors[] = $this->errors->pages->no_link;

        foreach ($langs as $lang) {
            $title = trim(strip_tags($this->_request->title[$lang->id]));
            $body = trim($this->_request->body[$lang->id]);
            $description = trim(strip_tags($this->_request->description[$lang->id]));
            $keywords = trim(strip_tags($this->_request->keywords[$lang->id]));

            if (!$title)
                $errors[] = $this->errors->pages->no_title;

            if (!$body)
                $errors[] = $this->errors->pages->no_body;

            if (!$description)
                $errors[] = $this->errors->pages->no_description;
            if (!$keywords)
                $errors[] = $this->errors->pages->no_keywords;

            $bind[] = array(
                'body' => $body,
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
                'lang' => $lang->id
            );
        }

        if ($errors) {
            $this->_request->setParam('errors', $errors);
            $this->_request->setParam('request', $this->_request);
            $this->_forward('edit');
        } else {
            $this->_pages->update(array(
                        'user_id' => Auth::getAuthInfo()->user_id,
                        'link' => $link,
                        'date_posted' => new Zend_Db_Expr('NOW()')
                    ), $id);

            $this->_pages->deleteInfo($id);
            foreach ($bind as $data) {
                $data['page_id'] = $id;
                $this->_pages->insertInfo($data);
            }

            $this->_redirect('manager/pages/view/id/' . $id);
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->_request->id;
        if (!$id)
            $this->_redirect('/manager/pages/');

        $this->_pages->delete($id);
        $this->_pages->deleteInfo($id);
        $this->_redirect('/manager/pages/');
    }

    public function categoriesAction()
    {
        $categories = $this->_category->getTree(0);

        $this->_assign('tab', 'category');
        $this->_assign('categories', $categories);
        $this->_display('pages/categories.tpl');
    }

    public function categoryEditAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/pages/categories/');

        $category = $this->_category->load($id);
        $category->parent = $this->_category->load($category->parent_id);

        $categories = $this->_category->getParents();
        $allCategories = $this->_category->getAll();

        $this->_assign('tab', 'category');
        $this->_assign('category', $category);
        $this->_assign('all_categories', $allCategories);
        $this->_assign('categories', $categories);
        $this->_display('pages/edit-category.tpl');
    }

    public function categoryUpdateAction()
    {
        $id = (int) $this->_request->id;
        $name = trim($this->_request->name);
        $category = $this->_category->load($id);

        if (!$id || empty($name))
            $this->_redirect('/manager/pages/categories/');

        $bind = array(
            'name' => $name,
            'description' => $this->_request->description,
            'parent_id' => (int) $this->_request->parent_id
        );

        if ($_FILES['icon']) {
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $uploader->addValidator('IsImage', true);
            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $this->_makeName($uploader->getFileName(null, false)),
                'overwrite' => true
            ));
            $icon = $uploader->receive();

            if ($icon) {
                $icon = $uploader->getFileName(null, false);
                Eve_Image::resample($this->_dir_images . $icon, $this->_dir_images . $icon, 64, 64);
                $bind['icon'] = $icon;

                if (file_exists($this->_dir_images . $category->icon))
                    unlink($this->_dir_images . $category->icon);
            }
        }

        $this->_category->update($bind, $id);

        $this->_redirect('/manager/pages/categories/');
    }

    public function categoryAddAction()
    {
        $allCategories = $this->_category->getAll();

        $this->_assign('tab', 'category');
        $this->_assign('all_categories', $allCategories);
        $this->_display('pages/add-category.tpl');
    }

    public function categoryCreateAction()
    {
        $name = trim($this->_request->name);
        $alias = trim($this->_request->translit);

        if (empty($name))
            $this->_redirect('/manager/pages/categories/');

        $bind = array(
            'name' => $name,
            'parent_id' => (int) $this->_request->parent_id
        );

        if ($_FILES['icon']) {
            $uploader = new Zend_File_Transfer_Adapter_Http();
            $uploader->setDestination($this->_dir_images);
            $uploader->addValidator('IsImage', true);
            $uploader->addFilter('Rename', array(
                'target' => $this->_dir_images . $this->_makeName($uploader->getFileName(null, false)),
                'overwrite' => true
            ));
            $icon = $uploader->receive();

            if ($icon) {
                $icon = $uploader->getFileName(null, false);
                Eve_Image::resample($this->_dir_images . $icon, $this->_dir_images . $icon, 64, 64);
                $bind['icon'] = $icon;
            }
        }

        $this->_category->insert($bind);

        $this->_redirect('/manager/pages/categories/');
    }

    public function categoryDeleteAction()
    {
        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/pages/categories/');

        $children = $this->_category->getChildren($id);
        $category = $this->_category->load($id);

        $ids = array();
        $ids[] = $id;

        foreach ($children as $child) {
            $ids[] = $child->category_id;

            if (file_exists($this->_dir_images . $child->image))
                unlink($this->_dir_images . $child->image);
        }

        $pages = $this->_pages->fetchPagesByCategories($ids, array(
                    'publication_id'
                ));

        // get ids of pages that are in categories
        $pageIds = array();
        foreach ($pages as $page) {
            $pageIds[] = $page->publication_id;
        }

        // delete all child categories
        $this->_category->deleteChilds($id);

        // delete all related pages
        if (!empty($pageIds))
            $this->_pages->deleteMatchedPages($pageIds);

        // delete requested category
        $this->_category->delete($id);

        if (file_exists($this->_dir_images . $category->image))
            unlink($this->_dir_images . $category->image);


        $this->_redirect('/manager/pages/categories/');
    }

    public function categoryRemoveIconAction()
    {

        $id = (int) $this->_request->id;

        if (!$id)
            $this->_redirect('/manager/pages/categories/');

        $category = $this->_category->load($this->_request->id);

        if (file_exists($this->_dir_images . $category->icon))
            unlink($this->_dir_images . $category->icon);

        $this->_category->update(array(
            'icon' => ''
                ), $id);

        $this->_redirect('/manager/pages/category-edit/id/' . $id);
    }

}