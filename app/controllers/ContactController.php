<?php
/* ----------------------------------------------------------------------
 * controllers/ContactController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2017 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/ApplicationError.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class ContactController extends BasePawtucketController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
            $this->config = caGetContactConfig();
 			if(!$this->config->get("contact_email") && !$this->config->get("contact_form_elements")){
 				$this->notification->addNotification(_t("Contact form is not configured properly"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl('', '', ''));
 			}
 		}
 		# ------------------------------------------------------
 		public function Send() {
 		    caValidateCSRFToken($this->request);
 			$o_purifier = new HTMLPurifier();
 			# --- check for errors
			#$error = false;

 			# --- not supporting sum check?
 			#if($this->config->get("check_security")){
 			#	$ps_security = $this->request->getParameter("security", pString);
 			#	if (!$ps_security || (($ps_security != $_REQUEST["sum"]))) {
			#		$this->view->setVar('data', [
			#			'status' => 'err', 'error' => _t("Please answer the security question")
			#		]);
			#		$error = true;
			#	}
 			#}
 			$field_errors = [];
 			if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") && __CA_GOOGLE_RECAPTCHA_SECRET_KEY__){
 				$ps_captcha = $this->request->getParameter("g-recaptcha-response", pString);
 				if(!$ps_captcha){
					$field_errors["captcha"] = _t("Please complete the captcha");
				} else {
					$va_request = curl_init();
					curl_setopt($va_request, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
					curl_setopt($va_request, CURLOPT_HEADER, 0);
					curl_setopt($va_request, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($va_request, CURLOPT_POST, 1);
					$va_request_params = ['secret'=>__CA_GOOGLE_RECAPTCHA_SECRET_KEY__, 'response'=>$ps_captcha];
					curl_setopt($va_request, CURLOPT_POSTFIELDS, $va_request_params);
					$va_captcha_resp = curl_exec($va_request);
					$captcha_json = json_decode($va_captcha_resp, true);
					if(!$captcha_json['success']){
						$field_errors["captcha"] = _t("Your Captcha was rejected, please try again");
					}
				}
 			}

 			$fields = $this->config->get("contact_form_elements");
			if(is_array($fields) && sizeof($fields)){
 				foreach($fields as $vs_element_name => $va_options){
 					$vs_element_value = $o_purifier->purify($this->request->getParameter($vs_element_name, pString));
 					if($va_options["required"] && !$vs_element_value){
 						$field_errors[$vs_element_name] = _t('Field is required');
 					}
 					if($va_options["email_address"]){
 						# --- check if entered value is valid email address
 						if (!caCheckEmailAddress($vs_element_value)) {
							$field_errors[$vs_element_name]= _t("Please enter a valid e-mail address");
						}
 					}
 				}
 			}
 			if(sizeof($field_errors) == 0){
				$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				$o_view->setVar("contact_form_elements", $fields);
				# -- generate email subject line from template
				$vs_subject_line = $o_view->render("mailTemplates/contact_subject.tpl");

				# -- generate mail text from template - get both the text and the html versions
				$vs_mail_message_text = $o_view->render("mailTemplates/contact.tpl");
				$vs_mail_message_html = $o_view->render("mailTemplates/contact_html.tpl");
				if(caSendmail($this->config->get("contact_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html)){
					$this->view->setVar('data', [
						'status' => 'ok'
					]);
				}else{
					$va_errors["display_errors"]["send_error"] = _t("");
					$this->view->setVar('data', [
						'status' => 'err', 'error' => _t('Your email could not be sent')
					]);
				}
 			} else {
				$this->view->setVar('data', [
					'status' => 'err', 'error' => _t('Please correct the errors and try again'), 'fieldErrors' => $field_errors
				]);
			}

			$this->render('Contact/data_json.php');
 		}
 		# -------------------------------------------------------
 	}
