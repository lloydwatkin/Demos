<?php
/**
 * Tests for the grid console writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 */

/**
 * @namespace
 */
namespace Grid\Display;

use Grid\Display\Console as Console;

class ConsoleTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Stores an instance of the console drawer
     * 
     * @var \Grid\Display\Console
     */
    protected $_renderer;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->_renderer = new Console();
    }

    /**
     * Test passing a 1x1 inactive grid returns expected result
     */
    public function testPassingOneByOneInactiveGridReturnsExpectedResult()
    {
        $response = $this->_renderer->draw(array(array(false)));
        $expected = Console::INACTIVE . PHP_EOL;
        $this->assertSame($expected, $response);
    }

    /**
     * Test a multiline grid is drawn as expected
     */
    public function testMultiLineGridIsDrawnAsExpected()
    {
        $response = $this->_renderer->draw(array(array(false, true, false), array(true, false, true)));
        $expected = Console::INACTIVE . Console::ACTIVE . Console::INACTIVE 
            . PHP_EOL . Console::ACTIVE . Console::INACTIVE 
            . Console::ACTIVE . PHP_EOL;
        $this->assertSame($expected, $response);
    }

    /**
     * Test that an invalid grid value throws exception
     * 
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage Non-boolean grid value
     */
    public function testInvalidGridValueThrowsException()
    {
        $this->_renderer->draw(array(array(1)));
    }
}