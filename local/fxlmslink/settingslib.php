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

class admin_setting_configipv4v6list extends admin_setting_configiplist {
    /**
     * Validate the contents of the textarea as IP addresses
     *
     * Used to validate a new line separated list of IP addresses collected from
     * a textarea control
     *
     * @param string $data A list of IP Addresses separated by new lines
     * @return mixed bool true for success or string:error on failure
     */
    public function validate($data) {
        if (empty($data))
            return get_string('validateerror', 'admin');

        foreach (explode("\n", $data) as $line) {
            $line = trim($line);

            // IPv4
            if (parent::validate($line) === true)
                continue;
            // IPv6
            if (self::validate6($line) === true)
                continue;

            return get_string('validateerror', 'admin');
        }
        return true;
    }

    /**
     * @param string $data An IP Address
     * @return bool true for success or false on failure
     */
    private static function validate6($data) {
        if (strpos($data, '/') !== false) {
            list ($addr, $mask) = explode('/', $data, 2);
            if (is_number($mask) && 0 <= $mask && $mask <= 128 && cleanremoteaddr($addr) !== null)
                return true;
        } else {
            if (cleanremoteaddr($data) !== null)
                return true;
        }
        return false;
    }
}

class admin_category_local_fxlmslink extends admin_category {
    public function __construct() {
        parent::__construct('local_fxlmslink', new lang_string('pluginname', 'local_fxlmslink'));

        $settings = new admin_settingpage('local_fxlmslink_settings', new lang_string('settings'));
        $settings->add(
            new admin_setting_configselect('local_fxlmslink/teacheridfield',
                new lang_string('teacheridfield', 'local_fxlmslink'),
                new lang_string('teacheridfielddesc', 'local_fxlmslink'),
                'username',
                array(
                    'username'  => get_string('username')  . ' (username)',
                    'firstname' => get_string('firstname') . ' (firstname)',
                    'lastname'  => get_string('lastname')  . ' (lastname)',
                    'idnumber'  => get_string('idnumber')  . ' (idnumber)',
                    'department'  => get_string('department')  . ' (department)',
                    )
                )
            );
        $settings->add(
            new admin_setting_configselect('local_fxlmslink/studentidfield',
                new lang_string('studentidfield', 'local_fxlmslink'),
                new lang_string('studentidfielddesc', 'local_fxlmslink'),
                'username',
                array(
                    'username'  => get_string('username')  . ' (username)',
                    'firstname' => get_string('firstname') . ' (firstname)',
                    'lastname'  => get_string('lastname')  . ' (lastname)',
                    'idnumber'  => get_string('idnumber')  . ' (idnumber)',
                    'department'  => get_string('department')  . ' (department)',
                    )
                )
            );
        $settings->add(
            new admin_setting_configipv4v6list('local_fxlmslink/allowips',
                new lang_string('allowips', 'local_fxlmslink'),
                new lang_string('allowipsdesc', 'local_fxlmslink'),
                '127.0.0.1')
            );
        $settings->add(
            new admin_setting_configcheckbox('local_fxlmslink/defer',
                new lang_string('defer', 'local_fxlmslink'),
                new lang_string('deferdesc', 'local_fxlmslink'),
                1)
            );
        $settings->add(
            new admin_setting_configselect('local_fxlmslink/authority',
                new lang_string('authority', 'local_fxlmslink'),
                new lang_string('authoritydesc', 'local_fxlmslink'),
                0,
                array(
                    0 => get_string('authorityno', 'local_fxlmslink'),
                    1 => get_string('authorityyes', 'local_fxlmslink')
                )
            )
        );
        $this->add($this->name, $settings);

    }
}
