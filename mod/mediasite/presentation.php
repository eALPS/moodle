<?php
namespace Sonicfoundry;
use Sonicfoundry\EDAS as EDAS;

global $CFG;

require_once("$CFG->dirroot/mod/mediasite/slidecontent.php");
require_once("$CFG->dirroot/mod/mediasite/presenter.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
require_once("$CFG->dirroot/mod/mediasite/tag.php");
require_once("$CFG->dirroot/mod/mediasite/utility.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_functions.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_enumerations.php");

/**
 * Class DefaultPresentation
 * @package Sonicfoundry
 */
class DefaultPresentation {
    /**
     * @param null|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            if($json instanceof EDAS\PresentationDetails) {
                $this->Id = $json->Id;
                $this->Name = $json->Name;
                $this->Status = $json->Status;
                if(isset($json->Content) && isset($json->Content->PresentationContentDetails) && is_array($json->Content->PresentationContentDetails)) {
                    for($i = 0; $i < count($json->Content->PresentationContentDetails); $i++) {
                        if(!strcmp($json->Content->PresentationContentDetails[$i]->ContentType, EDAS\PresentationContentTypeDetails::PresentationThumbnail)) {
                            $this->ThumbnailContent = $json->FileServerUrl.'/Presentation/'.$json->Id.'/'.$json->Content->PresentationContentDetails[$i]->FileNameWithExtension;
                            break;
                        }
                    }
                }
                if(isset($json->Presenters)) {
                    $this->Presenters = array();
                    if(is_array($json->Presenters->PresenterName)) {
                        for($i = 0; $i < count($json->Presenters->PresenterName); $i++) {
                            array_push($this->Presenters, new Presenter($json->Presenters->PresenterName[$i]));
                        }
                    } else {
                        array_push($this->Presenters, new Presenter($json->Presenters->PresenterName));
                    }
                }
                if(isset($json->Tags) && is_array($json->Tags)) {
                    $this->Tags = array();
                    for($i = 0; $i < count($json->Tags); $i++) {
                        array_push($this->Tags, new Tag($json->Tags[$i]));
                    }
                }
            } else {
                $this->Tags = $json->{'Tags@odata.navigationLinkUrl'};
                $this->TimedEvents = $json->{'TimedEvents@odata.navigationLinkUrl'};
                $this->Presenters = $json->{'Presenters@odata.navigationLinkUrl'};
                $this->Questions = $json->{'Questions@odata.navigationLinkUrl'};
                $this->ThumbnailContent = $json->{'ThumbnailContent@odata.navigationLinkUrl'};
                $this->SlideContent = $json->{'SlideContent@odata.navigationLinkUrl'};
                $this->OnDemandContent = $json->{'OnDemandContent@odata.navigationLinkUrl'};
                $this->BroadcastContent = $json->{'BroadcastContent@odata.navigationLinkUrl'};
                $this->PodcastContent = $json->{'PodcastContent@odata.navigationLinkUrl'};
                $this->OcrContent = $json->{'ThumbnailContent@odata.navigationLinkUrl'};
                $this->CaptionContent = $json->{'CaptionContent@odata.navigationLinkUrl'};
                $this->AudioPeaksContent = $json->{'AudioPeaksContent@odata.navigationLinkUrl'};

                $this->Id = $json->Id;
                $this->Name = $json->Title;
                $this->Status = $json->Status;
            }
        }
    }
    // Navigation Properties
    public $Tags;
    public $TimedEvents;
    public $Presenters;
    public $Questions;
    public $ThumbnailContent;
    public $SlideContent;
    public $OnDemandContent;
    public $BroadcastContent;
    public $PodcastContent;
    public $OcrContent;
    public $CaptionContent;
    public $AudioPeaksContent;
    // 'Normal' properties
    public $Id;
    public $Name;
    public $Status;
    // 'Actions'
    public $Play;

    /**
     * @return \stdClass
     * @usedby CardPresentation::DatabaseRecord()
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->resourceid = $this->Id;
        $record->name = substr_unicode($this->Name, 0, 255);
        $record->status = $this->Status;
        $record->play = $this->Play;
        return $record;
    }
    private $_thumbnails = array();
    public function AddThumbnail(ThumbnailContent $thumbnail) {
        $this->_thumbnails[] = $thumbnail;
    }
    private $_presenters = array();
    public function AddPresenter(Presenter $presenter) {
        $this->_presenters[] = $presenter;
    }
    private $_slides = array();
    public function AddSlide(Presenter $presenter) {
        $this->_presenters[] = $presenter;
    }
}

/**
 * Class CardPresentation
 * @package Sonicfoundry
 */
class CardPresentation extends DefaultPresentation {
    /**
     * @param null|\stdClass $json
     * @uses DefaultPresentation::__construct($json)
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            parent::__construct($json);
            if($json instanceof EDAS\PresentationDetails) {
                $this->Description = $json->Description;
                $this->RecordDate = $json->CreationDate;
                $this->Duration = $json->Duration;
                $this->Owner = $json->Owner;
            } else {
                $this->Description = $json->Description;
                $this->RecordDate = $json->RecordDate;
                $this->Duration = $json->Duration;
                $this->NumberOfViews = $json->NumberOfViews;
                $this->Owner = $json->Owner;
            }
        }
    }

    /**
     * @uses DefaultPresentation::DatabaseRecord()
     * @return \stdClass
     * @usedby Presentation::DatabaseRecord()
     */
    public function DatabaseRecord() {
        $record = parent::DatabaseRecord();
        $record->description = $this->Description;
        $record->recorddate = $this->RecordDate;
        if($this->Duration > 999999) {
            $record->duration = 999999;
        } elseif($this->Duration < 0) {
            $record->duration = 0;
        } else {
            $record->duration = $this->Duration;
        }
        $record->numberofviews = $this->NumberOfViews;
        $record->owner = $this->Owner;
        return $record;
    }
    public $Description;
    public $RecordDate;
    public $Duration;
    public $NumberOfViews;
    public $Owner;
}

/**
 * Class Presentation
 * @package Sonicfoundry
 */
class Presentation extends CardPresentation {
    /**
     * @param null|\stdClass $json
     * @uses CardPresentation::__construct($json)
     */
    function __construct($json = null) {
        if(!is_null($json)) {
            parent::__construct($json);
            if($json instanceof EDAS\PresentationDetails) {
                $this->RootId = $json->PresentationRootId;
                $this->PlayerId = $json->PlayerId;
                $this->CopyrightNotice = $json->CopyrightNotice;
                $this->TimeZone = $json->TimeZoneId;
                $this->ApprovalState = $json->ApprovalState;
                $this->ApprovalRequiredChangeTypes = $json->ChangeTypes;
                $this->ContentRevision = $json->ContentRevision;
                $this->ParentFolderId = $json->ParentFolderId;
            } else {
                $this->RootId = $json->RootId;
                $this->PlayerId = $json->PlayerId;
                $this->PresentationTemplateId = $json->PresentationTemplateId;
                $this->AlternateName = $json->AlternateName;
                $this->CopyrightNotice = $json->CopyrightNotice;
                $this->MaximumConnections = $json->MaximumConnections;
                $this->PublishingPointName = $json->PublishingPointName;
                $this->IsUploadAutomatic = $json->IsUploadAutomatic;
                $this->TimeZone = $json->TimeZone;
                $this->PollsEnabled = $json->PollsEnabled;
                $this->ForumsEnabled = $json->ForumsEnabled;
                $this->SharingEnabled = $json->SharingEnabled;
                $this->PlayerLocked = $json->PlayerLocked;
                $this->PollsInternal = $json->PollsInternal;
                $this->Private = $json->Private;
                if(isset($json->NotifyOnMetaChanged))
                {
                    $this->NotifyOnMetaChanged = $json->NotifyOnMetaChanged;
                }
                $this->ApprovalState = $json->ApprovalState;
                $this->ApprovalRequiredChangeTypes = $json->ApprovalRequiredChangeTypes;
                $this->ContentRevision = $json->ContentRevision;
                $this->PollLink = $json->PollLink;
                $this->ParentFolderName = $json->ParentFolderName;
                $this->ParentFolderId = $json->ParentFolderId;
                $this->DisplayRecordDate = $json->DisplayRecordDate;
            }
        }
    }

    /**
     * @uses CardPresentation::DatabaseRecord()
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = parent::DatabaseRecord();
        return $record;
    }
    public $RootId;
    public $PlayerId;
    public $PresentationTemplateId;
    public $AlternateName;
    public $CopyrightNotice;
    public $MaximumConnections;
    public $PublishingPointName;
    public $IsUploadAutomatic;
    public $TimeZone;
    public $PollsEnabled;
    public $ForumsEnabled;
    public $SharingEnabled;
    public $PlayerLocked;
    public $PollsInternal;
    public $Private;
    public $NotifyOnMetaChanged;
    public $ApprovalState;
    public $ApprovalRequiredChangeTypes;
    public $ContentRevision;
    public $PollLink;
    public $ParentFolderName;
    public $ParentFolderId;
    public $DisplayRecordDate;
}

class ExpandedPresentation {
    public $Tags;
    public $Presenters;
    public $Thumbnails;
    public $Presentation;
}