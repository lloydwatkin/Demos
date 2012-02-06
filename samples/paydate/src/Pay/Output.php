<?php
/**
 * Processes results and passes to writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage results
 */

/**
 * Processes results and passes to writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage results
 */
class Pay_Output 
    implements Pay_Interface_Output
{
	/**
	 * Error messages
	 */
	const NO_WRITER = 'Writer has not been set';
	const NOT_ARRAY = 'Expected array for result';
	
	/**
	 * Holds the writer objects
	 * 
	 * @var array
	 */
	protected $_writers = array();

	/**
	 * Holds the CSV header row
	 * 
	 * @var array
	 */
    protected $_header = array();

	/**
	 * Add a writer object
	 * 
	 * @param Pay_Writer_Interface $writer
	 * @return Writer Provides a flent interface
	 */
	public function addWriter(Pay_Writer_Interface $writer)
	{
	    $this->_writers[] = $writer;
	    return $this;
	}

	/**
	 * Get the writers
	 * 
	 * @return array
	 * @throws Exception If writer not set
	 */
	protected function _getWriters()
	{
		if (0 === count($this->_writers)) {
			throw new Pay_Exception(self::NO_WRITER);
		}
		return $this->_writers;
	}

	/**
	 * Set the header - an empty array is acceptable, this prints no header
	 * 
	 * @param array $header
	 */
	public function setHeader(array $header)
	{
		$this->_header = $header;
	}
	
	/**
	 * Writes output
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function _write($message)
	{
		$writers = $this->_getWriters();		
		foreach ($writers AS $writer) {
			$writer->write($message);
		}
	}

	/**
	 * Accepts a Results object and processes
	 * 
	 * @param Pay_Dto_Results $results
	 * @return boolean
	 */
	public function process(Pay_Dto_Results $results)
	{
		if (0 !== count($this->_header)) {
			$header = $this->_convertToCsv($this->_header);
			$this->_write($header);
		}
		foreach ($results AS $result) {
			$result = $this->_convertToCsv($result);
			$this->_write($result);
		}
		return true;
	}

	/**
	 * Convert results array to CSV format
	 * 
	 * @param array $result
	 * @return string $csv
	 */
	protected function _convertToCsv(array $result)
	{
		return '"' . implode('","', $result) . '"' . PHP_EOL;
	}
}