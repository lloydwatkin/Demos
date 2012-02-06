<?php
/**
 * Test cases for the 'Stream' writer 
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage writer
 */

/**
 * Test cases for the 'Stream' writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage writer
 */
class Pay_Writer_StreamTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * Holds the mock writer
     * 
     * @var Pay_Writer_Mock
     */
    private $writer;
    
    /**
     * Test output file name
     * 
     * @var string
     */
    private $file = 'tmp.log';

    /**
     * Prepares the environment before running a test.
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->writer = new Pay_Writer_Stream();
    }

    /**
     * Cleans up the environment after running a test.
     * 
     * @return void
     */
    protected function tearDown()
    {
        $this->writer = null;
        @unlink($this->file);
        parent::tearDown();
    }

    /**
     * Passing invalid config via construct throws exception
     *
     * @dataProvider notArrayProvider
     * @expectedException PHPUnit_Framework_Error
     * @param mixed $var
     */
    public function testPassingNonArrayToConstructThrowsPhpError($var)
    {
    	$writer = new Pay_Writer_Stream($var);
    }

    /**
     * Passing invalid config to setConfig() throws exception
     *
     * @dataProvider notArrayProvider
     * @expectedException PHPUnit_Framework_Error
     * @param mixed $var
     */
    public function testPassingNonArrayToSetConfigThrowsPhpError($var)
    {
        $writer = new Pay_Writer_Stream($var);
    }

    /**
     * Can set writer config via construct
     * 
     * @return void
     */
    public function testCanSetConfigViaConstruct()
    {
    	$this->assertTrue(
    	    new Pay_Writer_Stream(array('filename' => $this->file)) 
    	    instanceof Pay_Writer_Stream
    	);
    }

    /**
     * Test setting config returns instance of $this
     * 
     * @return void
     */
    public function testSettingConfigReturnsInstanceOfObject()
    {
    	$writer = $this->writer->setConfig(array('filename' => $this->file));
    	$this->assertTrue($writer instanceof Pay_Writer_Stream);
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
     * Setting an invalid write mode throws PHP_Error
     * 
     * @expectedException Pay_Writer_Exception
     * @return void
     */
    public function testPassingInvalidWriteModeThrowsException()
    {
    	$this->writer->setConfig(
    	    array(
    	        'filename' => $this->file, 
    	        'mode' => 'thisIsntValid'
    	    )
    	);
    }

    /**
     * Test that it is possible to pass messages and returns $this
     * 
     * @return void
     */
    public function testCanPassMessages()
    {
    	$message = 'This is the message' . PHP_EOL;

    	$response = $this->writer
    	    ->setConfig(array('filename' => $this->file))
    	    ->write($message);
    	
    	$this->assertTrue($response instanceof Pay_Writer_Stream);
    }

    /**
     * Passing invalid config to setConfig() throws exception
     * 
     * @expectedException Pay_Writer_Exception
     * @return void
     */
    public function testPassingInvalidConfigToSetConfigThrowsException()
    {
    	$this->writer->setConfig(array());
    }

    /**
     * Attempting to post message without configuring writer throws exception
     * 
     * @expectedException Pay_Writer_Exception
     * @return void
     */
    public function testSettingMessageWithoutConfiguringWriterThrowsException()
    {
    	$this->writer->write('Exception to be thrown');
    }

    /**
     * Can pass message and read from output
     * 
     * @return void
     */
    public function testCanAddMessageAndRetrieve()
    {
    	$message = 'This is the message';
    	
    	$this->writer
    	    ->setConfig(array('filename' => $this->file))
    	    ->write($message);
    	$this->assertEquals($message, file_get_contents($this->file));
    }

    // ------------------- Data providers from here ------------------- 

    /**
     * Provides non-arrays
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
    	return Providers::notArrayProvider();
    }

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