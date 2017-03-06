<?php
$capabilities = array(
    'mod/mediasite:addinstance' => array (
        'riskbitmask' => RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array (
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    ),
    'mod/mediasite:view' => array (
        'riskbitmask' => RISK_PERSONAL | RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array (
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
            'coursecreator' => CAP_ALLOW
        ),
    ),
  'mod/mediasite:overridedefaults' => array (
      'riskbitmask' => RISK_SPAM | RISK_PERSONAL | RISK_CONFIG,
      'captype' => 'write',
      'contextlevel' => CONTEXT_COURSE,
      'archetypes' => array (
          'teacher' => CAP_ALLOW,
          'editingteacher' => CAP_ALLOW,
          'manager' => CAP_ALLOW,
          'coursecreator' => CAP_ALLOW
      )
  )
)
?>