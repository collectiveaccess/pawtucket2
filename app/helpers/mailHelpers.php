<?php
/** ---------------------------------------------------------------------
 * app/helpers/mailHelpers.php : e-mail utility functions
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2022  Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 * 
 * @package CollectiveAccess
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */
 	
  /**
   *
   */ 

require_once(__CA_LIB_DIR__.'/Configuration.php');
require_once(__CA_LIB_DIR__.'/View.php');
require_once(__CA_LIB_DIR__.'/Logging/Eventlog.php');

# ------------------------------------------------------------------------------------------------
/**
 * Sends mail using server settings specified in app.conf/global.conf
 *
 * Parameters are:
 *
 * 	$pa_to: 	Email address(es) of message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name.
 *	$pa_from:	The email address of the message sender. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable sender name.
 *	$ps_subject:	The subject line of the message
 *	$ps_body_text:	The text of the message				(optional)
 *	$ps_html_text:	The HTML-format text of the message (optional)
 * 	$pa_cc: 	Email address(es) of cc'ed message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name. (optional)
 * 	$pa_bcc: 	Email address(es) of bcc'ed message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name. (optional)
 * 	$pa_attachments: 	array of arrays, each containing file path, name and mimetype of file to attach.
 *				keys are "path", "name", "mimetype"
 *
 *  $pa_options:	Array of options. Options include:
 *					log = Log activity? [Default is true]
 *					logSuccess = Log successful sends? [Default is true]
 *					logFailure = Log failed sends? [Default is true]
 *					source = source of email, used for logging. [Default is "Registration"]
 *					successMessage = Message to use for logging on successful send of email. Use %1 as a placeholder for a list of recipient email addresses. [Default is 'Email was sent to %1']
 *					failureMessage = Message to use for logging on failure of send. Use %1 as a placeholder for a list of recipient email addresses; %2 for the error message. [Default is 'Could not send email to %1: %2']
 *
 * While both $ps_body_text and $ps_html_text are optional, at least one should be set and both can be set for a 
 * combination text and HTML email
 */
function caSendmail($pa_to, $pa_from, $ps_subject, $ps_body_text, $ps_body_html='', $pa_cc=null, $pa_bcc=null, $pa_attachments=null, $pa_options=null) {
	global $g_last_email_error;
	$o_config = Configuration::load();
	$o_log = new Eventlog();
	if($o_config->get('smtp_auth')){
		$vs_smtp_auth = $o_config->get('smtp_auth');
	} else {
		$vs_smtp_auth = '';
	}
	if($o_config->get('smtp_username')){
		$vs_smtp_uname = $o_config->get('smtp_username');
		$vs_smtp_auth = 'login';
	} else {
		$vs_smtp_uname = '';
	}
	if($o_config->get('smtp_password')){
		$vs_smtp_pw = $o_config->get('smtp_password');
		$vs_smtp_auth = 'login';
	} else {
		$vs_smtp_pw = '';
	}
	$va_smtp_config = array(
		'username' => $vs_smtp_uname,
		'password' => $vs_smtp_pw
	);
	
	if($vs_smtp_auth){
		$va_smtp_config['auth'] = $vs_smtp_auth;
	}
	if($vs_ssl = $o_config->get('smtp_ssl')){
		$va_smtp_config['ssl'] = $vs_ssl;
	}
	if($vs_port = $o_config->get('smtp_port')){
		$va_smtp_config['port'] = $vs_port;
	}
	
	try {
		if($o_config->get('smtp_use_sendmail_transport')){
			$vo_tr = new Zend_Mail_Transport_Sendmail($va_smtp_config);
		} else {
			$vo_tr = new Zend_Mail_Transport_Smtp($o_config->get('smtp_server'), $va_smtp_config);
		}
		
		$o_mail = new Zend_Mail('UTF-8');
		
		if (!is_array($pa_from) && $pa_from) {
			$pa_from = preg_split('![,;\|]!', $pa_from);
		}
		if (is_array($pa_from)) {
			foreach($pa_from as $vs_from_email => $vs_from_name) {
				if (is_numeric($vs_from_email)) {
					$o_mail->setFrom($vs_from_name, $vs_from_name);
				} else {
					$o_mail->setFrom($vs_from_email, $vs_from_name);
				}
				break;
			}
		}
		
		if (!is_array($pa_to) && $pa_to) {
			$pa_to = preg_split('![,;\|]!', $pa_to);
		}
		
		foreach($pa_to as $vs_to_email => $vs_to_name) {
			if (is_numeric($vs_to_email)) {
				$o_mail->addTo($vs_to_name, $vs_to_name);
			} else {
				$o_mail->addTo($vs_to_email, $vs_to_name);
			}
		}
		
		if (!is_array($pa_cc) && $pa_cc) {
			$pa_cc = preg_split('![,;\|]!', $pa_cc);
		}
		if (is_array($pa_cc) && sizeof($pa_cc)) {
			foreach($pa_cc as $vs_to_email => $vs_to_name) {
				if (is_numeric($vs_to_email)) {
					$o_mail->addCc($vs_to_name, $vs_to_name);
				} else {
					$o_mail->addCc($vs_to_email, $vs_to_name);
				}
			}
		}
		
		if (is_array($pa_bcc) && sizeof($pa_bcc)) {
			foreach($pa_bcc as $vs_to_email => $vs_to_name) {
				$o_mail->addBcc(is_numeric($vs_to_email) ? $vs_to_name : $vs_to_email);
			}
		}
		
		if(is_array($pa_attachments)) {
			if (isset($pa_attachments["path"])) { $pa_attachments = [$pa_attachments]; }
			foreach($pa_attachments as $a) {
				if(!isset($a['path'])) { continue; }
				$attachment_url = $a["path"];
				# --- only attach media if it is less than 50MB
				if(filesize($attachment_url) < 419430400){
					$file_contents = file_get_contents($attachment_url);
					$o_attachment = $o_mail->createAttachment($file_contents);
					if($a["name"]){
						$o_attachment->filename = $a["name"];
					}
					if($a["mimetype"]){
						$o_attachment->type = $a["mimetype"];
					}
				}
			}
		}

		$o_mail->setSubject($ps_subject);
		if ($ps_body_text) {
			$o_mail->setBodyText($ps_body_text);
		}
		if ($ps_body_html) {
			$o_mail->setBodyHtml($ps_body_html);
		}
		$o_mail->send($vo_tr);
		
		if (caGetOption('log', $pa_options, true) && caGetOption('logSuccess', $pa_options, true)) {
			$o_log->log(array('CODE' => 'SYS', 'SOURCE' => caGetOption('source', $pa_options, 'Registration'), 'MESSAGE' => _t(caGetOption('successMessage', $pa_options, 'Email was sent to %1'), join(';', array_keys($pa_to)))));
		}
		return true;
	} catch (Exception $e) {
		$g_last_email_error = $e->getMessage();
		if (caGetOption('log', $pa_options, true) && caGetOption('logDFailure', $pa_options, true)) {
			$o_log->log(array('CODE' => 'ERR', 'SOURCE' => caGetOption('source', $pa_options, 'Registration'),  'MESSAGE' => _t(caGetOption('failureMessage', $pa_options, 'Could not send email to %1: %2'), join(';', array_keys($pa_to)), $e->getMessage())));
		}
		return false;
	}
}
# ------------------------------------------------------------------------------------------------
/**
 * Verifies the $ps_address is a properly formatted email address
 * by passing it through a regular expression pattern check and then
 * verifying that the domain exists. This is not a foolproof check but
 * will catch most data entry errors
 */ 
