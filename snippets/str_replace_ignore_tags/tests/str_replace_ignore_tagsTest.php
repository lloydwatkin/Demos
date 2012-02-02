<?php
/**
 * Test for function str_replace_ignore_tags function
 * 
 * @author     Lloyd Watkin <lloyd@evilprofessor.co.uk>
 * @since      25/01/2012
 */
class str_replace_ignore_tagsTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Setup function - includes function str_replace_ignore_tags
     */
    public function setup()
    {
        if (false === function_exists('str_replace_ignore_tags')) {
            include dirname(__FILE__) . '/../str_replace_ignore_tags.php';
        }
    }

    /**
     * Ensure that if there is no HTML in the string we get back the original 
     * string no replacements to be made
     */
    public function testPassingStringWithNoHtmlReturnsOriginalString()
    {
        $input  = 'no html in this string';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame($input, $output);
    }

    /**
     * Test that a string containg replacements is replaced correctly
     */
    public function testPassingStringWithNoHtmlButReplacementsReturnsAsExpected()
    {
        $input  = 'time to replace the foo in bar';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame(str_replace('foo', 'bar', $input), $output);
    }

    /**
     * Ensure that we don't modify HTML tags
     */
    public function testHtmlTagsAreNotModified()
    {
        $input  = 'no <foo>html</foo>';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame('no <foo>html</foo>', $output);
    }

    /**
     * Test that multiple replacements are made
     */
    public function testMultipleReplacementsCanBeMade()
    {
        $input  = '<p>foo foo <strong>foo</strong></p>';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame('<p>bar bar <strong>bar</strong></p>', $output);
    }

    /**
     * Test that HTML attributes aren't replaced
     */
    public function testHtmlTagAttributesAreNotReplaced()
    {
        $input = '<br foo="blah" />';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame($input, $output);
    }

    /**
     * Test that HTML attribute values aren't replaced
     */
    public function testHtmlTagAttributeValuesAreNotReplaced()
    {
        $input = '<p class="foo">some text</p>';
        $output = str_replace_ignore_tags('foo', 'bar', $input);
        $this->assertSame($input, $output);
    }

    /**
     * A more complicated string returns as expected
     */
    public function testMoreComplexHtmlStringReplacesAsExpected()
    {
        $input = <<<EOI
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<title>My nice page title</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
<meta http-equiv="content-language" content="en" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" href="css.css" type="text/css" media="screen" title="no title" charset="utf-8" /> <!-- <<< link to external css file -->
</head> 
<body>
    <h1>This is a h1 title</h1>
    <p>This is some content, sandwiched between two &lt;p&gt; tags. It is contained within the head tags.</p>
    <h2>This is a h2 tag</h2>
    <p style="second paragraph">This second paragraph has style</p>
</body>
</html>
EOI;
        $expectedOutput = <<<EOEO
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<title>My terrible page title</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
<meta http-equiv="content-language" content="en" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" href="css.css" type="text/css" media="screen" title="no title" charset="utf-8" /> <!-- <<< link to external css file -->
</head> 
<body>
    <h1>This is a strong title</h1>
    <p>This is some writing, sandwiched between two &lt;p&gt; tags. It is contained within the body tags.</p>
    <h2>This is a h2 tag</h2>
    <p style="second paragraph">This fourth line has style</p>
</body>
</html>
EOEO;
        $replacements = array(
            'second paragraph' => 'fourth line',
            'nice'             => 'terrible',
            'content'          => 'writing',
            'h1'               => 'strong',
            '<h2>'             => '<h1>',
            'head'             => 'body',
        );
        $output = str_replace_ignore_tags(
            array_keys($replacements),
            $replacements,
            $input
        );
        $this->assertSame($expectedOutput, $output);

    }
}