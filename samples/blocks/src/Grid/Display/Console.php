<?php
/**
 * Display a grid within the console
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */

/**
 * Display a grid within the console
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */
namespace Grid\Display;
use \Grid\Display as Display;

class Console
    implements Display
{
    /**
     * Characters for cells
     * 
     * @var string
     */
    const ACTIVE   = "■";
    const INACTIVE = "·";

    /**
     * Main draw method
     * 
     * @param  array  $grid
     * @return string
     */
    public function draw(array $grid)
    {
        $response = '';
        foreach ($grid as $row) {
            $response .= $this->_drawRow($row);
        }
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
        $rowResponse = '';
        foreach ($row as $cell) {
            if (false === \is_bool($cell)) {
                throw new \UnexpectedValueException(self::INVALID_GRID_VALUE);
            }
            if (true === $cell) {
                $rowResponse .= self::ACTIVE;
            } else {
                $rowResponse .= self::INACTIVE;
            }
        }
        return $rowResponse . PHP_EOL;
    }
} 