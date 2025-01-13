<?php
/* ----------------------------------------------------------------------
 * controllers/ContactController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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
	/**
	 * Set up form configuration
	 */
	public function __construct($request, $response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		$this->config = caGetContactConfig();
		if(!$this->config->get("contact_email") && !$this->config->get("contact_form_elements")){
			$this->notification->addNotification(_t("Contact form is not configured properly"), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, '', '', ''));
		}
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contact"));
		caSetPageCSSClasses(["contact"]);
	}
	# -------------------------------------------------------
	/**
	 * Generate form for display
	 */
	public function Form() {
		$fields = $this->config->get("contact_form_elements");
		$this->view->setVar("contact_form_elements", $fields);
		
		$id = $this->request->getParameter("id", pInteger);
		$table = $this->request->getParameter("table", pString);
		
		// Get configured detail types
		$o_dconfig = caGetDetailConfig();
		if(!is_array($detail_types = $o_dconfig->get('detailTypes'))) {
			throw new ApplicationException(_('No details configured'));
		}
		
		$configured_tables = array_values(array_filter(array_map(function($v) { return $v['table'] ?? null; }, $detail_types), 'strlen'));
		if(strlen($table) && !in_array($table, $configured_tables, true)) { 
			throw new ApplicationException(_t('Invalid table: %1', $table));
		}
		if($id) {
			$t_item = $table::findAsInstance($id, ['checkAccess' => $this->opa_access_values]);
		} else {
			$t_item = Datamodel::getInstanceByTableName($table, true);
		}
		$this->view->setVar('t_item', $t_item);
		
		$this->render("Contact/form_html.php");
	}
	# ------------------------------------------------------
	/**
	 * Send message
	 */
	public function Send() {
		caValidateCSRFToken($this->request);
		$o_purifier = caGetHTMLPurifier();
		
		// Check for errors
		$errors = [];
		if($this->config->get("check_security")){
			$security = $this->request->getParameter("security", pString);
			if(!$security || ($security != ($_REQUEST["sum"] ?? null))){
				$errors["display_errors"]["security_error"] = _t("Please answer the security question");
			}
		}
		if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") && __CA_GOOGLE_RECAPTCHA_SECRET_KEY__){
			try {
				caVerifyCaptcha($this->request->getParameter("g-recaptcha-response", pString));
			} catch(CaptchaException $e) {
				$errors["recaptcha"] = $errors["display_errors"]["recaptcha"] = $e->getMessage();
			}
		}
		
		$from = $this->request->config->get("ca_admin_email");
		
		$fields = $this->config->get("contact_form_elements");
		$this->view->setVar("contact_form_elements", $fields);
		if(is_array($fields) && sizeof($fields)){
			foreach($fields as $element_name => $options){
				$element_value = $o_purifier->purify($this->request->getParameter($element_name, pString, ['forcePurify' => true]));
				if($options["required"] && !$element_value){
					$errors[$element_name] = true;
					$errors["display_errors"]["required_error"] = _t("Please enter the required information in the highlighted fields");
				}
				if($options["email_address"] ?? null){
					# --- check if entered value is valid email address
					if (!caCheckEmailAddress($element_value)) {
						$errors["display_errors"]["email_address_error"] = _t("Please enter a valid e-mail address");
						$errors[$element_name] = true;
					}
				}
				if($options['use_as_from_address'] ?? false) {
					$from = $element_value;
				}
				$this->view->setVar($element_name, $element_value);
			}
		}
		if(sizeof($errors) === 0){
				// Send email
				$o_view = new View($this->request, [$this->request->getViewsDirectoryPath()]);
				$o_view->setVar("contact_form_elements", $fields);
				
				// Generate email subject line from template
				$subject_line = $o_view->render("mailTemplates/contact_subject.tpl");
					
				// Generate mail text from template - get both the text and the html versions
				$mail_message_text = $o_view->render("mailTemplates/contact.tpl");
				$mail_message_html = $o_view->render("mailTemplates/contact_html.tpl");
				if(caSendmail($this->config->get("contact_email"), $from, $subject_line, $mail_message_text, $mail_message_html)){
					$this->render("Contact/success_html.php");
				} else  {
					$errors["display_errors"]["send_error"] = _t("Your email could not be sent");
					$this->view->setVar("errors", $errors);
					$this->form();
				}
		} else {
			$this->view->setVar("errors", $errors);
			$this->form();
		}
	}
	# -------------------------------------------------------
}
