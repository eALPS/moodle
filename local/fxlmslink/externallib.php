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

require_once __DIR__.'/../../lib/externallib.php';
require_once __DIR__.'/class/assign.php';

/**
 * FXLMSLink ファイル提出 Web サービス
 *
 * Sakai API をエミュレートするためにログインセッションは独自に実装し、
 * Moodle ユーザはトークンによって認証されたアカウント利用する
 * したがって、ログインユーザとは無関係にトークンユーザの権限で動作する
 */
class local_fxlmslink_external extends external_api {
    /**
     * @const int セッション有効期限 [秒]
     */
    const SESSION_LIFETIME = 5400;

    /**
     * セッション情報の取得
     *
     * @global moodle_database $DB
     * @param string $id ユーザ名
     * @param string $pw パスワード
     * @return string セッションID
     * @throws moodle_exception
     */
    public static function login($id, $pw) {
        global $DB;

        self::validate_remoteaddr();
        self::validate_parameters(
            self::login_parameters(), compact('id', 'pw')
            );

        // ユーザの有効性をチェック (権限やサイトメンテナンス中などは考慮しない)
        $user = authenticate_user_login($id, $pw);
        if (!$user || isguestuser($user))
            throw new moodle_exception('unabletologin', 'local_fxlmslink');
        
        if(get_config('local_fxlmslink', 'authority')) {
            if (!self::checkCapability($user->id)) {
                throw new moodle_exception('unabletologin', 'local_fxlmslink');
            }
        }
        
        // セッション生成
        $session = new stdClass;
        $session->sid          = self::unique_uuid();
        $session->userid       = $user->id;
        $session->timemodified = $session->timecreated = time();
        $session->lastip       = $session->firstip     = getremoteaddr();
        $DB->insert_record('local_fxlmslink_sessions', $session);
		
        return $session->sid;
    }
    public static function login_parameters() {
        return new external_function_parameters(array(
            'id' => new external_value(PARAM_TEXT),
            'pw' => new external_value(PARAM_TEXT),
            ));
    }
    public static function login_returns() {
        return new external_value(PARAM_TEXT);
    }

    /**
     * セッション情報の解放
     *
     * @global moodle_database $DB
     * @param string $sessionid セッションID
     * @return boolean 常にtrue
     * @throws moodle_exception
     */
    public static function logout($sessionid) {
        global $DB;

        self::validate_remoteaddr();
        self::validate_parameters(
            self::logout_parameters(), compact('sessionid')
            );

        // 明示的にセッションを解放
        $DB->delete_records('local_fxlmslink_sessions', array('sid' => $sessionid));
        // 期限の切れたセッションを全て解放
        $DB->delete_records_select('local_fxlmslink_sessions',
            'timemodified < ?', array(time() - self::SESSION_LIFETIME)
            );

        return true;
    }
    public static function logout_parameters() {
        return new external_function_parameters(array(
            'sessionid' => new external_value(PARAM_TEXT),
            ));
    }
    public static function logout_returns() {
        return new external_value(PARAM_BOOL);
    }

