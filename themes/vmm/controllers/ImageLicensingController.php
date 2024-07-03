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
 	require_once(__CA_APP_DIR__."/helpers/exportHelpers.php");
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 
 	class ImageLicensingController extends BasePawtucketController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
            $this->config = Configuration::load(__CA_THEME_DIR__.'/conf/image_licensing.conf');
 			if(!$this->config->get("contact_email") && !$this->config->get("licensing_form_elements")){
 				$this->notification->addNotification(_t("Image licensing form is not configured properly"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl($this->request, '', '', ''));
 			}
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Image Licensing or Reproduction Request"));
 			caSetPageCSSClasses(array("contact"));
 		}
 		# -------------------------------------------------------
 		public function Form() {
			$this->render("ImageLicensing/form_html.php");
 		}
 		# ------------------------------------------------------
 		public function Send() {
 		    caValidateCSRFToken($this->request);
 			# --- $o_view is object used for pdf export view
 			$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				
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
 			$va_fields = $this->config->get("licensing_form_elements");
 			$this->view->setVar("licensing_form_elements", $va_fields);
 			$o_view->setVar("licensing_form_elements", $va_fields);
 			
 			$ps_table = $this->request->getParameter("table", pString);
 			$this->view->setVar("table", $ps_table);
 			$o_view->setVar("table", $ps_table);
 			$pn_id = $this->request->getParameter("id", pInteger);
 			$this->view->setVar("id", $pn_id);
 			$o_view->setVar("id", $pn_id);
				
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
 					$o_view->setVar($vs_element_name, $vs_element_value);
 				}
 			}
 			$va_fields_per_item = $this->config->get("licensing_form_elements_per_object");
			switch($ps_table){
				case "ca_objects":
					$t_item = new ca_objects($pn_id);
				break;
				# ---------------------------
				case "ca_sets":
					$t_item = new ca_sets($pn_id);
				break;
				# ---------------------------
			}

			if($t_item && $ps_table){
				$va_object_ids = array();
				if($ps_table == "ca_objects"){
					$va_object_ids[] = $pn_id;
				}elseif($ps_table == "ca_sets"){
					$va_object_ids = array_keys($t_item->getItemRowIDs(array("checkAccess" => $this->opa_access_values)));
				}
				$o_view->setVar("object_ids", $va_object_ids);
				$qr_objects = caMakeSearchResult('ca_objects', $va_object_ids, array('checkAccess' => $this->opa_access_values));
				$va_objects_info = array();
				if($qr_objects->numHits()){
					while($qr_objects->nextHit()){
						$va_fields_for_item = array();	
						if(is_array($va_fields_per_item) && sizeof($va_fields_per_item)){
							foreach($va_fields_per_item as $vs_element_name => $va_options){
								$vs_element_value = $o_purifier->purify($this->request->getParameter($vs_element_name.$qr_objects->get("object_id"), pString));
								if($va_options["required"] && !$vs_element_value){
									$va_errors[$vs_element_name.$qr_objects->get("object_id")] = true;
									$va_errors["display_errors"]["required_error"] = _t("Please enter the required information in the highlighted fields");
								}
								$this->view->setVar($vs_element_name.$qr_objects->get("object_id"), $vs_element_value);
								$o_view->setVar($vs_element_name.$qr_objects->get("object_id"), $vs_element_value);
								
								$va_fields_for_item[] = array("label" => $va_options["label"], "value" => $vs_element_value);
							}
						}
						
						$va_objects_info[$qr_objects->get("ca_objects.object_id")] = array("title" => $qr_objects->get("ca_objects.preferred_labels"), "idno" => $qr_objects->get("ca_objects.idno"), "image" => $qr_objects->getMediaTag("ca_object_representations.media", "small", array("checkAccess" => $this->opa_access_values)), "fields" => $va_fields_for_item);
						
					}
					$o_view->setVar("object_information", $va_objects_info);
				}
			}
			
 			
 			
 		

 			if(sizeof($va_errors) == 0){
 				$va_template_info = caGetPrintTemplateDetails('summary', 'image_licensing_form_export');
				
				$vs_file_content = caExportViewAsPDF($o_view, $va_template_info, "image_licensing_form.pdf", array("returnFile" => true));
				$vs_temp_file_path = tempnam ( __CA_APP_DIR__."/tmp/", "ca_image_licensing_form_export_");
				file_put_contents($vs_temp_file_path, $vs_file_content);
				#caExportViewAsPDF($o_view, $va_template_info, "image_licensing_form.pdf");
				#$o_controller = AppController::getInstance();
				#$o_controller->removeAllPlugins();
 				# --- send email
				$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				$o_view->setVar("licensing_form_elements", $va_fields);
				$o_view->setVar("licensing_form_elements_per_item", $va_fields_per_item);
				$o_view->setVar("object_information", $va_objects_info);
				
				# --- generate email subject line from template
				$vs_subject_line = $o_view->render("mailTemplates/image_licensing_subject.tpl");
					
				# --- generate admin notification mail text from template - get both the text and the html versions
				$vs_mail_message_text = $o_view->render("mailTemplates/image_licensing.tpl");
				$vs_mail_message_html = $o_view->render("mailTemplates/image_licensing_html.tpl");
				if(caSendmail($this->config->get("image_licensing_contact_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html, null, null, array("path" => $vs_temp_file_path, "name" => "ImageLicensingRequest.pdf", "mimetype" => "application/pdf"))){
					# --- send a copy of the pdf to the submitter --- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/image_licensing_user_conf.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/image_licensing_user_conf_html.tpl");
					$vs_submitter_email = $o_purifier->purify($this->request->getParameter("email", pString));
					caSendmail($vs_submitter_email, $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html, null, null, array("path" => $vs_temp_file_path, "name" => "ImageLicensingRequest.pdf", "mimetype" => "application/pdf"));

					$this->render("ImageLicensing/success_html.php");
				}else{
					$va_errors["display_errors"]["send_error"] = _t("Your email could not be sent");
					$this->view->setVar("errors", $va_errors);
					$this->form();
				}
				
				unlink ($vs_temp_file_path);
 			}else{
 				$this->view->setVar("errors", $va_errors);
 				$this->form();
 			}
 		}
 		# -------------------------------------------------------
 	}