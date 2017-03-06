<?php

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');

$siteid = required_param('siteid', PARAM_INT);

global $DB;

$record = $DB->get_record('mediasite_sites', array('id' => $siteid));
if($record) {
    echo $record->siteclient;
} else {
    echo 'unknown';
}
