<?php

define('AJAX_SCRIPT', true);
define('NO_MOODLE_COOKIES', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/mod/mediasite/utility.php");

$sid = required_param('sid', PARAM_INT);
global $DB;
try {
    $record = $DB->get_record('mediasite_status', array('sessionid' => $sid), 'id,processed,status', MUST_EXIST);
    if($record) {
        if($record->processed) {
            echo $record->status;
        } else {
            $status = json_decode($record->status);
            $status->processed = 0;
            $record->processed = 1;
            unset($record->status);
            $DB->update_record('mediasite_status', $record);
            echo json_encode($status);
        }
        Sonicfoundry\http_response_code_by_version(200, 'OK');
    } else {
        echo 'Not found';
        Sonicfoundry\http_response_code_by_version(404, 'Not Found');
    }
} catch(Exception $e) {
    $record = new stdClass();
    $record->operation = 'Starting';
    $record->count = 0;
    $record->elapsed = 0;
    echo json_encode($record);
    Sonicfoundry\http_response_code_by_version(200, 'OK');
}

