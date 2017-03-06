<?php
namespace Sonicfoundry;

require_once(dirname(__FILE__) . '/../../config.php');
global $CFG;
require_once("$CFG->dirroot/mod/mediasite/imediasiteclient.php");
require_once("$CFG->dirroot/mod/mediasite/webapiclient.php");

class WebApiMediasiteClient implements iMediasiteClient {
    private $mediasiteclient;

    /**
     * @access private
     * @param $input
     */
    private function _escapeCharacters($input) {
        if(is_array($input)) {
            return array_map(function($e) {
                return str_replace(array("\"", "'"), '', $e);
            }, $input);
        } else {
            return str_replace(array("\"", "'"), '', $input);
        }
    }
    /**
     * @access private
     * @param $input
     */
    private function _addTitleComparison($input) {
        if(is_array($input)) {
            return '('.implode(' or ',array_map(function($e) {
                return "Title eq '$e'";
            }, $input)).')';
        } else {
            return "(Title eq '$input')";
        }
    }
    /**
     * @access private
     * @param $input
     */
    private function _addNameComparison($input) {
        if(is_array($input)) {
            return '('.implode(' or ',array_map(function($e) {
                return "Name eq '$e'";
            }, $input)).')';
        } else {
            return "(Name eq '$input')";
        }
    }
    /**
     * @access private
     * @param $input
     */
    private function _addDescriptionComparison($input) {
        if(is_array($input)) {
            return '('.implode(' or ', array_map(function($e) {
                return "Description eq '$e'";
            }, $input)).')';
        } else {
            return "(Description eq '$input')";
        }
    }
    /**
     * @access private
     * @param $input
     */
    private function _addTagComparison($input) {
        if(is_array($input)) {
            $tagArray = array();
            foreach($input as $value) {
                array_push($tagArray, $value);
            }
            array_walk($tagArray, function(&$item, $key) {
                $item = "(Tags/any(t$key:t$key/Tag eq '$item'))";
            });
            return '('.implode(' or ', $tagArray).')';
        } else {
            return "(Tags/any(t:t/Tag eq '$input'))";
        }
    }
    /**
     * @access private
     * @param $input
     */
    private function _addPresenterComparison($input) {
        if(is_array($input)) {
            $tagArray = array();
            foreach($input as $value) {
                array_push($tagArray, $value);
            }
            array_walk($tagArray, function(&$item, $key) {
                $item = "(Presenters/any(p$key:p$key/DisplayName eq '$item'))";
            });
            return '('.implode(' or ', $tagArray).')';
        } else {
            return "(Presenters/any(p:p/DisplayName eq '$input'))";
        }
    }
    /**
    * @access private
    * @param $input
    */
    private function _addStartswithTitleComparison($input) {
        return "startswith(Title, '$input')";
    }
    /**
     * @access private
     * @param $input
     */
    private function _addStartswithDescriptionComparison($input) {
        return "startswith(Description, '$input')";
    }
    /**
     * @access private
     * @param $input
     */
    private function _addStartswithTagComparison($input) {
        return "Tags/any(t:startswith(t/Tag, '$input'))";
    }
    /**
     * @access private
     * @param $input
     */
    private function _addStartswithPresenterComparison($input) {
        return "Presenters/any(p:startswith(p/DisplayName, '$input'))";
    }
    /**
     * @access private
     * @param SearchOptions $searchOptions
     * @return string
     */
    private function _presentation_raw_search_filter(SearchOptions $searchOptions, $input) {
        $transformedInput = $this->_escapeCharacters($input);
        $advancedSelection = array();
        if($searchOptions->Name) {
            array_push($advancedSelection, $this->_addTitleComparison($transformedInput));
        }
        if($searchOptions->Description) {
            array_push($advancedSelection, $this->_addDescriptionComparison($transformedInput));
        }
        if($searchOptions->Tag) {
            array_push($advancedSelection, $this->_addTagComparison($transformedInput));
        }
        if($searchOptions->Presenter) {
            array_push($advancedSelection, $this->_addPresenterComparison($transformedInput));
        }
        $searchFilter = '('.implode(' or ', $advancedSelection).')';
        $advancedSelection = array();
        array_push($advancedSelection, $searchFilter);
        $dateSelection = array();
        if($searchOptions->After) {
            array_push($dateSelection, '('.'RecordDate ge datetime\''.$searchOptions->AfterDate.'\')');
        }
        if($searchOptions->Until) {
            array_push($dateSelection, '('.'RecordDate le datetime\''.$searchOptions->UntilDate.'\')');
        }
        if(count($dateSelection) > 0) {
            array_push($advancedSelection, '('.implode(' and ', $dateSelection).')');
        }
        $searchFilter = implode(' and ', $advancedSelection);
        $searchFilter .= ' and '.
            '('.
            'Status eq \'Viewable\''.' or '.
            'Status eq \'Record\''.
            ')';
        return $searchFilter;
    }
    /**
     * @access private
     * @param SearchOptions $searchOptions
     * @return string
     */
    private function _presentation_startswith_filter(SearchOptions $searchOptions, $input) {
        $transformedInput = $this->_escapeCharacters($input);
        $advancedSelection = array();
        if($searchOptions->Name) {
            array_push($advancedSelection, $this->_addStartswithTitleComparison($transformedInput));
        }
        if($searchOptions->Description) {
            array_push($advancedSelection, $this->_addStartswithDescriptionComparison($transformedInput));
        }
        if($searchOptions->Tag) {
            array_push($advancedSelection, $this->_addStartswithTagComparison($transformedInput));
        }
        if($searchOptions->Presenter) {
            array_push($advancedSelection, $this->_addStartswithPresenterComparison($transformedInput));
        }
        $searchFilter = '('.implode(' or ', $advancedSelection).')';
        $advancedSelection = array();
        array_push($advancedSelection, $searchFilter);
        $dateSelection = array();
        if($searchOptions->After) {
            array_push($dateSelection, '('.'RecordDate ge datetime\''.$searchOptions->AfterDate.'\')');
        }
        if($searchOptions->Until) {
            array_push($dateSelection, '('.'RecordDate le datetime\''.$searchOptions->UntilDate.'\')');
        }
        if(count($dateSelection) > 0) {
            array_push($advancedSelection, '('.implode(' and ', $dateSelection).')');
        }
        $searchFilter = implode(' and ', $advancedSelection);
        $searchFilter .= ' and '.
            '('.
            'Status eq \'Viewable\''.' or '.
            'Status eq \'Record\''.
            ')';
        return $searchFilter;
    }
    private function _catalog_raw_search_filter($input) {
        $transformedInput = $this->_escapeCharacters($input);
        $searchFilter = $this->_addNameComparison($transformedInput);  
        return $searchFilter;
    }
    
