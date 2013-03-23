<?php
// 2012/05/07 by e-Learning

define('DEFAULT_CHARSET','utf-8');

ini_set('display_errors','On');
ini_set('error_reporting', 'E_ALL');

//Moodleのコンフィグファイルを拝借
require_once(dirname(dirname(__FILE__)) . '/config.php');

header('Content-Type: application/json'."\n");

$vars = explode('&', $_SERVER["QUERY_STRING"]) ;

$first = 1 ;
print "{\n" ;
foreach ($vars as $line) {
	$var = explode('=', $line) ;
	if ($course = get_record('course', 'shortname', addslashes($var[1]), '', '', '', '', 'id, shortname, defaultrole')) {
		if ( !($first) ) {
			print ",\n" ;
		} else {
			$first = 0 ;
		} ;
		print '"' . $var[1] . '":"' . $course->id  . '"';
	} ;
} ;
print "\n}\n" ;

?>
