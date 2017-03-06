<?php
require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->dirroot/lib/formslib.php");
require_once("$CFG->dirroot/mod/mediasite/mediasitesite.php");
require_once("$CFG->dirroot/mod/mediasite/mediasiteclientfactory.php");
require_once("$CFG->dirroot/mod/mediasite/presentation.php");
require_once("$CFG->dirroot/mod/mediasite/presenter.php");
require_once("$CFG->dirroot/mod/mediasite/thumbnailcontent.php");
require_once("$CFG->dirroot/mod/mediasite/slidecontent.php");
require_once("$CFG->dirroot/mod/mediasite/exceptions.php");

function mediasite_supports($feature) {
    switch($feature) {
        case FEATURE_GROUPS:                  return true;
        case FEATURE_GROUPINGS:               return true;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return false;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return true;
        case FEATURE_GRADE_OUTCOMES:          return true;
        case FEATURE_GRADE_HAS_GRADE:         return true;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_SHOW_DESCRIPTION:        return true;
        case FEATURE_ADVANCED_GRADING:        return true;
        case FEATURE_PLAGIARISM:              return true;

        default: return null;
    }
}

function mediasite_add_instance($data, $mform = null) {
    global $DB,$CFG;
    require_once("$CFG->libdir/resourcelib.php");

    $cmid = $data->coursemodule;

    $data->id = $DB->insert_record('mediasite', $data);

    return $data->id;
}
function mediasite_update_instance($data, $mform) {
    global $DB, $CFG;
    require_once("$CFG->libdir/resourcelib.php");

    $data->id    = $data->instance;

    $DB->update_record('mediasite', $data);

    return true;
}
function mediasite_delete_instance($mediasiteId) {
    global $DB;
    return $DB->delete_records("mediasite", array('id'=>$mediasiteId));
}
/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return cached_cm_info|null
 */
