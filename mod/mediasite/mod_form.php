<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/course/moodleform_mod.php");
require_once("$CFG->dirroot/mod/mediasite/locallib.php");
require_once("$CFG->dirroot/mod/mediasite/search_form.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");

defined('MOODLE_INTERNAL') || die();

class mod_mediasite_mod_form extends moodleform_mod {
    function __construct($data, $section, $cm, $course) {

        parent::__construct($data, $section, $cm, $course);

		global $CFG,$DB,$PAGE;
        $sites = $DB->get_records('mediasite_sites');
        $config = $DB->get_record('mediasite_config', array());
        if(!$config || is_null($config) ||
           !$sites  || is_null($sites) || count($sites) < 1) {
            // Go home
            print_error(get_string('incompleteconfiguration', 'mediasite'));
            redirect($CFG->wwwroot);
        }
        $PAGE->requires->js(new moodle_url('/mod/mediasite/js/load.js'), true);
    }

    function definition()
    {
        $mform = $this->_form;

//-------------------------------------------------------------------------------

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('hidden', 'gate');
        $mform->setType('gate', PARAM_INT);
        $mform->setDefault('gate', 0);

        global $CFG,$COURSE;

        $searchbutton = $mform->addElement('button', 'searchbutton', get_string('opensearchwindow', 'mediasite'));
        $buttonattributes = array('title'=>get_string('searchsubmit', 'mediasite'), 'onclick'=>"return window.open('"
            . "$CFG->wwwroot/mod/mediasite/search.php?course=". strval($COURSE->id)
            . "', 'mediasitesearch', 'menubar=1,location=1,directories=1,toolbar=1,scrollbars,resizable,width=800,height=600');");
        $searchbutton->updateAttributes($buttonattributes);

        $mform->addElement('text', 'name', get_string('resourcetitle', 'mediasite'), array('size' => '97'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'server');

        $mform->addElement('textarea', 'description', get_string('description', 'mediasite'), array('wrap' => "virtual",
                                                                                                    'rows' => 20,  'cols' => 100 ));
        $mform->setType('description', PARAM_TEXT);
//        $mform->disabledIf('description', 'gate', 'eq', 0);
//
//        $mform->addElement('editor', 'description', get_string('description', 'mediasite'));
//        $mform->setType('description', PARAM_RAW);

        if(isset($this->current->resourceid)) {
            $condition = array('id' => $this->current->siteid);
            global$DB;
            if($DB->record_exists("mediasite_sites", $condition)) {
                $record = $DB->get_record("mediasite_sites", $condition);
                $site = new Sonicfoundry\MediasiteSite($record);
                if($site->get_passthru()) {
                    global $USER;
                    if($site->get_sslselect()) {
                        global $CFG;
                        $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
                        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                            $site->get_username(),
                            $site->get_password(),
                            $site->get_apikey(),
                            $USER->username,
                            $path);
                    } else {
                        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                            $site->get_username(),
                            $site->get_password(),
                            $site->get_apikey(),
                            $USER->username);
                    }
                } else {
                    if($site->get_sslselect()) {
                        global $CFG;
                        $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
                        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                            $site->get_username(),
                            $site->get_password(),
                            $site->get_apikey(),
                            false,
                            $path);
                    } else {
                        $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),
                            $site->get_username(),
                            $site->get_password(),
                            $site->get_apikey());
                    }
                }
                if($this->current->resourcetype == 'Presentaion') {
                    $presentation = $client->QueryPresentationById($this->current->resourceid);
                    $mform->setDefault('description', $presentation->Description);
                } else if($this->current->resourcetype == get_string('catalog', 'mediasite')) {
                    $catalog = $client->QueryCatalogById($this->current->resourceid);
                    $mform->setDefault('description', $catalog->Description);
                }
            }
        }
        $context = context_course::instance($COURSE->id);

        if(has_capability('mod/mediasite:overridedefaults', $context)) {
            $mform->addElement('advcheckbox', 'openaspopup', null, \get_string('openaspopup', 'mediasite'));
            $mform->addHelpButton('openaspopup', 'openaspopup', 'mediasite');
            $mform->setDefault('openaspopup', 1);
        } else {
            $mform->addElement('hidden', 'openaspopup');
            $mform->setType('openaspopup', PARAM_INT);
        }

        global $DB;
        $config = $DB->get_record('mediasite_config', array());
        if($config) {
            $mform->setDefault('openaspopup', $config->openaspopup);
        }

        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();

        // add standard buttons, common to all modules
        $this->add_action_buttons();

        $mform->closeHeaderBefore('siteid');

        $mform->addElement('hidden', 'siteid', -1, array('id' => 'id_siteid'));
        $mform->setType('siteid', PARAM_INT);

        $mform->addElement('hidden', 'resourcetype', '', array('id' => 'id_resourcetype'));
        $mform->setType('resourcetype', PARAM_TEXT);

        $mform->addElement('hidden', 'resourceid', '', array('id' => 'id_resourceid'));
        $mform->setType('resourceid', PARAM_TEXT);

        global $COURSE,$CFG;
        $mform->addElement('hidden',
            'searchurl',
            "$CFG->wwwroot/mod/mediasite/search.php?" . 'course=' . strval($COURSE->id),
            array('id' => 'id_searchurl'));
        $mform->setType('searchurl', PARAM_TEXT);

        if(method_exists($mform,'setExpanded')) {
            $mform->setExpanded('modstandardelshdr', false);
        }

    }

