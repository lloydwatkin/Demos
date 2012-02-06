<?php
/**
 * Processes results and passes to writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage output
 */

/**
 * Processes results and passes to writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage output
 */
interface Pay_Interface_Output
{
	/**
	 * Set the writer object
	 * 
	 * @param Pay_Writer_Interface $writer
	 * @return Writer Provides a flent interface
	 */
	public function addWriter(Pay_Writer_Interface $writer);

	/**
	 * Set the header - an empty array is acceptable, this prints no header
	 * 
	 * @param array $header
	 */
	public function setHeader(array $header);

	/**
	 * Accepts a Results object and processes
	 * 
	 * @param Pay_Dto_Results $results
	 * @return boolean
	 */
	public function process(Pay_Dto_Results $results);
}