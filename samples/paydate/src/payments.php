<?php
/**
 * Test application - runner script
 * 
 * See readme.html
 * 
 * @see        ../docs/readme.html
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 */
require_once '../setup.php';

/**
 * Test application - runner script
 * 
 * See readme.html
 * 
 * @see        ../docs/readme.html
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 */

if (!isset($argv[1]) || !preg_match('/^[A-Z\.\-]{1,}$/i', $argv[1])) {
    echo 'Invalid file name provided, please try again' . PHP_EOL;
    exit(0);
}

try {
	$calculator = new Pay_Manager();
	
	// Load payment config
	$config = parse_ini_file(BASE_PATH . '/src/configs/payments.ini', true);
    // Add the payment types to the calculator	
	foreach ($config AS $name => $type) {
	   $calculator->addType(new Pay_Payment($name, $type));
    }
    // Retrieve the results
    $results = $calculator->setDto(new Pay_Dto_Results())
        ->getDates('2010-01');

	// Setup results writer	
	$output = new Pay_Output();
	$output->addWriter(new Pay_Writer_Stream(array('filename' => $argv[1])));
	$output->setHeader(array_merge(array('Payment Date'), array_keys($config)));
	$output->process($results);

} catch (Exception $e) {
	echo PHP_EOL . "There has been an error in processing your request: " .
	    PHP_EOL . '    ' . $e->getMessage() . PHP_EOL;
	exit(0);
}