function caCheckEmailAddress($ps_address) {
	if (!caCheckEmailAddressRegex($ps_address)) { return false; }
	
	if (!function_exists('checkdnsrr')) { return true; }
	
	//list($vs_username, $vs_domain) = split('@', $ps_address);
	//if(!checkdnsrr($vs_domain,'MX')) {
		///return false;
	//}
	
	return true;
}
# ------------------------------------------------------------------------------------------------
/**
 * Verifies using a regular expression the $ps_address looks like a valid email address
 * Returns true if $ps_address looks like an email address, false if it doesn't
 */
function caCheckEmailAddressRegex($ps_address) {
	if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._\-\+\'])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $ps_address)) {
		return false;
	}
	return true;
}
# ------------------------------------------------------------------------------------------------
/**
* Sends mail message using specified view and variable to merge
 *
 * Parameters are:
 *
 * 	$pa_to: 	Email address(es) of message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name.
 *	$pa_from:	The email address of the message sender. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable sender name.
 *	$ps_subject:	The subject line of the message
 *	$ps_view:	The name of a view in the 'mailTemplates' view directory
 * 	$pa_values:	An array of values
 * 	$pa_cc: 	Email address(es) of cc'ed message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name. (optional)
 * 	$pa_bcc: 	Email address(es) of bcc'ed message recipients. Can be a string containing a single email address or
 *				an associative array with keys set to multiple addresses and corresponding values optionally set to
 *				a human-readable recipient name. (optional)
 *
 * @return string True if send, false if error
 */
function caSendMessageUsingView($po_request, $pa_to, $pa_from, $ps_subject, $ps_view, $pa_values, $pa_cc=null, $pa_bcc=null, $pa_options=null) {
	$view_paths = (is_object($po_request)) ? [$po_request->getViewsDirectoryPath().'/mailTemplates'] : array_unique([__CA_BASE_DIR__.'/themes/'.__CA_THEME__.'/views/mailTemplates', __CA_BASE_DIR__.'/themes/default/views/mailTemplates']);
	if(!is_object($po_request)) { $po_request = null; }
	
	$o_view = new View($po_request, $view_paths, 'UTF8', array('includeDefaultThemePath' => false));
	
	$tag_list = $o_view->getTagList($ps_view);		// get list of tags in view

	foreach($tag_list as $tag) {
		if ((strpos($tag, "^") !== false) || (strpos($tag, "<") !== false)) {
			$o_view->setVar($tag, caProcessTemplate($tag, $pa_values, []) );
		} elseif (array_key_exists($tag, $pa_values)) {
			$o_view->setVar($tag, $pa_values[$tag]);
		} else {
			$o_view->setVar($tag, "?{$tag}");
		}
		unset($pa_values[$tag]);
	}
	
	foreach($pa_values as $k => $v) {
		$o_view->setVar($k, $v);
	}
	return caSendmail($pa_to, $pa_from, $ps_subject, null, $o_view->render($ps_view), $pa_cc, $pa_bcc, caGetOption(['attachment', 'attachments'], $pa_options, null), $pa_options);
}
# ------------------------------------------------------------------------------------------------
