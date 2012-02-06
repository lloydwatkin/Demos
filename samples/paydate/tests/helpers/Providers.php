<?php
/**
 * Data providers for unit tests
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage helpers
 */

/**
 * Data providers for unit tests
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    test
 * @subpackage helpers
 */
class Providers
{
    /**
     * Returns 'not an array'
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
        return array(
            array('notAnArray'),
            array(1),
            array(true),
            array(null),
            array(new StdClass),
            array(2e30),        
        );
    }

    /**
     * Provides not the required class type
     * 
     * @return array
     */
    public static function notRequiredClassProvider()
    {
        return array(
            array('notRequiredClass'),
            array(true),
            array(null),
            array(array('not', 'required', 'class')),
            array(new StdClass),
            array(2e30),
            array(1),      
        );
    }

    /**
     * Not a populated strin provider
     * 
     * @return array
     */
    public static function notPopulatedStringProvider()
    {
        return array(
            array(''),
            array(true),
            array(null),
            array(array('not', 'populated', 'string')),
            array(new StdClass),
            array(2e30),
            array(1),
        );
    }
}