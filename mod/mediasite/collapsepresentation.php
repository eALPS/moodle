<?php
require_once('../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/tag.php");
require_once("$CFG->dirroot/mod/mediasite/presenter.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");

$siteId = required_param('site', PARAM_INT);          // Site Id
$resourceId = required_param('resource', PARAM_TEXT); // Resource Id
$resourceType = required_param('type', PARAM_TEXT);   // Resource Type

global $DB;

$condition = array('id' => $siteId);
if($DB->record_exists("mediasite_sites", $condition)) {
    try {
        $record = $DB->get_record("mediasite_sites", $condition);
        $site = new Sonicfoundry\MediasiteSite($record);
        if($site->get_passthru()) {
            global $USER;
            if($site->get_sslselect()) {
                $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                    $site->get_username(),
                    $site->get_password(),
                    $site->get_apikey(),
                    $USER->username,
                    $path);
            } else {
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                    $site->get_username(),
                    $site->get_password(),
                    $site->get_apikey(),
                    $USER->username);
            }
        } else {
            if($site->get_sslselect()) {
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
        }
        $response = $client->QueryPresentationById($resourceId);
        http_response_code(200);
        echo json_encode($response);
    } catch (Sonicfoundry\SonicfoundryException $se) {
        http_response_code(400);
        echo $se->getMessage();
    } catch (Exception $e) {
        http_response_code(400);
        echo $e->getMessage();
    }
} else {
    http_response_code(404);
    echo "$siteId does not exist";
}
