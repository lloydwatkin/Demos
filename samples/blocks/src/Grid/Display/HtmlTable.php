<?php
/**
 * Display a grid using HTML Table
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */

/**
 * Display a grid within using HTML Table
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */
namespace Grid\Display;

class HtmlTable
{
    /**
     * Errors
     * 
     * @var string    
     */
    const INVALID_GRID_VALUE = 'Non-boolean grid value';

    /**
     * Characters for cells
     * 
     * @var string
     */
    const ACTIVE   = "#0000FF";
    const INACTIVE = "#FFFFFF";

    /**
     * Table cell style
     * 
     * @var string
     */
    const TABLE_CELL_STYLE = "border: 1px solid #000000; width: 3px; height: 3px; font-size: 6px;";

    /**
     * General table style
     * 
     * @var string
     */
    const TABLE_STYLE = "width: 90%;";

    /**
     * Main draw method
     * 
     * @param  array  $grid
     * @return string
     */
    public function draw(array $grid)
    {
        $tableStyle = self::TABLE_STYLE;
        $response    = <<<EOR
<table style="{$tableStyle}">
    <tbody>

EOR;
        foreach ($grid as $row) {
            $response .= $this->_drawRow($row);
        }
        $response .= <<<EOR
    </tbody>
</table>
EOR;
        return $response;
    }

    /**
     * Draw a row
     * 
     * @param  array $row
     * @return string
     */
    protected function _drawRow(array $row)
    {
        $rowResponse    = "\t<tr>" . PHP_EOL;
        $tableCellStyle = self::TABLE_CELL_STYLE;
        foreach ($row as $cell) {
            if (false === \is_bool($cell)) {
                throw new \UnexpectedValueException(self::INVALID_GRID_VALUE);
            }
            $rowResponse .= "\t\t<td style=\"{$tableCellStyle} background-color: ";
            if (true === $cell) {
                $rowResponse .= self::ACTIVE;
            } else {
                $rowResponse .= self::INACTIVE;
            }
            $rowResponse .= '">&nbsp;</td>' . PHP_EOL;
        }
        return $rowResponse . "\t</tr>" . PHP_EOL;
    }
} 