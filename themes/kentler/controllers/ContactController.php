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
	require_once(__CA_MODELS_DIR__."/ca_lists.php");
	
 	class ContactController extends BasePawtucketController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
            $this->config = caGetContactConfig();
 			if(!$this->config->get("contact_email") && !$this->config->get("contact_form_elements")){
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
 			if(!$this->request->isLoggedIn()){
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
 					$vs_element_value = $o_purifier->purify($this->request->getParameter($vs_element_name, pString));
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
				# --- check that selected benefit item is still available.  
				# --- If so, set to unavailable and send email
				# --- otherwise set error array so falls through to form with link back to benefit page
				$pn_id = $this->request->getParameter("id", pInteger);
				$ps_table = $this->request->getParameter("table", pString);
				$ps_contactType = $this->request->getParameter("contactType", pString);
				if(($ps_contactType == "benefit") && $pn_id && $ps_table){
					$t_item = Datamodel::getInstanceByTableName($ps_table);
					if($t_item){
						$t_item->load($pn_id);
						$va_removed_attribute = $t_item->get("ca_objects.removed", array("returnWithStructure" => true));
						if($va_removed_attribute){
							$va_tmp = array_pop($va_removed_attribute);
							foreach($va_tmp as $vn_attribute_id => $va_values){
								# --- 137 = yes
								$t_list = new ca_lists();
								# --- 2 types of collection item object records
								$vn_yes_list_item_id = $t_list->getItemIDFromList("yn", "yes");
	
								if(strtolower($va_values["removal_text"]) == $vn_yes_list_item_id){
									$va_errors["benefit"] = "Item no longer available"; 
								}else{
									# --- remove the attribute set to no or not set
									$t_item->setMode(ACCESS_WRITE);
									$t_item->removeAttribute($vn_attribute_id);
									$t_item->update();
								}
							}
						}
						if(!$va_errors["benefit"]){							
							$this->request->user->setPreference("user_profile_number_of_items_selected", intval($this->request->user->getPreference("user_profile_number_of_items_selected")) + 1);
							$vs_name = $o_purifier->purify($this->request->getParameter('name', pString));
							$vs_email = $o_purifier->purify($this->request->getParameter('email', pString));
							$vs_message = $o_purifier->purify($this->request->getParameter('message', pString));
							$t_item->setMode(ACCESS_WRITE);
							$t_item->addAttribute(['removal_text' => 'yes', 'removed_date' => date("F j, Y, g:i a"), 'removed_notes' => 'Virtual Benefit: Selected by '.$vs_name.' ('.$vs_email.') '.(($vs_message) ? 'with message: '.$vs_message : ''), 'locale_id' => 1], 'removed');
							$t_item->update();
						}
					}
				}
			} 			
 			if(sizeof($va_errors) == 0){
 				# --- send admin notification email
 					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
 					$o_view->setVar("contact_form_elements", $va_fields);
 					# -- generate email subject line from template
					$vs_subject_line = $o_view->render("mailTemplates/contact_subject.tpl");
						
					# -- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/contact.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/contact_html.tpl");
					if(caSendmail($this->config->get("contact_email"), $this->config->get("contact_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html)){
						# --- send user confirmation email
						$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
						$o_view->setVar("contact_form_elements", $va_fields);
						# -- generate email subject line from template
						$vs_subject_line = $o_view->render("mailTemplates/benefit_confirmation_subject.tpl");
					
						# -- generate mail text from template - get both the text and the html versions
						$vs_mail_message_text = $o_view->render("mailTemplates/benefit_confirmation.tpl");
						$vs_mail_message_html = $o_view->render("mailTemplates/benefit_confirmation_html.tpl");
						if(caSendmail($vs_email, $this->config->get("contact_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html)){
							$this->render("Contact/success_html.php");
						}else{
							$va_errors["display_errors"]["send_error"] = _t("Your email could not be sent");
							$this->view->setVar("errors", $va_errors);
							$this->form();
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