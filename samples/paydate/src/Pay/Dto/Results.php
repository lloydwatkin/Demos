<?php
/**
 * Results data transfer object 
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage dto
 */

/**
 * Results collection
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage dto
 */
class Pay_Dto_Results
    implements Iterator, Countable
{
    /**
     * Error messages
     */
    const NO_ELEMENTS = 'Expected a least 1 element in a result';
	
    /**
     * Holds the results
     * 
     * @var array
     */
    protected $_results = array();

    /**
     * Holds current position within the results array
     * 
     * @var integer
     */
    protected $_offset = 0;

    /**
     * Returns a count of results
     * 
     * @return integer
     */
    public function count()
    {
        return count($this->_results);
    }
    
    /**
     * Gets the current result
     * 
     * @return array
     */
    public function current()
    {
        return $this->_results[$this->_offset];
    }

    /**
     * Returns the current offset/key
     * 
     * @return integer|string
     */
    public function key()
    {
        return $this->_offset;
    }

    /**
     * Sets the next position in the results array
     * 
     * @return void
     */
    public function next()
    {
        ++$this->_offset;
    }

    /**
     * Rewinds the current position in the array
     * 
     * @return void
     */
    public function rewind()
    {
        $this->_offset = 0;
    }

    /**
     * Returns true if current offset exists
     * 
     * @return boolean
     */
    public function valid()
    {
        return isset($this->_results[$this->_offset]);
    }

    /**
     * Add a new result
     * 
     * @param  array $result
     * @return Results Provides a fluent interface
     * @throws InvalidArgumentException If empty array provided
     */
    public function add(array $result)
    {
    	if (0 === count($result)) {
    		throw new InvalidArgumentException(self::NO_ELEMENTS);
    	}
    	$this->_results[] = $result;
    	return $this;
    }
}
