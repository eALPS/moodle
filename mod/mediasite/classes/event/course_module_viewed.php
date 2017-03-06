<?php

namespace mod_mediasite\event;
defined('MOODLE_INTERNAL') || die();

class course_module_viewed extends \core\event\course_module_viewed {
    
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'mediasite';
    }
    
//	parent class handles the following functions.   
//    public function get_url() {
//        return new \moodle_url("mod/mediasite/view.php", array('id' => $this->contextinstanceid));
//    }
//
//    public function get_description() {
//        return "The user with id {$this->userid} viewed the mediasite activity with the course module id {$this->contextinstanceid}.";
//    }
//    
//    public static function get_name() {
//        return get_string('eventcoursemoduleviewed', 'mediasite');
//    }
    
//    public function get_legacy_logdata() {
//    // Override if you are migrating an add_to_log() call.
//        return array($this->courseid, 'mediasite', 'view',
//                            'view.php?id=' . $this->objectid, $this->objectid,$this->contextinstanceid);
//    }
}