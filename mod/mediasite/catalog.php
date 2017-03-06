<?php

namespace Sonicfoundry;
use Sonicfoundry\EDAS as EDAS;

global $CFG;
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");

/**
 * Class Catalog
 * @package Sonicfoundry
 */
class Catalog {
    /**
     * @param null|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json))
        {
            if($json instanceof EDAS\CatalogShare) {
                $this->Id = $json->Id;
                $this->Name = $json->Name;
                $this->Description = $json->Description;
                $this->CatalogUrl = $json->CatalogUrl;
                $this->Recycled = $json->Recycled;
            } else {
                $this->Id = $json->Id;
                $this->LinkedFolderId = $json->LinkedFolderId;
                $this->Name = $json->Name;
                $this->Description = $json->Description;
                $this->CatalogUrl = $json->CatalogUrl;
                $this->Recycled = $json->Recycled;
            }
        }
    }

    /**
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->resourceid = $this->Id;
        $record->linkfolderid = $this->LinkedFolderId;
        $record->name = $this->Name;
        $record->description = $this->Description;
        $record->catalogurl = $this->CatalogUrl;
        $record->recycled = $this->Recycled;
        return $record;
    }
    public $Id;
    public $LinkedFolderId;
    public $Name;
    public $Description;
    public $CatalogUrl;
    public $Recycled;
}
