<?php
$route = new Zend_Controller_Router_Route(
    'index/view/:code',
    array(
        'controller' => 'index',
        'action'     => 'view'
    ) 
);
$router->addRoute('indexview', $route);


$delcountry = new Zend_Controller_Router_Route(
    'index/delcountry/:code',
    array(
        'controller' => 'index',
        'action'     => 'delcountry'
    ) 
);
$router->addRoute('delcountry', $delcountry);

$editcountry = new Zend_Controller_Router_Route(
    'index/editcountry/:code',
    array(
        'controller' => 'index',
        'action'     => 'editcountry'
    ) 
);
$router->addRoute('editcountry', $editcountry);

