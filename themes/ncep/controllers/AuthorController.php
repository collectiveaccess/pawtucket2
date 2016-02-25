<?php
/* ----------------------------------------------------------------------
 * controllers/AuthorController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_metadata_elements.php');
	require_once(__CA_APP_DIR__."/helpers/contributeHelpers.php");
	require_once(__CA_LIB_DIR__."/ca/Utils/DataMigrationUtils.php");
 
 	class AuthorController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 * Entity linked to logged in user
 		 */
 		protected $opt_entity;
 		
 		/**
         * @var HTMLPurifier
         */
        protected $purifier;
        
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
            if (!$this->request->isLoggedIn() || !$this->request->user->hasUserRole("author")) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			caSetPageCSSClasses(array("authorDashboard", "detail"));
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			
 			# --- find the entity record linked to this user --- the entity is associated with the modules/components as author
 			$vn_entity_id = $this->request->user->get("entity_id");
 			$this->opt_entity = new ca_entities($vn_entity_id);
 			if(!$this->opt_entity->get("entity_id")){
 				$this->notification->addNotification(_t('There is no entity record linked to this user'), __NOTIFICATION_TYPE_INFO__);
				$this->response->setRedirect(caNavUrl($this->request, "", "", ""));
				return;
 			}
 			$this->purifier = new HTMLPurifier();
 		}
 		# -------------------------------------------------------
 		/**
 		 * List user's components
 		 */
 		public function Index() {
 			$va_objects = $this->opt_entity->get("ca_objects.object_id", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("author")));
 			$va_modules = array();
 			$va_module_titles = array();
 			if(sizeof($va_objects)){
 				$t_component = new ca_objects();
 				foreach($va_objects as $vn_object_id){
 					$t_component->load($vn_object_id);
 					$va_module_titles[$t_component->get("ca_objects.parent_id")] = $t_component->get("ca_objects.parent.preferred_labels.name");
 					$va_modules[$t_component->get("ca_objects.parent_id")][$vn_object_id] = array(
 						"title"	=> $t_component->get("ca_objects.preferred_labels.name"),
 						"type"				=> $t_component->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)),
						"authors"			=> $t_component->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("author"))),
						"abstract"			=> $t_component->get("ca_objects.abstract"),
						"rep_ids"			=> $t_component->get("ca_object_representations.representation_id", array("returnWithStructure" => true))			
 					);
 				}
 			}
 			$this->view->setVar("num_components", sizeof($va_objects));
 			$this->view->setVar("modules", $va_modules);
 			$this->view->setVar("module_titles", $va_module_titles);
 			$this->render("Author/index_html.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 * generate form
 		 */
 		public function Form() {
 			$vn_object_id = $this->request->getParameter('object_id', pInteger);
 			$this->view->setVar("object_id", $vn_object_id);
 			$t_component = new ca_objects();
 			$t_component->load($vn_object_id);
 			$this->view->setVar("component_name", $t_component->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)).": ".$t_component->get("ca_objects.preferred_labels.name"));
 			$this->render("Author/form_html.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 * generate form
 		 */
 		public function SaveForm() {
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			$vn_object_id = $this->request->getParameter('object_id', pInteger);
 			$this->view->setVar("object_id", $vn_object_id);
 			$t_component = new ca_objects();
 			$t_component->load($vn_object_id);
 			$vs_component_name = $t_component->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)).": ".$t_component->get("ca_objects.preferred_labels.name");
 			$this->view->setVar("component_name", $vs_component_name);
 			$this->view->setVar("author_name", $this->request->user->get("fname")." ".$this->request->user->get("lname"));
 			$t_lists = new ca_lists();
 			$vn_rep_type_id = $t_lists->getItemIdFromList("object_representation_types", "front");
 			
 			# --- check params
 			# title
 			if(!($ps_title = $this->purifier->purify($this->request->getParameter('title', pString)))){
 				$va_errors["title"] = _t("Please enter a title for your file");
 			}
 			$this->view->setVar("title", $ps_title);
 			# file
 			if(!$ps_file = $_FILES['file']['tmp_name']){
 				$va_errors["file"] = _t("Please upload your file");
 			}
 			$ps_file_original_name = $_FILES['file']['name'];
 			
 			# comment - optional
 			$ps_comment =  $this->purifier->purify($this->request->getParameter('comment', pString));
 			$this->view->setVar("comment", $ps_comment);

			if(sizeof($va_errors) == 0){
				$va_attributes = array("label" => $ps_title, "comment_text" => $vs_comment, "comment_date" => "now", "commenter" => $this->opt_entity->get("entity_id"));
				$vn_rc = $t_component->addRepresentation($ps_file, $vn_rep_type_id, $g_ui_locale_id, 0, 0, false, $va_attributes, array('original_filename' => $ps_file_original_name));
          		print $vn_rc;			
				if ($t_component->numErrors()) {
					$va_errors["general"] = join("; ", $t_component->getErrors());
					$this->notification->addNotification(_t('There were errors: ').join(", ", $va_errors), __NOTIFICATION_TYPE_ERROR__);
					$this->Index(); 
				} else {
					$this->notification->addNotification(_t('Added file to %1', $vs_component_name), __NOTIFICATION_TYPE_INFO__);
					# --- send email notification to admin
					#$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));

					# -- generate email subject line from template
					#$vs_subject_line = $o_view->render("mailTemplates/author_submission_subject.tpl");

					# -- generate mail text from template - get both the text and the html versions
					#$vs_mail_message_text = $o_view->render("mailTemplates/author_submission_conf.tpl");
					#$vs_mail_message_html = $o_view->render("mailTemplates/author_submission_conf_html.tpl");
					#caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);

				}
				
			}else{
				$this->notification->addNotification(_t('There were errors: ').join(", ", $va_errors), __NOTIFICATION_TYPE_ERROR__);        	
			}
 			
 			$this->Index();
 		}
 		# -------------------------------------------------------
 	}