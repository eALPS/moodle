<?php

require_once __DIR__.'/../../config.php';
require_once __DIR__.'/class/table.php';

/* @var $DB moodle_database */
/* @var $CFG object */
/* @var $USER object */
/* @var $PAGE moodle_page */
/* @var $OUTPUT core_renderer */

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$PAGE->set_url('/local/fxlmslink/view.php', array('id' => $cm->id));

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
require_login($course, false, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/assign:grade', $context);

$PAGE->set_title(get_string('pluginname', 'assign') . ': ' . get_string('pluginname', 'local_fxlmslink'));
$PAGE->set_heading($course->fullname);

$assign = new fxlmslink\assign($context, $cm, $course);
if (!$assign->is_file_submission_enabled()) {
    redirect(new moodle_url('/mod/assign/view.php', array('id' => $id)));
}

if ($grades = optional_param_array('grades', array(), PARAM_FLOAT)) {
    foreach ($grades as $userid => $grade) {
        if ($grade != $assign->get_deferred_submission_grade($userid, MUST_EXIST)) {
            $assign->update_deferred_submission_grade($userid, $grade);
        }
    }
}
if (!empty($_FILES['files']['error']) && is_array($_FILES['files']['error'])) {
    foreach ($_FILES['files']['error'] as $userid => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $filename = $_FILES['files']['name'][$userid];
            $filepath = $_FILES['files']['tmp_name'][$userid];
            $assign->update_deferred_submission_file($userid, $filename, file_get_contents($filepath));
        }
    }
}

if (optional_param('finish', null, PARAM_TEXT)) {
    $assign->finish_deferred_submissions();
    redirect(new moodle_url('/mod/assign/view.php', array('id' => $id, 'action' => 'grading')));
}
if (optional_param('cancel', null, PARAM_TEXT)) {
    $assign->delete_deferred_submissions();
    redirect($PAGE->url);
}
if (optional_param('update', null, PARAM_TEXT)) {
    redirect($PAGE->url);
}

$table = new fxlmslink\table($assign);

$strfinish = get_string('finishsubmissions', 'local_fxlmslink');
$strcancel = get_string('cancelsubmissions', 'local_fxlmslink');
$strcofirmation = get_string('confirmationremoved', 'local_fxlmslink');

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($cm->name, false, array('context' => $context)));

if ($table->record_exists()) {
    echo $OUTPUT->box_start('boxaligncenter gradingtable');
    
    echo html_writer::start_tag('form', array('class' => 'mform', 'action' => $PAGE->url->out_omit_querystring(),
                                              'method' => 'post', 'enctype' => 'multipart/form-data'));
    echo html_writer::input_hidden_params($PAGE->url);
    
    echo $table->out($table->count_records(), false);
    echo html_writer::empty_tag('input', array('type' => 'submit', 'name' => 'update', 'style' => 'display:none'));
    
    echo html_writer::input_hidden_params($PAGE->url);
    
    echo html_writer::start_tag('div', array('class' => 'fitem'));
    echo html_writer::start_tag('div', array('class' => 'felement'));
    
    // 保留領域の全登録ボタン 確認画面無し
    $urlfinish = new moodle_url('/local/fxlmslink/view.php', array('finish' => $strfinish));
    $btnfinish = new single_button($urlfinish, $strfinish, 'post');
    echo $OUTPUT->render($btnfinish);
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');
    
    echo html_writer::end_tag('form');
    
    echo $OUTPUT->box_end();
    
    // 保留領域の全削除ボタン 確認画面有り
    echo $OUTPUT->box_start('boxaligncenter gradingtable');
    echo html_writer::start_tag('form', 
                                array('class' => 'mform',
                                      'action' => $PAGE->url->out_omit_querystring(),
                                      'method' => 'post', 'enctype' => 'multipart/form-data'));
    echo html_writer::input_hidden_params($PAGE->url);
    
    echo html_writer::start_tag('div', array('class' => 'fitem'));
    echo html_writer::start_tag('div', array('class' => 'felement'));
    
    $urlcancel = new moodle_url('/local/fxlmslink/view.php', array('cancel' => $strcancel));
    $btncancel = new single_button($urlcancel, $strcancel, 'post');
    $btncancel->add_action(new confirm_action($strcofirmation, 
                                              null,
                                              get_string('yes', 'local_fxlmslink'),
                                              get_string('no', 'local_fxlmslink')));
    echo $OUTPUT->render($btncancel);
    
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');
    
    echo html_writer::end_tag('form');
    echo $OUTPUT->box_end();
} else {
    echo $OUTPUT->box(get_string('nodeferredsubmissions', 'local_fxlmslink'), 'generalbox', 'notice');
}

echo $OUTPUT->footer();
