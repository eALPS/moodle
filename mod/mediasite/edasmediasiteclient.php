<?php

namespace Sonicfoundry\EDAS;
use Sonicfoundry;

require_once(dirname(__FILE__) . '/../../config.php');
global $CFG;
require_once("$CFG->dirroot/mod/mediasite/imediasiteclient.php");
require_once("$CFG->dirroot/mod/mediasite/siteproperties.php");
require_once("$CFG->dirroot/mod/mediasite/catalog.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/folder.php");
require_once("$CFG->dirroot/mod/mediasite/tag.php");
require_once("$CFG->dirroot/mod/mediasite/presenter.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_client.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_enumerations.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_functions.php");

class EDASQueryOptions {
    function __construct($BatchSize, $QueryId, $StartIndex, $fields) {
        $this->Options = new QueryOptions($BatchSize, $QueryId, $StartIndex);
        $this->Fields = $fields;
        $this->SearchString = '';
    }
    public $Options;
    public $SearchString;
    public $Fields;
}

class EDASMediasiteClient implements Sonicfoundry\iMediasiteClient {
    const EDAS_QUERY_BATCH_SIZE = 10;
    const EDAS_WILDCARD_PRESENTATION_SEARCH = "Type:Presentation";
    const EDAS_WILDCARD_CATALOG_SEARCH = "Type:Catalog";
    const EDAS_WILDCARD_FOLDER_SEARCH = "Type:Folder";
    private $impersonationName;
    private $mediasiteclient;
    /**
     * @access private
     * @param SearchOptions $searchOptions
     * @return string[]
     */
    private function _supportedPresentationFields(Sonicfoundry\SearchOptions $searchOptions) {
        $fields = array();
        if($searchOptions->Name) {
            array_push($fields, SupportedSearchField::Name);
        }
        if($searchOptions->Description) {
            array_push($fields, SupportedSearchField::Description);
        }
        if($searchOptions->Presenter) {
            array_push($fields, SupportedSearchField::Presenter);
        }
        return $fields;
    }
    /**
     * @access private
     * @param $input
     * @return string
     */
    private function _transformRawSearchText($input) {
        // Replace HTML entities
        $searchtext = urldecode($input);
        // Replace Lucene special characters
        $searchtext = preg_replace('/([!+\-~])+/U', '\\\\\1', $searchtext);
        return $searchtext;
    }
    /**
     * @access private
     * @param $input
     * @return string
     */
    private function _tagify($input) {
        $regexp = '/\G(?:"[^"]*"|\'[^\']*\'|[^"\'\s]+)*\K\s+/mU';
        $tokens = preg_split($regexp,$input);
        $regexp = '/"([^"]+)"/i';
        for($i = 0; $i < count($tokens); $i++) {
            if(!preg_match($regexp, $tokens[$i])) {
                $tokens[$i] .= '*';
            }
        }
        return implode(' OR ', $tokens);
    }
    /**
     * @access private
     * @param $input
     * @param SearchOptions $searchOptions
     * @return string
     */
    private function _addPresentationConstraints($input, Sonicfoundry\SearchOptions $searchOptions) {
        $searchText = '';
        if($searchOptions->Name) {
            if(empty($searchText)) {
                $searchText .= 'Name:('.$input.')';
            } else {
                $searchText .= ' OR Name:('.$input.')';
            }
        }
        if(!strcmp($searchOptions->ResourceType,'Catalog')) return $searchText;
        if($searchOptions->Description) {
            if(empty($searchText)) {
                $searchText .= 'Description:('.$input.')';
            } else {
                $searchText .= ' OR Description:('.$input.')';
            }
        }
        if($searchOptions->Tag) {
            if(empty($searchText)) {
                $searchText .= 'Tags:('.$input.')';
            } else {
                $searchText .= ' OR Tags:('.$input.')';
            }
        }
        if($searchOptions->Presenter) {
            if(empty($searchText)) {
                $searchText .= 'Presenters:('.$input.')';
            } else {
                $searchText .= ' OR Presenters:('.$input.')';
            }
        }
        return $searchText;
    }
    /**
     * @access private
     * @param $presentationSearchResults
     * @return \Sonicfoundry\Presentation[]
     */
    private function _presentation_search_mapping($presentationSearchResults) {
        if(isset($presentationSearchResults->Results->TotalResults) && $presentationSearchResults->Results->TotalResults > 0 && count($presentationSearchResults->DetailList->SearchResponseDetails) > 0) {
            $presentationIds = array();
            if(is_array($presentationSearchResults->DetailList->SearchResponseDetails)) {
                foreach($presentationSearchResults->DetailList->SearchResponseDetails as $rd) {
                    array_push($presentationIds, $rd->MediasiteId);
                }
            } else {
                array_push($presentationIds, $presentationSearchResults->DetailList->SearchResponseDetails->MediasiteId);
            }
            try {
                $edasPresentations = $this->mediasiteclient->QueryPresentationsById($presentationIds);
            } catch(\Exception $ex) {
                $edasPresentations = array();
                foreach($presentationIds as $id) {
                    array_push($edasPresentations, $this->mediasiteclient->QueryPresentationsById(array($id)));
                }
            }
//            if(count($presentationIds) !== count($edasPresentations)) {
//                $foundPresentationIds = array();
//                foreach($edasPresentations->Presentations as $edasPresentation) {
//                    array_push($foundPresentationIds, $edasPresentation->Id);
//                }
//                if(count($presentationIds) > count($foundPresentationIds)) {
//                    $differenceIds = array_diff($presentationIds, $foundPresentationIds);
//                } else {
//                    $differenceIds = array_diff($foundPresentationIds, $presentationIds);
//                }
//                foreach($differenceIds as $differenceId) {
//                    print($differenceId."\n");
//                }
//            }
            $presentations = array();
            foreach($edasPresentations->Presentations as $edasPresentation) {
                array_push($presentations, new Sonicfoundry\Presentation($edasPresentation));
            }
            return $presentations;

        } else {
            return array();
        }
    }

