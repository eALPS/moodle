<?php
require_once(dirname(__FILE__) . '/../../../config.php');
require_once("$CFG->dirroot/lib/formslib.php");
require_once("$CFG->dirroot/mod/mediasite/lib.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("$CFG->dirroot/mod/mediasite/utility.php");

class mod_mediasite_site_form extends \moodleform {
    private $siteToEdit = null;
    function __construct(Sonicfoundry\MediasiteSite $site = null) {
        $this->siteToEdit = $site;
        parent::__construct();
    }
    function definition() {
        $mform    =& $this->_form;
        $maxbytes = 100000;
//-------------------------------------------------------------------------------
//        $mform->addElement('header', 'siteheader', get_string('siteheader', 'mediasite'));
//-------------------------------------------------------------------------------
        if(is_null($this->siteToEdit)) {
            $mform->addElement('text', 'sitename', get_string('sitename', 'mediasite'), array('class' => 'sofo-site-name'));
            $mform->setType('sitename', PARAM_TEXT);
            $mform->addElement('text', 'siteurl', get_string('serverurl', 'mediasite'), array('class' => 'sofo-site-url'));
            $mform->setType('siteurl', PARAM_TEXT);
            $mform->addElement('text', 'siteusername', get_string('username', 'mediasite'), array('class' => 'sofo-username'));
            $mform->setType('siteusername', PARAM_TEXT);
            $mform->addElement('passwordunmask', 'sitepassword', get_string('password', 'mediasite'), array('class' => 'sofo-password'));
            $mform->setType('sitepassword', PARAM_TEXT);
            $mform->addElement('advcheckbox', 'sitepassthru', get_string('passthru', 'mediasite') );
            $mform->setType('sitepassthru', PARAM_INT);

            $mform->addElement('filepicker', 'cert', get_string('certformat', 'mediasite'), null, array('maxbytes' => $maxbytes));

            $mform->addElement('hidden', 'site', 0);
            $mform->setType('site', PARAM_INT);
            $this->add_action_buttons(TRUE, get_string('siteaddbuttonlabel', 'mediasite'));
        } else {
            $mform->addElement('text', 'sitename', get_string('sitename', 'mediasite'));
            $mform->setType('sitename', PARAM_TEXT);
            $mform->setDefault('sitename',$this->siteToEdit->get_sitename());

            $mform->addElement('text', 'siteurl', get_string('serverurl', 'mediasite'));
            $mform->setType('siteurl', PARAM_TEXT);
            $mform->setDefault('siteurl',$this->siteToEdit->get_endpoint());

            $mform->addElement('text', 'siteusername', get_string('username', 'mediasite'));
            $mform->setType('siteusername', PARAM_TEXT);
            $mform->setDefault('siteusername',$this->siteToEdit->get_username());

            $mform->addElement('passwordunmask', 'sitepassword', get_string('password', 'mediasite'));
            $mform->setType('sitepassword', PARAM_TEXT);
            $mform->setDefault('sitepassword',$this->siteToEdit->get_password());

            $mform->addElement('advcheckbox', 'sitepassthru', get_string('passthru', 'mediasite') );
            $mform->setType('sitepassthru', PARAM_INT);
            $mform->setDefault('sitepassthru',$this->siteToEdit->get_passthru());

            $mform->addElement('filepicker', 'cert', get_string('certformat', 'mediasite'), null, array('maxbytes' => $maxbytes));

            $mform->addElement('hidden', 'site', $this->siteToEdit->get_siteid());
            $mform->setType('site', PARAM_INT);
            $this->add_action_buttons(TRUE, get_string('savechangebutton', 'mediasite') );
        }
    }
    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if(isset($data['sitename']) && strlen($data['sitename']) > 0) {
            if(strlen($data['sitename']) > 254) {
                $errors['sitename'] = get_string('longsitename', 'mediasite');
                return $errors;
            }
        } else {
            $errors['sitename'] = get_string('requiredsitename', 'mediasite');
        }
        if(isset($data['siteusername']) && strlen($data['siteusername']) > 3) {
            if(strlen($data['siteusername']) > 254) {
                $errors['siteusername'] = get_string('longsiteusername', 'mediasite');
                return $errors;
            }
        } else {
            $errors['siteusername'] = get_string('requiredsiteusername', 'mediasite');
            return $errors;
        }
        if(isset($data['sitepassword']) && strlen($data['sitepassword']) > 3) {
            if(strlen($data['sitepassword']) > 254) {
                $errors['sitepassword'] = get_string('longsitepassword', 'mediasite');
                return $errors;
            }
        } else {
            $errors['sitepassword'] = get_string('requiredsitepassword', 'mediasite');
            return $errors;
        }

        $url = $data['siteurl'];
        if(!preg_match('%\bhttps?:\/\/%si',$url)) {
            $url = 'http://'.$url;
        }
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url))
        {
            $errors['siteurl'] = get_string('invalidURL', 'mediasite');
            return $errors;
        }

        if(isset($data['sitename'])) {
            global $DB;
            $sites = $DB->get_records('mediasite_sites', null, '', 'sitename');
            foreach($sites as $site) {
                if(strtolower($data['sitename']) == strtolower($site->sitename)) {
                    if(is_null($this->siteToEdit)) {
                        $errors['sitename'] = get_string('duplicatesitename', 'mediasite', $data['sitename']);
                        break;
                    } elseif($data['sitename'] != $this->siteToEdit->get_sitename()) {
                        $errors['sitename'] = get_string('duplicatesitename', 'mediasite', $data['sitename']);
                        break;
                    }
                }
            }
            if(strlen($data['sitename']) > 254) {
                $errors['sitename'] = get_string('longsitename', 'mediasite');
                return $errors;
            }
        } else {
            $errors['sitename'] = get_string('requiredsitename', 'mediasite');
        }
        if(count($errors) > 0) {
            return $errors;
        }

        if(!Sonicfoundry\EndsWith($url, '/')) {
            $url .= '/';
        }

        $matches = array();
        $siteclient = 'odata';
        try {
            // For SOAP Fiddler
            //$additional_options = array('proxy_host' => 'localhost', 'proxy_port' => 8888);
            //$soapclient = Sonicfoundry\MediasiteClientFactory::MediasiteClient('soap', $url, $data['siteusername'], $data['sitepassword'], null, null, null, $additional_options);
            $soapclient = Sonicfoundry\MediasiteClientFactory::MediasiteClient('soap', $url, $data['siteusername'], $data['sitepassword']);
            $siteproperties = $soapclient->QuerySiteProperties();
            $version = $siteproperties->SiteVersion;
            if(preg_match('/(6|7)\.(\d+)\.(\d+)/i', $version, $matches)) {
                if(count($matches) < 4) {
                    $errors['siteurl'] = get_string('invalidversion', 'mediasite', $version);
                    return $errors;
                }
                if($matches[1] == 6) {
                    $siteclient = 'soap';
                    if($matches[2] != 1 ||
                       $matches[3] < 13) {
                        $errors['siteurl'] = get_string('unsupportedversion', 'mediasite', $version);
                        return $errors;
                    }
                } elseif($matches[1] == 7) {
                    $siteclient = 'odata';
                    if($matches[2] == 0) {
                        if($matches[3] < 5) {
                            $errors['siteurl'] = get_string('unsupportedversion', 'mediasite', $version);
                            return $errors;
                        }
                    }
                } else {
                    $errors['siteurl'] = get_string('unsupportedversion', 'mediasite', $version);
                    return $errors;
                }
            } else {
                $errors['siteurl'] = get_string('invalidversion', 'mediasite', $version);
                return $errors;
            }
            $soapclient->Logout();
        } catch(SoapFault $sf) {
            if($sf->faultcode === 'WSDL') {
                $errors['siteurl'] = get_string('invalidserviceroot', 'mediasite');
            } elseif(Sonicfoundry\EndsWith($sf->faultcode,'MediasiteAuthenticationException')) {
                if($sf->detail->DataServiceFault->FaultType === 'Authentication') {
                    $errors['siteusername'] = get_string('invalidcred', 'mediasite');
                } else {
                    $errors['sitename'] = get_string('unknownexception', 'mediasite', $sf->getMessage());
                }
                return $errors;
            } else {
                $errors['sitename'] = get_string('unknownexception', 'mediasite', $sf->getMessage());
            }
            return $errors;
        } catch(Exception $ex) {
            $errors['sitename'] = get_string('unknownexception', 'mediasite', $ex->getMessage());
            return $errors;
        }
        if(preg_match('%\bhttps:\/\/%si',$url)) {
            $files = $this->get_draft_files('cert');
            if(!is_null($files)) {
                $file = reset($files);
                $content = $file->get_content();
                if(!$content || is_null($content)) {
                    $errors['siteurl'] = get_string('nocert', 'mediasite');
                    return $errors;
                }
            } else {
                $errors['siteurl'] = get_string('nocert', 'mediasite');
                return $errors;
            }
        }

        if($siteclient === 'odata') {
            // ODATA/WebApi validation
            $url .= Sonicfoundry\WebApiExternalAccessClient::VERSION;
            $ch = curl_init();
            $curlOptions = array(CURLOPT_FAILONERROR => TRUE,
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                    CURLOPT_HEADER => 0,
                    CURLOPT_VERBOSE => false,
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPGET => TRUE,
                    CURLOPT_HTTPHEADER => array ('Accept: ' . 'application/json'),
                    CURLOPT_SSL_VERIFYHOST => FALSE,
                    CURLOPT_SSL_VERIFYPEER => FALSE);
            curl_setopt_array($ch, $curlOptions);
            if( $result = curl_exec($ch))
            {
                if(!preg_match('/[^<]+<!DOCTYPE.*window.location.href.*Login\?ReturnUrl/si',$result)) {
                    $json = json_decode($result);
                    if(is_null($json) || $json == false) {
                        $errors['siteurl'] = get_string('invalidformat', 'mediasite');
                        curl_close($ch);
                        return $errors;
                    }
                    $found = false;
                    foreach($json->value as $value) {
                        if($value->name == 'Home') {
                            $found = true;
                            break;
                        }
                    }
                    if(!$found) {
                        $errors['siteurl'] = get_string('no70', 'mediasite');
                        curl_close($ch);
                        return $errors;
                    }
                }
            }

            $curlOptions = array(CURLOPT_FAILONERROR => TRUE,
                                CURLOPT_FOLLOWLOCATION => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                                CURLOPT_HEADER => 0,
                                CURLOPT_VERBOSE => false,
                                CURLOPT_URL => $url.'Home',
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . 'application/json'),
                                CURLOPT_SSL_VERIFYHOST => FALSE,
                                CURLOPT_SSL_VERIFYPEER => FALSE);
            curl_setopt_array($ch, $curlOptions);
            if( !$result = curl_exec($ch))
            {
                $errors['siteurl'] = get_string('invalidserviceroot', 'mediasite');
                curl_close($ch);
                return $errors;
            }
            $json = json_decode($result);
            if(is_null($json) || $json == false) {
                $errors['siteurl'] = get_string('invalidformat', 'mediasite');
                curl_close($ch);
                return $errors;
            }
            if(isset($json->siteVersion)) {
                $errors['siteurl'] = get_string('wrongversion', 'mediasite', $json->siteVersion);
                curl_close($ch);
                return $errors;
            }
            if(!isset($json->SiteVersion) || !preg_match('/(\d+)\.(\d+)\.(\d+)/', $json->SiteVersion, $matches)) {
                $errors['siteurl'] = get_string('noversion', 'mediasite');
                curl_close($ch);
                return $errors;
            } elseif(count($matches) < 4 || $matches[1] < 7 || 
                    ($matches[1] == 7 && $matches[2] == 0 && $matches[3] < 5)) {
                $errors['siteurl'] = get_string('invalidversion', 'mediasite', $json->SiteVersion);
                curl_close($ch);
                return $errors;
            }

            $authorization = 'Authorization: '.'Basic '.base64_encode($data['siteusername'] . ':' . $data['sitepassword']);
            $curlOptions = array(CURLOPT_FAILONERROR => TRUE,
                                CURLOPT_FOLLOWLOCATION => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                                CURLOPT_HEADER => 0,
                                CURLOPT_VERBOSE => false,
                                CURLOPT_URL => $url.'ApiKeys(\'7788acb4-4533-4efd-a6d1-e9c74c025bfe\')',
                                CURLOPT_HTTPGET => TRUE,
                                CURLOPT_HTTPHEADER => array ('Accept: ' . 'application/json',
                                                            $authorization),
                                CURLOPT_SSL_VERIFYHOST => FALSE,
                                CURLOPT_SSL_VERIFYPEER => FALSE);
            // Force traffic through Fiddler proxy
            //$proxy = Sonicfoundry\WebApiExternalAccessClient::PROXY;
            $proxy = '';
            if(!empty($proxy))
            {
                $curlOptions[CURLOPT_PROXY] = $proxy;
            }
            curl_setopt_array($ch, $curlOptions);
            if( !$result = curl_exec($ch))
            {
                $errors['siteusername'] = get_string('invalidcred', 'mediasite');
                curl_close($ch);
                return $errors;
            }
            $json = json_decode($result);
            if(!isset($json->Name) || $json->Name != 'MoodlePlugin') {
                $errors['siteurl'] = getstring('invalidapikey', 'mediasite');
                curl_close($ch);
                return $errors;
            }
            // Now check the certificate
            if(preg_match('%\bhttps:\/\/%si',$url)) {
                global $CFG;
                if(!file_exists($CFG->dirroot.'/mod/mediasite/cert')) {
                    if(!mkdir($CFG->dirroot.'/mod/mediasite/cert', 0777, true)) {
                        die('Failed to create cert folder');
                    }
                }
                if(!is_writable($CFG->dirroot.'/mod/mediasite/cert')) {
                    $errors['siteurl'] = get_string('nowritepermissions', 'mediasite', $CFG->dirroot.'/mod/mediasite/cert');
                    return $errors;
                }
                $certinfo = $CFG->dirroot.'/mod/mediasite/cert/'.'test.crt';
                $certhandle = @fopen($certinfo,'x');
                if($certhandle) {
                    $byteswritten = fwrite($certhandle, $content);
                    fflush($certhandle);
                    fclose($certhandle);
                }
                $curlOptions = array(CURLOPT_FAILONERROR => TRUE,
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_USERAGENT => "Mediasite Moodle Plugin",
                    CURLOPT_HEADER => 0,
                    CURLOPT_VERBOSE => false,
                    CURLOPT_URL => $url.'Home',
                    CURLOPT_HTTPGET => TRUE,
                    CURLOPT_HTTPHEADER => array ('Accept: ' . 'application/json'),
                    CURLOPT_CAINFO => $certinfo,
                    CURLOPT_SSLVERSION => 3,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => TRUE);
                curl_setopt_array($ch, $curlOptions);
                if( !$result = curl_exec($ch)) {
                    $errors['siteurl'] = get_string('invalidcert', 'mediasite');
                    return $errors;
                }
                unlink($certinfo);
            }
            curl_close($ch);
        } else {
            //SOAP/EDAS validation
            // Now check the certificate
            if(preg_match('%\bhttps:\/\/%si',$url)) {
                global $CFG;
                if(!file_exists($CFG->dirroot.'/mod/mediasite/cert')) {
                    if(!mkdir($CFG->dirroot.'/mod/mediasite/cert', 0777, true)) {
                        die('Failed to create cert folder');
                    }
                }
                if(!is_writable($CFG->dirroot.'/mod/mediasite/cert')) {
                    $errors['siteurl'] = get_string('nowritepermissions', 'mediasite', $CFG->dirroot.'/mod/mediasite/cert');
                    return $errors;
                }
                $certinfo = $CFG->dirroot.'/mod/mediasite/cert/'.'test.crt';
                $certhandle = @fopen($certinfo,'x');
                if($certhandle) {
                    $byteswritten = fwrite($certhandle, $content);
                    fflush($certhandle);
                    fclose($certhandle);
                }

//                $additional_options = array('local_cert' => $certinfo,
//                                            'verify_peer' => false,
//                                            'verify_host' => false,
//                                            'allow_self_signed' => true);
                $soapclient = Sonicfoundry\MediasiteClientFactory::MediasiteClient('soap',
                                                                                   $url,
                                                                                   $data['siteusername'],
                                                                                   $data['sitepassword'],
                                                                                   null,
                                                                                   null,
                                                                                   $certinfo);
                $siteproperties = $soapclient->QuerySiteProperties();
                $version = $siteproperties->SiteVersion;
                unlink($certinfo);
            }
        }
        return $errors;
    }
}