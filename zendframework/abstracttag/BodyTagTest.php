<?php
/* 
 * Personal file which setups up ZendFramework and 
 * autoloading for my test apps 
 */
@include 'AppSetup.php';

require 'AbstractTag.php';
require 'BodyTag.php';

/**
 * Test for Pro_View_Helper_BodyTag
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      21/08/2010
 * @package    App
 * @subpackage ViewHelper
 * @group      App
 * @group      Pro_View
 * @group      Pro_View_Helper
 */
class Pro_View_Helper_BodyTagTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Holds an instance of the view helper
     * 
     * @var Zend_View_Helper_Abstract
     */
    protected $_helper;

    /**
     * Holds Zend_View instance
     * 
     * @var Zend_View_Interface
     */
    protected $_view;

    /**
     * Setup creates instance of the config object and add test DAO
     * 
     * @return null
     */
    protected function setUp()
    {
        $this->_helper = new Pro_View_Helper_BodyTag();
        // Create a Zend_View
        $this->_helper->setView($this->_view = new Zend_View());
    }

    /**
     * Tear down
     * 
     * @return null
     */
    public function tearDown()
    {
    	/* Clear out registry data */
    	Zend_Registry::_unsetInstance();
    }

    /**
     * Passing non string returns instance of view helper
     * 
     * @dataProvider notString
     * @param        mixed $p
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testNonStringToMethodAchievesNothing($p)
    {
    	$this->_helper->bodyTag($p);
    	$response = (string) $this->_helper;
    	$this->assertSame('<body>', $response);
    }

    /**
     * Passing an unrecognised attribute throws exception
     * 
     * @expectedException Zend_View_Exception
     */
    public function testPassingInvalidAtrributeThrowsException()
    {
    	$this->_helper->bodyTag('notvalid');
    }

    /**
     * Test that it is possible to set an attribute value
     * 
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testCanSetValidAttributeValue()
    {
    	$this->_helper->bodyTag('class', 'top');
    	$this->assertSame('<body class="top">', (string) $this->_helper);
    }

    /**
     * Test can reset an attribute value by setting it to null
     * 
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testAttributeCanBeUnsetByPassingNull()
    {
    	$this->_helper->bodyTag('class', 'bottom');
    	$this->_helper->bodyTag('class');
        $this->assertSame('<body>', (string) $this->_helper);
    }

    /**
     * Test it's possible to add two different attributes
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testCanSetTwoAttributes()
    {
    	$this->_helper->bodyTag('class', 'top')->bodyTag('style', 'left');
    	$this->assertSame(
    	   '<body class="top" style="left">', (string) $this->_helper
    	);
    }

    /**
     * Test that it's possible to set two values to an attribute
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testCanSetTwoValuesToAnAttribute()
    {
    	$this->_helper->bodyTag('class', 'top')->bodyTag('class', 'bottom');
    	$this->assertSame(
    	    '<body class="top bottom">', (string) $this->_helper
    	);
    }

    /**
     * Test that attributes are always lowercased
     *
     * @covers Pro_View_Helper_BodyTag::_validAttribute
     */
    public function testAttributeValuesAreAlwaysLowerCased()
    {
        $this->_helper->bodyTag('cLaSs', 'top');
        $this->assertSame(
            '<body class="top">', (string) $this->_helper
        );
    }

    /**
     * Test that it's possible to overwrite the value of an attribute
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testCanOverwriteAnAttributesValue()
    {
        $this->_helper->bodyTag('class', 'top')
            ->bodyTag('class', 'bottom', true);
        $this->assertSame(
            '<body class="bottom">', (string) $this->_helper
        );
    }

    /**
     * Passing the same value to an attribute does not result in duplication
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testPassingSameAttributeValueTwiceDoesNotResultInDuplication()
    {
    	$this->_helper->bodyTag('class', 'top')->bodyTag('class', 'top');
        $this->assertSame(
            '<body class="top">', (string) $this->_helper
        );
    }

    /**
     * Passing the same value to an attribute does not result in duplication
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testPassingSameAttributeValueTwiceSeparatedDoesNotResultInDuplication()
    {
        $this->_helper->bodyTag('class', 'top')
            ->bodyTag('class', 'bottom')
            ->bodyTag('class', 'top');
        $this->assertSame(
            '<body class="top bottom">', (string) $this->_helper
        );
    }

    /**
     * Passing the same value to an attribute does not result in duplication
     * only where appropriate
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testPassingSimilarAttributeValueIsNotConsideredDuplicateAppended()
    {
        $this->_helper->bodyTag('class', 'top')->bodyTag('class', 'tops');
        $this->assertSame(
            '<body class="top tops">', (string) $this->_helper
        );
    }

    /**
     * Passing the same value to an attribute does not result in duplication
     * only where appropriate
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testPassingSimilarAttributeValueIsNotConsideredDuplicatePrepended()
    {
        $this->_helper->bodyTag('class', 'top')->bodyTag('class', 'stop');
        $this->assertSame(
            '<body class="top stop">', (string) $this->_helper
        );
    }

    /**
     * Passing the same value to an attribute does not result in duplication
     * only where appropriate
     *
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testPassingSimilarAttributeValueIsNotConsideredDuplicateSurrounded()
    {
        $this->_helper->bodyTag('class', 'top')->bodyTag('class', 'stops');
        $this->assertSame(
            '<body class="top stops">', (string) $this->_helper
        );
    }

    /**
     * Passing an invalid separator throws exception
     * 
     * @expectedException Zend_View_Exception
     * @covers Pro_View_Helper_BodyTag::_validSeparator
     */
    public function testPassingInvalidSeparatorThrowsException()
    {
    	$this->_helper->bodyTag('class', 'top', false, '@');
    }

    /**
     * Test can pass separator and seen in output
     * 
     * @covers Pro_View_Helper_BodyTag::bodyTag
     */
    public function testCanPassDifferentSeparator()
    {
    	$this->_helper->bodyTag('class', 'top')
    	    ->bodyTag('class', 'bottom', false, ';');
    	$this->assertSame(
    	    '<body class="top; bottom">', (string) $this->_helper
    	);
    }

    /**
     * Test passing "not-string" or empty string as value throws exception
     * 
     * @expectedException Zend_View_Exception
     * @covers Pro_View_Helper_BodyTag::_validValue
     * @dataProvider notPopulatedString
     * @param mixed $p
     */
    public function testPassingNotPopulatedStringAsValueThrowsException($p)
    {
    	$this->_helper->bodyTag('class', $p);
    }

    /**
     * Test passing unescaped double quotes throws exception
     * 
     * @expectedException Zend_View_Exception
     * @covers Pro_View_Helper_BodyTag::_validValue
     */
    public function testPassingUnescapedDoubleQuoteThrowsException()
    {
    	$this->_helper->bodyTag('onclick', 'doSomething("now")');
    }

    /**
     * Test closing a tag returns expected closing tag
     * 
     * @return void
     */
    public function testTagClosesAsExpected()
    {
    	// Can use abstract class to gather open/close constant
        $this->assertSame(
            '</body>', 
            $this->_helper->toString(Pro_View_Helper_AbstractTag::CLOSE)
        );
    }

    /**
     * Can create a tag using the toString() method and retrieve expected
     * 
     * @return void
     */
    public function testCanOpenTagUsingToStringMethodAndRetrieveExpectedData()
    {
        $this->_helper->bodyTag('class', 'top')
            ->bodyTag('class', 'bottom', false, ';');
        $this->assertSame(
            '<body class="top; bottom">', $this->_helper->toString()
        );    	
    }

    /**
     * Can create a tag using the toString() method and retrieve expected
     * 
     * @return void
     */
    public function testCanOpenTagUsingToStringMethodUsingParam()
    {
    	// Can use concrete class to gather open/close constant
        $this->_helper->bodyTag('class', 'top')
            ->bodyTag('class', 'bottom', false, ';');
        $this->assertSame(
            '<body class="top; bottom">',
            $this->_helper->toString(Pro_View_Helper_BodyTag::OPEN)
        );      
    }

    // ----------------------- Data providers from here -----------------------

    /**
     * Provides 'not string'
     * 
     * @return array
     */
    public static function notString()
    {
        return array(
            array(true),
            array(1),
            array(1.5),
            array(new StdClass()),
            array(null),
            array(array('get', 'up')),
            array(array('get on up')),
            array(-5),
        );
    }

    /**
     * Provides 'not populated string' or NULL
     * 
     * @return array
     */
    public static function notPopulatedString()
    {
        return array(
            array(true),
            array(1),
            array(1.5),
            array(new StdClass()),
            array(''),
            array(array('get', 'up')),
            array(array('get on up')),
            array(-5),
        );
    }
}
