<?php
/**
 * View helper to render a view file if it exists
 * 
 * @author     Lloyd Watkin
 * @since      12/12/2010
 * @package    Pro
 * @subpackage View
 */

/**
 * View helper to render a view file if it exists
 * 
 * @author     Lloyd Watkin
 * @since      12/12/2010
 * @package    Pro
 * @subpackage View
 */
class Pro_View_Helper_RenderIfExists
    extends Zend_View_Helper_Abstract
{
    /**
     * Errors 
     * 
     * @var string
     */
    const INVALID_FILE = 'Invalid file parameter';

    /**
     * Holds file name for processing
     * 
     * @var string
     */
    protected $_file;

    /**
     * Takes a products options array and converts to a formatted string
     * 
     * @param  string $file
     * @return string
     */
    public function renderIfExists($file)
    {
        if (!is_string($file) || empty($file)) {
            throw new Zend_View_Exception(self::INVALID_FILE);
        }
        $this->_file = $file;
        if (false === $this->_fileExists()) {
            return '';
        }
        return $this->view->render($file);
    }

    /**
     * Check to see if a view script exists
     * 
     * @return boolean
     */
    protected function _fileExists()
    {
        $paths = $this->view->getScriptPaths();
        foreach ($paths as $path) {
            if (file_exists($path . $this->_file)) {
                return true;
            }
        }
        return false;
    }
}