    /**
     * @access private
     * @param $catalogSearchResults
     * @return \Sonicfoundry\Catalog[]
     */
    private function _catalog_search_mapping($catalogSearchResults) {
        if(isset($catalogSearchResults->Results->TotalResults) && $catalogSearchResults->Results->TotalResults > 0 && count($catalogSearchResults->DetailList->SearchResponseDetails) > 0) {
            $catalogIds = array();
            if(is_array($catalogSearchResults->DetailList->SearchResponseDetails)) {
                foreach($catalogSearchResults->DetailList->SearchResponseDetails as $rd) {
                    array_push($catalogIds, $rd->MediasiteId);
                }
            } else {
                array_push($catalogIds, $catalogSearchResults->DetailList->SearchResponseDetails->MediasiteId);
            }
            try {
                $edasCatalogs = $this->mediasiteclient->QueryCatalogsById($catalogIds);
            } catch(\Exception $ex) {
                $edasCatalogs = array();
                foreach($catalogIds as $id) {
                    array_push($edasCatalogs, $this->mediasiteclient->QueryCatalogsById(array($id)));
                }
            }
            $catalogs = array();
            foreach($edasCatalogs->Shares as $edasCatalog) {
                array_push($catalogs, new Sonicfoundry\Catalog($edasCatalog));
            }
            return $catalogs;

        } else {
            return array();
        }
    }

