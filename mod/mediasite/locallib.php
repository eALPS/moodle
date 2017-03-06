<?php

require_once(dirname(__FILE__) . '/../../config.php');

global $CFG;
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteresource.php");
require_once("$CFG->dirroot/mod/mediasite/progress.php");
require_once("$CFG->dirroot/mod/mediasite/searchoptions.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/catalog.php");

define("MEDIASITE_MOODLE_TIMEOUT", 25);

function mediasite_get_version () {
    global $DB;
    $configs = $DB->get_records('mediasite_config');
    $config = reset($configs);
    $record = $DB->get_record('mediasite_sites', array('id' => $config->siteid));
    $site = new Sonicfoundry\MediasiteSite($record);
    if($site->get_passthru() == 1) {
        global $USER;
        if($site->get_sslselect()) {
            global $CFG;
            $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username, $path);
        } else {
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username);
        }
    } else {
        if($site->get_sslselect()) {
            global $CFG;
            $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), false, $path);
        } else {
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey());
        }
    }

    $siteprops = $client->QuerySiteProperties();

    return $siteprops->Version;
}

function mediasite_client($siteid) {
    global $DB;
    $record = $DB->get_record('mediasite_sites', array('id' => $siteid));
    $site = new Sonicfoundry\MediasiteSite($record);
    if($site->get_passthru() == 1) {
        global $USER;
        if($site->get_sslselect()) {
            global $CFG;
            $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username, $path);
        } else {
            // Force traffic through Fiddler proxy
            //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
            //    $site->get_username(),
            //    $site->get_password(),
            //    $site->get_apikey(),
            //    $USER->username,
            //    null,
            //    Sonicfoundry\WebApiExternalAccessClient::PROXY);
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username);
        }
    } else {
        // Force traffic through Fiddler proxy
        //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
        //    $site->get_username(),
        //    $site->get_password(),
        //    $site->get_apikey(),
        //    false,
        //    null,
        //    Sonicfoundry\WebApiExternalAccessClient::PROXY);
        if($site->get_sslselect()) {
            global $CFG;
            $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), false, $path);
        } else {
            $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey());
        }
    }
    return $client;
}
function mediasite_check_resource_permission($resourceid, $resourcetype, $username) {
    if ($resourcetype == get_string('presentation', 'mediasite')) {
    } elseif ($resourcetype == get_string('catalog', 'mediasite')) {
    }
    return true;
}

function mediasite_search($siteid, Sonicfoundry\SearchOptions &$searchoptions, &$results=null, &$total=0) {
    $top = 10;
    $start = 0;
    $start_time = microtime(true);
    if(is_null($results)) {
        $results = array();
    }
    $timeout = false;
    $client = mediasite_client($siteid);
    if($searchoptions->ResourceType == get_string('presentation', 'mediasite')) {
        $batchResults = array();
        $more = $client->QueryPresentations($searchoptions, $batchResults, $total, $top, $start);
        $results = array_merge($results, $batchResults);
        $start = count($results);
        while($more) {
            $batchResults = array();
            $more = $client->QueryPresentations($more, $batchResults, $total, $top, $start);
            $results = array_merge($results, $batchResults);
            $start = count($results);
            if((microtime(true) - $start_time) > MEDIASITE_MOODLE_TIMEOUT) {
                $timeout = true;
                break;
            }
        }
        usort($results, function(Sonicfoundry\DefaultPresentation $a, Sonicfoundry\DefaultPresentation $b) {
            return strcmp($a->Name, $b->Name);
        });
    } else if($searchoptions->ResourceType == get_string('catalog', 'mediasite')) {
        $batchResults = array();
        $more = $client->QueryCatalogShares($searchoptions, $batchResults, $total, $top, $start);
        $results = array_merge($results, $batchResults);
        $start = count($results);
        while($more) {
            $batchResults = array();
            $more = $client->QueryCatalogShares($more, $batchResults, $total, $top, $start);
            $results = array_merge($results, $batchResults);
            $start = count($results);
            if((microtime(true) - $start_time) > MEDIASITE_MOODLE_TIMEOUT) {
                $timeout = true;
                break;
            }
        }
        usort($results, function(Sonicfoundry\Catalog $a, Sonicfoundry\Catalog $b) {
            return strcmp($a->Name, $b->Name);
        });
     }

    if(!is_array($results)) {
        $results = array($results);
    }
    return $timeout;
}
function mediasite_page_search($siteid, $searchoptions, $resourceType, &$results, &$total, $top, $skip) {
    $client = mediasite_client($siteid);
    if(!strcmp($resourceType, get_string('presentation', 'mediasite'))) {
        return $client->QueryPresentations($searchoptions, $results, $total, $top, $skip);
    } else if(!strcmp($resourceType, get_string('catalog', 'mediasite'))) {
        return $client->QueryCatalogShares($searchoptions, $results, $total, $top, $skip);
    }
}
function mediasite_page_search_initializer($siteid, Sonicfoundry\SearchOptions $searchoptions, &$results, &$total, $top, $skip) {
    $client = mediasite_client($siteid);
    if(!strcmp($searchoptions->ResourceType, get_string('presentation', 'mediasite'))) {
        return $client->QueryPresentations($searchoptions, $results, $total, $top, $skip);
    } else if(!strcmp($searchoptions->ResourceType, get_string('catalog', 'mediasite'))) {
        return $client->QueryCatalogShares($searchoptions, $results, $total, $top, $skip);
    }
}
function mediasite_get_playback_url(Sonicfoundry\MediasiteResource $mediasitelink) {
    $site = new Sonicfoundry\MediasiteSite($mediasitelink->siteid);
    if(!$site) {
        error('Site not found - '.$mediasitelink->siteid);
        return '';
    }
    if($site->get_sslselect()) {
        global $CFG;
        $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), false, $path);
    } else {
        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey());
    }

    if($mediasitelink->resourcetype === 'Presentation') {
        $playbackbase = $client->QueryPresentationPlaybackUrl($mediasitelink->resourceid);
    }
    else if($mediasitelink->resourcetype === 'Catalog') {
        $catalog = $client->QueryCatalogById($mediasitelink->resourceid);
        $playbackbase = $catalog->CatalogUrl;
    }

    if(!isset($playbackbase) || empty($playbackbase)) {
        print_error( get_string('notfound', 'mediasite'));
        exit;
    }
    $clientip = null;
    if($mediasitelink->restrictip == 1) {
        $clientip = $_SERVER['REMOTE_ADDR'];
    }
    global $USER;
    $authticket = $client->CreateAuthTicket($USER->username, $mediasitelink->resourceid, $clientip, $mediasitelink->duration);

    if(is_array($playbackbase)) {
        $playbackurl = $playbackbase[0]."?authTicket=$authticket";
    } else {
        $playbackurl = "$playbackbase?authTicket=$authticket";
    }
    return $playbackurl;
}

function mediasite_get_editor_options($context) {
    global $CFG;
    return array('subdirs'=>1, 'maxbytes'=>$CFG->maxbytes, 'maxfiles'=>-1, 'changeformat'=>1, 'context'=>$context, 'noclean'=>1, 'trusttext'=>0);
}

?>
