<?php
/**
 * View helper for the abstract tag
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      21/08/2010
 * @package    Pro
 * @subpackage ViewHelper
 */

/**
 * View helper for the abstract tag
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      21/08/2010
 * @package    Pro
 * @subpackage ViewHelper
 */
abstract class Pro_View_Helper_AbstractTag
    extends Zend_View_Helper_Placeholder_Container_Standalone
{
	/**
	 * Error messages
	 * 
	 * @var string
	 */
	const BAD_ATTRIBUTE = 'Attribute "%s" is not valid';
	const BAD_VALUE     = 'Attribute value should be a populated string';
	const BAD_SEPARATOR = 'Invalid separator';

	/**
	 * Flags
	 * 
	 * @var boolean
	 */
	const OPEN  = true;
	const CLOSE = false;

    /**
     * Registry key for placeholder
     * 
     * @var string
     */
    protected $_regKey = 'Pro_View_Helper_AbstractTag';

    /**
     * Which attributes are valid
     * 
     * Currently only STF attributes supported 
     * (S = STRICT, T = TRANSITIONAL, F = FRAMESET)
     * 
     * @see http://www.w3schools.com/tags/
     * @var array
     */
    protected $_validAttributes = array();

    /**
     * Self closing tag?
     * 
     * @var boolean
     */
    protected $_selfClosing = false;

    /**
     * Valid separators
     * 
     * @var array
     */
    protected $_validSeparator = array('', ' ', ';');

    /**
     * Tag name
     * 
     * @var string
     */
    protected $_tagName = 'tag';
    
    /**
     * Draw tag method
     * 
     * @param  string  $attribute
     * @param  string  $value
     * @param  boolean $replace
     * @param  string  $separator
     * @return Pro_View_Helper_AbstractTag
     */
    protected function _abstractTag($attribute = null, $value = null, 
        $replace = false, $separator = '')
    {
    	if (is_string($attribute) && $this->_validAttribute($attribute)) {
    		$container = $this->getContainer();

    		if (is_null($value)) {
    			unset($container[$attribute]);
    			return $this;
    		}
            $this->_validValue($value);
            $this->_validSeparator($separator);

    		if ((true === $replace) || !isset($container[$attribute])) {
    		    $container[$attribute] = $value;
    		} else if (false === strpos($container[$attribute], $value)) {
    		    $container[$attribute] .= "{$separator} {$value}";
    		}
    	}
    	return $this;
    }

    /**
     * Retrieve string representation
     *
     * @param  boolean $open Open or close a tag
     * @return string
     */
    public function toString($open = self::OPEN)
    {
    	if ($open == self::CLOSE) {
    		if (true === $this->_selfClosing) {
    			return '';
    		}
    		return "</{$this->_tagName}>";
    	}
    	$container = $this->getContainer();
    	$tag = '<' . $this->_tagName;
    	foreach ($container as $attribute => $value) {
    		$tag .= " {$attribute}=\"{$value}\"";
    	}
    	if (true === $this->_selfClosing) {
    		return $tag . '/>';
    	}
    	return $tag . '>';
    }

    /**
     * Check to see if a specified attribute is valid
     * 
     * @param  string $attribute
     * @return boolean
     * @throws Zend_View_Exception
     */
    public function _validAttribute(&$attribute)
    {
    	$attribute = strtolower($attribute);

    	if (in_array($attribute, $this->_validAttributes)) {
    		return true;
    	}
        $e = new Zend_View_Exception(
            sprintf(self::BAD_ATTRIBUTE, $attribute)
        );
        $e->setView($this->view);
        throw $e;
    }

    /**
     * Check that a 'value' is valid
     * 
     * @param  mixed $value
     * @return boolean
     * @throws Zend_View_Exception
     * @todo   Check for double escaped quotes
     */
    public function _validValue($value)
    {
        if (is_string($value) && !empty($value) && !preg_match('/[^\/]{1}"/', $value)) {
            return true;
        }
        $e = new Zend_View_Exception(self::BAD_VALUE);
        $e->setView($this->view);
        throw $e;
    }

    /**
     * Check that a 'separator' is valid
     * 
     * @param  mixed $value
     * @return boolean
     * @throws Zend_View_Exception
     */
    public function _validSeparator($separator)
    {
        if (is_string($separator) && in_array($separator, $this->_validSeparator)) {
            return true;
        }
        $e = new Zend_View_Exception(self::BAD_SEPARATOR);
        $e->setView($this->view);
        throw $e;
    }
}