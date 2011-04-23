<?php
/**
 * Auth adapter for Oauth
 * 
 * @author     Lloyd  Watkin <lloyd@evilprofessor.co.uk>
 * @since      22/04/2011
 * @package    Pro
 * @subpackage Auth
 */

/**
 * Auth adapter for Oauth
 * 
 * @author     Lloyd  Watkin <lloyd@evilprofessor.co.uk>
 * @since      22/04/2011
 * @package    Pro
 * @subpackage Auth
 */
class Pro_Auth_Adapter_Oauth
    implements Zend_Auth_Adapter_Interface
{
	/**
	 * Error messages
	 * 
	 * @var string
	 */
	const INVALID_PARAMETER_KEY_NAME = 'Invalid parameter key name';
	const INVALID_PARAMETER_VALUE    = 'Invalid parameter value';

	/**
	 * Authentication namespace
	 * 
	 * @var string
	 */
	const AUTH_NAMESPACE = 'Zend_Auth';

	/**
	 * Oauth consumer
	 * 
	 * @var Zend_Oauth_Consumer
	 */
	protected $_consumer;

	/**
	 * Stores session object
	 * 
	 * @var Zend_Session_Abstract
	 */
	protected $_session;

	/**
	 * Stores additional parameters for oauth request
	 * 
	 * @var array
	 */
	protected $_parameters;

	/**
	 * Login URI
	 * 
	 * @var string
	 */
	protected $_loginUri;

	/**
	 * Constructor
	 * 
	 * @param  Zend_Oauth_Consumer $consumer
	 * @param  Zend_Session_Abstract $session
	 */
	public function __construct(Zend_Oauth_Consumer $consumer = null,
	    Zend_Session_Abstract $session = null)
	{
		$this->_consumer = $consumer;
		$this->_session  = $session;
	}

    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        if (NULL === $this->_session->requestToken) {
        	$this->_redirectForAuthentication();
        } 
        return $this->_authentication();
    }

    /**
     * Redirect to twitter for authentication
     *
     */
    protected function _redirectForAuthentication()
    {
        $token                        = $this->_consumer->getRequestToken();
        $this->_session->requestToken = serialize($token);
        $params                       = array();
        $this->_consumer->redirect($this->_parameters);
        die('Redirecting...');
    }

    /**
     * Confirm response from twitter
     * 
     * @return Zend_Auth_Result
     */
    protected function _authentication()
    {
        $params = Zend_Controller_Front::getInstance()
            ->getRequest()
            ->getParams(); 
        $unserialisedRequestToken = unserialize($this->_session->requestToken);
        unset($this->_session->requestToken);
        
        if (0 === count($params)) {
        	return $this->_uncategorisedFailure();
        }
        if (isset($params['denied'])) {
        	return $this->_deniedAccess();
        }

        $token = $this->_consumer->getAccessToken(
           $params,
           $unserialisedRequestToken
        );
        $this->_session->accessToken = serialize($token);

        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS,
            $token
        );
    }

    /**
     * Generate an uncategorised authentication failure
     * 
     * @return Zend_Auth_Result
     */
    protected function _uncategorisedFailure()
    {
        return new Zend_Auth_Result(
            Zend_Auth_Result::FAILURE_UNCATEGORIZED,
            array()
        );
    }

    /**
     * Response for user denying the application access
     * 
     * @return Zend_Auth_Result
     */
    protected function _deniedAccess()
    {
        return new Zend_Auth_Result(
            Zend_Auth_Result::FAILURE,
            array(),
            array('User denied access')
        );
    }

    /**
     * Set parameters
     * 
     * @param  array $parameters
     * @return $this *Provides a fluent interface*
     */
    public function setParameters(array $parameters)
    {
    	foreach ($parameters as $key => $value) {
    		$this->addParameter($key, $value);
    	}
    	return $this;
    }

    /**
     * Add a single parameter
     * 
     * @param  string $key
     * @param  string $value
     * @return $this *Provides a fluent interface*
     * @throws InvalidArgumentException
     */
    public function addParameter($key, $value)
    {
    	if (!is_string($key) || empty($key)) {
    		throw new InvalidArgumentException(self::INVALID_PARAMETER_KEY_NAME);
    	}
        if (!is_string($key) || empty($key)) {
            throw new InvalidArgumentException(self::INVALID_PARAMETER_VALUE);
        }
    }

    /**
     * Clear parameters
     * 
     * @return $this *Provides a fluent interface*
     */
    public function clearParameters()
    {
    	$this->_parameters = array();
    	return $this;
    }    
}
