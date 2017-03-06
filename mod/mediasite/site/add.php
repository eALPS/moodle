<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("mod_mediasite_site_form.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");

$context = context_system::instance();

require_login();
require_capability('mod/mediasite:addinstance', $context);

global $PAGE;

$PAGE->set_context($context);
$PAGE->set_url($CFG->wwwroot . '/mod/mediasite/site/add.php');
$addform = new mod_mediasite_site_form();
$mform =& $addform;

if ($mform->is_cancelled()) {
    redirect("configuration.php");
}
$data = $mform->get_data();
if($data) {
    $record = new stdClass();
    $url = $data->siteurl;
    if(substr($url, - 1) !== '/') {
        $url .= '/';
    }
    $soapclient = Sonicfoundry\MediasiteClientFactory::MediasiteClient('soap', $url, $data->siteusername, $data->sitepassword);
    $siteproperties = $soapclient->QuerySiteProperties();
    $version = $siteproperties->SiteVersion;
    $soapclient->Logout();
    $matches = array();
    if(preg_match('/(6|7)\.(\d+)\.(\d+)/i', $version, $matches)) {
        if($matches[1] == 6) {
            $record->siteclient = 'soap';
        }
        elseif($matches[1] == 7) {
            $record->siteclient = 'odata';
        }
    }
    $apikeyId = null;
    try {
        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($record->siteclient, $url, $data->siteusername, $data->sitepassword);
        $apikeyId = $client->get_apikey();
        $record->apikey = is_null($apikeyId) ? '' : $apikeyId;
    } catch(\Sonicfoundry\SonicfoundryException $se) {
        try {
            if(isset($client) && !is_null($client)) {
                if(is_null($apikeyId)) {
                    $apikey = $client->CreateApiKey();
                    $record->apikey = $apikey->Id;
                }
            } else {
                throw new Exception("No client at ".$data->siteurl." Previous exception ".$se->getMessage()." ".$se->getTraceAsString());
            }
        } catch(\Sonicfoundry\SonicfoundryException $e) {
            redirect("configuration.php");
            // Go home on error
            throw $e;
        }
    }
    $record->sitename = $data->sitename;
    if(!preg_match('%\bhttps?:\/\/%si',$data->siteurl)) {
        $data->siteurl = 'http://'.$data->siteurl;
    }
    $record->endpoint = $data->siteurl;
    $record->username = $data->siteusername;
    $record->password = $data->sitepassword;
    $record->passthru = $data->sitepassthru;
    if(preg_match('%\bhttps:\/\/%si',$data->siteurl)) {
        $record->sslselect = 1;
    } else {
        $record->sslselect = 0;
    }

    if($record->sslselect) {
        $certcontent = $mform->get_file_content('cert');
        $record->cert = $certcontent;
    }
    global $DB;
    // Add new record
    $siteid = $DB->insert_record('mediasite_sites', $record);

    if($record->sslselect) {
        if(!file_exists($CFG->dirroot.'/mod/mediasite/cert')) {
           if(!mkdir($CFG->dirroot.'/mod/mediasite/cert', 0777, true)) {
               die('Failed to create cert folder');
           }
        }
        $certhandle = @fopen($CFG->dirroot.'/mod/mediasite/cert/'.'site'.$siteid.'.crt','x');
        if($certhandle) {
            $byteswritten = fwrite($certhandle, $certcontent);
            fflush($certhandle);
            fclose($certhandle);
        }
    }

    // Go home
    redirect("configuration.php");
}

global $OUTPUT;

echo $OUTPUT->header();

echo "<table border=\"0\" style=\"margin-left:auto;margin-right:auto\" cellspacing=\"3\" cellpadding=\"3\" width=\"640\">";
echo "<tr>";
echo "<td colspan=\"2\">";

$mform->display();

echo '</td></tr></table>';

echo $OUTPUT->footer();
