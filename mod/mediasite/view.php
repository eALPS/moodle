<?php
require_once('../../config.php');

global $CFG;

require_once("$CFG->dirroot/mod/mediasite/locallib.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteresource.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");

$id       = optional_param('id', 0, PARAM_INT); // Course Module ID, or
$a        = optional_param('a', 0, PARAM_INT);  // mediasite ID
$frameset = optional_param('frameset', '', PARAM_ALPHA);
$inpopup  = optional_param('inpopup', 0, PARAM_BOOL);

global $DB,$OUTPUT, $PAGE;

$PAGE->set_url($CFG->wwwroot . '/mod/mediasite/view.php', array("id"=>$id, "inpopup"=>$inpopup));

if ($id) {
    if (! ($cm = $DB->get_record("course_modules", array("id" => $id))))
         error("Course Module ID was incorrect");
}

if (! $course = $DB->get_record("course", array("id" => $cm->course))) {
    error("Course is misconfigured");
}

if (! ($mediasite = $DB->get_record("mediasite", array("id" => $cm->instance)))) {
	echo $cm->instance;
    error("Course module is incorrect");
} else {
    if (! ($course = $DB->get_record("course", array("id" => $mediasite->course)))) {
        error("Course is misconfigured");
    }
    if (! ($cm = get_coursemodule_from_instance("mediasite", $mediasite->id, $course->id))) {
        error("Course Module ID was incorrect");
    }
}

require_login($course->id);

$strmediasites = get_string("modulenameplural", "mediasite");
$strmediasite  = get_string("modulename", "mediasite");

$context = context_module::instance($cm->id);

$pagetitle = strip_tags($course->shortname.': '.format_string($mediasite->name));

$formatoptions = new object();
$formatoptions->noclean = true;

$navlinks = array();
$navlinks[] = array('name' => $strmediasites, 'link' => "index.php?id=$course->id", 'type' => 'activity');
$navlinks[] = array('name' => format_string($mediasite->name), 'link' => "$CFG->wwwroot/mod/mediasite/view.php?id={$cm->id}", 'type' => 'activityinstance');

//$navigation = build_navigation($navlinks);

//display the top frame if the mediasite content is embedded
if (!empty( $frameset ) and ($frameset == "top") ) {

    $PAGE->set_heading($course->fullname); // Required
    $PAGE->set_title($pagetitle);
    $PAGE->set_cacheable(true);
    $PAGE->set_focuscontrol("");
    $PAGE->set_button(update_module_button($cm->id, $course->id, $strmediasite));
    $PAGE->navbar->add($navlinks[0]["name"], $navlinks[0]["link"]);
    $PAGE->navbar->add($navlinks[1]["name"], $navlinks[1]["link"]);

    echo $OUTPUT->header();

    $PAGE->set_pagelayout("base");
    echo $OUTPUT->footer();
    exit;
}

//create the popup window if the content should be a popup    
if ($mediasite->openaspopup == '1' and !$inpopup) {

    $PAGE->set_heading($course->fullname); // Required
    $PAGE->set_title($pagetitle);
    $PAGE->set_cacheable(true);
    $PAGE->set_focuscontrol("");
    $PAGE->set_button(update_module_button($cm->id, $course->id, $strmediasite));
    $PAGE->navbar->add($navlinks[0]["name"], $navlinks[0]["link"]);
    $PAGE->navbar->add($navlinks[1]["name"], $navlinks[1]["link"]);

    echo $OUTPUT->header();

    echo "\n<script type=\"text/javascript\">";
    echo "\n<!--\n";
    echo 'openpopup(null, {"url":"/mod/mediasite/view.php?id=' . $cm->id . '&inpopup=true", ' . '"name":"mediasite' . $mediasite->id . '", ' . '"options":"resizable=1,scrollbars=1,directories=1,location=1,menubar=1,toolbar=1,status=1"});';
    echo "\n-->\n";
    echo '</script>';

    $link = "<a href=\"$CFG->wwwroot/mod/mediasite/view.php?inpopup=true&amp;id={$cm->id}\" "
          . "onclick=\"this.target='mediasite{$mediasite->id}'; return openpopup('/mod/mediasite/view.php?inpopup=true&amp;id={$cm->id}', "
          . "'mediasite{$mediasite->id}','resizable=1,scrollbars=1,directories=1,location=1,menubar=1,toolbar=1,status=1');\">".format_string($mediasite->name,true)."</a>";

    echo '<div class="popupnotice">';
    print_string('popupresource', 'resource');
    echo '<br />';
    print_string('popupresourcelink', 'resource', $link);
    echo '</div>';
    echo $OUTPUT->footer($course);
    exit;
    
}
//add_to_log($course->id, "mediasite", "view", "view.php?id=$cm->id", "$mediasite->id");
$event = \mod_mediasite\event\course_module_viewed::create(array(
    'objectid' => $mediasite->id,
    'context' => $context
));
$event->add_record_snapshot('course_modules', $cm);
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('mediasite', $mediasite);
$event->trigger();

//Redirect to content if this is a popup
if ($mediasite->openaspopup == '1' and $inpopup) {
	$authlink = get_authlink(new Sonicfoundry\MediasiteResource($mediasite));
    echo $authlink;
    redirect($authlink);
}

//Load the content frame if this is embedded
if (empty($frameset)) {
	$link = get_authlink(new Sonicfoundry\MediasiteResource($mediasite));
    @header('Content-Type: text/html; charset=utf-8');
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    echo "<html dir=\"ltr\">\n";
    echo '<head>';
    echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
   
    echo '<script type="text/javascript">window.onload = function () {var a=window.frames["topframe"].document.getElementsByTagName("a");'.
            'for(var i=0; i<a.length; i++){a[i].target="_top";}}</script>';
    
    echo "<title>" . format_string($course->shortname) . ": ".strip_tags(format_string($mediasite->name,true))."</title></head>\n";   
    if (!empty($CFG->resource_framesize)) {
        echo "<frameset rows=\"$CFG->resource_framesize,*\">";
    } else {
        echo "<frameset rows=\"160,*\">";
    }  
	echo "<frame src=\"$CFG->wwwroot/mod/mediasite/view.php?id={$cm->id}&amp;frameset=top\" title=\"". get_string('modulename','resource')."\" name=\"topframe\"/>"; 
	echo "<frame src=\"$link\" title=\"".get_string('modulename','resource')."\"/>"; 
    echo "</frameset>";
    echo "</html>";
    exit;
}

function get_authlink(Sonicfoundry\MediasiteResource $mediasite) {
    try {
         $authlink = mediasite_get_playback_url($mediasite);
    } catch (\Sonicfoundry\SonicfoundryException $se) {
        print_error($se->getMessage());
        die;
    } catch (Exception $e) {
        print_error($e->getMessage());
        die;
    }

    return $authlink;    	
}

?>