    /**
     * 教員情報取得
     *
     * @global string $FULLME
     * @param string $sessionId セッションID
     * @param string $userId    教員ユーザID
     * @return struct 教員情報
     * @throws moodle_exception
     */
    public static function get_instructor_info($sessionId, $userId) {
        global $FULLME;

        self::validate_remoteaddr();
        self::validate_parameters(
            self::get_instructor_info_parameters(), compact('sessionId', 'userId')
            );
        self::validate_session($sessionId);

        // 教員ユーザを授業支援ボックス側IDに紐付けて取得
        $instructor = self::get_user_by_fxid('teacher', $userId);
        if (empty($instructor->email)) {
            throw new moodle_exception('noemailaddress', 'local_fxlmslink');
		}

        if(get_config('local_fxlmslink', 'authority')) {
            if (!self::checkCapability($user->id)) {
                throw new moodle_exception('unabletologin', 'local_fxlmslink');
            }
        }
		
        // 教員の担当しているコースとコース内の課題一覧を取得
        $courses = array();
        foreach (self::get_courses_managed_by($instructor->id) as $course) {
            $course->activeassigns = array();
            $modinfo = get_fast_modinfo($course->id);
            foreach ($modinfo->get_sections() as $cmids) {
                foreach ($cmids as $cmid) {
                    $cm = $modinfo->get_cm($cmid);
                    if ($cm->modname != 'assign')
                        continue;
                    $assign = new fxlmslink\assign($cm->context, $cm, $course);
                    if (!$assign->is_file_submission_enabled())
                        continue;
                    $cutoffdate = $assign->get_instance()->cutoffdate;
                    if ($cutoffdate == 0 || time() < $cutoffdate)
                        $course->activeassigns[$cmid] = $cm;
                }
            }
            if (!empty($course->activeassigns))
                $courses[$course->id] = $course;
        }
        if (empty($courses)) {
            throw new moodle_exception('nocourses', 'local_fxlmslink');
		}

        // 生のSOAP-XMLを生成して直接出力する
        $xml  = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
        $xml .= '<SOAP-ENV:Envelope';
        $xml .= ' xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"';
        $xml .= ' xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"';
        $xml .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $xml .= ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
        $xml .= ' xmlns:ns1="' . s($FULLME) . '"';
        $xml .= ' SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">';
        $xml .= '<SOAP-ENV:Body>';
        $xml .= '<ns1:getInstructorInfoResponse xsi:type="ns1:getInstructorInfoResponse">';
        $xml .= '<getInstructorInfoReturn xsi:type="ns1:getInstructorInfoReturn">';
        $xml .= '<InstructorInfoRequestResponse xsi:type="ns1:InstructorInfoRequestResponse">';
        $xml .= '  <version xsi:type="xsd:string">1.0</version>';
        $xml .= '  <result xsi:type="xsd:string">Success</result>';
        $xml .= '  <lmsName xsi:type="xsd:string">Moodle</lmsName>';
        $xml .= '  <lmsVersion xsi:type="xsd:string">' . moodle_major_version() . '</lmsVersion>';
        $xml .= '  <serverId xsi:type="xsd:string">' . s($_SERVER['SERVER_ADDR']) . '</serverId>';
        $xml .= '  <requestId xsi:type="xsd:dateTime">' . gmdate(DATE_ATOM) . '</requestId>';
        $xml .= '  <instructorId xsi:type="xsd:string">' . s($userId)  . '</instructorId>';
        $xml .= '  <instructorName xsi:type="xsd:string">' . s(fullname($instructor))  . '</instructorName>';
        $xml .= '  <emailAddress xsi:type="xsd:string">' . s($instructor->email)  . '</emailAddress>';
        foreach ($courses as $course) {
            $xml .= '<course xsi:type="ns1:course">';
            $xml .= '  <courseId xsi:type="xsd:string">' . s($course->id) . '</courseId>';
            $xml .= '  <courseTitle xsi:type="xsd:string">' . s($course->fullname) . '</courseTitle>';
            $xml .= '  <courseCode xsi:type="xsd:string">' . s($course->shortname) . '</courseCode>';
            foreach ($course->activeassigns as $assign) {
                $xml .= '<assignment xsi:type="ns1:assignment">';
                $xml .= '  <assignmentId xsi:type="xsd:string">' . self::id_to_uuid('assign', $assign->id) . '</assignmentId>';
                $xml .= '  <assignmentTitle xsi:type="xsd:string">' . s($assign->name) . '</assignmentTitle>';
                $xml .= '</assignment>';
            }
            $xml .= '</course>';
        }
        $xml .= '</InstructorInfoRequestResponse>';
        $xml .= '</getInstructorInfoReturn>';
        $xml .= '</ns1:getInstructorInfoResponse>';
        $xml .= '</SOAP-ENV:Body>';
        $xml .= '</SOAP-ENV:Envelope>';
        header('Content-Type: text/xml; charset=utf-8');
        echo $xml;
		
        exit;
    }
    public static function get_instructor_info_parameters() {
        return new external_function_parameters(array(
            'sessionId' => new external_value(PARAM_TEXT),
            'userId'    => new external_value(PARAM_TEXT),
            ));
    }
    public static function get_instructor_info_returns() {
        return new external_single_structure(array(
            'version'        => new external_value(PARAM_TEXT),
            'result'         => new external_value(PARAM_TEXT),
            'lmsName'        => new external_value(PARAM_TEXT),
            'lmsVersion'     => new external_value(PARAM_TEXT),
            'serverId'       => new external_value(PARAM_TEXT),
            'requestId'      => new external_value(PARAM_TEXT), // xs:dateTime
            'instructorId'   => new external_value(PARAM_TEXT),
            'instructorName' => new external_value(PARAM_TEXT),
            'emailAddress'   => new external_value(PARAM_TEXT),
            'course' => new external_multiple_structure(new external_single_structure(array(
                'courseId'    => new external_value(PARAM_TEXT),
                'courseTitle' => new external_value(PARAM_TEXT),
                'courseCode'  => new external_value(PARAM_TEXT),
                'assignment'  => new external_multiple_structure(new external_single_structure(array(
                    'assignmentId'    => new external_value(PARAM_TEXT),
                    'assignmentTitle' => new external_value(PARAM_TEXT),
                    ))),
                ))),
            ));
    }

