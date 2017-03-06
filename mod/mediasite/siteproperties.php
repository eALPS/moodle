<?php

namespace Sonicfoundry;

global $CFG;
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");

/**
 * Class SiteProperties
 * @package Sonicfoundry
 */
class SiteProperties {
    /**
     * @param null|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            if(isset($json->Properties)) {
                $this->SiteDescription = $json->Properties->Description;
                $this->SiteName = $json->Properties->Name.'/'.$json->Properties->SiteId;
                $this->SiteVersion = $json->Properties->Version;
                $this->ApiVersion = $json->Properties->Edition;
                $this->SiteOwner = $json->Properties->Owner;
                $this->SiteOwnerContact = $json->Properties->OwnerContact;
                $this->SiteOwnerEmail = $json->Properties->OwnerEmail;
                $this->SiteRootUrl = $json->Properties->SiteRootUrl;
                $this->RootFolderId = $json->Properties->RootFolderId;
            } else {
                $this->Folders = $json->{'Folders@odata.navigationLinkUrl'};
                $this->ApiVersion = $json->ApiVersion;
                $this->ApiPublishedDate = $json->ApiPublishedDate;
                $this->SiteName = $json->SiteName;
                $this->SiteDescription = $json->SiteDescription;
                $this->SiteVersion = $json->SiteVersion;
                $this->SiteOwner = $json->SiteOwner;
                $this->SiteOwnerContact = $json->SiteOwnerContact;
                $this->SiteOwnerEmail = $json->SiteOwnerEmail;
                $this->SiteRootUrl = $json->SiteRootUrl;
                $this->ServiceRootUrl = $json->ServiceRootUrl;
                $this->LoggedInUserName = $json->LoggedInUserName;
                $this->RootFolderId = $json->RootFolderId;
            }
        }
    }
    // Navigation Property
    public $Folders;
    // 'Normal' properties
    public $ApiVersion;
    public $ApiPublishedDate;
    public $SiteName;
    public $SiteDescription;
    public $SiteVersion;
    public $SiteOwner;
    public $SiteOwnerContact;
    public $SiteOwnerEmail;
    public $SiteRootUrl;
    public $ServiceRootUrl;
    public $LoggedInUserName;
    public $RootFolderId;

}
