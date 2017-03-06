<?php

namespace Sonicfoundry;

class MediasitePageSearchResult {
    function __construct($results, $totalCount, $site, $type, $searchString='', $pageIncrement=10, $pageSize=10, $queryId='') {
        $this->Results = $results;
        $this->TotalCount = $totalCount;
        $this->Site = $site;
        $this->Type = $type;
        $this->SearchString = $searchString;
        $this->PageIncrement = $pageIncrement;
        $this->PageSize = $pageSize;
        $this->QueryId = $queryId;
    }
    public $Results;
    public $TotalCount;
    public $Site;
    public $Type;
    public $SearchString;
    public $PageIncrement;
    public $PageSize;
    public $QueryId;
} 