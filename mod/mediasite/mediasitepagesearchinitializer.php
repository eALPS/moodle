<?php

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/mod/mediasite/locallib.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/searchoptions.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitepagesearchresult.php");

$sessionid = required_param('sid', PARAM_TEXT);
$courseid = required_param('course', PARAM_INT);
$siteid = required_param('site', PARAM_INT);
$searchtext = required_param('search', PARAM_TEXT);
$resourcetype = required_param('type', PARAM_TEXT);

$until  = required_param('until', PARAM_TEXT);
$untilselect = required_param('untilselect', PARAM_BOOL);
$after  = required_param('after', PARAM_TEXT);
$afterselect = required_param('afterselect', PARAM_BOOL);

$name  = required_param('name', PARAM_BOOL);
$description  = required_param('description', PARAM_BOOL);
$tag  = required_param('tag', PARAM_BOOL);
$presenter  = required_param('presenter', PARAM_BOOL);

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
$searchoptions->SearchText = $searchtext;
$searchoptions->ResourceType = $resourcetype;

        $results = array();
        $total = -1;
        $next = mediasite_page_search_initializer($siteid, $searchoptions, $results, $total, 10, 0);

global $DB;
if($siteRecord = $DB->get_record('mediasite_sites', array('id' => $siteid))) {
    $site = new Sonicfoundry\MediasiteSite($siteRecord);
    if(!strcasecmp($site->get_siteclient(),  'odata')) {
        if($next) {
            if(preg_match('/^[^?#]+\?([^#]+)/i', $next, $matches)) {
                $searchString = preg_replace('/\$(top|skip)=[^&]+&?/i', '', $matches[1]);
               if(preg_match_all('/\$(top|skip)=(\d+)/m', $matches[1], $matches) && count($matches) == 3) {
                   $top = 10;
                   $increment = 0;
                   if(!strcmp($matches[1][0], 'top')) {
                       $top = $matches[2][0];
                   } elseif(!strcmp($matches[1][0], 'skip')) {
                       $increment = $matches[2][0];
                   }
                   if(!strcmp($matches[1][1], 'top')) {
                       $top = $matches[2][1];
                   } elseif(!strcmp($matches[1][1], 'skip')) {
                       $increment = $matches[2][1];
                   }
                   $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype, $searchString, $increment, $top);
               } else {
                   $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype, '');
               }
            } else {
                // No query parameters
                $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype, '');
            }
        } else {
            // No next (the results are all in this page)
            $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype, '');
        }
    } else if(!strcasecmp($site->get_siteclient(),  'soap')) {
        if($next) {
            $queryOptions = json_decode($next);
            $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype,
                                                                           $next,
                                                                           $queryOptions->Options->StartIndex,
                                                                           $queryOptions->Options->BatchSize,
                                                                           $queryOptions->Options->QueryId);
        } else {
            $pageSearchResult = new Sonicfoundry\MediasitePageSearchResult($results, $total, $siteid, $resourcetype,
                                                                           '');
        }
    }
    echo json_encode($pageSearchResult);
}
