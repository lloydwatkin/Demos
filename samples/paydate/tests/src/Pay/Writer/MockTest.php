<?php
/**
 * Test cases for the 'Mock' writer 
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage writer
 */

/**
 * Test cases for the 'Mock' writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage writer
 */
class Pay_Writer_MockTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * Holds the mock writer
     * 
     * @var Pay_Writer_Mock
     */
    private $writer;


    /**
     * Prepares the environment before running a test.
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->writer = new Pay_Writer_Mock();
    }

    /**
     * Cleans up the environment after running a test.
     * 
     * @return void
     */
    protected function tearDown()
    {
        $this->writer = null;
        parent::tearDown();
    }

    /**
     * Test passing anything but a string to write throws exception
     * 
     * @expectedException Pay_Writer_Exception
     * @dataProvider notPopulatedStringProvider
     * @param mixed $var
     */
    public function testPassingNotPopulatedStringToWriteThrowsError($var)
    {
        $this->writer->write($var);
    }

    /**
     * Test not passing any messages and retrieving events returns empty array
     * 
     * @return void
     */
    public function testNotSendingMessageAndRetrievingEventsReturnsEmptyArray()
    {
    	$this->assertSame(array(), $this->writer->getEvents());
    }

    /**
     * Test that it is possible to pass messages and retrieve
     * 
     * @return void
     */
    public function testCanPassMessagesAndRetrieve()
    {
    	$messageOne = 'This is the first message';
    	$messageTwo = 'This is the second message';

    	$this->writer->write($messageOne)->write($messageTwo);
    	$events = $this->writer->getEvents();
    	
    	$this->assertEquals($messageOne, $events[0]['message']);
    	$this->assertEquals($messageTwo, $events[1]['message']);
    }

    // ------------------- Data providers from here ------------------- 

    /**
     * Provides 'not populated string'
     * 
     * @return array
     */
    public static function notPopulatedStringProvider()
    {
        return Providers::notPopulatedStringProvider();
    }
}