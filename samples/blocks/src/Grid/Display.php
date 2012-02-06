<?php
/**
 * Interface for displaying a grid
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */

/**
 * Interface for displaying a grid
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      02/02/2012
 * @package    Grid
 * @subpackage Display
 */
namespace Grid;

interface Display
{
    /**
     * Errors
     * 
     * @var string    
     */
    const INVALID_GRID_VALUE = 'Non-boolean grid value';

    /**
     * Main draw method
     * 
     * @param  array  $grid
     * @return string
     */
    public function draw(array $grid);
} 