<?php
set_include_path(
    implode(
        PATH_SEPARATOR, array(
            '/library/ZendFramework-Trunk/library/',
            get_include_path(),
        )
    )
);
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Zend');

define('APP_PATH', dirname(__FILE__). '/..');
ob_start();

// Create a Zend_View instance
Zend_Layout::startMvc();
$layout = Zend_Layout::getMvcInstance();
$layout->setLayoutPath(APP_PATH . '/layout/scripts')
    ->setViewSuffix('phtml')
    ->setLayout('index');
    
$view = $layout->getView()
    ->setScriptPath(APP_PATH . '/view/scripts')
    ->addHelperPath(APP_PATH . '/library/Zend/View/Helper', 'Zend_View_Helper');

// Set Base URL - ok *almost* naked, but you don't need this!
Zend_Controller_Front::getInstance()->setBaseUrl($_SERVER['HTTP_HOST']);

try {
    /**
     * Perform some application routing...
     *  - Could be using this as a front controller and directing all requests
     *    through this one file (provided file does not exist in file system
     *  - Note the method below is only really for demonstration, it would be 
     *    horrible with a large site
     */
    switch ($_GET['page']) {
    	case 'index':
    	case 'exception':
    		$pageName = $_GET['page'];
    		break;
    	default:
    		$pageName = false;
    		break;
    }
    // Example of a page not being found...
    if (false === $pageName) {
        $responseHeader = 'HTTP/1.1 404 Page Not Found';
        throw new Exception('Page not Found');
    }

    /**
     * Add data to your view object here
     *   You may have your own controller implementation or some includes files
     *   where business logic is partly separated from view logic
     */
    $view->displayText = 'Hello from Lloyd';
    $view->buttonText  = 'I\'m not active!';

	$layout->content = $view->render("{$pageName}.phtml");
    echo $layout->render();
} catch (Exception $e) {
	// Clean out already buffered content - we don't want to display that!
	ob_clean();
    if (!isset($responseHeader)) {
    	$responseHeader = 'HTTP/1.1 500 Internal Server Error';
    }
    header($responseHeader);
    $view->exception = $e;
    $layout->content = $view->render('error.phtml');
    echo $layout->render();
}