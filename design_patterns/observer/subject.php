<?php 
/**
 * This file contains the subject
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */

abstract class Subject
{
	abstract public function addObserver(Observer $observer);
	abstract public function removeObserver(Observer $observer);
	abstract public function updateObservers( $newsHeadline );
}

/**
 * This is the subject class for the example
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */
class ArticleAggregator extends Subject
{
	/**
	 * Holds a list of our observers
	 * 
	 * @var array
	 */
	protected $_observerList = array();
	
	/**
	 * Method to add an observer
	 * 
	 * @var Observer $observer
	 * @return void
	 */
	public function addObserver(Observer $observer)
	{
		$this->_observerList[] = $observer;
	}
	
	/**
	 * Method to remove an observer
	 * 
	 * @var Observer $observer
	 * @return boolean
	 */
	public function removeObserver(Observer $observer)
	{
		foreach ($this->_observerList AS $key => $ob) {
			if ($ob == $observer) {
				unset($this->_observerList[$key]);
				return true;
			}			
		}
		return false;
	}
	
	/**
	 * Method to update observers
	 * 
	 * @var string $newsHeadline
	 * @return void
	 */
	public function updateObservers( $newsHeadline )
	{
		foreach ($this->_observerList AS $ob) {
			$ob->update( $newsHeadline );
		}
	}
	
	/**
	 * Add a new news story
	 * 
	 * @var string $story
	 * @return void
	 */
	public function addNewsStory( $story )
	{
		if ( empty( $story ) || !is_string( $story) ) {
			throw new InvalidArgumentException('Expected a news story!');
		}
		$this->updateObservers( $story );
	}
}