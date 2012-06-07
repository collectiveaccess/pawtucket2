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
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
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
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function Index() {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
			$t_object = new ca_objects();
			
			if(!$t_object->load($pn_object_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			$this->view->setVar('t_object', $t_object);
 			$this->view->setVar('object_id', $pn_object_id);
 			
 			$this->render('form_html.php');
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
			if(!$ps_to_email || !caCheckEmailAddress($ps_to_email)){
				$ps_to_email = "";
				$va_errors["to_email"] = _t("Please enter a valid email address");
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
			if(!$ps_message){
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
				
				# --- get media for attachment
				$va_reps = $t_object->getPrimaryRepresentation(array($this->opo_plugin_config->get('email_media_version'), "original"), null, array('return_with_access' => $va_access_values));
				$va_media = null;
				$vs_media_path = "";
				$vs_media_name = "";
				$vs_media_mime_type = "";

				if(is_array($va_reps) && sizeof($va_reps)){
					$va_media = array();
					if(in_array($va_reps["mimetype"], array("application/pdf"))){
						# --- send original version if PDF
						$vs_version = "original";
					}else{
						$vs_version = $this->opo_plugin_config->get('email_media_version');
					}
					$va_media["path"] = $va_reps["paths"][$vs_version];
					if($va_reps["info"][$vs_version]["PROPERTIES"]["mimetype"]){
						$va_media["mime_type"] = $va_reps["info"][$vs_version]["PROPERTIES"]["mimetype"];
					}
					if($va_reps["original_filename"]){
						$va_media["name"] = $va_reps["original_filename"];
					}elseif($va_reps["info"][$vs_version]["FILENAME"]){
						$va_media["name"] = $va_reps["info"][$vs_version]["FILENAME"];
					}					
				}
				
				if(caSendmail($ps_to_email, array($ps_from_email => $ps_from_name), $ps_subject, $vs_mail_message_text, $vs_mail_message_html, null, null, $va_media)){
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
 				$this->render('form_html.php'); 			
 			}
 		} 		
 		# -------------------------------------------------------
 	}
 ?>
