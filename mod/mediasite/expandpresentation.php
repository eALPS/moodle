<?php
require_once('../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/tag.php");
require_once("$CFG->dirroot/mod/mediasite/presenter.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
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
            //                                                      null,
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
        //$tags = $client->GetTagsForPresentation($resourceId);
        $presenters = $client->GetPresentersForPresentation($resourceId);
        $thumbnails = $client->GetThumbnailContentForPresentation($resourceId, rawurlencode('StreamType eq \'Presentation\''));
        if(count($thumbnails) > 1) {
            usort($thumbnails, function($a, $b) {
                if($a->ContentRevision == $b->ContentRevision) {
                    return 0;
                }
                return ($a->ContentRevision < $b->ContentRevision) ? 1 : -1;
            });
        }
        $presentation = $client->QueryPresentationById($resourceId);

        $response = new Sonicfoundry\ExpandedPresentation();
        $response->Tags = array();
        $response->Presenters = $presenters;
        $response->Thumbnails = $thumbnails;
        $response->Presentation = $presentation;
        Sonicfoundry\http_response_code_by_version(200, 'OK');
        echo json_encode($response);
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
