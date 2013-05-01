<?php
// 2013 by e-Learning Center

define('DEFAULT_CHARSET','utf-8');

ini_set('display_errors','On');
ini_set('error_reporting', 'E_ALL');

//
require_once(dirname(dirname(__FILE__)) . '/config.php');

header('Content-Type: application/json'."\n");

$vars = explode('&', $_SERVER["QUERY_STRING"]) ;

// 


$first = 1 ;
print "{\n" ;
foreach ($vars as $line) {
	$var = explode('=', $line) ;
	if ($course = $DB->get_record('course', array('shortname'=>$var[1]), '*', IGNORE_MISSING)) {
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
