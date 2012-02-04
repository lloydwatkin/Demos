<?php
/**
 * Tests for the grid generator
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 */

/**
 * @namespace
 */
namespace Grid\Generator; 

use \Grid\Generator as Generator;

class GeneratorTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Stores an instance of the grid generator
     *
     * @var \Grid\Generator
     */
    protected $_gridGenerator;

    /**
     * Setup function - includes function str_replace_ignore_tags
     */
    public function setup()
    {
        $this->_gridGenerator = new Generator();
        srand(20);
    }

    /**
     * Unseed the random number generator
     */
    public function tearDown()
    {
        srand();
    }

    /**
     * Passing an invalid width into setSize throws exception
     * 
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Width should be a positive integer value
     * @param                    mixed $invalidArgument
     * @dataProvider             notPositiveIntegerProvider
     */
    public function testPassingInvalidWidthToSetSizeThrowsException($invalidArgument)
    {
        $this->_gridGenerator->setSize($invalidArgument, 1);
    }

    /**
     * Passing an invalid height into setSize throws exception
     * 
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Height should be a positive integer value
     * @param                    mixed $invalidArgument
     * @dataProvider             notPositiveIntegerProvider
     */
    public function testPassingInvalidHeightToSetSizeThrowsException($invalidArgument)
    {
        $this->_gridGenerator->setSize(1, $invalidArgument);
    }

    /**
     * Test that setting a valid height/width returns instance of self
     */
    public function testSettingValidGridSizeRetunsInstanceOfItself()
    {
        $response = $this->_gridGenerator->setSize(1, 1);
        $this->assertSame($this->_gridGenerator, $response);
    }

    /**
     * Attempt to generator grid without setting a size throws exception
     * 
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage Grid size must be set before generation
     */
    public function testAttemptingToGenerateGridWithoutSettingSizeThrowsException()
    {
        $this->_gridGenerator->generate();
    }

    /**
     * Test that generating a 1x1 grid returns as expected
     */
    public function testCanGenerateAOneByOneGrid()
    {
        $this->assertSame(
            array(array(false)),
            $this->_gridGenerator->setSize(1, 1)->generate()
        );
    }

    /**
     * Test that generating a 3 x 2 grid returns as expected
     */
    public function testCanGenerateAThreeByTwoGrid()
    {
        $this->assertSame(
            array(
                array(false, false, false),
                array(false, false, false),
            ),
            $this->_gridGenerator->setSize(3, 2)->generate()
        );
    }

    /**
     * Test that attempting to set an invalid probability for active blocks 
     * throws exception
     * 
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Probabilities should be between 0 and 1
     * @dataProvider             invalidProbabilityProvider
     * @param                    mixed $invalidProbability
     */
    public function testCanNotSetAnInvalidProbability($invalidProbability)
    {
        $this->_gridGenerator->setProbability($invalidProbability);
    }

    /**
     * Test that setting a valid probability returns instance of self
     */
    public function testSettingValidProbabilityRetunsInstanceOfItself()
    {
        $response = $this->_gridGenerator->setProbability(1.0);
        $this->assertSame($this->_gridGenerator, $response);
    }

    /**
     * Test that generating a 3 x 2 grid with a probability of 1 returns as expected
     */
    public function testGeneratingAThreeByTwoGridWithProbabilityOfOneReturnsExpectedGrid()
    {
        $this->assertSame(
            array(
                array(true, true, true),
                array(true, true, true),
            ),
            $this->_gridGenerator->setSize(3, 2)->setProbability(1.0)->generate()
        );
    }

    /**
     * Generating a large grid returns expected result of fraction of active cells
     * 
     * Generating 1,000 cells and as we are seeding random number generator we 
     * can be confident that results are as expected
     * 
     * @dataProvider  probabilityAndResultProvider
     * @param         double $probabilityRequested
     * @param         double $expectedResult
     */
    public function testSomething($probabilityRequested, $expectedResult)
    {
        $grid        = $this->_gridGenerator
            ->setSize(1, 1000)
            ->setProbability($probabilityRequested)
            ->generate();
        $activeCells = $this->_countActiveCells($grid);
        $this->assertEquals($expectedResult, $activeCells);
    }

    /*********************** Test helpers from here ***************************/

    /**
     * Provider of not a positive integer
     * 
     * @return array
     */
    public static function notPositiveIntegerProvider()
    {
        return array(
            array(-1),
            array(0),
            array(true),
            array(new \stdClass()),
            array(NULL),
            array(1.2),
            array('1'),
            array(array(1)),
        );
    }

    /**
     * Provider of invalid probabilities
     * 
     * @return array
     */
    public static function invalidProbabilityProvider()
    {
        return array(
            array(1.00001),
            array(1),
            array(0),
            array(-0.0000001),
            array(true),
            array(NULL),
            array(new \stdClass()),
            array(array()),
            array('0.999'),
        );
    }

    /**
     * Count number of active cells in grid
     * 
     * @param  array $grid
     * @return double
     */
    protected function _countActiveCells(array $grid)
    {
        $totalCells  = 0;
        $activeCells = 0;
        $reduce      = function($currentValue, $elementValue) {
            return $currentValue + (int) $elementValue;
        };
        foreach ($grid as $row) {
            $totalCells  += count($row);
            $activeCells += array_reduce($row, $reduce, 0);
        }
        return $activeCells / $totalCells;
    }

    /**
     * Probability and result generator
     * 
     * @return array
     */
    public static function probabilityAndResultProvider()
    {
        return array(
            array(0.5001, 0.480),
            array(0.6001, 0.592),
            array(0.1001, 0.090),
            array(0.9999, 1.000),
        );
    }
}