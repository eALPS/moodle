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
require_once __DIR__.'/../../../config.php';
require_once __DIR__.'/../../../lib/adminlib.php';

/* @var $DB moodle_database */
/* @var $CFG object */
/* @var $USER object */
/* @var $PAGE moodle_page */
/* @var $OUTPUT core_renderer */

admin_externalpage_setup('local_fxlmslink_webserver');

require_capability('moodle/site:config', context_system::instance());

$apache = optional_param('apache', 'httpd.conf', PARAM_TEXT);

$wstoken = $DB->get_field_sql(
    'SELECT xt.token
       FROM {external_tokens} xt
       JOIN {external_services} xs ON xs.id = xt.externalserviceid
      WHERE xs.shortname = :servicename AND xs.enabled = 1
        AND (xt.validuntil IS NULL OR xt.validuntil = 0 OR xt.validuntil <= :now)',
    array('servicename' => 'local_fxlmslink_service', 'now' => time()),
    IGNORE_MULTIPLE);
if (!$wstoken) {
    redirect(
        new moodle_url('/admin/settings.php', array('section' => 'webservicetokens')),
        get_string('notokens', 'local_fxlmslink'),
        3);
}

function auto_radio($name, $value, $checked = false, $label = null) {
    $checked = optional_param($name, $checked ? $value : null, PARAM_TEXT) == $value;
    $id = 'id_' . preg_replace('/\W/', '_', $name) . '_' . preg_replace('/\W/', '_', $value);
    return '<input type="radio" name="' . $name . '" value="' . s($value) . '" id="' . $id . '"'
         . ($checked ? ' checked="checked"' : '') . ' onclick="this.form.submit()" />'
         . '<label for="' . $id . '">' . s($label ?: $value) . '</label>';
}

$PAGE->requires->css('/local/fxlmslink/admin/webserver.css');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('webserver', 'local_fxlmslink'));

echo '<form action="', $PAGE->url, '" method="get" id="adminsettings">';
echo '<fieldset>';

echo $OUTPUT->heading('Apache', 3);
echo '<div class="box generalbox">';
echo '<table class="generaltable">';
echo '<thead><tr><th class="header">';
echo auto_radio('apache', 'httpd.conf', true), ' / ', auto_radio('apache', '.htaccess');
echo '</th></tr></thead>';
echo '<tbody><tr><td><pre>';
if ($apache == 'httpd.conf') {
    echo s('<Location />'), "\n";
    echo "    RewriteEngine On\n";
    echo "    RewriteRule sakai-axis/LMSLink.jws $CFG->wwwroot/webservice/soap/server.php?wstoken=$wstoken [NC,QSA,R,L]\n";
    echo "    RewriteRule sakai-axis/SakaiLogin.jws $CFG->wwwroot/webservice/soap/server.php?wstoken=$wstoken [NC,QSA,R,L]\n";
    echo s('</Location>'), "\n";
} else {
    echo "RewriteEngine On\n";
    echo "RewriteRule sakai-axis/LMSLink.jws $CFG->wwwroot/webservice/soap/server.php?wstoken=$wstoken [NC,QSA,R,L]\n";
    echo "RewriteRule sakai-axis/SakaiLogin.jws $CFG->wwwroot/webservice/soap/server.php?wstoken=$wstoken [NC,QSA,R,L]\n";
}
echo '</pre></td></tr></tbody>';
echo '</table>';
echo '</div>';

echo '</fieldset>';
echo '</form>';

echo $OUTPUT->footer();
