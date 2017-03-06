<?php

    namespace Sonicfoundry\EDAS;

    require_once __DIR__ . '/edasproxy_responses.php';
    require_once __DIR__ . '/edasproxy_functions.php';

    /**
     * Mediasite External Data Access (Edas) webservice client wrapper
     * These proxy classes were generated based on the Mediasite 6.0 EDAS WSDL definition.
     * PHP Version 5.3
     *
     * @copyright Copyright (c) 2013, Sonic Foundry
     * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
     * @version   6.1.7
     * @package   SonicFoundry.Mediasite.Edas.PHPClient
     * @author    Cori Schlegel <coris@sonicfoundry.com>
     *            This software is provided "AS IS" without a warranty of any kind.

     */
    /**
     * The proxy will take care of requiring the items it needs
     */
    require_once( __DIR__ . "/edasproxy.php" );

    /**
     * External Access Client takes care of communications with the EDAS SOAP endpoint defined in the constructor
     *
     * @api
     *
     * @package SonicFoundry.Mediasite.Edas.PHPClient
     */
    class ExternalAccessClient
    {
        const VERSION = 'Services60/EdasSixOneThirteen.svc';

        /**
         * @var string user ticket cached in the client instance
         */
        public $Ticket;

        /**
         * @var string User to impersonate; must exist in the system
         */
        public $ImpersonationUsername;

        /**
         * Construct new Edas Access client.
         * Ticket will be cached for the request if provided.
         * Aside from Login() and Logout(), all other methods rely on a ticket being supplied in the EdasAccessClient
         * constructor or in the method call or being created and cached by calling Login().
         * Once created and cached for a given request, multiple operations can be executed from within that context.
         *
         * @param string $serviceLocation            url of the Edas service
         * @param string $ticket                     ticket must be provided if Login is not called during this request
         * @param string $impersonationUsername      user to impersonate for this session
         * @param array  $additional_options         additional SoapClient options
         *
         * @throws Exception
         */
        function __construct( $serviceLocation = 'http://dev.mediasite.com/Mediasite/6_1_7', $username = null, $password = null, $apiKey = null, $impersonationUsername = null, $certinfo = null, $proxy = null, $ticket = null, $additional_options = array() ) {
            $edas_class_map = array();

            $edas_type_map = array( array( "type_ns"   => "http://schemas.microsoft.com/2003/10/Serialization/Arrays",
                                           "type_name" => "ArrayOfdateTime",
                                           "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistDatesWatchedList" ),
                array( "type_ns"   => "http://schemas.microsoft.com/2003/10/Serialization/Arrays",
                       "type_name" => "ArrayOfString",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfString" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfIdNameTotalPair",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfIdNameTotalPair" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPresentationUsage",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPresentationUsage" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfActiveConnection",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfActiveConnection" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfFolderDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfFolderDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPresentationContentDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPresentationContentDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPresentationDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPresentationDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfUserProfileMapping",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfUserProfileMappings" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfMediasiteKeyValue",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfMediasiteKeyValue" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPresentationTemplateDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPresentationTemplateDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfContentEncodingSettingDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfContentEncodingSettingDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfMediasiteTimeZone",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfMediasiteTimeZone" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfScheduleDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfScheduleDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfScheduleRecurrenceDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfScheduleRecurrenceDetail" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfCatalogShare",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfCatalogShare" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfMediasiteRoleDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfMediasiteRoleDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfChapterDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfChapterDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfContentServerDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfContentServerDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPlayerDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPlayerDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfPresenterDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfPresenterDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfResourcePermissionEntry",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfResourcePermissionEntry" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfResourcePermissions",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfResourcePermissions" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfSlideDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfSlideDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfUserProfileDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfUserProfileDetails" ),
                array( "type_ns"   => "http://www.SonicFoundry.com/Mediasite/Services60/Messages",
                       "type_name" => "ArrayOfExternalLinkDetails",
                       "from_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfExternalLinkDetails" ),

                array("type_ns" => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfResourceRegistrationCustomFieldDefinition",
                    "type_xml" => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfResourceRegistrationCustomFieldDefinition"),
                array("type_ns" => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfResourceRegistrationDetail",
                    "type_xml" => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfResourceRegistrationDetail"),
                array("type_ns" => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfResourceRegistrationCustomField",
                    "type_xml" => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfResourceRegistrationCustomField"),
                array("type_ns" => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfImportProjectItemProgress",
                    "type_xml" => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfImportProjectItemProgress"),

                array ( "type_ns"   => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfSegmentViews",
                    "type_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfSegmentViews" ),
                array ( "type_ns"   => "http://schema.microsoft.com/2003/10/Serialization/Arrays",
                    "type_name" => "ArrayOfViewingSession",
                    "type_xml"  => "Sonicfoundry\EDAS\TypeMapFunctions::hoistArrayOfViewingSession" )
            );

            try {
                if(!is_null($impersonationUsername) && $impersonationUsername) {
                    $this->ImpersonationUsername = $impersonationUsername;
                }
                if(strpos($serviceLocation, self::VERSION."?WSDL") === FALSE) {
                    if(substr($serviceLocation, - 1) === '/') {
                        $serviceLocation .= self::VERSION."?WSDL";
                    } else {
                        $serviceLocation .= "/".self::VERSION."?WSDL";
                    }
                }
                if(!is_null($certinfo) && !empty($certinfo)) {
                    $opts = array(
                        'ssl' => array('verify_peer' => false,
                                       'verify_host' => true) ,
                        'https' => array('curl_verify_ssl_peer' => false,
                                         'curl_verify_ssl_host' => true)
                    );
                    $streamContext = stream_context_create($opts);
                    $ssl_opts = array('local_cert' => file_get_contents($certinfo),
                                      'allow_self_signed' => true,
                                      'stream_context' => $streamContext);

                    $additional_options = array_merge($ssl_opts, $additional_options);
                }
                $this->proxy = new \SoapClient( $serviceLocation,
                                               array_merge(array( "typemap" => $edas_type_map,
                                                                  "classmap" => $edas_class_map ),
                                                           $additional_options) );
                if(!is_null($username) &&
                   !is_null($password) &&
                   (is_null($ticket) || empty($ticket))) {
                    $this->Login($username, $password, 'Moodle Plugin', $impersonationUsername);
                } else {
                    $this->Ticket = $ticket;
                }
            } catch ( Exception $ex ) {
                throw( $ex );
            }

        }

        /**
         * Creates a role with a given set of details
         *
         * @param CreateRoleDetails $RoleDetails
         * @param string            $Ticket
         * @param null              $ImpersonationUsername
         *
         * @return CreateRoleResponse
         * @since 6.0
         */
        public function CreateRole( CreateRoleDetails $RoleDetails, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateRoleRequest( $reqTicket, $RoleDetails, $ImpersonationUsername );
            $container             = new CreateRole( $req );

            return $this->proxy->CreateRole($container)->CreateRoleResult;
        }

        /**
         * Update a role
         *
         * @param UpdateRoleDetails $RoleDetails
         * @param string            $Ticket
         * @param string            $ImpersonationUsername
         *
         * @return UpdateRoleResponse
         * @since 6.0
         */
        public function UpdateRole( UpdateRoleDetails $RoleDetails, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdateRoleRequest( $reqTicket, $RoleDetails, $ImpersonationUsername );
            $container             = new UpdateRole( $req );

            return $this->proxy->UpdateRole($container)->UpdateRoleResult;
        }

        /**
         * Queries total view count for a supplied array of string Ids and {@link AnalyticsRequestType}
         *
         * @todo    verify how these results are sorted
         *
         * @param string[]                $IdList array of Ids
         * @param AnalyticsRequestType    $RequestType
         * @param QueryOptions            $Options
         * @param string                  $Ticket
         * @param string                  $ImpersonationUsername
         *
         * @return QueryTotalViewsResponse
         * @since   6.0
         */
        public function QueryTotalViews( array $IdList, $RequestType, QueryOptions $Options = null, $Ticket = null,
                                         $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTotalViewsRequest( $reqTicket, $IdList, $RequestType, $Options, $ImpersonationUsername );
            $container             = new QueryTotalViews( $req );

            return $this->proxy->QueryTotalViews($container)->QueryTotalViewsResult;
        }

        /**
         * Queries the dates a given presentation was watched
         *
         * @param string               $Id
         * @param AnalyticsRequestType $RequestType
         * @param QueryOptions         $Options
         * @param string               $Ticket
         * @param string               $ImpersonationUsername
         *
         * @return QueryDatesWatchedResponse
         * @since 6.0
         */
        public function QueryDatesWatched( $Id, $RequestType, QueryOptions $Options = null, $Ticket = null,
                                           $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryAnalyticsByIdRequest( $reqTicket, $Id, $RequestType, $Options, $ImpersonationUsername );
            $container             = new QueryDatesWatched( $req );

            return $this->proxy->QueryDatesWatched($container)->QueryDatesWatchedResult;
        }

        /**
         * Query platform configurations used to watch a given presentation
         *
         * @param string               $Id
         * @param AnalyticsRequestType $RequestType
         * @param QueryOptions         $Options
         * @param string               $Ticket
         * @param string               $ImpersonationUsername
         *
         * @return QueryPlatformUsageResponse
         * @since 6.0
         */
        public function QueryPlatformUsage( $Id, $RequestType, QueryOptions $Options = null, $Ticket = null,
                                            $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryAnalyticsByIdRequest( $reqTicket, $Id, $RequestType, $Options, $ImpersonationUsername );
            $container             = new QueryPlatformUsage( $req );

            return $this->proxy->QueryPlatformUsage($container)->QueryPlatformUsageResult;
        }

        /**
         * Queries the totals views of a particular Mediasite entity
         * AnalyticsRequestType::Server is not valid in either $RequestType or $ChildType
         *
         * @param string               $Id
         * @param AnalyticsRequestType $RequestType
         * @param AnalyticsRequestType $ChildType
         * @param QueryOptions         $Options
         * @param string               $Ticket
         * @param string               $ImpersonationUsername
         *
         * @return QueryTotalViewsResponse
         * @since 6.0
         */
        public function QueryTotalViewsById( $Id, $RequestType, $ChildType, QueryOptions $Options = null, $Ticket = null,
                                             $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTotalViewsByIdRequest( $reqTicket, $Id, $RequestType, $ChildType, $Options, $ImpersonationUsername );
            $container             = new QueryTotalViewsById( $req );

            return $this->proxy->QueryTotalViewsById($container)->QueryTotalViewsByIdResult;
        }

        /**
         * Queries Mediasite for presentation usage for a given client type and identifier
         * AnalyticsRequestType::Presentation and AnalyticsRequestType::Server are invalid for this query
         *
         * @param string[]                $ClientIdList array of strings must be valid IP Addresses if $ClientType is AnalyticsRequestType::IPAddress
         * @param AnalyticsRequestType    $ClientType   only IPAddress and User are valid pn this request
         * @param string                  $PresentationId
         * @param QueryOptions            $Options
         * @param string                  $Ticket
         * @param string                  $ImpersonationUsername
         *
         * @return QueryPresentationUsageResponse
         * @since 6.0
         */
        public function QueryPresentationUsage( array $ClientIdList, $ClientType, $PresentationId,
                                                QueryOptions $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationUsageRequest( $reqTicket, $ClientIdList, $ClientType, $PresentationId, $Options,
                $ImpersonationUsername );
            $container             = new QueryPresentationUsage( $req );

            return $this->proxy->QueryPresentationUsage($container)->QueryPresentationUsageResult;
        }

        /**
         * Queries Mediasite for some server usage details
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryServerUsageResponse
         * @since 6.0
         */
        public function QueryServerUsage( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryServerUsageRequest( $reqTicket, $ImpersonationUsername );
            $container             = new QueryServerUsage( $req );

            return $this->proxy->QueryServerUsage($container)->QueryServerUsageResult;
        }

        /**
         * Query the active connections on the Mediasite instance
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryActiveConnectionsResponse
         * @since 6.0
         */
        public function QueryActiveConnections( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryActiveConnectionsRequest( $reqTicket, $ImpersonationUsername );
            $container             = new QueryActiveConnections( $req );

            return $this->proxy->QueryActiveConnections($container)->QueryActiveConnectionsResult;
        }

        /**
         * Query Mediasite for Presentations that are currently active
         *
         * @param string[]        $PresentationIdList array of strings
         * @param QueryOptions    $Options
         * @param string          $Ticket
         * @param string          $ImpersonationUsername
         *
         * @return QueryActivePresentationsResponse
         * @since 6.0
         */
        public function QueryActivePresentations( array $PresentationIdList, QueryOptions $Options, $Ticket = null,
                                                  $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryActivePresentationsRequest( $reqTicket, $PresentationIdList, $Options, $ImpersonationUsername );
            $container             = new QueryActivePresentations( $req );

            return $this->proxy->QueryActivePresentations($container)->QueryActivePresentationsResult;
        }

        /**
         * Query for a structured array of {@link ActiveConnection} for a given Presentation
         *
         * @param string       $PresentationId
         * @param QueryOptions $Options
         * @param string       $Ticket
         * @param string       $ImpersonationUsername
         *
         * @return QueryActivePresentationConnectionsResponse
         * @since 6.0
         */
        public function QueryActivePresentationConnections( $PresentationId, QueryOptions $Options = null, $Ticket = null,
                                                            $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryActivePresentationConnectionsRequest( $reqTicket, $PresentationId, $Options,
                $ImpersonationUsername );
            $container             = new QueryActivePresentationConnections( $req );

            return $this->proxy->QueryActivePresentationConnections($container)->QueryActivePresentationConnectionsResult;
        }

        /**
         * Creates an authorization ticket to a particular resource for a given username/ipaddress combination
         * One usage is as one mechanism for creating playback tickets for Presentations
         * Resource must be valid for PermissionMask.Execute for this call to succeed
         *
         * @param string $IPAddress
         * @param int    $MinutesToLive
         * @param string $ResourceId
         * @param string $Username
         *
         * @return CreateAuthTicketResponse
         * @since 6.0
         */
        public function CreateAuthTicket( $IPAddress, $MinutesToLive, $ResourceId, $Username ) {
            $reqTicket = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $settings  = new CreateAuthTicketSettings( $IPAddress, $MinutesToLive, $ResourceId, $Username );
            $req       = new CreateAuthTicketRequest( $reqTicket, $settings );
            $container = new CreateAuthTicket( $req );

            return $this->proxy->CreateAuthTicket($container)->CreateAuthTicketResult;
        }

        /**
         * Queries Service for properties of an Auth Ticket, and optionally renews it
         *
         * @param string $AuthTicketId
         * @param int    $MinutesToLive
         * @param bool   $RenewTicket
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryAuthTicketPropertiesResponse
         * @since 6.0
         */
        public function QueryAuthTicketProperties( $AuthTicketId, $MinutesToLive, $RenewTicket, $Ticket = null,
                                                   $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryAuthTicketPropertiesRequest( $reqTicket, $AuthTicketId, $MinutesToLive, $RenewTicket, $ImpersonationUsername );
            $container             = new QueryAuthTicketProperties( $req );

            return $this->proxy->QueryAuthTicketProperties($container)->QueryAuthTicketPropertiesResult;
        }

        /**
         * Creates a folder based on provided details
         * The a folder with the provided name must not exist within the given parent folder, even if it is recycled
         * If no parent folder id is provided, the new folder will be created in the root folder
         * The currently logged-in user or the user being impersonated in this request will be the new folder's owner
         * $PermissionList is the set of ResourcePermissionEntries to be applied to the folder when it is created
         *
         * @param string                                            $Name
         * @param ResourcePermissionEntry|ResourcePermissionEntry[] $PermissionList Array of {@link ResourcePermissionEntries}
         * @param string                                            $Description
         * @param CreateFolderTypeDetails                           $FolderType
         * @param string                                            $ParentFolderId
         * @param string                                            $ImpersonationUsername
         *
         * @return CreateSubFolderResponse
         * @since 6.0
         */
        public function CreateSubFolder( $Name, $PermissionList, $Description = null, $FolderType = null,
                                         $ParentFolderId = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateSubFolderRequest( $reqTicket, $Name, $PermissionList, $Description,
                $FolderType, $ParentFolderId, $ImpersonationUsername );
            $container             = new CreateSubFolder( $req );

            return $this->proxy->CreateSubFolder($container)->CreateSubFolderResult;
        }

        /**
         * Queries details of the given folder
         * $PermissionMask is a ResourcePermissionMask that the logged-in or impersonated user is required to have before
         *  the query will execute
         *
         * @param string[]                 $FolderIdList array of strings
         * @param ResourcePermissionMask   $PermissionMask
         * @param string                   $Ticket
         * @param string                   $ImpersonationUsername
         *
         * @return QueryFoldersByIdResponse
         * @throws SoapFault
         * @since 6.0
         */
        public function QueryFoldersById( array $FolderIdList, $PermissionMask, $Ticket = null,
                                          $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryFoldersByIdRequest( $reqTicket, $FolderIdList, $PermissionMask, $ImpersonationUsername );
            $container             = new QueryFoldersById( $req );

            return $this->proxy->QueryFoldersById($container)->QueryFoldersByIdResult;
        }

        /**
         * Recycles the requested Folder
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         * @since 6.1.1
         */
        public function DeleteFolder( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteFolder( $req );

            return $this->proxy->DeleteFolder($container)->DeleteFolderResult;
        }

        /**
         * Creates a new identity ticket for a given user
         *
         * @param CreateIdentityTicketSettings $Settings
         * @param string                       $Ticket
         * @param string                       $ImpersonationUsername
         *
         * @return CreateIdentityTicketResponse
         * @since 6.0
         */
        public function CreateIdentityTicket( CreateIdentityTicketSettings $Settings, $Ticket = null,
                                              $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateIdentityTicketRequest( $reqTicket, $Settings, $ImpersonationUsername );
            $container             = new CreateIdentityTicket( $req );

            return $this->proxy->CreateIdentityTicket($container)->CreateIdentityTicketResult;
        }

        /**
         * Creates a new presentation from a provided template
         *
         * @param CreatePresentationFromTemplateDetails $CreateDetails
         * @param string                                $Ticket
         * @param string                                $ImpersonationUsername
         *
         * @return CreatePresentationFromTemplateResponse
         * @since 6.0
         */
        public function CreatePresentationFromTemplate( CreatePresentationFromTemplateDetails $CreateDetails,
                                                        $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePresentationFromTemplateRequest( $reqTicket, $CreateDetails, $ImpersonationUsername );
            $container             = new CreatePresentationFromTemplate( $req );

            return $this->proxy->CreatePresentationFromTemplate($container)->CreatePresentationFromTemplateResult;
        }

        /**
         * Creates a Presentations based on a provided Presentation Schedule
         *
         * @param CreatePresentationFromScheduleDetails $CreationDetails
         * @param string                                $Ticket
         * @param string                                $ImpersonationUsername
         *
         * @return CreatePresentationFromScheduleResponse
         */
        public function CreatePresentationFromSchedule( CreatePresentationFromScheduleDetails $CreationDetails,
                                                        $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePresentationFromScheduleRequest( $reqTicket, $CreationDetails, $ImpersonationUsername );
            $container             = new CreatePresentationFromSchedule( $req );

            return $this->proxy->CreatePresentationFromSchedule($container)->CreatePresentationFromScheduleResult;
        }

        /**
         * Creates a presentation based upon the settings from another, already existing presentation
         *
         * @param CreatePresentationLikeDetails $CreationDetails
         * @param string                        $Ticket
         * @param string                        $ImpersonationUsername
         *
         * @return CreatePresentationLikeResponse
         */
        public function CreatePresentationLike( CreatePresentationLikeDetails $CreationDetails, $Ticket = null,
                                                $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePresentationLikeRequest( $reqTicket, $CreationDetails, $ImpersonationUsername );
            $container             = new CreatePresentationLike( $req );

            return $this->proxy->CreatePresentationLike($container)->CreatePresentationLikeResult;
        }

        /**
         * Creates a Poll for a given Presentation
         *
         * @param CreatePresentationPollDetails $CreationDetails
         * @param string                        $Ticket
         * @param string                        $ImpersonationUsername
         *
         * @return CreatePresentationPollResponse
         */
        public function CreatePresentationPoll( CreatePresentationPollDetails $CreationDetails, $Ticket = null,
                                                $ImpersonationUsername = null ) {
            $reqTicket = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $req       = new CreatePresentationPollRequest( $reqTicket, $CreationDetails, $ImpersonationUsername );
            $container = new CreatePresentationPoll( $req );

            return $this->proxy->CreatePresentationPoll($container)->CreatePresentationPollResult;
        }

        /**
         * Creates a Schedule from provided details
         *
         * @param CreateScheduleFromTemplateDetails $Schedule
         * @param string                            $Ticket
         * @param string                            $ImpersonationUsername
         *
         * @return CreateScheduleFromTemplateResponse
         */
        public function CreateScheduleFromTemplate( CreateScheduleFromTemplateDetails $Schedule, $Ticket = null,
                                                    $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateScheduleFromTemplateRequest( $reqTicket, $Schedule, $ImpersonationUsername );
            $container             = new CreateScheduleFromTemplate( $req );

            return $this->proxy->CreateScheduleFromTemplate($container)->CreateScheduleFromTemplateResult;
        }

        /**
         * Gets the version of the Edas service (in the form of the url of the service endpoint)
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return GetVersionResponse
         */
        public function GetVersion( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new GetVersionRequest( $reqTicket, $ImpersonationUsername );
            $container             = new GetVersion( $req );

            return $this->proxy->GetVersion($container)->GetVersionResult;
        }

        /**
         * Logins session in using the provided username and password
         * Alternatively also sets the user for the current session to impersonate and the name of the calling application
         *
         * @param string $Username
         * @param string $Password
         * @param string $ApplicationName
         * @param string $ImpersonationUsername
         *
         * @return LoginResponse
         */
        public function Login( $Username, $Password, $ApplicationName = null, $ImpersonationUsername = null ) {
            if ( isset( $this->ImpersonationUsername ) && $ImpersonationUsername != null ) {
                $msg = 'Mediasite EDAS WARNING: You are logging in with an ImpersonationUsername and also have ';
                $msg .= 'ImpersonationUsername set on the client. All requests made from the instance of the ';
                $msg .= 'ExternalAccessClient will be made as the user represented by the client\'s ';
                $msg .= 'ImpersonationUsername, and if the user you are Impersonating in the login call doesn\'t have ';
                $msg .= 'the Impersonation Operation, all requests will fail.';
                error_log($msg);
            }
            $req       = new LoginRequest( $Username, $Password, $ApplicationName, $ImpersonationUsername );
            $container = new Login( $req );
            $response  = $this->proxy->Login($container)->LoginResult;

            $this->Ticket = $response->UserTicket;

            return $response;
        }

        /**
         * Logs out the session represented by the provided or cached identity ticket
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return LogoutResponse
         */
        public function Logout( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new LogoutRequest( $reqTicket, $ImpersonationUsername );
            $container             = new Logout( $req );

            return $this->proxy->Logout($container)->LogoutResult;
        }

        /**
         * Queries Mediasite Catalogs that the logged-in user has *all* the provided permissions to
         *
         * @param ResourcePermissionMask[] $PermissionMask
         * @param string                   $Ticket
         * @param string                   $ImpersonationUsername
         *
         * @return QueryCatalogSharesResponse
         */
        public function QueryCatalogShares( array $PermissionMask, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryCatalogSharesRequest( $reqTicket, $PermissionMask, $ImpersonationUsername );
            $container             = new QueryCatalogShares( $req );

            return $this->proxy->QueryCatalogShares($container)->QueryCatalogSharesResult;
        }

        /**
         * Queries a given Presenatation for Chapter Points
         *
         * @param int    $Count
         * @param string $PresentationId
         * @param int    $StartIndex
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryChapterPointsResponse
         */
        public function QueryChapterPoints( $Count, $PresentationId, $StartIndex, $Ticket = null,
                                            $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryChapterPointsRequest( $reqTicket, $Count, $PresentationId, $StartIndex, $ImpersonationUsername );
            $container             = new QueryChapterPoints( $req );

            return $this->proxy->QueryChapterPoints($container)->QueryChapterPointsResult;
        }

        /**
         * Returns the calling client's IP Address, and optionally the client's dns name
         *
         * @param bool   $ResolveDnsName
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryClientIpAddressResponse
         */
        public function QueryClientIpAddress( $ResolveDnsName, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryClientIpAddressRequest( $reqTicket, $ResolveDnsName, $ImpersonationUsername );
            $container             = new QueryClientIpAddress( $req );

            return $this->proxy->QueryClientIpAddress($container)->QueryClientIpAddressResult;
        }

        /**
         * Queries Content Servers for a given Presentation and the given options
         *
         * @param ContentServerQueryCriteria $Criteria
         * @param string                     $Ticket
         * @param string                     $ImpersonationUsername
         *
         * @return QueryContentServersByCriteriaResponse
         */
        public function QueryContentServersByCriteria( ContentServerQueryCriteria $Criteria, $Ticket = null,
                                                       $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryContentServersByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryContentServersByCriteria( $req );

            return $this->proxy->QueryContentServersByCriteria($container)->QueryContentServersByCriteriaResult;
        }

        /**
         * Queries all Folder that contain Presentations
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryFoldersWithPresentationsResponse
         */
        public function QueryFoldersWithPresentations( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryFoldersWithPresentationsRequest( $reqTicket, $ImpersonationUsername );
            $container             = new QueryFoldersWithPresentations( $req );

            return $this->proxy->QueryFoldersWithPresentations($container)->QueryFoldersWithPresentationsResult;
        }

        /**
         * Queries Properties of the provided Identity ticket, and optionally renews it
         * Use this method to determine if the ticket you've cached is still valid
         *
         * @param string $IdentityTicket
         * @param int    $MinutesToLive
         * @param bool   $RenewTicket
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryIdentityTicketPropertiesResponse
         * @since 6.0
         */
        public function QueryIdentityTicketProperties( $IdentityTicket, $MinutesToLive, $RenewTicket, $Ticket = null,
                                                       $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryIdentityTicketPropertiesRequest( $reqTicket, $IdentityTicket, $MinutesToLive, $RenewTicket, $ImpersonationUsername );
            $container             = new QueryIdentityTicketProperties( $req );

            return $this->proxy->QueryIdentityTicketProperties($container)->QueryIdentityTicketPropertiesResult;
        }

        /**
         * Queries Encoding Settings for a given Id
         *
         * @param string[]  $ContentEncodingSettingsIds array of strings
         * @param string    $Ticket
         * @param string    $ImpersonationUsername
         *
         * @return QueryContentEncodingSettingsByIdResponse
         */
        public function QueryContentEncodingSettingsById( array $ContentEncodingSettingsIds, $Ticket = null,
                                                          $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryContentEncodingSettingsByIdRequest( $reqTicket, $ContentEncodingSettingsIds, $ImpersonationUsername );
            $container             = new QueryContentEncodingSettingsById( $req );

            return $this->proxy->QueryContentEncodingSettingsById($container)->QueryContentEncodingSettingsByIdResult;
        }

        /**
         * Queries Encoding Settings based on provided criteria
         *
         * @param ContentEncodingSettingsQueryCriteria $Criteria
         * @param string                               $Ticket
         * @param string                               $ImpersonationUsername
         *
         * @return QueryContentEncodingSettingsByCriteriaResponse
         */
        public function QueryContentEncodingSettingsByCriteria( ContentEncodingSettingsQueryCriteria $Criteria,
                                                                $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryContentEncodingSettingsByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryContentEncodingSettingsByCriteria( $req );

            return $this->proxy->QueryContentEncodingSettingsByCriteria($container)->QueryContentEncodingSettingsByCriteriaResult;
        }

        /**
         * Queries details of available Players
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryPlayersResponse
         */
        public function QueryPlayers( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPlayersRequest( $reqTicket, $ImpersonationUsername );
            $container             = new QueryPlayers( $req );

            return $this->proxy->QueryPlayers($container)->QueryPlayersResult;
        }

        /**
         * Queries details of the provided array of Presentations
         *
         * @param string[]  $PresentationIds
         * @param string    $Ticket
         * @param string    $ImpersonationUsername
         *
         * @return QueryPresentationsByIdResponse
         * @since 6.0
         */
        public function QueryPresentationsById( array $PresentationIds, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationsByIdRequest( $reqTicket, $PresentationIds, $ImpersonationUsername );
            $container             = new QueryPresentationsById( $req );

            return $this->proxy->QueryPresentationsById($container)->QueryPresentationsByIdResult;
        }

        /**
         * Queries Presentationsbase on provided criteria
         *
         * @param PresentationQueryCriteria $QueryCriteria
         * @param QueryOptions              $Options
         * @param string                    $Ticket
         * @param string                    $ImpersonationUsername
         *
         * @return QueryPresentationsByCriteriaResponse
         */
        public function QueryPresentationsByCriteria( PresentationQueryCriteria $QueryCriteria,
                                                      QueryOptions $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationsByCriteriaRequest( $reqTicket, $QueryCriteria, $Options, $ImpersonationUsername );
            $container             = new QueryPresentationsByCriteria( $req );

            return $this->proxy->QueryPresentationsByCriteria($container)->QueryPresentationsByCriteriaResult;
        }

        /**
         * Queries Templates by provided criteria
         *
         * @param PresentationTemplateQueryCriteria $QueryCriteria
         * @param QueryOptions                      $Options
         * @param string                            $Ticket
         * @param string                            $ImpersonationUsername
         *
         * @return QueryPresentationTemplatesByCriteriaResponse
         */
        public function QueryPresentationTemplatesByCriteria( PresentationTemplateQueryCriteria $QueryCriteria,
                                                              QueryOptions $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationTemplatesByCriteriaRequest( $reqTicket, $QueryCriteria, $Options, $ImpersonationUsername );
            $container             = new QueryPresentationTemplatesByCriteria( $req );

            return $this->proxy->QueryPresentationTemplatesByCriteria($container)->QueryPresentationTemplatesByCriteriaResult;
        }

        /**
         * Queries Presenters based on provided criteria
         *
         * @param PresenterQueryCriteria $QueryCriteria
         * @param string                 $Ticket
         * @param string                 $ImpersonationUsername
         *
         * @return QueryPresentersByCriteriaResponse
         */
        public function QueryPresentersByCriteria( PresenterQueryCriteria $QueryCriteria, $Ticket = null,
                                                   $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentersByCriteriaRequest( $reqTicket, $QueryCriteria, $ImpersonationUsername );
            $container             = new QueryPresentersByCriteria( $req );

            return $this->proxy->QueryPresentersByCriteria($container)->QueryPresentersByCriteriaResult;
        }

        /**
         * Queries Presenters from a given list of Ids
         *
         * @param string[]  $PresenterIdList
         * @param string    $Ticket
         * @param string    $ImpersonationUsername
         *
         * @return QueryPresentersByIdResponse
         */
        public function QueryPresentersById( array $PresenterIdList, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentersByIdRequest( $reqTicket, $PresenterIdList, $ImpersonationUsername );
            $container             = new QueryPresentersById( $req );

            return $this->proxy->QueryPresentersById($container)->QueryPresentersByIdResult;
        }

        /**
         * Queries a list of Roles that have permissions to a provided resource, along with the permissions each Role is
         *  granted
         *
         * @param ResourceIdentifier $Resource
         * @param string             $Ticket
         * @param string             $ImpersonationUsername
         *
         * @return QueryResourcePermissionListResponse
         */
        public function QueryResourcePermissionList( ResourceIdentifier $Resource, $Ticket = null,
                                                     $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryResourcePermissionListRequest( $reqTicket, $Resource, $ImpersonationUsername );
            $container             = new QueryResourcePermissionList( $req );

            return $this->proxy->QueryResourcePermissionList($container)->QueryResourcePermissionListResult;
        }

        /**
         * Queries impersonated user's permissions on the provided Resources
         *
         * @param ResourceIdentifier[]  $Resource
         * @param string                $Ticket
         * @param string                $ImpersonationUsername
         *
         * @return QueryResourcePermissionsResponse
         */
        public function QueryResourcePermissions( array $Resource, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryResourcePermissionsRequest( $reqTicket, $Resource, $ImpersonationUsername );
            $container             = new QueryResourcePermissions( $req );

            return $this->proxy->QueryResourcePermissions($container)->QueryResourcePermissionsResult;
        }

        /**
         * Queries Presentation Schedules based on provided criteria.
         * If PresentationScheduleQueryCriteria::QueryScheduleBy is QueryScheduleBy::All, paging options must be
         *  provided via the QueryOptions parameter.
         * If PresentationScheduleQueryCriteria::QueryScheduleBy is QueryScheduleBy::ScheduleId, the
         *  PresentationScheduleQueryCriteria::ScheduleId should be provided.
         * If PresentationScheduleQueryCriteria::QueryScheduleBy is QueryScheduleBy::RecorderPhysicalAddress, the
         *  PresentationScheduleQueryCriteria::RecorderPhysicalAddress should be provided.
         * If PresentationScheduleQueryCriteria::QueryScheduleBy is QueryScheduleBy::Key, the
         *  PresentationScheduleQueryCriteria::Key should be provided.
         *
         * @param PresentationScheduleQueryCriteria $Criteria
         * @param QueryOptions                      $Options
         * @param string                            $Ticket
         * @param string                            $ImpersonationUsername
         *
         * @return QuerySchedulesByCriteriaResponse
         */
        public function QuerySchedulesByCriteria( PresentationScheduleQueryCriteria $Criteria, QueryOptions $Options = null,
                                                  $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QuerySchedulesByCriteriaRequest( $reqTicket, $Criteria, $Options, $ImpersonationUsername );
            $container             = new QuerySchedulesByCriteria( $req );

            return $this->proxy->QuerySchedulesByCriteria($container)->QuerySchedulesByCriteriaResult;
        }

        /**
         * Queries Mediasite Site Properties
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QuerySitePropertiesResponse
         */
        public function QuerySiteProperties( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QuerySitePropertiesRequest( $reqTicket, $ImpersonationUsername );
            $container             = new QuerySiteProperties( $req );

            return $this->proxy->QuerySiteProperties($container)->QuerySitePropertiesResult;
        }

        /**
         * Queries the requested number of slides from the provided Presentation starting with the provided index
         *
         * @param int    $Count
         * @param string $PresentationId
         * @param int    $StartIndex
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QuerySlidesResponse
         */
        public function QuerySlides( $Count, $PresentationId, $StartIndex, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QuerySlidesRequest( $reqTicket, $Count, $PresentationId, $StartIndex, $ImpersonationUsername );
            $container             = new QuerySlides( $req );

            return $this->proxy->QuerySlides($container)->QuerySlidesResult;
        }

        /**
         * Queries details of the Subfolders of a list of Folder Ids where the impersonated user has the asserted permission
         * If the impersonated user doesn't have the asserted permission for any of the folders, and error is thrown
         *
         * @param bool                      $IncludeAllSubFolders
         * @param string[]                  $ParentFolderIdList
         * @param ResourcePermissionMask    $PermissionMask
         * @param string                    $Ticket
         * @param string                    $ImpersonationUsername
         *
         * @return QuerySubFolderDetailsResponse
         */
        public function QuerySubFolderDetails( $IncludeAllSubFolders, array $ParentFolderIdList, $PermissionMask,
                                               $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QuerySubFolderDetailsRequest( $reqTicket, $IncludeAllSubFolders, $ParentFolderIdList, $PermissionMask,
                $ImpersonationUsername );
            $container             = new QuerySubFolderDetails( $req );

            return $this->proxy->QuerySubFolderDetails($container)->QuerySubFolderDetailsResult;
        }

        /**
         * Queries TimeZone details for a list of TimeZone Ids (integer values as stored in Mediasite)
         * Using an empty array in the TimeZoneCriteria will return all configured TimeZones
         *
         * @param TimeZoneQueryCriteria $Criteria
         * @param string                $Ticket
         * @param string                $ImpersonationUsername
         *
         * @return QueryTimeZonesByCriteriaResponse
         */
        public function QueryTimeZonesByCriteria( TimeZoneQueryCriteria $Criteria, $Ticket = null,
                                                  $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTimeZonesByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryTimeZonesByCriteria( $req );

            return $this->proxy->QueryTimeZonesByCriteria($container)->QueryTimeZonesByCriteriaResult;
        }

        /**
         * Removes an auth ticket created by CreateAuthTicket
         *
         * @param string $AuthTicket
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return RemoveAuthTicketResponse
         */
        public function RemoveAuthTicket( $AuthTicket, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new RemoveAuthTicketRequest( $reqTicket, $AuthTicket, $ImpersonationUsername );
            $container             = new RemoveAuthTicket( $req );

            return $this->proxy->RemoveAuthTicket($container)->RemoveAuthTicketResult;
        }

        /**
         * Removes the provided Identity Ticket
         * It is possible to remove the Identity ticket of the requesting user
         *
         * @param string $IdentityTicket
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return RemoveIdentityTicketResponse
         * @since 6.0
         */
        public function RemoveIdentityTicket( $IdentityTicket, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new RemoveIdentityTicketRequest( $reqTicket, $IdentityTicket, $ImpersonationUsername );
            $container             = new RemoveIdentityTicket( $req );

            return $this->proxy->RemoveIdentityTicket($container)->RemoveIdentityTicketResult;
        }

        /**
         * Test API connection
         *
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return TestResponse
         */
        public function Test( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new TestRequest( $reqTicket, $ImpersonationUsername );
            $container             = new Test( $req );

            return $this->proxy->Test($container)->TestResult;
        }

        /**
         * Search for Mediasite entities based on provided citeria
         *
         * @param SupportedSearchField[]        $Fields
         * @param string                        $SearchText
         * @param SupportedSearchType[]         $Types
         * @param QueryOptions                  $Options
         * @param string                        $Id
         * @param string                        $Ticket
         * @param string                        $ImpersonationUsername
         *
         * @return SearchResponse
         */
        public function Search( array $Fields, $SearchText, array $Types, $Options, $DisableCaptionHighlighting = null, $DisableOcrHighlighting = null, $Id = null, $Ticket = null,
                                $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new SearchRequest( $reqTicket, $Fields, $SearchText, $Types, $Options, $DisableCaptionHighlighting, $DisableOcrHighlighting, $Id, $ImpersonationUsername );
            $container             = new Search( $req );

            return $this->proxy->Search($container)->SearchResult;
        }

        /**
         * @param UpdateScheduleDetails $Schedule
         * @param string                $Ticket
         * @param string                $ImpersonationUsername
         *
         * @return UpdateScheduleResponse
         */
        public function UpdateSchedule( UpdateScheduleDetails $Schedule, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdateScheduleRequest( $reqTicket, $Schedule, $ImpersonationUsername );
            $container             = new UpdateSchedule( $req );

            return $this->proxy->UpdateSchedule($container)->UpdateScheduleResult;
        }

        /**
         * Updates a given Presentation based on the provided Presentation Details
         *
         * @param string                    $PresentationId
         * @param PresentationUpdateDetails $Details
         * @param string                    $Ticket
         * @param string                    $ImpersonationUsername
         *
         * @return UpdatePresentationDetailsResponse
         */
        public function UpdatePresentationDetails( $PresentationId, PresentationUpdateDetails $Details, $Ticket = null,
                                                   $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdatePresentationDetailsRequest( $reqTicket, $PresentationId, $Details, $ImpersonationUsername );
            $container             = new UpdatePresentationDetails( $req );

            return $this->proxy->UpdatePresentationDetails($container)->UpdatePresentationDetailsResult;
        }

        /**
         * Queries Role details from a provided list of Role Ids
         *
         * @param string|string[] $RoleIdList must be GUID-formatted
         * @param string          $Ticket
         * @param string          $ImpersonationUsername
         *
         * @return QueryRolesByIdResponse
         * @since 6.0
         */
        public function QueryRolesById( array $RoleIdList, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryRolesByIdRequest( $reqTicket, $RoleIdList, $ImpersonationUsername );
            $container             = new QueryRolesById( $req );

            return $this->proxy->QueryRolesById($container)->QueryRolesByIdResult;
        }

        /**
         * Queries Role details based on provided criteria.
         * If the criteria parameters do not represent the same role, no results will be returned.
         *
         * @param RoleQueryCriteria $Criteria
         * @param string            $Ticket
         * @param string            $ImpersonationUsername
         *
         * @return QueryRolesByCriteriaResponse
         */
        public function QueryRolesByCriteria( RoleQueryCriteria $Criteria, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryRolesByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryRolesByCriteria( $req );

            return $this->proxy->QueryRolesByCriteria($container)->QueryRolesByCriteriaResult;
        }

        /*  final 6.0.2methods  */

        /**
         *  Irretrievably deletes the requested Role
         *
         * @param string $Id GUID-formatted
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         * @since 6.0
         */
        public function DeleteRole( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteRole( $req );

            return $this->proxy->DeleteRole($container)->DeleteRoleResult;
        }

        /**
         * Recycles the requested Catalog
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeleteCatalog( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteCatalog( $req );

            return $this->proxy->DeleteCatalog($container)->DeleteCatalogResult;
        }

        /**
         * Recycles the requested Schedule
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeleteSchedule( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteSchedule( $req );

            return $this->proxy->DeleteSchedule($container)->DeleteScheduleResult;
        }

        /**
         * Recycles the requested Presentation
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeletePresentation( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeletePresentation( $req );

            return $this->proxy->DeletePresentation($container)->DeletePresentationResult;
        }

        /**
         * Recycles the requested Player
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeletePlayer( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeletePlayer( $req );

            return $this->proxy->DeletePlayer($container)->DeletePlayerResult;
        }

        /**
         * Recycles the requested PresentationTemplate
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeletePresentationTemplate( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeletePresentationTemplate( $req );

            return $this->proxy->DeletePresentationTemplate($container)->DeletePresentationTemplateResult;
        }

        /**
         * Recycles the requested Podcast
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeletePodcast( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeletePodcast( $req );

            return $this->proxy->DeletePodcast($container)->DeletePodcastResult;
        }

        /**
         * Recycles the requested MediaImportProject
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeleteMediaImportProject( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteMediaImportProject( $req );

            return $this->proxy->DeleteMediaImportProject($container)->DeleteMediaImportProjectResult;
        }

        /**
         * Recycles the requested ContentEncodingSettings
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeleteContentEncodingSettings( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteContentEncodingSettings( $req );

            return $this->proxy->DeleteContentEncodingSettings($container)->DeleteContentEncodingSettingsResult;
        }

        /**
         * Recycles the requested Content Server
         *
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return DeleteResponse
         */
        public function DeleteContentServer( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new DeleteContentServer( $req );

            return $this->proxy->DeleteContentServer($container)->DeleteContentServerResult;
        }

        /**
         * Queries for details of catalogs from the provided list of Ids to which the impersonated user has the specified permissions
         *
         * @param string[]                  $CatalogIdList
         * @param ResourcePermissionMask[]  $PermissionMask defaults to Read
         * @param string                    $Ticket
         * @param string                    $ImpersonationUsername
         *
         * @return QueryCatalogsByIdResponse
         */
        public function QueryCatalogsById( $CatalogIdList, $PermissionMask = array( ResourcePermissionMask::Read ), $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryCatalogsByIdRequest( $reqTicket, $CatalogIdList, $PermissionMask, $ImpersonationUsername );
            $container             = new QueryCatalogsById( $req );

            return $this->proxy->QueryCatalogsById($container)->QueryCatalogsByIdResult;
        }

        /**
         * Creates a Catalog from the provided folder details
         *
         * @param CreateCatalogFromFolderDetails $CreateDetails
         * @param string                         $Ticket
         * @param string                         $ImpersonationUsername
         *
         * @return CreateCatalogFromFolderResponse
         */
        public function CreateCatalogFromFolder( CreateCatalogFromFolderDetails $CreateDetails, $Ticket = null,
                                                 $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateCatalogFromFolderRequest( $reqTicket, $CreateDetails, $ImpersonationUsername );
            $container             = new CreateCatalogFromFolder( $req );

            return $this->proxy->CreateCatalogFromFolder($container)->CreateCatalogFromFolderResult;
        }

        /**
         * Creates a copy (Like) Player from the provided player details
         *
         * @param CreatePlayerLikeDetails $CreateDetails
         * @param string                  $Ticket
         * @param string                  $ImpersonationUsername
         *
         * @return CreatePlayerLikeResponse
         */
        public function CreatePlayerLike( CreatePlayerLikeDetails $CreateDetails, $Ticket = null,
                                          $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePlayerLikeRequest( $reqTicket, $CreateDetails, $ImpersonationUsername );
            $container             = new CreatePlayerLike( $req );

            return $this->proxy->CreatePlayerLike($container)->CreatePlayerLikeResult;
        }

        /**
         * Updates permissions on a set of resources based on the supplied UpdateResourcePermissionsDetails
         * Updating Folder permissions is unsupported in Mediasite 6.0.2
         *
         * @param UpdateResourcePermissionsDetails $PermissionDetails
         * @param string                           $Ticket
         * @param string                           $ImpersonationUsername
         *
         * @return UpdateResourcePermissionsResponse UpdateResourcePermissionsResponse
         */
        public function UpdateResourcePermissions( UpdateResourcePermissionsDetails $PermissionDetails, $Ticket = null,
                                                   $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdateResourcePermissionsRequest( $reqTicket, $PermissionDetails, $ImpersonationUsername );
            $container             = new UpdateResourcePermissions( $req );

            return $this->proxy->UpdateResourcePermissions($container)->UpdateResourcePermissionsResult;
        }

        /*  New for 6.1.1   */

        /**
         * Creates User Profiles for an array of UserProfileCreateDetails
         *
         * @param UserProfileCreateDetails[] $UserProfileDetails
         * @param string                     $Ticket
         * @param string                     $ImpersonationUsername
         *
         * @return CreateUserProfilesResponse
         * @since 6.0
         */
        public function CreateUserProfiles( array $UserProfileDetails, $Ticket = null,
                                            $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateUserProfilesRequest( $reqTicket, $UserProfileDetails, $ImpersonationUsername );
            $container             = new CreateUserProfiles( $req );

            return $this->proxy->CreateUserProfiles($container)->CreateUserProfilesResult;
        }

        /**
         * Create user profiles from an array of email addresses
         * These profiles are created without usernames
         *
         * @param string[]   $EmailAddresses
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return CreateUserProfilesFromEmailsResponse
         */
        public function CreateUserProfilesFromEmails( array $EmailAddresses, $Ticket = null,
                                                      $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateUserProfilesFromEmailsRequest( $reqTicket, $EmailAddresses, $ImpersonationUsername );
            $container             = new CreateUserProfilesFromEmails( $req );

            return $this->proxy->CreateUserProfilesFromEmails($container)->CreateUserProfilesFromEmailsResult;
        }

        /**
         * Query user profiles by array of ids
         *
         * @param string[]   $UserProfileIdList
         * @param string     $Ticket
         * @param string     $ImpersonationUserName
         *
         * @return QueryUserProfilesByIdResponse
         */
        public function QueryUserProfilesById( array $UserProfileIdList, $Ticket = null,
                                               $ImpersonationUserName = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryUserProfilesByIdRequest( $reqTicket, $UserProfileIdList, $ImpersonationUsername );
            $container             = new QueryUserProfilesById( $req );

            return $this->proxy->QueryUserProfilesById($container)->QueryUserProfilesByIdResult;
        }

        /**
         * Query user profiles by configured criteria
         * Criteria are additive - profiles only returned if they match all configured criteria
         *
         * @param UserProfileQueryCriteria   $Criteria
         * @param string                     $Ticket
         * @param string                     $ImpersonationUsername
         *
         * @return QueryUserProfilesByCriteriaResponse
         */
        public function QueryUserProfilesByCriteria( UserProfileQueryCriteria $Criteria, $Ticket = null,
                                                     $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryUserProfilesByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryUserProfilesByCriteria( $req );

            return $this->proxy->QueryUserProfilesByCriteria($container)->QueryUserProfilesByCriteriaResult;

        }

        /**
         * Update user profiles from UserProfileUpdateDetails
         *
         * @param UserProfileUpdateDetails[]   $Details
         * @param string                       $Ticket
         * @param string                       $ImpersonationUsername
         *
         * @return UpdateUserProfilesResponse
         */
        public function UpdateUserProfiles( array $Details, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdateUserProfilesRequest( $reqTicket, $Details, $ImpersonationUsername );
            $container             = new UpdateUserProfiles( $req );

            return $this->proxy->UpdateUserProfiles($container)->UpdateUserProfilesResult;
        }

        /**
         * Check status of a job in the system
         *
         * @param string     $JobId
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return CheckJobStatusResponse
         */
        public function CheckJobStatus( $JobId, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CheckJobStatusRequest( $reqTicket, $JobId, $ImpersonationUsername );
            $container             = new CheckJobStatus( $req );

            return $this->proxy->CheckJobStatus($container)->CheckJobStatusResult;
        }

        /**
         * Add tag to a mediasite object
         *
         * @param string     $Id
         * @param string     $TagName
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return mixed
         */
        public function AddTagToMediasiteObject( $Id, $TagName, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new AddTagToMediasiteObjectRequest( $reqTicket, $Id, $TagName, $ImpersonationUsername );
            $container             = new AddTagToMediasiteObject( $req );

            return $this->proxy->AddTagToMediasiteObject($container)->AddTagToMediasiteObjectResult;
        }

        /**
         * @param string     $Id
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return QueryTagsByMediasiteIdResponse
         */
        public function QueryTagsByMediasiteId( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new AddTagToMediasiteObjectRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new QueryTagsByMediasiteId( $req );

            return $this->proxy->QueryTagsByMediasiteId($container)->QueryTagsByMediasiteIdResult;
        }

        /**
         * @param      $Id
         * @param      $TagName
         * @param null $Ticket
         * @param null $ImpersonationUsername
         *
         * @return RemoveTagFromMediasiteObjectResponse
         */
        public function RemoveTagFromMediasiteObject( $Id, $TagName, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new RemoveTagFromMediasiteObjectRequest( $reqTicket, $Id, $TagName, $ImpersonationUsername );
            $container             = new RemoveTagFromMediasiteObject( $req );

            return $this->proxy->RemoveTagFromMediasiteObject($container);
        }

        /**
         * @param CreateTemplateLikeDetails     $Details
         * @param string                        $Ticket
         * @param string                        $ImpersonationUsername
         *
         * @return CreateTemplateLikeResponse
         */
        public function CreateTemplateLike( $Details, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateTemplateLikeRequest( $reqTicket, $Details, $ImpersonationUsername );
            $container             = new CreateTemplateLike( $req );

            return $this->proxy->CreateTemplateLike($container)->CreateTemplateLikeResult;
        }

        /**
         * @param MediasiteKeyValue $KeyValue
         * @param string            $Ticket
         * @param string            $ImpersonationUsername
         *
         * @return CreateMediasiteKeyValueResponse
         * TODO:    use typemapping to hoist the result property
         */
        public function CreateMediasiteKeyValue( $KeyValue, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreateMediasiteKeyValueRequest( $reqTicket, $KeyValue, $ImpersonationUsername );
            $container             = new CreateMediasiteKeyValue( $req );

            return $this->proxy->CreateMediasiteKeyValue($container)->CreateMediasiteKeyValueResult;
        }

        /**
         * @param string $Id
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryMediasiteKeyValueByIdResponse
         * TODO:    use typemapping to hoist the result property
         */
        public function QueryMediasiteKeyValuesById( $Id, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryMediasiteKeyValueByIdRequest( $reqTicket, $Id, $ImpersonationUsername );
            $container             = new QueryMediasiteKeyValuesById( $req );

            return $this->proxy->QueryMediasiteKeyValuesById($container)->QueryMediasiteKeyValuesByIdResult;
        }

        /**
         * @param string $Id
         * @param string $Key
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryMediasiteKeyValueByIdAndKeyResponse
         */
        public function QueryMediasiteKeyValuesByIdAndKey( $Id, $Key, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryMediasiteKeyValueByIdAndKeyRequest( $reqTicket, $Id, $Key, $ImpersonationUsername );
            $container             = new QueryMediasiteKeyValuesByIdAndKey( $req );

            return $this->proxy->QueryMediasiteKeyValuesByIdAndKey($container)->QueryMediasiteKeyValuesByIdAndKeyResult;
        }

        /**
         * @param string     $Id
         * @param string     $Key
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return void
         */
        public function DeleteMediasiteKeyValueByIdAndKey( $Id, $Key, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteMediasiteKeyValueByIdAndKeyRequest( $reqTicket, $Id, $Key, $ImpersonationUsername );
            $container             = new DeleteMediasiteKeyValueByIdAndKey( $req );

            $this->proxy->DeleteMediasiteKeyValueByIdAndKey($container);
        }

        /**
         * @param string $KeyValue
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryMediasiteKeyValueByKeyValueResponse
         */
        public function QueryMediasiteKeyValuesByKeyValue( $KeyValue, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryMediasiteKeyValueByKeyValueRequest( $reqTicket, $KeyValue, $ImpersonationUsername );
            $container             = new QueryMediasiteKeyValuesByKeyValue( $req );

            return $this->proxy->QueryMediasiteKeyValuesByKeyValue($container)->QueryMediasiteKeyValuesByKeyValueResult;
        }

        /**
         * @param string     $KeyValue
         * @param string     $Ticket
         * @param string     $ImpersonationUsername
         *
         * @return void
         */
        public function DeleteMediasiteKeyValueByKeyValue( $KeyValue, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeleteMediasiteKeyValueByKeyValueRequest( $reqTicket, $KeyValue, $ImpersonationUsername );
            $container             = new DeleteMediasiteKeyValueByKeyValue( $req );

            $this->proxy->DeleteMediasiteKeyValueByKeyValue($container);
        }

        /**
         * @param string[]         $Ids
         * @param string           $Key
         * @param string           $NewValue
         * @param string           $Ticket
         * @param string           $ImpersonationUsername
         *
         * @return void
         */
        public function UpdateMediasiteKeyValueByIdsAndKey( $Ids, $Key, $NewValue, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdateMediasiteKeyValueByIdsAndKeyRequest( $reqTicket, $Ids, $Key, $NewValue, $ImpersonationUsername );
            $container             = new UpdateMediasiteKeyValueByIdsAndKey( $req );
            $this->proxy->UpdateMediasiteKeyValueByIdsAndKey($container);
        }

        /**
         * @param UpdatePlayerDetails   $PlayerDetails
         * @param string                $Ticket
         * @param string                $ImpersonationUsername
         *
         * @return UpdatePlayerResponse
         */
        public function UpdatePlayer( $PlayerDetails, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdatePlayerRequest( $reqTicket, $PlayerDetails, $ImpersonationUsername );
            $container             = new UpdatePlayer( $req );

            return $this->proxy->UpdatePlayer($container);
        }

        /**
         * @param string                               $PresentationContentId
         * @param string                               $PresentationId
         * @param PresentationContentUpdateDetails     $UpdateDetails
         * @param string                               $Ticket
         * @param string                               $ImpersonationUsername
         *
         * @return UpdatePresentationContentDetailsResponse
         * @since   6.1.5
         */
        public function UpdatePresentationContentDetails( $PresentationContentId, $PresentationId, $UpdateDetails, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UpdatePresentationContentDetailsRequest( $reqTicket, $PresentationContentId, $PresentationId, $UpdateDetails, $ImpersonationUsername );
            $container             = new UpdatePresentationContentDetails( $req );

            return $this->proxy->UpdatePresentationContentDetails($container);
        }

        /**
         * @param string                               $PresentationContentId
         * @param string                               $PresentationId
         * @param string                               $Ticket
         * @param string                               $ImpersonationUsername
         *
         * @return DeletePresentationContentResponse
         * @since   6.1.5
         */
        public function DeletePresentationContent( $PresentationContentId, $PresentationId, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new DeletePresentationContentRequest( $PresentationContentId, $PresentationId, $Ticket, $ImpersonationUsername );
            $container             = new DeletePresentationContent( $req );

            return $this->proxy->DeletePresentationContent($container);
        }

        /**
         * @param string                   $Id
         * @param AnalyticsRequestType     $RequestType
         * @param AnalyticsRequestType     $ChildType
         * @param QueryOptions             $Options
         * @param string                   $Ticket
         * @param string                   $ImpersonationUsername
         *
         * @return QueryPresentationUsageByIdResponse
         * @since   6.1.5
         */
        public function QueryPresentationUsageById( $Id, $RequestType, $ChildType, $Options = null, $Ticket = null, $ImpersonationUsername = null ) {

            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationUsageByIdRequest( $reqTicket, $Id, $RequestType, $ChildType, $Options, $ImpersonationUsername );
            $container             = new QueryPresentationUsageById( $req );

            return $this->proxy->QueryPresentationUsageById($container)->QueryPresentationUsageByIdResult;
        }

        /**
         * @param UserProfileQueryCriteria $Criteria
         * @param string                   $Ticket
         * @param string                   $ImpersonationUsername
         *
         * @return QueryUserProfileDetailsByCriteriaResponse
         * @since   6.1.5
         */
        public function QueryUserProfileDetailsByCriteria( $Criteria, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryUserProfileDetailsByCriteriaRequest( $reqTicket, $Criteria, $ImpersonationUsername );
            $container             = new QueryUserProfileDetailsByCriteria( $req );

            return $this->proxy->QueryUserProfileDetailsByCriteria($container)->QueryUserProfileDetailsByCriteriaResult;
        }

        /**
         * @param string[]                 $UserProfileIdList
         * @param string                   $Ticket
         * @param string                   $ImpersonationUsername
         *
         * @return QueryUserProfileDetailsByIdResponse
         * @since   6.1.5
         */
        public function QueryUserProfileDetailsById( $UserProfileIdList, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryUserProfileDetailsByIdRequest( $reqTicket, $UserProfileIdList, $ImpersonationUsername );
            $container             = new QueryUserProfileDetailsById( $req );

            return $this->proxy->QueryUserProfileDetailsById($container)->QueryUserProfileDetailsByIdResult;
        }

        /**
         * @param string $Id
         * @param string $Key
         * @param string $Value
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return QueryMediasiteKeyValuesByCriteriaResponse
         * @since   6.1.5
         */
        public function QueryMediasiteKeyValuesByCriteria( $Id = null, $Key = null, $Value = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryMediasiteKeyValuesByCriteriaRequest( $reqTicket, $Id, $Key, $Value, $ImpersonationUsername );
            $container             = new QueryMediasiteKeyValuesByCriteria( $req );

            return $this->proxy->QueryMediasiteKeyValuesByCriteria($container)->QueryMediasiteKeyValuesByCriteriaResult;
        }

        /**
         * @param string     $Name
         * @param int        $Order
         * @param string     $PresentationId
         * @param string     $Url
         * @param string     $ImpersonationUsername
         * @param string     $Ticket
         *
         * @return CreatePresentationExternalLinkResponse
         * @since   6.1.5
         */
        public function CreatePresentationExternalLink( $Name, $Order, $PresentationId, $Url, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePresentationExternalLinkRequest( $reqTicket, $Name, $Order, $PresentationId, $Url, $ImpersonationUsername );
            $container             = new CreatePresentationExternalLink( $req );

            return $this->proxy->CreatePresentationExternalLink($container);
        }

        /**
         * @param string $PresentationTitle
         * @param string $PresentationDescription
         * @param string $ParentFolderId
         * @param string $Ticket
         * @param string $ImpersonationUsername
         *
         * @return CreatePresentationForMediaUploadResponse
         * @since   6.1.5
         */
        public function CreatePresentationForMediaUpload( $PresentationTitle, $PresentationDescription = null, $ParentFolderId = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePresentationForMediaUploadRequest( $reqTicket, $PresentationTitle, $PresentationDescription, $ParentFolderId, $ImpersonationUsername );
            $container             = new CreatePresentationForMediaUpload( $req );

            return $this->proxy->CreatePresentationForMediaUpload($container)->CreatePresentationForMediaUploadResult;
        }

        /**
         * @param string                            $FileName
         * @param string                            $PresentationId
         * @param MediaUploadTranscodeOptionDetails $TranscodeOption
         * @param int                               $ContentId
         * @param string                            $Ticket
         * @param string                            $ImpersonationUsername
         *
         * @return CreateMediaUploadResponse
         * @since   6.1.5
         */
        public function CreateMediaUpload( $FileName, $PresentationId, $TranscodeOption, $ContentId = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new UploadMediaRequest( $reqTicket, $FileName, $PresentationId, $TranscodeOption, $ContentId, $ImpersonationUsername );
            $container             = new CreateMediaUpload( $req );

            return $this->proxy->CreateMediaUpload($container);
        }

        /**
         * @param null $Ticket
         * @param null $ImpersonationUsername
         *
         * @return RefreshReportDataResponse
         * @since 6.1.7
         */
        public function RefreshReportData( $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new RefreshReportDataRequest( $reqTicket, $ImpersonationUsername );
            $container             = new RefreshReportData( $req );

            return $this->proxy->RefreshReportData($container)->RefreshReportDataResult;
        }

        /**
         * CreateRegistration
         *
         * @param RegistrationDetails Details
         *
         * @return CreateRegistrationResponse
         * @since 6.1.11
         */
        public function CreateRegistration( $Details = null, $Ticket = null, $ImpersonationUsername = null ) {
                $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
                $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
                $req                   = new CreateRegistrationRequest( $reqTicket, $Details, $ImpersonationUsername );
                $container             = new CreateRegistration ( $req );

                return $this->proxy->CreateRegistration($container)->CreateRegistrationResult;

        }

        /**
         * DisableRegistration
         *
         * @param string ResourceId
         *
         * @return DisableRegistrationResponse
         * @since 6.1.11
         */
        public function DisableRegistration($ResourceId = null, $Ticket = null, $ImpersonationUsername = null)
        {
            $reqTicket = isset($Ticket) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset($ImpersonationUsername) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req = new DisableRegistrationRequest($reqTicket, $ResourceId, $ImpersonationUsername);
            $container = new DisableRegistration ($req);

            return $this->proxy->DisableRegistration($container)->DisableRegistrationResult;

        }

        /**
         * AddRegistrantsToResource
         *
         * @param ResourceRegistrationDetail[] RegistrationDetails
         *
         * @return AddRegistrantsToResourceResponse
         * @since 6.1.11
         */
        public function AddRegistrantsToResource( $RegistrationDetails = null, $Ticket = null, $ImpersonationUsername = null ) {
                $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
                $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
                $req                   = new AddRegistrantsToResourceRequest( $reqTicket, $RegistrationDetails, $ImpersonationUsername );
                $container             = new AddRegistrantsToResource ( $req );

                return $this->proxy->AddRegistrantsToResource($container)->AddRegistrantsToResourceResult;

        }

        /**
         * RemoveRegistrantsFromResource
         *
         * @param ResourceRegistrationDetail[] RegistrationDetails
         *
         * @return RemoveRegistrantsFromResourceResponse
         * @since 6.1.11
         */
        public function RemoveRegistrantsFromResource( $RegistrationDetails = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new RemoveRegistrantsFromResourceRequest( $reqTicket, $RegistrationDetails, $ImpersonationUsername );
            $container             = new RemoveRegistrantsFromResource ( $req );

            return $this->proxy->RemoveRegistrantsFromResource($container)->RemoveRegistrantsFromResourceResult;

        }

        /**
         * QueryResourceRegistrants
         *
         * @param string ResourceId
         *
         * @return QueryResourceRegistrantsResponse
         * @since 6.1.11
         */
        public function QueryResourceRegistrants($ResourceId = null, $Ticket = null, $ImpersonationUsername = null)
        {
            $reqTicket = isset($Ticket) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset($ImpersonationUsername) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req = new QueryResourceRegistrantsRequest( $reqTicket, $ResourceId, $ImpersonationUsername );
            $container = new QueryResourceRegistrants ($req);

            return $this->proxy->QueryResourceRegistrants($container)->QueryResourceRegistrantsResult;

        }

        /**
         * CreateMp3Content
         *
         * @param int AudioBitRate
         * @param string PresentationId
         *
         * @return CreateMp3ContentResponse
         * @since 6.1.11
         */
        public function CreateMp3Content($AudioBitRate, $PresentationId = null, $Ticket = null, $ImpersonationUsername = null)
        {
            $reqTicket = isset($Ticket) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset($ImpersonationUsername) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req = new CreateMp3ContentRequest( $reqTicket, $AudioBitRate, $PresentationId, $ImpersonationUsername );
            $container = new CreateMp3Content ($req);

            return $this->proxy->CreateMp3Content($container)->CreateMp3ContentResult;

        }

        /**
         * CreateMediaImportProject
         *
         * @param CreateMediaImportProjectDetails CreateDetails
         *
         * @return CreateMediaImportProjectResponse
         * @since 6.1.11
         */
        public function CreateMediaImportProject($CreateDetails = null, $Ticket = null, $ImpersonationUsername = null)
        {
            $reqTicket = isset($Ticket) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset($ImpersonationUsername) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req = new CreateMediaImportProjectRequest( $reqTicket, $CreateDetails, $ImpersonationUsername );
            $container = new CreateMediaImportProject ($req);

            return $this->proxy->CreateMediaImportProject($container)->CreateMediaImportProjectResult;

        }

        /**
         * QueryContentImportProjectProgress
         *
         * @param string[] FileNames
         * @param string MediaImportProjectId
         *
         * @return QueryContentImportProjectProgressResponse
         * @since 6.1.11
         */
        public function QueryContentImportProjectProgress($FileNames = null, $MediaImportProjectId = null, $Ticket = null, $ImpersonationUsername = null)
        {
            $reqTicket = isset($Ticket) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset($ImpersonationUsername) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req = new QueryContentImportProjectProgressRequest( $reqTicket, $FileNames, $MediaImportProjectId, $ImpersonationUsername );
            $container = new QueryContentImportProjectProgress ($req);

            return $this->proxy->QueryContentImportProjectProgress($container)->QueryContentImportProjectProgressResult;

        }

		/**
		 * QueryPresentationViewingTrends
		 *
		 * @param string ClientId
		 * @param QueryOptions Options
		 * @param string PresentationId
		 * @param AnalyticsRequestType RequestType
		 *
		 * @return QueryPresentationViewingTrendsResponse
		 * @since 6.1.11
		 */
		public function QueryPresentationViewingTrends( $ClientId = null, $Options = null, $PresentationId = null, $RequestType, $Ticket = null, $ImpersonationUsername = null ) {
			$reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
			$req                   = new QueryPresentationViewingTrendsRequest( $reqTicket, $ClientId, $Options, $PresentationId, $RequestType, $ImpersonationUsername );
			$container             = new QueryPresentationViewingTrends ( $req );

			return $this->proxy->QueryPresentationViewingTrends($container)->QueryPresentationViewingTrendsRequest;

		}

        /**
         *  * QueryPresentationViewingTrendsResponse
         *  *
         * @param int Duration
         * @param int MinViewLength
         * @param QueryResults Results
         * @param SegmentViews[] SegmentViewsList
         *
         * @return QueryPresentationViewingTrendsResponseResponse
         * @since 6.1.13
         */
        public function QueryPresentationViewingTrendsResponse( $Duration, $MinViewLength, $Results = null, $SegmentViewsList = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryViewingTrendsResponse( $reqTicket, $Duration, $MinViewLength, $Results, $SegmentViewsList, $ImpersonationUsername );
            $container             = new QueryPresentationViewingTrendsResponse ( $req );

            return $this->proxy->QueryPresentationViewingTrendsResponse($container)->QueryViewingTrendsResponse;

        }

        /**
		 * QueryPresentationViewingSessions
		 *
		 * @param string ClientId
		 * @param QueryOptions Options
		 * @param string PresentationId
		 * @param AnalyticsRequestType RequestType
		 *
		 * @return QueryPresentationViewingSessionsResponse
		 * @since 6.1.11
		 */
		public function QueryPresentationViewingSessions( $ClientId = null, $Options = null, $PresentationId = null, $RequestType, $Ticket = null, $ImpersonationUsername = null ) {
			$reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
			$req                   = new QueryPresentationViewingSessionsRequest( $reqTicket, $ClientId, $Options, $PresentationId, $RequestType, $ImpersonationUsername );
			$container             = new QueryPresentationViewingSessions ( $req );

			return $this->proxy->QueryPresentationViewingSessions($container)->QueryPresentationViewingSessionsResult;

		}
        /**
         *  CreatePublishToGoContent
         *
         * @param string ContentServerId
         * @param string PresentationId
         *
         * @return CreatePublishToGoContentResponse
         * @since 6.1.13
         */
         public function CreatePublishToGoContent( $ContentServerId = null, $PresentationId = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new CreatePublishToGoContentRequest( $reqTicket, $ContentServerId, $PresentationId, $ImpersonationUsername );
            $container             = new CreatePublishToGoContent ( $req );

            return $this->proxy->CreatePublishToGoContent($container)->CreatePublishToGoContentResult;

         }
        /**
         *  QueryUserViews
         *
         * @param string[] UserIdList
         * @param QueryOptions Options
         *
         * @return QueryUserViewsResponse
         * @since 6.1.13
         * @example ExternalAccessClientTest.php 2053 3
         */
        public function QueryUserViews($UserIdList = null, $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTotalViewsRequest($reqTicket, $UserIdList, AnalyticsRequestType::User, $Options, $ImpersonationUsername);
            $container             = new QueryTotalViews ( $req );
            return $this->proxy->QueryTotalViews($container)->QueryTotalViewsResult;
        }
        /**
         *  QueryUserPresentationViews
         *
         * @param string UserId
         * @param QueryOptions Options
         *
         * @return QueryUserPresentationViewsResponse
         * @since 6.1.13
         * @example ExternalAccessClientTest.php 2062 3
         */
        public function QueryUserPresentationViews($UserId = null, $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTotalViewsByIdRequest($reqTicket, $UserId, AnalyticsRequestType::User, AnalyticsRequestType::Presentation, $Options, $ImpersonationUsername);
            $container             = new QueryTotalViewsById ( $req );
            return $this->proxy->QueryTotalViewsById($container)->QueryTotalViewsByIdResult;
        }
        /**
         *  QueryUserIpAddressViews
         *
         * @param string UserId
         * @param QueryOptions Options
         *
         * @return QueryUserIpAddressViewsResponse
         * @since 6.1.13
         * @example ExternalAccessClientTest.php 2071 3
         */
        public function QueryUserIpAddressViews($UserId = null, $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryTotalViewsByIdRequest($reqTicket, $UserId, AnalyticsRequestType::User, AnalyticsRequestType::IPAddress, $Options, $ImpersonationUsername);
            $container             = new QueryTotalViewsById ( $req );
            return $this->proxy->QueryTotalViewsById($container)->QueryTotalViewsByIdResult;
        }
        /**
         *  QueryPresentationIpAddressDetails
         *
         * @param string PresentationId
         * @param QueryOptions Options
         * @param string[] IpAddressList
         *
         * @return QueryPresentationIpAddressDetailsResponse
         * @since 6.1.13
         * @example ExternalAccessClientTest.php 2080 2
         */
        public function QueryPresentationIpAddressDetails($PresentationId = null, $Options = null, $IpAddressList = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationUsageRequest($reqTicket, $IpAddressList, AnalyticsRequestType::IPAddress, $PresentationId, $Options, $ImpersonationUsername);
            $container             = new QueryPresentationUsage ( $req );
            return $this->proxy->QueryPresentationUsage($container)->QueryPresentationUsageResult;
        }
        /**
         *  QueryUserPresentationDetails
         *
         * @param string UserId
         * @param QueryOptions Options
         *
         * @return QueryUserPresentationDetailsResponse
         * @since 6.1.13
         * @example ExternalAccessClientTest.php 2088 3
         */
        public function QueryUserPresentationDetails($UserId = null, $Options = null, $Ticket = null, $ImpersonationUsername = null ) {
            $reqTicket             = isset( $Ticket ) ? $Ticket : $this->Ticket;
            $ImpersonationUsername = isset( $ImpersonationUsername ) ? $ImpersonationUsername : $this->ImpersonationUsername;
            $req                   = new QueryPresentationUsageByIdRequest($reqTicket, $UserId, AnalyticsRequestType::User, AnalyticsRequestType::Presentation, $Options, $ImpersonationUsername);
            $container             = new QueryPresentationUsageById ( $req );
            $result = $this->proxy->QueryPresentationUsageById($container);
            return $result->QueryPresentationUsageByIdResult;
        }

}
