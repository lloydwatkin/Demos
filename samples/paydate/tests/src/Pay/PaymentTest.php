<?php
/**
 * Test cases for the 'Payment' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage payment
 */

/**
 * Test cases for the 'Payment' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage payment
 */
class Pay_PaymentTest 
    extends PHPUnit_Framework_TestCase
{
	/**
	 * Valid config
	 * 
	 * @var array
	 */
	protected $_config;

	/**
	 * Setup, sets valid config array
	 * 
	 * @return void
	 */
	public function setUp()
	{
		$this->_config = array(
		    'Salary' => array(
                'paydate'       => '15',
                'weekend.allow' => 'true',
                'weekend.move'  => 'before',
                'weekend.day'   => 'friday',
                'payshift'      => '0',
		    ),
		);
	}
    /**
     * Test instantiating with no parameters throws PHP Error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @return void
     */
	public function testPassingNoParametersToConstructThrowsException()
	{
		$payment = new Pay_Payment();
	}

	/**
	 * Test passing non-populated string as first parameter throws exception
	 * 
	 * @dataProvider notPopulatedStringProvider
	 * @expectedException Pay_Exception
	 * @param mixed $var
	 */
	public function testPassingNonPopulatedStringAsNameThrowsException($var)
	{
		$payment = new Pay_Payment($var, array());
	}

	/**
	 * Calling setName() with non-populated string throws exception
     * 
     * @dataProvider notPopulatedStringProvider
     * @expectedException Pay_Exception
     * @param mixed $var
     */
    public function testPassingNotStringToSetNameNameThrowsException($var)
    {
        $payment = new Pay_Payment('valid', array());
    }

	/**
	 * Test passing non-array as second parameter throws PHP Error
	 * 
	 * @expectedException PHPUnit_Framework_Error
	 * @dataProvider notArrayProvider
	 * @param mixed $var
	 */
	public function testPassingNonArrayAsSecondParameterThrowsPhpWarning($var)
	{
		$payment = new Pay_Payment('validString', $var);
	}

	/**
	 * Test passing config missing various elements throws exception
	 * 
	 * @expectedException Pay_Exception
	 * @dataProvider missingConfigParameter
	 * @param string $key Key to unset
	 */
	public function testProvidingSlightlyIncorrectConfigsThrowsException($key)
	{
		$config = $this->_config['Salary'];
		unset($config[$key]);
		$payment = new Pay_Payment('validString', $config);
	}

	/**
	 * Test passing invalid 'weekend.move' parameter throws exception
	 * 
	 * @expectedException Pay_Exception
	 * @dataProvider badParameterProvider
	 * @param string $key Key to change
	 * @param string $val Value to change to 
	 * @return void
	 */
	public function testPassingBadConfigParametersThrowsException($key, $val)
	{
		$config = $this->_config['Salary'];
        $config[$key] = $val;
		$payment = new Pay_Payment('validString', $config);
	}

	/**
	 * Passing valid config and name returns class of expected type
	 * 
	 * @return void
	 */
	public function testPassingValidParametersOnConstructReturnsObject()
	{
		$payment = new Pay_Payment('validname', $this->_config['Salary']);
		$this->assertTrue($payment instanceof Pay_Interface_Payment);
	}

	/**
	 * Test passing invalid date strings to getDate() throw exception
	 * 
	 * @expectedException Pay_Exception
	 * @dataProvider invalidDateStrings
	 * @param mixed $var
	 */
	public function testPassingInvalidDateStringsThrowsException($var)
	{
		$payment = new Pay_Payment('validName', $this->_config['Salary']);
		$payment->getDate($var);
	}

	/**
	 * Passing various payshifts returns expected date
	 * 
	 * @dataProvider  dateShiftProvider
	 * @param integer $shift
	 * @param string  $expectedDate
	 */
	public function testPassingVariousDateShiftsReturnsExpectedDate(
	    $shift, $expectedDate)
	{
		$config = $this->_config['Salary'];
		$config['payshift'] = $shift;
		$payment = new Pay_Payment('validName', $config);
		$result = $payment->getDate('2010-06');
		$this->assertEquals($expectedDate, $result);
	}

	/**
	 * Not allowing payments on weekends but selecting payment dates that are 
	 * not on weekends returns expected results
	 * 
	 * @param string $paymentMonth
	 * @param string $paymentDate
	 * @dataProvider nonWeekendPaymentDatesProvider
	 */
	public function testBanningWeekendPaymentsForNonWeekendPayDaysHasNoEffect(
	    $paymentMonth, $paymentDate)
	{
        $config = $this->_config['Salary'];
        $config['weekend.allow'] = 'false';
        $payment = new Pay_Payment('validName', $config);
        $result = $payment->getDate($paymentMonth);
        $this->assertEquals($paymentDate, $result); 	
	}

	/**
	 * Testing various date configs and testing for expected dates
	 * 
	 * @param string $payMonth
	 * @param string $weekendMove
	 * @param string $weekendDay
	 * @param string $payDate
	 * @param string $paymentDate
	 * @dataProvider paymentSetupAndExpectedDatesProvider
	 */
	public function testVariousPaymentSetupsReturnsExpectedPaymentDates(
	    $payMonth, $weekendMove, $weekendDay, $payDate, $paymentDate)
	{
        $config = $this->_config['Salary'];
        $config['weekend.allow'] = 'false';
        $config['weekend.move']  = $weekendMove;
        $config['weekend.day']   = $weekendDay;
        $config['paydate']       = $payDate;     
        $payment                 = new Pay_Payment('validName', $config);

        $result = $payment->getDate($payMonth);
        $this->assertEquals($paymentDate, $result); 	
    }
 
    // ------------------- Data providers from here ------------------- 

    /**
     * Provides not the required class type
     * 
     * @return array
     */
    public static function notRequiredClassProvider()
    {
        return Providers::notRequiredClassProvider();
    }

    /**
     * Provides not populated string
     * 
     * @return array
     */
    public static function notPopulatedStringProvider()
    {
    	return Providers::notPopulatedStringProvider();
    }

    /**
     * Provides 'not array'
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
        return Providers::notArrayProvider();    
    }

    /**
     * Returns key names to remove from config array
     * 
     * @return array
     */
    public static function missingConfigParameter()
    {
    	return array(
    	    array('paydate'), array('weekend.allow'), array('weekend.move'),
    	    array('weekend.day'), array('payshift'),
    	);
    }

    /**
     * Sets config keys to invalid values
     * 
     * @return array
     */
    public static function badParameterProvider()
    {
    	return array(
    	    array('weekend.move', 'never'),
    	    array('paydate', 200),
    	    array('paydate', 'beginning'),
    	    array('weekend.allow', 'notAtAll'),
    	    array('weekend.day', 'saturday'),
    	    array('payshift', 'two months'),
    	);
    }

    /**
     * Provides invalid date strings
     * 
     * @return array
     */
    public static function invalidDateStrings()
    {
    	$vals   = Providers::notPopulatedStringProvider();
    	$vals[] = array('fewofkpo');
    	$vals[] = array('2010-22');
    	$vals[] = array('20100-10');
    	$vals[] = array('2010-00');
    	return $vals;    	
    }
    
    /**
     * Provides date shifts
     * 
     * @return array
     */
    public static function dateShiftProvider()
    {
    	return array(
    	    array(-13, '2009-05-15'),
    	    array(-7, '2009-11-15'),
    	    array(-6, '2009-12-15'),
    	    array(-5, '2010-01-15'),
    	    array(-1, '2010-05-15'),
    	    array(0, '2010-06-15'),
    	    array(1, '2010-07-15'),
    	    array(5, '2010-11-15'),
    	    array(6, '2010-12-15'),
    	    array(7, '2011-01-15'),
    	    array(13, '2011-07-15'),
    	);
    }

    /**
     * Provider of non-weekend payment dates
     * 
     * @return array
     */
    public static function nonWeekendPaymentDatesProvider()
    {
    	return array(
    	    array('2010-01', '2010-01-15'),
    	    array('2010-02', '2010-02-15'),
    	    array('2010-03', '2010-03-15'),
    	    array('2010-04', '2010-04-15'),
    	);
    }

    /**
     * Various payment parameters and expected payment dates
     * 
     * array('year-month', 'before/after', 'new pay day', 
     *       'paydate', 'payment date')
     * e.g. First record:
     *    Payment date 15th of month, if on weekend pay the friday after for 
     *    May of 2010
     * 
     * @return array
     */
    public static function paymentSetupAndExpectedDatesProvider()
    {
    	return array(
    	    array('2010-05', 'after', 'friday', '15', '2010-05-21'),
    	    array('2010-08', 'after', 'friday', '15', '2010-08-20'),
    	    array('2011-01', 'after', 'friday', '15', '2011-01-21'),
    	    array('2010-05', 'before', 'wednesday', '15', '2010-05-12'),
    	    array('2010-08', 'before', 'wednesday', '15', '2010-08-11'),
    	    array('2011-01', 'before', 'wednesday', '15', '2011-01-12'),
            array('2010-02', 'after', 'friday', '28', '2010-03-05'),
            array('2010-03', 'after', 'friday', '28', '2010-04-02'),
            array('2010-08', 'after', 'friday', '28', '2010-09-03'),
            array('2010-02', 'before', 'wednesday', '28', '2010-02-24'),
            array('2010-03', 'before', 'wednesday', '28', '2010-03-24'),
            array('2010-08', 'before', 'wednesday', '28', '2010-08-25'),
            array('2010-01', 'before', 'monday', 'start', '2010-01-01'),
            array('2010-01', 'before', 'monday', 'end', '2010-01-25'),
            array('2010-04', 'before', 'tuesday', 'end', '2010-04-30'),
            array('2010-02', 'before', 'thursday', '30', '2010-02-25'),
            array('2010-08', 'before', 'tuesday', '28', '2010-08-24'),
    	);
    }
    
}