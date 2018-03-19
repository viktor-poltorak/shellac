<?php

class Eve_Plugin_Dispatcher extends Zend_Controller_Plugin_Abstract
{

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $templater = Zend_Registry::get('templater');

        //Init languages
        //if lang get in request it set to current languages
        $params['code'] = $this->getRequest()->getParam('lang', false);

        $language = new Eve_Languages($params);
        Zend_Registry::set('Lang', $language); //It will be set before init Db classes
        $templater->assign('currentLang', $language->getCurrentCode());

        //Init translate
        $translateFile = 'application/translate/' . $language->getCurrentCode() . '.ini';
        $translate = new Zend_Translate(
                array(
            'adapter' => 'ini',
            'content' => $translateFile,
            'locale' => $language->getCurrentCode()
                )
        );
        Zend_Registry::set('translate', $translate);


        /** Assign phones * */
        $settings = new Settings();
        $templater->assign('contactPhone', $settings->getByName('phone1'));
        $templater->assign('orderPhone', $settings->getByName('orderPhone'));
        $templater->assign('keywords', $settings->getByName('keywords'));
        $templater->assign('pageTitle', $settings->getByName('title'));
        $templater->assign('description', $settings->getByName('description'));
        $templater->assign('textLogo', $settings->getByName('textLogo'));
        $templater->assign('siteText', $settings->getByName('siteText'));
        $templater->assign('leftOrange', $settings->getByName('leftOrange'));
        $templater->assign('leftBlue', $settings->getByName('leftBlue'));
        $templater->assign('textPhone', $settings->getByName('textPhone'));
        $templater->assign('settings', $settings);

        //Categories
        $categoriesModel = new Categories();
        $categories = $categoriesModel->getAll(true);
        $curLang = $language->getCurrentCode();
        foreach ($categories as &$cat) {
            if ($curLang != 'en') {
                $name = 'name_' . $curLang;
                $cat->name = $cat->$name;
            }
        }
        $templater->assign('categories', $categories);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

    }

}
