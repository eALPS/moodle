<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/mod/mediasite/lib.php');
require_once("mod_mediasite_siteselection_form.php");

// Check the user is logged in.
require_login();
$context = context_system::instance();

admin_externalpage_setup('activitysettingmediasite');
require_capability('mod/mediasite:addinstance', $context);
global $PAGE;

$PAGE->requires->yui_module('moodle-mod_mediasite-configure', 'M.mod_mediasite.configure.init');

//$PAGE->requires->strings_for_js(array(
//    'advancedskipped'
//), 'mediasite');

global $DB;
// Get the list of configured engines.
$sites = $DB->get_records('mediasite_sites');
$siteselectionform = new Sonicfoundry\mod_mediasite_siteselection_form($sites);
$mform =& $siteselectionform;
if ($mform->is_cancelled()) {
    // Go home
    redirect($CFG->wwwroot);
}
$data = $mform->get_data();
if($data) {
	$record = new stdClass();
	if(!isset($data->sites) || is_null($data->sites)) {
		$sites = $DB->get_records('mediasite_sites', null, '', "id");
		$record->siteid = reset($sites)->id;
	} else {
		$record->siteid = $data->sites;
	}
	$record->openaspopup = $data->openaspopup;
	$record->duration = $data->duration;
	$record->restrictip = $data->restrictip;
    $ids = $DB->get_records('mediasite_config', null, '', "id");
	if(!is_null($ids) && count($ids) > 0) {
		$record->id = reset($ids)->id;
		$DB->update_record('mediasite_config', $record);
	} else {
		$DB->insert_record('mediasite_config', $record);
	}
    // Go home
    redirect($CFG->wwwroot);
}

global $OUTPUT;

echo $OUTPUT->header();

echo "<table border=\"0\" style=\"margin-left:auto;margin-right:auto\" cellspacing=\"3\" cellpadding=\"3\" width=\"100%\" >";
echo "<tr>";
echo "<td colspan=\"2\">";

$mform->display();

echo '</td></tr></table>';

echo $OUTPUT->footer();
