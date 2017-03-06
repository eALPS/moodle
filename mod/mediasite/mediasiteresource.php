<?php

namespace Sonicfoundry;

/**
 * Class MediasiteResource
 * @package Sonicfoundry
 */
class MediasiteResource {
    function __construct($record) {
        if($record instanceof \stdClass) {
            $this->id = $record->id;
            $this->course = $record->course;
            $this->name = $record->name;
            $this->description = $record->description;
            $this->resourceid = $record->resourceid;
            $this->resourcetype = $record->resourcetype;
            $this->openaspopup = $record->openaspopup;
            $this->duration = $record->duration;
            $this->restrictip = $record->restrictip;
            $this->timecreated = $record->timecreated;
            $this->timemodified = $record->timemodified;
            $this->siteid = $record->siteid;
        }
    }
    public $id;
    public $course;
    public $name;
    public $description;
    public $resourceid;
    public $resourcetype;
    public $openaspopup;
    public $duration;
    public $restrictip;
    public $timecreated;
    public $timemodified;
    public $siteid;
} 