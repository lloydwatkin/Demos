<?php
/**
 * str_replace extended to replace outside of HTML tags
 * 
 * @param  mixed  $find
 * @param  mixed  $replace
 * @param  string $input
 * @return string
 */
function str_replace_ignore_tags($find, $replace, $input, &$count = NULL)
{
    if (false === strpos($input, '<')) {
        return str_replace($find, $replace, $input, $count);
    }
    // There is HTML in string
    $stringLength = strlen($input);
    $stringParts  = array();
    $parts        = preg_split(
        '/([\<\>])/',
        $input,
        -1,
        PREG_SPLIT_DELIM_CAPTURE
    );
    $isTag  = ('<' === $input[0]);
    $output = '';
    foreach ($parts as $part) {
        if (false === $isTag) {
            $part = str_replace($find, $replace, $part, $count);
        }
        if ('<' === $part) {
            $isTag = true;
        } elseif ('>' === $part) {
            $isTag = false;
        }
        $output .= $part;
    }
    return $output;
}