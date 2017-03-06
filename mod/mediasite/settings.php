<?php  //$Id: settings.php,v 1.1.2.3 2008/01/24 20:29:36 skodak Exp $

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/mod/mediasite/lib.php");
require_once("$CFG->dirroot/mod/mediasite/locallib.php");

defined('MOODLE_INTERNAL') || die();

    $settings = new admin_externalpage('activitysettingmediasite',
        get_string('pluginname', 'mediasite'),
        new moodle_url('/mod/mediasite/site/configuration.php'),
        'mod/mediasite:addinstance');

?>
