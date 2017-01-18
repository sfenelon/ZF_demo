<?php

class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
    {
        $acl = new Zend_Acl();

        // create roles
        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('admin'), 'guest');
        
        // create resourses - one per controller
        $acl->add(new Zend_Acl_Resource('index'));
        $acl->add(new Zend_Acl_Resource('auth')); 
        $acl->add(new Zend_Acl_Resource('error'));
        $acl->add(new Zend_Acl_Resource(':index')); 
        
        
        // allow everyone access to some resources
        $acl->allow(null, array('error', 'auth'));
        // allow access to specific controller/actions; by ommission they are denied access to the rest
        $acl->allow('guest', 'index', array('index', 'view', 'about')); 
        $acl->allow('guest', ':index', null);
        
        // admin can see/do anything
        $acl->allow('admin', null);
        
        // fetch the current user
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $role = strtolower($identity->role);
        } else {
            $role = 'guest';
        }
        
        $module = $request->module;
        $controller = $request->controller;
        $action = $request->action;
        if ($module == 'default') {
            // module is not part of the resource name
            $controller_res = $controller;
        } else {
            // module name is part of resource name
            $controller_res = "$module:$controller";
        }

        if ($role != 'admin') {
            // check for authorization
            if ($acl->isAllowed($role, $controller_res, $action) == FALSE) {
                // send them to error/notauth
                $request->setModuleName('default');
                $request->setControllerName('error');
                $request->setActionName('notauth');
            }
        }
        
    }
    
}