    /**
     * @access private
     * @param $presentationSearchResults
     * @return \Sonicfoundry\Folder[]
     */
    private function _folder_mapping($folderSearchResults) {
        if(isset($folderSearchResults->Results->TotalResults) && $folderSearchResults->Results->TotalResults > 0 && count($folderSearchResults->DetailList->SearchResponseDetails) > 0) {
            $folderIds = array();
            if(is_array($folderSearchResults->DetailList->SearchResponseDetails)) {
                foreach($folderSearchResults->DetailList->SearchResponseDetails as $rd) {
                    array_push($folderIds, $rd->MediasiteId);
                }
            } else {
                array_push($folderIds, $folderSearchResults->DetailList->SearchResponseDetails->MediasiteId);
            }
            try {
                $edasFolders = $this->mediasiteclient->QueryFoldersById($folderIds, ResourcePermissionMask::Read);
            } catch(\Exception $ex) {
                $edasFolders = array();
                foreach($folderIds as $id) {
                    array_push($edasFolders, $this->mediasiteclient->QueryFoldersById(array($id), ResourcePermissionMask::Read));
                }
            }
            $folders = array();
            foreach($edasFolders->FolderDetails as $edasFolder) {
                array_push($folders, new Sonicfoundry\Folder($edasFolder));
            }
            return $folders;

        } else {
            return array();
        }
    }
    /**
     * @access private
     * @param $presentationSearchResults
     * @return \Sonicfoundry\Presenter[]
     */
    private function _presenter_mapping($presentationSearchResults) {
        $presenters = array();
        foreach($presentationSearchResults->Presentations as $edasPresentation) {
            if(is_array($edasPresentation->Presenters->PresenterName)) {
                foreach($edasPresentation->Presenters->PresenterName as $presenter) {
                    array_push($presenters, new Sonicfoundry\Presenter($presenter));
                }
            } else {
                array_push($presenters, new Sonicfoundry\Presenter($edasPresentation->Presenters->PresenterName));
            }
        }
        return $presenters;
    }
    /**
     * @access private
     * @param $presentationSearchResults
     * @return \Sonicfoundry\ThumbnailContent[]
     */
    private function _thumbnail_mapping($presentationSearchResults) {
        $thumbnails = array();
        foreach($presentationSearchResults->Presentations as $edasPresentation) {
            if(is_array($edasPresentation->Content->PresentationContentDetails)) {
                foreach($edasPresentation->Content->PresentationContentDetails as $content) {
                    if(!strcmp($content->ContentType, PresentationContentTypeDetails::PresentationThumbnail)) {
                        array_push($thumbnails, new Sonicfoundry\ThumbnailContent($edasPresentation->FileServerUrl.'/Presentation/'.$edasPresentation->Id.'/'.$content->FileNameWithExtension));
                    }
                }
            } else {
                if(!strcmp($edasPresentation->Content->PresentationContentDetails->ContentType, PresentationContentTypeDetails::PresentationThumbnail)) {
                    array_push($thumbnails, new Sonicfoundry\ThumbnailContent($edasPresentation->FileServerUrl.'/Presentation/'.$edasPresentation->Id.'/'.$edasPresentation->Content->PresentationContentDetails->FileNameWithExtension));
                }
            }
        }
        return $thumbnails;
    }
    /**
     * @access private
     * @param $presentationSearchResults
     * @return \Sonicfoundry\SlideContent[]
     */
    private function _slide_mapping($edasSlides) {
        $slides = array();
        if(is_array($edasSlides->Slides)) {
            foreach($edasSlides->Slides as $edasSlide) {
                array_push($slides, new Sonicfoundry\SlideContent('', $edasSlide));
            }
        } else {
            array_push($slides, new Sonicfoundry\SlideContent('', $edasSlides->Slides));
        }
        return $slides;
    }

    function __construct() {
        $arg_list = func_get_args();
        if(count($arg_list) > 5) {
            $this->impersonationName = $arg_list[4];
            $arg_list[4] = null;
        } else if(count($arg_list) == 5) {
            $this->impersonationName = $arg_list[4];
            $arg_list = array_slice($arg_list, 0, 4);
        }
        $reflection = new \ReflectionClass('Sonicfoundry\EDAS\ExternalAccessClient');
        $this->mediasiteclient = $reflection->newInstanceArgs($arg_list);
    }
    /**
     * @return string|null
     */
    function get_apikey() {
        return null;
    }

    /**
     * @return string|null
     */
    function Version() {
        $siteproperties = $this->mediasiteclient->QuerySiteProperties();
        return $siteproperties->Properties->Version;
    }

    /**
     * Returns a SiteProperties class that contains various site properties
     * The most useful is the SiteVersion property that indicates the site version
     * @return \Sonicfoundry\SiteProperties
     */
    function QuerySiteProperties() {
        return new Sonicfoundry\SiteProperties($this->mediasiteclient->QuerySiteProperties());
    }

