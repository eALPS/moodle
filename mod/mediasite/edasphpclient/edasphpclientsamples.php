<?php
    namespace Sonicfoundry\EDAS;
    /**
     * Mediasite External Data Access (Edas) webservice client wrapper
     * These proxy classes were generated based on the Mediasite 6.0 EDAS WSDL definition.
     * PHP Version 5.3
     *
     * @copyright  Copyright (c) 2013, Sonic Foundry
     * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
     * @version    6.1.7
     * @package    SonicFoundry.Mediasite.Edas.PHPClient
     * @subpackage Samples
     * @author     Cori Schlegel <coris@sonicfoundry.com>
     *             This software is provided "AS IS" without a warranty of any kind.

     */

    /**
     * We require the client - it will require everything else we need
     */
    require_once 'edasproxy_client.php';

    ini_set('display_errors', 'on');
    ini_set('html_errors', 1);
    ini_set('ignore_repeated_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    session_start();

    $render_params = array(
        "error_message"          => "",
        "application_name"       => isset( $_SESSION['application_name'] ) ? $_SESSION['application_name'] : "",
        "impersonation_username" => isset( $_SESSION['impersonation_username'] ) ? $_SESSION['impersonation_username'] : "",
        "svc_url"                => isset( $_SESSION['svc_url'] ) ? $_SESSION['svc_url'] : "http://Your_Mediasite_Root/Services60/EdasSixOneThree.svc",
        "preso_title"            => isset( $_SESSION['preso_title'] ) ? $_SESSION['preso_title'] : "mediasite",
        "preso_start"            => isset( $_SESSION['preso_start'] ) ? $_SESSION['preso_start'] : "2011-06-27",
        "preso_end"              => isset( $_SESSION['preso_end'] ) ? $_SESSION['preso_end'] : date('Y-m-d'),
        "test_results"           => "",
        "presentations"          => "",
        "search_results"         => "",
        "create_results"         => "",
        "auth_ticket_results"    => "",
        "auth_ticket_properties" => "",
        "ipaddress"              => "192.168.1.1",
        "minutes_to_live"        => "60",
        "resource_id"            => "",
        "user_name"              => ""
    );

    $error_message = "";

    try {

        //Cache a few useful values in the SESSION
        if ( isset( $_POST['application_name'] ) && $_POST['application_name'] != '' ) {
            $render_params['application_name'] = $_POST['application_name'];
            $_SESSION['application_name']      = $_POST['application_name'];
        } else {
            $_SESSION['application_name'] = isset( $_SESSION['application_name'] ) ? $_SESSION['application_name'] : null;
        }

        $impersonationUsernameForLogin = null;
        if ( isset( $_POST['impersonation_username'] ) && $_POST['impersonation_username'] != '' ) {
            $impersonationUsernameForLogin           = $_POST['impersonation_username'];
            $render_params['impersonation_username'] = $_POST['impersonation_username'];
            $_SESSION['impersonation_username']      = $_POST['impersonation_username'];
        } else {
            $_SESSION['impersonation_username'] = isset( $_SESSION['impersonation_username'] ) ? $_SESSION['impersonation_username'] : null;
        }

        if ( $_POST && ( !isset( $_POST['svc_url'] ) || $_POST['svc_url'] == '' ) ) {

            //if no service url we cannot proceed
            $render_params['error_message'] = SetError("Service URL Must be provided");
            Render($render_params);

        } else if ( $_POST && isset( $_POST['login'] ) ) {
            // log in to Mediasite Edas

            if ( get_headers($_POST['svc_url']) ) {
                $_SESSION['svc_url'] = $_POST['svc_url'];
                try {

                    //  instantiate a new client and calls login. Login will cache the ticket in the client
                    //  but we'll cache it in the SESSION for use in other new clients in the sample
                    $client                 = new ExternalAccessClient( $_SESSION['svc_url'] );
                    $login_resp             = $client->Login($_POST['username'], $_POST['pass'], $_SESSION['application_name'],
                        $impersonationUsernameForLogin);
                    $_SESSION['userticket'] = $login_resp->UserTicket;

                    //  use the client which has kept a reference to the user ticket
                    TestConnection($client, $render_params);

                } catch ( Exception $ex ) {
                    $render_params['error_message'] = SetException($ex);
                }

            } else {

                $render_params['error_message'] = SetError("Cannot retrieve service url");

            }

            Render($render_params);

        } else if ( $_POST && isset( $_POST['query'] ) ) {
            //Query Presentations
            //  we no longer have the previously-instantiated client that we used to log in so we need to
            //  create a new one. Then we call QueryPresentationsByCriteria() passing in the cached user ticket.
            //  that ticket will be useful for that method call only;
            //  if we call another method we'll need to supply it with the ticket as well,
            //  because this instance of the client doesn't have a ticket cached

            $_SESSION['preso_title'] = $_POST['preso_title'];
            $_SESSION['preso_start'] = $_POST['preso_start'];
            $_SESSION['preso_end']   = $_POST['preso_end'];
            try {
                QueryPresentations($render_params);
            } catch ( Exception $ex ) {
                $render_params['error_message'] = SetError($ex->getMessage());
            }

            Render($render_params);

        } else if ( $_POST && isset( $_POST['search'] ) ) {
            //Search Presentations
            //  we no longer have the previously-instantiated client that we used to log in so we need to
            //  create a new one, but this time we supply the ticket in the client constructor.
            //  Now this instance of the client has a reference to the supplied user ticket.
            //  Then we call Search() without supplying the cached user ticket, and can make further calls using this
            //  client instance without resupplying the user ticket.

            SearchPresentations($_POST['search_text'], $render_params);
            Render($render_params);

        } else if ( $_POST && isset( $_POST['create_presentation'] ) ) {

            $creation_details = new CreatePresentationFromTemplateDetails( $_POST['template_id'], $_POST['presentation_title'] );
            CreatePresentation($creation_details, $render_params);

            Render($render_params);

        } else if ( $_POST && isset( $_POST['create_auth_ticket'] ) ) {

            CreateAuthTicket($_POST['ipaddress'], $_POST['minutes_to_live'], $_POST['resource_id'], $_POST['user_name'], $render_params);

            Render($render_params);

        } else {

            Render($render_params);

        }

    } catch ( Exception $ex ) {

        $render_params['error_message'] = SetError($ex->getMessage());
        Render($render_params);

    }

    /**
     * Test the Edas connection
     * This call illustrates using a previously-instantiated {@link ExternalAccessClient} which has cached
     * its own ticket. Once Login() is called on a given client, that client instance will maintain its own user ticket
     * and will use that if one is not supplied in the method call.
     * Once a given request has ended, that client is no longer available
     *
     * @param ExternalAccessClient $client
     * @param array                $render_params values to pass to the Render() method
     */
    function TestConnection( ExternalAccessClient $client, &$render_params ) {

        $render_params['test_results'] = PrePrint($client->QueryIdentityTicketProperties($_SESSION['userticket'], 120, false));

    }

    /**
     * Query for Presentations
     * We query Edas for Presentations that match a certain set of criteria
     * Start and End dates must be set, and you must specify aa array of {@link ResourcePermissionMask} values
     * see {@link PresentationQueryCriteria} for the values that can be used as criteria
     * This method illustrates instantiating a new {@link ExternalAccessClient} without a user ticket and
     * passing in a previously obtained Ticket in the specific method call,
     * assuming you've previously logged in and have a user ticket cached in the $_SESSION
     *
     * @param ExternalAccessClient $client
     * @param array                &$render_params parameters passed to the Render() method
     *
     * @return void
     * @throws Exception
     */
    function QueryPresentations( &$render_params ) {

        $impersonation_username = null;
        if ( $_SESSION['userticket'] == '' ) {
            $render_params['error_message'] = "Must be logged in to a valid EDAS service to query";

            return;
        }

        if ( isset( $_POST['query_impersonation_username'] ) && $_POST['query_impersonation_username'] != '' ) {
            $impersonation_username = $_POST['query_impersonation_username'];
        }

        $perms    = array( ResourcePermissionMask::Read );
        $criteria = new PresentationQueryCriteria( $_SESSION['preso_start'], $_SESSION['preso_end'], $perms, $_SESSION['preso_title'] );

        //  here we pass in a previously-obtained user ticket that we've cached in the session
        try {
            $client = new ExternalAccessClient( $_SESSION['svc_url'] );
            $result = $client->QueryPresentationsByCriteria($criteria, null, $_SESSION['userticket'], $impersonation_username);
        } catch ( Exception $ex ) {
            throw $ex;
        }
        $render_params['presentations'] = PrePrint($result);
        $render_params['test_results']  = PrePrint($_SESSION['impersonation_username']);

        return;

    }

    /**
     * Search this Mediasite instance for Presentations
     * Search allows user to search presentation names and descriptions, as well as Presenter and Owner
     * It does not allow more finely-grained criteria
     * For searches, {@link QueryOptions} is required
     * This method outlines creating a new client with url and a previously-obtained ticket.
     * Once instantiated, multiple calls can be made using this client without having to regenerate a ticket,
     * but once this request is over future calls will need to supply a ticket
     *
     * @param string $search_string  string to search for
     * @param array  &$render_params array of values to pass to the render method
     *
     * @throws Exception
     * @return void results returned in $render_params
     */
    function SearchPresentations( $search_string, &$render_params ) {

        if ( !IsLoggedIn($render_params) ) {
            return;
        }

        try {
            //  create a client for a specific ticket
            $client = new ExternalAccessClient( $_SESSION['svc_url'], $_SESSION['userticket'] );

            $searchFields = array( SupportedSearchField::Description, SupportedSearchField::Name );
            $options      = new QueryOptions( 10, "edas sample search", 0 );
            $searchTypes  = array( SupportedSearchType::Presentation );

            $render_params['search_results'] = PrePrint($client->Search($searchFields, $search_string, $searchTypes, $options));

        } catch ( Exception $ex ) {
            throw $ex;
        }

        return;

    }

    /**
     * Creates a Presentation based on the provided details
     *
     * @param CreatePresentationFromTemplateDetails $creation_details presentation details for the preso to create
     * @param array                                 $render_params    value to use for rendering html
     *
     * @throws Exception
     */
    function CreatePresentation( CreatePresentationFromTemplateDetails $creation_details, &$render_params ) {

        if ( !IsLoggedIn($render_params) ) {
            $render_params['error_message'] = SetError("Must be logged in to a valid EDAS service to search");

            return;
        }

        try {

            $client = new ExternalAccessClient( $_SESSION['svc_url'], $_SESSION['userticket'], $_SESSION['impersonation_username'] );

            //ensure we have a valid, unexpired ticket before calling Create
            $identTicket = $client->QueryIdentityTicketProperties($_SESSION['userticket'], 120, false);

            if ( !isset( $creation_details ) || $creation_details->PresentationTemplateId == '' ) {
                $crit                                     = new PresentationTemplateQueryCriteria( false, 0 );
                $templates                                = $client->QueryPresentationTemplatesByCriteria($crit)->PresentationTemplates->PresentationTemplateDetails;
                $template                                 = $templates[0];
                $creation_details->PresentationTemplateId = $template->Id;
            }
            if ( $identTicket->Properties->ExpirationTime >= date('c') ) {
                $render_params['create_results'] = PrePrint($client->CreatePresentationFromTemplate($creation_details));
            } else {
                $render_params['error_message'] = SetError('User ticket expired');

                return;
            }

        } catch ( Exception $ex ) {
            throw $ex;
        }

        return;

    }

    /**
     * Creates an Auth Ticket for a given IP Address, Time To Live, Resource Id, and Username
     *
     * @param string $ipaddress        ip address for the ticket
     * @param string $minutes_to_live  lifespan of the ticket
     * @param string $resource_id      id of the resource to authorize
     * @param string $user_name        username to create the ticket for
     * @param array  $render_params    value to use for rendering html
     *
     * @throws Exception
     * @internal param string $ipaddress ip address for the ticket
     * @internal param string $reource_id id of the resource to authorize
     * @internal param string $user_name username to create the ticket for
     */
    function CreateAuthTicket( $ip_address, $minutes_to_live, $resource_id, $username, &$render_params ) {

        if ( !IsLoggedIn($render_params) ) {
            $render_params['error_message'] = SetError("Must be logged in to a valid EDAS service to create an authorization ticket");

            return;
        }

        try {

            $client = new ExternalAccessClient( $_SESSION['svc_url'], $_SESSION['userticket'] );

            //ensure we have a valid, unexpired ticket before calling Create
            $identTicket = $client->QueryIdentityTicketProperties($_SESSION['userticket'], 120, false);

            if ( $identTicket->Properties->ExpirationTime >= date('c') ) {
                $ticket                                  = $client->CreateAuthTicket($ip_address, $minutes_to_live, $resource_id, $username, $_SESSION['userticket']);
                $render_params['auth_ticket_results']    = PrePrint($ticket);
                $render_params['auth_ticket_properties'] = PrePrint($client->QueryAuthTicketProperties($ticket->AuthTicketId, $minutes_to_live, false, $_SESSION['userticket']));
                $render_params["ipaddress"]              = $ip_address;
                $render_params["minutes_to_live"]        = $minutes_to_live;
                $render_params["resource_id"]            = $resource_id;
                $render_params["user_name"]              = $username;
            } else {
                $render_params['error_message'] = SetError('User ticket expired');

                return;
            }

        } catch ( Exception $ex ) {
            throw $ex;
        }

        return;

    }

    /**
     * Poor man's controller. Render the html for the page.
     *
     * @param array $params parameters to set dynamic values in the html
     */
    function Render( $params ) {
        $html = <<<HTML
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Mediasite EDAS (External Data Access) PHP Client and Proxy Library Samples</title>
			<style>
				p { margin: 0; }
				label { display: block; float: left; width: 215px; text-align: right; margin-right: 5px; padding-top: 2px; }
				fieldset { margin-top: 10px; display: block; clear: both; }
				#documentation, #req { float: right; display: block; }
				#headerimg { float: left; margin-bottom: 15px }
				#errorZone { clear: both; }
				.impersonation-warning { color: #C43C35; }
				.sample-for{color: #666666; font-size: small; margin-bottom: 5px;}
			</style>
		</head>
		<body>
			<form id="edasSamples" method="POST" >
			<div id="header">
				<a href="http://www.sonicfoundry.com"><img id="headerimg" src="sonic_theme_logo.png" /></a>
				<a id="documentation" href="../EdasPHPDocumentation/index.html">Documentation</a><br>
				<p id="req">* denotes a required field</p>
			</div>
			<div id="errorZone">{$params['error_message']}</div>
			<fieldset id="configZone">
				<legend>Configuration</legend>
				<p title="Provide a valid EDAS Service url"><label for="svc_url">* Service URL: </label><input type="text" id="svc_url" name="svc_url" value="{$params['svc_url']}" size="100"></p><br>
				<p title="Optional Application name to send along with Edas operations"><label for="application_name">Application Name: </label><input type="text" id="application_name" name="application_name" value="{$params['application_name']}" size="100"></p><br>
			</fieldset>
			<fieldset id="loginZone">
				<legend>Login Information</legend>
				<p class="sample-for">Edas Operation: Login</p>
				<p title="Provide a valid username and password for the Mediasite Installation referenced above"><label for="username">* Username:</label><input type="text" id="username" name="username" size="100" /><br>
				<label for="pass">* Password:</label><input type="password" id="pass" name="pass" size="100"/></p><br>
				<p title="Optional username to impersonate"><label for="impersonation_username">User to Impersonate: </label><input type="text" id="impersonation_username" name="impersonation_username" size="100"></p><br>
				<div class="impersonation-warning">
				    <p>Important note: logging in with an ImpersonationUsername will generate a ticket for the impersonated user, <b>not</b> the user whose credentials you've entered above.</p>
				    <p>The user whose credentials you provided must be granted the Impersonation Operation in the Management Portal, or login will fail.</b></p><br>
				</div>
				<button type="submit" id="login" name="login">Login</button><br>
				<div title="Response from an in-line call to the Test() method of the Edas service on successful login">{$params['test_results']}</div>
			</fieldset>
			<fieldset id="presentationZone">
				<legend>Presentation Query</legend>
				<p class="sample-for">Edas Operation: QueryPresentationsByCriteria</p>
				<p title="Provide minimal criteria for a query of presentations on your Mediasite Installation: start and end dates of the range of dates to query and text to compare against Presentation titles">
				<label for="preso_title">* Presentation Title Criteria: </label><input type="text" id="preso_title" name="preso_title" value="{$params['preso_title']}" size="100"></input><br>
				<label for="preso_start">* Presentation Start Date Criteria: </label><input type="text" id="preso_start" name="preso_start" value="{$params['preso_start']}" size="100"></input><br>
				<label for="preso_end">* Presentation End Date Criteria: </label><input type="text" id="preso_end" name="preso_end" value="{$params['preso_end']}" size="100"></input></p><br>
				<p title="Optional username to impersonate"><label for="query_impersonation_username">User to Impersonate: </label><input type="text" id="query_impersonation_username" name="query_impersonation_username" size="100"></p><br>
				<div class="impersonation-warning">
				    <p>Setting an Impersonation Username here will cause the QueryPresentationByCriteria call to be executed in the context of the impersonated user, but the identity ticket will still be for the user you logged in as above.</p>
				    <p>If the user you logged in as above does not have the Impersonation Operation and you provide a user to impersonate, this request will fail..</p>
				</div>
				<button type="submit" id="query" name="query">Query Presentations</button>
				<div title="Resulting query results">{$params['presentations']}</div>
			</fieldset>
			<fieldset id="searchZone">
				<legend>Presentation Search</legend>
				<p class="sample-for">Edas Operation: Search</p>
				<p title="Text to search Presentation Name and Descriptions for"><label for="search_text">* Search Text: </label><input type="text" id="search_text" name="search_text" size="100"></input></p><br>
				<button type="submit" id="search" name="search">Search</button>
				<div id="search_results" title="Search results">{$params['search_results']}</div>
			</fieldset>
			<fieldset id="createPresentationZone">
				<legend>Presentation Creation</legend>
				<p class="sample-for">Edas Operation: CreatePresentationFromTemplate</p>
				<p title="Presentation Details">
					<label for="template_id">Template Id: </label><input type="text" id="template_id" name="template_id" size="100" placeholder="If not set will default to first template from QueryPresentationTemplatesByCriteria."></input><br>
					<label for="presentation_title">* Presentation Title: </label><input type="text" id="presentation_title" name="presentation_title" size="100"></input><br>
					<label for="record_datetime">Recorded Date/Time: </label><input type="text" id="record_datetime" name="record_datetime" size="100"></input><br>
					<label for="data_status">Data Status: </label><input type="text" id="data_status" name="data_status" size="100"></input><br>
					<label for="cdn_publishingpoint">Publishing Point: </label><input type="text" id="cdn_publishingpoint" name="cdn_publishingpoint" size="100"></input><br>
					<label for="description">Description: </label><textarea id="description" name="description" cols="77"></textarea><br>
					<label for="duration">Duration: </label><input type="text" id="duration" name="duration" size="100"></input><br>
					<label for="folder_id">Folder Id: </label><input type="text" id="folder_id" name="folder_id" size="100" placeholder="If not provided, Presentation will be created in the same folder as the template selected."></input><br>
					<label for="max_connections">Max Connections: </label><input type="text" id="max_connections" name="max_connections" size="100"></input><br>
					<label for="moderator_email">Moderator Email: </label><input type="text" id="moderator_email" name="moderator_email" size="100"></input><br>
					<label for="presentation_id">Presentation Id: </label><input type="text" id="presentation_id" name="presentation_id" size="100"></input><br>
				</p>
				<button type="submit" id="create_presentation" name="create_presentation">Create Presentation</button>
				<div id="create_results" title="Results">{$params['create_results']}</div>
			</fieldset>
			<fieldset id="creatAuthTicketZone">
				<legend>Create Authorization Ticket</legend>
				<p class="sample-for">Edas Operation: CreateAuthTicket</p>
				<p title="Authorization Ticket Details">
					<label for="ipaddress">Ip Address: </label><input type="text" id="ipaddress" name="ipaddress" size="100" value="{$params['ipaddress']}" /><br />
					<label for="minutes_to_live">Minutes To Live: </label><input type="text" id="minutes_to_live" name="minutes_to_live" size="100" value="{$params['minutes_to_live']}" /></input><br />
					<label for="resource_id">Resource Id: </label><input type="text" id="resource_id" name="resource_id" size="100" value="{$params['resource_id']}" /><br />
					<label for="user_name">User Name: </label><input type="text" id="user_name" name="user_name" size="100" value="{$params['user_name']}"/><br />
				</p>
				<button type="submit" id="create_auth_ticket" name="create_auth_ticket">Create Auth Ticket</button>
				<div id="create_results" title="Results">{$params['auth_ticket_results']}</div>
				<div id="ticket_results" title="Ticket Properties">{$params['auth_ticket_properties']}</div>
			</fieldset>
			</form>
		</body>
	</html>
HTML;
        echo( $html );
    }

    /**
     * Wrap the supplied string in &lt;p&gt; tags and make it red
     *
     * @param string $msg message to color red
     *
     * @return string colored string
     */
    function SetError( $msg ) {
        return "<p style='color: red'>{$msg}<br/></p>";
    }

    function SetException( Exception $ex ) {
        return "<p style='color: red'>{$ex->getMessage()}<br/>{$ex->getTrace()}</p>";
    }

    /**
     * Wrap a supplied string in pre tags
     *
     * @param string $string string to wrap in pre tags
     *
     * @return string wrapped string
     */
    function PrePrint( $string ) {
        $formatted_string = print_r($string, true);

        return "<pre>$formatted_string</pre>";
    }

    /**
     * Verify if user session is logged in
     *
     * @param $render_params
     *
     * @return bool
     */
    function IsLoggedIn( $render_params ) {

        if ( $_SESSION['svc_url'] == '' || $_SESSION['userticket'] == '' ) {
            $render_params['error_message'] = SetError("Must be logged in to a valid EDAS service to search");

            return false;
        } else {
            return true;
        }

    }
