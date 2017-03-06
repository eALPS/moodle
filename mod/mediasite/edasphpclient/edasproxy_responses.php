<?php

    namespace Sonicfoundry\EDAS;

    require_once __DIR__ . '/edasproxy_functions.php';

    /**
     * Proxy classes for Mediasite External Data Access Service (Edas)
     * These proxy classes were generated based on the Mediasite 6.0 EDAS WSDL definition.
     * PHP Version 5.3
     *
     * @copyright  Copyright (c) 2013, Sonic Foundry
     * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
     * @version    6.1.7
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @subpackage Responses
     * @author     Cori Schlegel <coris@sonicfoundry.com>
     *             This software is provided "AS IS" without a warranty of any kind.
     */

    /**
     * Generated data proxy class for struct CreateRoleResponse
     *
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since      6.0
     * @deprecated deprecated in 6.1.1; CreateRole() returns the RoleId directly
     */
    class CreateRoleResponse
    {

        /**
         * @var string $RoleId
         */
        public $RoleId;

    }

    /**
     * Generated data proxy class for struct DataServiceFault
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class DataServiceFault
    {

        /**
         * @var DataServiceFaultType $FaultType
         */
        public $FaultType;

        /**
         * @var string $Message
         */
        public $Message;

    }

    /**
     * Generated data proxy class for struct UpdateRoleResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class UpdateRoleResponse
    {

    }

    /**
     * Generated data proxy class for struct QueryTotalViewsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class QueryTotalViewsResponse
    {

        /**
         * @var QueryResults $Results
         */
        public $Results;

        /**
         * @var IdNameTotalPair|IdNameTotalPair[] $ViewsList
         */
        public $ViewsList;

    }

    /**
     * Data proxy class for struct QueryTotalViewsByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class QueryTotalViewsByIdResponse extends QueryTotalViewsResponse
    {

    }

    /**
     * Generated data proxy class for struct QueryResults
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class QueryResults
    {

        /**
         * @var boolean $MoreResultsAvailable are there more results fpr this query
         */
        public $MoreResultsAvailable;

        /**
         * @var QueryOptions $NextQueryOptions options to pass the next query to get next resulset
         */
        public $NextQueryOptions;

        /**
         * @var int $TotalResults total number of results
         */
        public $TotalResults;

    }

    /**
     * Data proxy class for struct ViewsList
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    /*    class ViewsList
        {

            /**
         * @var IdNameTotalPair|IdNameTotalPair[] $IdNameTotalPair of {@link IdNameTotalPair}
         */
    /*    public $IdNameTotalPair;

    }*/

    /**
     * Generated data proxy class for struct IdNameTotalPair
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class IdNameTotalPair
    {

        /**
         * @var string $Id id of the queried for object
         */
        public $Id;

        /**
         * @var string $Name name of the queried-for object
         */
        public $Name;

        /**
         * @var int $Total number of views
         */
        public $Total;

    }

    /**
     * Generated data proxy class for struct QueryDatesWatchedResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryDatesWatchedResponse
    {

        /**
         * @var string[] $DatesWatchedList array of date/time formatted strings
         */
        public $DatesWatchedList;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct QueryPlatformUsageResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPlatformUsageResponse
    {

        /**
         * @var PlatformUsage $Usage
         */
        public $Usage;

    }

    /**
     * Generated data proxy class for struct PlatformUsage
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PlatformUsage
    {

        /**
         * @var IdNameTotalPair[] $BrowserList
         */
        public $BrowserList;

        /**
         * @var IdNameTotalPair[] $MediaPluginList
         */
        public $MediaPluginList;

        /**
         * @var IdNameTotalPair[] $PlayerEngineList
         */
        public $PlayerEngineList;

        /**
         * @var IdNameTotalPair[] $SystemList
         */
        public $SystemList;

    }

    /**
     * Generated data proxy class for struct QueryPresentationUsageResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPresentationUsageResponse
    {

        /**
         * @var QueryResults $Results
         */
        public $Results;

        /**
         * @var PresentationUsage[] $UsageList
         */
        public $UsageList;

    }

    /**
     * Generated data proxy class for struct PresentationUsage
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     */
    class PresentationUsage
    {
        /**
         * @var int $CoverageWatchedSeconds
         */
        public $CoverageWatchedSeconds;
        /**
         * @var string $FirstWatched date-time formatted string
         */
        public $FirstWatched;
        /**
         * @var string $Id
         */
        public $Id;
        /**
         * @var string $LastWatched date-time formatted string
         */
        public $LastWatched;
        /**
         * @var int $LiveViews
         */
        public $LiveViews;
        /**
         * @var string $Name
         */
        public $Name;
        /**
         * @var int $OnDemandViews
         */
        public $OnDemandViews;
        /**
         * @var double $PercentWatched
         */
        public $PercentWatched;
        /**
         * @var int $TotalTimeWatchedSeconds
         */
        public $TotalTimeWatchedSeconds;
        /**
         * @var int $TotalViews
         */
        public $TotalViews;
    }

    /**
     * Generated data proxy class for struct QueryServerUsageResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryServerUsageResponse
    {

        /**
         * @var ServerUsage $Usage
         */
        public $Usage;

    }

    /**
     * Generated data proxy class for struct ServerUsage
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ServerUsage
    {

        /**
         * @var int $LivePresentationsWatched
         */
        public $LivePresentationsWatched;

        /**
         * @var int $LiveViews
         */
        public $LiveViews;

        /**
         * @var int $OnDemandPresentationsWatched
         */
        public $OnDemandPresentationsWatched;

        /**
         * @var int $OnDemandViews
         */
        public $OnDemandViews;

        /**
         * @var int $TotalPresentationsWatched
         */
        public $TotalPresentationsWatched;

        /**
         * @var int $TotalViews
         */
        public $TotalViews;

    }

    /**
     * Generated data proxy class for struct QueryActivePresentationsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryActivePresentationsResponse
    {

        /**
         * @var IdNameTotalPair[] $ActivePresentationList
         */
        public $ActivePresentationList;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct QueryActiveConnectionsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryActiveConnectionsResponse
    {

        /**
         * @var ActiveConnections
         */
        public $Connections;

    }

    /**
     * Generated data proxy class for struct ActiveConnections
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ActiveConnections
    {

        /**
         * @var int $LiveConnections
         */
        public $LiveConnections;

        /**
         * @var int $LivePresentations
         */
        public $LivePresentations;

        /**
         * @var int $OnDemandConnections
         */
        public $OnDemandConnections;

        /**
         * @var int $OnDemandPresentations
         */
        public $OnDemandPresentations;

        /**
         * @var int $TotalConnections
         */
        public $TotalConnections;

        /**
         * @var int $TotalPresentations
         */
        public $TotalPresentations;

    }

    /**
     * Generated data proxy class for struct QueryActivePresentationConnectionsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryActivePresentationConnectionsResponse
    {

        /**
         * @var ActiveConnection[] $ConnectionsList
         */
        public $ConnectionsList;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct ActiveConnection
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ActiveConnection
    {

        /**
         * @var string $BeginPlayback date-time formatted string
         */
        public $BeginPlayback;

        /**
         * @var IdNamePair $Browser
         */
        public $Browser;

        /**
         * @var string $ConnectionType
         */
        public $ConnectionType;

        /**
         * @var string $HostName
         */
        public $HostName;

        /**
         * @var string $IPAddress
         */
        public $IPAddress;

        /**
         * @var IdNamePair $MediaPlugin
         */
        public $MediaPlugin;

        /**
         * @var string $Opened date-time formatted string
         */
        public $Opened;

        /**
         * @var string $PlaybackTicket
         */
        public $PlaybackTicket;

        /**
         * @var IdNamePair $PlayerEngine
         */
        public $PlayerEngine;

        /**
         * @var string $Referrer
         */
        public $Referrer;

        /**
         * @var IdNamePair $System
         */
        public $System;

        /**
         * @var string $UserId
         */
        public $UserId;

    }

    /**
     * Generated data proxy class for struct IdNamePair
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class IdNamePair
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Name
         */
        public $Name;

    }

    /**
     * Generated data proxy class for struct CreateAuthTicketResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class CreateAuthTicketResponse
    {

        /**
         * @var string $AuthTicketId
         */
        public $AuthTicketId;

    }

    /**
     * Generated data proxy class for struct CreateSubFolderResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class CreateSubFolderResponse
    {

        /**
         * @var string $Id
         */
        public $Id;

    }

    /**
     * Generated data proxy class for struct CreateIdentityTicketResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreateIdentityTicketResponse
    {

        /**
         * @var string $Ticket
         */
        public $Ticket;

    }

    /**
     * Generated data proxy class for struct CreatePresentationFromTemplateResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class CreatePresentationFromTemplateResponse
    {

        /**
         * @var PresentationDetails $Presentation
         */
        public $Presentation;

    }

    /**
     * Proxy class for struct PresentationDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class PresentationDetails
    {

        /**
         * @var string $AirDateTime date-time formatted string
         */
        public $AirDateTime;

        /**
         * @var string $AirDateTimeUtc date-time formatted string
         */
        public $AirDateTimeUtc;

        /**
         * @var EntityApprovalStateDetails $ApprovalState
         */
        public $ApprovalState;

        /**
         * @var EntityChangeTypesDetails $ChangeTypes
         */
        public $ChangeTypes;

        /**
         * @var int $ChapterPointCount
         */
        public $ChapterPointCount;

        /**
         * @var PresentationContentDetails[] $Content
         */
        public $Content;

        /**
         * @var int $ContentRevision
         */
        public $ContentRevision;

        /**
         * @var string $CopyrightNotice
         */
        public $CopyrightNotice;

        /**
         * @var string $CreationDate date-time formatted string
         */
        public $CreationDate;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var int $Duration
         */
        public $Duration;

        /**
         * @var string $FileServerUrl
         */
        public $FileServerUrl;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var boolean $IsLive
         */
        public $IsLive;

        /**
         * @var boolean $IsOnDemand
         */
        public $IsOnDemand;

        /**
         * @var boolean $IsReviewEditApproveEnabled
         */
        public $IsReviewEditApproveEnabled;

        /**
         * @var string $LastModified date-time formatted string
         */
        public $LastModified;

        /**
         * @var int $MediaLength
         */
        public $MediaLength;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var string $PlayerId
         */
        public $PlayerId;

        /**
         * @var string $PlayerUrl
         */
        public $PlayerUrl;

        /**
         * @var string $PresentationRootId
         */
        public $PresentationRootId;

        /**
         * @var PresenterName[] $Presenters
         */
        public $Presenters;

        /**
         * @var boolean $Recycled
         */
        public $Recycled;

        /**
         * @var int $SlideCount
         */
        public $SlideCount;

        /**
         * @var PresentationDataStatusDetails $Status
         */
        public $Status;

        /**
         * @var string[] $Tags
         */
        public $Tags;

        /**
         * @var string $TimeZoneAbbreviation
         */
        public $TimeZoneAbbreviation;

        /**
         * @var int $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var string $VideoUrl
         */
        public $VideoUrl;

    }

    /**
     * Proxy class for struct PresentationContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PresentationContentDetails
    {

        /**
         * @var string $ContentEncodingSettingsId
         */
        public $ContentEncodingSettingsId;

        /**
         * @var string $ContentMimeType
         */
        public $ContentMimeType;

        /**
         * @var string $ContentServerId
         */
        public $ContentServerId;

        /**
         * @var PresentationContentTypeDetails $ContentType
         */
        public $ContentType;

        /**
         * @var int $EncodingOrder
         */
        public $EncodingOrder;

        /**
         * @var string $FileNameWithExtension
         */
        public $FileNameWithExtension;

        /**
         * @var string $PresentationContentId
         */
        public $PresentationContentId;

        /**
         * @var ContentServerDetails $ServerDetails
         */
        public $ServerDetails;

        /**
         * @var PresentationContentStatusDetails $Status
         */
        public $Status;

    }

    /**
     * Proxy class for struct CreatePresentationPollResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreatePresentationPollResponse
    {

    }

    /**
     * Proxy class for struct ContentServerDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ContentServerDetails
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var ServerConnections $ServerConnections
         */
        public $ServerConnections;

        /**
         * @var ContentServerTypeDetails $ServerType
         */
        public $ServerType;

    }

    /**
     * Generated data proxy class for struct ServerConnections
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ServerConnections
    {

        /**
         * @var ContentServerDistributionEndpoint[]|ContentServerStorageEndpoint[] $ContentServerEndpoint
         */
        public $ContentServerEndpoint;
    }

    /**
     * Generated data proxy class for struct ContentServerEndpoint
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ContentServerEndpoint
    {

        /**
         * @var ContentServerEndpointType $EndpointType
         */
        public $EndpointType;

    }

    /**
     * Generated data proxy class for struct ContentServerDistributionEndpoint
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ContentServerDistributionEndpoint extends ContentServerEndpoint
    {

        /**
         * @var string $DistributionUrl
         */
        public $DistributionUrl;

    }

    /**
     * Generated data proxy class for struct ContentServerStorageEndpoint
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ContentServerStorageEndpoint extends ContentServerEndpoint
    {

        /**
         * @var boolean $EnableFileServerSecurity
         */
        public $EnableFileServerSecurity;

        /**
         * @var string $LocalUrl
         */
        public $LocalUrl;

        /**
         * @var string $Password
         */
        public $Password;

        /**
         * @var string $Url
         */
        public $Url;

        /**
         * @var boolean $UseMediasiteFileServer
         */
        public $UseMediasiteFileServer;

        /**
         * @var string $Username
         */
        public $Username;

    }

    /**
     * Generated data proxy class for struct ExternalLinkContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ExternalLinkContentDetails
    {

        /**
         * @var ExternalLinkDetails[] $ExternalLinks
         */
        public $ExternalLinks;

    }

    /**
     * Generated data proxy class for struct ExternalLinkDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ExternalLinkDetails
    {

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var int $Order
         */
        public $Order;

        /**
         * @var string $Url
         */
        public $Url;

    }

    /**
     * Generated data proxy class for struct SlideContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class SlideContentDetails extends PresentationContentDetails
    {

        /**
         * @var boolean $AllowOcr
         */
        public $AllowOcr;

        /**
         * @var boolean $IsGeneratedFromVideoStream
         */
        public $IsGeneratedFromVideoStream;

        /**
         * @var string $LastOcrDate date-time formatted string
         */
        public $LastOcrDate;

        /**
         * @var PresentationContentStatusDetails $OcrStatus
         */
        public $OcrStatus;

        /**
         * @var string $OcrStatusText
         */
        public $OcrStatusText;

    }

    /**
     * Generated data proxy class for struct ChapterContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ChapterContentDetails extends PresentationContentDetails
    {

    }

    /**
     * Generated data proxy class for struct CaptionContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CaptionContentDetails
    {

        /**
         * @var boolean $IsRushJob
         */
        public $IsRushJob;

        /**
         * @var string $ProviderSubmissionDate date-time formatted string
         */
        public $ProviderSubmissionDate;

        /**
         * @var string $SecurityToken
         */
        public $SecurityToken;

    }

    /**
     * Generated data proxy class for struct PresenterName
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PresenterName
    {

        /**
         * @var string $DisplayName
         */
        public $DisplayName;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $ImageUrl
         */
        public $ImageUrl;

    }

    /**
     * Generated data proxy class for struct CreatePresentationFromScheduleResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreatePresentationFromScheduleResponse
    {

        /**
         * @var int $Duration
         */
        public $Duration;

        /**
         * @var string $PlayerUrl
         */
        public $PlayerUrl;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var string $PrimaryPresenterEmailId
         */
        public $PrimaryPresenterEmailId;

        /**
         * @var string $PrimaryPresenterName
         */
        public $PrimaryPresenterName;

        /**
         * @var ScheduledPresentationAssociation $ScheduledPresentationAssociation
         */
        public $ScheduledPresentationAssociation;

        /**
         * @var string $SendEmailInvitationError
         */
        public $SendEmailInvitationError;

        /**
         * @var string $StartDateTime date-time formatted string
         */
        public $StartDateTime;

        /**
         * @var string $Title
         */
        public $Title;

    }

    /**
     * Generated data proxy class for struct ScheduledPresentationAssociation
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ScheduledPresentationAssociation
    {

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var int $RecurrenceId
         */
        public $RecurrenceId;

        /**
         * @var string $ScheduleId
         */
        public $ScheduleId;

        /**
         * @var string $Status
         */
        public $Status;

    }

    /**
     * Generated data proxy class for struct CreatePresentationLikeResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreatePresentationLikeResponse
    {

        /**
         * @var PresentationDetails $Presentation
         */
        public $Presentation;

    }

    /**
     * Generated data proxy class for struct CreateScheduleFromTemplateResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreateScheduleFromTemplateResponse
    {

        /**
         * @var string $ScheduleId
         */
        public $ScheduleId;

    }

    /**
     * Generated data proxy class for struct LoginResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     */
    class LoginResponse
    {

        /**
         * @var string $UserTicket
         */
        public $UserTicket;

    }

    /**
     * Generated data proxy class for struct LogoutResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class LogoutResponse
    {

    }

    /**
     * Generated data proxy class for struct QueryAuthTicketPropertiesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryAuthTicketPropertiesResponse
    {

        /**
         * @var AuthTicketProperties $Properties
         */
        public $Properties;

    }

    /**
     * Generated data proxy class for struct AuthTicketProperties
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class AuthTicketProperties
    {

        /**
         * @var string $ClientIpAddress
         */
        public $ClientIpAddress;

        /**
         * @var string $CreationTime date-time formatted string
         */
        public $CreationTime;

        /**
         * @var string $ExpirationTime date-time formatted string
         */
        public $ExpirationTime;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @var string $TicketId
         */
        public $TicketId;

        /**
         * @var string $Username
         */
        public $Username;

    }

    /**
     * Generated data proxy class for struct QueryCatalogSharesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryCatalogSharesResponse
    {

        /**
         * @var CatalogShare[] $Shares
         */
        public $Shares;

    }

    /**
     * Generated data proxy class for struct CatalogShare
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CatalogShare
    {

        /**
         * @var string $CatalogUrl
         */
        public $CatalogUrl;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var boolean $Recycled
         */
        public $Recycled;

    }

    /**
     * Generated data proxy class for struct QueryChapterPointsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryChapterPointsResponse
    {

        /**
         * @var ChapterDetails[] $ChapterPoints
         */
        public $ChapterPoints;

    }

    /**
     * Generated data proxy class for struct ChapterDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ChapterDetails
    {

        /**
         * @var string $ImageFileName
         */
        public $ImageFileName;

        /**
         * @var int $Number
         */
        public $Number;

        /**
         * @var int $Time
         */
        public $Time;

        /**
         * @var string $Title
         */
        public $Title;

    }

    /**
     * Generated data proxy class for struct QueryClientIpAddressResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryClientIpAddressResponse
    {

        /**
         * @var string $DnsName
         */
        public $DnsName;

        /**
         * @var string $IpAddress
         */
        public $IpAddress;

    }

    /**
     * Generated data proxy class for struct QueryContentServersByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryContentServersByCriteriaResponse
    {

        /**
         * @var ContentServerDetails[] $ContentServers
         */
        public $ContentServers;

    }

    /**
     * Generated data proxy class for struct QueryFoldersByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryFoldersByIdResponse
    {

        /**
         * @var FolderDetails[] $FolderDetails
         */
        public $FolderDetails;

    }

    /**
     * Generated data proxy class for struct FolderDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class FolderDetails
    {

        /**
         * @var string $CreationDate date-time formatted string
         */
        public $CreationDate;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $FolderPath
         */
        public $FolderPath;

        /**
         * @var boolean $HasChildFolders
         */
        public $HasChildFolders;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $LastModified date-time formatted string
         */
        public $LastModified;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ParentId
         */
        public $ParentId;

        /**
         * @var FolderTypeDetails $Type
         */
        public $Type;

    }

    /**
     * Generated data proxy class for list FolderTypeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class FolderTypeDetails
    {

    }

    /**
     * Generated data proxy class for struct QueryFoldersWithPresentationsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryFoldersWithPresentationsResponse
    {

        /**
         * @var FolderDetails[] $Folders
         */
        public $Folders;

    }

    /**
     * Generated data proxy class for struct QueryIdentityTicketPropertiesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryIdentityTicketPropertiesResponse
    {

        /**
         * @var IdentityTicketProperties $Properties
         */
        public $Properties;

    }

    /**
     * Generated data proxy class for struct IdentityTicketProperties
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class IdentityTicketProperties
    {

        /**
         * @var string $Application
         */
        public $Application;

        /**
         * @var string $ClientIpAddress
         */
        public $ClientIpAddress;

        /**
         * @var string $CreationTime date-time formatted string
         */
        public $CreationTime;

        /**
         * @var string $ExpirationTime date-time formatted string
         */
        public $ExpirationTime;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $Username
         */
        public $Username;

    }

    /**
     * Generated data proxy class for struct QueryContentEncodingSettingsByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryContentEncodingSettingsByIdResponse
    {

        /**
         * @var ContentEncodingSettingDetails[] $ContentEncodingSettings
         */
        public $ContentEncodingSettings;

    }

    /**
     * Generated data proxy class for struct ContentEncodingSettingDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ContentEncodingSettingDetails
    {

        /**
         * @var string $CreationDate date-time formatted string
         */
        public $CreationDate;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var EncodingStreamDescription[] $H264StreamDescriptions
         */
        public $H264StreamDescriptions;

        /**
         * @var EncodingSettingsFilter[] $H264StreamFilters
         */
        public $H264StreamFilters;

        /**
         * @var int $H264UserMaximumDeviceClass
         */
        public $H264UserMaximumDeviceClass;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $LastModified date-time formatted string
         */
        public $LastModified;

        /**
         * @var string $MimeType
         */
        public $MimeType;

        /**
         * @var int $MinimumDeviceClass
         */
        public $MinimumDeviceClass;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var boolean $Recycled
         */
        public $Recycled;

        /**
         * @var string $SerializedSettings
         */
        public $SerializedSettings;

    }

    /**
     * Generated data proxy class for struct QueryContentEncodingSettingsByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryContentEncodingSettingsByCriteriaResponse
    {

        /**
         * @var ContentEncodingSettingDetails[] $ContentEncodingSettings
         */
        public $ContentEncodingSettings;

    }

    /**
     * Generated data proxy class for struct QueryPlayersResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPlayersResponse
    {

        /**
         * @var PlayerDetails[] $Players
         */
        public $Players;

    }

    /**
     * Generated data proxy class for struct PlayerDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided as a reference to server return data types only, client applications should never need to instantiate this class
     */
    class PlayerDetails
    {

        /**
         * @var string $CreationDate date-time formatted string
         */
        public $CreationDate;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $LastModified date-time formatted string
         */
        public $LastModified;

        /**
         * @var string $LayoutId
         */
        public $LayoutId;

        /**
         * @var string $LayoutOptions
         */
        public $LayoutOptions;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var string $PlayerOptionsFolderUrl
         */
        public $PlayerOptionsFolderUrl;

        /**
         * @var string $PlayerUrl
         */
        public $PlayerUrl;

        /**
         * @var boolean $Recycled
         */
        public $Recycled;

    }

    /**
     * Generated data proxy class for struct QueryPresentationsByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class QueryPresentationsByIdResponse
    {

        /**
         * @var PresentationDetails|PresentationDetails[] $Presentations of {@link PresentationDetails}
         */
        public $Presentations;

    }

    /**
     * Generated data proxy class for struct QueryPresentationsByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPresentationsByCriteriaResponse
    {

        /**
         * @var PresentationDetails[] $Presentations
         */
        public $Presentations;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct QueryPresentationTemplatesByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPresentationTemplatesByCriteriaResponse
    {

        /**
         * @var PresentationTemplateDetails[] $PresentationTemplates
         */
        public $PresentationTemplates;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct PresentationTemplateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PresentationTemplateDetails
    {

        /**
         * @var PresentationTemplateContentDetails[] $ContentDetails
         */
        public $ContentDetails;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var boolean $IsForumsEnabled
         */
        public $IsForumsEnabled;

        /**
         * @var boolean $IsLive
         */
        public $IsLive;

        /**
         * @var boolean $IsOnDemand
         */
        public $IsOnDemand;

        /**
         * @var boolean $IsPollsEnabled
         */
        public $IsPollsEnabled;

        /**
         * @var boolean $IsUploadAutomatic
         */
        public $IsUploadAutomatic;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var string $PlayerId
         */
        public $PlayerId;

        /**
         * @var PresenterName[] $Presenters
         */
        public $Presenters;

        /**
         * @var int $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var string $TimeZoneRegistryKey
         */
        public $TimeZoneRegistryKey;

    }

    /**
     * Generated data proxy class for struct PresentationTemplateContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PresentationTemplateContentDetails
    {

        /**
         * @var string $ContentEncodingSettingsId
         */
        public $ContentEncodingSettingsId;

        /**
         * @var string $ContentServerId
         */
        public $ContentServerId;

        /**
         * @var PresentationContentTypeDetails $ContentType
         */
        public $ContentType;

        /**
         * @var int $EncodingOrder
         */
        public $EncodingOrder;

        /**
         * @var string $MimeType
         */
        public $MimeType;

    }

    /**
     * Generated data proxy class for struct QueryPresentersByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPresentersByCriteriaResponse
    {

        /**
         * @var PresenterDetails[] $Presenters
         */
        public $Presenters;

    }

    /**
     * Generated data proxy class for struct PresenterDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class PresenterDetails
    {

        /**
         * @var string $AdditionalInfo
         */
        public $AdditionalInfo;

        /**
         * @var string $BioUrl
         */
        public $BioUrl;

        /**
         * @var string $Email
         */
        public $Email;

        /**
         * @var string $FirstName
         */
        public $FirstName;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $ImageName
         */
        public $ImageName;

        /**
         * @var string $ImageUrl
         */
        public $ImageUrl;

        /**
         * @var string $LastName
         */
        public $LastName;

        /**
         * @var string $MiddleName
         */
        public $MiddleName;

        /**
         * @var string $Prefix
         */
        public $Prefix;

        /**
         * @var string $Suffix
         */
        public $Suffix;

    }

    /**
     * Generated data proxy class for struct QueryPresentersByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryPresentersByIdResponse
    {

        /**
         * @var PresenterDetails[] $PresenterDetails
         */
        public $PresenterDetails;

    }

    /**
     * Generated data proxy class for struct QueryResourcePermissionListResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryResourcePermissionListResponse
    {

        /**
         * @var ResourcePermissionDetails $ResourcePermission
         */
        public $ResourcePermission;

    }

    /**
     * Generated data proxy class for struct ResourcePermissionDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ResourcePermissionDetails
    {

        /**
         * @var ResourcePermissionEntry[] $PermissionList
         */
        public $PermissionList;

        /**
         * @var ResourceIdentifier $Resource
         */
        public $Resource;

    }

    /**
     * Generated data proxy class for struct QueryResourcePermissionsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryResourcePermissionsResponse
    {

        /**
         * @var ResourcePermissions[] $ResourceList
         */
        public $ResourceList;

    }

    /**
     * Generated data proxy class for struct ResourcePermissions
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ResourcePermissions
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var ResourcePermissionMask $PermissionMask
         */
        public $PermissionMask;

    }

    /**
     * Generated data proxy class for struct QuerySchedulesByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QuerySchedulesByCriteriaResponse
    {

        /**
         * @var QueryResults $Results
         */
        public $Results;

        /**
         * @var ScheduleDetails[] $ScheduleList
         */
        public $ScheduleList;

    }

    /**
     * Generated data proxy class for struct ScheduleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ScheduleDetails
    {

        /**
         * @var int $AdvanceCreationTime
         */
        public $AdvanceCreationTime;

        /**
         * @var int $AdvanceLoadTimeInSeconds
         */
        public $AdvanceLoadTimeInSeconds;

        /**
         * @var boolean $AutoStart
         */
        public $AutoStart;

        /**
         * @var boolean $AutoStop
         */
        public $AutoStop;

        /**
         * @var string $CDNPublishingPoint
         */
        public $CDNPublishingPoint;

        /**
         * @var ScheduleContentDetails[] $ContentDetails
         */
        public $ContentDetails;

        /**
         * @var boolean $CreatePresentation
         */
        public $CreatePresentation;

        /**
         * @var boolean $DeleteInactive
         */
        public $DeleteInactive;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $FolderId
         */
        public $FolderId;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var boolean $IsForumEnabled
         */
        public $IsForumEnabled;

        /**
         * @var boolean $IsLive
         */
        public $IsLive;

        /**
         * @var boolean $IsUploadAutomatic
         */
        public $IsOnDemand;

        /**
         * @var boolean $IsUploadAutomatic
         */
        public $IsPollsEnabled;

        /**
         * @var boolean $IsUploadAutomatic
         */
        public $IsUploadAutomatic;

        /**
         * @var string $LastModified date-time formatted string
         */
        public $LastModified;

        /**
         * @var boolean $LoadPresentation
         */
        public $LoadPresentation;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var int $NextNumberInSchedule
         */
        public $NextNumberInSchedule;

        /**
         * @var boolean $NotifyPresenter
         */
        public $NotifyPresenter;

        /**
         * @var string $PlayerId
         */
        public $PlayerId;

        /**
         * @var string $RecipientsEmailAddresses
         */
        public $RecipientsEmailAddresses;

        /**
         * @var string $RecorderEncryptionKey
         */
        public $RecorderEncryptionKey;

        /**
         * @var string $RecorderId
         */
        public $RecorderId;

        /**
         * @var string $RecorderName
         */
        public $RecorderName;

        /**
         * @var string $RecorderPassword
         */
        public $RecorderPassword;

        /**
         * @var string $RecorderUsername
         */
        public $RecorderUsername;

        /**
         * @var string $RecorderWebServiceUrl
         */
        public $RecorderWebServiceUrl;

        /**
         * @var RecurrenceList $RecurrenceList
         */
        public $RecurrenceList;

        /**
         * @var boolean $ReplaceAclWithPolicy
         */
        public $ReplaceAclWithPolicy;

        /**
         * @var boolean $ReviewEditApproveEnabled
         */
        public $ReviewEditApproveEnabled;

        /**
         * @var string $ScheduleTemplateId
         */
        public $ScheduleTemplateId;

        /**
         * @var string $SendersEmail
         */
        public $SendersEmail;

        /**
         * @var string $TimeZoneRegistryKey
         */
        public $TimeZoneRegistryKey;

        /**
         * @var ScheduleTitleType $TitleType
         */
        public $TitleType;

    }

    /**
     * Generated data proxy class for struct ScheduleContentDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ScheduleContentDetails
    {

        /**
         * @var string $ContentEncodingSettingsId
         */
        public $ContentEncodingSettingsId;

        /**
         * @var string $ContentServerId
         */
        public $ContentServerId;

        /**
         * @var PresentationContentTypeDetails $ContentType
         */
        public $ContentType;

        /**
         * @var int $EncodingOrder
         */
        public $EncodingOrder;

        /**
         * @var string $MimeType
         */
        public $MimeType;

        /**
         * @var ContentServerTypeDetails $ServerType
         */
        public $ServerType;

    }

    /**
     * Data proxy class for struct RecurrenceList
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class RecurrenceList
    {

        /**
         * @var ScheduleRecurrenceDetails|ScheduleRecurrenceDetails[] $ScheduleRecurrenceDetails
         */
        public $ScheduleRecurrenceDetails;
    }

    /**
     * Generated data proxy class for struct QuerySitePropertiesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QuerySitePropertiesResponse
    {

        /**
         * @var SiteProperties $Properties
         */
        public $Properties;

    }

    /**
     * Generated data proxy class for struct EDASSiteProperties
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class SiteProperties
    {

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $Edition
         */
        public $Edition;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var string $OwnerContact
         */
        public $OwnerContact;

        /**
         * @var string $OwnerEmail
         */
        public $OwnerEmail;

        /**
         * @var string $RecycleBinFolderId
         */
        public $RecycleBinFolderId;

        /**
         * @var string $RootFolderId
         */
        public $RootFolderId;

        /**
         * @var string $SiteId
         */
        public $SiteId;

        /**
         * @var string $SiteRootUrl
         */
        public $SiteRootUrl;

        /**
         * @var string $Version
         */
        public $Version;

    }

    /**
     * Generated data proxy class for struct QuerySlidesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QuerySlidesResponse
    {

        /**
         * @var SlideDetails[] $Slides
         */
        public $Slides;

    }

    /**
     * Generated data proxy class for struct SlideDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class SlideDetails
    {

        /**
         * @var string $Content
         */
        public $Content;

        /**
         * @var int $Number
         */
        public $Number;

        /**
         * @var int $Time
         */
        public $Time;

        /**
         * @var string $Title
         */
        public $Title;

    }

    /**
     * Generated data proxy class for struct QuerySubFolderDetailsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QuerySubFolderDetailsResponse
    {

        /**
         * @var FolderDetails[] $Folders
         */
        public $Folders;

    }

    /**
     * Generated data proxy class for struct QueryTimeZonesByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryTimeZonesByCriteriaResponse
    {

        /**
         * @var MediasiteTimeZone[] $TimeZones
         */
        public $TimeZones;

    }

    /**
     * Generated data proxy class for struct MediasiteTimeZone
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class MediasiteTimeZone
    {

        /**
         * @var string $DaylightAbbreviation
         */
        public $DaylightAbbreviation;

        /**
         * @var string $DisplayName
         */
        public $DisplayName;

        /**
         * @var int $Id
         */
        public $Id;

        /**
         * @var boolean $IsDisplayed
         */
        public $IsDisplayed;

        /**
         * @var string $RegistryKey
         */
        public $RegistryKey;

        /**
         * @var string $StandardAbbreviation
         */
        public $StandardAbbreviation;

    }

    /**
     * Generated data proxy class for struct RemoveAuthTicketResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class RemoveAuthTicketResponse
    {

    }

    /**
     * Generated data proxy class for struct RemoveIdentityTicketResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class RemoveIdentityTicketResponse
    {

    }

    /**
     * Generated data proxy class for struct TestResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class TestResponse
    {

        /**
         * @var boolean $Value
         */
        public $Value;

    }

    /**
     * Generated data proxy class for struct SearchResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class SearchResponse
    {

        /**
         * @var SearchResponseDetails[] $DetailList
         */
        public $DetailList;

        /**
         * @var QueryResults $Results
         */
        public $Results;

    }

    /**
     * Generated data proxy class for struct SearchResponseDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class SearchResponseDetails
    {

        /**
         * @var string $MediasiteId
         */
        public $MediasiteId;

        /**
         * @var string $TypeName
         */
        public $TypeName;

    }

    /**
     * Generated data proxy class for struct UpdateScheduleResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class UpdateScheduleResponse
    {

        /**
         * @var string $ScheduleId
         */
        public $ScheduleId;

    }

    /**
     * Generated data proxy class for struct UpdatePresentationDetailsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class UpdatePresentationDetailsResponse
    {

    }

    /**
     * Generated data proxy class for struct QueryRolesByIdResponse
     *
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since      6.0
     * @deprecated Deprecated in v6.1.1; QueryRoleById now returns MediasiteRoleDetails directly
     */
    class QueryRolesByIdResponse
    {

        /**
         * @var MediasiteRoleDetails[] $RoleDetails
         */
        public $RoleDetails;

    }

    /**
     * Generated data proxy class for struct MediasiteRoleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class MediasiteRoleDetails
    {

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $DirectoryEntry
         */
        public $DirectoryEntry;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var boolean $IsBuiltInRole
         */
        public $IsBuiltInRole;

        /**
         * @var string $Name
         */
        public $Name;

    }

    /**
     * Generated data proxy class for struct QueryRolesByCriteriaResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryRolesByCriteriaResponse
    {

        /**
         * @var MediasiteRoleDetails[] $RoleDetails
         */
        public $RoleDetails;

    }

    /**
     * Generated data proxy class for struct GetVersionResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class GetVersionResponse
    {

        /**
         * @var string $Version
         */
        public $Version;

    }

    /**
     * Generated data proxy class for struct ArrayofActiveConnection
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class ArrayofActiveConnection
    {

        /**
         * @var ActiveConnection $ActiveConnection
         */
        public $ActiveConnection;

    }

    /**
     * Generated data proxy class for struct DeleteResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class DeleteResponse
    {

        /**
         * @var string $Message For some calls this contains informative information on a successful delete
         */
        public $Message;

        /**
         * @var string $JobId
         */
        public $JobId;

    }

    /**
     * Generated data proxy class for struct QueryCatalogsByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class QueryCatalogsByIdResponse
    {

        /**
         * @var CatalogShare[] $Shares
         */
        public $Shares;

    }

    /**
     * Generated data proxy class for struct CreateCatalogFromFolderResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreateCatalogFromFolderResponse
    {

        /**
         * @var string $CatalogId
         */
        public $CatalogId;

    }

    /**
     * Generated data proxy class for struct CreatePlayerLikeResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreatePlayerLikeResponse
    {

        /**
         * @var string $Id
         */
        public $Id;

    }

    /**
     * Generated data proxy class for struct UpdateResourcePermissionsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class UpdateResourcePermissionsResponse
    {

    }

    /*  new for 6.1.1   */
    /**
     * Generated data proxy class for struct CreateUserProfilesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     */
    class CreateUserProfilesResponse
    {

        /**
         * @var UserProfileMapping|UserProfileMapping[] $ProfileMappings
         */
        public $ProfileMappings;

    }

    /**
     * Generated data proxy class for struct UserProfileMapping
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.0
     */
    class UserProfileMapping
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Value
         */
        public $Value;

    }

    /**
     * Generated data proxy class for struct QueryUserProfilesByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryUserProfilesByIdResponse
    {

        /**
         * @var UserProfileMapping|UserProfileMapping[] $UserProfiles
         */
        public $UserProfiles;

    }

    /**
     * Generated data proxy class for struct CreateUserProfilesFromEmailsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class CreateUserProfilesFromEmailsResponse
    {

        /**
         * @var UserProfileMapping|UserProfileMapping[] $UserProfiles
         */
        public $ProfileMappings;

    }

    /**
     * Generated data proxy class for struct CreateUserProfilesFromEmailsResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryUserProfilesByCriteriaResponse
    {

        /**
         * @var UserProfileMapping|UserProfileMapping[] $UserProfiles
         */
        public $UserProfiles;
    }

    /**
     * Generated data proxy class for struct UpdateUserProfilesResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class UpdateUserProfilesResponse
    {

    }

    /**
     * Generated data proxy class for struct CheckJobStatusResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class CheckJobStatusResponse
    {

        /**
         * @var JobStatus $Status
         */
        public $Status;

        /**
         * @var string $StatusMessage
         */
        public $StatusMessage;

    }

    /**
     * Generated data proxy class for struct CheckJobStatusResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class AddTagToMediasiteObjectResponse
    {

    }

    /**
     * Generated data proxy class for struct CheckJobStatusResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryTagsByMediasiteIdResponse
    {
        /**
         * @var string[] $Tags
         */
        public $Tags;
    }

    /**
     * Generated data proxy class for struct RemoveTagFromMediasiteObjectResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class RemoveTagFromMediasiteObjectResponse
    {

    }

    /**
     * Generated data proxy class for struct CreateTemplateLikeResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class CreateTemplateLikeResponse
    {

        /**
         * @var string id of the created template
         */
        public $TemplateId;

    }

    /**
     * Generated data proxy class for struct CreateMediasiteKeyValueResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class CreateMediasiteKeyValueResponse
    {

        /**
         * @var string $Id
         */
        public $Id;

    }

    /**
     * Generated data proxy class for struct QueryMediasiteKeyValueByIdResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByIdResponse
    {
        /**
         * @var MediasiteKeyValue[]
         */
        public $KeyValues;

