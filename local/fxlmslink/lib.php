<?php
// This file is part of fxlmslink moodle plugin - http://www.fujixerox.co.jp
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local plugin "fxlmslink" - Library
 *
 * @package     fxlmslink
 * @copyright   2014 Fuji Xerox Co., Ltd.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

/**
 * @global moodle_page $PAGE
 * @global moodle_database $DB
 * @param settings_navigation $nav
 * @param context|null $context null can be given https://tracker.moodle.org/browse/MDL-44014
 */
function local_fxlmslink_extend_settings_navigation(settings_navigation $nav, $context) {
    global $PAGE, $DB;

    if ($PAGE->context->contextlevel == CONTEXT_MODULE && $PAGE->cm->modname === 'assign') {
        if ($modulesettings = $nav->get('modulesettings') and has_capability('mod/assign:grade', $PAGE->context)) {
            $filesubmissionenabled = $DB->get_field('assign_plugin_config', 'value',
                array('assignment' => $PAGE->cm->instance, 'plugin' => 'file',
                      'subtype' => 'assignsubmission', 'name' => 'enabled')
                );
            if ($filesubmissionenabled) {
                $fxlmslink = navigation_node::create(get_string('pluginname', 'local_fxlmslink'));
                $fxlmslink->key = 'fxlmslink';
                $fxlmslink->action = new moodle_url('/local/fxlmslink/view.php', array('id' => $PAGE->cm->id));
                $modulesettings->add_node($fxlmslink);
                if ($fxlmslink->action->compare($PAGE->url))
                    $fxlmslink->make_active();
            }
        }
    }
}

/**
 * for 2.8 earlier.
 */
function local_fxlmslink_extends_settings_navigation(settings_navigation $nav, $context) {
    local_fxlmslink_extend_settings_navigation($nav, $content);
}


/**
 * @param object $course
 * @param object $cm
 * @param context $context
 * @param string $filearea
 * @param string[] $args
 * @param boolean $forcedownload
 * @param array $options
 * @return bool false if file not found, does not return if found - justsend the file
 */
function local_fxlmslink_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel != CONTEXT_MODULE)
        return false;

    require_course_login($course, false, $cm);
    require_capability('mod/assign:grade', $context);

    $pathname = "/$context->id/local_fxlmslink/$filearea/" . implode('/', $args);
    $file = get_file_storage()->get_file_by_hash(sha1($pathname));
    if (!$file || $file->is_directory())
        return false;

    send_stored_file($file, 0, 0, true, $options);
}
