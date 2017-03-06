<?php

$string['mediasite'] = 'Mediasite';

$string['modulename'] = 'Mediasite Content';
$string['modulenameplural'] = 'Mediasite Content';
$string['pluginname'] = 'Mediasite Content';

$string['presentation'] = 'Presentation';
$string['catalog'] = 'Catalog';
$string['plural'] = 's';
$string['notauthorized'] = 'You are not authorized for this resource.';
$string['notfound'] = 'The selected Mediasite content was not found.';
$string['searchnoresult'] = 'No results were found matching your search.';
$string['nosites'] = 'There are no configured sites.';

//mod_form.php
$string['sitename'] = 'Title';
$string['resourcetype'] = 'Content Type';
$string['searchheader'] = 'Search for Mediasite content';
$string['searchbutton'] = 'Search for Mediasite content';
$string['duration'] = 'Ticket duration (in minutes)';
$string['duration_help'] = 'Length in minutes that generated authorization tickets will be valid.';
$string['restrictip'] = 'Restrict playback to client IP';
$string['restrictip_help'] = 'Bind authorization tickets to the client IP address to prevent link sharing.  This may need to be disabled when using a CDN or if the Moodle and Mediasite servers are on different networks.';
$string['openaspopup'] = 'Open Mediasite content in new window';
$string['openaspopup_help'] = 'When viewing the resource should it be displayed as a pop-up or inline.';

//settings.php add.php edit.php
$string['resourcetitle'] = 'Title';
$string['serverurl'] = 'Mediasite Root URL';
$string['passthru'] = 'Enable pass through authentication';
$string['passthru_help'] = 'Enable pass through authentication. This means that there is the same user name that is known to Moodle and a local authentication server (eg. LDAP)';
$string['certformat'] = 'Certificate file in .crt format';
$string['username'] = 'Username';
$string['username_help'] = 'Admin or system user on the Mediasite server.';
$string['password'] = 'Password';
$string['password_help'] = 'Password of the admin or system user.';

//site administration
$string['siteheader'] = 'Mediasite Server';
$string['siteaddbuttonlabel'] = 'Add site';
$string['sitenames'] = 'Select a default server';
$string['certpath'] = 'Cert Path';
$string['certpath_help'] = 'Path to the CA certificate.';
$string['nocert'] = 'No certificate for an HTTPS site';
$string['no70'] = 'This URL does not appear to be a Mediasite 7.0.4+ site';
$string['invalidserviceroot'] = 'Not a valid service root URL';
$string['invalidformat'] = 'Site responded with data that does not appear to be the correct format';
$string['wrongversion'] = 'This url seems to point to a Mediasite site, but with the wrong version - {$a}';
$string['noversion'] = 'Site did not respond with version information';
$string['invalidversion'] = 'Site did not respond with adequate version information - {$a}';
$string['invalidcred'] = 'Invalid username and/or password';
$string['invalidapikey'] = 'Site does not have an API key setup for Moodle';
$string['invalidcert'] = 'Invalid certificate';
$string['nowritepermissions'] = 'No write permissions to {$a}';
$string['unknownexception'] = 'Unknown exception {$a}';
$string['unsupportedversion'] = 'Unsupported version - {$a}';

$string['savechangebutton'] = 'Save changes';
//site configuration table headers
$string['sitenametblhder'] = 'Site Name';
$string['siteroottblhder'] = 'Site Root';
$string['usernametblhder'] = 'User Name';
$string['passthrutblhder'] = 'Pass through';
$string['actiontblhder'] = 'Action';

$string['actionedit'] = 'Edit existing site';
$string['actiondelete'] = 'Delete existing site';

//search, search_form
$string['searchtext'] = 'Search For:';
$string['opensearchwindow'] = 'Open Search Window';
$string['searchsubmit'] = 'Search';
$string['descriptionlabel'] = 'Description: ';
$string['searchtruncated'] = 'Search results are truncated';
$string['expandresource'] = 'Show details for this resource';
$string['selectresource'] = 'Select this resource';
$string['titleresource'] = 'Title of this resource';
$string['searchresultheader'] = 'Search returned {$a->count} {$a->type}';

$string['advancedsearchnotice'] = 'Search the fields you would like to search in Mediasite';
$string['advancedheader'] = 'Advanced';
$string['advancedfieldname'] = 'Name';
$string['advancedfielddescription'] = 'Description';
$string['advancedfieldtag'] = 'Tag';
$string['advancedfieldpresenter'] = 'Presenter';
$string['advancedsearchafter'] = 'After';
$string['advancedsearchuntil'] = 'Until';

$string['futuredate'] = '{$a} is in the future';
$string['notadate'] = '{$a} is not a date';
$string['impossibledatecombination'] = 'No presentation will match given date combinations';
$string['onefieldselect'] = 'There must be at least one field selected with a non-empty search string';
$string['advancedskipped'] = 'Warning: Advanced field selection is ignored for wild-card searches';
$string['resource'] = 'Type of resource';
$string['resource_help'] = 'The type of resource. Currently only \'presentations\' and \'catalogs\' are supported';
$string['searchtext'] = 'Text to search';
$string['searchtext_help'] = 'In the absence of any advanced options this text defaults to search in the tags and presentation titles. Leaving this blank causes all resources to be returned.';
$string['afterdate'] = 'Filter presentations in search by record date';
$string['afterdate_help'] = 'Limit the presentations returned to those that have a record date after than this date. The format is yyyy-mm-dd';
$string['untildate'] = 'Filter presentations in search by record date';
$string['untildate_help'] = 'Limit the presentations returned to those that have a record date earlier than this date. The format is yyyy-mm-dd';
$string['invaliddate'] = '{$a} - is not a valid date.';
$string['futuredate'] = '{$a} - specified date is in the future.';
$string['invaliddateformat'] = '{$a} is not of the format YYYY-MM-DD';
$string['datecombination'] = 'After {$a->after} and before {$a->before} will never be satisfied';
$string['description'] = 'Description';
$string['longsitename'] = 'Site Name is too long';
$string['requiredsitename'] = 'Site Name is required';
$string['duplicatesitename'] = '{$a} is already in use. Please use a different site name.';
$string['requiredsiteusername'] = 'User Name longer than 3 characters is required';
$string['longsiteusername'] = 'User Name is too long';
$string['requiredsitepassword'] = 'Password longer than 3 characters is required';
$string['longsitepassword'] = 'Password is too long';
$string['blankduration'] = 'Please enter a non-blank duration';
$string['nonnumericduration'] = 'You have entered a non-numeric value for duration ({$a})';
$string['smallduration'] = 'You have entered a value for duration that is considered too small ({$a})';
$string['longduration'] = 'Long ticket durations are not recommended ({$a})';
$string['invalidURL'] = 'Invalid URL format';
$string['unauthorized'] = 'Unauthorized';
$string['incompleteconfiguration'] = 'Incomplete configuration. Did the site administrator save configuration changes?';

// capabilities
$string['mediasite:view'] = "View Mediasite content on course";
$string['mediasite:addinstance'] = "Add Mediasite content to a course";
$string['mediasite:managesite'] = "Manage Mediasite settings";
$string['mediasite:overridedefaults'] = "Override default Mediasite settings";

// plugin administration
$string['pluginadministration'] = "Mediasite Content administration";
?>
