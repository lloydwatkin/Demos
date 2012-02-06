<?php
/**
 * Test cases for the 'Manager' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage manager
 */

/**
 * Test cases for the 'Manager' object
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    tests
 * @subpackage manager
 */
class Pay_ManagerTest 
    extends PHPUnit_Framework_TestCase
{
	/**
	 * Holds the manager object
	 * 
	 * @var Pay_Manager
	 */
	private $manager;

    /**
     * Prepares the environment before running a test.
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->manager = new Pay_Manager();
        $this->manager->setDto(new Pay_Dto_Results());              
    }
    
    /**
     * Add payment type mock to manager
     * 
     * @return void
     */
    protected function _getPaymentTypeMock()
    {
    	$paymentMock = new PaymentMock('', array());
        return $paymentMock;
    }

    /**
     * Cleans up the environment after running a test.
     * 
     * @return void
     */
    protected function tearDown()
    {
        $this->manager = null;
        parent::tearDown();
    }

    /**
     * Test that the manger model is an instance of the interface
     * 
     * @return void
     */
    public function testInstantiatedModelIsOfCorrectType()
    {
    	$this->assertTrue($this->manager instanceof Pay_Interface_Manager);
    }

    /**
     * Passing not correct object to addType() method throws PHP error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notRequiredClassProvider
     * @param mixed $var
     */
    public function tesPassingNotCorrectObjectToAddTypeThrowsError($var)
    {
    	$this->manager->addType($var);
    }

    /**
     * Can add a valid payment type
     * 
     * @return void
     */
    public function testPassingValidPaymentTypeObjectReturnsThis()
    {
        $mock = $this->_getPaymentTypeMock();
        $manager = $this->manager->addType($mock);
        
        $this->assertTrue($manager instanceof Pay_Interface_Manager);
    }
    
    /**
     * Attempting to set invalid Dto throws Error
     * 
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider notRequiredClassProvider
     * @param mixed $var
     */
    public function testProvidingInvalidDtoThrowsError($var)
    {
    	$this->manager->setDto($var);
    }

    /**
     * Setting a valid Dto returns instance of $this
     * 
     * @return void
     */
    public function testSettingValidDtoReturnsInstanceOfObject()
    {
    	// The results dto is very simple so we'll use it here
    	$dto = new Pay_Dto_Results();
    	$manager = $this->manager->setDto($dto);

    	$this->assertTrue($manager instanceof Pay_Interface_Manager);
    }

    /**
     * Attempting to get data without setting valid Dto throws exception
     * 
     * @expectedException Pay_Exception
     * @return void
     */
    public function testAttemptingToGetResultsWithoutSettingDtoThrowsException()
    {
    	$this->manager = new Pay_Manager();
    	$this->manager->getDates();
    }

    /**
     * Requesting two months of results returns two results sets
     * 
     * @return void
     */
    public function testRequestingTwoMonthsOfResultsReturnsTwoResults()
    {
    	$results = $this->manager->getDates('2010-01', '2010-02');
    	$this->assertEquals(2, count($results));
    }
    
    /**
     * Setting bad start date uses current month/year
     * 
     * @return void
     */
    public function testPassingBadStartMonthYearUsesCurrentMonthYear()
    {
        $results = $this->manager->getDates('notValid', date('Y-m'));
        $this->assertEquals(1, count($results));
    }

    /**
     * Setting bad end date uses december of current year
     * 
     * @return void
     */
    public function testPassingBadEndMonthYearUsesDecemberOfCurrentYear()
    {
        $results = $this->manager->getDates(date('Y') . '-10', 'notValid');
        $this->assertEquals(3, count($results));
    }

    /**
     * Setting a start date after end date sets end date to same as start date
     * 
     * @return void
     */
    public function testPassingStartDateAfterEndDateSetsEndDateToStartDate()
    {
    	$startDate = ((int) date('Y') + 1) . '-11';
        $results = $this->manager->getDates($startDate, date('Y-m'));
        $this->assertEquals(1, count($results));
    }

    /**
     * Test results are an instance of the results Dto
     * 
     * @return void
     */
    public function testResultsAreInstanceOfResultsDto()
    {
    	$this->assertTrue(
    	    $this->manager->getDates('2010-03', '2010-03') 
    	    instanceof Pay_Dto_Results
    	);
    }

    /**
     * Setting month numerically returns expected text month name
     * 
     * @return void
     */
    public function testSettingNumericalMonthReturnsExpectedStringResponse()
    {
    	$results = $this->manager->getDates('2010-03', '2010-03');
    	$month   = $results->current();
    	$this->assertEquals('March 2010', $month[0]); 	
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
     * Provides 'not array'
     * 
     * @return array
     */
    public static function notArrayProvider()
    {
        return Providers::notArrayProvider();    
    }
}