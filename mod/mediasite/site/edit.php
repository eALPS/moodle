<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

require_once("mod_mediasite_site_form.php");

//$siteid = required_param('site', PARAM_INT);
$siteid = optional_param('site', 0, PARAM_INT);

$context = context_system::instance();

global $CFG,$PAGE;

$PAGE->set_context($context);
$PAGE->set_url($CFG->wwwroot . '/mod/mediasite/site/edit.php');

require_login();
require_capability('mod/mediasite:addinstance', $context);

global $DB;

$record = $DB->get_record('mediasite_sites', array('id'=>$siteid));

$site = new Sonicfoundry\MediasiteSite($record);
$editform = new mod_mediasite_site_form($site);
$mform =& $editform;
if ($mform->is_cancelled()) {
    // Go home
    redirect("configuration.php");
}
$data = $mform->get_data();
if($data) {
    // Save edited data
    $site->set_sitename($data->sitename);
    $site->set_endpoint($data->siteurl);
    $site->set_username($data->siteusername);
    $site->set_password($data->sitepassword);
    $site->set_passthru($data->sitepassthru);
    if(preg_match('%\bhttps:\/\/%si',$data->siteurl)) {
        $site->set_sslselect(1);
    } else {
        $site->set_sslselect(0);
    }
    if($site->get_sslselect()) {
        $certcontent = $mform->get_file_content('cert');
        $site->set_cert($certcontent);
    }
    $url = $data->siteurl;
    if(substr($url, - 1) !== '/') {
        $url .= '/';
    }
    $soapclient = Sonicfoundry\MediasiteClientFactory::MediasiteClient('soap',  $url, $data->siteusername, $data->sitepassword);
    $siteproperties = $soapclient->QuerySiteProperties();
    $version = $siteproperties->SiteVersion;
    $soapclient->Logout();
    $matches = array();
    if(preg_match('/(6|7)\.(\d+)\.(\d+)/i', $version, $matches)) {
        if($matches[1] == 6) {
            $site->set_siteclient('soap');
        }
        elseif($matches[1] == 7) {
            $site->set_siteclient('odata');
        }
    }

    $site->update_database();
    if($site->get_siteclient() === 'odata') {
        if($site->get_sslselect()) {
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
