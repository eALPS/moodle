<?php

    namespace Sonicfoundry\EDAS;

    /**
     * Proxy classes for Mediasite External Data Access Service (Edas)
     * These proxy classes were generated based on the Mediasite 6.0 EDAS WSDL definition.
     * PHP Version 5.3
     *
     * @copyright  Copyright (c) 2013, Sonic Foundry
     * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
     * @version    6.1.7
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @subpackage Requests
     * @author     Cori Schlegel <coris@sonicfoundry.com>
     *             This software is provided "AS IS" without a warranty of any kind.

     */
    /**
     * Require the other files that contain requisite class definitions
     */
    require_once __DIR__ . '/edasproxy_containers.php';
    require_once __DIR__ . '/edasproxy_enumerations.php';
    require_once __DIR__ . '/edasproxy_containers.php';
    require_once __DIR__ . '/edasproxy_responses.php';
    require_once __DIR__ . '/edasproxy_functions.php';

    /**
     * @internal
     *
     * Base class for requests
     *
     * @package    SonicFoundry.Mediasite.Edas.PHPProxy
     * @subpackage Requests
     * @since      6.0
     */
    abstract class RequestMessage
    {

        /**
         * @var string $Ticket
         */
        public $Ticket;

        /**
         * @var string $ImpersonationUsername
         */
        public $ImpersonationUsername;

        /**
         * @param string $Ticket
         * @param string $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {

            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct EncodingStreamDescription
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class EncodingStreamDescription
    {

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var int $DeviceClass
         */
        public $DeviceClass;

        /**
         * @var int $Number
         */
        public $Number;

        /**
         * @var EncodingStreamType $StreamType
         */
        public $StreamType;

        /**
         * @param string $Description
         * @param string $DeviceClass
         * @param string $Number
         * @param string $StreamType
         */
        function __construct( $Description, $DeviceClass, $Number, $StreamType ) {
            $this->Description = $Description;
            $this->DeviceClass = $DeviceClass;
            $this->Number      = $Number;
            $this->StreamType  = $StreamType;
        }

    }

    /**
     * Proxy class for struct EncodingSettingsFilter
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class EncodingSettingsFilter
    {

        /**
         * @var FilterType $FilterType
         */
        public $FilterType;

        /**
         * @var string $FilterValue
         */
        public $FilterValue;

        /**
         * @param FilterType $FilterType
         * @param string     $FilterValue
         */
        function __construct( $FilterType, $FilterValue ) {
            $this->FilterType  = $FilterType;
            $this->FilterValue = $FilterValue;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateRoleRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateRoleRequest extends RequestMessage
    {

        /**
         * @var CreateRoleDetails $RoleDetails
         */
        public $RoleDetails;

        /**
         * @param string            $Ticket
         * @param CreateRoleDetails $RoleDetails
         * @param null              $ImpersonationUsername
         */
        function __construct( $Ticket, $RoleDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->RoleDetails           = $RoleDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreateRoleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateRoleDetails
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
         * @var string $Name
         */
        public $Name;

        /**
         * @param string $DirectoryEntry
         * @param string $Name
         * @param string $Description
         */
        function __construct( $DirectoryEntry, $Name, $Description = null ) {
            $this->Description    = $Description;
            $this->DirectoryEntry = $DirectoryEntry;
            $this->Name           = $Name;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct UpdateRoleRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateRoleRequest extends RequestMessage
    {

        /**
         * @var UpdateRoleDetails $RoleDetails
         */
        public $RoleDetails;

        /**
         * @param string            $Ticket
         * @param UpdateRoleDetails $RoleDetails
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $RoleDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->RoleDetails           = $RoleDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct UpdateRoleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateRoleDetails
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var boolean $DescriptionIsSet
         */
        public $DescriptionIsSet;

        /**
         * @var string $DirectoryEntry
         */
        public $DirectoryEntry;

        /**
         * @var boolean $DirectoryEntryIsSet
         */
        public $DirectoryEntryIsSet;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var boolean $NameIsSet
         */
        public $NameIsSet;

        /**
         * Build details for a role update
         *
         * @param string $Id                  required to look up the role to update
         * @param string $Description
         * @param bool   $DescriptionIsSet    if set to false or not set, $Description will be ignored
         * @param string $DirectoryEntry
         * @param bool   $DirectoryEntryIsSet if set to false or not set, $DirectoryEntry will be ignored
         * @param string $Name
         * @param bool   $NameIsSet           if set to false or not set, $Name will be ignored
         *
         * @since 6.0
         */
        function __construct( $Id, $Description = null, $DescriptionIsSet = false, $DirectoryEntry = null,
                              $DirectoryEntryIsSet = false, $Name = null, $NameIsSet = false ) {
            $this->Id                  = $Id;
            $this->Description         = $Description;
            $this->DescriptionIsSet    = $DescriptionIsSet;
            $this->DirectoryEntry      = $DirectoryEntry;
            $this->DirectoryEntryIsSet = $DirectoryEntryIsSet;
            $this->Name                = $Name;
            $this->NameIsSet           = $NameIsSet;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryTotalViewsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryTotalViewsRequest extends RequestMessage
    {

        /**
         * @var string[] $IdList
         */
        public $IdList;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var AnalyticsRequestType $RequestType
         */
        public $RequestType;

        /**
         * @param string                  $Ticket
         * @param string[]                $IdList
         * @param AnalyticsRequestType    $RequestType
         * @param QueryOptions            $Options
         * @param string                  $ImpersonationUsername
         */
        function __construct( $Ticket, $IdList, $RequestType, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->IdList                = $IdList;
            $this->RequestType           = $RequestType;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct QueryOptions
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryOptions
    {

        /**
         * @var int $BatchSize
         */
        public $BatchSize;

        /**
         * @var string $QueryId
         */
        public $QueryId;

        /**
         * @var int $StartIndex
         */
        public $StartIndex;

        /**
         * @param int    $BatchSize
         * @param string $QueryId
         * @param int    $StartIndex
         */
        function __construct( $BatchSize, $QueryId, $StartIndex ) {

            $this->BatchSize  = $BatchSize;
            $this->QueryId    = $QueryId;
            $this->StartIndex = $StartIndex;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryAnalyticsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryAnalyticsByIdRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var AnalyticsRequestType $RequestType
         */
        public $RequestType;

        /**
         * @param string               $Ticket
         * @param string               $Id
         * @param AnalyticsRequestType $RequestType
         * @param QueryOptions         $Options
         * @param string               $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $RequestType, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->RequestType           = $RequestType;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryTotalViewsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryTotalViewsByIdRequest extends QueryAnalyticsByIdRequest
    {

        /**
         * @var AnalyticsRequestType $ChildType
         */
        public $ChildType;

        /**
         * @param string                           $Ticket
         * @param string                           $Id
         * @param AnalyticsRequestType             $RequestType
         * @param AnalyticsRequestType             $ChildType
         * @param QueryOptions                     $Options     ,
         * @param string                           $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $RequestType, $ChildType, QueryOptions $Options = null, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->RequestType           = $RequestType;
            $this->ChildType             = $ChildType;
            $this->Id                    = $Id;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentationUsageRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentationUsageRequest extends RequestMessage
    {

        /**
         * @var string[] $ClientIdList
         */
        public $ClientIdList;

        /**
         * @var AnalyticsRequestType $ClientType
         */
        public $ClientType;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @param string                  $Ticket
         * @param string[]                $ClientIdList array of ids
         * @param AnalyticsRequestType    $ClientType
         * @param string                  $PresentationId
         * @param QueryOptions            $Options
         * @param null                    $ImpersonationUsername
         */
        function __construct( $Ticket, $ClientIdList, $ClientType, $PresentationId, $Options = null,
                              $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ClientIdList          = $ClientIdList;
            $this->ClientType            = $ClientType;
            $this->Options               = $Options;
            $this->PresentationId        = $PresentationId;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryServerUsageRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryServerUsageRequest extends RequestMessage
    {

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryActiveConnectionsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryActiveConnectionsRequest extends RequestMessage
    {

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryActivePresentationsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryActivePresentationsRequest extends RequestMessage
    {

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var string[] $PresentationIdList
         */
        public $PresentationIdList;

        /**
         * @param string          $Ticket
         * @param string[]        $PresentationIdList array of ids
         * @param QueryOptions    $Options
         * @param null            $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationIdList, $Options, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PresentationIdList    = $PresentationIdList;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryActivePresentationConnectionsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryActivePresentationConnectionsRequest extends RequestMessage
    {

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @param string       $Ticket
         * @param string       $PresentationId
         * @param QueryOptions $Options
         * @param string       $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationId, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PresentationId        = $PresentationId;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateAuthTicketRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateAuthTicketRequest extends RequestMessage
    {

        /**
         * @var CreateAuthTicketSettings $TicketSettings
         */
        public $TicketSettings;

        /**
         * @param string                   $Ticket
         * @param CreateAuthTicketSettings $TicketSettings
         */
        function __construct( $Ticket, $TicketSettings ) {
            $this->Ticket         = $Ticket;
            $this->TicketSettings = $TicketSettings;
        }

    }

    /**
     * Proxy class for struct CreateAuthTicketSettings
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateAuthTicketSettings
    {

        /**
         * @var string $ClientIpAddress
         */
        public $ClientIpAddress;

        /**
         * @var int $MinutesToLive
         */
        public $MinutesToLive;

        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @var string $Username
         */
        public $Username;

        /**
         * @param string $ClientIpAddress
         * @param int    $MinutesToLive
         * @param string $ResourceId
         * @param string $Username
         */
        function __construct( $ClientIpAddress, $MinutesToLive, $ResourceId, $Username ) {
            $this->ClientIpAddress = $ClientIpAddress;
            $this->MinutesToLive   = $MinutesToLive;
            $this->ResourceId      = $ResourceId;
            $this->Username        = $Username;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateSubFolderRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateSubFolderRequest extends RequestMessage
    {

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var CreateFolderTypeDetails $FolderType
         */
        public $FolderType;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var ResourcePermissionEntry[] $PermissionList
         */
        public $PermissionList;

        /**
         * @param string                     $Ticket
         * @param string                     $Name
         * @param ResourcePermissionEntry[]  $PermissionList
         * @param string                     $Description
         * @param CreateFolderTypeDetails    $FolderType
         * @param string                     $ParentFolderId
         * @param string                     $ImpersonationUsername
         *
         * @internal param string $Id
         */
        function __construct( $Ticket, $Name, $PermissionList, $Description = null, $FolderType = null, $ParentFolderId = null,
                              $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Description           = $Description;
            $this->FolderType            = $FolderType;
            $this->Name                  = $Name;
            $this->ParentFolderId        = $ParentFolderId;
            $this->PermissionList        = $PermissionList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct ResourcePermissionEntry
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class ResourcePermissionEntry
    {

        /**
         * @var ResourcePermissionMask[] $PermissionMask
         */
        public $PermissionMask;

        /**
         * @var string $RoleId
         */
        public $RoleId;

        /**
         * @param ResourcePermissionMask[]  $PermissionMask
         * @param string                    $RoleId         Must be in MediasiteId format - full GUID including hyphens
         */
        function __construct( $PermissionMask, $RoleId ) {
            $this->PermissionMask = $PermissionMask;
            $this->RoleId         = $RoleId;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateIdentityTicketRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateIdentityTicketRequest extends RequestMessage
    {

        /**
         * @var CreateIdentityTicketSettings $Settings
         */
        public $Settings;

        /**
         * @param string                       $Ticket
         * @param CreateIdentityTicketSettings $Settings
         * @param null                         $ImpersonationUsername
         */
        function __construct( $Ticket, $Settings, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Settings              = $Settings;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreateIdentityTicketSettings
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateIdentityTicketSettings
    {

        /**
         * @var string $ClientIpAddress
         */
        public $ClientIpAddress;

        /**
         * @var int $MinutesToLive
         */
        public $MinutesToLive;

        /**
         * @var string $Username
         */
        public $Username;

        /**
         * @param string $ClientIpAddress
         * @param int    $MinutesToLive
         * @param string $Username
         */
        function __construct( $ClientIpAddress, $MinutesToLive, $Username ) {
            $this->ClientIpAddress = $ClientIpAddress;
            $this->MinutesToLive   = $MinutesToLive;
            $this->Username        = $Username;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationFromTemplateRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationFromTemplateRequest extends RequestMessage
    {

        /**
         * @var CreatePresentationFromTemplateDetails $CreationDetails
         */
        public $CreationDetails;

        /**
         * @param string                                $Ticket
         * @param CreatePresentationFromTemplateDetails $CreationDetails
         * @param null                                  $ImpersonationUsername
         */
        function __construct( $Ticket, $CreationDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CreationDetails       = $CreationDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreatePresentationFromTemplateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationFromTemplateDetails extends BaseCreatePresentationFromTemplateDetails
    {

        /**
         * @var string $PresentationTemplateId
         */
        public $PresentationTemplateId;

        /**
         * @param string                                     $PresentationTemplateId Template to use for new Presentation
         * @param string                                     $Title                  Title of created Presentation
         * @param string                                     $RecordDateTime         date-time formatted string for record date. If not provided defaults to today
         * @param null|\PresentationDataStatusDetails|string $DataStatus             Status for created Presentation defaults to {@link PresentationDataStatusDetails::Scheduled}
         * @param string                                     $CdnPublishingPoint
         * @param string                                     $Description
         * @param int                                        $Duration               Created Presentation's duration. Defaults to 0
         * @param string                                     $FolderId               Folder to create new Presentation in. If not provided Presentation will be created in the root folder
         * @param int                                        $MaxConnections         Max Connections allowed for new Presentation. Defaults to -1 (unlimited)
         * @param string                                     $ModeratorEmail
         * @param string                                     $PresentationId
         */
        function __construct( $PresentationTemplateId, $Title, $RecordDateTime = null,
                              $DataStatus = PresentationDataStatusDetails::Scheduled, $CdnPublishingPoint = null, $Description = null,
                              $Duration = 0, $FolderId = null, $MaxConnections = -1, $ModeratorEmail = null, $PresentationId = null ) {
            $this->PresentationTemplateId = $PresentationTemplateId;
            $this->RecordDateTime         = isset( $RecordDateTime ) ? $RecordDateTime : date('Y-m-d');
            $this->Title                  = $Title;
            $this->DataStatus             = $DataStatus;
            $this->CdnPublishingPoint     = $CdnPublishingPoint;
            $this->Description            = $Description;
            $this->Duration               = $Duration;
            $this->FolderId               = $FolderId;
            $this->MaxConnections         = $MaxConnections;
            $this->ModeratorEmail         = $ModeratorEmail;
            $this->PresentationId         = $PresentationId;
        }

    }

    /**
     * Proxy class for struct BaseCreatePresentationFromTemplateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class BaseCreatePresentationFromTemplateDetails
    {

        /**
         * @var string $CdnPublishingPoint
         */
        public $CdnPublishingPoint;

        /**
         * @var PresentationDataStatusDetails $DataStatus
         */
        public $DataStatus;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var int $Duration
         */
        public $Duration;

        /**
         * @var string $FolderId
         */
        public $FolderId;

        /**
         * @var int $MaxConnections
         */
        public $MaxConnections;

        /**
         * @var string $ModeratorEmail
         */
        public $ModeratorEmail;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var string $RecordDateTime date-time formatted string
         */
        public $RecordDateTime;

        /**
         * @var string $Title
         */
        public $Title;

        /**
         * @var CreatePresenterDetails[] $Presenters
         */
        public $Presenters;

        /**
         * @var string $PlayerId
         */

        /**
         * @param string                                                   $Title          Title of created Presentation
         * @param string                                                   $RecordDateTime date-time formatted string for record date. If not provided defaults to today
         * @param PresentationDataStatusDetails|string                     $DataStatus     Status for created Presentation defaults to {@link PresentationDataStatusDetails::Scheduled}
         * @param string                                                   $CdnPublishingPoint
         * @param string                                                   $Description
         * @param int                                                      $Duration       Created Presentation's duration. Defaults to 0
         * @param string                                                   $FolderId       Folder to create new Presentation in. If not provided Presentation will be created in the root folder
         * @param int                                                      $MaxConnections Max Connections allowed for new Presentation. Defaults to -1 (unlimited)
         * @param string                                                   $ModeratorEmail
         * @param string                                                   $PresentationId
         * @param CreatePresenterDetails[]                                 $Presenters     Presenters to override Schedule/Template presenter list with
         * @param string                                                   $PlayerId       Player Id to overrider Schedule/Template Player with
         */
        function __construct( $Title, $RecordDateTime = null, $DataStatus = PresentationDataStatusDetails::Scheduled,
                              $CdnPublishingPoint = null, $Description = null, $Duration = 0, $FolderId = null, $MaxConnections = -1,
                              $ModeratorEmail = null, $PresentationId = null, $Presenters = null, $PlayerId = null ) {
            $this->CdnPublishingPoint = $CdnPublishingPoint;
            $this->DataStatus         = $DataStatus;
            $this->Description        = $Description;
            $this->Duration           = $Duration;
            $this->FolderId           = $FolderId;
            $this->MaxConnections     = $MaxConnections;
            $this->ModeratorEmail     = $ModeratorEmail;
            $this->PresentationId     = $PresentationId;
            $this->RecordDateTime     = isset( $RecordDateTime ) ? $RecordDateTime : date('Y-m-d');
            $this->Title              = $Title;
            $this->Presenters         = $Presenters;
            $this->PlayerId           = $PlayerId;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationFromScheduleRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationFromScheduleRequest extends RequestMessage
    {

        /**
         * @var CreatePresentationFromScheduleDetails $CreationDetails
         */
        public $CreationDetails;

        /**
         * @param string                                $Ticket
         * @param CreatePresentationFromScheduleDetails $CreationDetails
         * @param null                                  $ImpersonationUsername
         */
        function __construct( $Ticket, $CreationDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CreationDetails       = $CreationDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationFromScheduleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationFromScheduleDetails extends BaseCreatePresentationFromTemplateDetails
    {

        /**
         * @var int $RecurrenceId
         */
        public $RecurrenceId;

        /**
         * @var string $ScheduleId
         */
        public $ScheduleId;

        /**
         * @param string                                     $ScheduleId
         * @param string                                     $Title          Title of created Presentation
         * @param int                                        $RecurrenceId   this value must exist in the database - use QuerySchedulesByCriteria to obtain a valid value
         * @param string                                     $RecordDateTime date-time formatted string for record date. If not provided defaults to today
         * @param null|\PresentationDataStatusDetails|string $DataStatus     Status for created Presentation defaults to {@link PresentationDataStatusDetails::Scheduled}
         * @param string                                     $CdnPublishingPoint
         * @param string                                     $Description
         * @param int                                        $Duration       Created Presentation's duration. Defaults to 0
         * @param string                                     $FolderId       Folder to create new Presentation in. If not provided Presentation will be created in the root folder
         * @param int                                        $MaxConnections Max Connections allowed for new Presentation. Defaults to -1 (unlimited)
         * @param string                                     $ModeratorEmail
         * @param string                                     $PresentationId
         */
        function __construct( $ScheduleId, $Title, $RecurrenceId, $RecordDateTime = null,
                              $DataStatus = PresentationDataStatusDetails::Scheduled, $CdnPublishingPoint = null, $Description = null,
                              $Duration = 0, $FolderId = null, $MaxConnections = -1, $ModeratorEmail = null, $PresentationId = null ) {
            $this->RecurrenceId       = $RecurrenceId;
            $this->ScheduleId         = $ScheduleId;
            $this->CdnPublishingPoint = $CdnPublishingPoint;
            $this->DataStatus         = $DataStatus;
            $this->Description        = $Description;
            $this->Duration           = $Duration;
            $this->FolderId           = $FolderId;
            $this->MaxConnections     = $MaxConnections;
            $this->ModeratorEmail     = $ModeratorEmail;
            $this->PresentationId     = $PresentationId;
            $this->RecordDateTime     = isset( $RecordDateTime ) ? $RecordDateTime : date('Y-m-d');
            $this->Title              = $Title;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationLikeRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationLikeRequest extends RequestMessage
    {

        /**
         * @var CreatePresentationLikeDetails $CreationDetails
         */
        public $CreationDetails;

        /**
         * @param string                        $Ticket
         * @param CreatePresentationLikeDetails $CreationDetails
         * @param null                          $ImpersonationUsername
         */
        function __construct( $Ticket, $CreationDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CreationDetails       = $CreationDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreatePresentationLikeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationLikeDetails
    {

        /**
         * @var string $CreateLikePresentationId
         */
        public $CreateLikePresentationId;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var int $Duration
         */
        public $Duration;

        /**
         * @var string $RecordDateTime date-time formatted string
         */
        public $RecordDateTime;

        /**
         * @var int $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var string $Title
         */
        public $Title;

        /**
         * @param string $CreateLikePresentationId
         * @param string $Title
         * @param string $Description
         * @param int    $Duration
         * @param string $RecordDateTime date-time formatted string
         * @param int    $TimeZoneId
         */
        function __construct( $CreateLikePresentationId, $Title, $TimeZoneId, $Description = null, $Duration = 0
            , $RecordDateTime = null ) {
            $this->CreateLikePresentationId = $CreateLikePresentationId;
            $this->Description              = $Description;
            $this->Duration                 = $Duration;
            $this->RecordDateTime           = isset( $RecordDateTime ) ? $RecordDateTime : date('Y-m-d');
            $this->TimeZoneId               = $TimeZoneId;
            $this->Title                    = $Title;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationPollRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationPollRequest extends RequestMessage
    {

        /**
         * @var CreatePresentationPollDetails $CreateDetails
         */
        public $CreateDetails;

        /**
         * @param string                        $Ticket
         * @param CreatePresentationPollDetails $CreateDetails
         * @param null                          $ImpersonationUsername
         */
        function __construct( $Ticket, $CreateDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CreateDetails         = $CreateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreatePresentationPollDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresentationPollDetails
    {

        /**
         * @var int $Id ID of the poll
         */
        public $Id;

        /**
         * @var PollQuestionDetails[] $PollQuestions
         */
        public $PollQuestions;

        /**
         * @var string $PresentationRootId Mediasite ID of the presentation this poll is for
         */
        public $PresentationRootId;

        /**
         * @param int                    $Id
         * @param PollQuestionDetails[]  $PollQuestions
         * @param string                 $PresentationRootId
         */
        function __construct( $PollQuestions, $PresentationRootId, $Id = 0 ) {
            $this->Id                 = $Id;
            $this->PollQuestions      = $PollQuestions;
            $this->PresentationRootId = $PresentationRootId;
        }

    }

    /**
     * Proxy class for struct PollQuestionDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PollQuestionDetails
    {

        /**
         * @var PollAnswerDetails[] $Answers possible answers for the poll
         */
        public $Answers;

        /**
         * @var int $Id ID of the Poll Question among the questions for this poll
         */
        public $Id;

        /**
         * @var int $Options
         */
        public $Options;

        /**
         * @var int $Order order of the question in the poll
         */
        public $Order;

        /**
         * @var string $PresentationPollId ID of the poll
         */
        public $PresentationPollId;

        /**
         * @var string $QuestionText text of the question
         */
        public $QuestionText;

        /**
         * @var int $TotalRespondents
         */
        public $TotalRespondents;

        /**
         * @param PollAnswerDetails[]  $Answers
         * @param int                  $Id               unused
         * @param string               $PresentationPollId
         * @param string               $QuestionText
         * @param int                  $Order
         * @param int                  $Options          Bitmask of the following options
         *                                               None                         = 0,
         *                                               Result link disabled         = 1,
         *                                               Multiple Choice              = 2,
         *                                               Anonymous                    = 4,
         *                                               Allow multiple submiossions  = 8
         * @param int                  $TotalRespondents unused
         */
        function __construct( $Answers, $PresentationPollId, $QuestionText, $Order = 0, $Options = 0,
                              $TotalRespondents = 0, $Id = 0 ) {
            $this->Answers            = $Answers;
            $this->Id                 = $Id;
            $this->Options            = $Options;
            $this->Order              = $Order;
            $this->PresentationPollId = $PresentationPollId;
            $this->QuestionText       = $QuestionText;
            $this->TotalRespondents   = $TotalRespondents;
        }

    }

    /**
     * Proxy class for struct PollAnswerDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PollAnswerDetails
    {

        /**
         * @var string $AnswerText Text of this answer
         */
        public $AnswerText;

        /**
         * @var int $Id ID of the answer among the answers for this question
         */
        public $Id;

        /**
         * @var int $PollQuestionId ID of the question this answer belongs to
         */
        public $PollQuestionId;

        /**
         * @var int $Result arbitrary result value
         */
        public $Result;

        /**
         * @param string $AnswerText
         * @param int    $Id
         * @param int    $PollQuestionId
         * @param int    $Result
         */
        function __construct( $AnswerText, $Id, $PollQuestionId, $Result ) {
            $this->AnswerText     = $AnswerText;
            $this->Id             = $Id;
            $this->PollQuestionId = $PollQuestionId;
            $this->Result         = $Result;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateScheduleFromTemplateRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateScheduleFromTemplateRequest extends RequestMessage
    {

        /**
         * @var CreateScheduleFromTemplateDetails $Schedule
         */
        public $Schedule;

        /**
         * @param string                            $Ticket
         * @param CreateScheduleFromTemplateDetails $Schedule
         * @param string                            $ImpersonationUsername
         */
        function __construct( $Ticket, $Schedule, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Schedule              = $Schedule;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreateScheduleFromTemplateDetails.
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateScheduleFromTemplateDetails
    {

        /**
         * @var string $TemplateId
         */
        public $TemplateId;

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
         * @var boolean $CreatePresentation
         */
        public $CreatePresentation;

        /**
         * @var string $Description
         */
        public $Description;

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
         * @var string $PublishingPoint
         */
        public $PublishingPoint;

        /**
         * @var string $ReceipientsEmailAddresses
         */
        public $ReceipientsEmailAddresses;

        /**
         * @var string $RecorderId
         */
        public $RecorderId;

        /**
         * @var ScheduleRecurrenceDetails[] $RecurrenceList
         */
        public $RecurrenceList;

        /**
         * @var string $SendersEmail
         */
        public $SendersEmail;

        /**
         * @var string $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var string $TimeZoneRegistryKey
         */
        public $TimeZoneRegistryKey;

        /**
         * @var ScheduleTitleType $TitleType
         */
        public $TitleType;

        public $DeleteInactive;
        public $ReviewEditApproveEnabled;
        public $ReplaceAclWithPolicy;

        /**
         * @param string                                  $TemplateId
         * @param string                                  $Name
         * @param ScheduleRecurrenceDetails[]             $RecurrenceList
         * @param ScheduleTitleType                       $TitleType
         * @param int                                     $AdvanceCreationTime
         * @param int                                     $AdvanceLoadTimeInSeconds
         * @param int                                     $NextNumberInSchedule
         * @param bool                                    $AutoStart
         * @param bool                                    $AutoStop
         * @param bool                                    $CreatePresentation
         * @param bool                                    $LoadPresentation
         * @param int                                     $NextNumberInSchedule
         * @param bool                                    $NotifyPresenter
         * @param string                                  $Description
         * @param string                                  $PublishingPoint
         * @param string                                  $RecipientsEmailAddresses
         * @param string                                  $RecorderId
         * @param string                                  $SendersEmail
         * @param string                                  $TimeZoneId
         * @param string                                  $TimeZoneRegistryKey
         *
         * @param bool                                    $DeleteInactive
         * @param bool                                    $ReviewEditApproveEnabled
         * @param bool                                    $ReplaceAclWithPolicy
         */
        function __construct( $TemplateId, $Name, $RecurrenceList, $TitleType, $AdvanceCreationTime,
                              $AdvanceLoadTimeInSeconds, $NextNumberInSchedule, $AutoStart, $AutoStop, $CreatePresentation,
                              $LoadPresentation, $NotifyPresenter, $Description = null, $PublishingPoint = null,
                              $RecipientsEmailAddresses = null, $RecorderId = null, $SendersEmail = null, $TimeZoneId = null,
                              $TimeZoneRegistryKey = null,
                              $DeleteInactive = FALSE, $ReviewEditApproveEnabled = FALSE, $ReplaceAclWithPolicy = FALSE ) {
            $this->AdvanceCreationTime      = $AdvanceCreationTime;
            $this->AdvanceLoadTimeInSeconds = $AdvanceLoadTimeInSeconds;
            $this->AutoStart                = $AutoStart;
            $this->AutoStop                 = $AutoStop;
            $this->CreatePresentation       = $CreatePresentation;
            $this->Description              = $Description;
            $this->LoadPresentation         = $LoadPresentation;
            $this->Name                     = $Name;
            $this->NextNumberInSchedule     = $NextNumberInSchedule;
            $this->NotifyPresenter          = $NotifyPresenter;
            $this->PublishingPoint          = $PublishingPoint;
            $this->RecipientsEmailAddresses = $RecipientsEmailAddresses;
            $this->RecorderId               = $RecorderId;
            $this->RecurrenceList           = $RecurrenceList;
            $this->SendersEmail             = $SendersEmail;
            $this->TemplateId               = $TemplateId;
            $this->TitleType                = $TitleType;
            $this->DeleteInactive           = $DeleteInactive;
            $this->ReviewEditApproveEnabled = $ReviewEditApproveEnabled;
            $this->ReplaceAclWithPolicy     = $ReplaceAclWithPolicy;
        }

    }

    /**
     * Proxy class for struct ScheduleRecurrenceDetails.
     * If RecurrencePattern is RecurrencePattern::Daily
     *  WeekDayOnly forced to true
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class ScheduleRecurrenceDetails
    {

        /**
         * @var int $DayOfTheMonth
         * Only used when RecurrencePattern is RecurrencePattern::Monthly or RecurrencePattern::Yearly, otherwise disregarded
         */
        public $DayOfTheMonth;

        /**
         * @var WeekDay $DaysOfTheWeek
         * Use WeekDay[] to Provide multiple weekdays
         * Only used when RecurrencePattern is RecurrencePattern::Weekly, RecurrencePattern::Monthly, or RecurrencePattern::Yearly, otherwise disregarded
         */
        public $DaysOfTheWeek;

        /**
         * @var string $EndRecordDateTime date-time formatted string
         */
        public $EndRecordDateTime;

        /**
         * @var RecurrenceExcludeDateRangeDetails[] $ExcludeDateRangeList
         */
        public $ExcludeDateRangeList;

        /**
         * @var boolean $ExcludeHolidays
         */
        public $ExcludeHolidays;

        /**
         * @var int $Id
         */
        public $Id;

        /**
         * @var MonthOfTheYear $MonthOfTheYear
         * Only used when RecurrencePattern is RecurrencePattern::Yearly, otherwise disregarded
         */
        public $MonthOfTheYear;

        /**
         * @var string $NextScheduleTime date-time formatted string
         */
        public $NextScheduleTime;

        /**
         * @var int $RecordDuration
         */
        public $RecordDuration;

        /**
         * @var int $RecurrenceFrequency
         */
        public $RecurrenceFrequency;

        /**
         * @var RecurrencePattern $RecurrencePattern
         */
        public $RecurrencePattern;

        /**
         * @var RecurrencePatternType $RecurrencePatternType
         */
        public $RecurrencePatternType;

        /**
         * @var string $StartRecordDateTime date-time formatted string
         */
        public $StartRecordDateTime;

        /**
         * @var boolean $WeekDayOnly
         */
        public $WeekDayOnly;

        /**
         * @var WeekOfTheMonth $WeekOfTheMonth
         * Only used when RecurrencePattern is RecurrencePattern::Monthly or RecurrencePattern::Yearly, otherwise disregarded
         */
        public $WeekOfTheMonth;

        /**
         * @param int                                                 $Id
         * @param int                                                 $DayOfTheMonth
         * @param string                                              $StartRecordDateTime  date-time formatted string
         * @param string                                              $EndRecordDateTime    date-time formatted string must be after $StartRecordDateTime
         * @param RecurrenceExcludeDateRangeDetails[]                 $ExcludeDateRangeList can be an empty array, but must be supplied
         * @param bool                                                $ExcludeHolidays
         * @param MonthOfTheYear                                      $MonthOfTheYear
         * @param string                                              $NextScheduleTime     date-time formatted string
         * @param int                                                 $RecordDuration
         * @param int                                                 $RecurrenceFrequency
         * @param RecurrencePattern                                   $RecurrencePattern
         * @param RecurrencePatternType                               $RecurrencePatternType
         * @param bool                                                $WeekDayOnly
         * @param WeekOfTheMonth                                      $WeekOfTheMonth
         * @param WeekDay                                             $DaysOfTheWeek
         */
        function __construct( $Id, $DayOfTheMonth, $StartRecordDateTime, $EndRecordDateTime, $ExcludeDateRangeList,
                              $ExcludeHolidays, $MonthOfTheYear, $NextScheduleTime, $RecordDuration, $RecurrenceFrequency,
                              $RecurrencePattern, $RecurrencePatternType, $WeekDayOnly, $WeekOfTheMonth, $DaysOfTheWeek = null ) {
            $this->DayOfTheMonth         = $DayOfTheMonth;
            $this->DaysOfTheWeek         = $DaysOfTheWeek;
            $this->EndRecordDateTime     = $EndRecordDateTime;
            $this->ExcludeDateRangeList  = $ExcludeDateRangeList;
            $this->ExcludeHolidays       = $ExcludeHolidays;
            $this->Id                    = $Id;
            $this->MonthOfTheYear        = $MonthOfTheYear;
            $this->NextScheduleTime      = $NextScheduleTime;
            $this->RecordDuration        = $RecordDuration;
            $this->RecurrenceFrequency   = $RecurrenceFrequency;
            $this->RecurrencePattern     = $RecurrencePattern;
            $this->RecurrencePatternType = $RecurrencePatternType;
            $this->StartRecordDateTime   = $StartRecordDateTime;
            $this->WeekDayOnly           = $WeekDayOnly;
            $this->WeekOfTheMonth        = $WeekOfTheMonth;
        }

    }

    /**
     * Proxy class for struct RecurrenceExcludeDateRangeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class RecurrenceExcludeDateRangeDetails
    {

        /**
         * @var string $End date-time formatted string
         */
        public $End;

        /**
         * @var int $ExcludeId
         */
        public $ExcludeId;

        /**
         * @var string $Start date-time formatted string
         */
        public $Start;

        /**
         * @param string $End   date-time formatted string
         * @param int    $ExcludeId
         * @param string $Start date-time formatted string
         */
        function __construct( $End, $ExcludeId, $Start ) {
            $this->End       = $End;
            $this->ExcludeId = $ExcludeId;
            $this->Start     = $Start;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct GetVersionRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class GetVersionRequest extends RequestMessage
    {

        /**
         * @param string $Ticket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct LoginRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class LoginRequest
    {

        /**
         * @var string $ApplicationName
         */
        public $ApplicationName;

        /**
         * @var string $Password
         */
        public $Password;

        /**
         * @var string $Username
         */
        public $Username;

        /**
         * @var string $ImpersonationUsername
         */
        public $ImpersonationUsername;

        /**
         * @param string $Username
         * @param string $Password
         * @param string $ApplicationName
         * @param        string @ImpersonationUsername
         */
        function __construct( $Username, $Password, $ApplicationName = null, $ImpersonationUsername = null ) {
            $this->Username              = $Username;
            $this->Password              = $Password;
            $this->ApplicationName       = $ApplicationName;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct LogoutRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class LogoutRequest extends RequestMessage
    {

        /**
         * @param string $Ticket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryAuthTicketPropertiesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryAuthTicketPropertiesRequest extends RequestMessage
    {

        /**
         * @var string $AuthTicketId
         */
        public $AuthTicketId;

        /**
         * @var int $MinutesToLive
         */
        public $MinutesToLive;

        /**
         * @var boolean $RenewTicket
         */
        public $RenewTicket;

        /**
         * @param string $Ticket
         * @param string $AuthTicketId
         * @param int    $MinutesToLive
         * @param bool   $RenewTicket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $AuthTicketId, $MinutesToLive, $RenewTicket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->AuthTicketId          = $AuthTicketId;
            $this->MinutesToLive         = $MinutesToLive;
            $this->RenewTicket           = $RenewTicket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryCatalogSharesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryCatalogSharesRequest extends RequestMessage
    {

        /**
         * @var ResourcePermissionMask[] $PermissionMask
         */
        public $PermissionMask;

        /**
         * @param string                    $Ticket
         * @param ResourcePermissionMask[]  $PermissionMask
         * @param string                    $ImpersonationUsername
         */
        function __construct( $Ticket, $PermissionMask, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PermissionMask        = $PermissionMask;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryChapterPointsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryChapterPointsRequest extends RequestMessage
    {

        /**
         * @var int $Count
         */
        public $Count;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var int $StartIndex
         */
        public $StartIndex;

        /**
         * @param string $Ticket
         * @param int    $Count
         * @param string $PresentationId
         * @param int    $StartIndex
         * @param string $ImpersonationUsername
         */
        function __construct( $Ticket, $Count, $PresentationId, $StartIndex, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Count                 = $Count;
            $this->PresentationId        = $PresentationId;
            $this->StartIndex            = $StartIndex;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryClientIpAddressRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryClientIpAddressRequest extends RequestMessage
    {

        /**
         * @var boolean $ResolveDnsName
         */
        public $ResolveDnsName;

        /**
         * @param string $Ticket
         * @param bool   $ResolveDnsName
         * @param string $ImpersonationUsername
         */
        function __construct( $Ticket, $ResolveDnsName, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->ResolveDnsName        = $ResolveDnsName;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryContentServersByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryContentServersByCriteriaRequest extends RequestMessage
    {

        /**
         * @var ContentServerQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string                     $Ticket
         * @param ContentServerQueryCriteria $Criteria
         * @param null                       $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct ContentServerQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class ContentServerQueryCriteria
    {

        /**
         * @var bool $IncludeStorageSettings
         */
        public $IncludeStorageSettings;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var ContentServerQueryBy $QueryBy
         */
        public $QueryBy;

        /**
         * @var ContentServerTypeDetails $ServerType
         */
        public $ServerType;

        /**
         * @var string $Key
         */
        public $Key;

        /**
         * @param bool                     $IncludeStorageSettings
         * @param string                   $PresentationId
         * @param ContentServerQueryBy     $QueryBy
         * @param ContentServerTypeDetails $ServerType
         * @param string                   $Key
         */
        function __construct( $QueryBy, $IncludeStorageSettings = null, $PresentationId = null, $ServerType = null, $Key = null ) {
            $this->IncludeStorageSettings = $IncludeStorageSettings;
            $this->PresentationId         = $PresentationId;
            $this->QueryBy                = $QueryBy;
            $this->ServerType             = $ServerType;
            $this->Key                    = $Key;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryFoldersByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryFoldersByIdRequest extends RequestMessage
    {

        /**
         * @var string[]$FolderIdList
         */
        public $FolderIdList;

        /**
         * @var ResourcePermissionMask $PermissionMask
         */
        public $PermissionMask;

        /**
         * @param string                 $Ticket
         * @param string[]               $FolderIdList
         * @param ResourcePermissionMask $PermissionMask
         * @param null                   $ImpersonationUsername
         */
        function __construct( $Ticket, $FolderIdList, $PermissionMask, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->FolderIdList          = $FolderIdList;
            $this->PermissionMask        = $PermissionMask;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryFoldersWithPresentationsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryFoldersWithPresentationsRequest extends RequestMessage
    {

        /**
         * @param string $Ticket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryIdentityTicketPropertiesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryIdentityTicketPropertiesRequest extends RequestMessage
    {

        /**
         * @var string $IdentityTicket
         */
        public $IdentityTicket;

        /**
         * @var int $MinutesToLive
         */
        public $MinutesToLive;

        /**
         * @var boolean $RenewTicket
         */
        public $RenewTicket;

        /**
         * @param string $Ticket
         * @param string $IdentityTicket
         * @param int    $MinutesToLive
         * @param bool   $RenewTicket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $IdentityTicket, $MinutesToLive, $RenewTicket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->IdentityTicket        = $IdentityTicket;
            $this->MinutesToLive         = $MinutesToLive;
            $this->RenewTicket           = $RenewTicket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryContentEncodingSettingsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryContentEncodingSettingsByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $ContentEncodingSettingsIds
         */
        public $ContentEncodingSettingsIds;

        /**
         * @param string   $Ticket
         * @param string[] $ContentEncodingSettingsIds
         * @param null     $ImpersonationUsername
         */
        function __construct( $Ticket, $ContentEncodingSettingsIds, $ImpersonationUsername = null ) {
            $this->Ticket                     = $Ticket;
            $this->ContentEncodingSettingsIds = $ContentEncodingSettingsIds;
            $this->ImpersonationUsername      = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryContentEncodingSettingsByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryContentEncodingSettingsByCriteriaRequest extends RequestMessage
    {

        /**
         * @var ContentEncodingSettingsQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string                               $Ticket
         * @param ContentEncodingSettingsQueryCriteria $Criteria
         * @param null                                 $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct ContentEncodingSettingsQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class ContentEncodingSettingsQueryCriteria
    {

        /**
         * @var string[] $ContentEncodingSettingsIdList
         */
        public $ContentEncodingSettingsIdList;

        /**
         * @var string[] $RecorderSupportedMimeTypes
         */
        public $RecorderSupportedMimeTypes;

        /**
         * @param string[] $ContentEncodingSettingsIdList
         * @param string[] $RecorderSupportedMimeTypes
         */
        function __construct( $ContentEncodingSettingsIdList, $RecorderSupportedMimeTypes = null ) {
            $this->ContentEncodingSettingsIdList = $ContentEncodingSettingsIdList;
            $this->RecorderSupportedMimeTypes    = $RecorderSupportedMimeTypes;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryPlayersRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPlayersRequest extends RequestMessage
    {

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentationsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentationsByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $PresentationIdList
         */
        public $PresentationIdList;

        /**
         * @param string   $Ticket
         * @param string[] $PresentationIdList
         * @param null     $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationIdList, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PresentationIdList    = $PresentationIdList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentationsByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentationsByCriteriaRequest extends RequestMessage
    {

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var PresentationQueryCriteria $QueryCriteria
         */
        public $QueryCriteria;

        /**
         * @param string                    $Ticket
         * @param PresentationQueryCriteria $QueryCriteria
         * @param QueryOptions              $Options
         * @param null                      $ImpersonationUsername
         */
        function __construct( $Ticket, $QueryCriteria, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Options               = $Options;
            $this->QueryCriteria         = $QueryCriteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct PresentationQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PresentationQueryCriteria
    {

        /**
         * @var string $StartDate date-time formatted string
         */
        public $StartDate;

        /**
         * @var string $EndDate date-time formatted string
         */
        public $EndDate;

        /**
         * @var ResourcePermissionMask $PermissionMask
         */
        public $PermissionMask;

        /**
         * @var string $TitleRegEx
         */
        public $TitleRegEx;

        /**
         * @var boolean $IsInRecycleBin
         */
        public $IsInRecycleBin;

        /**
         * @var int $MinimumDeviceClass
         */
        public $MinimumDeviceClass;

        /**
         * @var PresentationDataStatusDetails[] $StatusFilterList
         */
        public $StatusFilterList;

        /**
         * @var string[] $FolderIdFilter
         */
        public $FolderIdFilter;

        /**
         * @var string $PrimaryOnDemandMimeType
         */
        public $PrimaryOnDemandMimeType;

        /**
         * @var ResourcePermissionMask $RootPermissionMask
         */
        public $RootPermissionMask;

        /**
         * @param string                                             $StartDate        must be a valid date or date-time string
         * @param string                                             $EndDate          must be a valid date or date-time string
         * @param ResourcePermissionMask[]                           $PermissionMask
         * @param bool                                               $IsInRecycleBin
         * @param int                                                $MinimumDeviceClass
         * @param string                                             $TitleRegEx
         * @param PresentationDataStatusDetails[]                    $StatusFilterList
         * @param string[]                                           $FolderIdFilter
         * @param string                                             $PrimaryOnDemandMimeType
         * @param ResourcePermissionMask                             $RootPermissionMask
         */
        function __construct( $StartDate, $EndDate, $PermissionMask, $IsInRecycleBin, $MinimumDeviceClass = null,
                              $TitleRegEx = null, $StatusFilterList = null, $FolderIdFilter = null, $PrimaryOnDemandMimeType = null,
                              $RootPermissionMask = null ) {
            $this->StartDate               = $StartDate;
            $this->EndDate                 = $EndDate;
            $this->PermissionMask          = $PermissionMask;
            $this->IsInRecycleBin          = $IsInRecycleBin;
            $this->MinimumDeviceClass      = $MinimumDeviceClass;
            $this->TitleRegEx              = $TitleRegEx;
            $this->StatusFilterList        = $StatusFilterList;
            $this->FolderIdFilter          = $FolderIdFilter;
            $this->PrimaryOnDemandMimeType = $PrimaryOnDemandMimeType;
            $this->RootPermissionMask      = $RootPermissionMask;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentationTemplatesByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentationTemplatesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var PresentationTemplateQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @param string                            $Ticket
         * @param PresentationTemplateQueryCriteria $Criteria
         * @param QueryOptions                      $Options
         * @param null                              $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct PresentationTemplateQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PresentationTemplateQueryCriteria
    {

        /**
         * @var boolean $IncludeContentDetails
         */
        public $IncludeContentDetails;

        /**
         * @var int $MinimumDeviceClass
         */
        public $MinimumDeviceClass;

        /**
         * @var string[] $PresentationTemplateIdList
         */
        public $PresentationTemplateIdList;

        /**
         * @var string[] $RecorderSupportedMimeTypes
         */
        public $RecorderSupportedMimeTypes;

        /**
         * @param bool     $IncludeContentDetails
         * @param int      $MinimumDeviceClass
         * @param string[] $PresentationTemplateIdList
         * @param string[] $RecorderSupportedMimeTypes
         */
        function __construct( $IncludeContentDetails, $MinimumDeviceClass = null, $PresentationTemplateIdList = null,
                              $RecorderSupportedMimeTypes = null ) {
            $this->IncludeContentDetails      = $IncludeContentDetails;
            $this->MinimumDeviceClass         = $MinimumDeviceClass;
            $this->PresentationTemplateIdList = $PresentationTemplateIdList;
            $this->RecorderSupportedMimeTypes = $RecorderSupportedMimeTypes;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentersByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentersByCriteriaRequest extends RequestMessage
    {

        /**
         * @var PresenterQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string                 $Ticket
         * @param PresenterQueryCriteria $Criteria
         * @param null                   $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct PresenterQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PresenterQueryCriteria
    {

        /**
         * @var string $EmailAddress
         */
        public $EmailAddress;

        /**
         * @var string $FirstName
         */
        public $FirstName;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $LastName
         */
        public $LastName;

        /**
         * @param string $EmailAddress
         * @param string $FirstName
         * @param string $Id
         * @param string $LastName
         */
        function __construct( $EmailAddress = null, $FirstName = null, $Id = null, $LastName = null ) {
            $this->EmailAddress = $EmailAddress;
            $this->FirstName    = $FirstName;
            $this->Id           = $Id;
            $this->LastName     = $LastName;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentersByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryPresentersByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $PresenterIdList
         */
        public $PresenterIdList;

        /**
         * @param string   $Ticket
         * @param string[] $PresenterIdList
         * @param null     $ImpersonationUsername
         */
        function __construct( $Ticket, $PresenterIdList, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PresenterIdList       = $PresenterIdList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryResourcePermissionListRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryResourcePermissionListRequest extends RequestMessage
    {

        /**
         * @var ResourceIdentifier $Resource
         */
        public $Resource;

        /**
         * @param string             $Ticket
         * @param ResourceIdentifier $Resource
         * @param null               $ImpersonationUsername
         */
        function __construct( $Ticket, $Resource, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Resource              = $Resource;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct ResourceIdentifier
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class ResourceIdentifier
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var ResourceType $Type
         */
        public $Type;

        /**
         * @param string       $Id
         * @param ResourceType $Type
         */
        function __construct( $Id, $Type ) {
            $this->Id   = $Id;
            $this->Type = $Type;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryResourcePermissionsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryResourcePermissionsRequest extends RequestMessage
    {

        /**
         * @var ResourceIdentifier[] $ResourceList
         */
        public $ResourceList;

        /**
         * @param string               $Ticket
         * @param ResourceIdentifier[] $ResourceList
         * @param null                 $ImpersonationUsername
         */
        function __construct( $Ticket, $ResourceList, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ResourceList          = $ResourceList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QuerySchedulesByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QuerySchedulesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var PresentationScheduleQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @param string                            $Ticket
         * @param PresentationScheduleQueryCriteria $Criteria
         * @param QueryOptions                      $Options
         * @param null                              $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct PresentationScheduleQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PresentationScheduleQueryCriteria
    {

        /**
         * @var boolean $IgnoreInactiveSchedules
         */
        public $IgnoreInactiveSchedules;

        /**
         * @var QueryScheduleBy $QueryScheduleBy
         */
        public $QueryScheduleBy;

        /**
         * @var string $Key
         */
        public $Key;

        /**
         * @var string $LastSyncDateTimeUtc date-time formatted string
         */
        public $LastSyncDateTimeUtc;

        /**
         * @var int $MinimumDeviceClass
         */
        public $MinimumDeviceClass;

        /**
         * @var string $RecorderPhysicalAddress
         */
        public $RecorderPhysicalAddress;

        /**
         * @var string $ScheduleId
         */
        public $ScheduleId;

        /**
         * @var int $ServiceId
         */
        public $ServiceId;

        /**
         * @param bool            $IgnoreInactiveSchedules
         * @param string          $Key
         * @param string          $LastSyncDateTimeUtc date-time formatted string
         * @param int             $ServiceId
         * @param int             $MinimumDeviceClass
         * @param QueryScheduleBy $QueryScheduleBy
         * @param string          $RecorderPhysicalAddress
         * @param string          $ScheduleId
         */
        function __construct( $IgnoreInactiveSchedules, $QueryScheduleBy, $Key = null, $LastSyncDateTimeUtc = null,
                              $ServiceId = null, $MinimumDeviceClass = null, $RecorderPhysicalAddress = null,
                              $ScheduleId = null ) {
            $this->IgnoreInactiveSchedules = $IgnoreInactiveSchedules;
            $this->QueryScheduleBy         = $QueryScheduleBy;
            $this->Key                     = $Key;
            $this->LastSyncDateTimeUtc     = $LastSyncDateTimeUtc;
            $this->ServiceId               = $ServiceId;
            $this->MinimumDeviceClass      = $MinimumDeviceClass;
            $this->RecorderPhysicalAddress = $RecorderPhysicalAddress;
            $this->ScheduleId              = $ScheduleId;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QuerySitePropertiesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QuerySitePropertiesRequest extends RequestMessage
    {

        /**
         * @param string $Ticket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QuerySlidesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QuerySlidesRequest extends RequestMessage
    {

        /**
         * @var int $Count
         */
        public $Count;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var int $StartIndex
         */
        public $StartIndex;

        /**
         * @param string $Ticket
         * @param int    $Count
         * @param string $PresentationId
         * @param int    $StartIndex
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $Count, $PresentationId, $StartIndex, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Count                 = $Count;
            $this->PresentationId        = $PresentationId;
            $this->StartIndex            = $StartIndex;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QuerySubFolderDetailsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QuerySubFolderDetailsRequest extends RequestMessage
    {

        /**
         * @var boolean $IncludeAllSubFolders
         */
        public $IncludeAllSubFolders;

        /**
         * @var string[] $ParentFolderIdList
         */
        public $ParentFolderIdList;

        /**
         * @var ResourcePermissionMask $PermissionMask
         */
        public $PermissionMask;

        /**
         * @param string                 $Ticket
         * @param bool                   $IncludeAllSubFolders
         * @param string[]               $ParentFolderIdList
         * @param ResourcePermissionMask $PermissionMask
         * @param null                   $ImpersonationUsername
         */
        function __construct( $Ticket, $IncludeAllSubFolders, $ParentFolderIdList, $PermissionMask,
                              $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->IncludeAllSubFolders  = $IncludeAllSubFolders;
            $this->ParentFolderIdList    = $ParentFolderIdList;
            $this->PermissionMask        = $PermissionMask;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryTimeZonesByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryTimeZonesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var TimeZoneQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string                $Ticket
         * @param TimeZoneQueryCriteria $Criteria
         * @param null                  $ImpersonationUsername
         *
         * @internal param string $ticket
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Generated data proxy class for struct TimeZoneQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class TimeZoneQueryCriteria
    {

        /**
         * @var int[] $TimeZoneIdList
         */
        public $TimeZoneIdList;

        /**
         * @param int[] $TimeZoneIdList
         */
        function __construct( $TimeZoneIdList ) {
            $this->TimeZoneIdList = $TimeZoneIdList;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct RemoveAuthTicketRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class RemoveAuthTicketRequest extends RequestMessage
    {

        /**
         * @var string $AuthTicketId
         */
        public $AuthTicketId;

        /**
         * @param string $Ticket       current request's authentication ticket
         * @param string $AuthTicketId auth ticket to remove
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $AuthTicketId, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->AuthTicketId          = $AuthTicketId;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct RemoveIdentityTicketRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class RemoveIdentityTicketRequest extends RequestMessage
    {

        /**
         * @var string $IdentityTicket
         */
        public $IdentityTicket;

        /**
         * @param string $Ticket         the current request's authentication ticket
         * @param string $IdentityTicket Identity ticket to remove
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $IdentityTicket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->IdentityTicket        = $IdentityTicket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Generated data proxy class for struct TestRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class TestRequest
    {

    }

    /**
     * @internal
     *
     * Proxy class for struct SearchRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class SearchRequest extends RequestMessage
    {

        /**
         * @var SupportedSearchField[] $Fields
         */
        public $Fields;

        /**
         * @var string $Id  Limit search to a single presentation
         */
        public $Id;

        /**
         * @var QueryOptions $Options
         */
        public $Options;

        /**
         * @var string $SearchText
         */
        public $SearchText;

        /**
         * @var SupportedSearchType[] $Types
         */
        public $Types;
        public $DisableCaptionHighlighting;
        public $DisableOcrHighlighting;

        /**
         * @param string                      $Ticket
         * @param SupportedSearchField        $Fields
         * @param string                      $SearchText
         * @param SupportedSearchType         $Types
         * @param QueryOptions                $Options
         * @param bool                        $DisableCaptionHighlighting
         * @param bool                        $DisableOcrHighlighting
         * @param string                      $Id
         * @param null                        $ImpersonationUsername
         */
        function __construct( $Ticket, $Fields, $SearchText, $Types, $Options = null, $DisableCaptionHighlighting = null, $DisableOcrHighlighting = null, $Id = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Fields                = $Fields;
            $this->Options               = $Options;
            $this->SearchText            = $SearchText;
            $this->Types                 = $Types;
            $this->DisableCaptionHighlighting = $DisableCaptionHighlighting;
            $this->DisableOcrHighlighting = $DisableOcrHighlighting;
            $this->ImpersonationUsername = $ImpersonationUsername;
            $this->Id                    = $Id;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct UpdateScheduleRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateScheduleRequest extends RequestMessage
    {

        /**
         * @var UpdateScheduleDetails $Schedule
         */
        public $Schedule;

        /**
         * @param string                $Ticket
         * @param UpdateScheduleDetails $Schedule
         * @param null                  $ImpersonationUsername
         */
        function __construct( $Ticket, $Schedule, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Schedule              = $Schedule;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct UpdateScheduleDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateScheduleDetails
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var bool $AdvanceCreationTimeIsSet
         */
        public $AdvanceCreationTimeIsSet;

        /**
         * @var bool $AdvanceLoadTimeInSecondsIsSet
         */
        public $AdvanceLoadTimeInSecondsIsSet;

        /**
         * @var bool $AutoStartIsSet
         */
        public $AutoStartIsSet;

        /**
         * @var bool $AutoStopIsSet
         */
        public $AutoStopIsSet;

        /**
         * @var bool $CreatePresentationIsSet
         */
        public $CreatePresentationIsSet;

        /**
         * @var bool $DeleteInactiveIsSet
         */
        public $DeleteInactiveIsSet;

        /**
         * @var bool $DescriptionIsSet
         */
        public $DescriptionIsSet;

        /**
         * @var bool $FolderIdIsSet
         */
        public $FolderIdIsSet;

        /**
         * @var bool $IsForumsEnabledIsSet
         */
        public $IsForumsEnabledIsSet;

        /**
         * @var bool $IsLiveIsSet
         */
        public $IsLiveIsSet;

        /**
         * @var bool $IsOnDemandIsSet
         */
        public $IsOnDemandIsSet;

        /**
         * @var bool $IsPollsEnabledIsSet
         */
        public $IsPollsEnabledIsSet;

        /**
         * @var bool $IsUploadAutomaticIsSet
         */
        public $IsUploadAutomaticIsSet;

        /**
         * @var bool $LoadPresentationIsSet
         */
        public $LoadPresentationIsSet;

        /**
         * @var bool $NameIsSet
         */
        public $NameIsSet;

        /**
         * @var bool $NextNumberInScheduleIsSet
         */
        public $NextNumberInScheduleIsSet;

        /**
         * @var bool $NotifyPresenterIsSet
         */
        public $NotifyPresenterIsSet;

        /**
         * @var bool $PlayerIdIsSet
         */
        public $PlayerIdIsSet;

        /**
         * @var bool $PublishingPointIsSet
         */
        public $PublishingPointIsSet;

        /**
         * @var bool $RecipientsEmailAddressesIsSet
         */
        public $RecipientsEmailAddressesIsSet;

        /**
         * @var bool $RecorderIdIsSet
         */
        public $RecorderIdIsSet;

        /**
         * @var bool $ReplaceAclWithPolicyIsSet
         */
        public $ReplaceAclWithPolicyIsSet;

        /**
         * @var bool $ReviewEditApproveEnabledIsSet
         */
        public $ReviewEditApproveEnabledIsSet;

        /**
         * @var bool $SendersEmailIsSet
         */
        public $SendersEmailIsSet;

        /**
         * @var bool $TimeZoneIdIsSet
         */
        public $TimeZoneIdIsSet;

        /**
         * @var bool $TimeZoneRegistryKeyIsSet
         */
        public $TimeZoneRegistryKeyIsSet;

        /**
         * @var bool $TitleTypeIsSet
         */
        public $TitleTypeIsSet;

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
         * @var boolean $CreatePresentation
         */
        public $CreatePresentation;

        /**
         * @var bool $DeleteInactive
         */
        public $DeleteInactive;

        /**
         * @var boolean $IsLive
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
         * @var boolean $LoadPresentation
         */
        public $LoadPresentation;

        /**
         * @var int $NextNumberInSchedule
         */
        public $NextNumberInSchedule;

        /**
         * @var boolean $NotifyPresenter
         */
        public $NotifyPresenter;

        /**
         * @var bool $ReplaceAclWithPolicy
         */
        public $ReplaceAclWithPolicy;

        /**
         * @var bool $ReviewEditApproveEnabled
         */
        public $ReviewEditApproveEnabled;

        /**
         * @var int $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var ResourcePermissionEntry[] $AccessControlList
         */
        public $AccessControlList;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $FolderId
         */
        public $FolderId;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $PlayerId
         */
        public $PlayerId;

        /**
         * @var CreatePresenterDetails[] $PresenterList
         */
        public $PresenterList;

        /**
         * @var string $PublishingPoint
         */
        public $PublishingPoint;

        /**
         * @var string $RecipientsEmailAddresses
         */
        public $RecipientsEmailAddresses;

        /**
         * @var string $RecorderId
         */
        public $RecorderId;

        /**
         * @var ScheduleRecurrenceDetails[] $RecurrenceList
         */
        public $RecurrenceList;

        /**
         * @var string $SendersEmail
         */
        public $SendersEmail;

        /**
         * @var int $TimeZoneRegistryKey
         */
        public $TimeZoneRegistryKey;

        /**
         * @var ScheduleTitleType $TitleType
         */
        public $TitleType;

        /**
         * @param string                                  $Id
         * @param bool                                    $AdvanceCreationTimeIsSet
         * @param bool                                    $AdvanceLoadTimeInSecondsIsSet
         * @param bool                                    $AutoStartIsSet
         * @param bool                                    $AutoStopIsSet
         * @param bool                                    $CreatePresentationIsSet
         * @param bool                                    $DeleteInactiveIsSet
         * @param bool                                    $DescriptionIsSet
         * @param bool                                    $FolderIdIsSet
         * @param bool                                    $IsForumsEnabledIsSet
         * @param bool                                    $IsLiveIsSet
         * @param bool                                    $IsOnDemandIsSet
         * @param bool                                    $IsPollsEnabledIsSet
         * @param bool                                    $IsUploadAutomaticIsSet
         * @param bool                                    $LoadPresentationIsSet
         * @param bool                                    $NameIsSet
         * @param bool                                    $NextNumberInScheduleIsSet
         * @param bool                                    $NotifyPresenterIsSet
         * @param bool                                    $PlayerIdIsSet
         * @param bool                                    $PublishingPointIsSet
         * @param bool                                    $RecipientsEmailAddressesIsSet
         * @param bool                                    $RecorderIdIsSet
         * @param bool                                    $ReplaceAclWithPolicyIsSet
         * @param bool                                    $ReviewEditApproveEnabledIsSet
         * @param bool                                    $SendersEmailIsSet
         * @param bool                                    $TimeZoneIdIsSet
         * @param bool                                    $TimeZoneRegistryKeyIsSet
         * @param bool                                    $TitleTypeIsSet
         * @param int                                     $AdvanceCreationTime
         * @param int                                     $AdvanceLoadTimeInSeconds
         * @param bool                                    $AutoStart
         * @param bool                                    $AutoStop
         * @param bool                                    $CreatePresentation
         * @param bool                                    $DeleteInactive
         * @param bool                                    $IsForumsEnabled
         * @param bool                                    $IsLive
         * @param bool                                    $IsOnDemand
         * @param bool                                    $IsPollsEnabled
         * @param bool                                    $IsUploadAutomatic
         * @param bool                                    $LoadPresentation
         * @param int                                     $NextNumberInSchedule
         * @param bool                                    $NotifyPresenter
         * @param bool                                    $ReplaceAclWithPolicy
         * @param bool                                    $ReviewEditApproveEnabled
         * @param int                                     $TimeZoneId
         * @param ResourcePermissionEntry[]               $AccessControlList can be an empty array, but must be passed
         * @param string                                  $Description
         * @param string                                  $FolderId
         * @param string                                  $Name
         * @param string                                  $PlayerId
         * @param CreatePresenterDetails[]                $PresenterList     can be an empty array, but must be passed
         * @param string                                  $PublishingPoint
         * @param string                                  $RecipientsEmailAddresses
         * @param string                                  $RecorderId
         * @param ScheduleRecurrenceDetails[]             $RecurrenceList
         * @param string                                  $SendersEmail
         * @param string                                  $TimeZoneRegistryKey
         * @param ScheduleTitleType                       $TitleType
         */
        function __construct( $Id, $AdvanceCreationTimeIsSet, $AdvanceLoadTimeInSecondsIsSet, $AutoStartIsSet, $AutoStopIsSet,
                              $CreatePresentationIsSet, $DeleteInactiveIsSet, $DescriptionIsSet, $FolderIdIsSet,
                              $IsForumsEnabledIsSet, $IsLiveIsSet, $IsOnDemandIsSet, $IsPollsEnabledIsSet,
                              $IsUploadAutomaticIsSet, $LoadPresentationIsSet, $NameIsSet, $NextNumberInScheduleIsSet,
                              $NotifyPresenterIsSet, $PlayerIdIsSet, $PublishingPointIsSet, $RecipientsEmailAddressesIsSet,
                              $RecorderIdIsSet, $ReplaceAclWithPolicyIsSet, $ReviewEditApproveEnabledIsSet,
                              $SendersEmailIsSet, $TimeZoneIdIsSet, $TimeZoneRegistryKeyIsSet, $TitleTypeIsSet,
                              $AdvanceCreationTime, $AdvanceLoadTimeInSeconds, $AutoStart, $AutoStop,
                              $CreatePresentation, $DeleteInactive, $IsForumsEnabled, $IsLive, $IsOnDemand, $IsPollsEnabled,
                              $IsUploadAutomatic, $LoadPresentation, $NextNumberInSchedule, $NotifyPresenter,
                              $ReplaceAclWithPolicy, $ReviewEditApproveEnabled, $TimeZoneId, $AccessControlList = null,
                              $Description = null, $FolderId = null, $Name = null, $PlayerId = null, $PresenterList = null,
                              $PublishingPoint = null, $RecipientsEmailAddresses = null, $RecorderId = null,
                              $RecurrenceList = null, $SendersEmail = null, $TimeZoneRegistryKey = null, $TitleType = null ) {
            $this->Id                            = $Id;
            $this->AdvanceCreationTimeIsSet      = $AdvanceCreationTimeIsSet;
            $this->AdvanceLoadTimeInSecondsIsSet = $AdvanceLoadTimeInSecondsIsSet;
            $this->AutoStartIsSet                = $AutoStartIsSet;
            $this->AutoStopIsSet                 = $AutoStopIsSet;
            $this->CreatePresentationIsSet       = $CreatePresentationIsSet;
            $this->DeleteInactiveIsSet           = $DeleteInactiveIsSet;
            $this->DescriptionIsSet              = $DescriptionIsSet;
            $this->FolderIdIsSet                 = $FolderIdIsSet;
            $this->IsForumsEnabledIsSet          = $IsForumsEnabledIsSet;
            $this->IsLiveIsSet                   = $IsLiveIsSet;
            $this->IsOnDemandIsSet               = $IsOnDemandIsSet;
            $this->IsPollsEnabledIsSet           = $IsPollsEnabledIsSet;
            $this->IsUploadAutomaticIsSet        = $IsUploadAutomaticIsSet;
            $this->LoadPresentationIsSet         = $LoadPresentationIsSet;
            $this->NameIsSet                     = $NameIsSet;
            $this->NextNumberInScheduleIsSet     = $NextNumberInScheduleIsSet;
            $this->NotifyPresenterIsSet          = $NotifyPresenterIsSet;
            $this->PlayerIdIsSet                 = $PlayerIdIsSet;
            $this->PublishingPointIsSet          = $PublishingPointIsSet;
            $this->RecipientsEmailAddressesIsSet = $RecipientsEmailAddressesIsSet;
            $this->RecorderIdIsSet               = $RecorderIdIsSet;
            $this->ReplaceAclWithPolicyIsSet     = $ReplaceAclWithPolicyIsSet;
            $this->ReviewEditApproveEnabledIsSet = $ReviewEditApproveEnabledIsSet;
            $this->SendersEmailIsSet             = $SendersEmailIsSet;
            $this->TimeZoneIdIsSet               = $TimeZoneIdIsSet;
            $this->TimeZoneRegistryKeyIsSet      = $TimeZoneRegistryKeyIsSet;
            $this->TitleTypeIsSet                = $TitleTypeIsSet;
            $this->AdvanceCreationTime           = $AdvanceCreationTime;
            $this->AdvanceLoadTimeInSeconds      = $AdvanceLoadTimeInSeconds;
            $this->AutoStart                     = $AutoStart;
            $this->AutoStop                      = $AutoStop;
            $this->CreatePresentation            = $CreatePresentation;
            $this->DeleteInactive                = $DeleteInactive;
            $this->IsForumsEnabled               = $IsForumsEnabled;
            $this->IsLive                        = $IsLive;
            $this->IsOnDemand                    = $IsOnDemand;
            $this->IsPollsEnabled                = $IsPollsEnabled;
            $this->IsUploadAutomatic             = $IsUploadAutomatic;
            $this->LoadPresentation              = $LoadPresentation;
            $this->NextNumberInSchedule          = $NextNumberInSchedule;
            $this->NotifyPresenter               = $NotifyPresenter;
            $this->ReplaceAclWithPolicy          = $ReplaceAclWithPolicy;
            $this->ReviewEditApproveEnabled      = $ReviewEditApproveEnabled;
            $this->TimeZoneId                    = $TimeZoneId;
            $this->AccessControlList             = $AccessControlList;
            $this->Description                   = $Description;
            $this->FolderId                      = $FolderId;
            $this->Name                          = $Name;
            $this->PlayerId                      = $PlayerId;
            $this->PresenterList                 = $PresenterList;
            $this->PublishingPoint               = $PublishingPoint;
            $this->ReceipientsEmailAddresses     = $RecipientsEmailAddresses;
            $this->RecorderId                    = $RecorderId;
            $this->RecurrenceList                = $RecurrenceList;
            $this->SendersEmail                  = $SendersEmail;
            $this->TimeZoneRegistryKey           = $TimeZoneRegistryKey;
            $this->TitleType                     = $TitleType;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct UpdatePresentationDetailsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdatePresentationDetailsRequest extends RequestMessage
    {

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var PresentationUpdateDetails $Details
         */
        public $Details;

        /**
         * @param string                    $Ticket
         * @param string                    $PresentationId
         * @param PresentationUpdateDetails $Details
         * @param                           $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationId, $Details, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->PresentationId        = $PresentationId;
            $this->Update                = $Details;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct PresentationUpdateDetails
     * Many of the properties of this class are not required on the service endpoint, but the boolean flags that represent
     * whether or not they are set are. To keep the properties and their boolean flags together we're not defaulting
     * any of the properties.
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class PresentationUpdateDetails
    {

        /**
         * @var boolean $AirDateTimeUtcIsSet
         */
        public $AirDateTimeUtcIsSet;

        /**
         * @var boolean $ChangeTypesIsSet
         */
        public $ChangeTypesIsSet;

        /**
         * @var boolean $ContentRevisionIsSet
         */
        public $ContentRevisionIsSet;

        /**
         * @var boolean $DescriptionIsSet
         */
        public $DescriptionIsSet;

        /**
         * @var boolean $DurationIsSet
         */
        public $DurationIsSet;

        /**
         * @var boolean $IsLiveIsSet
         */
        public $IsLiveIsSet;

        /**
         * @var boolean $IsOnDemandIsSet
         */
        public $IsOnDemandIsSet;

        /**
         * @var boolean $MediaLengthIsSet
         */
        public $MediaLengthIsSet;

        /**
         * @var boolean $ParentFolderIdIsSet
         */
        public $ParentFolderIdIsSet;

        /**
         * @var boolean $PlayerIdIsSet
         */
        public $PlayerIdIsSet;

        /**
         * @var boolean $PresenterDetailsIsSet
         */
        public $PresenterDetailsIsSet;

        /**
         * @var boolean $StatusIsSet
         */
        public $StatusIsSet;

        /**
         * @var boolean $TimeZoneIdIsSet
         */
        public $TimeZoneIdIsSet;

        /**
         * @var boolean $TimeZoneRegistryKeyIsSet
         */
        public $TimeZoneRegistryKeyIsSet;

        /**
         * @var boolean $TitleIsSet
         */
        public $TitleIsSet;

        /**
         * @var string $AirDateTimeUtc date-time formatted string
         */
        public $AirDateTimeUtc;

        /**
         * @var EntityChangeTypesDetails $ChangeTypes
         */
        public $ChangeTypes;

        /**
         * @var int $ContentRevision
         */
        public $ContentRevision;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var int $Duration
         */
        public $Duration;

        /**
         * @var boolean $IsLive
         */
        public $IsLive;

        /**
         * @var boolean $IsOnDemand
         */
        public $IsOnDemand;

        /**
         * @var int $MediaLength
         */
        public $MediaLength;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var string $PlayerId
         */
        public $PlayerId;

        /**
         * @var CreatePresenterDetails[] $PresenterDetails
         */
        public $PresenterDetails;

        /**
         * @var PresentationDataStatusDetails $Status
         */
        public $Status;

        /**
         * @var string $TimeZoneId
         */
        public $TimeZoneId;

        /**
         * @var string $TimeZoneRegistryKey
         */
        public $TimeZoneRegistryKey;

        /**
         * @var string $Title
         */
        public $Title;

        /**
         * @param bool                                                               $AirDateTimeUtcIsSet
         * @param bool                                                               $ChangeTypesIsSet
         * @param bool                                                               $ContentRevisionIsSet
         * @param bool                                                               $DescriptionIsSet
         * @param bool                                                               $DurationIsSet
         * @param bool                                                               $IsLiveIsSet
         * @param bool                                                               $IsOnDemandIsSet
         * @param bool                                                               $MediaLengthIsSet
         * @param bool                                                               $ParentFolderIdIsSet
         * @param bool                                                               $PlayerIdIsSet
         * @param bool                                                               $PresenterDetailsIsSet
         * @param bool                                                               $StatusIsSet
         * @param bool                                                               $TimeZoneIdIsSet
         * @param bool                                                               $TimeZoneRegistryKeyIsSet
         * @param bool                                                               $TitleIsSet
         * @param string                                                             $AirDateTimeUtc            date-time formatted string
         * @param EntityChangeTypesDetails                                           $ChangeTypes               may be null
         * @param int                                                                $ContentRevision           may be null
         * @param string                                                             $Description               may be null
         * @param int                                                                $Duration
         * @param bool                                                               $IsLive
         * @param bool                                                               $IsOnDemand
         * @param int                                                                $MediaLength
         * @param string                                                             $ParentFolderId            may be null
         * @param string                                                             $PlayerId                  may be null
         * @param CreatePresenterDetails[]                                           $PresenterDetails          null
         * @param PresentationDataStatusDetails                                      $Status
         * @param int                                                                $TimeZoneId                may be null
         * @param int                                                                $TimeZoneRegistryKey       may be null
         * @param string                                                             $Title                     may be null
         */
        function __construct( $AirDateTimeUtcIsSet, $ChangeTypesIsSet, $ContentRevisionIsSet, $DescriptionIsSet, $DurationIsSet,
                              $IsLiveIsSet, $IsOnDemandIsSet, $MediaLengthIsSet, $ParentFolderIdIsSet, $PlayerIdIsSet,
                              $PresenterDetailsIsSet, $StatusIsSet, $TimeZoneIdIsSet, $TimeZoneRegistryKeyIsSet, $TitleIsSet,
                              $AirDateTimeUtc = null, $ChangeTypes = null, $ContentRevision = null, $Description = null,
                              $Duration = null, $IsLive = null, $IsOnDemand = null, $MediaLength = null, $ParentFolderId = null,
                              $PlayerId = null, $PresenterDetails = null, $Status = null, $TimeZoneId = null,
                              $TimeZoneRegistryKey = null, $Title = null ) {
            $this->AirDateTimeUtcIsSet      = $AirDateTimeUtcIsSet;
            $this->ChangeTypesIsSet         = $ChangeTypesIsSet;
            $this->ContentRevisionIsSet     = $ContentRevisionIsSet;
            $this->DescriptionIsSet         = $DescriptionIsSet;
            $this->DurationIsSet            = $DurationIsSet;
            $this->IsLiveIsSet              = $IsLiveIsSet;
            $this->IsOnDemandIsSet          = $IsOnDemandIsSet;
            $this->MediaLengthIsSet         = $MediaLengthIsSet;
            $this->ParentFolderIdIsSet      = $ParentFolderIdIsSet;
            $this->PlayerIdIsSet            = $PlayerIdIsSet;
            $this->PresenterDetailsIsSet    = $PresenterDetailsIsSet;
            $this->StatusIsSet              = $StatusIsSet;
            $this->TimeZoneIdIsSet          = $TimeZoneIdIsSet;
            $this->TimeZoneRegistryKeyIsSet = $TimeZoneRegistryKeyIsSet;
            $this->TitleIsSet               = $TitleIsSet;
            $this->AirDateTimeUtc           = $AirDateTimeUtc;
            $this->ChangeTypes              = $ChangeTypes;
            $this->ContentRevision          = $ContentRevision;
            $this->Description              = $Description;
            $this->Duration                 = $Duration;
            $this->IsLive                   = $IsLive;
            $this->IsOnDemand               = $IsOnDemand;
            $this->MediaLength              = $MediaLength;
            $this->ParentFolderId           = $ParentFolderId;
            $this->PlayerId                 = $PlayerId;
            $this->PresenterDetails         = $PresenterDetails;
            $this->Status                   = $Status;
            $this->TimeZoneId               = $TimeZoneId;
            $this->TimeZoneRegistryKey      = $TimeZoneRegistryKey;
            $this->Title                    = $Title;
        }

    }

    /**
     * Proxy class for struct CreatePresenterDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePresenterDetails
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
         * @var string $EmailAddress
         */
        public $EmailAddress;

        /**
         * @var string $FirstName
         */
        public $FirstName;

        /**
         * @var base64Binary $Image
         */
        public $Image;

        /**
         * @var string $ImageName
         */
        public $ImageName;

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

        /**
         * @param string       $AdditionalInfo
         * @param string       $BioUrl
         * @param string       $EmailAddress
         * @param string       $FirstName
         * @param base64Binary $Image
         * @param string       $ImageName
         * @param string       $LastName
         * @param string       $MiddleName
         * @param string       $Prefix
         * @param string       $Suffix
         */
        function __construct( $AdditionalInfo, $BioUrl, $EmailAddress, $FirstName, $Image, $ImageName, $LastName,
                              $MiddleName, $Prefix, $Suffix ) {
            $this->AdditionalInfo = $AdditionalInfo;
            $this->BioUrl         = $BioUrl;
            $this->EmailAddress   = $EmailAddress;
            $this->FirstName      = $FirstName;
            $this->Image          = $Image;
            $this->ImageName      = $ImageName;
            $this->LastName       = $LastName;
            $this->MiddleName     = $MiddleName;
            $this->Prefix         = $Prefix;
            $this->Suffix         = $Suffix;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryRolesByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryRolesByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $RoleIdList
         */
        public $RoleIdList;

        /**
         * @param string   $Ticket
         * @param string[] $RoleIdList
         * @param null     $ImpersonationUsername
         */
        function __construct( $Ticket, $RoleIdList, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->RoleIdList            = $RoleIdList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryRolesByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryRolesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var RoleQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string            $Ticket
         * @param RoleQueryCriteria $Criteria
         * @param null              $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct RoleQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class RoleQueryCriteria
    {

        /**
         * @var string $DirectoryEntry
         */
        public $DirectoryEntry;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * Build a RoleQueryCriteria
         * Neither parameter is required, but if both are provided and do not represent the same Role, no results will be
         * returned
         *
         * @param string $DirectoryEntry
         * @param string $Name
         */
        function __construct( $DirectoryEntry = null, $Name = null ) {
            $this->DirectoryEntry = $DirectoryEntry;
            $this->Name           = $Name;
        }

    }

    /*  Final 6.0.2 methods */

    /**
     * @internal
     *
     * Proxy class for struct DeleteRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class DeleteRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @param string $Ticket
         * @param string $Id
         * @param string $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryCatalogsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class QueryCatalogsByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $CatalogIdList
         */
        public $CatalogIdList;

        /**
         * @var ResourcePermissionMask[] $PermissionMask
         */
        public $PermissionMask;

        /**
         * @param string                    $Ticket
         * @param string[]                  $CatalogIdList
         * @param ResourcePermissionMask[]  $PermissionMask
         * @param string                    $ImpersonationUsername
         */
        function __construct( $Ticket, $CatalogIdList, $PermissionMask = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CatalogIdList         = $CatalogIdList;
            $this->PermissionMask        = $PermissionMask;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreateCatalogFromFolderRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateCatalogFromFolderRequest
    {

        /**
         * @var CreateCatalogFromFolderDetails $CreateDetails
         */
        public $CreateDetails;

        /**
         * @param string                         $Ticket
         * @param CreateCatalogFromFolderDetails $CreateDetails
         * @param string                         $ImpersonationUsername
         */
        function __construct( $Ticket, CreateCatalogFromFolderDetails $CreateDetails, $ImpersonationUsername = null ) {
            $this->CreateDetails         = $CreateDetails;
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreateCatalogFromFolderDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreateCatalogFromFolderDetails
    {

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $FolderId
         */
        public $FolderId;

        /**
         * @var boolean $IncludeSubFolders
         */
        public $IncludeSubFolders;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @param      $FolderId
         * @param      $IncludeSubFolders
         * @param      $Name
         * @param null $Description
         */
        function __construct( $FolderId, $IncludeSubFolders, $Name, $Description = null ) {
            $this->Description       = $Description;
            $this->FolderId          = $FolderId;
            $this->IncludeSubFolders = $IncludeSubFolders;
            $this->Name              = $Name;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePlayerLikeRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePlayerLikeRequest extends RequestMessage
    {

        /**
         * @var CreatePlayerLikeDetails $CreateDetails
         */
        public $CreateDetails;

        /**
         * @param string                  $Ticket
         * @param CreatePlayerLikeDetails $CreateDetails
         * @param string                  $ImpersonationUsername
         */
        function __construct( $Ticket, CreatePlayerLikeDetails $CreateDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->CreateDetails         = $CreateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct CreatePlayerLikeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class CreatePlayerLikeDetails
    {

        /**
         * @var string $CreateLikePlayerId
         */
        public $CreateLikePlayerId;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @param string $CreateLikePlayerId
         * @param string $Name
         * @param string $Description
         * @param string $ParentFolderId
         */
        function __construct( $CreateLikePlayerId, $Name, $ParentFolderId, $Description = null ) {
            $this->CreateLikePlayerId = $CreateLikePlayerId;
            $this->Description        = $Description;
            $this->Name               = $Name;
            $this->ParentFolderId     = $ParentFolderId;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct UpdateResourcePermissionsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateResourcePermissionsRequest extends RequestMessage
    {

        /**
         * @var UpdateResourcePermissionsDetails $PermissionDetails
         */
        public $PermissionDetails;

        /**
         * @param string                           $Ticket
         * @param UpdateResourcePermissionsDetails $PermissionDetails
         * @param null                             $ImpersonationUsername
         */
        function __construct( $Ticket, UpdateResourcePermissionsDetails $PermissionDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PermissionDetails     = $PermissionDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct UpdateResourcePermissionsDetails
     * Details of Resource Permission changes to be made.
     * Since changing permissions on folders is not supported in Edas as of v6.0.2, PropagatePermissions and PropagateOwner
     *  are meaningless, so they are defaulted to false
     * Also, if InheritPermissions is true, MergePermissions must be false or EDAS will throw an error
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.0
     */
    class UpdateResourcePermissionsDetails
    {

        /**
         * @var ResourcePermissionEntry[] $Acl
         */
        public $Acl;

        /**
         * @var ResourceIdentifier[] $Ids
         */
        public $Ids;

        /**
         * @var boolean $InheritPermissions
         */
        public $InheritPermissions;

        /**
         * @var boolean $MergePermissions
         */
        public $MergePermissions;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var boolean $PropagateOwner
         */
        public $PropagateOwner;

        /**
         * @var boolean $PropagatePermissions
         */
        public $PropagatePermissions;

        /**
         * @param ResourcePermissionEntry[]  $Acl
         * @param string[]                   $Ids
         * @param bool                       $InheritPermissions
         * @param bool                       $MergePermissions
         * @param string                     $Owner
         * @param bool                       $PropagateOwner
         * @param bool                       $PropagatePermissions
         */
        function __construct( $Acl, $Ids, $InheritPermissions, $MergePermissions, $Owner, $PropagateOwner = false,
                              $PropagatePermissions = false ) {
            $this->Acl                  = $Acl;
            $this->Ids                  = $Ids;
            $this->InheritPermissions   = $InheritPermissions;
            $this->MergePermissions     = $MergePermissions;
            $this->Owner                = $Owner;
            $this->PropagateOwner       = $PropagateOwner;
            $this->PropagatePermissions = $PropagatePermissions;
        }

    }

    /*  New for 6.1.1   */
    /**
     * @internal
     *
     * Proxy class for struct CreateUserProfilesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CreateUserProfilesRequest extends RequestMessage
    {

        /**
         * @var UserProfileCreateDetails|UserProfileCreateDetails[] $ProfileCreateDetails
         */
        public $ProfileCreateDetails;

        /**
         * @param string                                              $Ticket
         * @param UserProfileCreateDetails[]                          $ProfileCreateDetails
         * @param string                                              $ImpersonationUsername
         */
        function __construct( $Ticket, $ProfileCreateDetails, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->ProfileCreateDetails  = $ProfileCreateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct UpdateResourcePermissionsDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UserProfileCreateDetails
    {

        /**
         * @var string $DisplayName
         */
        public $DisplayName;

        /**
         * @var string $Email
         */
        public $Email;

        /**
         * @var string $UserName
         */
        public $UserName;

        /**
         * @param string $DisplayName
         * @param string $Email
         * @param string $UserName
         */
        function __construct( $DisplayName = null, $Email = null, $UserName = null ) {
            $this->DisplayName = $DisplayName;
            $this->Email       = $Email;
            $this->UserName    = $UserName;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreateUserProfilesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CreateUserProfilesFromEmailsRequest extends RequestMessage
    {

        /**
         * @var string[] $EmailAddresses
         */
        public $EmailAddresses;

        /**
         * @param string              $Ticket
         * @param string[]            $EmailAddresses
         * @param string              $ImpersonationUsername
         */
        function __construct( $Ticket, $EmailAddresses, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->EmailAddresses        = $EmailAddresses;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryUserProfilesByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryUserProfilesByIdRequest extends RequestMessage
    {

        /**
         * @var string[] $UserProfileIdList
         */
        public $UserProfileIdList;

        /**
         * @param string        $Ticket
         * @param string[]      $UserProfileIdList
         * @param string        $ImpersonationUsername
         */
        function __construct( $Ticket, $UserProfileIdList, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->UserProfileIdList     = $UserProfileIdList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryUserProfilesByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryUserProfilesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var UserProfileQueryCriteria $Criteria
         */
        public $Criteria;

        /**
         * @param string                   $Ticket
         * @param UserProfileQueryCriteria $UserProfileQueryCriteria
         * @param null                     $ImpersonationUsername
         */
        function __construct( $Ticket, $UserProfileQueryCriteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $UserProfileQueryCriteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Generated data proxy class for struct UserProfileQueryCriteria
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UserProfileQueryCriteria
    {

        /**
         * @var string[] $EmailAddresses
         */
        public $EmailAddresses;

        /**
         * @var string $EmailContains
         */
        public $EmailContains;

        /**
         * @var string $UserNameContains
         */
        public $UserNameContains;

        /**
         * @var string[] $UserNames
         */
        public $UserNames;

        /**
         * @param string[]  $EmailAddresses
         * @param string    $EmailContains
         * @param string    $UserNameContains
         * @param string[]  $UserNames
         */
        function __construct( $EmailAddresses = null, $EmailContains = null, $UserNameContains = null, $UserNames = null ) {
            $this->EmailAddresses   = $EmailAddresses;
            $this->EmailContains    = $EmailContains;
            $this->UserNameContains = $UserNameContains;
            $this->UserNames        = $UserNames;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct UpdateUserProfilesRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UpdateUserProfilesRequest extends RequestMessage
    {

        /**
         * @var UserProfileUpdateDetails|UserProfileUpdateDetails[] $ProfileUpdateDetails
         */
        public $ProfileUpdateDetails;

        /**
         * @param string                                                  $Ticket
         * @param UserProfileUpdateDetails|UserProfileUpdateDetails[]     $ProfileUpdateDetails
         * @param string                                                  $ImpersonationUsername
         */
        function __construct( $Ticket, $ProfileUpdateDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ProfileUpdateDetails  = $ProfileUpdateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Generated data proxy class for struct UserProfileUpdateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UserProfileUpdateDetails
    {

        /**
         * @var string $DisplayName
         */
        public $DisplayName;

        /**
         * @var boolean $DisplayNameIsSet
         */
        public $DisplayNameIsSet;

        /**
         * @var string $Email
         */
        public $Email;

        /**
         * @var boolean $EmailIsSet
         */
        public $EmailIsSet;

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var boolean $ReSendInvitationRequest
         */
        public $ReSendInvitationRequest;

        /**
         * @var string $UserName
         */
        public $UserName;

        /**
         * @var boolean $UserNameIsSet
         */
        public $UserNameIsSet;

        /**
         * @param string     $Id
         * @param string     $DisplayName
         * @param bool       $DisplayNameIsSet
         * @param string     $Email
         * @param bool       $EmailIsSet
         * @param bool       $ReSendInvitationRequest
         * @param string     $UserName
         * @param bool       $UserNameIsSet
         */
        function __construct( $Id, $DisplayName = null, $DisplayNameIsSet = false, $Email = null, $EmailIsSet = false,
                              $ReSendInvitationRequest = false, $UserName = null, $UserNameIsSet = false ) {
            $this->Id                      = $Id;
            $this->DisplayName             = $DisplayName;
            $this->DisplayNameIsSet        = $DisplayNameIsSet;
            $this->Email                   = $Email;
            $this->EmailIsSet              = $EmailIsSet;
            $this->ReSendInvitationRequest = $ReSendInvitationRequest;
            $this->UserName                = $UserName;
            $this->UserNameIsSet           = $UserNameIsSet;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct CheckJobStatusRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CheckJobStatusRequest extends RequestMessage
    {

        /**
         * @var string $JobId
         */
        public $JobId;

        /**
         * @param string        $Ticket
         * @param string        $JobId
         * @param string        $ImpersonationUsername
         */
        function __construct( $Ticket, $JobId, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->JobId                 = $JobId;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct AddTagToMediasiteObjectRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class AddTagToMediasiteObjectRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;
        /**
         * @var string $TagName
         */
        public $TagName;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $TagName
         * @param null              $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $TagName, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->TagName               = $TagName;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }
    }

    /**
     * @internal
     *
     * Generated data proxy class for struct AddTagToMediasiteObjectRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryTagsByMediasiteIdRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @param string      $Ticket
         * @param string      $Id
         * @param null        $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct RemoveTagFromMediasiteObjectRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class RemoveTagFromMediasiteObjectRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $TagName
         */
        public $TagName;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $TagName
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $TagName, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->TagName               = $TagName;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct CreateTemplateLikeRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CreateTemplateLikeRequest extends RequestMessage
    {

        /**
         * @var CreateTemplateLikeDetails $Details;
         */
        public $Template;

        /**
         * @param string      $Ticket
         * @param null|string $Template
         * @param null        $ImpersonationUsername
         */
        function __construct( $Ticket, $Template, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Template              = $Template;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * Generated data proxy class for struct CreateTemplateLikeDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CreateTemplateLikeDetails
    {

        /**
         * @var string required
         */
        public $OriginalTemplateId;
        /**
         * @var string
         */
        public $Name;
        /**
         * @var string PlayerId of player to be used. Required, query source template for value if needed
         */
        public $PlayerId;
        /**
         * @var string Id of parent folder to create template in. Required, query source template for value if needed
         */
        public $FolderId;
        /**
         * @var string optional, overrides Original Template's value if provided
         */
        public $Description;
        /**
         * @var string optional, overrides Original Template's value if provided
         */
        public $ExternalPoll;
        /**
         * @var bool optional, overrides Original Template's value if provided
         */
        public $IsForumsEnabled;
        /**
         * @var bool optional, overrides Original Template's value if provided
         */
        public $IsPollsEnabled;
        /**
         * @var CreatePresenterDetails[] optional, overrides Original Template's value if provided
         */
        public $PresenterList;
        /**
         * @var PublishingOptions optional, overrides Original Template's value if provided
         */
        public $PublishingOptions;
        /**
         * @var bool optional, overrides Original Template's value if provided
         */
        public $ReplaceAceWithPolicy;
        /**
         * @var bool optional, overrides Original Template's value if provided
         */
        public $ReviewEditApproveEnabled;

        /**
         * @param string                       $OriginalTemplateId
         * @param string                       $Name
         * @param string                       $PlayerId
         * @param string                       $FolderId
         * @param string                       $Description
         * @param string                       $ExternalPoll
         * @param bool                         $IsForumsEnabled
         * @param bool                         $IsPollsEnabled
         * @param CreatePresenterDetails[]     $PresenterList
         * @param PublishingOptions            $PublishingOptions
         * @param bool                         $ReplaceAceWithPolicy
         * @param bool                         $ReviewEditApproveEnabled
         */
        function __construct( $OriginalTemplateId, $Name, $PlayerId, $FolderId, $Description = null,
                              $ExternalPoll = null, $IsForumsEnabled = null, $IsPollsEnabled = null,
                              $PresenterList = null, $PublishingOptions = null, $ReplaceAceWithPolicy = null,
                              $ReviewEditApproveEnabled = null ) {
            $this->Description              = $Description;
            $this->ExternalPoll             = $ExternalPoll;
            $this->FolderId                 = $FolderId;
            $this->IsForumsEnabled          = $IsForumsEnabled;
            $this->IsPollsEnabled           = $IsPollsEnabled;
            $this->Name                     = $Name;
            $this->OriginalTemplateId       = $OriginalTemplateId;
            $this->PlayerId                 = $PlayerId;
            $this->PresenterList            = $PresenterList;
            $this->PublishingOptions        = $PublishingOptions;
            $this->ReplaceAceWithPolicy     = $ReplaceAceWithPolicy;
            $this->ReviewEditApproveEnabled = $ReviewEditApproveEnabled;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct CreateMediasiteKeyValueRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class CreateMediasiteKeyValueRequest extends RequestMessage
    {

        /**
         * @var MediasiteKeyValue
         */
        public $KeyValue;

        /**
         * @param string            $Ticket
         * @param MediasiteKeyValue $KeyValue
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $KeyValue, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->KeyValue              = $KeyValue;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryMediasiteKeyValueByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByIdRequest extends RequestMessage
    {

        /**
         * @var string
         */
        public $Id;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct DeleteMediasiteKeyValueByIdAndKeyRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */

    class DeleteMediasiteKeyValueByIdAndKeyRequest extends RequestMessage
    {

        /**
         * @var string id of the mediasite object from which to remove the KeyValue pair
         */
        public $Id;
        /**
         * @var string
         */
        public $Key;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $Key
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $Key, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->ImpersonationUsername = $ImpersonationUsername;
            $this->Key                   = $Key;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryMediasiteKeyValueByKeyValueRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByKeyValueRequest extends RequestMessage
    {

        /**
         * @var string
         */
        public $KeyValue;

        /**
         * @param string            $Ticket
         * @param string            $KeyValue
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $KeyValue, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->KeyValue              = $KeyValue;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct DeleteMediasiteKeyValueByKeyValueRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */

    class DeleteMediasiteKeyValueByKeyValueRequest extends RequestMessage
    {

        /**
         * @var string
         */
        public $KeyValue;

        /**
         * @param string                       $Ticket
         * @param MediasiteKeyValue            $KeyValue
         * @param string                       $ImpersonationUsername
         */
        function __construct( $Ticket, $KeyValue, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->KeyValue              = $KeyValue;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryMediasiteKeyValueByKeyAndIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class QueryMediasiteKeyValueByIdAndKeyRequest extends RequestMessage
    {

        /**
         * @var string
         */
        public $Id;

        /**
         * @var string
         */
        public $Key;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $Key
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $Key, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->Key                   = $Key;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct QueryMediasiteKeyValueByIdsAndKeyAndIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UpdateMediasiteKeyValueByIdsAndKeyRequest extends RequestMessage
    {
        /**
         * @var string[] array of Ids to update the keyvaluepair to a new value
         */
        public $Ids;
        /**
         * @var string key of the KVP to update
         */
        public $Key;
        /**
         * @var string new value to update to
         */
        public $NewValue;

        /**
         * @param string       $Ticket
         * @param string[]     $Ids
         * @param string       $Key
         * @param string       $NewValue
         * @param string       $ImpersonationUsername
         */
        function __construct( $Ticket, $Ids, $Key, $NewValue, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Ids                   = $Ids;
            $this->Key                   = $Key;
            $this->NewValue              = $NewValue;
            $this->ImpersonationUsername = $ImpersonationUsername;

        }

    }

    /**
     * Generated data proxy class for struct MediasiteKeyValue
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class MediasiteKeyValue
    {

        /**
         * @var string Mediasite Id to which this key/vale pair will be associated
         */
        public $Id;
        /**
         * @var string key for the key/value pair
         */
        public $Key;
        /**
         * @var string value for KVP
         */
        public $Value;

        /**
         * @param string $Id must be GUID-formatted
         * @param string $Key
         * @param string $Value
         */
        function __construct( $Id, $Key, $Value ) {
            $this->Id    = $Id;
            $this->Key   = $Key;
            $this->Value = $Value;
        }

    }

    /**
     * @internal
     *
     * Generated data proxy class for struct UpdatePlayerRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UpdatePlayerRequest extends RequestMessage
    {
        /**
         * @var UpdatePlayerDetails $UpdateDetails
         */
        public $UpdateDetails;

        /**
         * @param string                  $Ticket
         * @param UpdatePlayerDetails     $UpdateDetails
         * @param string                  $ImpersonationUsername
         */
        function __construct( $Ticket, $UpdateDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->UpdateDetails         = $UpdateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;

        }

    }

    /**
     * Generated data proxy class for struct UpdatePlayerDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.1
     */
    class UpdatePlayerDetails
    {

        /**
         * @var string $Id
         */
        public $Id;

        /**
         * @var string $Description
         */
        public $Description;

        /**
         * @var boolean $DescriptionIsSet
         */
        public $DescriptionIsSet;

        /**
         * @var string $LayoutId
         */
        public $LayoutId;

        /**
         * @var boolean $LayoutIdIsSet
         */
        public $LayoutIdIsSet;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var boolean $NameIsSet
         */
        public $NameIsSet;

        /**
         * @var string $Owner
         */
        public $Owner;

        /**
         * @var boolean $OwnerIsSet
         */
        public $OwnerIsSet;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var boolean $ParentFolderIdIsSet
         */
        public $ParentFolderIdIsSet;

        /**
         * @var string $SerializedLayoutOptions
         */
        public $SerializedLayoutOptions;

        /**
         * @var boolean $SerializedLayoutOptionsIsSet
         */
        public $SerializedLayoutOptionsIsSet;

        /**
         * Build details for a player update
         *
         * @param string $Id                                     required to look up the role to update
         * @param string $Description
         * @param bool   $DescriptionIsSet                       if set to false or not set, $Description will be ignored
         * @param string $LayoutId
         * @param bool   $LayoutIdIsSet                          if set to false or not set, $LayoutId will be ignored
         * @param string $Name
         * @param bool   $NameIsSet                              if set to false or not set, $Name will be ignored
         * @param string $Owner
         * @param bool   $OwnerIsSet                             if set to false or not set, $Owner will be ignored
         * @param string $ParentFolderId
         * @param bool   $ParentFolderIdIsSet                    if set to false or not set, $ParentFolderId will be ignored
         * @param string $SerializedLayoutOptions
         * @param bool   $SerializedLayoutOptionsIsSet           if set to false or not set, $SerializedLayoutOptions will be ignored
         */
        function __construct( $Id, $Description = null, $DescriptionIsSet = false, $LayoutId = null,
                              $LayoutIdIsSet = false, $Name = null, $NameIsSet = false, $Owner = null,
                              $OwnerIsSet = false, $ParentFolderId = null, $ParentFolderIdIsSet = false,
                              $SerializedLayoutOptions = null, $SerializedLayoutOptionsIsSet = false ) {
            $this->Id                           = $Id;
            $this->Description                  = $Description;
            $this->DescriptionIsSet             = $DescriptionIsSet;
            $this->LayoutId                     = $LayoutId;
            $this->LayoutIdIsSet                = $LayoutIdIsSet;
            $this->Name                         = $Name;
            $this->NameIsSet                    = $NameIsSet;
            $this->Owner                        = $Owner;
            $this->OwnerIsSet                   = $OwnerIsSet;
            $this->ParentFolderId               = $ParentFolderId;
            $this->ParentFolderIdIsSet          = $ParentFolderIdIsSet;
            $this->SerializedLayoutOptions      = $SerializedLayoutOptions;
            $this->SerializedLayoutOptionsIsSet = $SerializedLayoutOptionsIsSet;
        }

    }

    /*  New for 6.1.5   */

    /**
     * @internal
     *
     * Data proxy class for struct UpdatePresentationContentDetailsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class UpdatePresentationContentDetailsRequest extends RequestMessage
    {

        /**
         * @var string $PresentationContentId Id of the content item to be updated
         */
        public $PresentationContentId;

        /**
         * @var string $PresentationId id fo the presentation to which the content belongs
         */
        public $PresentationId;

        /**
         * @var PresentationContentUpdateDetails $UpdateDetails object describing the updates to make
         */
        public $UpdateDetails;

        /**
         * @param string                                      $Ticket
         * @param string                                      $PresentationContentId
         * @param string                                      $PresentationId
         * @param PresentationContentUpdateDetails            $UpdateDetails
         * @param string                                      $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationContentId, $PresentationId, $UpdateDetails, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->PresentationContentId = $PresentationContentId;
            $this->PresentationId        = $PresentationId;
            $this->UpdateDetails         = $UpdateDetails;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }
    }

    /**
     * @internal
     *
     * Data proxy class for struct PresentationContentUpdateDetails
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class PresentationContentUpdateDetails extends RequestMessage
    {
        /**
         * @var string $ContentEncodingSettingsId
         */
        public $ContentEncodingSettingsId;
        /**
         * @var bool $ContentEncodingSettingsIdIsSet
         */
        public $ContentEncodingSettingsIdIsSet;
        /**
         * @var int $ContentRevision
         */
        public $ContentRevision;
        /**
         * @var bool $ContentRevisionIsSet
         */
        public $ContentRevisionIsSet;
        /**
         * @var string $EncodingName
         */
        public $EncodingName;
        /**
         * @var bool $EncodingNameIsSet
         */
        public $EncodingNameIsSet;
        /**
         * @var int $EncodingOrder
         */
        public $EncodingOrder;
        /**
         * @var bool $EncodingOrderIsSet
         */
        public $EncodingOrderIsSet;
        /**
         * @var int $FileLength
         */
        public $FileLength;
        /**
         * @var bool $FileLengthIsSet
         */
        public $FileLengthIsSet;
        /**
         * @var string $FileName
         */
        public $FileName;
        /**
         * @var bool $FileNameIsSet
         */
        public $FileNameIsSet;
        /**
         * @var bool $IsTranscodeSource
         */
        public $IsTranscodeSource;
        /**
         * @var bool $IsTranscodeSourceIsSet
         */
        public $IsTranscodeSourceIsSet;
        /**
         * @var int $Length
         */
        public $Length;
        /**
         * @var bool $LengthIsSet
         */
        public $LengthIsSet;
        /**
         * @var int $PlaybackOrder
         */
        public $PlaybackOrder;
        /**
         * @var bool $PlaybackOrderIsSet
         */
        public $PlaybackOrderIsSet;
        /**
         * @var PresentationContentStatusDetails $Status
         */
        public $Status;
        /**
         * @var bool $StatusIsSet
         */
        public $StatusIsSet;
        /**
         * @var string $StatusText
         */
        public $StatusText;
        /**
         * @var bool $StatusTextIsSet
         */
        public $StatusTextIsSet;

        /**
         * @param string      $ContentEncodingSettingsId
         * @param bool        $ContentEncodingSettingsIdIsSet
         * @param string      $ContentRevision
         * @param bool        $ContentRevisionIsSet
         * @param string      $EncodingName
         * @param bool        $EncodingNameIsSet
         * @param string      $EncodingOrder
         * @param bool        $EncodingOrderIsSet
         * @param string      $FileName
         * @param bool        $FileNameIsSet
         * @param string      $FileLength
         * @param bool        $FileLengthIsSet
         * @param string      $IsTranscodeSource
         * @param bool        $IsTranscodeSourceIsSet
         * @param string      $Length
         * @param bool        $LengthIsSet
         * @param string      $PlaybackOrder
         * @param bool        $PlaybackOrderIsSet
         * @param string      $Status
         * @param bool        $StatusIsSet
         * @param string      $StatusText
         * @param bool        $StatusTextIsSet
         */
        function __construct( $ContentEncodingSettingsId = null, $ContentEncodingSettingsIdIsSet = false,
                              $ContentRevision = null, $ContentRevisionIsSet = false, $EncodingName = null,
                              $EncodingNameIsSet = false, $EncodingOrder = null, $EncodingOrderIsSet = false,
                              $FileName = null, $FileNameIsSet = false, $FileLength = null, $FileLengthIsSet = false,
                              $IsTranscodeSource = null, $IsTranscodeSourceIsSet = false, $Length = null,
                              $LengthIsSet = false, $PlaybackOrder = null, $PlaybackOrderIsSet = false, $Status = null,
                              $StatusIsSet = false, $StatusText = null, $StatusTextIsSet = false ) {
            $this->ContentEncodingSettingsId      = $ContentEncodingSettingsId;
            $this->ContentEncodingSettingsIdIsSet = $ContentEncodingSettingsIdIsSet;
            $this->ContentRevision                = $ContentRevision;
            $this->ContentRevisionIsSet           = $ContentRevisionIsSet;
            $this->EncodingName                   = $EncodingName;
            $this->EncodingNameIsSet              = $EncodingNameIsSet;
            $this->EncodingOrder                  = $EncodingOrder;
            $this->EncodingOrderIsSet             = $EncodingOrderIsSet;
            $this->FileName                       = $FileName;
            $this->FileNameIsSet                  = $FileNameIsSet;
            $this->FileLength                     = $FileLength;
            $this->FileLengthIsSet                = $FileLengthIsSet;
            $this->IsTranscodeSource              = $IsTranscodeSource;
            $this->IsTranscodeSourceIsSet         = $IsTranscodeSourceIsSet;
            $this->Length                         = $Length;
            $this->LengthIsSet                    = $LengthIsSet;
            $this->PlaybackOrder                  = $PlaybackOrder;
            $this->PlaybackOrderIsSet             = $PlaybackOrderIsSet;
            $this->Status                         = $Status;
            $this->StatusIsSet                    = $StatusIsSet;
            $this->StatusText                     = $StatusText;
            $this->StatusTextIsSet                = $StatusTextIsSet;
        }

    }

    /**
     * @internal
     *
     * Data proxy class for struct DeletePresentationContentRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class DeletePresentationContentRequest extends RequestMessage
    {

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var string $PresentationContentId
         */
        public $PresentationContentId;

        /**
         * @param string      $Ticket
         * @param string      $PresentationContentId
         * @param string      $PresentationId
         * @param string      $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationContentId, $PresentationId, $ImpersonationUsername ) {
            $this->Ticket                = $Ticket;
            $this->PresentationContentId = $PresentationContentId;
            $this->PresentationId        = $PresentationId;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryPresentationUsageByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class QueryPresentationUsageByIdRequest extends QueryAnalyticsByIdRequest
    {

        /**
         * @var AnalyticsRequestType $ChildType
         */
        public $ChildType;

        /**
         * @param string                            $Ticket
         * @param string                            $Id
         * @param AnalyticsRequestType              $RequestType
         * @param AnalyticsRequestType              $ChildType
         * @param QueryOptions|null                 $Options
         * @param string                            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id, $RequestType, $ChildType, $Options = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->RequestType           = $RequestType;
            $this->ChildType             = $ChildType;
            $this->Options               = $Options;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryUserProfileDetailsByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class QueryUserProfileDetailsByCriteriaRequest extends RequestMessage
    {
        /**
         * @var null|string
         */
        public $Criteria;

        /**
         * @param string                   $Ticket
         * @param UserProfileQueryCriteria $Criteria
         * @param string                   $ImpersonationUsername
         */
        function __construct( $Ticket, $Criteria, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Criteria              = $Criteria;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryUserProfileDetailsByIdRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class QueryUserProfileDetailsByIdRequest extends RequestMessage
    {
        /**
         * @var string[]
         */
        public $UserProfileIdList;

        /**
         * @param string            $Ticket
         * @param string[]          $UserProfileIdList
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $UserProfileIdList, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->UserProfileIdList     = $UserProfileIdList;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct QueryMediasiteKeyValuesByCriteriaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class QueryMediasiteKeyValuesByCriteriaRequest extends RequestMessage
    {

        /**
         * @var string $Id
         */
        public $Id;
        /**
         * @var string Key
         */
        public $Key;
        /**
         * @var string $Value
         */
        public $Value;

        /**
         * @param string            $Ticket
         * @param string            $Id
         * @param string            $Key
         * @param string            $Value
         * @param string            $ImpersonationUsername
         */
        function __construct( $Ticket, $Id = null, $Key = null, $Value = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Id                    = $Id;
            $this->Key                   = $Key;
            $this->Value                 = $Value;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationExternalLinkRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class CreatePresentationExternalLinkRequest extends RequestMessage
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
         * @var string $PresentationId
         */
        public $PresentationId;
        /**
         * @var string $Url
         */
        public $Url;

        /**
         * @param string        $Ticket
         * @param string        $Name
         * @param int           $Order
         * @param string        $PresentationId
         * @param string        $Url
         * @param string        $ImpersonationUsername
         */
        function __construct( $Ticket, $Name, $Order, $PresentationId, $Url, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->Name                  = $Name;
            $this->Order                 = $Order;
            $this->PresentationId        = $PresentationId;
            $this->Url                   = $Url;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }
    }

    /**
     * @internal
     *
     * Proxy class for struct CreatePresentationForMediaUploadRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class CreatePresentationForMediaUploadRequest extends RequestMessage
    {
        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;
        /**
         * @var string $PresentationDescription
         */
        public $PresentationDescription;
        /**
         * @var string $PresentationTitle
         */
        public $PresentationTitle;

        /**
         * @param string     $Ticket
         * @param string     $PresentationTitle
         * @param string     $PresentationDescription
         * @param string     $ParentFolderId
         * @param string     $ImpersonationUsername
         */
        function __construct( $Ticket, $PresentationTitle, $PresentationDescription = null, $ParentFolderId = null, $ImpersonationUsername = null ) {
            $this->Ticket                  = $Ticket;
            $this->ParentFolderId          = $ParentFolderId;
            $this->PresentationDescription = $PresentationDescription;
            $this->PresentationTitle       = $PresentationTitle;
            $this->ImpersonationUsername   = $ImpersonationUsername;
        }

    }

    /**
     * Proxy class for struct UploadMediaRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.5
     */
    class UploadMediaRequest
    {

        /**
         * @var int $ContentId
         */
        public $ContentId;
        /**
         * @var string $FileName
         */
        public $FileName;
        /**
         * @var string $PresentationId
         */
        public $PresentationId;
        /**
         * @var MediaUploadTranscodeOptionDetails
         */
        public $TranscodeOption;

        /**
         * @param string                                $Ticket
         * @param string                                $FileName
         * @param string                                $PresentationId
         * @param MediaUploadTranscodeOptionDetails     $TranscodeOption
         * @param int                                   $ContentId
         * @param string                                $ImpersonationUsername
         */
        function __construct( $Ticket, $FileName, $PresentationId, $TranscodeOption, $ContentId = null, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ContentId             = $ContentId;
            $this->FileName              = $FileName;
            $this->PresentationId        = $PresentationId;
            $this->TranscodeOption       = $TranscodeOption;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }

    /**
     * @internal
     *
     * Proxy class for struct RefreshReportDetailsRequest
     *
     * @package SonicFoundry.Mediasite.Edas.PHPProxy
     * @since   6.1.7
     */
    class RefreshReportDataRequest extends RequestMessage
    {

        /**
         * @param string $Ticket
         * @param null   $ImpersonationUsername
         */
        function __construct( $Ticket, $ImpersonationUsername = null ) {
            $this->Ticket                = $Ticket;
            $this->ImpersonationUsername = $ImpersonationUsername;
        }

    }
/**
 * @internal
 *
 * Proxy class for struct CreateRegistrationRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateRegistrationRequest extends RequestMessage
{
        /**
         * @var RegistrationDetails $Details
         */
        public $Details;

        /**
         * @param RegistrationDetails $Details
         */
        function __construct( $Ticket, $Details, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->Details = $Details;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * Proxy class for struct RegistrationDetails
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class RegistrationDetails
{
        /**
         * @var ResourceRegistrationCustomFieldDefinition[] $CustomFields
         */
        public $CustomFields;

        /**
         * @var boolean $HideLoginForm
         */
        public $HideLoginForm;

        /**
         * @var string $LoginMessage
         */
        public $LoginMessage;

        /**
         * @var string $Passcode
         */
        public $Passcode;

        /**
         * @var string $RegistrationMessage
         */
        public $RegistrationMessage;

        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @param ResourceRegistrationCustomFieldDefinition[] $CustomFields
         * @param boolean $HideLoginForm
         * @param string $LoginMessage
         * @param string $Passcode
         * @param string $RegistrationMessage
         * @param string $ResourceId
         */
        function __construct( $CustomFields, $HideLoginForm, $LoginMessage, $Passcode, $RegistrationMessage, $ResourceId ) {
                    $this->CustomFields = $CustomFields;
                    $this->HideLoginForm = $HideLoginForm;
                    $this->LoginMessage = $LoginMessage;
                    $this->Passcode = $Passcode;
                    $this->RegistrationMessage = $RegistrationMessage;
                    $this->ResourceId = $ResourceId;
        }

}
/**
 * Proxy class for struct ResourceRegistrationCustomFieldDefinition
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class ResourceRegistrationCustomFieldDefinition
{
        /**
         * @var boolean $IsRequired
         */
        public $IsRequired;

        /**
         * @var string $Label
         */
        public $Label;

        /**
         * @param boolean $IsRequired
         * @param string $Label
         */
        function __construct( $IsRequired, $Label ) {
                    $this->IsRequired = $IsRequired;
                    $this->Label = $Label;
        }

}
/**
 * @internal
 *
 * Proxy class for struct DisableRegistrationRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class DisableRegistrationRequest extends RequestMessage
{
        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @param string $ResourceId
         */
        function __construct( $Ticket, $ResourceId, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->ResourceId = $ResourceId;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * @internal
 *
 * Proxy class for struct AddRegistrantsToResourceRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class AddRegistrantsToResourceRequest extends RequestMessage
{
        /**
         * @var ResourceRegistrationDetail[] $RegistrationDetails
         */
        public $RegistrationDetails;

        /**
         * @param ResourceRegistrationDetail[] $RegistrationDetails
         */
        function __construct( $Ticket, $RegistrationDetails, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->RegistrationDetails = $RegistrationDetails;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * Proxy class for struct ResourceRegistrationDetail
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class ResourceRegistrationDetail
{
        /**
         * @var ResourceRegistrationCustomField[] $CustomFields
         */
        public $CustomFields;

        /**
         * @var string $EmailAddress
         */
        public $EmailAddress;

        /**
         * @var string $FirstName
         */
        public $FirstName;

        /**
         * @var string $LastName
         */
        public $LastName;

        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @param ResourceRegistrationCustomField[] $CustomFields
         * @param string $EmailAddress
         * @param string $FirstName
         * @param string $LastName
         * @param string $ResourceId
         */
        function __construct( $CustomFields, $EmailAddress, $FirstName, $LastName, $ResourceId ) {
                    $this->CustomFields = $CustomFields;
                    $this->EmailAddress = $EmailAddress;
                    $this->FirstName = $FirstName;
                    $this->LastName = $LastName;
                    $this->ResourceId = $ResourceId;
        }

}
/**
 * Proxy class for struct ResourceRegistrationCustomField
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class ResourceRegistrationCustomField
{
        /**
         * @var string $Label
         */
        public $Label;

        /**
         * @var string $Value
         */
        public $Value;

        /**
         * @param string $Label
         * @param string $Value
         */
        function __construct( $Label, $Value ) {
                    $this->Label = $Label;
                    $this->Value = $Value;
        }

}
/**
 * @internal
 *
 * Proxy class for struct RemoveRegistrantsFromResourceRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class RemoveRegistrantsFromResourceRequest extends RequestMessage
{
        /**
         * @var ResourceRegistrationDetail[] $RegistrationDetails
         */
        public $RegistrationDetails;

        /**
         * @param ResourceRegistrationDetail[] $RegistrationDetails
         */
        function __construct( $Ticket, $RegistrationDetails, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->RegistrationDetails = $RegistrationDetails;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * @internal
 *
 * Proxy class for struct QueryResourceRegistrantsRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryResourceRegistrantsRequest extends RequestMessage
{
        /**
         * @var string $ResourceId
         */
        public $ResourceId;

        /**
         * @param string $ResourceId
         */
        function __construct( $Ticket, $ResourceId, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->ResourceId = $ResourceId;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * @internal
 *
 * Proxy class for struct CreateMp3ContentRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateMp3ContentRequest extends RequestMessage
{
        /**
         * @var int $AudioBitRate
         */
        public $AudioBitRate;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @param int $AudioBitRate
         * @param string $PresentationId
         */
        function __construct( $Ticket, $AudioBitRate, $PresentationId, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->AudioBitRate = $AudioBitRate;
                    $this->PresentationId = $PresentationId;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * @internal
 *
 * Proxy class for struct CreateMediaImportProjectRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateMediaImportProjectRequest extends RequestMessage
{
        /**
         * @var CreateMediaImportProjectDetails $CreateDetails
         */
        public $CreateDetails;

        /**
         * @param CreateMediaImportProjectDetails $CreateDetails
         */
        function __construct( $Ticket, $CreateDetails, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->CreateDetails = $CreateDetails;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * Proxy class for struct CreateMediaImportProjectDetails
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class CreateMediaImportProjectDetails
{
        /**
         * @var DropboxDetails $DropBoxDetails
         */
        public $DropBoxDetails;

        /**
         * @var PresentationImportOptionDetails $ImportOptions
         */
        public $ImportOptions;

        /**
         * @var string $Name
         */
        public $Name;

        /**
         * @var string $ParentFolderId
         */
        public $ParentFolderId;

        /**
         * @var dateTime $StartDate
         */
        public $StartDate;

        /**
         * @var string $TemplateId
         */
        public $TemplateId;

        /**
         * @var int $UpdateIntervalInMinutes
         */
        public $UpdateIntervalInMinutes;

        /**
         * @param DropboxDetails $DropBoxDetails
         * @param PresentationImportOptionDetails $ImportOptions
         * @param string $Name
         * @param string $ParentFolderId
         * @param dateTime $StartDate
         * @param string $TemplateId
         * @param int $UpdateIntervalInMinutes
         */
        function __construct( $DropBoxDetails, $ImportOptions, $Name, $ParentFolderId, $StartDate, $TemplateId, $UpdateIntervalInMinutes ) {
                    $this->DropBoxDetails = $DropBoxDetails;
                    $this->ImportOptions = $ImportOptions;
                    $this->Name = $Name;
                    $this->ParentFolderId = $ParentFolderId;
                    $this->StartDate = $StartDate;
                    $this->TemplateId = $TemplateId;
                    $this->UpdateIntervalInMinutes = $UpdateIntervalInMinutes;
        }

}
/**
 * Proxy class for struct DropboxDetails
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class DropboxDetails
{
        /**
         * @var string $Location
         */
        public $Location;

        /**
         * @var string $Password
         */
        public $Password;

        /**
         * @var string $Username
         */
        public $Username;

        /**
         * @param string $Location
         * @param string $Password
         * @param string $Username
         */
        function __construct( $Location, $Password, $Username ) {
                    $this->Location = $Location;
                    $this->Password = $Password;
                    $this->Username = $Username;
        }

}
/**
 * Proxy class for struct PresentationImportOptionDetails
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class PresentationImportOptionDetails
{
        /**
         * @var boolean $AlwaysUsePresentersFromTemplate
         */
        public $AlwaysUsePresentersFromTemplate;

        /**
         * @var boolean $DeleteDropboxFileOnSuccessfulImport
         */
        public $DeleteDropboxFileOnSuccessfulImport;

        /**
         * @var boolean $MatchSource
         */
        public $MatchSource;

        /**
         * @var string $StartTimeUtc
         */
        public $StartTimeUtc;

        /**
         * @var boolean $TitlePresentationBasedOnTemplate
         */
        public $TitlePresentationBasedOnTemplate;

        /**
         * @param boolean $AlwaysUsePresentersFromTemplate
         * @param boolean $DeleteDropboxFileOnSuccessfulImport
         * @param boolean $MatchSource
         * @param string $StartTimeUtc
         * @param boolean $TitlePresentationBasedOnTemplate
         */
        function __construct( $AlwaysUsePresentersFromTemplate, $DeleteDropboxFileOnSuccessfulImport, $MatchSource, $StartTimeUtc, $TitlePresentationBasedOnTemplate ) {
                    $this->AlwaysUsePresentersFromTemplate = $AlwaysUsePresentersFromTemplate;
                    $this->DeleteDropboxFileOnSuccessfulImport = $DeleteDropboxFileOnSuccessfulImport;
                    $this->MatchSource = $MatchSource;
                    $this->StartTimeUtc = $StartTimeUtc;
                    $this->TitlePresentationBasedOnTemplate = $TitlePresentationBasedOnTemplate;
        }

}
/**
 * @internal
 *
 * Proxy class for struct QueryContentImportProjectProgressRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryContentImportProjectProgressRequest extends RequestMessage
{
        /**
         * @var string[] $FileNames
         */
        public $FileNames;

        /**
         * @var string $MediaImportProjectId
         */
        public $MediaImportProjectId;

        /**
         * @param string[] $FileNames
         * @param string $MediaImportProjectId
         */
        function __construct( $Ticket, $FileNames, $MediaImportProjectId, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->FileNames = $FileNames;
                    $this->MediaImportProjectId = $MediaImportProjectId;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
/**
 * Proxy class for struct ImportProjectItemProgress
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class ImportProjectItemProgress
{
        /**
         * @var string $DropboxFileName
         */
        public $DropboxFileName;

        /**
         * @var string $PresentationId
         */
        public $PresentationId;

        /**
         * @var ContentImportProjectItemStatusDetails $Status
         */
        public $Status;

        /**
         * @param string $DropboxFileName
         * @param string $PresentationId
         * @param ContentImportProjectItemStatusDetails $Status
         */
        function __construct( $DropboxFileName, $PresentationId, $Status ) {
                    $this->DropboxFileName = $DropboxFileName;
                    $this->PresentationId = $PresentationId;
                    $this->Status = $Status;
        }

}

/**
 * @internal
 *
 * Proxy class for struct QueryPresentationViewingTrendsRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryPresentationViewingTrendsRequest extends RequestMessage
{
    /**
     * @var string $ClientId
     */
    public $ClientId;

    /**
     * @var QueryOptions $Options
     */
    public $Options;

    /**
     * @var string $PresentationId
     */
    public $PresentationId;

    /**
     * @var AnalyticsRequestType $RequestType
     */
    public $RequestType;

    /**
     * @param string $ClientId
     * @param QueryOptions $Options
     * @param string $PresentationId
     * @param AnalyticsRequestType $RequestType
     */
    function __construct( $Ticket, $ClientId, $Options, $PresentationId, $RequestType, $ImpersonationUsername = null ) {
        $this->Ticket = $Ticket;
        $this->ClientId = $ClientId;
        $this->Options = $Options;
        $this->PresentationId = $PresentationId;
        $this->RequestType = $RequestType;
        $this->ImpersonationUsername = $ImpersonationUsername;
    }

}
/**
 * Proxy class for struct SegmentViews
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class SegmentViews
{
    /**
     * @var int $Duration
     */
    public $Duration;

    /**
     * @var int $StartTime
     */
    public $StartTime;

    /**
     * @var int $Views
     */
    public $Views;

    /**
     * @param int $Duration
     * @param int $StartTime
     * @param int $Views
     */
    function __construct( $Duration, $StartTime, $Views ) {
        $this->Duration = $Duration;
        $this->StartTime = $StartTime;
        $this->Views = $Views;
    }

}

/**
 * @internal
 *
 * Proxy class for struct QueryPresentationViewingSessionsRequest
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class QueryPresentationViewingSessionsRequest extends RequestMessage
{
    /**
     * @var string $ClientId
     */
    public $ClientId;

    /**
     * @var QueryOptions $Options
     */
    public $Options;

    /**
     * @var string $PresentationId
     */
    public $PresentationId;

    /**
     * @var AnalyticsRequestType $RequestType
     */
    public $RequestType;

    /**
     * @param string $ClientId
     * @param QueryOptions $Options
     * @param string $PresentationId
     * @param AnalyticsRequestType $RequestType
     */
    function __construct( $Ticket, $ClientId, $Options, $PresentationId, $RequestType, $ImpersonationUsername = null ) {
        $this->Ticket = $Ticket;
        $this->ClientId = $ClientId;
        $this->Options = $Options;
        $this->PresentationId = $PresentationId;
        $this->RequestType = $RequestType;
        $this->ImpersonationUsername = $ImpersonationUsername;
    }

}
/**
 * Proxy class for struct ViewingSession
 *
 * @package SonicFoundry.Mediasite.Edas.PHPProxy
 * @since 6.1.11
 */
class ViewingSession
{
    /**
     * @var string $Browser
     */
    public $Browser;

    /**
     * @var int $CoverageWatchedSeconds
     */
    public $CoverageWatchedSeconds;

    /**
     * @var string $HostName
     */
    public $HostName;

    /**
     * @var string $IPAddress
     */
    public $IPAddress;

    /**
     * @var dateTime $LastActive
     */
    public $LastActive;

    /**
     * @var string $MediaPlugin
     */
    public $MediaPlugin;

    /**
     * @var dateTime $Opened
     */
    public $Opened;

    /**
     * @var string $PlaybackTicket
     */
    public $PlaybackTicket;

    /**
     * @var string $Player
     */
    public $Player;

    /**
     * @var string $PresentationId
     */
    public $PresentationId;

    /**
     * @var string $Referrer
     */
    public $Referrer;

    /**
     * @var ViewingSessionType $SessionType
     */
    public $SessionType;

    /**
     * @var string $System
     */
    public $System;

    /**
     * @var int $TimeWatchedSeconds
     */
    public $TimeWatchedSeconds;

    /**
     * @var string $UserName
     */
    public $UserName;

    /**
     * @param string $Browser
     * @param int $CoverageWatchedSeconds
     * @param string $HostName
     * @param string $IPAddress
     * @param dateTime $LastActive
     * @param string $MediaPlugin
     * @param dateTime $Opened
     * @param string $PlaybackTicket
     * @param string $Player
     * @param string $PresentationId
     * @param string $Referrer
     * @param ViewingSessionType $SessionType
     * @param string $System
     * @param int $TimeWatchedSeconds
     * @param string $UserName
     */
    function __construct( $Browser, $CoverageWatchedSeconds, $HostName, $IPAddress, $LastActive, $MediaPlugin, $Opened, $PlaybackTicket, $Player, $PresentationId, $Referrer, $SessionType, $System, $TimeWatchedSeconds, $UserName ) {
        $this->Browser = $Browser;
        $this->CoverageWatchedSeconds = $CoverageWatchedSeconds;
        $this->HostName = $HostName;
        $this->IPAddress = $IPAddress;
        $this->LastActive = $LastActive;
        $this->MediaPlugin = $MediaPlugin;
        $this->Opened = $Opened;
        $this->PlaybackTicket = $PlaybackTicket;
        $this->Player = $Player;
        $this->PresentationId = $PresentationId;
        $this->Referrer = $Referrer;
        $this->SessionType = $SessionType;
        $this->System = $System;
        $this->TimeWatchedSeconds = $TimeWatchedSeconds;
        $this->UserName = $UserName;
    }

}

/**
 * @internal
 *
 *  * Proxy class for struct CreatePublishToGoContentRequest
 *  *
 *  * @package SonicFoundry.Mediasite.Edas.PHPProxy
 *  * @since 6.1.11
 *  */
class CreatePublishToGoContentRequest extends RequestMessage
{
        /**
         *      * @var string $ContentServerId
         *      */
        public $ContentServerId;

        /**
         *      * @var string $PresentationId
         *      */
        public $PresentationId;

        /**
         *      * @param string $ContentServerId
         *      * @param string $PresentationId
         *      */
        function __construct( $Ticket, $ContentServerId, $PresentationId, $ImpersonationUsername = null ) {
                    $this->Ticket = $Ticket;
                    $this->ContentServerId = $ContentServerId;
                    $this->PresentationId = $PresentationId;
                    $this->ImpersonationUsername = $ImpersonationUsername;
        }

}
