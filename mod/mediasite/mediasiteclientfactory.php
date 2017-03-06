<?php

namespace Sonicfoundry;

require_once(dirname(__FILE__) . '/../../config.php');
global $CFG;
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");
require_once("$CFG->dirroot/mod/mediasite/edasmediasiteclient.php");
require_once("$CFG->dirroot/mod/mediasite/webapimediasiteclient.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_responses.php");
require_once("$CFG->dirroot/mod/mediasite/edasphpclient/edasproxy_functions.php");


class MediasiteClientFactory {
    static function MediasiteClient() {
        $numargs = func_num_args();
        if ($numargs > 0) {
            $siteClient = func_get_arg(0);
        } else {
            throw new SonicfoundryException("Invalid number of arguments", SonicfoundryException::INVALID_ARGUMENT);
        }
        $arg_list = func_get_args();
        array_shift($arg_list);
        if($siteClient === 'odata') {
            $reflection = new \ReflectionClass('Sonicfoundry\WebApiMediasiteClient');
            return $reflection->newInstanceArgs($arg_list);
        } elseif($siteClient === 'soap') {
            $reflection = new \ReflectionClass('Sonicfoundry\EDAS\EDASMediasiteClient');
            return $reflection->newInstanceArgs($arg_list);
        }
        return null;
    }
} 