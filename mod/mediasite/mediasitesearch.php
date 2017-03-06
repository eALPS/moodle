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

$until  = optional_param('until', '', PARAM_TEXT);
$untilselect = optional_param('untilselect', 0, PARAM_BOOL);
$after  = optional_param('after', '', PARAM_TEXT);
$afterselect = optional_param('afterselect', 0, PARAM_BOOL);

$name  = optional_param('name', 0, PARAM_BOOL);
$description  = optional_param('description', 0, PARAM_BOOL);
$tag  = optional_param('tag', 0, PARAM_BOOL);
$presenter  = optional_param('presenter', 0, PARAM_BOOL);

require_login();
$context = context_course::instance($courseid);
$PAGE->set_context($context);

$searchoptions = new Sonicfoundry\SearchOptions();
$searchoptions->Session = $sessionid;
$searchoptions->Course = $courseid;
$searchoptions->Site = $siteid;

if(isset($after) &&
   !empty($after) &&
   isset($afterselect) &&
   $afterselect) {
    $searchoptions->After = true;
    $searchoptions->AfterDate = $after;
} else {
    $searchoptions->After = false;
    $searchoptions->AfterDate = null;
}
if(isset($until) &&
   !empty($until) &&
   isset($untilselect) &&
   $untilselect) {
    $searchoptions->Until = true;
    $searchoptions->UntilDate = $until;
} else {
    $searchoptions->Until = false;
    $searchoptions->UntilDate = null;
}
if(isset($name) && $name) {
    $searchoptions->Name = true;
} else {
    $searchoptions->Name = false;
}
if(isset($description) && $description) {
    $searchoptions->Description = true;
} else {
    $searchoptions->Description = false;
}
if(isset($tag) && $tag) {
    $searchoptions->Tag = true;
} else {
    $searchoptions->Tag = false;
}
if(isset($presenter) && $presenter) {
    $searchoptions->Presenter = true;
} else {
    $searchoptions->Presenter = false;
}
$searchoptions->SearchText = urlencode($searchtext);
$searchoptions->ResourceType = $resourcetype;

    try {
        $results = array();
        $total = -1;
        $truncated = mediasite_search($siteid, $searchoptions, $results, $total);
        $a = new stdClass();
        $a->count = count($results);
        $a->type = $resourcetype . ((count($results) > 1 || count($results) == 0) ? get_string('plural', 'mediasite') : '');

        $table = html_writer::tag('h1', get_string('searchresultheader', 'mediasite', $a), array('class' => 'sofo-search-results-header',
            'id' => 'id_search_results_header'));
        if($truncated) {
            $table .= html_writer::tag('h1', get_string('searchtruncated', 'mediasite'), array('class' => 'sofo-truncated-search-results-notification'));
        }
        $table .= html_writer::start_tag('ul',array('class' => 'sofo-search-results',
            'id' => 'id_search_results'));
        if(count($results) > 0) {
            foreach($results as $result) {
                $table .= html_writer::start_tag('li', array('class' => 'sofo-search-result-item'));
                $table .= get_result_item($result, $resourcetype, $siteid);
                $table .= html_writer::end_tag('li');
            }
        } else {
            $table .= html_writer::tag('span', get_string('searchnoresult','mediasite'));
        }
        $table .= html_writer::end_tag('ul');
    } catch(\Sonicfoundry\SonicfoundryException $se) {
        $table = html_writer::tag('h1', $se->getMessage(), array('class' => 'sofo-search-exception-header',
            'id' => 'id_search_results_header'));
    } catch(Exception $e) {
        $table = html_writer::tag('h1', $e->getMessage(), array('class' => 'sofo-search-exception-header',
            'id' => 'id_search_results_header'));
    }

    echo html_writer::tag('div', $table);

function get_result_item($result, $resourcetype, $siteid) {
    if($resourcetype != get_string('presentation', 'mediasite') &&
        $resourcetype != get_string('catalog', 'mediasite')) {
        throw new \Sonicfoundry\SonicfoundryException("Invalid resource type $resourcetype", \Sonicfoundry\SonicfoundryException::INVALID_RESOURCE_TYPE);
    }
    $escapedname = str_replace("'","\'",$result->Name);
    global $OUTPUT;
    $link = html_writer::tag('img', '',
        array('src'=>$OUTPUT->pix_url('t/backup'),
              'alt' => get_string('selectresource', 'mediasite'),
              'class' => 'selectresource',
              'name' => $escapedname,
              'resource' => $result->Id,
              'type' => $resourcetype,
              'site' => $siteid));
    $expandlink = html_writer::tag('img', html_writer::tag('span', format_string($result->Name), array('class' => 'sofo-title')),
        array('src'=>$OUTPUT->pix_url('t/collapsed'),
              'alt' => get_string('expandresource', 'mediasite'),
              'class'=>'expandresource',
              'resource' => $result->Id,
              'type' => $resourcetype,
              'site' => $siteid));
     $previewlink = html_writer::tag('img', '',
         array('src'=>$OUTPUT->pix_url('f/video'),
        'class'=> 'previewresource',
        'site' => $siteid,
        'resource' => $result->Id,
        'type' => $resourcetype));
    return html_writer::tag('div', $link . $expandlink . html_writer::tag('div', '', array('class' => 'sofo-details')), array('class' => 'sofo-search-results-action'));
}