    /**
     * 課題に添付ファイルを付けて評価・返却する
     *
     * @global moodle_database $DB
     * @param string $sessionId       セッションID
     * @param string $userId          学生証番号
     * @param string $assignmentId    教員が授業支援ボックスパネルで選択した課題ID
     * @param string $attachmentName  登録するPDFファイル名
     * @param string $attachmentData  Base64 エンコードされた PDF のデータ
     * @param int    $grade           得点
     * @param string $option          オプション文字列
     * @return string 正常終了時: "Success", エラー発生時: エラーメッセージ
     * @throws moodle_exception
     */
    public static function create_submission($sessionId, $userId, $assignmentId, $attachmentName, $attachmentData, $grade, $option) {
        global $DB;

        self::validate_remoteaddr();
        self::validate_parameters(
            self::create_submission_parameters(), compact('sessionId', 'userId', 'assignmentId', 'attachmentName', 'attachmentData', 'grade', 'option')
            );
        self::validate_session($sessionId);

        // 授業支援ボックス側IDから紐付く学生ユーザを取得
        $student = self::get_user_by_fxid('student', $userId);

        // 課題UUIDからインスタンスを取得
        $cmid = self::uuid_to_id('assign', $assignmentId);
        $cm = get_coursemodule_from_id('assign', $cmid);
        if (!$cm) {
            throw new moodle_exception('invalidassignmentid', 'local_fxlmslink');
		}
        $course = $DB->get_record('course', array('id' => $cm->course));
        if (!$course) {
            throw new moodle_exception('invalidassignmentid', 'local_fxlmslink');
		}
        $assign = new fxlmslink\assign(context_module::instance($cm->id), $cm, $course);

        // ファイル名とデータをデコードし、妥当性チェック
        $filename = clean_param($attachmentName, PARAM_FILE);
        $filedata = base64_decode($attachmentData);
        if (empty($filename)) {
            throw new moodle_exception('invalidfilename', 'local_fxlmslink');
		}

        // 指定の学生のファイルを提出
        try {
            $assign->create_deferred_submission($student->id, $filename, $filedata, $grade);
        } catch (invalid_parameter_exception $ex) {
            // 評点が 0～100 の範囲外
            throw new moodle_exception('other', 'local_fxlmslink');
        } catch (file_exception $ex) {
            // DiskFull/FileWriteError の区別は付かないので一律 FileWriteError とする
            throw new moodle_exception('filewriteerror', 'local_fxlmslink');
        } catch (moodle_exception $ex) {
            // その他のエラー
            throw new moodle_exception('invaliduserid', 'local_fxlmslink');
        }

        if (!get_config('local_fxlmslink', 'defer')) {
            // 保留領域を使用しない設定の場合は即座に課題へ登録
            $assign->finish_deferred_submission($student->id);
        }

        return 'Success';
    }
    public static function create_submission_parameters() {
        return new external_function_parameters(array(
            'sessionId'      => new external_value(PARAM_TEXT),
            'userId'         => new external_value(PARAM_TEXT),
            'assignmentId'   => new external_value(PARAM_TEXT),
            'attachmentName' => new external_value(PARAM_TEXT),
            'attachmentData' => new external_value(PARAM_TEXT),
            'grade'          => new external_value(PARAM_INT),
            'option'         => new external_value(PARAM_TEXT),
            ));
    }
    public static function create_submission_returns() {
        return new external_value(PARAM_TEXT);
    }

    /**
     * 指定ユーザが教員として管理しているコース一覧を取得
     *
     * @global object $CFG
     * @param int $userid
     * @return object[]
     */
    private static function get_courses_managed_by($userid) {
        global $CFG;

        $managerroles = explode(',', $CFG->coursecontact);
        $courses = array();
        foreach (enrol_get_all_users_courses($userid) as $course) {
            $ctx = context_course::instance($course->id);
            $rusers = get_role_users($managerroles, $ctx, true, 'u.id', 'u.id');
            if (isset($rusers[$userid]))
                $courses[$course->id] = $course;
        }
        return $courses;
    }

