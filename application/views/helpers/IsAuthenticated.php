<?php

/**
 * Use this in the view to test for logged in user.

 * @author sheila
 *
 */
class Zend_View_Helper_isAuthenticated extends Zend_View_Helper_Abstract 
{
    public function isAuthenticated ()
    {
        $auth = Zend_Auth::getInstance();
        return $auth->hasIdentity();
    }
}
