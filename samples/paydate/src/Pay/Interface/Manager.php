<?php
/**
 * Reads payment configs and calculates payment dates - Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage manager
 */

/**
 * Reads payment configs and calculates payment dates - Interface
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage manager
 */
interface Pay_Interface_Manager
{
    /**
     * Set a 'payment' type
     * 
     * @param  Pay_Interface_Payment $type
     * @return PaymentCalculator Provides a fluent interface
     */
    public function addType(Pay_Interface_Payment $type);

	/**
	 * Sets results data transfer object (DTO) that will be used
	 * 
	 * @param Pay_Dto_Results $dto
	 * @return PaymentCalculator Provides a fluent interface
	 */
	public function setDto(Pay_Dto_Results $dto);

	/**
	 * Returns payment dates to caller
	 * 
	 * @param string $startDate Date to start calculating payments YYYY-MM
	 * @param string $endDate Date to stop calculating payments YYYY-MM
	 * @return Results
	 */
	public function getDates($startDate = null, $endDate = null);
}