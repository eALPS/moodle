<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 3/22/14
 * Time: 10:33 AM
 */

namespace Sonicfoundry;


interface iMediasiteClient {
    /**
     * @return string|null
     */
    function get_apikey();
    /**
     * @param bool $verbose
     * @return string|null
     */
    function Version();
    /**
     * Returns a SiteProperties class that contains various site properties
     * The most useful is the SiteVersion property that indicates the site version
     * @param bool $verbose
     * @return \Sonicfoundry\SiteProperties
     */
    function QuerySiteProperties();
    /**
     * Searches the catalog shares on a site given the supplied criteria.
     * @param string $searchOptions - Either a string or a SearchOptions class
     * @param $limit - Limit the results returned.
     * @param bool $verbose
     * @return \Sonicfoundry\Catalog[]
     */
    function QueryCatalogShares($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0);
    /**
     * Searches the presentations on the site given the supplied search criteria
     * @param string $searchOptions - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $limit - Limit the results returned.
     * @param bool $verbose
     * @return \Sonicfoundry\Presentation[]
     */
    function QueryPresentations($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0);
    /**
     * @param string $searchText - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $limit - Limit the results returned.
     * @param bool $verbose
     * @return \Sonicfoundry\Folder[]
     */
    function QueryFolders($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0);
    /**
     * @param string[]|$string $resources
     * @param array $properties
     * @param bool $verbose
     * @return mixed
     */
    function ModifyPresentationProperty($resources, $properties);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\Tag[]
     */
    function GetTagsForPresentation($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\Presenter[]
     */
    function GetPresentersForPresentation($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\ThumbnailContent[]
     */
    function GetThumbnailContentForPresentation($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\SlideContent[]
     */
    function GetSlideContentForPresentation($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\LayoutOptions
     */
    function GetLayoutOptionsForPresentation($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param bool $verbose
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function QueryPresentationById($resources);
    /**
     * @param string[]|string $resourceId
     * @param bool $verbose
     * @return string[]|string
     */
    function QueryPresentationPlaybackUrl($resourceId);
    /**
     * @param string[]|string $resourceId
     * @param bool $verbose
     * @return \Sonicfoundry\Catalog[]|\Sonicfoundry\Catalog
     */
    function QueryCatalogById($resourceId);
    /**
     * @param string[]|string $resourceId
     * @param bool $verbose
     * @return \Sonicfoundry\Folder[]|\Sonicfoundry\Folder
     */
    function QueryFolderById($resourceId);
    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @param bool $verbose
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function GetPresentationsForFolder($resources, $queryParameters=null);
    /**
     * @param string[]|string $resources
     * @param array $properties
     * @param bool $verbose
     */
    function ModifyCatalogProperty($resources, $properties);
    /**
     * @param string $username
     * @param string $resourceId
     * @param string $ip
     * @param int $duration
     * @param bool $verbose
     * @return string
     */
    function CreateAuthTicket($username, $resourceId, $ip, $duration);
    /**
     * @param string $resourceId
     * @param bool $verbose
     * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyById($resourceId = '7788acb4-4533-4efd-a6d1-e9c74c025bfe');
    /**
     * @param string $apiname
     * @param bool $verbose
     * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyByName($apiname = "MoodlePlugin");
    /**
     * @param string $apiname
     * @param bool $verbose
     * @return bool|\Sonicfoundry\ApiKey
     */
    function CreateApiKey($apiname = "MoodlePlugin");
    /**
     * @param string $Username
     * @param string $Password
     * @param null|string $ApplicationName
     * @param null|string $ImpersonationUsername
     * @return \LoginResponse
     */
    function Login($Username, $Password, $ApplicationName = null, $ImpersonationUsername = null);
    /**
     * @param null|string $Ticket
     * @param null|string $ImpersonationUsername
     * @return \LogoutResponse
     */
    function Logout($Ticket = null, $ImpersonationUsername = null);

    function QueryPresentationsWithSlides();

} 