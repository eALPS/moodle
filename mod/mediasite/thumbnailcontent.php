<?php

namespace Sonicfoundry;

/**
 * Class ThumbnailContent
 * @package Sonicfoundry
 */
class ThumbnailContent {
    /**
     * @param null|string|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            if(is_string($json)) {
                $this->ThumbnailUrl = $json;
            } else {
                $this->Id = $json->Id;
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
                $this->ThumbnailUrl = $json->ThumbnailUrl;
            }
        }
    }

    /**
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->resourceid = $this->Id;
        $record->contenttype = $this->ContentType;
        $record->status = $this->Status;
        $record->contentmimetype = $this->ContentMimeType;
        $record->encodingorder = $this->EncodingOrder;
        $record->length = $this->Length;
        $record->filenamewithextension = $this->FileNameWithExtension;
        $record->contentencodingsettingsid = $this->ContentEncodingSettingsId;
        $record->contentserverid = $this->ContentServerId;
        $record->archivetype = $this->ArchiveType;
        $record->istranscodesource = $this->IsTranscodeSource;
        $record->contentrevision = $this->ContentRevision;
        $record->filelength = $this->FileLength;
        $record->streamtype = $this->StreamType;
        $record->url = $this->ThumbnailUrl;
        return $record;
    }
    public $Id;
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
    public $ThumbnailUrl;
}