//    function data_preprocessing(&$default_values) {
//        if ($this->current->instance) {
//            $draftitemid = file_get_submitted_draft_itemid('mediasite');
//            $default_values['mediasite']['format'] = $default_values['contentformat'];
//            $default_values['mediasite']['text']   = file_prepare_draft_area($draftitemid, $this->context->id, 'mod_page', 'content', 0, mediasite_get_editor_options($this->context), $default_values['content']);
//            $default_values['mediasite']['itemid'] = $draftitemid;
//        }
//        if (!empty($default_values['displayoptions'])) {
//            $displayoptions = unserialize($default_values['displayoptions']);
//            if (isset($displayoptions['printintro'])) {
//                $default_values['printintro'] = $displayoptions['printintro'];
//            }
//            if (!empty($displayoptions['popupwidth'])) {
//                $default_values['popupwidth'] = $displayoptions['popupwidth'];
//            }
//            if (!empty($displayoptions['popupheight'])) {
//                $default_values['popupheight'] = $displayoptions['popupheight'];
//            }
//        }
//    }

    function mediasite_get_editor_options($context) {

    }
    function definition_after_data()
    {
        //$users = get_enrolled_users(context_course::instance($this->_courseid));
        //$roles = get role_archetypes();
        //$roles = get_all_roles();
        //$roles = get_user_roles(context_course::instance($this->_courseid));
        parent::definition_after_data();
    }

    function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        global $USER;

        if(!isset($data['resourceid']) || is_null($data['resourceid']) || !isset($data['siteid']) || $data['siteid'] < 0 || !isset($data['resourcetype']) ||
            ($data['resourcetype'] != get_string('presentation', 'mediasite') && $data['resourcetype'] != get_string('catalog', 'mediasite'))) {
                $errors['name'] = 'This form should only be used after a resource has been selected by the search form.';
                return $errors;
        }
        try {
            //validate the current user has access to the selected resource
            $valid = mediasite_check_resource_permission($data['resourceid'], $data['resourcetype'], $USER->username);
            if (!$valid) {
                $errors['resourceid'] = get_string('notauthorized', 'mediasite');
            }
        } catch (\Sonicfoundry\SonicfoundryException $se) {
            $errors['resourceid'] = $se->getMessage();
        } catch (Exception $e) {
            $errors['resourceid'] = $e->getMessage();
        }

        return $errors;
    }
}

?>
