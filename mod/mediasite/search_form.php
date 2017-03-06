<?php
/**
 * search_form.php
 *
 * Define the search form used for searching Mediasite content
 * @author Kevin Burton
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/lib/formslib.php");
require_once("$CFG->dirroot/mod/mediasite/locallib.php");

/**
 * Class mod_mediasite_search_form
 * Extends the moodleform to define the search form used for searching
 * Mediasite content. It should be noted that this form submission is
 * handled in search.js
 */
class mod_mediasite_search_form extends moodleform {
    private $cid;
	function __construct($cid) {
		$this->cid = $cid;
		parent::__construct(null, null, 'post', '', array('id' => 'id_search_form'), true);
	}
	
    function definition() {
        $mform    =& $this->_form;
//-------------------------------------------------------------------------------
        $context = context_course::instance($this->cid);

        $mform->addElement('header', 'searchheader', get_string('searchheader', 'mediasite'));
        global $DB,$OUTPUT;
        $records = $DB->get_records('mediasite_sites');
        $defaults = $DB->get_record('mediasite_config', array());
        
        if (count($records) > 1 && has_capability('mod/mediasite:overridedefaults', $context)) {
            $sitenames = array();
            foreach ($records as $record) {
                $sitenames[$record->id] = $record->sitename;
            }
            $selectdropdown = $mform->addElement('select', 'siteid', get_string('sitenames', 'mediasite'), $sitenames, array('id' => 'id_siteid'));
            $selectdropdown->setSelected($defaults->siteid);
        } else {
            $mform->addElement('hidden', 'siteid', $defaults->siteid, array('id' => 'id_siteid'));
            $mform->setType('siteid', PARAM_INT);
            $mform->setDefault('siteid', $defaults->siteid);
        }
        
        $siteclient = 'odata';     
        if(isset($selectdropdown)) {
            foreach(array_keys($records) as $key) {
                if( implode("", $selectdropdown->getSelected()) == $key) {
                    $siteclient = $records[$key]->siteclient;              
                } 
            } 
        } else {               
                $siteclient = $records[$defaults->siteid]->siteclient;               
        }                 
        
        $resourcetypes = array(get_string('presentation', 'mediasite')=>get_string('presentation','mediasite'),get_string('catalog', 'mediasite')=>get_string('catalog','mediasite'));
        $mform->addElement('select','resourcetype',get_string('resourcetype','mediasite'),$resourcetypes,array('size'=>'1', 'id' => 'id_resourcetype'));
        $mform->addHelpButton('resourcetype', 'resource', 'mediasite');
        $mform->setType('resourcetype', PARAM_TEXT);
        $mform->setDefault('resourcetype', get_string('presentation', 'mediasite'));

        $mform->addElement('text', 'searchtext', get_string('searchtext', 'mediasite'), array('class' => 'sofo-search-text'));
        $mform->addHelpButton('searchtext', 'searchtext', 'mediasite');
        $mform->setType('searchtext', PARAM_TEXT);

//-------------------------------------------------------------------------------
        $mform->addElement('header', 'advancedsearchheader', get_string('advancedheader', 'mediasite'));

        $mform->addElement('html', \html_writer::tag('div', get_string('advancedsearchnotice', 'mediasite'), array('class' => 'sofo-search-selection-text')));

        $mform->addElement('advcheckbox', 'namesearch', null, get_string('advancedfieldname', 'mediasite'));
        $mform->setDefault('namesearch', 1);
        $mform->disabledIf('namesearch', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));
        $mform->addElement('advcheckbox', 'descriptionsearch', null, get_string('advancedfielddescription', 'mediasite'));
        $mform->setDefault('descriptionsearch', 1);
        $mform->disabledIf('descriptionsearch', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));
        $mform->addElement('advcheckbox', 'tagsearch', null, get_string('advancedfieldtag', 'mediasite'));
        $mform->setDefault('tagsearch', 1);
        $mform->disabledIf('tagsearch', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));
        $mform->addElement('advcheckbox', 'presentersearch', null, get_string('advancedfieldpresenter', 'mediasite'));
        if(!strcmp($siteclient, 'soap')) {
            $mform->freeze('presentersearch');
            $mform->setDefault('presentersearch', 0);
        } else {
            $mform->setDefault('presentersearch', 1);
        }
        $mform->disabledIf('presentersearch', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));

        $aftergroup=array();
        $aftergroup[] = $mform->createElement('advcheckbox', 'searchafterselect');
        $aftergroup[] = $mform->createElement('text', 'afterdate');
        $aftergroup[] = $mform->createElement('html', html_writer::tag('img', '', array('id' => 'id_aftercalendar', 'src'=>$OUTPUT->pix_url('i/calendar'))));
        $aftergroup[] = $mform->createElement('html', html_writer::tag('div', '', array('id' => 'id_afterdatecalendar', 'class' => 'afterdate')));
        $mform->addGroup($aftergroup, 'aftergroup', get_string('advancedsearchafter', 'mediasite'), ' ', false, false);
        $mform->setType('afterdate', PARAM_TEXT);
        $mform->disabledIf('aftergroup', 'searchafterselect');
        $mform->addHelpButton('aftergroup', 'afterdate', 'mediasite');
        $mform->disabledIf('aftergroup', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));

        $untilgroup=array();
        $untilgroup[] = $mform->createElement('advcheckbox', 'searchuntilselect');
        $untilgroup[] = $mform->createElement('text', 'untildate');
        $untilgroup[] = $mform->createElement('html', html_writer::tag('img', '', array('id' => 'id_untilcalendar', 'src'=>$OUTPUT->pix_url('i/calendar'))));
        $untilgroup[] = $mform->createElement('html', html_writer::tag('div', '', array('id' => 'id_untildatecalendar', 'class' => 'untildate')));
        $mform->addGroup($untilgroup, 'untilgroup', get_string('advancedsearchuntil', 'mediasite'),  ' ', false);
        $mform->setType('untildate', PARAM_TEXT);
        $mform->disabledIf('untilgroup', 'searchuntilselect');
        $mform->addHelpButton('untilgroup', 'untildate', 'mediasite');
        $mform->disabledIf('untilgroup', 'resourcetype', 'eq', get_string('catalog', 'mediasite'));

        if(!strcmp($siteclient, 'soap')) {
            $mform->freeze('aftergroup');
            $mform->freeze('untilgroup');
            $mform->setDefault('searchafterselect', 0);
            $mform->setDefault('searchuntilselect', 0);
        }

        if(method_exists($mform, 'setExpanded')) {
            $mform->setExpanded('advancedsearchheader',false);
        }
        $mform->closeHeaderBefore('submitbutton');
