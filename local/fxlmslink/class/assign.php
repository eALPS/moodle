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

require_once __DIR__.'/../../../mod/assign/lib.php';
require_once __DIR__.'/../../../mod/assign/locallib.php';
require_once __DIR__.'/../../../mod/assign/submission/file/locallib.php';

/**
 * FXLMSLink ファイル提出課題クラス
 */
class assign extends \assign {

    const FILE_COMPONENT = 'assignsubmission_file';
    const FILE_FILEAREA  = ASSIGNSUBMISSION_FILE_FILEAREA;
    const FILE_FILEPATH  = '/';

    /**
     * ファイル提出オプションが有効になっているかチェック
     *
     * @return boolean
     */
    public function is_file_submission_enabled() {
        /* @var $plugin \assign_plugin */
        $plugin = $this->get_plugin_by_type('assignsubmission', 'file');
        return $plugin && $plugin->is_enabled();
    }

    /**
     * 指定ユーザーの提出保留中レコード取得
     *
     * @global \moodle_database $DB
     * @param int $userid
     * @param int $strictness
     * @return object
     * @throws \dml_exception
     */
    public function get_deferred_submission_record($userid, $strictness = IGNORE_MISSING) {
        global $DB;
        return $DB->get_record('local_fxlmslink_submissions',
            array('assignment' => $this->get_instance()->id, 'userid' => $userid), '*', $strictness);
    }

    /**
     * 指定ユーザーの保留中の評点データ取得
     *
     * @global \moodle_database $DB
     * @param int $userid
     * @param int $strictness
     * @return float
     * @throws \dml_exception
     */
    public function get_deferred_submission_grade($userid, $strictness = IGNORE_MISSING) {
        global $DB;
        return $DB->get_field('local_fxlmslink_submissions', 'grade',
            array('assignment' => $this->get_instance()->id, 'userid' => $userid), $strictness);
    }

    /**
     * 指定ユーザーの保留中の提出ファイル取得
     *
     * @global \moodle_database $DB
     * @param int $userid
     * @param int $strictness
     * @return \stored_file|null
     * @throws \dml_exception
     */
    public function get_deferred_submission_file($userid, $strictness = IGNORE_MISSING) {
        global $DB;
        $filerecord = $DB->get_record_select('files',
            "contextid = :contextid AND
             component = :component AND
             filearea  = :filearea  AND
             itemid    = :itemid    AND
             filename <> '.'",
            array(
                'contextid' => $this->get_context()->id,
                'component' => 'local_fxlmslink',
                'filearea'  => self::FILE_FILEAREA,
                'itemid'    => $userid
                ),
            '*', $strictness);
        return $filerecord ? \get_file_storage()->get_file_instance($filerecord) : null;
    }

    /**
     * 指定ユーザーの提出保留データ作成
     *
     * 保留データが存在する場合は削除してから新規に作り直す
     *
     * @global \moodle_database $DB
     * @param int $userid
     * @param string $filename
     * @param string $filedata
     * @param float $grade
     * @throws \invalid_parameter_exception
     * @throws \file_exception
     * @throws \dml_exception
     */
    public function create_deferred_submission($userid, $filename, $filedata, $grade) {
        global $DB;
	
		\require_capability('mod/assign:submit', $this->get_context(), $userid);

        $this->delete_deferred_submission($userid);

        $filerecord = new \stdClass;
        $filerecord->contextid = $this->get_context()->id;
        $filerecord->component = 'local_fxlmslink';
        $filerecord->filearea  = self::FILE_FILEAREA;
        $filerecord->itemid    = $userid;
        $filerecord->filepath  = self::FILE_FILEPATH;
        $filerecord->filename  = $filename;
        $filerecord->userid    = $userid;
        \get_file_storage()->create_file_from_string($filerecord, $filedata);

        $record = new \stdClass;
        $record->assignment   = $this->get_instance()->id;
        $record->userid       = $userid;
        $record->grade        = $grade;
        $record->timecreated  = time();
        $record->timemodified = time();
        $DB->insert_record('local_fxlmslink_submissions', $record);
    }

