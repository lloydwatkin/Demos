<?php
/**
 * Writer based upon Zend_Log_Writer_Mock
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */

/**
 * Writer based upon Zend_Log_Writer_Mock
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */
class Pay_Writer_Mock
    implements Pay_Writer_Interface
{
	/**
	 * Error message(s)
	 */
	const INVALID_MESSAGE = 'Invalid message passed, expected populated string';

	/**
	 * Holds the writer
	 * 
	 * @var Zend_Log
	 */
	protected $_writer;

	/**
	 * Holds the mock writer
	 * 
	 * @var Zend_Log_Writer_Mock
	 */
	protected $_mock;

	/**
	 * Construct set file name to write to
	 * 
	 * @param string $output
	 * @return void
	 */
    public function __construct(array $options = array())   
    {
        $this->_mock = new Zend_Log_Writer_Mock();
        $this->_mock->setFormatter(new Zend_Log_Formatter_Simple('%message%'));
        $this->_writer = new Zend_Log($this->_mock);
    }

    /**
     * Write function - point to Zend_Log::info()
     * 
     * @param string $message
     * @return Pay_Writer_Interface Provides a fluent interface
     */
    public function write($message)
    {
    	if (!is_string($message) || empty($message)) {
    		throw new Pay_Writer_Exception(self::INVALID_MESSAGE);
    	}
    	$this->_writer->info($message);
    	return $this;
    }

    /**
     * Method which allows the retrieval of 'events' from the mock
     * 
     * @return array
     */
    public function getEvents()
    {
    	return $this->_mock->events;
    }
}