    function __construct() {
        $arg_list = func_get_args();
        $reflection = new \ReflectionClass('Sonicfoundry\WebApiExternalAccessClient');
        $this->mediasiteclient = $reflection->newInstanceArgs($arg_list);
    }
    /**
     * @return string|null
     */
    function get_apikey() {
        return $this->mediasiteclient->get_apikey();
    }

    /**
     * @return string|null
     */
    function Version() {
        return $this->mediasiteclient->Version();
    }

    /**
     * Returns a SiteProperties class that contains various site properties
     * The most useful is the SiteVersion property that indicates the site version
     * @return \Sonicfoundry\SiteProperties
     */
    function QuerySiteProperties() {
        return $this->mediasiteclient->QuerySiteProperties();
    }

    /**
     * Searches the catalog shares on a site given the supplied criteria.
     * @param string $searchOptions - Either a string or a SearchOptions class
     * @param $limit - Limit the results returned.
     * @param $start - Skip this number of values.
     * @param $result - Results
     * @return true if there are more, false if there are no more
     */
    function QueryCatalogShares($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0) {
        if($searchOptions instanceof SearchOptions) {
            $searchText = urldecode($searchOptions->SearchText); // BUG41284
            if(!is_null($searchText) && !empty($searchText))  {
                $queryParameters  = '$filter=';
                $queryParameters .= rawurlencode($this->_catalog_raw_search_filter($searchText));
                $queryParameters .= '&$orderby=';
                $queryParameters .= rawurlencode('Name asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
            } else {
                $queryParameters  = '$orderby=';
                $queryParameters .= rawurlencode('Name asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
            }
        } else {
            if(is_null($searchOptions) || empty($searchOptions)) {
                $queryParameters  = '$orderby=';
                $queryParameters .= rawurlencode('Name asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
            } else {
                $queryParameters = $searchOptions;
            }
        }
        return $this->mediasiteclient->QueryCatalogShares($queryParameters, $results, $total);
    }

    /**
     * Searches the presentations on the site given the supplied search criteria
     * @param string $searchOptions - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $result - Results
     * @param $total - Total available
     * @param $limit - Limit the results returned.
     * @param $start - Skip this number of values.
     * @return true if there are more, false if there are no more
     */
    function QueryPresentations($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0) {
        if($searchOptions instanceof SearchOptions) {
            $searchText = urldecode($searchOptions->SearchText); // BUG41284
            if(!is_null($searchText) && !empty($searchText))  {
                $queryParameters  = '$filter=';
                $queryParameters .= rawurlencode($this->_presentation_raw_search_filter($searchOptions, $searchText));
                $queryParameters .= '&$orderby=';
                $queryParameters .= rawurlencode('Title asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
                $more = $this->mediasiteclient->QueryPresentations($queryParameters, $results,  $total);
                if(count($results) <= 0) {
                    $regexp = '/\G(?:"[^"]*"|\'[^\']*\'|[^"\'\s]+)*\K\s+/mU';
                    $searchText = preg_split($regexp,$searchText);
                    $queryParameters  = '$filter=';
                    $queryParameters .= rawurlencode($this->_presentation_raw_search_filter($searchOptions, $searchText));
                    $queryParameters .= '&$orderby=';
                    $queryParameters .= rawurlencode('Title asc');
                    $queryParameters .= '&$top='.$limit;
                    $queryParameters .= '&$skip='.$start;
                    $more = $this->mediasiteclient->QueryPresentations($queryParameters, $results, $total);
                    if(count($results) <= 0) {
                        $searchText = $searchOptions->SearchText;
                        $queryParameters  = '$filter=';
                        $queryParameters .= rawurlencode($this->_presentation_startswith_filter($searchOptions, $searchText));
                        $queryParameters .= '&$orderby=';
                        $queryParameters .= rawurlencode('Title asc');
                        $queryParameters .= '&$top='.$limit;
                        $queryParameters .= '&$skip='.$start;
                        $more = $this->mediasiteclient->QueryPresentations($queryParameters, $results, $total);
                    }
                }
                return $more;
            } else {
                $queryParameters  = '$orderby=';
                $queryParameters .= rawurlencode('Title asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
                return $this->mediasiteclient->QueryPresentations($queryParameters, $results, $total);
            }
        } else {
            if(is_null($searchOptions) || empty($searchOptions)) {
                $queryParameters = '$orderby=';
                $queryParameters .= rawurlencode('Title asc');
                $queryParameters .= '&$top='.$limit;
                $queryParameters .= '&$skip='.$start;
            } else {
                $queryParameters =  $searchOptions;
            }
            return $this->mediasiteclient->QueryPresentations($queryParameters, $results, $total);
        }
    }

    /**
     * @param string $searchOptions - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $results - Results
     * @param $total - Total available
     * @param $limit - Limit the results returned.
     * @param $start - Skip this number of values.
     * @return true if there are more, false if there are no more
     */
    function QueryFolders($searchOptions='', &$results=null, &$total=null, $limit=10, $start=0) {
        if($searchOptions instanceof SearchOptions) {

        } else {
            return $this->mediasiteclient->QueryFolders($searchOptions, $results, $total);
        }
    }

    /**
     * @param string[]|$string $resources
     * @param array $properties
     * @return mixed
     */
    function ModifyPresentationProperty($resources, $properties) {
    }

    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @return \Sonicfoundry\Tag[]
     */
    function GetTagsForPresentation($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetTagsForPresentation($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @return \Sonicfoundry\Presenter[]
     */
    function GetPresentersForPresentation($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetPresentersForPresentation($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @return \Sonicfoundry\ThumbnailContent[]
     */
    function GetThumbnailContentForPresentation($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetThumbnailContentForPresentation($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $queryParameters
     * @return \Sonicfoundry\SlideContent[]
     */
    function GetSlideContentForPresentation($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetSlideContentForPresentation($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\LayoutOptions
     */
    function GetLayoutOptionsForPresentation($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetLayoutOptionsForPresentation($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function QueryPresentationById($resources) {
        return $this->mediasiteclient->QueryPresentationById($resources);
    }

    /**
     * @param string[]|string $resourceId
     * @return string[]|string
     */
    function QueryPresentationPlaybackUrl($resourceId) {
        return $this->mediasiteclient->QueryPresentationPlaybackUrl($resourceId);
    }

    /**
     * @param string[]|string $resourceId
     * @return \Sonicfoundry\Catalog[]|\Sonicfoundry\Catalog
     */
    function QueryCatalogById($resourceId) {
        return $this->mediasiteclient->QueryCatalogById($resourceId);
    }

    /**
     * @param string[]|string $resourceId
     * @return \Sonicfoundry\Folder[]|\Sonicfoundry\Folder
     */
    function QueryFolderById($resourceId) {
        return $this->mediasiteclient->QueryFolderById($resourceId);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function GetPresentationsForFolder($resources, $queryParameters=null) {
        return $this->mediasiteclient->GetPresentationsForFolder($resources, $queryParameters);
    }

    /**
     * @param string[]|string $resources
     * @param array $properties
     */
    function ModifyCatalogProperty($resources, $properties) {
        return $this->mediasiteclient->ModifyCatalogProperty($resources, $properties);
    }

    /**
     * @param string $username
     * @param string $resourceId
     * @param string $ip
     * @param int $duration
     * @return string
     */
    function CreateAuthTicket($username, $resourceId, $ip, $duration) {
        return $this->mediasiteclient->CreateAuthTicket($username, $resourceId, $ip, $duration);
    }

    /**
     * @param string $resourceId
     * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyById($resourceId = '7788acb4-4533-4efd-a6d1-e9c74c025bfe') {
        return $this->mediasiteclient->GetApiKeyById($resourceId);
    }

    /**
     * @param string $apiname
     * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyByName($apiname = "MoodlePlugin") {
        return $this->mediasiteclient->GetApiKeyByName($apiname);
    }

    /**
     * @param string $apiname
     * @return bool|\Sonicfoundry\ApiKey
     */
    function CreateApiKey($apiname = "MoodlePlugin") {
        return $this->mediasiteclient->CreateApiKey($apiname);
    }

    /**
     * @param string $Username
     * @param string $Password
     * @param null|string $ApplicationName
     * @param null|string $ImpersonationUsername
     * @return \LoginResponse
     */
    function Login($Username, $Password, $ApplicationName = null, $ImpersonationUsername = null) {
    }

    /**
     * @param null|string $Ticket
     * @param null|string $ImpersonationUsername
     * @return \LogoutResponse
     */
    function Logout($Ticket = null, $ImpersonationUsername = null) {
    }
    function QueryPresentationsWithSlides() {
    }

} 