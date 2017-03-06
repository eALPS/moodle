<?php
namespace Sonicfoundry;

require_once(\dirname(__FILE__) . '/../../config.php');

/**
 * Progress class.
 *
 * Manages the display of a progress bar.
 *
 * To use this class.
 * - construct
 * - call create (or use the 3rd param to the constructor)
 * - call update or update_full() or update() repeatedly
 *
 */
class Progress {
    private $sessionid;
    private $dbid = -1;
    /** @var int time when last printed */
    private $lastupdate = 0;
    /** @var int when did we start printing this */
    private $time_start = 0;

    /**
     * Constructor
     *
     * Prints JS code if $autostart true.
     *
     * @param int $width
     * @param bool $autostart Default to false
     */
    public function __construct($sessionid) {
        $this->sessionid = $sessionid;
        $this->time_start = microtime(true);

        $record = new \stdClass();
        $record->sessionid = $sessionid;
        $record->processed = 0;
        $status = new \stdClass();
        $status->operation = 'Starting';
        $status->count = 0;
        $status->elapsed = 0;
        $record->status = json_encode($status);
        global $DB;
        if($DB->record_exists('mediasite_status', array('sessionid' => $sessionid))) {
            $DB->delete_records('mediasite_status', array('sessionid' => $sessionid));
        }
        $record->id = $DB->insert_record('mediasite_status', $record);
        $this->dbid = $record->id;
    }

    /**
     * Update the progress bar
     *
     * @param int $percent from 1-100
     * @param string $msg
     * @return void Echo's output
     * @throws coding_exception
     */
    private function _update($msg) {
        if (empty($this->time_start)) {
            throw new coding_exception('You must call create() (or use the $autostart ' .
                'argument to the constructor) before you try updating the progress bar.');
        }

        $this->lastupdate = microtime(true);
        try {
            global $DB;
            if($this->dbid > 0)
            {
                $record = new \stdClass();
                $record->id = $this->dbid;
            } else {
                $record = $DB->get_record('mediasite_status', array('sessionid' => $this->sessionid), 'id', MUST_EXIST);
            }
            $record->status = $msg;
            $record->processed = 0;
            $DB->update_record('mediasite_status', $record);
        } catch(Exception $e) {
            // Ignore
        }
    }

    /**
     * Update progress bar according the number of tasks
     *
     * @param string $msg message
     */
    public function update($msg) {
        $this->_update($msg);
    }

    public function finish() {
        $this->lastupdate = microtime(true);
        try {
            global $DB;
            $DB->delete_records('mediasite_status', array('sessionid' => $this->sessionid));
        } catch(Exception $e) {
            // Ignore
        }
    }

    /**
     * Restart the progress bar.
     */
    public function restart() {
        $this->lastupdate = 0;
        $this->time_start = 0;
    }
}
