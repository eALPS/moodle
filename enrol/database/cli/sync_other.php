<?php
// This file is part of Moodle - http://moodle.org/
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
 * CLI sync for full external database synchronisation.
 *
 * Sample cron entry:
 * # 5 minutes past 4am
 * 5 4 * * * $sudo -u www-data /usr/bin/php /var/www/moodle/enrol/database/cli/sync.php
 *
 * Notes:
 *   - it is required to use the web server account when executing PHP CLI scripts
 *   - you need to change the "www-data" to match the apache user account
 *   - use "su" if "sudo" not available
 *
 * @package    enrol_database
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

// add by eALPS Developer
global $_SERVER;

$siteEnName = 'other';
$siteJaName = 'その他';

echo("年度更新しないサイト：".$siteJaName."の同期スタート\n");

$startTime = microtime(true);

$_SERVER['REQUEST_URI'] = '/'.$siteEnName.'/';
echo('SERVER[REQUEST_URI]：'.$_SERVER['REQUEST_URI']."\n");
// end by eALPS Developer
	
require(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
// add by eALPS Developer
require("$CFG->dirroot/lib/setup.php");
require_once($template_base.'/enrol/database/lib.php');
require_once($CFG->libdir.'/clilib.php');
echo("必要ファイルの読み込みを完了しました．\n");
// end by eALPS Developer

// Now get cli options.
list($options, $unrecognized) = cli_get_params(
	array('verbose'=>false,
			'help'=>false
	), 
	array('v'=>'verbose',
			'h'=>'help'
	)
);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
"Execute enrol sync with external database.
The enrol_database plugin must be enabled and properly configured.

Options:
-v, --verbose         Print verbose progess information
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php enrol/database/cli/sync.php

Sample cron entry:
# 5 minutes past 4am
5 4 * * * \$sudo -u www-data /usr/bin/php /var/www/moodle/enrol/database/cli/sync.php
";

    echo $help;
    die;
}

if (!enrol_is_enabled('database')) {
    echo('enrol_database plugin is disabled, sync is disabled'."\n");
    exit(1);
}

$verbose = !empty($options['verbose']);
$enrol = enrol_get_plugin('database');
$result = 0;

$result = $result | $enrol->sync_courses($verbose);
$result = $result | $enrol->sync_enrolments($verbose);

// add by eALPS Developer
echo($result."\n");
echo($siteJaName."の同期が終了しました．\n");
$endTime = microtime(true);
$time = $endTime - $startTime;
echo('処理時間は'.$time."秒でした．\n\n");
// end by eALPS Developer

exit($result);