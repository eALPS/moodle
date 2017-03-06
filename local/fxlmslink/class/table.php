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
namespace fxlmslink;

require_once __DIR__.'/assign.php';

/**
 * @property-read \context_module $context
 * @property-read object $course
 * @property-read object $course_module
 * @property-read \grade_item $grade_item
 * @property-read object $instance
 */
class table extends \table_sql {
    /** @var assign */
    private $assign;

    /**
     * @param string $name
     * @return mixed
     * @throws \coding_exception
     */
    public function __get($name) {
        if (method_exists($this->assign, 'get_' . $name)) {
            return $this->assign->{'get_' . $name}();
        }
        throw new \coding_exception("Invalid property: $name");
    }

    /**
     * @global \moodle_database $DB
     * @param assign $assign
     */
    public function __construct(assign $assign) {
        global $DB;
        parent::__construct('local_fxlmslink_table');
        $this->assign = $assign;

        $this->define_baseurl(new \moodle_url('/local/fxlmslink/view.php', array('id' => $this->course_module->id)));

        $idfield = \get_config('local_fxlmslink', 'studentidfield') ?: 'username';

        $userfields = \user_picture::fields('u', \get_extra_user_fields($this->context));
        if (strpos($userfields, "u.{$idfield}") === false) {
            $userfields .= ", u.{$idfield}";
        }
        $userids = array_keys($assign->list_participants(0, true)) ?: array(-1);
        list ($userwhere, $userparams) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED, 'u');
        $fields = "$userfields, f.grade, f.timemodified AS timedeferred";
        $from = "{user} u LEFT JOIN {local_fxlmslink_submissions} f ON f.userid = u.id AND f.assignment = :instanceid";
        $where = "u.id $userwhere";
        $params = array('instanceid' => $this->instance->id) + $userparams;
        $this->set_sql($fields, $from, $where, $params);
        $this->sortable(true, $idfield);

        $columns = array(
            'picture'      => \get_string('pictureofuser'),
            'fullname'     => \get_string('fullname'),
            $idfield       => \get_string($idfield) . " ($idfield)",
            'grade'        => \get_string('grade'),
            'file'         => \get_string('file', 'assignsubmission_file'),
            'replacement'  => \get_string('replacement', 'local_fxlmslink'),
        );

        $this->no_sorting('file');
        $this->no_sorting('replacement');
        $this->define_columns(array_keys($columns));
        $this->define_headers(array_values($columns));
    }

    /**
     * @global \moodle_database $DB
     * @return boolean
     */
    public function record_exists() {
        global $DB;
        return $DB->record_exists('local_fxlmslink_submissions', array('assignment' => $this->instance->id));
    }

    /**
     * @return int
     */
    public function count_records() {
        return count($this->assign->list_participants(0, true));
    }

    /**
     * @global \core_renderer $OUTPUT
     * @param object $row
     * @return string
     */
    public function col_picture($row) {
        global $OUTPUT;
        return $row->picture ? $OUTPUT->user_picture($row) : '';
    }

    /**
     * @param object $row
     * @return string
     */
    public function col_grade($row) {
        if (empty($row->timedeferred))
            return '-';
        return self::input_tag('text', "grades[$row->id]", format_float($row->grade, 2), array('size' => 5))
             . ' / ' . format_float($this->grade_item->grademax, 2);
    }

    /**
     * @global \core_renderer $OUTPUT
     * @param object $row
     * @return string
     */
    public function col_file($row) {
        global $OUTPUT;

        $file = $this->assign->get_deferred_submission_file($row->id);
        if (!$file)
            return '-';
        $url = \moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(),
                                                $file->get_itemid(), $file->get_filepath(), $file->get_filename());
        $icon = $OUTPUT->pix_icon(\file_file_icon($file), $file->get_filename(), 'moodle', array('class' => 'icon'));
        $link = \html_writer::link($url, $file->get_filename());
        return \html_writer::tag('div', $icon . $link);
    }

    /**
     * @param object $row
     * @return string
     */
    public function col_replacement($row) {
        if (empty($row->timedeferred))
            return '-';
        return self::input_tag('file', "files[$row->id]", null, array('onchange' => 'this.form.submit()'));
    }

    private static function input_tag($type, $name, $value = null, array $attributes = array()) {
        return \html_writer::empty_tag('input', compact('type', 'name', 'value') + $attributes);
    }
}