    /**
     * Searches the catalog shares on a site given the supplied criteria.
     * @param string $searchOptions - Either a string or a SearchOptions class
     * @param $results - Results
     * @param $total - Total available
     * @param $limit - Limit the results returned.
     * @return true if there are more, false if there are no more
    */
    function QueryCatalogShares($searchOptions = '', &$results=null, &$total=null, $limit = self::EDAS_QUERY_BATCH_SIZE, $start = 0) {
        $fields = array(SupportedSearchField::Name);
        $types = array(SupportedSearchType::Catalog);
        $options = new QueryOptions($limit, 'C'.(string)rand(), $start);
        $queryOptions = new EDASQueryOptions($limit, null, $start + $limit, $fields);
        if($searchOptions instanceof Sonicfoundry\SearchOptions) {
            if(!is_null($searchOptions->SearchText) &&
               !empty($searchOptions->SearchText)) {
                $searchText = $searchOptions->SearchText;
                $searchText = $this->_transformRawSearchText($searchText);
                $searchText = $this->_tagify($searchText);
                $searchText = 'Name:('.$searchText.')';
            } else {
                $searchText = self::EDAS_WILDCARD_CATALOG_SEARCH;
            }
        } else{
            if (!is_null($searchOptions) &&
                !empty($searchOptions)) {
                $newOptions = json_decode($searchOptions);
                if(!is_null($newOptions) &&
                    isset($newOptions->Options) &&
                    isset($newOptions->Fields) &&
                    isset($newOptions->SearchString)) {
                    $searchText = $newOptions->SearchString;
                    $options = $newOptions->Options;
                    $fields = $newOptions->Fields;
                } else {
                    $searchText = 'Name:(' . $searchOptions . ')';
                }
            } else {
                $searchText = self::EDAS_WILDCARD_CATALOG_SEARCH;
            }
        }
        $queryOptions->SearchString = $searchText;
        $queryOptions->Fields = $fields;
        if(!is_null($this->impersonationName) && $this->impersonationName) {
            $catalogSearchResults = $this->mediasiteclient->Search($fields,
                                                                   $searchText,
                                                                   $types,
                                                                   $options,
                                                                   null, null, null, null,
                                                                   $this->impersonationName);
        } else {
            $catalogSearchResults = $this->mediasiteclient->Search($fields,
                                                                   $searchText,
                                                                   $types,
                                                                   $options);
        }
        $queryOptions->Options->BatchSize = $catalogSearchResults->Results->NextQueryOptions->BatchSize;
        $queryOptions->Options->QueryId = $catalogSearchResults->Results->NextQueryOptions->QueryId;
        $queryOptions->Options->StartIndex = $catalogSearchResults->Results->NextQueryOptions->StartIndex;
        if(!is_null($results)) {
            $results = $this->_catalog_search_mapping($catalogSearchResults);
        }
        if(!is_null($total)) {
            $total = $catalogSearchResults->Results->TotalResults;
        }
        if(!$catalogSearchResults->Results->MoreResultsAvailable) {
            return $catalogSearchResults->Results->MoreResultsAvailable;
        } else {
            return \json_encode($queryOptions);
        }
    }

