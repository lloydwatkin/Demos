<?php
/**
 * Test cases for the 'Results' DTO 
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage results
 */

/**
 * Test cases for the 'Results' DTO
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage results
 */
class Pay_Dto_ResultsTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * Holds the results object
     * 
     * @var Pay_Dto_Results
     */
    private $results;


    /**
     * Prepares the environment before running a test.
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->results = new Pay_Dto_Results();
    }

    /**
     * Cleans up the environment after running a test.
     * 
     * @return void
     */
    protected function tearDown()
    {
        $this->results = null;
        parent::tearDown();
    }

    /**
     * Test passing anything but an array to add() method throws PHP Error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notArrayProvider
     * @param mixed $var
     */
    public function testPassingNotArrayToAddThrowsError($var)
    {
        $this->results->add($var);
    }

    /**
     * Passing an empty array to add() method throws exception
     * 
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testPassingEmptyArrayToAddThrowsException()
    {
        $this->results->add(array());
    }

    /**
     * Can add a result array to Result object and retrieve
     * 
     * @return void
     */
    public function testCanAddResultAndRetrieve()
    {
        $expected = array('this', 'could', 'be', 'a', 'result');
        $this->results->add($expected);
        $this->assertSame($expected, $this->results->current());
    }

    /**
     * Test that add() method returns $this
     * 
     * @return void
     */
    public function testAddMethodReturnsInstanceOfSelf()
    {
    	$this->assertTrue(
    	    $this->results->add(array('result')) instanceof Pay_Dto_Results
    	);
    }

    /**
     * Tests the countable aspect of the object
     * 
     * @return void
     */
    public function testCanCallCountOnResults()
    {
        $this->results->add(array('a', 'result'))
            ->add(array('another', 'result'))
            ->add(array('yet', 'another', 'result'));
        
        $this->assertEquals(3, count($this->results));
    }

    /**
     * Test can add results and looping over gives correct count
     * 
     * @return void
     */
    public function testAddResultsAndCountViaForeachReturnsCorrectCount()
    {
        $numberOfResultsToAdd = 5;
        for ($i = 0; $i < $numberOfResultsToAdd; $i++) {
            $this->results->add(array('a', 'potential', 'result'));
        }
        $count = 0;
        foreach ($this->results AS $result) {
            ++$count;
        }
        $this->assertEquals($numberOfResultsToAdd, $count);
    }

    /**
     * Tests rewind function works as expected
     * 
     * @return void
     */
    public function testRewindMethodWorksAsExcepted()
    {
    	$firstEntry = array('my', 'first', 'result');
    	$this->results->add($firstEntry)
    	    ->add(array('my', 'second', 'result'))
    	    ->add(array('my', 'third', 'result')); 

        $this->results->rewind();

        $this->assertEquals($firstEntry, $this->results->current());
    }

    /**
     * Test that the next function does what is expected
     * 
     * @return void
     */
    public function testNextMethodWorksAsExpected()
    {
    	$thirdEntry = array('my', 'third', 'result');  	
        $this->results->add(array('my', 'first', 'result'))
            ->add(array('my', 'second', 'result'))
            ->add($thirdEntry);     

        $this->results->next();
        $this->results->next();
        
        $this->assertEquals($thirdEntry, $this->results->current());
    }

    /**
     * Tests non-existent result returns invalid
     */
    public function testNonExistingResultIsInvalid()
    {
        $this->results->next();
        $this->assertFalse($this->results->valid());
    }

    /**
     * Test that the current key can be retrieved ok
     * 
     * @return void
     */
    public function testCanRetrieveResultKey()
    {
        $this->results->add(array('my', 'first', 'result'))
            ->add(array('my', 'second', 'result'))
            ->add(array('my', 'third', 'result')); 

        $this->assertTrue(is_int($this->results->key()));
        $this->assertEquals(0, $this->results->key());
        // Check the next key
        $this->results->next();
        $this->assertEquals(1, $this->results->key());
    }

    // ------------------- Data providers from here ------------------- 

    /**
     * Provides 'not arrays'
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
        return Providers::notArrayProvider();
    }
}
