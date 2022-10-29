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
 			if(!$this->config->get("contact_form_elements")){
 				$this->notification->addNotification(_t("Contact form is not configured properly"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl($this->request, '', '', ''));
 			}
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contact"));
 			caSetPageCSSClasses(array("contact"));
 		}
 		# -------------------------------------------------------
 		public function Form() {
			$this->render("Contact/form_html.php");
 		}
 		# ------------------------------------------------------
 		public function Send() {
 		    caValidateCSRFToken($this->request);
 			$o_purifier = new HTMLPurifier();
 			# --- check for errors
 			$va_errors = array();
 			if($this->config->get("check_security")){
 				$ps_security = $this->request->getParameter("security", pString);
 				if ((!$ps_security)) {
					$va_errors["security"] = true;
				}else{
					if($ps_security != $_REQUEST["sum"]){
						$va_errors["security"] = true;
					}
				}
				if($va_errors["security"]){
					$va_errors["display_errors"]["security_error"] = _t("Please answer the security question");
				}
 			}
 			if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") && __CA_GOOGLE_RECAPTCHA_SECRET_KEY__){
 				$ps_captcha = $this->request->getParameter("g-recaptcha-response", pString);
 				if(!$ps_captcha){
						$va_errors["recaptcha"] = $va_errors["display_errors"]["recaptcha"] = _t("Please complete the captcha");
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
							$va_errors["recaptcha"] = $va_errors["display_errors"]["recaptcha"] = _t("Your Captcha was rejected, please try again");
					}
				}
 			}
 			$va_fields = $this->config->get("contact_form_elements");
 			$this->view->setVar("contact_form_elements", $va_fields);
 			if(is_array($va_fields) && sizeof($va_fields)){
 				foreach($va_fields as $vs_element_name => $va_options){
 					$vs_element_value = $o_purifier->purify($this->request->getParameter($vs_element_name, pString, ['forcePurify' => true]));
 					if($va_options["required"] && !$vs_element_value){
 						$va_errors[$vs_element_name] = true;
 						$va_errors["display_errors"]["required_error"] = _t("Please enter the required information in the highlighted fields");
 					}
 					if($va_options["email_address"]){
 						# --- check if entered value is valid email address
 						if (!caCheckEmailAddress($vs_element_value)) {
							$va_errors["display_errors"]["email_address_error"] = _t("Please enter a valid e-mail address");
							$va_errors[$vs_element_name] = true;
						}
 					}
 					$this->view->setVar($vs_element_name, $vs_element_value);
 				}
 			}
 			if(sizeof($va_errors) == 0){
 				# --- send email
 					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
 					$o_view->setVar("contact_form_elements", $va_fields);
 					# -- generate email subject line from template
					$vs_subject_line = $o_view->render("mailTemplates/contact_subject.tpl");
						
					# -- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/contact.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/contact_html.tpl");
					$vs_sendTo = $o_purifier->purify($this->request->getParameter('sendTo', pString, ['forcePurify' => true]));
					if(caSendmail($vs_sendTo, $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html)){
						if(($pn_id = $this->request->getParameter('id', pInteger)) && ($ps_table = $this->request->getParameter('table', pString))){
							$this->notification->addNotification(_t("Thank you for your inquiry."), __NOTIFICATION_TYPE_ERROR__);
							$this->response->setRedirect(caDetailUrl($this->request, $ps_table, $pn_id));
						}else{
							$this->render("Contact/success_html.php");
						}
					}else{
						$va_errors["display_errors"]["send_error"] = _t("Your email could not be sent");
						$this->view->setVar("errors", $va_errors);
						$this->form();
					}
 			}else{
 				$this->view->setVar("errors", $va_errors);
 				$this->form();
 			}
 		}
 		# -------------------------------------------------------
 	}