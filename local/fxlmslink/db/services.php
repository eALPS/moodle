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

$functions = array(
    'login' => array(
        'classname'   => 'local_fxlmslink_external',
        'methodname'  => 'login',
        'classpath'   => 'local/fxlmslink/externallib.php',
        'description' => 'Log in to moodle',
        'type'        => 'read',
    ),
    'logout' => array(
        'classname'   => 'local_fxlmslink_external',
        'methodname'  => 'logout',
        'classpath'   => 'local/fxlmslink/externallib.php',
        'description' => 'Log out from moodle',
        'type'        => 'read',
    ),
    'getInstructorInfo' => array(
        'classname'   => 'local_fxlmslink_external',
        'methodname'  => 'get_instructor_info',
        'classpath'   => 'local/fxlmslink/externallib.php',
        'description' => 'Get instructor informations',
        'type'        => 'read',
    ),
    'createSubmission' => array(
        'classname'   => 'local_fxlmslink_external',
        'methodname'  => 'create_submission',
        'classpath'   => 'local/fxlmslink/externallib.php',
        'description' => 'Create file submissions',
        'type'        => 'write',
        'capabilities'=> 'moodle/course:update',
    ),
);

$services = array(
    'FXLMSLink service' => array(
        'functions'       => array('login', 'logout', 'getInstructorInfo', 'createSubmission'),
        'enabled'         => 1,
        'restrictedusers' => 0,
        'shortname'       => 'local_fxlmslink_service',
        'downloadfiles'   => 0,
    ),
);
