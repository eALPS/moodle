<?php
require_once('../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/utility.php");

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
                global $CFG;
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
        }
        $response = $client->QueryPresentationById($resourceId);
        Sonicfoundry\http_response_code_by_version(200, 'OK');
        echo json_encode($response);
    } catch (\Sonicfoundry\SonicfoundryException $se) {
        Sonicfoundry\http_response_code_by_version(400, 'Bad Request');
        echo $se->getMessage();
    } catch (Exception $e) {
        Sonicfoundry\http_response_code_by_version(400, 'Bad Request');
        echo $e->getMessage();
    }
} else {
    Sonicfoundry\http_response_code_by_version(404, 'Not Found');
    echo "$siteId does not exist";
}
