<?php
/**
 * Blocks sample code runner
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since  02/02/2012
 */
if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', __DIR__);
}

include APPLICATION_PATH . '/src/Grid/Generator.php';
include APPLICATION_PATH . '/src/Grid/Display.php';
include APPLICATION_PATH . '/src/Grid/Display/Console.php';
include APPLICATION_PATH . '/src/Block/Counter.php';

use Grid\Generator as Generator;
use Grid\Display\Console as Console;
use Block\Counter as Counter;

// Generate a grid
$generator = new Generator();
$grid      = $generator->setSize(20, 20)->setProbability(0.45)->generate();
// Draw the grid out
$renderer  = new Console();
echo $renderer->draw($grid);

// Count number of blocks
$counter = new Counter($grid);
$blocks  = $counter->count();
echo "There are {$blocks} blocks within this grid" . PHP_EOL;
