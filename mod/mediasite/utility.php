<?php

namespace Sonicfoundry;

function EndsWith($str, $needle)
{
    $length = strlen($needle);
    return !$length || substr($str, - $length) === $needle;
}
function StartsWith($str, $needle)
{
    return substr($str, 0, strlen($needle)) === $needle;
}
function substr_unicode($str, $s, $l = null)
{
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}

function http_response_code_by_version($code, $description) {
    if(version_compare(phpversion(), '5.4', '>')) {
        http_response_code($code);
    } else if(version_compare(phpversion(), '4.3', '>')) {
        header('X-PHP-Response-Code: '.$code, true, $code);
    } else {
        $sapi_type = php_sapi_name();
        if (substr($sapi_type, 0, 3) == 'cgi')
            header('Status: '.$code.' '.$description);
        else
            header('HTTP/1.1 '.$code.' '.$description);
    }
}
//$array = [0=>'a', 1=>'c', 2=>'d', 3=>'b', 4=>'e'];
//moveElement($array, 3, 1);
//[0=>'a', 1=>'b', 2=>'c', 3=>'d', 4=>'e'];
function moveElement(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}
