<?php
/**
 * Generic payment class which is setup via a config
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage paymentType
 */

/**
 * Generic payment class which is setup via a config
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage paymentType
 */
class Pay_Payment 
    implements Pay_Interface_Payment
{
    /**
     * Holds error messages
     */
    const INVALID_NAME  = 'Invalid payment name provided';
    const BAD_CONFIG    = 'Bad payment configuration data provided';
    const INVALID_DATE  = 'An invalid date has been passed';
    const INVALID_TYPE  = 'Invalid type provided for date, expected string'; 
    
    /**
     * Holds the payment type name
     * 
     * @var string
     */
    protected $_name;

    /**
     * Holds the payment config
     * 
     * @var array
     */
    protected $_config;

    /**
     * Year for which we are calculating the payment date
     * 
     * @var integer
     */
    protected $_year;

    /**
     * Month for which we are calculating the payment date
     * 
     * @var integer
     */
    protected $_month;

    /**
     * Payment date for the current month/year
     * 
     * @var integer
     */
    protected $_date;

    /**
     * Construct function, sets up payment type
     * 
     * @param string $name
     * @param array  $params
     * @throws Exception For invalid config
     */
    public function __construct($name, array $config)
    {
        $this->_setName($name);
        $this->_setConfig($config);
    }

    /**
     * Set the payment config name
     * 
     * @param string $name
     * @return Payment Provides a fluent interface
     */
    protected function _setName($name)
    {
        if (!is_string($name) || !preg_match('/^[A-Z\-\.]{1,}$/i', $name)) {
            throw new Pay_Exception(self::INVALID_NAME);
        }
        $this->_name = $name;
    }

    /**
     * Set config for payment type
     * 
     * @param array $config
     * @return Payment Provides a fluent interface
     */
    protected function _setConfig(array $config)
    {
        if (!$this->_isValid($config)) {
            throw new Pay_Exception(self::BAD_CONFIG);
        }
        $this->_config = $config;
    }

    /**
     * Calculates the payment date for a given month/year
     * 
     * @param string $date (Format YYYY-MM)
     * @return string Payment date (Format: YYYY-MM-DD)
     */
    public function getDate($date)
    {
    	if (!is_string($date)) {
    		throw new Pay_Exception(self::INVALID_TYPE);
    	}
        $dateParts = explode('-', $date);
        if (2 !== count($dateParts)) {
        	throw new Pay_Exception(self::INVALID_DATE);
        }
        list($year, $month) = $dateParts;
        
        switch (false) {
            case preg_match('/^([0]?[1-9]|1[012])$/', (int) $month):
            // Loose checking on year
            case preg_match('/^[0-9]{4}$/', $year):    
                throw new Pay_Exception(self::INVALID_DATE . " ({$date})");
        }
        return $this->_calculateDate((int) $month, (int) $year);        
    }

    /**
     * Calculate the payment date based on config information
     * 
     * @param ineger s $month
     * @param integer $year
     * @return string Payment date (YYYY-MM-DD)
     */
    protected function _calculateDate($month, $year)
    {
        $this->_month = $month;
        $this->_year  = $year;
        
        $this->_handlePayShift();
        $this->_setPaymentDate();
        
        /* If payments are not made on a weekend and payment date is a weekend
         * then additional calculations are required
         */
        if (('true' != $this->_config['weekend.allow']) && 
            ($this->_isWeekend())) {

            $intMove = $this->_getIntegerDayFromString();
            // We need the day of the currently predicted pay date
            $intPredicted = $this->_getIntegerDayFromPaymentDate();
            
            if ('before' == $this->_config['weekend.move']) {
            	 // Payment is before weekend
            	 $numberOfDays = -1 * ($intPredicted - $intMove);            	 
            } else {
            	// Payment comes after weekend
            	$numberOfDays = $intMove + (7 - $intPredicted);
            }
            list($this->_year, $this->_month, $this->_date) = explode(
                '-', 
                date(
                    'Y-m-d', 
                    mktime(
                        12, 0, 0, $this->_month, 
                        $this->_date + $numberOfDays, $this->_year
                    )
                )
            );
        }
        return $this->_formatDate();
    }
    
    /**
     * Returns integer day number from string
     * 
     * @return integer
     */
    protected function _getIntegerDayFromString()
    {
    	switch ($this->_config['weekend.day']) {
    		case 'monday':
    			return 1;
    		case 'tuesday':
    			return 2;
    		case 'wednesday':
    			return 3;
    		case 'thursday':
    			return 4;
    		default:
    			return 5;
    	}
    }

    /**
     * Returns integer day from payment date
     * 
     * @return integer
     */
    protected function _getIntegerDayFromPaymentDate()
    {
    	return date(
    	    'N', mktime(
    	        12, 0, 0, $this->_month, $this->_date, $this->_year
    	    )
    	);
    }

    /**
     * Calulates the payment date based on config
     * 
     * @return void
     */
    protected function _setPaymentDate()
    {
    	$endOfMonth = date(
            'd', mktime(0, 0, 0, $this->_month+1, 1, $this->_year) - 1
        );
    	switch ($this->_config['paydate']) {
    		case 'start':
    			$this->_date = 1;
    			return;
    		case 'end':
    			$this->_date = date(
    			    'd', mktime(0, 0, 0, $this->_month+1, 1, $this->_year) - 1
    			);
    			return;
    		default:
    			$this->_date = $this->_config['paydate'];
    			if ($this->_config['paydate'] > $endOfMonth) {
    				$this->_date = $endOfMonth;
    			}
    			return;
    	}
    }

    /**
     * Tests to see if current date, month, year is a weekend
     * 
     * @return boolean
     */
    protected function _isWeekend()
    {
        $day = date(
            'N', mktime(0, 0, 0, $this->_month, $this->_date, $this->_year)
        );
        return in_array($day, array(6, 7));
    }

    /**
     * Returns payment date formatted correctly
     * 
     * @return string Format: YYYY-MM-DD
     */
    protected function _formatDate()
    {
        $date  = "{$this->_year}-";
        $date .= str_pad($this->_month, 2, '0', STR_PAD_LEFT) . '-';
        $date .= str_pad($this->_date, 2, '0', STR_PAD_LEFT);
        return $date;
    }

    /**
     * Handles pay shifts
     * 
     * @return void
     */
    protected function _handlePayshift()
    {
        if (0 != $this->_config['payshift']) {
            $years = floor(abs($this->_config['payshift']) / 12);
            if ($years > 0) {
                if ($this->_config['payshift'] < 0) {
                    $this->_year -= $years;
                } else {
                    $this->_year += $years;
                }
            }
            $remainingMonths = abs($this->_config['payshift']) - ($years * 12);
            if ($remainingMonths > 0) {
                if ($this->_config['payshift'] > 0) {
                    $month = $this->_month + $remainingMonths;
                } else {
                    $month = $this->_month - $remainingMonths;
                }
                list($this->_year, $this->_month) = explode(
                    '-', 
                    date('Y-m', mktime(12, 0, 0, $month, 15, $this->_year))
                );
            }
        }
    }

    /**
     * Validates a config setup
     * 
     * @param array $config
     * @return boolean
     */
    protected function _isValid(array $config)
    {
        $validDays = array(
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
        );
        // Check validity of data provided
        switch (false) {
            case (count($config) > 0):
            case isset($config['paydate']):
            case isset($config['weekend.allow']):
            case isset($config['weekend.move']):
            case isset($config['weekend.day']):
            case isset($config['payshift']):
            case preg_match(
                '/^(([012]?[1-9]|3[01])|start|end)$/i', $config['paydate']
            ):
            case in_array($config['weekend.move'], array('before', 'after')):            	
            case in_array($config['weekend.day'], $validDays):
            case in_array($config['weekend.allow'], array('true', 'false')):
            case is_numeric($config['payshift']):
            case ($config['payshift'] == (int) $config['payshift']):
                return false;
        }
        return true;
    }
}