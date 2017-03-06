<?php
require_once('../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
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
            // Force traffic through Fiddler proxy
            //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
            //                                                      $site->get_username(),
            //                                                      $site->get_password(),
            //                                                      $site->get_apikey(),
            //                                                      $USER->username,
            //                                                      NULL
            //													    Sonicfoundry\WebApiExternalAccessClient::PROXY);
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
            // Force traffic through Fiddler proxy
            //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
            //                                                      $site->get_username(),
            //                                                      $site->get_password(),
            //                                                      $site->get_apikey(),
            //													    false,
            //                                                      null,
            //													    Sonicfoundry\WebApiExternalAccessClient::PROXY);
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
        $catalog = $client->QueryCatalogById($resourceId);
        Sonicfoundry\http_response_code_by_version(200, 'OK');
        echo json_encode($catalog);
    } catch (Sonicfoundry\SonicfoundryException $se) {
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
