<?php
/**
 * Counter test case
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      03/02/2012
 * @package    Block
 * @subpackage Counter
 */

/**
 * @namespace
 */
namespace Block;

use Block\Counter as Counter;

class CounterTest 
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of block counter
     * 
     * @var Block\Counter
     */
    protected $_counter;

    /**
     * Prepares the environment before running a test.
     */
    public function setUp()
    {
        $this->_counter = new Counter();
    }

    /**
     * Test that passing a valid grid to setGrid() returns instance of self
     */
    public function testProvidingValidGridReturnsInstanceOfSelf()
    {
        $response = $this->_counter->setGrid(array(array(true)));
        $this->assertSame($this->_counter, $response);
    }

    /**
     * Calling count() but not providing a grid throws exception
     * 
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage A grid has not been provided
     */
    public function testCallingCountWithoutSettingAGridThrowsException()
    {
        $this->_counter->count();
    }

    /**
     * Test that a 1x1 inactive grid returns a count of 0
     */
    public function testOneByOneGridInactiveGridReturnsCountOfZero()
    {
        $count = $this->_counter->setGrid(array(array(false)))->count();
        $this->assertSame(0, $count);
    }

    /**
     * Test that a 1x1 active grid returns a count of 1
     */
    public function testOneByOneGridActiveGridReturnsCountOfOne()
    {
        $count = $this->_counter->setGrid(array(array(true)))->count();
        $this->assertSame(1, $count);
    }

    /**
     * Test that an invalid grid value throws exception
     * 
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage Non-boolean grid value
     */
    public function testInvalidGridValueThrowsException()
    {
        $this->_counter->setGrid(array(array('moo')))->count();
    }

    /**
     * Batch tests that the number of blocks counted is correct
     * 
     * @dataProvider gridAndBlockCountProvider
     * @param        array   $grid
     * @param        integer $blockCount
     */
    public function testBlockCountCorrectForProvidedGrids(array $grid, $blockCount)
    {
        $count = $this->_counter->setGrid($grid)->count();
        $this->assertSame($blockCount, $count);
    }

    /**
     * Test that a grid can be set via constructor
     */
    public function testCanSetGridViaConstructor()
    {
        $counter = new Counter(array(array(true)));
        $count   = $counter->count();
        $this->assertSame(1, $count);
    }

    /*********************** Test helpers from here ***************************/

    /**
     * Block cound an provided grid provider
     * 
     * @return array
     */
    public static function gridAndBlockCountProvider()
    {
        return array(
            array(
                array(
                    array(true, true, true),
                ),
                1
            ),
            array(
                array(
                    array(true, false, true),
                ),
                2
            ),
            array(
                array(
                    array(true, false, true),
                    array(true, false, true),
                ),
                2
            ),
            array(
                array(
                    array(false, true, false),
                    array(true,  true, true),
                    array(false, true, false),
                ),
                1
            ),
            array(
                array(
                    array(true,  true,  true),
                    array(false, false, false),
                    array(true,  true,  true),
                ),
                2
            ),
            array(
                array(
                    array(true,  true,  true),
                    array(true,  true,  true),
                    array(true,  true,  true),
                ),
                1
            ),
            array(
                array(
                    array(true,  true,   true, false, false, true,  false),
                    array(true,  false,  true, true,  true,  false, false),
                    array(true,  true,   true, false, false, true,  true),
                ),
                3
            ),
        );
    }
}