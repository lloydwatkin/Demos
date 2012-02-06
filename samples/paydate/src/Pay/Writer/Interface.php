<?php
/**
 * Writer Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */

/**
 * Writer Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage writer
 */
interface Pay_Writer_Interface
{
	/**
	 * Set up the writer by passing options
	 * 
	 * @param  array $options
	 * @return void
	 */
    public function __construct(array $options = array());

    /**
     * Write function
     * 
     * @param  string $message
     * @return Pay_Writer_Interface Provides a fluent interface
     */
    public function write($message);
}