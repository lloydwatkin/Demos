<?php
/**
 * Tests for the HTML table writer
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 */

/**
 * @namespace
 */
namespace Grid\Display;

use Grid\Display\HtmlTable as HtmlTable;

class HtmlTableTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * Stores an instance of the HTML table drawer
     * 
     * @var \Grid\Display\HtmlTable
     */
    protected $_renderer;

    /**
     * Table cell style
     * 
     * @var string
     */
    protected $_tableCellStyle;

    /**
     * General table style
     * 
     * @var string
     */
    protected $_tableStyle;

    /**
     * Active cell colour
     * 
     * @var string
     */
    protected $_activeCell;

    /**
     * Inactive cell colour
     * 
     * @var string
     */
    protected $_inactiveCell;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->_renderer       = new HtmlTable();
        $this->_tableCellStyle = HtmlTable::TABLE_CELL_STYLE;
        $this->_tableStyle     = HtmlTable::TABLE_STYLE;
        $this->_activeCell     = HtmlTable::ACTIVE;
        $this->_inactiveCell   = HtmlTable::INACTIVE;
    }

    /**
     * Test passing a 1x1 inactive grid returns expected result
     */
    public function testPassingOneByOneInactiveGridReturnsExpectedResult()
    {
        $response = str_replace("\t", "    ", $this->_renderer->draw(array(array(false))));
        $expected = <<<EOE
<table style="{$this->_tableStyle}">
    <tbody>
    <tr>
        <td style="{$this->_tableCellStyle} background-color: {$this->_inactiveCell}">&nbsp;</td>
    </tr>
    </tbody>
</table>
EOE;
        $this->assertSame($expected, $response);
    }

    /**
     * Test a multiline grid is drawn as expected
     */
    public function testMultiLineGridIsDrawnAsExpected()
    {
        $response = str_replace(
            "\t",
            "    ",
            $this->_renderer->draw(array(array(false, true, false), array(true, false, true)))
        );
        $expected = <<<EOE
<table style="{$this->_tableStyle}">
    <tbody>
    <tr>
        <td style="{$this->_tableCellStyle} background-color: {$this->_inactiveCell}">&nbsp;</td>
        <td style="{$this->_tableCellStyle} background-color: {$this->_activeCell}">&nbsp;</td>
        <td style="{$this->_tableCellStyle} background-color: {$this->_inactiveCell}">&nbsp;</td>
    </tr>
    <tr>
        <td style="{$this->_tableCellStyle} background-color: {$this->_activeCell}">&nbsp;</td>
        <td style="{$this->_tableCellStyle} background-color: {$this->_inactiveCell}">&nbsp;</td>
        <td style="{$this->_tableCellStyle} background-color: {$this->_activeCell}">&nbsp;</td>
    </tr>
    </tbody>
</table>
EOE;
        $this->assertSame($expected, $response);
    }

    /**
     * Test that an invalid grid value throws exception
     * 
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage Non-boolean grid value
     */
    public function testInvalidGridValueThrowsException()
    {
        $this->_renderer->draw(array(array(1)));
    }
}