//        public $QueryMediasiteKeyValueByIdResult;

    }

    /**
     * Generated data proxy class for struct QueryMediasiteKeyValueByIdAndKeyResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByIdAndKeyResponse
    {
        /**
         * @var MediasiteKeyValue[]
         */
        public $KeyValues;

    }

    /**
     * Generated data proxy class for struct QueryMediasiteKeyValueByKeyValueResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByKeyValueResponse
    {
        /**
         * @var MediasiteKeyValue[]
         */
        public $KeyValues;

    }

    /**
     * Generated data proxy class for struct UpdatePlayerResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.1
     */
    class UpdatePlayerResponse
    {
    }

    /**
     * Data proxy class for struct RefreshReportDataResponse
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.7
     */
    class RefreshReportDataResponse
    {
        /**
         * @var
         */
        public $RefreshReportDataResult;
    }

    /**
     * Data proxy class for struct  RefreshReportDataResult
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @referenceonly This class provided for reference only, client applications should never need to instantiate this class
     * @since   6.1.7
     */
    class RefreshReportDataResult
    {
        /**
         * @var string $JobId
         */
        public $JobId;

    }
/**
 * Proxy class for struct CreateRegistrationResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateRegistrationResponse
{

}
/**
 * Proxy class for struct DisableRegistrationResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class DisableRegistrationResponse
{

}
/**
 * Proxy class for struct AddRegistrantsToResourceResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class AddRegistrantsToResourceResponse
{

}
/**
 * Proxy class for struct RemoveRegistrantsFromResourceResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class RemoveRegistrantsFromResourceResponse
{

}
/**
 * Proxy class for struct QueryResourceRegistrantsResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryResourceRegistrantsResponse
{
        /**
         * @var ResourceRegistrationDetail[] $RegistrationDetails
         */
        public $RegistrationDetails;

}
/**
 * Proxy class for struct CreateMp3ContentResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateMp3ContentResponse
{

}
/**
 * Proxy class for struct CreateMediaImportProjectResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateMediaImportProjectResponse
{
        /**
         * @var string $MediaImportProjectId
         */
        public $MediaImportProjectId;

}
/**
 * Proxy class for struct QueryContentImportProjectProgressResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryContentImportProjectProgressResponse
{
        /**
         * @var ImportProjectItemProgress[] $ProgressList
         */
        public $ProgressList;

}
/**
 * Proxy class for struct QueryViewingTrendsResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryViewingTrendsResponse
{
    /**
     * @var int $Duration
     */
    public $Duration;

    /**
     * @var int $MinViewLength
     */
    public $MinViewLength;

    /**
     * @var QueryResults $Results
     */
    public $Results;

    /**
     * @var SegmentViews[] $SegmentViewsList
     */
    public $SegmentViewsList;
    /**
     *      * @param int $Duration
     *      * @param int $MinViewLength
     *      * @param QueryResults $Results
     *      * @param SegmentViews[] $SegmentViewsList
     *      */
     function __construct( $Duration, $MinViewLength, $Results, $SegmentViewsList ) {
                 $this->Duration = $Duration;
                 $this->MinViewLength = $MinViewLength;
                 $this->Results = $Results;
                 $this->SegmentViewsList = $SegmentViewsList;
     }
}

/**
 * Proxy class for struct QueryViewingSessionsResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.13
 */
class QueryPresentationViewingSessionsResponse
{
    /**
     *      * @var QueryResults $Results
     *      */
        public $Results;

        /**
         *      * @var ViewingSession[] $ViewingSessionList
         *      */
        public $ViewingSessionList;

        /**
         *      * @param QueryResults $Results
         *      * @param ViewingSession[] $ViewingSessionList
         *      */
        function __construct( $Results, $ViewingSessionList ) {
                    $this->Results = $Results;
                    $this->ViewingSessionList = $ViewingSessionList;
        }
}

/**
 * Proxy class for struct CreatePublishToGoContentResponse
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since 6.1.13
 */
class CreatePublishToGoContentResponse
{
        /**
         *      * @var string $DownloadUrl
         *      */
        public $DownloadUrl;

        /**
         *      * @var string $JobId
         *      */
        public $JobId;

        /**
         *      * @param string $DownloadUrl
         *      * @param string $JobId
         *      */
        function __construct( $DownloadUrl, $JobId ) {
                    $this->DownloadUrl = $DownloadUrl;
                    $this->JobId = $JobId;
        }

}
