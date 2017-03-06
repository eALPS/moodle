<?php
define('AJAX_SCRIPT', true);
define('NO_MOODLE_COOKIES', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/utility.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");

$siteId = required_param('site', PARAM_INT);           // Site Id
$resource = required_param('resource', PARAM_TEXT);    // Resource Id
$duration = required_param('duration', PARAM_INT);     // Duration
$restrictip = required_param('restrictip', PARAM_INT); // Restrict to IP
$slideUrl = required_param('url', PARAM_TEXT);     // url

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
    $clientip = null;
    if($restrictip == 1) {
        $clientip = $_SERVER['REMOTE_ADDR'];
    }
    $authTicket = $client->CreateAuthTicket($site->get_username(), $resource, $clientip, $duration);
    redirect($slideUrl."?authTicket=$authTicket");
} else {
    Sonicfoundry\http_response_code_by_version(404, 'Not Found');
    echo "$siteId does not exist";
}