    /**
     * Searches the presentations on the site given the supplied search criteria
     * @param string $searchOptions - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $results - Results
     * @param $total - Total available
     * @param $limit - Limit the results returned.
     * @return true if there are more, false if there are no more
     */
    function QueryPresentations($searchOptions = '', &$results=null, &$total=null, $limit=self::EDAS_QUERY_BATCH_SIZE, $start=0) {
        $fields = array(SupportedSearchField::Name);
        $types = array(SupportedSearchType::Presentation);
        $options = new QueryOptions($limit, 'P'.(string)rand(), $start);
        $queryOptions = new EDASQueryOptions($limit, null, $start + $limit, $fields);
        if($searchOptions instanceof Sonicfoundry\SearchOptions) {
            if(!is_null($searchOptions->SearchText) && !empty($searchOptions->SearchText)) {
                $fields = $this->_supportedPresentationFields($searchOptions);
                $searchText = $searchOptions->SearchText;
                $searchText = $this->_transformRawSearchText($searchText);
                $searchText = $this->_tagify($searchText);
                $searchText = $this->_addPresentationConstraints($searchText, $searchOptions);
            } else {
                $fields = array();
                $searchText = self::EDAS_WILDCARD_PRESENTATION_SEARCH;
            }
        } else {
            if (!is_null($searchOptions) && !empty($searchOptions)) {
                $newOptions = json_decode($searchOptions);
                if(!is_null($newOptions) &&
                   isset($newOptions->Options) &&
                   isset($newOptions->SearchString)) {
                    $searchText = $newOptions->SearchString;
                    $options = $newOptions->Options;
                } else {
                    $searchText = 'Name:(' . $searchOptions . ')';
                }
            } else {
                $fields = array();
                $searchText = self::EDAS_WILDCARD_PRESENTATION_SEARCH;
            }
        }
        $queryOptions->SearchString = $searchText;
        $queryOptions->Fields = $fields;
        if(!is_null($this->impersonationName) && $this->impersonationName) {
            $presentationSearchResults = $this->mediasiteclient->Search($fields,
                                                                        $searchText,
                                                                        $types,
                                                                        $options,
                                                                        null, null, null, null,
                                                                        $this->impersonationName);
        } else {
            $presentationSearchResults = $this->mediasiteclient->Search($fields,
                                                                        $searchText,
                                                                        $types,
                                                                        $options);
        }
        $queryOptions->Options->BatchSize = $presentationSearchResults->Results->NextQueryOptions->BatchSize;
        $queryOptions->Options->QueryId = $presentationSearchResults->Results->NextQueryOptions->QueryId;
        $queryOptions->Options->StartIndex = $presentationSearchResults->Results->NextQueryOptions->StartIndex;
        if(!is_null($results)) {
            $results = $this->_presentation_search_mapping($presentationSearchResults);
        }
        if(!is_null($total)) {
            $total = $presentationSearchResults->Results->TotalResults;
        }
        if(!$presentationSearchResults->Results->MoreResultsAvailable) {
            return $presentationSearchResults->Results->MoreResultsAvailable;
        } else {
            return \json_encode($queryOptions);
        }
    }

