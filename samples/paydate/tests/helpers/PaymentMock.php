<?php
/**
 * Mock of payment type for testing
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage helper
 */

/**
 * Generic payment class which is setup via a config
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage helper
 */
class PaymentMock 
    implements Pay_Interface_Payment
{
    /**
     * Construct function, sets up payment type
     * 
     * @param string $name
     * @param array  $params
     * @throws Exception For invalid config
     */
    public function __construct($name, array $config)
    {
    }

    /**
     * Set the payment config name
     * 
     * @param string $name
     * @return Payment Provides a fluent interface
     */
    public function setName($name)
    {
    }

    /**
     * Set config for payment type
     * 
     * @param array $config
     * @return Payment Provides a fluent interface
     */
    public function setConfig(array $config)
    {
    }

    /**
     * Calculates the payment date for a given month/year
     * 
     * @param string $date (Format YYYY-MM)
     * @return string Payment date (Format: YYYY-MM-DD)
     */
    public function getDate($date)
    {
        return 'mock date';      
    }
}