    /**
     * 指定ユーザーの保留中の提出ファイル差し替え
     *
     * @param int $userid
     * @param string $filename
     * @param string $filedata
     * @throws \file_exception
     */
    public function update_deferred_submission_file($userid, $filename, $filedata) {
        $filerecord = new \stdClass;
        $filerecord->contextid = $this->get_context()->id;
        $filerecord->component = 'local_fxlmslink';
        $filerecord->filearea  = self::FILE_FILEAREA;
        $filerecord->itemid    = $userid;
        $filerecord->filepath  = self::FILE_FILEPATH;
        $filerecord->filename  = $filename;
        $filerecord->userid    = $userid;
        \get_file_storage()->delete_area_files(
            $filerecord->contextid,
            $filerecord->component,
            $filerecord->filearea,
            $filerecord->itemid);
        \get_file_storage()->create_file_from_string($filerecord, $filedata);
    }

    /**
     * 指定ユーザーの保留中の評点データ差し替え
     *
     * @global \moodle_database $DB
     * @param int $userid
     * @param float $grade
     * @throws \invalid_parameter_exception
     * @throws \dml_exception
     */
    public function update_deferred_submission_grade($userid, $grade) {
        global $DB;

        if ($grade < 0 || $this->get_grade_item()->grademax < $grade)
            throw new \invalid_parameter_exception();

        $record = $this->get_deferred_submission_record($userid, MUST_EXIST);
        $record->grade        = $grade;
        $record->timemodified = time();
        $DB->update_record('local_fxlmslink_submissions', $record);
    }

    /**
     * 指定ユーザーの提出保留データ削除
     *
     * @global \moodle_database $DB
     * @param int $userid
     */
    public function delete_deferred_submission($userid) {
        global $DB;
		
        $DB->delete_records('local_fxlmslink_submissions',
            array('assignment' => $this->get_instance()->id, 'userid' => $userid)
            );
        \get_file_storage()->delete_area_files(
            $this->get_context()->id,
            'local_fxlmslink',
            self::FILE_FILEAREA,
            $userid);
    }

    /**
     * 全てのユーザーの保留中の提出を削除
     *
     * @throws \required_capability_exception
     * @throws \file_exception
     * @throws \dml_exception
     */
    public function delete_deferred_submissions() {
        foreach (array_keys($this->list_participants(0, true)) as $userid) {
            if ($this->get_deferred_submission_record($userid))
                $this->delete_deferred_submission($userid);
        }
    }

    /**
     * 指定ユーザーの保留中の提出を確定
     *
     * @param int $userid
     * @throws \required_capability_exception
     * @throws \file_exception
     * @throws \dml_exception
     */
    public function finish_deferred_submission($userid) {
        global $DB, $USER;
		
        $deferredgrade = $this->get_deferred_submission_grade($userid, MUST_EXIST);
        $deferredfile = $this->get_deferred_submission_file($userid, MUST_EXIST);

        $user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);

        \require_capability('mod/assign:submit', $this->get_context(), $user->id);

        $submission = $this->get_user_submission($user->id, true);
        $submission->status = ASSIGN_SUBMISSION_STATUS_SUBMITTED;

        $filerecord = new \stdClass;
        $filerecord->contextid = $this->get_context()->id;
        $filerecord->component = self::FILE_COMPONENT;
        $filerecord->filearea  = self::FILE_FILEAREA;
        $filerecord->itemid    = $submission->id;
        $filerecord->filepath  = self::FILE_FILEPATH;
        $filerecord->filename  = $deferredfile->get_filename();
        $filerecord->userid    = $submission->userid;
        if ($oldfile = \get_file_storage()->get_file($filerecord->contextid, $filerecord->component,
            $filerecord->filearea, $filerecord->itemid, $filerecord->filepath, $filerecord->filename))
        {
            $oldfile->delete();
        }
        \get_file_storage()->create_file_from_storedfile($filerecord, $deferredfile);

