<?php
/**
 * Blocks sample code runner
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since  02/02/2012
 */

if (('cli' == php_sapi_name()) && (false === isset($argv[1]))) {
    echo 'ERROR: Please specify an output file name' . PHP_EOL;
    exit(1);
}
if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', __DIR__);
}

include APPLICATION_PATH . '/src/Grid/Generator.php';
include APPLICATION_PATH . '/src/Grid/Display/HtmlTable.php';
include APPLICATION_PATH . '/src/Block/Counter.php';

use Grid\Generator as Generator;
use Grid\Display\HtmlTable as HtmlTable;
use Block\Counter as Counter;

$startTime = microtime(true);

// Generate a grid
$rows        = 50;
$columns     = 50;
$probability = 0.4;
$generator   = new Generator();
$grid        = $generator->setSize($rows, $columns)
    ->setProbability($probability)
    ->generate();

ob_start();
echo "<h1>Block counter</h1>";
echo "<p>Generating a grid of size {$rows} x {$columns} with probability {$probability}</p>";

// Draw the grid out
$renderer  = new HtmlTable();
echo $renderer->draw($grid);

// Count number of blocks
$counter = new Counter($grid);
$blocks  = $counter->count();
echo "<p>There are {$blocks} blocks within this grid</p>" . PHP_EOL;

$endTime = microtime(true);
$timeTaken = number_format($endTime - $startTime, 5);
echo "<p>Generation time {$timeTaken} seconds</p>";
$content = ob_get_clean();

if (!$fp = fopen($argv[1], 'a+')) {
    echo "ERROR: Can not open {$argv[1]} for writing" . PHP_EOL;
    exit(1);
}
fwrite($fp, $content);
fclose($fp);