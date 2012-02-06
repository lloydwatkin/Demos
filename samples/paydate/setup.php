<?php
/**
 * IBuildings test application - setup script
 * 
 * See readme.html
 * 
 * @see        ../docs/readme.html
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 */
define('BASE_PATH', dirname(__FILE__));

/*
 * Set include path(s), required for this application are:
 *     - Zend Framework
 */
set_include_path(
    implode(
        PATH_SEPARATOR, array(
            BASE_PATH . '/src/',
            '/usr/lib/php',
            get_include_path(),
            '/home/lloyd/Code/PHP/library/',
        )
    )
);

require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Zend');
$autoloader->registerNamespace('Pay');