        //plagiarism code event trigger when files are uploaded
        $files = \get_file_storage()->get_area_files(
            $filerecord->contextid, $filerecord->component, $filerecord->filearea,
            $filerecord->itemid, 'id', false);
        if (class_exists('\assignsubmission_file\event\assessable_uploaded')) {
            // Moodle 2.6 or later
            $params = array(
                'context'  => $this->get_context(),
                'objectid' => $submission->id,
                'other'    => array(
                    'content'        => '',
                    'pathnamehashes' => array_keys($files)
                )
            );
            $event = \assignsubmission_file\event\assessable_uploaded::create($params);
            $event->set_legacy_files($files);
            $event->trigger();
        } else {
            // Moodle 2.5 or earlier
            $eventdata = new \stdClass;
            $eventdata->modulename     = 'assign';
            $eventdata->cmid           = $this->get_course_module()->id;
            $eventdata->itemid         = $submission->id;
            $eventdata->courseid       = $this->get_course()->id;
            $eventdata->userid         = $userid;
            if (count($files) > 1) {
                $eventdata->files      = $files;
            }
            $eventdata->file           = $files;
            $eventdata->pathnamehashes = array_keys($files);
            \events_trigger('assessable_file_uploaded', $eventdata);
        }

        $filesubmission = $DB->get_record('assignsubmission_file', array('submission' => $submission->id));
        if ($filesubmission) {
            $filesubmission->numfiles   = count($files);
            $DB->update_record('assignsubmission_file', $filesubmission);
        } else {
            $filesubmission = new \stdClass;
            $filesubmission->numfiles   = count($files);
            $filesubmission->submission = $submission->id;
            $filesubmission->assignment = $this->get_instance()->id;
            $DB->insert_record('assignsubmission_file', $filesubmission);
        }

        $submission->timemodified = time() - 1;    // Modified for MDL-48861.
        $DB->update_record('assign_submission', $submission);

        $adminconfig = $this->get_admin_config();
        if (!empty($adminconfig->submissionreceipts)) {
			if (!empty($USER) && !empty($user)) {
				$this->send_notification($USER, $user, 'submissionreceipt', 'assign_notification', $submission->timemodified);
			}
        }

        if (method_exists('\mod_assign\event\assessable_submitted', 'create_from_submission')) {
            // Moodle 2.7 or later
            \mod_assign\event\assessable_submitted::create_from_submission($this, $submission, false)->trigger();
        } elseif (class_exists('\mod_assign\event\assessable_submitted')) {
            // Moodle 2.6
            $params = array(
                'context'  => $this->get_context(),
                'objectid' => $submission->id,
                'other'    => array('submission_editable' => true)
            );
            $event = \mod_assign\event\assessable_submitted::create($params);
            $event->add_record_snapshot('assign_submission', $submission);
            $event->trigger();
        } else {
            // Moodle 2.5 or earlier
            $info = \get_string('submissionstatus', 'assign') . ': '
                  . \get_string('submissionstatus_' . $submission->status, 'assign') . '. <br/>'
                  . $this->get_submission_plugin_by_type('file')->format_for_log($submission);
            $this->add_to_log('submit', $info);
            $eventdata = new \stdClass;
            $eventdata->modulename = 'assign';
            $eventdata->cmid       = $this->get_course_module()->id;
            $eventdata->itemid     = $submission->id;
            $eventdata->courseid   = $this->get_course()->id;
            $eventdata->userid     = $user->id;
            $eventdata->params     = array('submission_editable' => true);
            \events_trigger('assessable_submitted', $eventdata);
        }

        $gradedata = $this->get_user_grade($userid, true);
        $gradedata->grade  = $deferredgrade;
        $gradedata->grader = $userid;
        $this->update_grade($gradedata);

        $this->delete_deferred_submission($userid);
    }

    /**
     * 全てのユーザーの保留中の提出を確定
     *
     * @throws \required_capability_exception
     * @throws \file_exception
     * @throws \dml_exception
     */
    public function finish_deferred_submissions() {
        foreach (array_keys($this->list_participants(0, true)) as $userid) {
            if ($this->get_deferred_submission_record($userid))
                $this->finish_deferred_submission($userid);
        }
    }
}
