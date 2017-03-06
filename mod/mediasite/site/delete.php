<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$siteid = required_param('site', PARAM_INT);          // site

global $DB;
$defaultId = $DB->get_field('mediasite_config', 'siteid', array());

//Check if the server to be deleted is the default one.
//If so, set the first server in table 'mediasite_sites' to be default.
if ($defaultId == $siteid) {
    $DB->delete_records('mediasite_sites', array('id'=>$siteid));
    $DB->delete_records('mediasite_config', array('siteid'=>$siteid));
    
    $sites = array_values($DB->get_records('mediasite_sites', array()));
    if($sites == null) 
        redirect("configuration.php");
    $site = $sites[0];  
    $record = new \stdClass();
    $record->siteid = $site->id;
    $record->openaspopup = 1;
    $record->duration = 300;
    $record->restrictip = 0;
    $DB->insert_record('mediasite_config', $record);
} else {
    $DB->delete_records('mediasite_sites', array('id'=>$siteid));
}
// Go home
redirect("configuration.php");