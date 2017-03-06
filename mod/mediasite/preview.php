<?php
require_once('../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");

$siteId = required_param('site', PARAM_INT);           // Site Id
$resource = required_param('resource', PARAM_TEXT);    // Resource Id
$duration = required_param('duration', PARAM_INT);     // Duration
$restrictip = required_param('restrictip', PARAM_INT); // Restrict to IP

global $DB;

$condition = array('id' => $siteId);
if($DB->record_exists("mediasite_sites", $condition)) {
    $record = $DB->get_record("mediasite_sites", $condition);
    $site = new Sonicfoundry\MediasiteSite($record);
    if($site->get_sslselect()) {
        global $CFG;
        $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                                                              $site->get_username(),
                                                              $site->get_password(),
                                                              $site->get_apikey(),
                                                              false,
                                                              $path);
    } else {
        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                                                              $site->get_username(),
                                                              $site->get_password(),
                                                              $site->get_apikey());
    }
    $playbackbase = $client->QueryPresentationPlaybackUrl($resource);

    if(!isset($playbackbase) || empty($playbackbase)) {
        http_response_code(404);
        echo "$resource does not exist";
    } else {
        $clientip = null;
        if($restrictip == 1) {
            $clientip = $_SERVER['REMOTE_ADDR'];
        }
        $authTicket = $client->CreateAuthTicket($site->get_username(), $resource, $clientip, $duration);

        header("HTTP/1.1 301 Moved Permanently");
        if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) {
            header("Origin: https://".gethostbyname(gethostname()));
        } else {
            header("Origin: http://".gethostbyname(gethostname()));
        }
        $augmentedUrl = $playbackbase."?authTicket=$authTicket";
        header("Location: $augmentedUrl");
        die();
    }
} else {
    http_response_code(404);
    echo "$siteId does not exist";
}