    /**
     * @param string $searchText - Either a string or a \Sonicfoundry\SearchOptions class
     * @param $results - Results
     * @param $total - Total available
     * @param $limit - Limit the results returned.
     * @return true if there are more, false if there are no more
     */
    function QueryFolders($searchOptions = '', &$results=null, &$total=null, $limit=self::EDAS_QUERY_BATCH_SIZE, $start=0) {
        $fields = array(SupportedSearchField::Name);
        $types = array(SupportedSearchType::Folder);
        $options = new QueryOptions($limit, 'F'.(string)rand(), $start);
        $queryOptions = new EDASQueryOptions($limit, null, $start + $limit, $fields);
        if($searchOptions instanceof Sonicfoundry\SearchOptions) {
            if(!is_null($searchOptions->SearchText) && !empty($searchOptions->SearchText)) {
                $searchText = $searchOptions->SearchText;
                $searchText = $this->_transformRawSearchText($searchText);
                $searchText = $this->_tagify($searchText);
                $searchText = 'Name:('.$searchText.')';
           } else {
                $searchText = self::EDAS_WILDCARD_FOLDER_SEARCH;
            }
        } else {
            if (!is_null($searchOptions) &&
                !empty($searchOptions)) {
                $newOptions = json_decode($searchOptions);
                if(!is_null($newOptions) &&
                    isset($newOptions->Options) &&
                    isset($newOptions->Fields) &&
                    isset($newOptions->SearchString)) {
                    $searchText = $newOptions->SearchString;
                    $options = $newOptions->Options;
                    $fields = $newOptions->Fields;
                    $options->Options->BatchSize = $limit;
                    $options->Options->StartIndex = $start;
                } else {
                    $searchText = 'Name:(' . $searchOptions . ')';
                }
            } else {
                $searchText = self::EDAS_WILDCARD_FOLDER_SEARCH;
            }
        }
        $queryOptions->SearchString = $searchText;
        $queryOptions->Fields = $fields;
        if(!is_null($this->impersonationName) && $this->impersonationName) {
            $folderSearchResults = $this->mediasiteclient->Search($fields,
                                                                  $searchText,
                                                                  $types,
                                                                  $options,
                                                                  null, null, null, null,
                                                                  $this->impersonationName);
        } else {
            $folderSearchResults = $this->mediasiteclient->Search($fields,
                                                                  $searchText,
                                                                  $types,
                                                                  $options);
        }
        $queryOptions->Options->BatchSize = $folderSearchResults->Results->NextQueryOptions->BatchSize;
        $queryOptions->Options->QueryId = $folderSearchResults->Results->NextQueryOptions->QueryId;
        $queryOptions->Options->StartIndex = $folderSearchResults->Results->NextQueryOptions->StartIndex;
        if(!is_null($results)) {
            $results = $this->_folder_mapping($folderSearchResults);
        }
        if(!is_null($total)) {
            $total = $folderSearchResults->Results->TotalResults;
        }
        if(!$folderSearchResults->Results->MoreResultsAvailable) {
            return $folderSearchResults->Results->MoreResultsAvailable;
        } else {
            return \json_encode($queryOptions);
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
     * @param null|string $filter
     * @return \Sonicfoundry\Tag[]
     */
    function GetTagsForPresentation($resources, $filter=null) {
        $tags = array();
        try {
            if(is_array($resources)) {
                foreach($resources as $resource) {
                    $edasTags = $this->mediasiteclient->QueryTagsByMediasiteId($resource);
                    if(is_array($edasTags->Tags->string)) {
                        foreach($edasTags->Tags->string as $tag) {
                            array_push($tags, new Sonicfoundry\Tag($tag));
                        }
                    } else {
                        array_push($tags, new Sonicfoundry\Tag($edasTags->Tags->string));
                    }
                }
            } else {
                $edasTags = $this->mediasiteclient->QueryTagsByMediasiteId(array($resources));
                if(is_array($edasTags->Tags->string)) {
                    foreach($edasTags->Tags->string as $tag) {
                        array_push($tags, new Sonicfoundry\Tag($tag));
                    }
                } else {
                    array_push($tags, new Sonicfoundry\Tag($edasTags->Tags->string));
                }
            }
        } catch (\SoapFault $sf) {
            return $tags;
        }
        return $tags;
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Presenter[]
     */
    function GetPresentersForPresentation($resources, $filter=null) {
        if(is_array($resources)) {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById($resources);
        } else {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById(array($resources));
        }
        return $this->_presenter_mapping($edasPresentations);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @param bool $verbose
     * @return \Sonicfoundry\ThumbnailContent[]
     */
    function GetThumbnailContentForPresentation($resources, $filter=null) {
        if(is_array($resources)) {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById($resources);
        } else {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById(array($resources));
        }
        return $this->_thumbnail_mapping($edasPresentations);
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\SlideContent[]
     */
    function GetSlideContentForPresentation($resources, $filter=null) {
        $slides = array();
        if(is_array($resources)) {
            foreach($resources as $resource) {
                $edasPresentation = $this->mediasiteclient->QueryPresentationsById(array($resource));
                $edasSlides = $this->mediasiteclient->QuerySlides($edasPresentation->Presentations[0]->SlideCount, $resource, 0);
                foreach($this->_slide_mapping($edasSlides) as $slide) {
                    array_push($slides, $slide);
                }
            }
        } else {
            $edasPresentation = $this->mediasiteclient->QueryPresentationsById(array($resources));
            $edasSlides = $this->mediasiteclient->QuerySlides($edasPresentation->Presentations[0]->SlideCount, $resources, 0);
            $slides = $this->_slide_mapping($edasSlides);
        }
        return $slides;
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\LayoutOptions
     */
    function GetLayoutOptionsForPresentation($resources, $filter=null) {
        return null;
    }

    /**
     * @param string[]|string $resources
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function QueryPresentationById($resources) {
        if(is_array($resources)) {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById($resources);
        } else {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById(array($resources));
        }
        if(is_array($edasPresentations->Presentations)) {
            $presentations = array();
            foreach($edasPresentations->Presentations as $edasPresentation) {
                array_push($presentations, new Sonicfoundry\Presentation($edasPresentation));
            }
            if(count($presentations) > 1) {
                return $presentations;
            } else {
                return $presentations[0];
            }
        } else {
            return new Sonicfoundry\Presentation($edasPresentations->Presentations);
        }
    }

    /**
     * @param string[]|string $resourceId
     * @return string[]|string
     */
    function QueryPresentationPlaybackUrl($resourceId) {
        if(is_array($resourceId)) {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById($resourceId);
        } else {
            $edasPresentations = $this->mediasiteclient->QueryPresentationsById(array($resourceId));
        }
        $playbackUrls = array();
        foreach($edasPresentations->Presentations as $presentation) {
            array_push($playbackUrls, $presentation->PlayerUrl);
        }
        return $playbackUrls;
    }

    /**
     * @param string[]|string $resourceId
     * @return \Sonicfoundry\Catalog[]|\Sonicfoundry\Catalog
     */
    function QueryCatalogById($resourceId) {
        if(is_array($resourceId)) {
            $edasCatalogs = $this->mediasiteclient->QueryCatalogsById($resourceId);
        } else {
            $edasCatalogs = $this->mediasiteclient->QueryCatalogsById(array($resourceId));
        }
        if(is_array($edasCatalogs->Shares)) {
            $catalogs = array();
            foreach($edasCatalogs->Shares as $edasCatalog) {
                array_push($catalogs, new Sonicfoundry\Catalog($edasCatalog));
            }
            return $catalogs[0];
        } else {
            return new Sonicfoundry\Catalog($edasCatalogs->Shares);
        }
    }

    /**
     * @param string[]|string $resourceId
     * @return \Sonicfoundry\Folder[]|\Sonicfoundry\Folder
     */
    function QueryFolderById($resourceId) {
    }

    /**
     * @param string[]|string $resources
     * @param null|string $filter
     * @return \Sonicfoundry\Presentation[]|\Sonicfoundry\Presentation
     */
    function GetPresentationsForFolder($resources, $filter=null) {
    }

    /**
     * @param string[]|string $resources
     * @param array $properties
     */
    function ModifyCatalogProperty($resources, $properties) {
    }

    /**
     * @param string $username
     * @param string $resourceId
     * @param string $ip
     * @param int $duration
     * @return string
     */
    function CreateAuthTicket($username, $resourceId, $ip, $duration) {
        $authTicket = $this->mediasiteclient->CreateAuthTicket( $ip, $duration, $resourceId, $username );
        return $authTicket->AuthTicketId;
    }

    /**
     * @param string $resourceId
      * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyById($resourceId = '7788acb4-4533-4efd-a6d1-e9c74c025bfe') {
    }

    /**
     * @param string $apiname
     * @param bool $verbose
     * @return bool|\Sonicfoundry\ApiKey
     */
    function GetApiKeyByName($apiname = "MoodlePlugin") {
    }

    /**
     * @param string $apiname
     * @param bool $verbose
     * @return bool|\Sonicfoundry\ApiKey
     */
    function CreateApiKey($apiname = "MoodlePlugin") {
    }

    /**
     * @param string $Username
     * @param string $Password
     * @param null|string $ApplicationName
     * @param null|string $ImpersonationUsername
     * @return \LoginResponse
     */
    function Login($Username, $Password, $ApplicationName = null, $ImpersonationUsername = null) {
        return $this->mediasiteclient->Login($Username, $Password, $ApplicationName, $ImpersonationUsername);
    }

    /**
     * @param null|string $Ticket
     * @param null|string $ImpersonationUsername
     * @return \LogoutResponse
     */
    function Logout($Ticket = null, $ImpersonationUsername = null) {
        return $this->mediasiteclient->Logout($Ticket, $ImpersonationUsername);
    }
    function QueryPresentationsWithSlides() {
    }

} 