    /**
     * 授業支援ボックス側IDに紐付いたユーザを取得
     *
     * @param string $teacherorstudent 'teacher' or 'student'
     * @param string $fxid
     * @return object
     * @throws moodle_exception
     */
    private static function get_user_by_fxid($teacherorstudent, $fxid) {
        global $DB;

        // 空文字列は不正なIDとして事前に除外 (idnumber は空文字列が存在し得るため)
        if (strlen($fxid) == 0)
            throw new moodle_exception('invaliduserid', 'local_fxlmslink');

        // 授業支援ボックス側IDがMoodleではどのフィールドに紐付けられているかをプラグイン設定から取得
        if ($teacherorstudent != 'teacher' && $teacherorstudent != 'student')
            throw new moodle_exception('other', 'local_fxlmslink');
        $idfield = get_config('local_fxlmslink', $teacherorstudent . 'idfield') ?: 'username';
        if (!self::is_valid_idfield($idfield))
            throw new moodle_exception('other', 'local_fxlmslink');

        // 大文字小文字を区別せずにユーザを検索
        try {
            $user = $DB->get_record_select('user',
                $DB->sql_like($idfield, ':id', false),
                array('id' => $fxid), '*', MUST_EXIST);
            if (isguestuser($user))
                throw new moodle_exception('invaliduserid', 'local_fxlmslink');
            return $user;
        } catch (dml_exception $ex) {
            // 見つからない or 複数ヒットした場合は InvalidUserID エラー
            throw new moodle_exception('invaliduserid', 'local_fxlmslink');
        }
    }

    /**
     * セッションIDを検証
     *
     * @global moodle_database $DB
     * @param string $sessionId
     * @throws moodle_exception InvalidSessionID
     */
    private static function validate_session($sessionId) {
        global $DB;
        $session = $DB->get_record_select('local_fxlmslink_sessions',
            'sid = :sid AND timemodified >= :time',
            array('sid' => $sessionId, 'time' => time() - self::SESSION_LIFETIME)
            );
        if (!$session)
            throw new moodle_exception('invalidsessionid', 'local_fxlmslink');
        $user = $DB->get_record_select('user',
            'id = :id AND deleted = 0 AND suspended = 0',
            array('id' => $session->userid)
            );
        if (!$user || isguestuser($user))
            throw new moodle_exception('invalidsessionid', 'local_fxlmslink');
        $session->timemodified = time();
        $session->lastip = getremoteaddr();
        $DB->update_record('local_fxlmslink_sessions', $session);
    }

    private static function validate_remoteaddr() {
        $remoteip = getremoteaddr();
        $allowips = get_config('local_fxlmslink', 'allowips');
        foreach (preg_split('/\s+/', $allowips, -1, PREG_SPLIT_NO_EMPTY) as $ip) {
            if ($ip === '0.0.0.0/0' || $remoteip === $ip || address_in_subnet($remoteip, $ip))
                return;
        }
        send_header_404();
        die;
    }

    private static function is_valid_idfield($idfield) {
        return preg_match('/^[a-z]+$/', $idfield);
    }

    private static function unique_uuid() {
        if (!function_exists('openssl_random_pseudo_bytes'))
            throw new moodle_exception('other', 'local_fxlmslink');
        $x = bin2hex(openssl_random_pseudo_bytes(16));
        return preg_replace('/^(.{8})(.{4})(.{4})(.{4})(.{12})$/', '$1-$2-$3-$4-$5', $x);
    }
    private static function id_to_uuid($prefix, $id) {
        return preg_replace('/^(.{8})(.{4})(.{4})(.{4}).*$/', '$1-$2-$3-$4-', sha1($prefix)) . sprintf('%012x', $id);
    }
    private static function uuid_to_id($prefix, $uuid) {
        list ($a, $b, $c, $d, $x) = explode('-', $uuid, 5);
        if (substr_compare($a . $b . $c . $d, sha1($prefix), 0, 20, true) != 0)
            return null;
        list ($id) = sscanf($x, '%012x');
        return $id;
    }
    
    private static function checkCapability($userid) {
        global $DB;
        
        $courses = $DB->get_records('course');
        $capability = false;
        
        foreach($courses as $course) {
            $coursecontext = context_course::instance($course->id);
            if(has_capability('local/fxlmslink:enabled_fxlmslink', $coursecontext, $userid)) {
                $capability = true; 
                break;
            }
        }
        
        return $capability;
    }
}
