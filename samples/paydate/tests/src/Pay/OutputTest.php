<?php
/**
 * Test cases for the 'Pay_Output' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage output
 */

/**
 * Test cases for the 'Pay_Output' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage output
 */
class Pay_OutputTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * Holds the Pay_Output Object
     * 
     * @var Pay_Output
     */
    private $output;

    /**
     * Holds the writer object
     * 
     * @var Zend_Log_Writer_Abstract
     */
    private $writer;

    /**
     * Holds the logger object
     * 
     * @var Zend_Log
     */
    private $logger;

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
        // Load the object
        $this->output = new Pay_Output();
        
        // Inject the mock writer
        $this->writer = new Pay_Writer_Mock();        
        
        $this->output->addWriter($this->writer);
        
        $this->_setUpResults();
    }
    
    /**
     * Sets up a results object
     * 
     * @return void
     */
    protected function _setUpResults()
    {
        $this->results = new Pay_Dto_Results();
        $this->results->add(array('January', '2010-01-29', '2010-02-15'))
            ->add(array('Feburary', '2010-02-26', '2010-03-15'))
            ->add(array('March', '2010-03-31', '2010-04-15'));
    }

    /**
     * Cleans up the environment after running a test.
     * 
     * @return void
     */
    protected function tearDown()
    {
        $this->output = null;
        parent::tearDown();
    }

    /**
     * Test that Pay_Output is of the correct object type
     * 
     * @return void
     */
    public function testInstantiatedClassIsOfCorrectType()
    {
        $this->assertTrue(
            $this->output instanceof Pay_Interface_Output
        );
    }
    
    /**
     * Test passing a non-Zend_Log class to setWriter() method throws PHP Error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notRequiredClassProvider
     * @param mixed $var
     */
    public function testPassingNonZendLogObjectToSetWriterThrowsError($var)
    {
        $this->output->addWriter($var);
    }
    
    /**
     * Test calling process() without setting a writer throws an exception
     * 
     * @expectedException Pay_Exception
     * @return void
     */
    public function testNotSettingWriterThrowsExceptionOnProcess()
    {
        $this->output = new Pay_Output();
        $this->output->process($this->results);
    }

    /**
     * Test passing a non-Results object to process() method throws PHP Error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notRequiredClassProvider
     * @param mixed $var
     */
    public function testPassingNonResultsObjectToProcessThrowsError($var)
    {
        $this->output->process($var);
    }

    /**
     * Calling process results returns expected results
     * 
     * @return void
     */
    public function testProcessMethodWritesExpectedData()
    {
        $this->output->process($this->results);
        
        $expected = '"January","2010-01-29","2010-02-15"' . PHP_EOL;
        $events = $this->writer->getEvents();

        $this->assertEquals($expected, $events[0]['message']);
    }

    /**
     * Test trying to set anything but an array as a header row throws error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notArrayProvider
     * @param mixed $var
     */
    public function testPassingNonArrayToSetHeaderThrowsError($var)
    {
        $this->output->setHeader($var);
    }

    /**
     * Test that a header can be set and seen as first record in results
     * 
     * @return void
     */
    public function testCanSetHeaderAndSeeInOutput()
    {
        $header = array('Month', 'Pay day', 'Bonus day');
        $this->output->setHeader($header);
        $this->output->process($this->results);

        $expected = '"' . implode('","', $header) . '"' . PHP_EOL;
        $events = $this->writer->getEvents();

        $this->assertEquals($expected, $events[0]['message']);
    }

    /**
     * Can overwrite header with nothing and find its not in the output
     * 
     * @return void
     */
    public function testCanUnsetHeaderAndFindItsNotInOutput()
    {
        $header = array('Month', 'Pay day', 'Bonus day');
        $this->output->setHeader($header);
        // Now overwrite the header with nothing
        $this->output->setHeader(array());
        
        $this->output->process($this->results);

        $expected = '"' . implode('","', $header) . '"' . PHP_EOL;
        $events = $this->writer->getEvents();

        $this->assertNotEquals($expected, $events[0]['message']);
    }

    /**
     * Can add two writers to the output model and both writers are written to
     * 
     * @return void
     */
    public function testCanWriteToTwoWriters()
    {
    	$secondWriter = clone $this->writer;
    	$this->output->addWriter($secondWriter);

    	$this->output->process($this->results);

    	$firstEvents  = $this->writer->getEvents();
    	$secondEvents = $secondWriter->getEvents();

    	$events = array(
    	    $firstEvents[0]['message'],
    	    $secondEvents[0]['message'],
    	);

    	$expected = array(
    	    '"January","2010-01-29","2010-02-15"' . PHP_EOL,
    	    '"January","2010-01-29","2010-02-15"' . PHP_EOL,
    	);

    	$this->assertEquals($expected, $events);
    }

    // ------------------- Data providers from here ------------------- 

    /**
     * Provides not the required class type
     * 
     * @return array
     */
    public static function notRequiredClassProvider()
    {
        return Providers::notRequiredClassProvider();
    }

    /**
     * Provides 'not array'
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
        return Providers::notArrayProvider();    
    }
}