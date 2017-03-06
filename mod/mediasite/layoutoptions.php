<?php

namespace Sonicfoundry;

global $CFG;

require_once("$CFG->dirroot/mod/mediasite/utility.php");

class Option {
    function __construct($allowoverride = false, $value = false) {
        $this->AllowOverride = $allowoverride;
        $this->Value = $value;
    }
    public $AllowOverride;
    public $Value;
}

/**
 * Class LayoutOptions
 * @package Sonicfoundry
 */
class LayoutOptions {
    /**
     * @param null|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json))
        {
            $this->Id = $json->MediasiteId;
            if(!is_null($json->EnablePresentationInfo))
                $this->EnablePresentationInfo = new Option($json->EnablePresentationInfo->AllowOverride, $json->EnablePresentationInfo->Value);
            if(!is_null($json->ShowDateTime))
                $this->ShowDateTime = new Option($json->ShowDateTime->AllowOverride, $json->ShowDateTime->Value);
        }
    }

    /**
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->resourceid = $this->Id;
        return $record;
    }
    public $Id;
    public $EnablePresentationInfo;
    public $ShowDateTime;
}
