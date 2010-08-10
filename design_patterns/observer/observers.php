<?php
/**
 * This file contains the observers
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */
interface Observer
{
	public function update( $newsHeadline );
}

/**
 * News Observer Class
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */
class NewsObserver implements Observer
{
	/**
	 * News feed only want to pick up stories mentioning
	 * politics, finance, or government
	 * 
	 * @var array
	 */
    protected $_gather = array( 'politics', 'finance', 'government');

	/**
	 * Implement the update function
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	public function update( $newsStory )
	{
		$keepStory = false;
		foreach ($this->_gather AS $gather) {
		    if (false !== strpos($newsStory, $gather)) {
		    	$keepStory = true;
		    }
		}
		if (true === $keepStory) {
			$this->writeStory( $newsStory );
		}
	}
	
	/**
	 * Write out the news story
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	private function writeStory( $newsStory )
	{
		echo 'NewsObserver finds: ' . $newsStory . PHP_EOL;
	}
}

/**
 * Sport Observer Class
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */
class SportObserver implements Observer
{
	/**
	 * News feed only want to pick up stories mentioning
	 * rugby, football, tennis
	 * 
	 * @var array
	 * @return void
	 */
    protected $_gather = array( 'rugby', 'football', 'tennis');

	/**
	 * Implement the update function
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	public function update( $newsStory )
	{
		$keepStory = false;
		foreach ($this->_gather AS $gather) {
		    if (false !== strpos($newsStory, $gather)) {
		    	$keepStory = true;
		    }
		}
		if (true === $keepStory) {
			$this->writeStory( $newsStory );
		}
	}
	
	/**
	 * Write out the news story
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	private function writeStory( $newsStory )
	{
		echo 'SportObserver finds: ' . $newsStory . PHP_EOL;
	}
}

/**
 * Gossip Observer Class
 * 
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 */
class GossipObserver implements Observer
{
	/**
	 * News feed only want to pick up stories mentioning
	 * celebrity, music, fashion
	 * 
	 * @var array
	 */
    protected $_gather = array( 'celebrity', 'music', 'fashion');
    
	/**
	 * Implement the update function
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	public function update( $newsStory )
	{
		$keepStory = false;
		foreach ($this->_gather AS $gather) {
		    if (false !== strpos($newsStory, $gather)) {
		    	$keepStory = true;
		    }
		}
		if (true === $keepStory) {
			$this->writeStory( $newsStory );
		}
	}
	
	/**
	 * Write out the news story
	 * 
	 * @var string $newsStory
	 * @return void
	 */
	private function writeStory( $newsStory )
	{		
		echo 'GossipObserver finds: ' . $newsStory . PHP_EOL;
	}
}