//-------------------------------------------------------------------------------

        $this->add_action_buttons(true, get_string('searchsubmit', 'mediasite'));

        //$mform->addElement('submit', 'searchsubmit', get_string('searchsubmit', 'mediasite'));

        $mform->addElement('hidden', 'course', $this->cid);
        $mform->setType('course', PARAM_INT);

        $mform->disable_form_change_checker();

    }

    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if(isset($data['untildate']) &&
            !empty($data['untildate']) &&
            isset($data['searchuntilselect']) &&
            $data['searchuntilselect']) {
            if(preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2})/', $data['untildate'], $matches) === 1) {
                if(!checkdate($matches[2], $matches[3], $matches[1])) {
                    $errors['untilgroup'] = get_string('invaliddate', 'mediasite', $data['untildate']);
                } else {
                    $untildate = \DateTime::createFromFormat('Y-m-d', $data['untildate']);
                    $now = new \DateTime();
                    if($untildate > $now) {
                        $errors['untilgroup'] =  get_string('futuredate', 'mediasite', $data['untildate']);
                    }
                }
            } else {
                $errors['untilgroup'] = get_string('invaliddateformat', 'mediasite', $data['untildate']);
            }
        }
        if(isset($data['afterdate']) &&
           !empty($data['afterdate']) &&
           isset($data['searchafterselect']) &&
           $data['searchafterselect']) {
            if(preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2})/', $data['afterdate'], $matches) === 1) {
                if(!checkdate($matches[2], $matches[3], $matches[1])) {
                    $errors['aftergroup'] = get_string('invaliddate', 'mediasite', $data['afterdate']);
                } else {
                    $afterdate = \DateTime::createFromFormat('Y-m-d', $data['afterdate']);
                    $now = new \DateTime();
                    if($afterdate > $now) {
                        $errors['aftergroup'] = get_string('futuredate', 'mediasite', $data['afterdate']);
                    }
                }
            } else {
                $errors['aftergroup'] = get_string('invaliddateformat', 'mediasite', $data['afterdate']);
            }
        }
        if(isset($afterdate) && isset($untildate)) {
            if($afterdate > $untildate) {
                $errorObject = new stdClass();
                $errorObject->after = $data['afterdate'];
                $errorObject->before = $data['untildate'];
                $errors['aftergroup'] = get_string('datecombination', 'mediasite', $errorObject);
                $errors['untilgroup'] = get_string('datecombination', 'mediasite', $errorObject);
            }
        }
        return $errors;
    }

}
?>