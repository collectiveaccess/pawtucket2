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
 
 	require_once(__CA_MODELS_DIR__.'/ca_set_items.php');
 
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
 					$va_reps = $t_component->getRepresentations(array("original"));
 					$va_module_titles[$t_component->get("ca_objects.parent_id")] = $t_component->get("ca_objects.parent.preferred_labels.name");
 					$va_modules[$t_component->get("ca_objects.parent_id")][$vn_object_id] = array(
 						"title"	=> $t_component->get("ca_objects.preferred_labels.name"),
 						"type"				=> $t_component->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)),
						"authors"			=> $t_component->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("author"))),
						"abstract"			=> $t_component->get("ca_objects.abstract"),
						"rep_ids"			=> array_keys($va_reps),
						"reps"				=> $va_reps			
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
 			$vn_date_type_id = $t_lists->getItemIdFromList("date_types", "dateSubmitted");
 			
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
				$va_attributes = array("name" => $ps_title, "date" => array("dates_value" => "now", "dc_dates_types" => $vn_date_type_id), "comments" => array("comment_text" => $ps_comment, "comment_date" => "now", "commenter" => $this->opt_entity->get("entity_id")));
				$t_rep = $t_component->addRepresentation($ps_file, $vn_rep_type_id, $g_ui_locale_id, 0, 0, false, $va_attributes, array('original_filename' => $ps_file_original_name, "returnRepresentation" => true));
          		if ($t_component->numErrors()) {
					$va_errors["general"] = join("; ", $t_component->getErrors());
					$this->notification->addNotification(_t('There were errors: ').join(", ", $va_errors), __NOTIFICATION_TYPE_ERROR__);
					$this->Index(); 
				} else {
					# --- link author
					$t_rep->addRelationship("ca_entities", $this->opt_entity->get("entity_id"), 23);
					$this->notification->addNotification(_t('Added file to %1', $vs_component_name), __NOTIFICATION_TYPE_INFO__);
					# --- send email notification to admin
					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
					$o_view->setVar("component_name", $vs_component_name);
					$o_view->setVar("author_name", $this->request->user->get("fname")." ".$this->request->user->get("lname"));
					
					# -- generate email subject line from template
					$vs_subject_line = $o_view->render("mailTemplates/author_submission_subject.tpl");

					# -- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/author_submission_conf.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/author_submission_conf_html.tpl");
					caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);

				}
				
			}else{
				$this->notification->addNotification(_t('There were errors: ').join(", ", $va_errors), __NOTIFICATION_TYPE_ERROR__);        	
			}
 			
 			$this->Index();
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns content for overlay containing details for object representation
 		 *
 		 * Expects the following request parameters: 
 		 *		object_id = the id of the ca_objects record to display
 		 *		representation_id = the id of the ca_object_representations record to display; the representation must belong to the specified object
 		 *
 		 *	Optional request parameters:
 		 *		version = The version of the representation to display. If omitted the display version configured in media_display.conf is used
 		 *
 		 */ 
 		public function GetRepresentationInfo() {
 			$o_config = caGetDetailConfig();
 			$o_detail_types = $o_config->getAssoc('detailTypes');
 			$pn_object_id 			= $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			$pn_item_id 			= $this->request->getParameter('item_id', pInteger);
 			if (!$ps_display_type 	= trim($this->request->getParameter('display_type', pString))) { $ps_display_type = 'media_overlay'; }
 			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			$va_detail_options 		= (isset($o_detail_types['objects']['options']) && is_array($o_detail_types['objects']['options'])) ? $o_detail_types['objects']['options'] : array();
 			
 			if(!$pn_object_id) { $pn_object_id = 0; }
 			$t_rep = new ca_object_representations($pn_representation_id);
 			if (!$t_rep->getPrimaryKey()) { 
 				$this->postError(1100, _t('Invalid object/representation'), 'DetailController->GetRepresentationInfo');
 				return;
 			}
 			$va_opts = array('display' => $ps_display_type, 'object_id' => $pn_object_id, 'representation_id' => $pn_representation_id, 'item_id' => $pn_item_id, 'containerID' => $ps_containerID);
 			if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }

			$vs_caption = ($vs_caption_template = caGetOption('representationViewerCaptionTemplate', $va_detail_options, false)) ? $t_rep->getWithTemplate($vs_caption_template) : '';
			
			$vs_output = $t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts);
			if ($this->request->getParameter('include_tool_bar', pInteger)) {
				$vs_output = "<div class='repViewerContCont'><div id='cont{$vn_rep_id}' class='repViewerCont'>".$vs_output.caRepToolbar($this->request, $t_rep, $pn_object_id).$vs_caption."</div></div>";
			}

 			$this->response->addContent($vs_output);
 		}
 		# -------------------------------------------------------
		/**
		 * Download single representation from currently open object
		 *
		 * TODO: remove and route all references to DownloadMedia()
		 */ 
		public function DownloadRepresentation() {
			$vn_object_id = $this->request->getParameter('object_id', pInteger);
			$t_object = new ca_objects($vn_object_id);
			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
			$ps_version = $this->request->getParameter('version', pString);
			
			$this->view->setVar('representation_id', $pn_representation_id);
			$t_rep = new ca_object_representations($pn_representation_id);
			$this->view->setVar('t_object_representation', $t_rep);
			
			$va_versions = $t_rep->getMediaVersions('media');
			
			if (!in_array($ps_version, $va_versions)) { $ps_version = $va_versions[0]; }
			$this->view->setVar('version', $ps_version);
			
			$va_rep_info = $t_rep->getMediaInfo('media', $ps_version);
			$this->view->setVar('version_info', $va_rep_info);
			
			$va_info = $t_rep->getMediaInfo('media');
			$vs_idno_proc = preg_replace('![^A-Za-z0-9_\-]+!', '_', $t_object->get('idno'));
			
			if ($va_info['ORIGINAL_FILENAME']) {
				$va_tmp = explode('.', $va_info['ORIGINAL_FILENAME']);
				if (sizeof($va_tmp) > 1) { 
					if (strlen($vs_ext = array_pop($va_tmp)) < 3) {
						$va_tmp[] = $vs_ext;
					}
				}
				$this->view->setVar('version_download_name', str_replace(" ", "_", join('_', $va_tmp).'.'.$va_rep_info['EXTENSION']));					
			} else {
				$this->view->setVar('version_download_name', $vs_idno_proc.'_representation_'.$pn_representation_id.'_'.$ps_version.'.'.$va_rep_info['EXTENSION']);
			}
			
			//
			// Perform metadata embedding
			#if ($vs_path = caEmbedMetadataIntoRepresentation($t_object, $t_rep, $ps_version)) {
			#	$this->view->setVar('version_path', $vs_path);
			#} else {
				$this->view->setVar('version_path', $t_rep->getMediaPath('media', $ps_version));
			#}
			$this->response->sendHeaders();
			$vn_rc = $this->render('Details/object_representation_download_binary.php');
			$this->response->sendContent();
			if ($vs_path) { unlink($vs_path); }
			return $vn_rc;
		}
 		# -------------------------------------------------------
 	}