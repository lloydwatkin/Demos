<?php
/**
 * Observer Design Pattern Example
 *  
 * @author Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since 2009/12/23
 * @link http://www.evilprofessor.co.uk
 */
include 'observers.php';
include 'subject.php';

if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    echo '<pre>';
}

// What are we doing?
echo 'Observer Pattern Example in PHP' . PHP_EOL;
echo '================================' . PHP_EOL;
// Set up our subject
$subject = new ArticleAggregator();
echo ' - ArticleAggregator created' . PHP_EOL;

// Add some observers
$subject->addObserver( new NewsObserver() );
$subject->addObserver( $gossiper = new GossipObserver() );

echo ' - Added NewsObverser & GossipObserver' . 
	 PHP_EOL . PHP_EOL;

// Beep, beep, beep... News Flash!
echo 'NewsFlash: celebrity rugby player loves finance' . PHP_EOL;
echo '================================================' . PHP_EOL;
$subject->addNewsStory('celebrity rugby player loves finance');
echo PHP_EOL;

echo ' - SportObserver has found out and wants to join the group!';
$subject->addObserver( new SportObserver() );
echo PHP_EOL . PHP_EOL;

// Beep, beep, beep... News Flash!
echo 'NewsFlash: government messes up again!' . PHP_EOL;
echo '=======================================' . PHP_EOL;
$subject->addNewsStory('government messes up again!');
echo PHP_EOL;

// Beep, beep, beep... News Flash!
echo 'NewsFlash: fashion and football combine' . PHP_EOL;
echo '=======================================' . PHP_EOL;
$subject->addNewsStory('fashion and football combine');
echo PHP_EOL;

// Beep, beep, beep... News Flash!
echo 'NewsFlash: music and politics, what next?' . PHP_EOL;
echo '==========================================' . PHP_EOL;
$subject->addNewsStory('music and politics, what next?');
echo PHP_EOL;

/**
 * Gossipers grow tired of news very quickly and have decided
 * to stop listening, despite all the interesting news today!
 */
echo ' - GossipObserver is bored and leaves the group!' . 
     PHP_EOL . PHP_EOL;
$subject->removeObserver( $gossiper );

// Beep, beep, beep... News Flash - Update to an earlier story!
echo 'NewsUpdate: fashion and football combine says ' .
     'government' . PHP_EOL;
echo '================================================' . 
     '=========' . PHP_EOL;
$subject->addNewsStory( 'fashion and football combine ' .
                        'says government' );
echo PHP_EOL;

if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    echo '</pre>';
}
