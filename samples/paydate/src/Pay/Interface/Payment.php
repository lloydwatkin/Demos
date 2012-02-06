<?php
/**
 * Generic payment class which is setup via a config - Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage payment
 */

/**
 * Generic payment class which is setup via a config - Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage payment
 */
interface Pay_Interface_Payment
{
    /**
     * Construct function, sets up payment type
     * 
     * @param string $name
     * @param array  $params
     * @throws Exception For invalid config
     */
    public function __construct($name, array $config);

    /**
     * Calculates the payment date for a given month/year
     * 
     * @param string $date (Format YYYY-MM)
     * @return string Payment date (Format: YYYY-MM-DD)
     */
    public function getDate($date);
}