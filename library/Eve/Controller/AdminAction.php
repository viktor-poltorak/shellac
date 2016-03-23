<?php

/**
 * 	Extender class for admin pages
 *
 * @author Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @version 0.2
 * @copyright  Copyright (c) 2009 Alex Oleshkevich
 * @package Eve
 * @license  GPLv3
 */
class Eve_Controller_AdminAction extends Eve_Controller_Action
{
    /*
     * roles model
     * @var Eve_Model_Role
     */

    public $_role;

    public function init()
    {
        parent::init();

        $this->_templater->setOption('template_dir', 'application/views/manager/');

        if (!Auth::isLogged()) {
            $this->_redirect('/404-not-found/');
        }

        $this->_role = new Eve_Model_Role();

        if (!Auth::getAuthInfo()->role_id) {
            $this->_redirect('/404-not-found/');
            exit;
        }
    }

    /**
     * is you has enough permissions to access this controller
     * @param array $permissions conntrollers permissions
     * @return bool
     */
    public function isAllowed($permissions)
    {
        $userRoles = $this->_role->getUserRoles(Auth::getAuthInfo()->user_id);

        foreach ($userRoles as $role) {
            $roles[] = $role->role_name;
        }

        $collisions = array_intersect((array) $roles, (array) $permissions);

        if ($collisions) {
            return true;
        } else {
            return false;
        }
    }

    public function getControllerPermissions($controller)
    {
        return $this->_role->getControllerPermissions($controller);
    }

    public function getJson($data)
    {
        return json_encode($data);
    }

}
