<?php
/**
 * Reads payment configs and calculates payment dates
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage manager
 */

/**
 * Reads payment configs and calculates payment dates
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      06/03/2010
 * @package    pay
 * @subpackage manager
 */
class Pay_Manager
    implements Pay_Interface_Manager
{
    /**
     * Error messages
     */
    const NO_CONFIG  = 'No configuration information has been provided';
    const BAD_CONFIG = 'Bad payment configuration data has been passed';
    const NO_DTO_SET = 'No DTO has been set';

    /**
     * Holds payment objects
     * 
     * @var array
     */
    protected $_payments = array();

    /**
     * Holds the results data transfer object (DTO)
     * 
     * @var Results
     */
    protected $_dto;

    /**
     * Holds valid date reg ex (YYYY-MM)
     * 
     * @var string
     */
    protected $_dateRegEx = '/^[1-2][0-9]{3}-(0?[1-9]|1[012])$/';

    /**
     * Set a 'payment' type
     * 
     * @param  Pay_Interface_Payment $type
     * @return PaymentCalculator Provides a fluent interface
     */
    public function addType(Pay_Interface_Payment $type)
    {
        $this->_payments[] = $type;
        return $this;
    }

    /**
     * Sets results data transfer object (DTO) that will be used
     * 
     * @param Pay_Dto_Results $dto
     * @return PaymentCalculator Provides a fluent interface
     */
    public function setDto(Pay_Dto_Results $dto)
    {
        $this->_dto = $dto;
        return $this;
    }
    
    /**
     * Get the results DTO object
     * 
     * @return Results
     * @throws Exception If results object not set
     */
    protected function _getDto()
    {
        if (is_null($this->_dto)) {
            throw new Pay_Exception(self::NO_DTO_SET);
        }
        return $this->_dto;
    }

    /**
     * Returns payment dates to caller
     * 
     * @param string $startDate Date to start calculating payments YYYY-MM
     * @param string $endDate Date to stop calculating payments YYYY-MM
     * @return Results
     */
    public function getDates($startDate = null, $endDate = null)
    {
        if (is_null($startDate) || !preg_match($this->_dateRegEx, $startDate)) {
            $startDate = date('Y-m');
        }
        if (is_null($endDate) || !preg_match($this->_dateRegEx, $endDate)) {
            $endDate = date('Y') . '-12';
        }
        if ($startDate > $endDate) {
            $endDate = $startDate;
        }
        // Loop over time period and add dates to the results DTO
        while ($startDate <= $endDate) {            
            $result = array();
            $result[] = $this->_getMonthName($startDate);
            foreach ($this->_payments AS $payment) {
                $result[] = $payment->getDate($startDate);
            }
            $startDate = $this->_addMonth($startDate);
            $this->_getDto()->add($result);
        }
        return $this->_getDto();
    }

    /** 
     * Add a month to the passed date
     * 
     * @param string $date
     * @return string
     */
    protected function _addMonth($date)
    {
        $date = explode('-', $date);
        if (12 == $date[1]) {
            ++$date[0];
            $date[1] = '01';
        } else {
            ++$date[1];            
        }
        return "{$date[0]}-" . str_pad($date[1], 2, '0', STR_PAD_LEFT);
    }

    /**
     * Return formatted string of month name
     * 
     * @param  string $date Format: YYYY-MM
     * @return string Format example January 2010
     */
    protected function _getMonthName($date)
    {
        $date = explode('-', $date);
        return date('F Y', mktime(0, 0, 0, $date[1], 1, $date[0]));
    }
}