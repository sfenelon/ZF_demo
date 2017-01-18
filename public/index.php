<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure zend library is on include_path
if (APPLICATION_ENV == 'development') {
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(APPLICATION_PATH . '/../library'),
        get_include_path(),
    )));

    // Class loaders
    require_once '../library/Zend/Loader/AutoloaderFactory.php';
    require_once '../library/Zend/Loader/ClassMapAutoloader.php';

} elseif (APPLICATION_ENV == 'production') {

    $zendLibPath = zend_deployment_library_path('Zend Framework 1', '1.12.11');

    set_include_path(implode(PATH_SEPARATOR, array(
        realpath($zendLibPath),
        get_include_path(),
    )));

    require_once $zendLibPath .'/Zend/Loader/AutoloaderFactory.php';
    require_once $zendLibPath . '/Zend/Loader/ClassMapAutoloader.php';
}

Zend_Loader_AutoloaderFactory::factory(
    array(
        'Zend_Loader_StandardAutoloader' => array(
            'namespaces' => array(
                'My' => APPLICATION_PATH . '/../library/My'
            ),
            'fallback_autoloader' => true
        )
    )
);

// start session
Zend_Session::start();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
            ->run();
