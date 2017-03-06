<?php
namespace Sonicfoundry;

global $CFG;
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");

/**
 * Class Tag
 * @package Sonicfoundry
 */
class Tag {
    /**
     * @param null|string|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            if(is_string($json)) {
                $this->Tag = $json;
            } else {
                $this->Id = $json->Id;
                $this->MediasiteId = $json->MediasiteId;
                $this->Tag = $json->Tag;
            }
        }
    }

    /**
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->id = $this->Id;
        $record->mediasiteid = $this->MediasiteId;
        $record->tag = $this->Tag;
        return $record;
    }
    public $Id;
    public $MediasiteId;
    public $Tag;
} 