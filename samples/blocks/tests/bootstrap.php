<?php
if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', dirname(__DIR__ . '/../../'));
}

include APPLICATION_PATH . '/src/Grid/Generator.php';
include APPLICATION_PATH . '/src/Grid/Display.php';
include APPLICATION_PATH . '/src/Grid/Display/Console.php';
include APPLICATION_PATH . '/src/Grid/Display/HtmlTable.php';
include APPLICATION_PATH . '/src/Block/Counter.php';

error_reporting(-1);
ini_set('display_errors', true);