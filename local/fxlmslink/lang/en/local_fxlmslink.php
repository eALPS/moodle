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

$string['pluginname'] = 'FXLMSLink';
$string['teacheridfield'] = 'Teacher ID field';
$string['teacheridfielddesc'] = 'Treat this field as a teacher ID.';
$string['studentidfield'] = 'Student ID field';
$string['studentidfielddesc'] = 'Treat this field as a student ID.';
$string['allowips'] = 'Allow IPs';
$string['allowipsdesc'] = 'Enter IP addresses to allow access.';
$string['defer'] = 'Use deferred area';
$string['deferdesc'] = 'Save submission data from Box into deferred area instead of assign submission.';

$string['replacement'] = 'Replacement';
$string['finishsubmissions'] = 'Complete submissions and grades';
$string['cancelsubmissions'] = 'Cancel submissions and grades';
$string['nodeferredsubmissions'] = 'No deferred submissions';
$string['confirmationremoved'] = 'Remove all of the submission.';

$string['webserver'] = 'Web server';
$string['notokens'] = 'No tokens created.';

$string['unabletologin'] = 'Unable to login';
$string['invalidsessionid'] = 'InvalidSessionID';
$string['invaliduserid'] = 'InvalidUserID';
$string['noemailaddress'] = 'NoEmailAddress';
$string['nocourses'] = 'NoCourses';
$string['invalidassignmentid'] = 'InvalidAssignmentId';
$string['invalidfilename'] = 'InvalidFilename';
$string['diskfull'] = 'DiskFull';
$string['filewriteerror'] = 'FileWriteError';
$string['other'] = 'Other';
$string['authority'] = 'It will check the user\'s authority';
$string['authoritydesc'] = 'The system controls access using capability 「Allow the operation from assistance box」.
<br />Admin can access in any case.
<br />Guest can not access in any case.
<br />When enable capability for authenticated user on frontpage, authenticated user is also enabled. Inheriting of capability follows moodle specification.';
$string['authorityno'] = 'No';
$string['authorityyes'] = 'Yes';
$string['fxlmslink:enabled_fxlmslink'] = 'Allow the operation from assistance box';
$string['no'] = 'No';
$string['yes'] = 'Yes';
