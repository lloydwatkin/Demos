<?php 
@include 'AppSetup.php';
require 'AbstractTag.php';
require 'BodyTag.php';

$tag = new Pro_View_Helper_BodyTag();
?>
<html>
<head>
    <title>Body/Abstract Zend View Helper Demo</title>
    <style>
	body.demo {
	    font-family: verdana;
	    font-size: 0.8em;
	}
	body.demo h1 {
	    font-size: 1.2em;
	}
	body.demo h3 {
	    font-size: 1em;
	    background-color: #EEEEEE;
	    padding: 0.6em;
	}
	body.demo h2 {
	    border-bottom: 0.05em #000000 dotted;
	    font-style: italic;
	    font-size: 0.9em;
	    padding-left: 5em;
	    padding-bottom: 0.5em;
	}
	body.demo dl {
		clear: both;
	}
	body.demo dl dd { 
		margin-left: 25.5em;
	}
	body.demo dl dt {
		float: left;
		width: 25em;
		background-color: AliceBlue;
	}
	body.demo p.note {
		border-left: 0.5em solid #0000FF;
		font-family: monospace;
		font-size: 1.2em;
		margin: 0.25em 0.25em 0.25em 0.2em;
		padding: 0.25em 0.25em 0.25em 0.5em;
    }
    body.demo span {
    	font-weight: bold;
    }
	</style>
</head>
<?php echo $tag->bodyTag('class', 'demo') . PHP_EOL ?>
<h1>Body/Abstract Tag View Helper for Zend Framework</h1>
<h2>by Steven Lloyd Watkin</h2>

<p>Adding an invalid attribute throws an exception. Valid attributes are set within the class.</p>
<p>This page uses the code to generate the body opening and closing tags. In order for the CSS to work the body
tag must have an attribute of <span>class</span> with the value <span>demo</span>. The code to achieve this is
as follows:</p>
<p class="note">
&lt;?php echo $tag->bodyTag('class', 'demo') . PHP_EOL ?&gt;<br/>
&lt;?php echo $tag->bodyTag()->toString(Pro_View_Helper_BodyTag::CLOSE) . PHP_EOL; ?&gt;
</p>
<p>For more information please visit 
<a href="http://www.evilprofessor.co.uk/311-zend-framework-body-tag-view-helper/" title="View helper for tags">
http://www.evilprofessor.co.uk/311-zend-framework-body-tag-view-helper/
</a>.
</p>

<h3>Plain tag</h3>
<dl>
<dt>&lt;body&gt;</dt>
<dd>echo $this->bodyTag()</dd>
<dd>echo $this->bodyTag()->toString()</dd>
<dd>echo $this->bodyTag()->toString(Pro_View_Helper_BodyTag::OPEN)</dd>
</dl>

<h3>Closing a tag</h3>
<dl>
<dt>&lt;/body&gt;</dt><dd>echo $this->bodyTag()->toString(Pro_View_Helper_BodyTag::CLOSE)</dd>
</dl>
<p class="note">If a tag is self closing (e.g. <span>&lt;img/&gt;</span>) then an empty string is returned</p>

<h3>Adding a attribute</h3>
<dl>
<dt>&lt;body style="nihilo"&gt;</dt>
<dd>echo $this->bodyTag('style', 'nihilo')</dd>
</dl>
<p class="note">To add multiple attribute values, repeat as required</p>
<dl>
<dt>&lt;body style="nihilo mystyle"&gt;</dt>
<dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('style', 'mystyle', false, ' ')</dd>
</dl>

<p class="note">If an attempt is made to apply the same attribute value multiple times the request is ignored</p>
<dl><dt>&lt;body style="nihilo"&gt;</dt><dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('style', 'nihilo')->bodyTag('style', 'nihilo')</dd></dl>

<p class="note">To replace an attrubute value simply set the <span>replace</span> parameter to true</p>
<dl><dt>&lt;body style="mystyle"&gt;</dt><dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('style', 'mystyle', true)</dd></dl>

<h3>Attribute value separator</h3>
<dl>
<dt>&lt;body style="nihilo; mystyle"&gt;</dt><dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('style', 'mystyle', false, ';')</dd>
</dl>
<p class="note">By default the separator is a space.</p>

<h3>Adding multiple attributes</h3>
<dl>
<dt>&lt;body style="nihilo" onload="alert('hello')"&gt;</dt><dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('onload', "alert('hello')")</dd>
</dl>
<p class="note">If user attempts to use a double quote (") in a attribute value it must escaped.</p>

<h3>Clearing an attribute</h3>

<dl><dt>&lt;body&gt;</dt><dd>echo $this->bodyTag('style', 'nihilo')->bodyTag('style')</dd></dl>

<?php echo $tag->bodyTag()->toString(Pro_View_Helper_BodyTag::CLOSE) . PHP_EOL; ?>
</html>