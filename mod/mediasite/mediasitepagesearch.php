<?php

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/mod/mediasite/locallib.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/searchoptions.php");

$sessionid = required_param('sid', PARAM_TEXT);
$courseid = required_param('course', PARAM_INT);
$siteid = required_param('site', PARAM_INT);
$searchtext = required_param('search', PARAM_TEXT);
$resourcetype = required_param('type', PARAM_TEXT);
$top = required_param('top', PARAM_INT);
$skip = required_param('skip', PARAM_INT);

require_login();
$context = context_course::instance($courseid);
$PAGE->set_context($context);

        $results = array();
        $total = -1;
        $next = mediasite_page_search($siteid, $searchtext, $resourcetype, $results, $total, $top, $skip);

echo json_encode($results);
