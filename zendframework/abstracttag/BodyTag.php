<?php
/**
 * View helper for the body tag
 * 
 * @author     Lloyd Watkin <lloyd.watkin@brightpearl.com>
 * @since      21/08/2010
 * @package    Pro
 * @subpackage ViewHelper
 */

/**
 * View helper for the body tag
 * 
 * @author     Lloyd Watkin <lloyd.watkin@brightpearl.com>
 * @since      21/08/2010
 * @package    Pro
 * @subpackage ViewHelper
 */
class Pro_View_Helper_BodyTag
    extends Pro_View_Helper_AbstractTag
{
    /**
     * Registry key for placeholder
     * 
     * @var string
     */
    protected $_regKey = 'Pro_View_Helper_BodyTag';

    /**
     * Which attributes are valid
     * 
     * Currently only STF attributes supported 
     * (S = STRICT, T = TRANSITIONAL, F = FRAMESET)
     * 
     * @see http://www.w3schools.com/tags/tag_body.asp
     * @var array
     */
    protected $_validAttributes = array(
        /* Standard Attributes */
        'class', 'dir', 'id', 'lang', 'style', 'title', 'xml:lang',
        /* Event Attributes */
        'onclick', 'ondblclick', 'onload', 'onmousedown', 'onmousemove',
        'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 'onkeypress',
        'onkeyup', 'onunload',
    );

    /**
     * Self closing tag?
     * 
     * @var boolean
     */
    protected $_selfClosing = false;    

    /**
     * Tag name
     * 
     * @var string
     */
    protected $_tagName = 'body';

    /**
     * BodyTag method
     * 
     * @param  string  $attribute
     * @param  string  $value
     * @param  boolean $replace
     * @param  string  $separator
     * @return App_View_Helper_BodyTag
     */
    public function bodyTag($attribute = null, $value = null, 
        $replace = false, $separator = '')
    {
    	return $this->_abstractTag(
    	    $attribute, $value, $replace, $separator
    	 );
    }
}