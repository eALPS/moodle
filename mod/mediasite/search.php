<?php
/**
 * search.php
 * This page is automatically brought up upon loading mod_form.php. It can be brought up
 * again using the 'Search' button on mod_form.php
 */
require_once(dirname(__FILE__) . '/../../config.php');
    global $CFG;
    require_once("$CFG->dirroot/mod/mediasite/search_form.php");
    require_once("$CFG->dirroot/mod/mediasite/locallib.php");
    require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
    require_once("$CFG->dirroot/mod/mediasite/progress.php");
    require_once("$CFG->dirroot/mod/mediasite/exceptions.php");

    global $PAGE;
 
    $courseid = required_param('course', PARAM_INT);          // course

    $context = context_course::instance($courseid);

    require_login();
	require_capability('mod/mediasite:addinstance', $context);

    $PAGE->set_context($context);
	$PAGE->set_url($CFG->wwwroot . '/mod/mediasite/search.php');

    //$PAGE->requires->js(new moodle_url('/mod/mediasite/js/search.js'), true);
    //global $CFG;
    //$CFG->debug = (E_ALL | E_STRICT);
    $PAGE->requires->yui_module('moodle-mod_mediasite-search', 'M.mod_mediasite.search.init', array('formid' => 'id_search_form',
                                                                                                    'courseid' => $courseid));
    $PAGE->requires->strings_for_js(array(
            'presentation',
            'catalog',
            'selectresource',
            'expandresource',
            'titleresource',
            'futuredate',
            'notadate',
            'impossibledatecombination',
            'onefieldselect',
            'advancedskipped'
    ), 'mediasite');
    date_default_timezone_set('UTC');

    html_header();

      $mform  = new mod_mediasite_search_form(strval($courseid));

      $mform->display();

      echo html_writer::tag('div', '', array('class' => 'yui3-scrollview-content', 'id' => 'id_search_results'));

    html_footer();

    function html_header() {
        GLOBAL $OUTPUT;

        echo $OUTPUT->header();

        echo "<table class=\"yui3-skin-sam\" border=\"0\" style=\"margin-left:auto;margin-right:auto\" cellspacing=\"3\" cellpadding=\"3\" width=\"640\">";
        echo "<tr>";
        echo "<td colspan=\"2\">";
    }

    function html_footer() {
        global $COURSE, $OUTPUT;

        echo '</td></tr></table>';

        echo $OUTPUT->footer($COURSE);
    }

?>