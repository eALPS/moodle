<?php

namespace Sonicfoundry;

class ApiKey {
    function __construct($json = null)
    {
        if(!is_null($json))
        {
            $this->Id = $json->Id;
            $this->Name = $json->Name;
            $this->TimeoutInMinutes = $json->TimeoutInMinutes;
            $this->IsDefault = $json->IsDefault;
            $this->CreateAuthTicketsForResources = $json->CreateAuthTicketsForResources;
            $this->ReportAuthFailureAsError = $json->ReportAuthFailureAsError;
        }
    }
    public $Id;
    public $Name;
    public $TimeoutInMinutes;
    public $IsDefault;
    public $CreateAuthTicketsForResources;
    public $ReportAuthFailureAsError;
}
