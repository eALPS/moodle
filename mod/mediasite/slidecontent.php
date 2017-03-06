<?php

namespace Sonicfoundry;
use Sonicfoundry\EDAS as EDAS;

global $CFG;
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");

/**
 * Class SlideContent
 * @package Sonicfoundry
 */
class SlideContent {
    /**
     * @param string $baseUrl
     * @param null|\stdClass $json
     */
    function __construct($baseUrl, $json = null) {
        if(!is_null($json)) {
            if($json instanceof EDAS\SlideDetails) {
                $this->Id = $json->Number;
                $this->Length = $json->Time;
                $this->OdataId = $json->Title;
                $this->ContentType = $json->Content;
            } else {
                $this->IsGeneratedFromVideoStream = $json->IsGeneratedFromVideoStream;

                $this->Id = $json->Id;
                $this->OdataId = $json->{'odata.id'};
                $this->ParentResourceId = $json->ParentResourceId;
                $this->ContentType = $json->ContentType;
                $this->Status = $json->Status;
                $this->ContentMimeType = $json->ContentMimeType;
                $this->EncodingOrder = $json->EncodingOrder;
                $this->Length = $json->Length;
                $this->FileNameWithExtension = $json->FileNameWithExtension;
                $this->ContentEncodingSettingsId = $json->ContentEncodingSettingsId;
                $this->ContentServerId = $json->ContentServerId;
                $this->ArchiveType = $json->ArchiveType;
                $this->IsTranscodeSource = $json->IsTranscodeSource;
                $this->ContentRevision = $json->ContentRevision;
                $this->FileLength = $json->FileLength;
                $this->StreamType = $json->StreamType;

                $this->SlideUrl = $baseUrl.'FileServer/Presentation/'.$this->ParentResourceId.'/'.$this->FileNameWithExtension;
            }
        }
    }

    public $IsGeneratedFromVideoStream;

    public $Id;
    public $OdataId;
    public $ParentResourceId;
    public $ContentType;
    public $Status;
    public $ContentMimeType;
    public $EncodingOrder;
    public $Length;
    public $FileNameWithExtension;
    public $ContentEncodingSettingsId;
    public $ContentServerId;
    public $ArchiveType;
    public $IsTranscodeSource;
    public $ContentRevision;
    public $FileLength;
    public $StreamType;
    public $SlideUrl;
}