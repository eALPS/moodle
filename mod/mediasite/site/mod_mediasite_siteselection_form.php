<?php

namespace Sonicfoundry;

global $CFG;
require_once("$CFG->dirroot/lib/formslib.php");
require_once("$CFG->dirroot/mod/mediasite/lib.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");

class mod_mediasite_siteselection_form extends \moodleform {
    private $siteList = null;
    function __construct($sites) {
        $this->siteList = $sites;
        parent::__construct();
    }
    function definition() {
        $mform    = $this->_form;

        $options = array();
        if(is_array($this->siteList) && count($this->siteList) > 0) {
            foreach($this->siteList as $site) {
                $options[$site->id] = $site->sitename;
            }
        }

        global $OUTPUT;
        if(is_array($this->siteList) && count($this->siteList) > 0) {
            $table = new \html_table();
            $table->head = array(get_string('sitenametblhder', 'mediasite'), get_string('siteroottblhder', 'mediasite'), 
                                                get_string('usernametblhder', 'mediasite'), get_string('passthrutblhder','mediasite'),
                                                get_string('actiontblhder', 'mediasite'));
            foreach($this->siteList as $site) {
                $cells = array();
                $cells[] = new \html_table_cell($site->sitename);
                $cells[] = new \html_table_cell($site->endpoint);
                $cells[] = new \html_table_cell($site->username);
                $cells[] = new \html_table_cell($site->passthru ? "Enabled" : "Disabled");
                $actioncell = new \html_table_cell();
                $actioncell->text = $OUTPUT->action_icon(new \moodle_url('/mod/mediasite/site/edit.php',
                            array('site' => $site->id)),
                        new \pix_icon('t/editstring', get_string('actionedit', 'mediasite')))
                    ." ".
                    $OUTPUT->action_icon(new \moodle_url('/mod/mediasite/site/delete.php',
                            array('site' => $site->id)),
                        new \pix_icon('t/delete', get_string('actiondelete', 'mediasite')));
                $cells[] = $actioncell;
                $row = new \html_table_row();
                $row->cells = $cells;
                $table->data[] = $row;
            }
            $mform->addElement('html', \html_writer::table($table));
        } else {
            $mform->addElement('html',  \html_writer::tag('p', \get_string('nosites', 'mediasite')));
        }
        $mform->addElement('html', \html_writer::tag('input', '', array('value' => \get_string('siteaddbuttonlabel', 'mediasite'),
                                                                        'type' => 'button',
                                                                        'id' => 'id_siteaddbutton',
                                                                        'name' => 'siteaddbutton')));

//        $mform->addElement('html', $OUTPUT->action_icon(new \moodle_url('/mod/mediasite/site/add.php'),
//            new \pix_icon('t/add', 'Add a site')));
        //$mform->addElement('button', 'siteaddbutton', \get_string('siteaddbuttonlabel', 'mediasite'));


        global $DB;
        if(is_array($this->siteList)) {
            if(count($this->siteList) > 0) {
                if(!$defaults = $DB->get_record('mediasite_config', array())) {
                    $sites = array_values($this->siteList);
                    $site = $sites[0];
                    $record = new \stdClass();
                    $record->siteid = $site->id;
                    $record->openaspopup = 1;
                    $record->duration = 300;
                    $record->restrictip = 0;
                    $DB->insert_record('mediasite_config', $record);
                    $defaults = $DB->get_record('mediasite_config', array());
                }
            }
            if(count($this->siteList) > 1) {
                $selectdropdown = $mform->addElement('select', 'sites', \get_string('sitenames', 'mediasite'), $options);
                $selectdropdown->setSelected($defaults->siteid);
            }
        }

        $config = $DB->get_record('mediasite_config', array());
        if(!$config && is_array($this->siteList) && count($this->siteList) > 0) {
            echo \html_writer::tag('div', '* To complete the plugin configuration you must save the options below', array('class' => 'sofo-configuration-notice'));
        }

        $mform->addElement('text', 'duration', \get_string('duration', 'mediasite'));
        //$mform->addHelpButton('duration', 'duration', 'mediasite');
        if($config) {
            $mform->setDefault('duration', $config->duration);
        } else {
            $mform->setDefault('duration', 300);
        }
        $mform->setType('duration', PARAM_INT);

        $mform->addElement('advcheckbox', 'openaspopup', \get_string('openaspopup', 'mediasite') );
        //$mform->addHelpButton('openaspopup', 'openaspopup', 'mediasite');
        if($config) {
            $mform->setDefault('openaspopup', $config->openaspopup);
        } else {
            $mform->setDefault('openaspopup', 1);
        }

        $mform->addElement('advcheckbox', 'restrictip', \get_string('restrictip', 'mediasite') );
        //$mform->addHelpButton('restrictip', 'restrictip', 'mediasite');
        if($config) {
            $mform->setDefault('restrictip', $config->restrictip);
        } else {
            $mform->setDefault('restrictip', 0);
        }
        $this->add_action_buttons(TRUE, get_string('savechangebutton', 'mediasite'));
    }
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if($data['duration'] == '') {
            $errors['duration'] = get_string('blankduration', 'mediasite');
        } else {
            if(is_numeric($data['duration'])) {
                if($data['duration'] < 10) {
                    $errors['duration'] = get_string('smallduration', 'mediasite', $data['duration']);
                } elseif($data['duration'] > 1440) {
                    $errors['duration'] = get_string('longduration', 'mediasite', $data['duration']);
                }
            } else {
                $errors['duration'] = get_string('nonnumericduration', 'mediasite', $data['duration']);
            }
        }
        return $errors;
    }
}