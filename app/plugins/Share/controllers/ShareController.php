<?php
/* ----------------------------------------------------------------------
 * plugins/Share/controllers/ShareController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
	require_once(__CA_LIB_DIR__."/core/Parsers/htmlpurifier/HTMLPurifier.standalone.php");
 
 	class ShareController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		private $opo_datamodel;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			JavascriptLoadManager::register('tokeninput');
 			
 			$this->ops_theme = __CA_THEME__;																	// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/Share/themes/'.$this->ops_theme.'/views')) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			parent::__construct($po_request, $po_response, array(__CA_APP_DIR__.'/plugins/Share/themes/'.$this->ops_theme.'/views'));
 			
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/Share/conf/Share.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('Share plugin is not enabled')); }
 			
 			MetaTagManager::addLink('stylesheet', $po_request->getBaseUrlPath()."/app/plugins/Share/themes/".$this->ops_theme."/css/share.css",'text/css');
 		 	
 		 	$va_access_values = caGetUserAccessValues($this->request);
 		 	$this->opa_access_values = $va_access_values;
			$this->view->setVar('access_values', $va_access_values);
			
			if ($this->opo_plugin_config->get('require_login') && !$po_request->isLoggedIn()) {
 				$this->notification->addNotification(_t("You must be logged in to email content."), __NOTIFICATION_TYPE_ERROR__);	
 				$this->response->setRedirect(caNavUrl($this->request, '', 'LoginReg', 'form', array('site_last_page' => 'ObjectDetail', 'object_id' => $this->request->getParameter('object_id', pInteger))));
 				return;
 			}
 			
 			$this->opo_datamodel = Datamodel::load();
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function objectForm() {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			$t_object = new ca_objects();
			
			if(!$t_object->load($pn_object_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			$this->view->setVar('t_object', $t_object);
 			$this->view->setVar('object_id', $pn_object_id);
 			
 			$this->render('form_object_html.php');
 		} 		
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function sendEmailObject() {
 			$va_errors = array();
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			$t_object = new ca_objects();
			
			if(!$t_object->load($pn_object_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			$ps_to_email = $this->request->getParameter('to_email', pString);
 			$ps_from_email = $this->request->getParameter('from_email', pString);
 			$ps_from_name = $this->request->getParameter('from_name', pString);
 			$ps_subject = $this->request->getParameter('subject', pString);
 			$ps_message = $this->request->getParameter('message', pString);
 			$pn_security = $this->request->getParameter('security', pInteger);
 			$pn_sum = $this->request->getParameter('sum', pInteger);
			
			$o_purifier = new HTMLPurifier();
    		$ps_message = $o_purifier->purify($ps_message);
    		$ps_to_email = $o_purifier->purify($ps_to_email);
    		$ps_from_email = $o_purifier->purify($ps_from_email);
    		$ps_from_name = $o_purifier->purify($ps_from_name);
    		$ps_subject = $o_purifier->purify($ps_subject);
			
			# --- check vars are set and email addresses are valid
			$va_to_email = array();
			$va_to_email_process = array();
			if(!$ps_to_email){
				$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
			}else{
				# --- explode on commas to support multiple addresses - then check each one
				$va_to_email_process = explode(",", $ps_to_email);
				foreach($va_to_email_process as $vs_email_to_verify){
					$vs_email_to_verify = trim($vs_email_to_verify);
					if(caCheckEmailAddress($vs_email_to_verify)){
						$va_to_email[$vs_email_to_verify] = "";
					}else{
						$ps_to_email = "";
						$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
					}
				}
			}
			if(!$ps_from_email || !caCheckEmailAddress($ps_from_email)){
				$ps_from_email = "";
				$va_errors["from_email"] = _t("Please enter a valid email address");
			}
			if(!$ps_from_name){
				$va_errors["from_name"] = _t("Please enter your name");
			}
			if(!$ps_subject){
				$va_errors["subject"] = _t("Please enter a subject");
			}
			if(!$ps_message && ($this->opo_plugin_config->get('require_message_text'))){
				$va_errors["message"] = _t("Please enter a message");
			}
			if(!$this->request->isLoggedIn()){
				# --- check for security answer if not logged in
				if ((!$pn_security)) {
					$va_errors["security"] = _t("Please answer the security question.");
				}else{
					if($pn_security != $pn_sum){
						$va_errors["security"] = _t("Your answer was incorrect, please try again");
					}
				}
			}
 			
 			$this->view->setVar('t_object', $t_object);
 			$this->view->setVar('object_id', $pn_object_id);
 			$this->view->setVar('errors', $va_errors);

 			if(sizeof($va_errors) == 0){
				# -- generate mail text from template - get both html and text versions
				ob_start();
				require($this->request->getAppConfig()->get('application_plugins')."/Share/themes/".$this->ops_theme."/views/mailTemplates/share_object_email_text.tpl");
				$vs_mail_message_text = ob_get_contents();
				ob_end_clean();
				ob_start();
				require($this->request->getAppConfig()->get('application_plugins')."/Share/themes/".$this->ops_theme."/views/mailTemplates/share_object_email_html.tpl");
				$vs_mail_message_html = ob_get_contents();
				ob_end_clean();
				
				$va_media = null;
				if($this->opo_plugin_config->get('enable_media_attachment')){
					# --- get media for attachment
					$vs_media_version = "";
					# Media representation to email
					# --- version is set in media_display.conf.
					if (method_exists($t_object, 'getPrimaryRepresentationInstance')) {
						if ($t_primary_rep = $t_object->getPrimaryRepresentationInstance()) {
							if (!sizeof($this->opa_access_values) || in_array($t_primary_rep->get('access'), $this->opa_access_values)) { 		// check rep access
								$va_media = array();
								$va_rep_display_info = caGetMediaDisplayInfo('email', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
								
								$vs_media_version = $va_rep_display_info['display_version'];
								
								$va_media['path'] = $t_primary_rep->getMediaPath('media', $vs_media_version);
								$va_media_info = $t_primary_rep->getFileInfo('media', $vs_media_version);
								if(!$va_media['name'] = $va_media_info['ORIGINAL_FILENAME']){
									$va_media['name'] = $va_media_info[$vs_media_version]['FILENAME'];
								}
								# --- this is the mimetype of the version being downloaded
								$va_media["mimetype"] = $va_media_info[$vs_media_version]['MIMETYPE'];
							}
						}
					}
				}				
				if(caSendmail($va_to_email, array($ps_from_email => $ps_from_name), $ps_subject, $vs_mail_message_text, $vs_mail_message_html, null, null, $va_media)){
 					$this->notification->addNotification(_t("Your email was sent"), "message");
 					$this->response->setRedirect(caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id)));
 					return;
 				}else{
 					$this->notification->addNotification(_t("Your email could not be sent"), "message");
 					$va_errors["email"] = 1;
 				}
 			}
 			if(sizeof($va_errors)){
 				# --- there were errors in the form data, so reload form with errors displayed - pass params to preload form
 				$this->view->setVar('to_email', $ps_to_email);
 				$this->view->setVar('from_email', $ps_from_email);
 				$this->view->setVar('from_name', $ps_from_name);
 				$this->view->setVar('subject', $ps_subject);
 				$this->view->setVar('message', $ps_message);
 				
 				$this->notification->addNotification(_t("There were errors in your form"), "message");
 				$this->render('form_object_html.php'); 			
 			}
 		} 		
 		# -------------------------------------------------------
 		/**
 		 *	form for all tables other than ca_objects
 		 */
 		public function form() {
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			$vs_controller = "";
			switch($ps_tablename){
				case "ca_objects":
					$vs_controller = "Object";
				break;
				# -----------------------------
				case "ca_entities":
					$vs_controller = "Entity";
				break;
				# -----------------------------
				case "ca_places":
					$vs_controller = "Place";
				break;
				# -----------------------------
				case "ca_occurrences":
					$vs_controller = "Occurrence";
				break;
				# -----------------------------
				case "ca_collections":
					$vs_controller = "Collection";
				break;
				# -----------------------------
			}
			$this->view->setVar("controller", $vs_controller);
			$pn_item_id = $this->request->getParameter('item_id', pInteger);
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($ps_tablename, true)) {
 				die("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
 			}
			if(!$t_item->load($pn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			$this->view->setVar('t_item', $t_item);
 			$this->view->setVar('item_id', $pn_item_id);
 			$this->view->setVar('tablename', $ps_tablename);
 			
 			$this->render('form_html.php');
 		} 		
 		# -------------------------------------------------------
 		/**
 		 *	send email for all tables other than ca_objects
 		 */
 		public function sendEmail() {
 			$va_errors = array();
 			$ps_tablename = $this->request->getParameter('tablename', pString);
 			$vs_controller = "";
			switch($ps_tablename){
				case "ca_objects":
					$vs_controller = "Object";
				break;
				# -----------------------------
				case "ca_entities":
					$vs_controller = "Entity";
				break;
				# -----------------------------
				case "ca_places":
					$vs_controller = "Place";
				break;
				# -----------------------------
				case "ca_occurrences":
					$vs_controller = "Occurrence";
				break;
				# -----------------------------
				case "ca_collections":
					$vs_controller = "Collection";
				break;
				# -----------------------------
			}
			$this->view->setVar("controller", $vs_controller);
			$pn_item_id = $this->request->getParameter('item_id', pInteger);
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($ps_tablename, true)) {
 				die("Invalid table name ".$ps_tablename." for detail");		// shouldn't happen
 			}
			if(!$t_item->load($pn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			$ps_to_email = $this->request->getParameter('to_email', pString);
 			$ps_from_email = $this->request->getParameter('from_email', pString);
 			$ps_from_name = $this->request->getParameter('from_name', pString);
 			$ps_subject = $this->request->getParameter('subject', pString);
 			$ps_message = $this->request->getParameter('message', pString);
 			$pn_security = $this->request->getParameter('security', pInteger);
 			$pn_sum = $this->request->getParameter('sum', pInteger);
			
			$o_purifier = new HTMLPurifier();
    		$ps_message = $o_purifier->purify($ps_message);
    		$ps_to_email = $o_purifier->purify($ps_to_email);
    		$ps_from_email = $o_purifier->purify($ps_from_email);
    		$ps_from_name = $o_purifier->purify($ps_from_name);
    		$ps_subject = $o_purifier->purify($ps_subject);
			
			# --- check vars are set and email addresses are valid
			$va_to_email = array();
			$va_to_email_process = array();
			if(!$ps_to_email){
				$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
			}else{
				# --- explode on commas to support multiple addresses - then check each one
				$va_to_email_process = explode(",", $ps_to_email);
				foreach($va_to_email_process as $vs_email_to_verify){
					$vs_email_to_verify = trim($vs_email_to_verify);
					if(caCheckEmailAddress($vs_email_to_verify)){
						$va_to_email[$vs_email_to_verify] = "";
					}else{
						$ps_to_email = "";
						$va_errors["to_email"] = _t("Please enter a valid email address or multiple addresses separated by commas");
					}
				}
			}
			if(!$ps_from_email || !caCheckEmailAddress($ps_from_email)){
				$ps_from_email = "";
				$va_errors["from_email"] = _t("Please enter a valid email address");
			}
			if(!$ps_from_name){
				$va_errors["from_name"] = _t("Please enter your name");
			}
			if(!$ps_subject){
				$va_errors["subject"] = _t("Please enter a subject");
			}
			if(!$ps_message && ($this->opo_plugin_config->get('require_message_text'))){
				$va_errors["message"] = _t("Please enter a message");
			}
			if(!$this->request->isLoggedIn()){
				# --- check for security answer if not logged in
				if ((!$pn_security)) {
					$va_errors["security"] = _t("Please answer the security question.");
				}else{
					if($pn_security != $pn_sum){
						$va_errors["security"] = _t("Your answer was incorrect, please try again");
					}
				}
			}
 			
 			$this->view->setVar('t_item', $t_item);
 			$this->view->setVar('item_id', $pn_item_id);
 			$this->view->setVar('tablename', $ps_tablename);
 			$this->view->setVar('errors', $va_errors);

 			if(sizeof($va_errors) == 0){
				# -- generate mail text from template - get both html and text versions
				ob_start();
				require($this->request->getAppConfig()->get('application_plugins')."/Share/themes/".$this->ops_theme."/views/mailTemplates/share_email_text.tpl");
				$vs_mail_message_text = ob_get_contents();
				ob_end_clean();
				ob_start();
				require($this->request->getAppConfig()->get('application_plugins')."/Share/themes/".$this->ops_theme."/views/mailTemplates/share_email_html.tpl");
				$vs_mail_message_html = ob_get_contents();
				ob_end_clean();
				
				if(caSendmail($va_to_email, array($ps_from_email => $ps_from_name), $ps_subject, $vs_mail_message_text, $vs_mail_message_html, null, null, $va_media)){
 					$this->notification->addNotification(_t("Your email was sent"), "message");
 					$this->response->setRedirect(caNavUrl($this->request, 'Detail', $vs_controller, 'Show', array($t_item->PrimaryKey() => $pn_item_id)));
 					return;
 				}else{
 					$this->notification->addNotification(_t("Your email could not be sent"), "message");
 					$va_errors["email"] = 1;
 				}
 			}
 			if(sizeof($va_errors)){
 				# --- there were errors in the form data, so reload form with errors displayed - pass params to preload form
 				$this->view->setVar('to_email', $ps_to_email);
 				$this->view->setVar('from_email', $ps_from_email);
 				$this->view->setVar('from_name', $ps_from_name);
 				$this->view->setVar('subject', $ps_subject);
 				$this->view->setVar('message', $ps_message);
 				
 				$this->notification->addNotification(_t("There were errors in your form"), "message");
 				$this->render('form_html.php'); 			
 			}
 		} 		
 		# -------------------------------------------------------
 	}
 ?>
