<?php
/** 
 * Block counting class
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      03/03/2012
 * @package    Block
 * @subpackage Counter 
 */

/** 
 * Block counting class
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      03/03/2012
 * @package    Block
 * @subpackage Counter 
 */

/**
 * @namespace Block
 */
namespace Block;

class Counter
{
    /**
     * Errors
     * 
     * @var string
     */
    const NO_GRID            = 'A grid has not been provided';
    const INVALID_GRID_VALUE = 'Non-boolean grid value';

    /**
     * Stores grid
     * 
     * @var array
     */
    protected $_grid;

    /**
     * Grid elements which have been checked already
     * 
     * @var array
     */
    protected $_checkedGridElements = array();

    /**
     * Constructor
     * 
     * @param  array $grid
     */
    public function __construct(array $grid = NULL)
    {
        if (false === is_null($grid)) {
            $this->setGrid($grid);
        }
    }

    /**
     * Set grid
     * 
     * @param  array $grid
     * @return $this *Provides a fluent interface*
     */
    public function setGrid(array $grid)
    {
        $this->_grid = $grid; 
        return $this;       
    }

    /**
     * Count method
     * 
     * @return integer
     */
    public function count()
    {
        $this->_checkGridSet();
        return $this->_countBlocks();
    }

    /**
     * Check that a grid has been provided
     */
    protected function _checkGridSet()
    {
        if (true === is_null($this->_grid)) {
            throw new \RuntimeException(self::NO_GRID);
        }
    }

    /**
     * Method which begins the counting process
     * 
     * @return integer
     */
    protected function _countBlocks()
    {
        $count = 0;
        foreach ($this->_grid as $rowIndex => $row) {
            foreach ($row as $columnIndex => $cell) {
                if (true === $this->_isBlock($rowIndex, $columnIndex)) {
                    ++$count;
                }
            }
        }
        return $count;
    }

    /**
     * Is this cell the starting point for a block?
     *
     * @param  integer $rowIndex
     * @param  integer $columnIndex
     * @return boolean
     */
    protected function _isBlock($rowIndex, $columnIndex)
    {
        switch (true) {
            case $this->_hasCellBeenChecked($rowIndex, $columnIndex):
            case ($rowIndex < 0):
            case ($rowIndex >= count($this->_grid)):
            case ($columnIndex < 0):
            case ($columnIndex >= count($this->_grid[0])):
                return false;
            default:
        }
        if (false === is_bool($this->_grid[$rowIndex][$columnIndex])) {
            throw new \UnexpectedValueException(self::INVALID_GRID_VALUE);
        }
        $this->_markCellChecked($rowIndex, $columnIndex);
        if (false === $this->_grid[$rowIndex][$columnIndex]) {
            return false;
        }
        // Check adjacent cells - spider out and check
        $this->_isBlock($rowIndex - 1, $columnIndex);
        $this->_isBlock($rowIndex, $columnIndex + 1);
        $this->_isBlock($rowIndex + 1, $columnIndex);
        $this->_isBlock($rowIndex, $columnIndex - 1);
        return true;
    }

    /**
     * Has the requested cell already been checked?
     * 
     * @param  integer $rowIndex
     * @param  integer $columnIndex
     * @return boolean
     */
    protected function _hasCellBeenChecked($rowIndex, $columnIndex)
    {
        return isset($this->_checkedGridElements[$rowIndex][$columnIndex]);
    }

    /**
     * Mark cell as checked
     * 
     * @param  integer $rowIndex
     * @param  integer $columnIndex
     */
    protected function _markCellChecked($rowIndex, $columnIndex)
    {
        $this->_checkedGridElements[$rowIndex][$columnIndex] = true;
    }
}