function mediasite_get_coursemodule_info($coursemodule) {
    global $DB;

    if ($mediasite = $DB->get_record('mediasite', array('id'=>$coursemodule->instance), 'id, course, name, description, resourceid, resourcetype, duration, restrictip, timecreated, siteid')) {
        if (empty($mediasite->name)) {
            // mediasite name missing, fix it
            $mediasite->name = "label{$mediasite->id}";
            $DB->set_field('mediasite', 'name', $mediasite->name, array('id'=>$mediasite->id));
        }
        if(!$record = $DB->get_record("mediasite_sites", array('id' => $mediasite->siteid))) {
            mediasite_delete_instance($mediasite->id);
            return null;
        }

        $site = new Sonicfoundry\MediasiteSite($record);
        $info = new cached_cm_info();
        // Convert intro to html. Do not filter cached version, filters run at display time.
        // $info->content = format_module_intro('mediasite', $mediasite, $coursemodule->id, false);
      try { // 2015-12-14: Fix the problem where course view crashes when Mediasite service is down.
        if($site->get_passthru() == 1) {
            global $USER;
            if($site->get_sslselect()) {
                global $CFG;
                $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username, $path);
            } else {
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), $USER->username);
            }
        } else {
            // Force traffic through Fiddler proxy
            //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),$site->get_username(),$site->get_password(), $site->get_apikey(), false, null, Sonicfoundry\WebApiExternalAccessClient::PROXY);
            if($site->get_sslselect()) {
                global $CFG;
                $path = $CFG->dirroot.'/mod/mediasite/cert/site'.$site->get_siteid().'.crt';
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey(), false, $path);
            } else {
                // Force traffic through Fiddler proxy
                //$client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(),$site->get_username(),$site->get_password(), $site->get_apikey(), false, null, Sonicfoundry\WebApiExternalAccessClient::PROXY);
                $client = Sonicfoundry\MediasiteClientFactory::MediasiteClient($site->get_siteclient(),$site->get_endpoint(), $site->get_username(), $site->get_password(), $site->get_apikey());
            }
        }
      }
      catch (Exception $ex) {
          $info->name  = $mediasite->name;
          return $info;
      }
        try {
            if($mediasite->resourcetype == get_string('presentation', 'mediasite')) {
                $presentation = $client->QueryPresentationById($mediasite->resourceid);
                try {
                    $layout = $client->GetLayoutOptionsForPresentation($mediasite->resourceid);
                } catch(Exception $ex) {
                    $layout = null;
                }
                $presenters = $client->GetPresentersForPresentation($mediasite->resourceid);
                $thumbnails = $client->GetThumbnailContentForPresentation($mediasite->resourceid, rawurlencode('StreamType eq \'Presentation\''));
                
                global $DB;
                $recordtime = strtotime($presentation->RecordDate);  
                $mediasite->timecreated = $recordtime;
                $mediasite->resourcetype = 'Presentation';
                $DB->update_record('mediasite', $mediasite);
                
                //$slides = $client->GetSlideContentForPresentation($mediasite->resourceid);
                if(count($thumbnails) > 1) {
                    usort($thumbnails, function($a, $b) {
                        if($a->ContentRevision == $b->ContentRevision) {
                            return 0;
                        }
                        return ($a->ContentRevision < $b->ContentRevision) ? 1 : -1;
                    });
                }
                if(!is_null($presentation)) {
                    global $CFG;
                    $content = html_writer::start_tag('div', array('class' => 'sofo-details'));
                    if(!is_null($thumbnails) && count($thumbnails) > 0) {
                        $content .= html_writer::tag('img', '', array('align' => 'right',
                                                                'class' => 'sofo-thumbnail',
                                                                'onerror' => 'this.style.display="none"',
                                                                'onload' => 'this.style.display="block"',
                                                                'src' => "$CFG->wwwroot/mod/mediasite".'/thumbnail.php?site='.$mediasite->siteid.'&resource='.$mediasite->resourceid.'&duration='.$mediasite->duration.'&restrictip='.$mediasite->restrictip.'&url='.$thumbnails[0]->ThumbnailUrl));
                    }

                    if(is_null($layout) || (isset($layout->ShowDateTime) && !is_null($layout->ShowDateTime) && $layout->ShowDateTime->Value)) {      
                        $content .= html_writer::tag('span', userdate($mediasite->timecreated, get_string('strftimedate')), array('class' => 'sofo-air-date'));
                    }
                    if(count($presenters) > 1) {
                        $content .= html_writer::start_tag('span', array('class' => 'sofo-presenter'));
                        $content .= html_writer::start_tag('ul', array('class' => 'sofo-presenter-list'));
                        for($i = 0; $i < count($presenters); $i++) {
                            $content .= html_writer::tag('li', ($presenters[$i]->DisplayName ? $presenters[$i]->DisplayName  . ' ' : ''));
                        }
                        $content .= html_writer::end_tag('ul');
                        $content .= html_writer::end_tag('span');
                    } elseif(count($presenters) == 1) {
                        $content .= html_writer::start_tag('span', array('class' => 'sofo-presenter'));
                        $content .= ($presenters[0]->DisplayName ? $presenters[0]->DisplayName  . ' ' : '');
                        $content .= html_writer::end_tag('span');
                    }
                    //$content .= html_writer::end_tag('div');
                    //$content .= html_writer::start_tag('div', array('class' => 'sofo-description-block'));
                    if(isset($mediasite->description) && !is_null($mediasite->description)) {
                        $content .= html_writer::tag('div', $mediasite->description, array('class' => 'sofo-description'));
                    }
                    $content .= html_writer::end_tag('div');
                    $info->content = $content;
                }
                $info->name  = $mediasite->name;
                return $info;
            } else {
                $catalog = $client->QueryCatalogById($mediasite->resourceid);
                global $DB;
                $mediasite->resourcetype = 'Catalog';
                $DB->update_record('mediasite', $mediasite);
                
                if(!is_null($catalog)) {
                    $content = html_writer::start_tag('div', array('class' => 'sofo-details'));
                    $content .= html_writer::tag('div', $mediasite->description, array('class' => 'sofo-description'));
                    $content .= html_writer::end_tag('div');
                    $info->content = $content;
                }
                $info->name  = $mediasite->name;             
                return $info;
            }
        } catch(Exception $ex) {
            $info->name  = $mediasite->name;
            return $info;
        }
    } else {
        return null;
    }
}
function mediasite_user_complete($mediasite) {

}
function mediasite_user_outline($mediasite) {

}
function mediasite_cron($mediasite) {

}
function mediasite_print_recent_activity($mediasite) {
}

?>
