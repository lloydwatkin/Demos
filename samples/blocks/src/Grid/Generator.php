<?php
/**
 * Grid generator
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Blocks
 * @subpackage Grid
 */

/**
 * Grid generator
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Blocks
 * @subpackage Grid
 */
namespace Grid;

class Generator
    /* implements GeneratorInterface */
{
    /**
     * Errors
     * 
     * @var string
     */
    const INVALID_WIDTH       = 'Width should be a positive integer value';
    const INVALID_HEIGHT      = 'Height should be a positive integer value';
    const GRID_SIZE_NOT_SET   = 'Grid size must be set before generation';
    const INVALID_PROBABILITY = 'Probabilities should be between 0 and 1';

    /**
     * Grid size to be generated
     * 
     * @var array
     */
    protected $_gridSize = array(
        'width'  => NULL,
        'height' => NULL,
    );

    /**
     * Chance of filled block
     * 
     * @var double
     */
    protected $_probabilityOfActiveBlock = 0.0;

    /**
     * Set grid size
     * 
     * @param  integer $width
     * @param  integer $height
     * @return $this   *Provides a fluent interface*
     */
    public function setSize($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);
        $this->_gridSize = array(
            'width' => (int) $width,
            'height' => (int) $height,
        );
        return $this;
    }

    /**
     * Set grid height
     * 
     * @param  integer $height
     * @return $this   *Provides a fluent interface*
     */
    public function setHeight($height)
    {
        if (!is_integer($height) || ($height < 1)) {
            throw new \InvalidArgumentException(self::INVALID_HEIGHT);
        }
        $this->_gridSize['height'] = (int) $height;
        return $this;
    }

    /**
     * Set grid width
     * 
     * @param  integer $width
     * @return $this   *Provides a fluent interface*
     */
    public function setWidth($width)
    {
        if (!is_integer($width) || ($width < 1)) {
            throw new \InvalidArgumentException(self::INVALID_WIDTH);
        }
        $this->_gridSize['width'] = (int) $width;
        return $this;
    }

    /**
     * Generate the grid
     * 
     * @return array
     */
    public function generate()
    {
        $this->_checkGridSizeSet();
        $grid = array_fill(0, $this->_gridSize['height'], array());
        for ($row = 0; $row < $this->_gridSize['height']; $row++) {
            $grid[$row] = $this->_getRowValues();
        }
        return $grid;
    }

    /**
     * Get row values for grid
     * 
     * @return array
     */
    protected function _getRowValues()
    {
        $row = array();
        for ($column = 0; $column < $this->_gridSize['width']; $column++) {
            $row[$column] = $this->_getCellValue();
        }
        return $row;
    }

    /**
     * Set probability of an active block
     * 
     * @param  double $probability
     * @return $this *Provides a fluent interface*
     */
    public function setProbability($probability)
    {
        if (!is_double($probability) 
            || ($probability < 0.0) 
            || ($probability > 1.0)
        ) {
            throw new \InvalidArgumentException(self::INVALID_PROBABILITY);
        }
        $this->_probabilityOfActiveBlock = $probability;
        return $this;
    }

    /**
     * Generate a value for a cell
     * 
     * @return boolean
     */
    protected function _getCellValue()
    {
        if (0.0 === $this->_probabilityOfActiveBlock) {
            return false;
        } else if (1.0 === $this->_probabilityOfActiveBlock) {
            return true;
        }
        $randomValue = rand(0, 100000) / 100000.0;
        return ($this->_probabilityOfActiveBlock >= $randomValue);
    }

    /**
     * Check to see if the grid size has been set
     */
    protected function _checkGridSizeSet()
    {
        if ((true === is_null($this->_gridSize['width']))
            || (true === is_null($this->_gridSize['height']))
        ) {
            throw new \RuntimeException(self::GRID_SIZE_NOT_SET);
        }
    }
}