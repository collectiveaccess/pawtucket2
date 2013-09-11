<?php
/* ----------------------------------------------------------------------
 * app/lib/ca/BaseBrowseController.php : base controller for search interface
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2012 Whirl-i-Gig
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
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 	require_once(__CA_LIB_DIR__.'/core/GeographicMap.php');
	require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
	require_once(__CA_MODELS_DIR__."/ca_relationship_types.php");
	require_once(__CA_MODELS_DIR__."/ca_lists.php");
 	
	class BaseDetailController extends ActionController {
		# -------------------------------------------------------
 		protected $opo_datamodel;
 		protected $ops_context = '';
		protected $opo_browse;
		protected $ops_tablename;
 		# -------------------------------------------------------
 		#
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			$this->opo_datamodel = Datamodel::load();
 		
 			$vs_browse_table_name = $po_request->config->get('allow_browse_within_detail_for_'.$this->ops_tablename);
			
			// create object browse for filtering objects on collection detail page
			$this->opo_browse = $this->getBrowseInstance($vs_browse_table_name, $po_request->session->getVar($this->ops_tablename.'_'.$this->ops_appname.'_detail_current_browse_id'), $this->ops_appname.'_detail');	
			$this->opa_sorts = $this->getBrowseSorts($vs_browse_table_name);
		
			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			AssetLoadManager::register('maps');
 			AssetLoadManager::register('jcarousel');
 		}
 		# -------------------------------------------------------
 		/**
 		 * Sets current browse context
 		 * Settings for the current browse are stored per-context. This means if you
 		 * have multiple interfaces in the same application using browse services
 		 * you can keep their settings (and caches) separate by varying the context.
 		 *
 		 * The browse engine and browse controller both have their own context settings
 		 * but the BaseDetailController is setup to make the browse engine's context its own.
 		 * Thus you only need set the context for the engine; the controller will inherit it.
 		 */
 		public function setContext($ps_context) {
 			$this->ops_context = $ps_context;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Returns the current browse context
 		 */
 		public function getContext($ps_context) {
 			return $this->ops_context;
 		}
 		# -------------------------------------------------------
 		# Detail display
 		# -------------------------------------------------------
 		/**
 		 * Alias for show() method
 		 */
 		public function Index() {
 			$this->Show();
 		}
 		# -------------------------------------------------------
 		/**
 		 * Generates detail detail. Will use a view named according to the following convention:
 		 *		<table_name>_<type_code>_detail_html.php
 		 *
 		 * So for example, the detail for objects of type 'artwork' (where 'artwork' is the type code for the artwork object type)
 		 * the view would be named "ca_objects_artwork_detail_html.php
 		 *
 		 * If the type specific view does not exist, then Show() will attemp to use a generic table-wide view name like this:
 		 *		<table_name>_detail_html.php
 		 *
 		 * For example: "ca_objects_detail_html.php"
 		 *
 		 * In general you should always have the table wide views defined. Then you can define type-specific views for your
 		 * application on an as-needed basis.
 		 */
 		public function Show($pa_options=null) {
 			AssetLoadManager::register('viz');
 			AssetLoadManager::register("ca", "panel");
 			AssetLoadManager::register("jit");
 			AssetLoadManager::register('browsable');
 			AssetLoadManager::register('imageScroller');
 			AssetLoadManager::register('jquery', 'expander');
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);
 			
 			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true)) {
 				die("Invalid table name ".$this->ops_tablename." for detail");		// shouldn't happen
 			}

 			if(!($vn_item_id = $this->request->getParameter($t_item->primaryKey(), pInteger))){
  				$this->notification->addNotification(_t("Invalid ID"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			if($t_item->hasField('deleted') && $t_item->get('deleted')){
  				$this->notification->addNotification(_t("ID has been deleted"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			// Check if item conforms to any configured display type restrictions
 			if(method_exists($t_item, "getTypeID")) {
 				$va_types = caMergeTypeRestrictionLists($t_item, array());
 				
 				if (is_array($va_types) && sizeof($va_types) && !in_array($t_item->getTypeID(), $va_types)) {
					$this->notification->addNotification(_t("This item is not viewable"), "message");
					$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
					return;
				}
 			}
 			
 			#
 			# Enforce access control
 			#
 			if(sizeof($va_access_values) && !in_array($t_item->get("access"), $va_access_values)){
  				$this->notification->addNotification(_t("This item is not available for view"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			
 			//
 			// In-detail browsing of objects - limited to object linked to the item being displayed
 			//
 			if (($vs_browse_for_table = $this->request->config->get('allow_browse_within_detail_for_'.$this->ops_tablename)) && is_object($this->opo_browse)) {
 				// set browse context for controller
 				$this->setContext($this->opo_browse->getContext());
 				
 				//
				// Restrict facets to specific group for refine browse (if set in app.conf config)
				// 			
				if ($vs_facet_group = $this->request->config->get('ca_objects_refine_facet_group')) {
					$this->opo_browse->setFacetGroup($vs_facet_group);
				}
				
 				$t_table = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true);
				if ($this->request->session->getVar($this->ops_tablename.'_'.$this->ops_appname.'_detail_current_item_id') != $vn_item_id) {
					$this->opo_browse->removeAllCriteria();	
				}
				
				// look for 'authority' facet for current detail table type so we can limit the object browse to the currently displayed item
				//$vs_limit_facet_name = null;
				//foreach($this->opo_browse->getInfoForFacets() as $vs_facet_name => $va_facet_info) {
				//	if (($va_facet_info['type'] === 'authority') && ($va_facet_info['table'] === $this->ops_tablename)) {
				//		$vs_limit_facet_name = $vs_facet_name;
				//		break;
				//	}
				//}
				$this->opo_browse->addFacetConfiguration($vs_limit_facet_name = '_detail_browse_'.$this->ops_tablename, array(
					'type' => 'authority', 'table' => $this->ops_tablename, 'relationship_table' => 'ca_objects_x_entities',
					'restrict_to_types' => array(), 'restrict_to_relationship_types' => array(),
					'label_singular' => 'Detail browse by '.$this->ops_tablename, 
					'label_plural' => 'Detail browse by '.$this->ops_tablename,
					'group_mode' => 'none',
					'indefinite_article' => 'a'
				));
				
				if ($vs_limit_facet_name) {
					if (($va_configured_type_restrictions = $this->request->config->getList($this->ops_tablename.'_detail_browse_type_restrictions')) && is_array($va_configured_type_restrictions)) {
						$this->opo_browse->setTypeRestrictions($va_configured_type_restrictions, array('includeChildren' => false));
					}
					$this->opo_browse->addCriteria($vs_limit_facet_name, array($vn_item_id));
					$this->opo_browse->execute(array('checkAccess' => $va_access_values));
					$this->request->session->setVar($this->ops_tablename.'_'.$this->ops_appname.'_detail_current_browse_id', $this->opo_browse->getBrowseID());
					$this->view->setVar('show_browse', true);
					
					//
					// Browse paging
					//
					$vn_items_per_page = $this->request->config->get("objects_per_page_for_detail_pages");
					if(!$vn_items_per_page){
						$vn_items_per_page = 12;
					}
					$this->view->setVar('page', ($vn_p = $this->request->getParameter('page', pInteger)) ? $vn_p : 1);
					
					$qr_hits = null;
					if ($this->opo_browse) {
						$va_sort = array();
						if ($vs_sort = $this->request->config->get('sort_browse_within_detail_for_'.$this->ops_tablename)) {
							$va_sort = array('sort' => $vs_sort);
						}
	
						$qr_hits = $this->opo_browse->getResults($va_sort);
						$vn_num_pages = ceil($qr_hits->numHits()/$vn_items_per_page);
						$qr_hits->seek(($vn_p - 1) * $vn_items_per_page);
					} else {
						$vn_num_pages = 0;
					}
					
					$this->view->setVar('browse_results', $qr_hits);
					$this->view->setVar('num_pages', (int)$vn_num_pages);
					$this->view->setVar('items_per_page', (int)$vn_items_per_page);
					$this->view->setVar('opo_browse', $this->opo_browse);
 					$this->view->setVar('sorts', $this->opa_sorts);				// supported sorts for the object browse
				
					// browse criteria in an easy-to-display format
					$va_browse_criteria = array();
					foreach($this->opo_browse->getCriteriaWithLabels() as $vs_facet_code => $va_criteria) {
						$va_facet_info = $this->opo_browse->getInfoForFacet($vs_facet_code);
						
						$va_criteria_list = array();
						foreach($va_criteria as $vn_criteria_id => $vs_criteria_label) {
							$va_criteria_list[] = $vs_criteria_label;
						}
						
						$va_browse_criteria[$va_facet_info['label_singular']] = join('; ', $va_criteria_list);
					}
					$this->view->setVar('browse_criteria', $va_browse_criteria);
				} else {
					// not configured for browse
					$this->request->session->setVar($this->ops_tablename.'_'.$this->ops_appname.'_detail_current_browse_id', null);
					$this->view->setVar('show_browse', false);
				}
 			}
 			$this->request->session->setVar($this->ops_tablename.'_'.$this->ops_appname.'_detail_current_item_id', $vn_item_id);
 			
 			# Next and previous navigation
 			$opo_result_context = new ResultContext($this->request, $this->ops_tablename, ResultContext::getLastFind($this->request, $this->ops_tablename));
 		
 			$this->view->setVar('next_id', $opo_result_context->getNextID($vn_item_id));
 			$this->view->setVar('previous_id', $opo_result_context->getPreviousID($vn_item_id));
 			
 			# Is the item we're show details for in the result set?
 			$this->view->setVar('is_in_result_list', ($opo_result_context->getIndexInResultList($vn_item_id) != '?'));
 			
 			# Item instance and id
 			$this->view->setVar('t_item', $t_item);
 			$this->view->setVar($t_item->getPrimaryKey(), $vn_item_id);
 			
 			# Item  - preferred
 			$this->view->setVar('label', $t_item->getLabelForDisplay());
 			
 			# Item  - nonpreferred
 			$this->view->setVar('nonpreferred_labels', caExtractValuesByUserLocale($t_item->getNonPreferredLabels()));
 		
 			# Item timestamps (creation and last change)
 			if ($va_entry_info = $t_item->getCreationTimestamp()) {
 				$this->view->setVar('date_of_entry', date('m/d/Y', $va_entry_info['timestamp']));
 			}
 			
 			if ($va_last_change_info = $t_item->getLastChangeTimestamp()) {
 				$this->view->setVar('date_of_last_change', date('m/d/Y', $va_last_change_info['timestamp']));
 			}
 			
 			
 			# Media representations to display (objects only)
 			if (method_exists($t_item, 'getPrimaryRepresentationInstance')) {
 				if ($t_primary_rep = $t_item->getPrimaryRepresentationInstance()) {
 					if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) { 		// check rep access
						$this->view->setVar('t_primary_rep', $t_primary_rep);
						
						$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
						
						$this->view->setVar('primary_rep_display_version', $va_rep_display_info['display_version']);
						unset($va_display_info['display_version']);
						$va_rep_display_info['poster_frame_url'] = $t_primary_rep->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
						unset($va_display_info['poster_frame_version']);
						$this->view->setVar('primary_rep_display_options', $va_rep_display_info);
					}
				}
 			}
 					
 			 
 			#
 			# User-generated comments, tags and ratings
 			#
 			$va_user_comments = $t_item->getComments(null, true);
 			$va_comments = array();
 			if (is_array($va_user_comments)) {
				foreach($va_user_comments as $va_user_comment){
					if($va_user_comment["comment"] || $va_user_comment["media1"] || $va_user_comment["media2"] || $va_user_comment["media3"] || $va_user_comment["media4"]){
						# TODO: format date based on locale
						$va_user_comment["date"] = date("n/j/Y", $va_user_comment["created_on"]);
						
						# -- get name of commenter
						$t_user = new ca_users($va_user_comment["user_id"]);
						$va_user_comment["author"] = $t_user->getName();
						$va_comments[] = $va_user_comment;
					}
				}
			}
 			$this->view->setVar('comments', $va_comments);
 			
 			$va_user_tags = $t_item->getTags(null, true);
 			$va_tags = array();
 			
 			if (is_array($va_user_tags)) {
				foreach($va_user_tags as $va_user_tag){
					if(!in_array($va_user_tag["tag"], $va_tags)){
						$va_tags[] = $va_user_tag["tag"];
					}
				}
			}
 			$this->view->setVar('tags_array', $va_tags);
 			$this->view->setVar('tags', implode(", ", $va_tags));
 			
			$this->view->setVar('result_context', $opo_result_context);
 			
 			# -- get average user ranking
 			$this->view->setVar('ranking', $t_item->getAverageRating(null));	// null makes it ignore moderation status
 			# -- get number of user rankings
 			$this->view->setVar('numRankings', $t_item->getNumRatings(null));	// null makes it ignore moderation status
 			
 			#
 			# Miscellaneous useful information
 			#
 			$this->view->setVar('t_relationship_types', new ca_relationship_types());					// relationship types object - used for displaying relationship type of related authority information
 			if (method_exists($t_item, 'getTypeName')) { $this->view->setVar('typename', $t_item->getTypeName()); }

 			
 			// Record view
 			$t_item->registerItemView($this->request->getUserID());
 			
 			//
 			// Render view
 			//
 			if(isset($pa_options['view']) && $pa_options['view']) {
 				$this->render($pa_options['view']);
 			} else {
				if ($this->getView()->viewExists($this->ops_tablename.'_'.$t_item->getTypeCode().'_detail_html.php')) {
					$this->render($this->ops_tablename.'_'.$t_item->getTypeCode().'_detail_html.php');
				} else {
					$this->render($this->ops_tablename.'_detail_html.php');
				}
			}
 		}
 		# -------------------------------------------------------
 		# Tagging and commenting
 		# -------------------------------------------------------
 		public function saveCommentRanking() {
 			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename)) {
 				die("Invalid table name ".$this->ops_tablename." for saving comment");
 			}

 			if(!($vn_item_id = $this->request->getParameter($t_item->primaryKey(), pInteger))){
  				$this->notification->addNotification(_t("Invalid ID"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			# --- get params from form
 			$ps_comment = $this->request->getParameter('comment', pString);
 			$pn_rank = $this->request->getParameter('rank', pInteger);
 			$ps_tags = $this->request->getParameter('tags', pString);
 			$ps_email = $this->request->getParameter('email', pString);
 			$ps_name = $this->request->getParameter('name', pString);
 			$ps_media1 = $_FILES['media1']['tmp_name'];
 			$ps_media1_original_name = $_FILES['media1']['name'];
 			
 			if($ps_comment || $pn_rank || $ps_tags || $ps_media1){
 				if(!(($pn_rank > 0) && ($pn_rank <= 5))){
 					$pn_rank = null;
 				}
 				if($ps_comment || $pn_rank || $ps_media1){
 					$t_item->addComment($ps_comment, $pn_rank, $this->request->getUserID(), null, $ps_name, $ps_email, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null, array('media1_original_filename' => $ps_media1_original_name), $ps_media1);
 				}
 				if($ps_tags){
 					$va_tags = array();
 					$va_tags = explode(",", $ps_tags);
 					foreach($va_tags as $vs_tag){
 						$t_item->addTag(trim($vs_tag), $this->request->getUserID(), null, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null);
 					}
 				}
 				if($ps_comment || $ps_tags || $ps_media1){
 					if($this->request->config->get("dont_moderate_comments")){
 						$this->notification->addNotification(_t("Thank you for contributing."), "message");
 					}else{
 						$this->notification->addNotification(_t("Thank you for contributing.  Your comments will be posted on this page after review by site staff."), "message");
 					}
 					# --- check if email notification should be sent to admin
 					if(!$this->request->config->get("dont_email_notification_for_new_comments")){
 						# --- send email confirmation
						# -- generate mail subject line
						ob_start();
						require($this->request->getViewsDirectoryPath()."/mailTemplates/admin_comment_notification_subject.tpl");
						$vs_subject_line = ob_get_contents();
						ob_end_clean();
						# -- generate mail text from template - get both html and text versions
						ob_start();
						require($this->request->getViewsDirectoryPath()."/mailTemplates/admin_comment_notification.tpl");
						$vs_mail_message_text = ob_get_contents();
						ob_end_clean();
						ob_start();
						require($this->request->getViewsDirectoryPath()."/mailTemplates/admin_comment_notification_html.tpl");
						$vs_mail_message_html = ob_get_contents();
						ob_end_clean();
						
						caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
 					}
 				}else{
 					$this->notification->addNotification(_t("Thank you for your contribution."), "message");
 				}
 			}
 			
 			$this->Show();
 		}
 		# -------------------------------------------------------
 		# Detail-based browsing
 		# -------------------------------------------------------
 		public function getFacet() {
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			if ($this->request->getParameter('clear', pInteger)) {
 				$this->opo_browse->removeAllCriteria();
 				$this->opo_browse->execute(array('checkAccess' => $va_access_values));
 				$this->request->session->setVar($this->ops_tablename.'_'.$this->ops_context.'_current_browse_id', $this->opo_browse->getBrowseID());
 			} else {
 				if ($this->request->getParameter('modify', pString)) {
 					$vm_id = $this->request->getParameter('id', pString);
 					$this->opo_browse->removeCriteria($ps_facet_name, array($vm_id));
 					$this->opo_browse->execute(array('checkAccess' => $va_access_values));
 					
 					$this->view->setVar('modify', $vm_id);
 				}
 			}
 			
 			$va_facet = $this->opo_browse->getFacet($ps_facet_name, array('sort' => 'name', 'checkAccess' => $va_access_values));
 			
 			$this->view->setVar('facet', $va_facet);
 			$this->view->setVar('facet_info', $va_facet_info = $this->opo_browse->getInfoForFacet($ps_facet_name));
 			$this->view->setVar('facet_name', $ps_facet_name);
 			
 			$this->view->setVar('browse_id', $pn_browse_id);
 			
 			$this->view->setVar('grouping', $this->request->getParameter('grouping', pString));
 			
 			// generate type menu and type value list for related authority table facet
 			if ($va_facet_info['type'] === 'authority') {
				$t_model = $this->opo_datamodel->getTableInstance($va_facet_info['table']);
				if (method_exists($t_model, "getTypeList")) {
					$this->view->setVar('type_list', $t_model->getTypeList());
				}
				
				$t_rel_types = new ca_relationship_types();
				$this->view->setVar('relationship_type_list', $t_rel_types->getRelationshipInfo($va_facet_info['relationship_table']));
			}
			
			$t_table = $this->opo_datamodel->getTableInstance($this->ops_tablename);
			$this->view->setVar('other_parameters', array($t_table->primaryKey() => $this->request->getParameter($t_table->primaryKey(), pInteger)));
 			$this->render('../Browse/ajax_browse_facet_html.php');
 		}
 		# -------------------------------------------------------
 		public function addCriteria() {
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->opo_browse->addCriteria($ps_facet_name, array($this->request->getParameter('id', pString)));
 			$this->Show();
 		}
 		# -------------------------------------------------------
 		public function modifyCriteria() {
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->opo_browse->removeCriteria($ps_facet_name, array($this->request->getParameter('mod_id', pString)));
 			$this->opo_browse->addCriteria($ps_facet_name, array($this->request->getParameter('id', pString)));
 			$this->Show();
 		}
 		# -------------------------------------------------------
 		public function removeCriteria() {
 			$ps_facet_name = $this->request->getParameter('facet', pString);
 			$this->opo_browse->removeCriteria($ps_facet_name, array($this->request->getParameter('id', pString)));
 			$this->Show();
 		}
 		# -------------------------------------------------------
 		public function clearCriteria() {
 			$this->opo_browse->removeAllCriteria();
 			$this->Show();
 		}	
 		# ------------------------------------------------------------------
		/**
		 * Export displayed item
		 */
		public function exportItem() {
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true)) {
 				die("Invalid table name ".$this->ops_tablename." for detail");		// shouldn't happen
 			}

 			if(!($vn_item_id = $this->request->getParameter($t_item->primaryKey(), pInteger))){
  				$this->notification->addNotification(_t("Invalid ID"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
			$ps_mapping = $this->request->getParameter('mapping', pString);
			
			// $t_mapping = new ca_bundle_mappings();
// 			if(!$t_mapping->load(array('mapping_code' => $ps_mapping))) {
// 				$this->notification->addNotification(_t("Mapping does not exist"), "message");
//  				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
//  				return;
// 			}
			if(!$t_mapping->get('access')) {
				$this->notification->addNotification(_t("Export format cannot be used"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
			}
			$vn_mapping_id = $t_mapping->getPrimaryKey();
			
			//$o_export = new DataExporter();
			//$this->view->setVar('export_mimetype', $o_export->exportMimetype($vn_mapping_id));
			//$this->view->setVar('export_data', $o_export->export($vn_mapping_id, $t_item, null, array('returnOutput' => true, 'returnAsString' => true)));
			//$this->view->setVar('export_filename', preg_replace('![\W]+!', '_', substr($t_item->getLabelForDisplay(), 0, 40).'_'.$o_export->exportTarget($vn_mapping_id)).'.'.$o_export->exportFileExtension($vn_mapping_id));
			
			$this->render('export_xml.php');
		}
 		# -------------------------------------------------------
		# Download Summary
		# -------------------------------------------------------
		/**
		 * Download Summary of displayed item
		 */
		public function downloadSummary() {
			if(!$t_item = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true)) {
 				die("Invalid table name ".$this->ops_tablename." for detail");		// shouldn't happen
 			}
			if(!($vn_item_id = $this->request->getParameter($t_item->primaryKey(), pInteger))){
  				$this->notification->addNotification(_t("Invalid ID"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
 			if(!$t_item->load($vn_item_id)){
  				$this->notification->addNotification(_t("ID does not exist"), "message");
 				$this->response->setRedirect(caNavUrl($this->request, "", "", "", ""));
 				return;
 			}
			
			$this->view->setVar('t_item', $t_item);
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$this->view->setVar('access_values', $va_access_values);
 			
 			$vs_output_filename = $t_item->getLabelForDisplay();
			$vs_output_filename = mb_substr($vs_output_filename, 0, 30);

			require_once(__CA_LIB_DIR__.'/core/Parsers/dompdf/dompdf_config.inc.php');
			$vs_output_file_name = mb_substr(preg_replace("/[^A-Za-z0-9\-]+/", '_', $vs_output_filename), 0, 40);
			header("Content-Disposition: attachment; filename=".$vs_output_file_name.".pdf");
			header("Content-type: application/pdf");
			$vs_content = $this->render('downloadTemplates/'.$this->ops_tablename.'_pdf_html.php');
			$o_pdf = new DOMPDF();
			// Page sizes: 'letter', 'legal', 'A4'
			// Orientation:  'portrait' or 'landscape'
			$o_pdf->set_paper("letter", "portrait");
			$o_pdf->load_html($vs_content, 'utf-8');
			$o_pdf->render();
			$o_pdf->stream($vs_output_file_name.".pdf");
			return;	
		}
		# -------------------------------------------------------
 		/**
 		  *
 		  */
 		protected function getBrowseInstance($pm_table_name_or_num, $pn_browse_id, $ps_context) {
 			$vs_table = $this->opo_datamodel->getTableName($pm_table_name_or_num);
 			
 			switch($vs_table) {
 				case 'ca_entities':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/EntityBrowse.php');
 					return new EntityBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_places':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/PlaceBrowse.php');
 					return new PlaceBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_occurrences':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/OccurrenceBrowse.php');
 					return new OccurrenceBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_collections':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/CollectionBrowse.php');
 					return new CollectionBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_object_lots':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/ObjectLotBrowse.php');
 					return new ObjectLotBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_loans':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/LoanBrowse.php');
 					return new LoanBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_movements':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/MovementBrowse.php');
 					return new MovementBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_storage_locations':
 					require_once(__CA_LIB_DIR__.'/ca/Browse/StorageLocationBrowse.php');
 					return new StorageLocationBrowse($pn_browse_id, $ps_context);
 					break;
 				case 'ca_objects':
 				default:
 					if (($vs_table == 'ca_objects') || (int)$pm_table_name_or_num) {
						require_once(__CA_LIB_DIR__.'/ca/Browse/ObjectBrowse.php');
						return new ObjectBrowse($pn_browse_id, $ps_context);
					}
 					break;
 			}
 			return null;
 		}
 		# -------------------------------------------------------
 		/**
 		  *
 		  */
 		protected function getBrowseSorts($pm_table_name_or_num) {
 			$va_sorts = null;
 			
 			switch($vs_table) {
 				case 'ca_entities':
 					$va_sorts = array(
						'ca_entity_labels.displayname' => _t('name'),
						'ca_entities.type_id' => _t('type'),
						'ca_entities.idno' => _t('idno')
					 );
 					break;
 				case 'ca_places':
 					$va_sorts = array(
						'ca_place_labels.name' => _t('name'),
						'ca_places.type_id' => _t('type'),
						'ca_places.idno' => _t('idno')
					 );
 					break;
 				case 'ca_occurrences':
 					$va_sorts = array(
						'ca_occurrence_labels.name' => _t('name'),
						'ca_occurrences.type_id' => _t('type'),
						'ca_occurrences.idno' => _t('idno')
					 );
 					break;
 				case 'ca_collections':
 					$va_sorts = array(
						'ca_collection_labels.name' => _t('name'),
						'ca_collections.type_id' => _t('type'),
						'ca_collections.idno' => _t('idno')
					 );
 					break;
 				case 'ca_object_lots':
 					$va_sorts = array(
						'ca_object_lot_labels.name' => _t('name'),
						'ca_object_lots.type_id' => _t('type'),
						'ca_object_lots.idno_stub' => _t('idno')
					 );
 					break;
 				case 'ca_loans':
 					$va_sorts = array(
						'ca_loan_labels.name' => _t('short description'),
						'ca_loans.type_id' => _t('type'),
						'ca_loans.idno' => _t('idno')
					 );
 					break;
 				case 'ca_movements':
 					$va_sorts = array(
						'ca_movement_labels.name' => _t('short description'),
						'ca_movements.type_id' => _t('type'),
						'ca_movements.idno' => _t('idno')
					 );
 					break;
 				case 'ca_storage_locations':
 					$va_sorts = array(
						'ca_storage_location_labels.name' => _t('name'),
						'ca_storage_locations.type_id' => _t('type')
					 );
 					break;
 				case 'ca_objects':
 				default:
 					if (($vs_table == 'ca_objects') || (int)$pm_table_name_or_num) {
						$va_sorts = array(
							'ca_object_labels.name' => _t('title'),
							'ca_objects.type_id' => _t('type'),
							'ca_objects.idno' => _t('idno')
						 );
					}
 					break;
 			}
 			
 			return $va_sorts;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function getRelationshipsAsJSON() {
 			$vs_table = $this->request->getParameter('table', pString);
 			$vs_id = $this->request->getParameter('id', pString);
 			$va_tmp = explode('_', $vs_id);
 			$vn_id = (int)array_pop($va_tmp);
 			
 			$vs_rel_table = $this->request->getParameter('rtable', pString);
 			$vn_rel_type_id = $this->request->getParameter('rtypeid', pInteger);
 			
 			$o_dm = Datamodel::load();
 			
 			$t_instance = $o_dm->getInstanceByTableName($vs_table, true);
 			$t_instance->load($vn_id);
 			
 			$va_data = array(
 				'id' => $vs_table.'-'.$vn_id,
 				'name' => $t_instance->get("{$vs_table}.preferred_labels"),
 				'children' => array(),
 				'data' => array(
 					'table' => $vs_table,
					'detail' => ucfirst($t_instance->getProperty('NAME_SINGULAR')),
					'key' => $t_instance->primaryKey(),
					'id' => $vn_id
 				)
 			);
 			
 			if($vs_rel_table) {
 				if ($t_rel_instance = $o_dm->getInstanceByTableName($vs_rel_table, true)) {
					$va_rel = $t_instance->getRelatedItems($vs_rel_table);
					
					$vn_c = 0;
					if (is_array($va_rel)) {
						foreach($va_rel as $vn_rel_id => $va_rel_info) {
							if ($vn_rel_type_id && ($va_rel_info['item_type_id'] != $vn_rel_type_id)) { continue; }
							$va_data['children'][] = array(
								'id' => $vs_rel_table.'-'.$va_rel_info[$t_rel_instance->primaryKey()].'-'.$vs_table.'-'.$vn_id,
								'name' => $va_rel_info['label'],
								'data' => array(
									'table' => $vs_rel_table,
									'detail' => ucfirst($t_rel_instance->getProperty('NAME_SINGULAR')),
									'key' => $t_rel_instance->primaryKey(),
									'id' => $va_rel_info[$t_rel_instance->primaryKey()]
								)
							);
							
							$vn_c++;
							
							if ($vn_c > 50) { break; }
						}
					}
				}
 			} else {
				foreach(array('ca_entities', 'ca_places', 'ca_occurrences', 'ca_collections') as $vs_rel_table) {
					//if ($vs_rel_table == $vs_table) { continue; }
					$t_rel_instance = $o_dm->getInstanceByTableName($vs_rel_table, true);
					$va_rel = $t_instance->getRelatedItems($vs_rel_table);
					
					$vn_c = 0;
					if (is_array($va_rel) && sizeof($va_rel)) {
						$va_type_ids = array();
						$va_type_list = $t_rel_instance->getTypeList();
						foreach($va_rel as $vn_rel_id => $va_rel_info) {
							$va_type_ids[$va_rel_info['item_type_id']] = true;
						}
						
						foreach(array_keys($va_type_ids) as $vn_type_id) {
							$va_data['children'][] = array(
								'id' => $vs_table.'-'.$vn_id.'-'.$vs_rel_table.'-'.$vn_type_id.'-rel',
								'name' => $vs_name = ucfirst($va_type_list[$vn_type_id]['name_plural']),
								'data' => array(
									'table' => $vs_rel_table,
									'detail' => $vs_name,
									'key' => $t_rel_instance->primaryKey(),
									'id' => $va_rel_info[$t_rel_instance->primaryKey()]
								)
							);
						}
					}
				}
			}
 			
 			$this->view->setVar('data', $va_data);
 			
 			$this->render('ajax_relationships_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetViz() {
 			$pn_id = $this->request->getParameter('id', pInteger);
 			$this->view->setVar('t_subject', $t_instance = $this->opo_datamodel->getInstanceByTableName($this->ops_tablename, true));
 			$t_instance->load($pn_id);
 			$this->render('ajax_visualization_html.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function GetRelatedObjectsAsJSON() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$pn_collection_id = $this->request->getParameter('collection_id', pInteger);
 			$pn_start = $this->request->getParameter('s', pInteger);
 			$pn_num_items = $this->request->getParameter('n', pInteger);
 			if ($pn_num_items < 1) { $pn_num_items = 1; }
 			
 			$vn_items_per_page = $this->request->config->get("objects_per_page_for_detail_pages");
 			$va_sort = array();
			if ($vs_sort = $this->request->config->get('sort_browse_within_detail_for_'.$this->ops_tablename)) {
				$va_sort = array('sort' => $vs_sort);
			}
			$qr_hits = $this->opo_browse->getResults($va_sort);
			$vn_num_pages = ceil($qr_hits->numHits()/$vn_items_per_page);
			$qr_hits->seek(($pn_start - 1) * $vn_items_per_page);
			$va_related_objects = array();
			$i = 0;
			while($qr_hits->nextHit() && $i < $vn_items_per_page){
				$va_related_objects[$qr_hits->get("object_id")] = array(
					"widethumbnail" => $qr_hits->getMediaTag('ca_object_representations.media', 'widethumbnail', array('checkAccess' => $va_access_values)),
					"small" => $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)),
					"object_id" => $qr_hits->get("object_id"),
					"label" => join($qr_hits->getDisplayLabels(), ", "),
					"idno" => $qr_hits->get("idno")
				);
				$i++;
			}
			$this->view->setVar('related_objects', $va_related_objects);
 			
 			$this->render('ajax_related_objects_json.php');
 		}
 		# -------------------------------------------------------
	}
?>