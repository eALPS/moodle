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
 * @global moodle_database $DB
 * @param int $oldversion
 */
function xmldb_local_fxlmslink_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2013121800) {

        // Define table local_fxlmslink_sessions to be created.
        $table = new xmldb_table('local_fxlmslink_sessions');

        // Adding fields to table local_fxlmslink_sessions.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('sid', XMLDB_TYPE_CHAR, '128', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('firstip', XMLDB_TYPE_CHAR, '45', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lastip', XMLDB_TYPE_CHAR, '45', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_fxlmslink_sessions.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_FOREIGN, array('userid'), 'user', array('id'));

        // Adding indexes to table local_fxlmslink_sessions.
        $table->add_index('sid', XMLDB_INDEX_UNIQUE, array('sid'));
        $table->add_index('timecreated', XMLDB_INDEX_NOTUNIQUE, array('timecreated'));
        $table->add_index('timemodified', XMLDB_INDEX_NOTUNIQUE, array('timemodified'));

        // Conditionally launch create table for local_fxlmslink_sessions.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fxlmslink savepoint reached.
        upgrade_plugin_savepoint(true, 2013121800, 'local', 'fxlmslink');
    }

    if ($oldversion < 2014090100) {

        // Define table local_fxlmslink_submissions to be created.
        $table = new xmldb_table('local_fxlmslink_submissions');

        // Adding fields to table local_fxlmslink_submissions.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('assignment', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('grade', XMLDB_TYPE_NUMBER, '10', '5', null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_fxlmslink_submissions.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_FOREIGN, array('userid'), 'user', array('id'));

        // Adding indexes to table local_fxlmslink_submissions.
        $table->add_index('assignment', XMLDB_INDEX_NOTUNIQUE, array('assignment'));

        // Conditionally launch create table for local_fxlmslink_submissions.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fxlmslink savepoint reached.
        upgrade_plugin_savepoint(true, 2014090100, 'local', 'fxlmslink');
    }

    if ($oldversion < 2015112700) {
        $config = $DB->get_records('user_info_field', array('shortname' => 'assistancebox'));
    
        if(empty($config)) {
            $config = new stdClass();
            $config->shortname = 'assistancebox';
            $config->name = '授業支援ボックスからの操作を許可する';
            $config->datatype = 'checkbox';
            $config->categoryid = 1;
            $config->visible = 2;
    
            $DB->insert_record('user_info_field', $config);
        }
        // Fxlmslink savepoint reached.
        upgrade_plugin_savepoint(true, 2015112700, 'local', 'fxlmslink');
    }
    
    if ($oldversion < 2015121500) {
        $config = $DB->get_records('user_info_field', array('shortname' => 'assistancebox'));
    
        if(!empty($config)) {
            $DB->delete_records('user_info_field', array('shortname' => 'assistancebox'));
        }
        // Fxlmslink savepoint reached.
        upgrade_plugin_savepoint(true, 2015121500, 'local', 'fxlmslink');
    }
    
    return true;
}
