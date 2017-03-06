<?php

namespace Sonicfoundry;

require_once(dirname(__FILE__) . '/../../config.php');

global $CFG;

require_once("$CFG->dirroot/mod/mediasite/siteproperties.php");
require_once("$CFG->dirroot/mod/mediasite/catalog.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
require_once("$CFG->dirroot/mod/mediasite/layoutoptions.php");
require_once("$CFG->dirroot/mod/mediasite/apikey.php");
require_once("$CFG->dirroot/mod/mediasite/folder.php");
require_once("$CFG->dirroot/mod/mediasite/utility.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/lib.php");

defined('MOODLE_INTERNAL') || die();

// Mediasite WebApi webservice client wrapper

class QueryOptions {
    public $includePresenters = FALSE;
    public $includeThumbnail = FALSE;
    public $includeSlides = FALSE;
}

class WebApiExternalAccessClient {
    const MEDIASITE_WEBAPI_JSONACCEPT = "application/json";
    const MEDIASITE_WEBAPI_JSONCONTENTTYPE = "application/json";
    // Open a cURL resource
    private $_ch;
    private $_rootUrl;
    private $_baseUrl;
    private $_curlBaseOptions;
    private $_curlOptions;
    private $_authorization;
    private $_apiKey;
    private $_apiKeyId;
    private $_apiKeyHeader;
    private $_closed = FALSE;
    private $_passthru = null;
    private $_certinfo = null;
    const VERSION = 'api/v1/';
    const PROXY = '127.0.0.1:8888';

    private function FindCookie($header) {
        if( ($cookiestart = strpos($header, "Set-Cookie:")) !== FALSE) {
            if( ($cookieend = strpos($header, PHP_EOL, $cookiestart)) !== FALSE) {
                $cookie = substr($header, $cookiestart, $cookieend - $cookiestart);
                //if(preg_match('/MediasiteAuth=([^;]+)/', $cookie, $matches)) {
                if(preg_match('/MediasiteAuth=([^;]*)(.*)/', $cookie, $matches)) {
                   return "MediasiteAuth=$matches[1]";
                }
            }
        }
        return FALSE;
    }
    private function BaseAddOptions($option) {
        if($this->_curlBaseOptions == null) {
            $this->_curlBaseOptions = array();
        }
        if(is_array($option)) {
            foreach($option as $key => $value) {
                $this->_curlBaseOptions[$key] = $value;
            }
        } else {
            $this->_curlBaseOptions[] = $option;
        }
    }
    private function AddOptions($option) {
        if($this->_curlOptions == null) {
            $this->_curlOptions = array();
        }
        if(is_array($option)) {
            foreach($option as $key => $value) {
                $this->_curlOptions[$key] = $value;
            }
        } else {
            $this->_curlOptions[] = $option;
        }
    }
    private function GetOptions() {
        foreach($this->_curlBaseOptions as $key => $value) {
            $this->_curlOptions[$key] = $value;
        }
        return $this->_curlOptions;
    }
    private function ClearOptions() {
        $this->_curlOptions = array();
    }
    function __construct($serviceLocation = 'http://dev.mediasite.com/Mediasite/7_0', $userName = 'MediasiteAdmin', $password = null, $apiKey = '7788acb4-4533-4efd-a6d1-e9c74c025bfe', $passthru = false, $certinfo = null, $proxy = '') {
        $this->Open($serviceLocation, $userName, $password, $apiKey, $passthru, $certinfo, $proxy);
    }
    function __destruct() {
        $this->Close();
    }
    private function Open($serviceLocation, $userName, $password, $apiKey, $passthru, $certinfo, $proxy) {
        $this->_closed = FALSE;
        $this->_certinfo = $certinfo;
        if(substr($serviceLocation, - 1) === '/') {
            $this->_baseUrl = $serviceLocation;
        } else {
            $this->_baseUrl = $serviceLocation.'/';
        }
        $this->_rootUrl = $this->_baseUrl.self::VERSION;
        $this->_passthru = $passthru;
        if(is_null($this->_passthru) || $this->_passthru == false) {
            $this->_authorization = 'Authorization: '.'Basic '.base64_encode($userName . ':' . $password);
        } else {
            $this->_authorization = 'Authorization: '.'SfIdentTicket '.base64_encode($userName . ':' . $password . ':' . $passthru);
        }

        $this->_ch = curl_init();

        //global $DB;
        //if($record = $DB->get_record("mediasite_cookie", array('auth' => $this->_authorization))) {
        //    $this->_cookie = $record->cookie;
        //}

        if(is_null($certinfo)) {
            $this->BaseAddOptions(array(CURLOPT_FAILONERROR => TRUE,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_SSL_VERIFYPEER => FALSE));

        } else {
            $this->BaseAddOptions(array(CURLOPT_FAILONERROR => TRUE,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                CURLOPT_CAINFO => $certinfo,
                CURLOPT_SSLVERSION => 3,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => TRUE));
        }
        if(!is_null($proxy) && !empty($proxy))
        {
            $this->BaseAddOptions(array(CURLOPT_PROXY => $proxy));
        }
        //curl_setopt($this->_ch, CURLOPT_COOKIEJAR, "tmp/cookieFileName");
        //$tempFileName = tempnam(getcwd(), "ms_");
        if(isset($apiKey) && !empty($apiKey))
        {
            $this->_apiKeyId = $apiKey;
        }
        else
        {
            $this->_apiKey = null;
            try {
                $this->_apiKey = $this->GetApiKeyById();
                $this->_apiKeyId = $this->_apiKey->Id;
            } catch (SonicfoundryException $se) {
                if(preg_match('/(401)?\s+Unauthorized/', $se->getMessage()) === 1) {
                    throw new SonicfoundryException($se->getMessage(), SonicfoundryException::QUERY_API_KEY_BY_NAME_UNAUTHORIZED_DURING_CLIENT_CONSTRUCTION);
                } else {
                    throw new SonicfoundryException($se->getMessage(), SonicfoundryException::QUERY_API_KEY_BY_NAME_UNKNOWN_DURING_CLIENT_CONSTRUCTION);
                }
            }
        }
        if(!is_null($this->_apiKeyId))
        {
            $this->_apiKeyHeader = 'sfapikey: '.$this->_apiKeyId;
        }
    }
    private function Close() {
        // Close the cURL resource
        if(!$this->_closed)
        {
            curl_close($this->_ch);
            $this->_authorization = '';
            $this->_apiKey = null;
            $this->_apiKeyHeader = '';
            $this->_curlOptions = null;
            $this->_ch = null;
            $this->_rootUrl = '';
            $this->_closed = TRUE;
            $this->_cookie = null;
        }
    }
    function get_apikey() {
        return $this->_apiKeyId;
    }

    /**
     * @return string
     */
    function Version() {
        $siteProperties = $this->QuerySiteProperties();
        return $siteProperties->SiteVersion;
    }

    /**
     * @return SiteProperties
     * @throws SonicfoundryException
     */
    function QuerySiteProperties() {

        $url = $this->_rootUrl.'Home';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QuerySiteProperties error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_SITE_PROPERTIES);
        }
        $this->ClearOptions();
        $json = json_decode($result);
        $response = new SiteProperties();

        $response->Folders = $json->{'Folders@odata.navigationLinkUrl'};

        $response->ApiVersion = $json->ApiVersion;
        $response->ApiPublishedDate = $json->ApiPublishedDate;
        $response->SiteName = $json->SiteName;
        $response->SiteDescription = $json->SiteDescription;
        $response->SiteVersion = $json->SiteVersion;
        $response->SiteBuildNumber = $json->SiteBuildNumber;
        $response->SiteOwner = $json->SiteOwner;
        $response->SiteOwnerContact = $json->SiteOwnerContact;
        $response->SiteOwnerEmail = $json->SiteOwnerEmail;
        $response->SiteRootUrl = $json->SiteRootUrl;
        $response->ServiceRootUrl = $json->ServiceRootUrl;
        $response->ServerTime = $json->ServerTime;
        $response->LoggedInUserName = $json->LoggedInUserName;
        $response->RootFolderId = $json->RootFolderId;

        return $response;
    }

    /**
     * @param string $queryParameters
     * @param \Sonicfoundry\Catalog[] &$results
     * @return string|false
     * @throws SonicfoundryException
     */
    function QueryCatalogShares($queryParameters = '', &$results = null, &$totalResults = null) {
        $url = $this->_rootUrl.'Catalogs';
        if(!empty($queryParameters)) {
            $url .= '?'.$queryParameters;
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $response = array();
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QueryCatalogShares error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_CATALOG_SHARES);
        } else {
            $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);

                $header = substr($result, 0, $header_size);
                $cookie = $this->FindCookie($header);
                if($cookie !== FALSE) {
                    $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                                         $this->_apiKeyHeader),
                                            CURLOPT_COOKIE => $cookie));
                 }

            $body = substr($result, $header_size);
            $json = json_decode($body);
            foreach($json->value as $catalog) {
                $catalogShare = new Catalog($catalog);
                $response[] = $catalogShare;
            }
            if(!is_null($results)) {
                $results = $response;
            }
            if(!is_null($totalResults) && isset($json->{'odata.count'})) {
                $totalResults = $json->{'odata.count'};
            }
            $this->ClearOptions();
            if(isset($json->{'odata.nextLink'})) {
                $nextLink = $json->{'odata.nextLink'};
                $serviceUrl = $this->_rootUrl.'Catalogs';
                $queryParameterStart = !mb_stripos($nextLink, $serviceUrl) ? mb_strlen($serviceUrl) + 1 : mb_strlen($nextLink);
                return mb_substr($nextLink, $queryParameterStart);
            } else {
                return false;
            }
        }
    }

    /**
     * @param string $queryParameters
     * @param \Sonicfoundry\Presentation[] &$results
     * @return string|false
     * @throws SonicfoundryException
     */
    function QueryPresentations($queryParameters = '', &$results = null, &$totalResults = null) {
        $url = $this->_rootUrl.'Presentations';
        if(!empty($queryParameters)) {
            $url .= '?'.$queryParameters;
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $response = array();
        curl_setopt_array($this->_ch, $this->GetOptions());
        //Search service is off error.
        if( ! $result = curl_exec($this->_ch)) {
            //$errormsg =  'QueryPresentations error: ' . curl_error($this->_ch);
            $errormsg =  'QueryPresentations error: Unable to contact Mediasite server. '
                    . 'Please contact your system administrator or verify that the Mediasite Search service is enabled and running. ';
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_PRESENTATIONS);
        } else {
            $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);

                $header = substr($result, 0, $header_size);
                $cookie = $this->FindCookie($header);
                if($cookie !== FALSE) {
                    $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                                         $this->_apiKeyHeader),
                                            CURLOPT_COOKIE => $cookie));
                }

            $body = substr($result, $header_size);
            $json = json_decode($body);

                if (isset($json->RootId)) {
                    foreach($json->value as $presentation) {
                        $presentationRepresentation = new Presentation($presentation);
                        $presentationRepresentation->Play = $presentation->{'#Play'}->target;
                        $response[] = $presentationRepresentation;
                    }
                } elseif(isset($json->Description)) {
                    foreach($json->value as $presentation) {
                        $presentationRepresentation = new CardPresentation($presentation);
                        $presentationRepresentation->Play = $presentation->{'#Play'}->target;
                        $response[] = $presentationRepresentation;
                    }
                } else {
                    foreach($json->value as $presentation) {
                        $presentationRepresentation = new DefaultPresentation($presentation);
                        $presentationRepresentation->Play = $presentation->{'#Play'}->target;
                        $response[] = $presentationRepresentation;
                    }
                }

            if(!is_null($results)) {
                $results = $response;
            }
            if(!is_null($totalResults) && isset($json->{'odata.count'})) {
                $totalResults = $json->{'odata.count'};
            }
            $this->ClearOptions();
            if(isset($json->{'odata.nextLink'})) {
                $nextLink = $json->{'odata.nextLink'};
                $serviceUrl = $this->_rootUrl.'Presentations';
                $queryParameterStart = !mb_stripos($nextLink, $serviceUrl) ? mb_strlen($serviceUrl) + 1 : mb_strlen($nextLink);
                return mb_substr($nextLink, $queryParameterStart);
             } else {
                return false;
            }
        }
    }

    /**
     * @param string $queryParameters
     * @param \Sonicfoundry\Folder[] &$results
     * @return string|false
     * @throws SonicfoundryException
     */
    function QueryFolders($queryParameters = '', &$results= null, &$totalResults = null) {
        $url = $this->_rootUrl.'Folders';
        if(!empty($queryParameters)) {
            $url .= '?'.$queryParameters;
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        $response = array();
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QueryFolders error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_FOLDERS);
        } else {
            $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);

            $header = substr($result, 0, $header_size);
            $cookie = $this->FindCookie($header);
            if($cookie !== FALSE) {
                $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                                     $this->_apiKeyHeader),
                                        CURLOPT_COOKIE => $cookie));
            }

            $body = substr($result, $header_size);
            $json = json_decode($body);

                foreach($json->value as $folder) {
                    $folderRepresentation = new Folder($folder);
                    $response[] = $folderRepresentation;
                }

            if(!is_null($results)) {
                $results = $response;
            }
            if(!is_null($totalResults) && isset($json->{'odata.count'})) {
                $totalResults = $json->{'odata.count'};
            }
            $this->ClearOptions();

            if(isset($json->{'odata.nextLink'})) {
                $nextLink = $json->{'odata.nextLink'};
                $serviceUrl = $this->_rootUrl.'Folders';
                $queryParameterStart = !mb_stripos($nextLink, $serviceUrl) ? mb_strlen($serviceUrl) + 1 : mb_strlen($nextLink);
                return mb_substr($nextLink, $queryParameterStart);
            } else {
                return false;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param $properties
     * @throws SonicfoundryException
     */
    function ModifyPresentationProperty($resources, $properties) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::MODIFY_PRESENTATION);
        }
        if(!is_null($this->_cookie)) {
            $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => json_encode($properties),
                CURLOPT_CUSTOMREQUEST => "PATCH",
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_COOKIE => $this->_cookie,
                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                             'Content-Type: '. self::MEDIASITE_WEBAPI_JSONCONTENTTYPE,
                                             $this->_apiKeyHeader)));
        } else {
            $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => json_encode($properties),
                CURLOPT_CUSTOMREQUEST => "PATCH",
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                             'Content-Type: '. self::MEDIASITE_WEBAPI_JSONCONTENTTYPE,
                                             $this->_authorization,
                                             $this->_apiKeyHeader)));
        }
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')';
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            $result = curl_exec($this->_ch);
            if( $result === false) {
                $info = curl_getinfo($this->_ch);
                $errormsg =  'ModifyPresentationProperty error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::MODIFY_PRESENTATION);
            }
            $jsonresult = json_decode($result);
            if(isset($jsonresult->response->status) && $jsonresult->response->status == 'ERROR') {
                throw new SonicfoundryException($jsonresult->response->errormessage, SonicfoundryException::MODIFY_PRESENTATION);
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Tag[]
     * @throws SonicfoundryException
     */
    function GetTagsForPresentation($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_TAGS_FOR_PRESENTATION);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')Tags';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "GetTagsForPresentation ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    foreach($json->value as $content) {
                        $tagRepresentation = new Tag($content);
                        $response[] = $tagRepresentation;
                    }
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')Tags';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetTagsForPresentation error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_TAGS_FOR_PRESENTATION);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                foreach($json->value as $content) {
                    $tagRepresentation = new Tag($content);
                    $response[] = $tagRepresentation;
                }
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Presenter[]
     * @throws SonicfoundryException
     */
    function GetPresentersForPresentation($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_PRESENTERS_FOR_PRESENTATION);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')Presenters';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value))
                {
                    $errormsg =  "GetPresentersForPresentation ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    $header = substr($result, 0, $header_size);
                    if(!$cookieFound) {
                        $cookie = $this->FindCookie($header);
                        if($cookie) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                $this->_apiKeyHeader),
                                CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    foreach($json->value as $content) {
                        $presenterRepresentation = new Presenter($content);
                        $response[] = $presenterRepresentation;
                    }
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')Presenters';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetPresentersForPresentation error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_PRESENTERS_FOR_PRESENTATION);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                foreach($json->value as $content) {
                    $presenterRepresentation = new Presenter($content);
                    $response[] = $presenterRepresentation;
                }
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\ThumbnailContent[]
     * @throws SonicfoundryException
     */
    function GetThumbnailContentForPresentation($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_THUMBNAILS_FOR_PRESENTATION);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')ThumbnailContent';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "GetThumbnailContentForPresentation ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    if(!$cookieFound) {
                        $header = substr($result, 0, $header_size);
                        $cookie = $this->FindCookie($header);
                        if($cookie) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                $this->_apiKeyHeader),
                                CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    foreach($json->value as $content) {
                        $thumbnailContentRepresentation = new ThumbnailContent($content);
                        $response[] = $thumbnailContentRepresentation;
                    }
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')ThumbnailContent';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetThumbnailContentForPresentation error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_THUMBNAILS_FOR_PRESENTATION);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                foreach($json->value as $content) {
                    $thumbnailContentRepresentation = new ThumbnailContent($content);
                    $response[] = $thumbnailContentRepresentation;
                }
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\SlideContent[]
     * @throws SonicfoundryException
     */
    function GetSlideContentForPresentation($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_SLIDES_FOR_PRESENTATION);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')SlideContent';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "GetSlideContentForPresentation ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    if(!$cookieFound) {
                        $header = substr($result, 0, $header_size);
                        $cookie = $this->FindCookie($header);
                        if($cookie !== FALSE) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                $this->_apiKeyHeader),
                                CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    foreach($json->value as $content) {
                        $slideContentRepresentation = new SlideContent($this->_baseUrl, $content);
                        $response[] = $slideContentRepresentation;
                    }
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        }
        else
        {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')SlideContent';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetSlideContentForPresentation error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_SLIDES_FOR_PRESENTATION);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                foreach($json->value as $content) {
                    $slideContentRepresentation = new SlideContent($this->_baseUrl, $content);
                    $response[] = $slideContentRepresentation;
                }
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\LayoutOptions
     * @throws SonicfoundryException
     */
    function GetLayoutOptionsForPresentation($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_LAYOUTOPTIONS_FOR_PRESENTATION);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')LayoutOptions';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "GetLayoutOptionsForPresentation ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    if(!$cookieFound) {
                        $header = substr($result, 0, $header_size);
                        $cookie = $this->FindCookie($header);
                        if($cookie !== FALSE) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                $this->_apiKeyHeader),
                                CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                        $layoutOptionsRepresentation = new LayoutOptions($json);
                        $response[] = $layoutOptionsRepresentation;
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')LayoutOptions';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetLayoutOptionsForPresentation error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_LAYOUTOPTIONS_FOR_PRESENTATION);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                    $layoutOptionsRepresentation = new LayoutOptions($json);
                    $response = $layoutOptionsRepresentation;
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @return \Sonicfoundry\Presentation|\Sonicfoundry\Presentation[]
     * @throws SonicfoundryException
     */
    function QueryPresentationById($resources) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null presentation id', SonicfoundryException::QUERY_PRESENTATION_BY_ID);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            $response = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Presentations(\''.$resource.'\')?$select=full';
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "QueryPresentationById ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    if(!$cookieFound) {
                        $header = substr($result, 0, $header_size);
                        $cookie = $this->FindCookie($header);
                        if($cookie !== FALSE) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                $this->_apiKeyHeader),
                                CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    $presentationRepresentation = new Presentation($json);
                    $presentationRepresentation->Play = $json->{'#Play'}->target;
                    $response[] = $presentationRepresentation;
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        } else {
            $url = $this->_rootUrl.'Presentations(\''.$resources.'\')?$select=full';
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'QueryPresentationById error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_PRESENTATION_BY_ID);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                $presentationRepresentation = new Presentation($json);
                $presentationRepresentation->Play = $json->{'#Play'}->target;
                $this->ClearOptions();
                return $presentationRepresentation;
            }
        }
    }

    /**
     * @param string $resourceId
     * @return string
     * @throws SonicfoundryException
     */
    function QueryPresentationPlaybackUrl($resourceId) {
        if(empty($resourceId)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null resource id for presentation playback', SonicfoundryException::QUERY_PLAYBACKURL);
        }
        $url = $this->_rootUrl.'Presentations(\''.$resourceId.'\')?$select=full';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QueryPresentationPlaybackUrl error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_PLAYBACKURL);
        } else {
            $json = json_decode($result);
            $this->ClearOptions();
            return $json->{'#Play'}->target;
        }
    }

    /**
     * @param string $resourceId
     * @return \Sonicfoundry\Catalog
     * @throws SonicfoundryException
     */
    function QueryCatalogById($resourceId) {
        if(empty($resourceId)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null catalog id', SonicfoundryException::QUERY_CATALOG_BY_ID);
        }
        $url = $this->_rootUrl.'Catalogs(\''.$resourceId.'\')';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization,
                                                            $this->_apiKeyHeader)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QueryCatalogById error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_CATALOG_BY_ID);
        } else {
            $json = json_decode($result);
            $this->ClearOptions();
            return new Catalog($json);
        }
    }

    /**
     * @param string $resourceId
     * @return \Sonicfoundry\Folder
     * @throws SonicfoundryException
     */
    function QueryFolderById($resourceId) {
        if(empty($resourceId)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null catalog id', SonicfoundryException::QUERY_CATALOG_BY_ID);
        }
        $url = $this->_rootUrl.'Folders(\''.$resourceId.'\')';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'QueryFolderById error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_CATALOG_BY_ID);
        } else {
            $json = json_decode($result);
            $this->ClearOptions();
            return new Folder($json);
        }
    }

    /**
     * @param string|string[] $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Presentation[]
     * @throws SonicfoundryException
     */
    function GetPresentationsForFolder($resources, $queryParameters=null) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null folder id', SonicfoundryException::QUERY_PRESENTATIONS_FOR_FOLDER);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        $cookieFound = FALSE;
        $response = array();
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
            foreach($resources as $resource) {
                $url = $this->_rootUrl.'Folders(\''.$resource.'\')\\Presentations';
                if(!is_null($queryParameters)) {
                    $url .= '?'.$queryParameters;
                }
                $this->AddOptions(array(CURLOPT_URL => $url));
                $handles[$url] = curl_init($url);
                curl_setopt_array($handles[$url], $this->GetOptions());
                curl_multi_add_handle($mh, $handles[$url]);
            }
            $running = null;

            do {
                curl_multi_exec($mh, $running);
                usleep(100000);
            } while ($running > 0);

            foreach ($handles as $key => $value) {
                if(curl_errno($value)) {
                    $errormsg =  "GetPresentationsForFolder ($key) error: " . curl_error($value);
                    $response[] = $errormsg;
                } else {
                    $header_size = curl_getinfo($value, CURLINFO_HEADER_SIZE);
                    $result = curl_multi_getcontent($value);
                    if(!$cookieFound) {
                        $header = substr($result, 0, $header_size);
                        $cookie = $this->FindCookie($header);
                        if($cookie !== FALSE) {
                            $this->AddOptions(array(CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                                                 $this->_apiKeyHeader),
                                                    CURLOPT_COOKIE => $cookie));
                            $cookieFound = TRUE;
                        }
                    }
                    $body = substr($result, $header_size);
                    $json = json_decode($body);
                    foreach($json->value as $content) {
                        $presentationRepresentation = new Presentation($$content);
                        $response[] = $presentationRepresentation;
                    }
                }

                curl_multi_remove_handle($mh, $value);
                curl_close($value);
            }
            $this->ClearOptions();
            return $response;
        }
        else
        {
            $url = $this->_rootUrl.'Folders(\''.$resources.'\')\\Presentations';
            if(!is_null($queryParameters)) {
                $url .= '?'.$queryParameters;
            }
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            if( ! $result = curl_exec($this->_ch)) {
                $errormsg =  'GetPresentationsForFolder error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_PRESENTATIONS_FOR_FOLDER);
            } else {
                $header_size = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
                $body = substr($result, $header_size);
                $json = json_decode($body);
                foreach($json->value as $content) {
                    $presentationRepresentation = new DefaultPresentation($content);
                    $response[] = $presentationRepresentation;
                }
                $this->ClearOptions();
                return $response;
            }
        }
    }

    /**
     * @param string|string[] $resources
     * @param array $properties
     * @throws SonicfoundryException
     */
    function ModifyCatalogProperty($resources, $properties) {
        if(empty($resources)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null catalog id', SonicfoundryException::MODIFY_CATALOG);
        }
        $this->AddOptions(array(CURLOPT_HEADER => TRUE,
                                CURLOPT_POST => 1,
                                CURLOPT_POSTFIELDS => json_encode($properties),
                                CURLOPT_CUSTOMREQUEST => "PATCH",
                                CURLOPT_HEADER => false,
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             'Content-Type: '. self::MEDIASITE_WEBAPI_JSONCONTENTTYPE,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        if(is_array($resources)) {
            $mh = curl_multi_init();
            $handles = array();
        } else {
            $url = $this->_rootUrl.'Catalogs(\''.$resources.'\')';
            $this->AddOptions(array(CURLOPT_URL => $url));
            curl_setopt_array($this->_ch, $this->GetOptions());
            $result = curl_exec($this->_ch);
            if( $result === false) {
                $errormsg =  'ModifyCatalogProperty error: ' . curl_error($this->_ch);
                throw new SonicfoundryException($errormsg, SonicfoundryException::MODIFY_CATALOG);
            }
            $jsonresult = json_decode($result);
            if(isset($jsonresult->response->status) && $jsonresult->response->status == 'ERROR') {
                throw new SonicfoundryException($jsonresult->response->errormessage, SonicfoundryException::MODIFY_CATALOG);
            }
        }
        $this->ClearOptions();
    }

    /**
     * @param string $username
     * @param string $resourceId
     * @param string $ip
     * @param int $duration
     * @return string
     * @throws SonicfoundryException
     */
    function CreateAuthTicket($username, $resourceId, $ip, $duration) {
        if(empty($resourceId)) {
            // Empty/null resource id
            throw new SonicfoundryException('Empty/null resource id for auth ticket', SonicfoundryException::CREATE_AUTH_TICKET);
        }
        $url = $this->_rootUrl.'AuthorizationTickets';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_POST => TRUE,
                                CURLOPT_POSTFIELDS => json_encode(array("Username"=>$username, "ClientIpAddress"=> $ip, "ResourceId"=> $resourceId, "MinutesToLive"=>$duration)),
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             'Content-Type: '.self::MEDIASITE_WEBAPI_JSONCONTENTTYPE,
                                                             $this->_authorization,
                                                             $this->_apiKeyHeader)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'CreateAuthTicket error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::CREATE_AUTH_TICKET);
        } else {
            $json = json_decode($result);
            $this->ClearOptions();
            return $json->TicketId;
        }
    }

    /**
     * @param string $resourceId
     * @return bool|\Sonicfoundry\ApiKey
     * @throws SonicfoundryException
     */
    function GetApiKeyById($resourceId = '7788acb4-4533-4efd-a6d1-e9c74c025bfe') {
        if(empty($resourceId)) {
            // Empty/null key name
            throw new SonicfoundryException('Empty/null API Key ID', SonicfoundryException::QUERY_API_KEY_BY_NAME);
        }
        if(!is_null($this->_apiKey) && $this->_apiKey->Id === $resourceId) {
            return $this->_apiKey;
        }
        $url = $this->_rootUrl.'ApiKeys(\'' .  $resourceId . '\')';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'GetApiKeyById error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_API_KEY_BY_ID);
        }
        $json = json_decode($result);
        $this->ClearOptions();
        return new ApiKey($json);
    }

    /**
     * @param string $apiname
     * @return bool|\Sonicfoundry\ApiKey
     * @throws SonicfoundryException
     */
    function GetApiKeyByName($apiname = "MoodlePlugin") {
        if(empty($apiname)) {
            // Empty/null key name
            throw new SonicfoundryException('Empty/null API Key Name', SonicfoundryException::QUERY_API_KEY_BY_NAME);
        }
        if(!is_null($this->_apiKey) && $this->_apiKey->Name === $apiname) {
            $this->ClearOptions();
            return $this->_apiKey;
        }
        $url = $this->_rootUrl.'ApiKeys?$filter=Name%20eq%20\''.$apiname.'\'';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                            $this->_authorization)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'GetApiKeyByName error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::QUERY_API_KEY_BY_NAME);
        }
        $json = json_decode($result);
        if(is_array($json->value) && count($json->value) > 0) {
            $this->ClearOptions();
            return new ApiKey($json->value[0]);
        }
        $this->ClearOptions();
        return false;
    }

    /**
     * @param string $apiname
     * @return bool|\Sonicfoundry\ApiKey
     * @throws SonicfoundryException
     */
    function CreateApiKey($apiname = "MoodlePlugin")
    {
        if(empty($apiname)) {
            // Empty/null key name
            throw new SonicfoundryException('Empty/null API Key Name', SonicfoundryException::CREATE_APIKEY);
        }
        $url = $this->_rootUrl.'ApiKeys';
        $this->AddOptions(array(CURLOPT_HEADER => 0,
                                CURLOPT_URL => $url,
                                CURLOPT_POST => TRUE,
                                CURLOPT_POSTFIELDS => json_encode(array("Name"=>$apiname)),
                                CURLOPT_HTTPHEADER => array ('Accept: ' . self::MEDIASITE_WEBAPI_JSONACCEPT,
                                                             'Content-Type: '.self::MEDIASITE_WEBAPI_JSONCONTENTTYPE,
                                                             $this->_authorization)));
        curl_setopt_array($this->_ch, $this->GetOptions());
        if( ! $result = curl_exec($this->_ch)) {
            $errormsg =  'CreateApiKey error: ' . curl_error($this->_ch);
            throw new SonicfoundryException($errormsg, SonicfoundryException::CREATE_APIKEY);
        }
        $json = json_decode($result);
        if(is_array($json->value) && count($json->value) > 0) {
            $this->ClearOptions();
            return new ApiKey($json->value[0]);
        }
        $this->ClearOptions();
        return false;
    }
}

?>