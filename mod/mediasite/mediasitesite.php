<?php

namespace Sonicfoundry;

/**
 * Class MediasiteSite
 * @package Sonicfoundry
 */
class MediasiteSite {
    private $id;
    private $sitename;
    private $endpoint;
    private $apikey;
    private $username;
    private $password;
    private $siteclient;
    private $passthru;
    private $sslselect;
    private $cert;
    function __construct($record = null) {
        if(!is_null($record)) {
            if($record instanceof MediasiteSite) {
                $this->id = $record->id;
                $this->sitename = $record->sitename;
                $this->endpoint = $record->endpoint;
                $this->apikey = $record->apikey;
                $this->username = $record->username;
                $this->password = $record->password;
                $this->siteclient = $record->siteclient;
                $this->passthru = $record->passthru;
                $this->sslselect = $record->sslselect;
                $this->cert = $record->cert;
            } elseif($record instanceof \stdClass) {
                $this->id = $record->id;
                $this->sitename = $record->sitename;
                $this->endpoint = $record->endpoint;
                $this->apikey = $record->apikey;
                $this->username = $record->username;
                $this->password = $record->password;
                $this->siteclient = $record->siteclient;
                $this->passthru = $record->passthru;
                $this->sslselect = $record->sslselect;
                $this->cert = $record->cert;
            } elseif(is_numeric($record)) {
                global $DB;
                $record = $DB->get_record('mediasite_sites', array('id'=>$record));
                if($record) {
                    $this->id = $record->id;
                    $this->sitename = $record->sitename;
                    $this->endpoint = $record->endpoint;
                    $this->apikey = $record->apikey;
                    $this->username = $record->username;
                    $this->password = $record->password;
                    $this->siteclient = $record->siteclient;
                    $this->passthru = $record->passthru;
                    $this->sslselect = $record->sslselect;
                    $this->cert = $record->cert;
                }
            }
        }
    }
    function update_database() {
        $record = new \stdClass();
        $record->id = $this->id;
        $record->sitename = $this->sitename;
        $record->endpoint = $this->endpoint;
        $record->apikey = $this->apikey;
        $record->username = $this->username;
        $record->password = $this->password;
        $record->siteclient = $this->siteclient;
        $record->passthru = $this->passthru;
        $record->sslselect = $this->sslselect;
        $record->cert = $this->cert;
        global $DB;
        $DB->update_record('mediasite_sites', $record);
    }
    function get_siteid() {
        return $this->id;
    }
    function set_sitename($value) {
        $this->sitename = $value;
    }
    function get_sitename() {
        return $this->sitename;
    }
    function set_endpoint($value) {
        $this->endpoint = $value;
    }
    function get_endpoint() {
        return $this->endpoint;
    }
    function set_apikey($value) {
        $this->apikey = $value;
    }
    function get_apikey() {
        return $this->apikey;
    }
    function set_username($value) {
        $this->username = $value;
    }
    function get_username() {
        return $this->username;
    }
    function set_password($value) {
        $this->password = $value;
    }
    function get_password() {
        return $this->password;
    }
    function set_siteclient($value) {
        $this->siteclient = $value;
    }
    function get_siteclient() {
        return $this->siteclient;
    }
    function get_passthru() {
        return $this->passthru;
    }
    function set_passthru($value) {
        $this->passthru = $value;
    }
    function get_sslselect() {
        return $this->sslselect;
    }
    function set_sslselect($value) {
        $this->sslselect = $value;
    }
    function get_cert() {
        return $this->cert;
    }
    function set_cert($value) {
        $this->cert = $value;
    }
    static function loadbyname($name) {
        global $DB;
        if($record = $DB->get_record('mediasite_sites', array('sitename'=>$name))) {
            $site = new MediasiteSite($record);
            return $site;
        } else {
            return FALSE;
        }
    }
}
