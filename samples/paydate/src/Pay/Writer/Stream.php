<?php
/**
 * Writer based upon Zend_Log_Writer_Stream
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */

/**
 * Writer based upon Zend_Log_Writer_Stream
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */
class Pay_Writer_Stream
    implements Pay_Writer_Interface
{
	/**
	 * Error messages
	 */
	const INVALID_OPTIONS = 'Expected array for options';
	const INVALID_FILE    = 'Expected `filename` to be populated string';
	const INVALID_MESSAGE = 'Invalid message passed, expected populated string';
	const NO_CONFIG       = 'The writer object has not been configured';
	const FILE_ERROR      = 'File could not be opened for writing';

	/**
	 * Holds the writer
	 * 
	 * @var Zend_Log
	 */
	protected $_writer;

    /**
     * Set up the writer by passing options
     * 
     * @param  array $options
     * @return void
     */
    public function __construct(array $options = array())
    {
        if (0 !== count($options)) {
        	$this->setConfig($options);
        }
    }

    /**
     * Set the stream writer
     * 
     * @param array $options
     * @return Pay_Writer_Interface Provides fluent interface
     */
    public function setConfig(array $options)
    {
        if (!isset($options['filename']) || !is_string($options['filename']) 
            || empty($options['filename'])) {

            throw new Pay_Writer_Exception(self::INVALID_FILE);
        }
        $mode = 'w';                    
        if (isset($options['mode'])) {
            $mode = $options['mode'];
        }
        try {
            $writer = new Zend_Log_Writer_Stream($options['filename'], $mode);
        } catch (Zend_Log_Exception $e) {
        	throw new Pay_Writer_Exception(self::FILE_ERROR);
        }
        $writer->setFormatter(new Zend_Log_Formatter_Simple('%message%'));
        $this->_writer = new Zend_Log($writer);
        return $this;
    }

    /**
     * Returns the writer object
     * 
     * @return Zend_Log_Writer_Stream
     * @throws Pay_Exception_Writer If the writer has not been configured
     */
    protected function _getWriter()
    {
    	if (is_null($this->_writer)) {
    		throw new Pay_Writer_Exception(self::NO_CONFIG);
    	}
    	return $this->_writer;
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
    	$this->_getWriter()->info($message);
    	return $this;
    }
}