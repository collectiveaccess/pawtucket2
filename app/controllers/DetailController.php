<?php
/* ----------------------------------------------------------------------
 * app/controllers/SearchController.php : controller for object search request handling - processes searches from top search bar
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__."/ca/BaseSearchController.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_LIB_DIR__."/ca/MediaContentLocationIndexer.php");
 	
 	class DetailController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		protected $opa_detail_types = null;
 		
 		/**
 		 *
 		 */
 		protected $config = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->config = Configuration::load(__CA_THEME_DIR__.'/conf/detail.conf');
 			$this->opa_detail_types = $this->config->getAssoc('detailTypes');
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			
 			$ps_function = strtolower($ps_function);
 			$ps_id = $this->request->getActionExtra(); //$this->request->getParameter('id', pString);
 			if (!isset($this->opa_detail_types[$ps_function]) || !isset($this->opa_detail_types[$ps_function]['table']) || (!($vs_table = $this->opa_detail_types[$ps_function]['table']))) {
 				// invalid detail type – throw error
 				die("Invalid detail type");
 			}
 			
 			$o_dm = Datamodel::load();
 			
 			$t_table = $o_dm->getInstanceByTableName($vs_table, true);
 			if (!$t_table->load(caUseIdentifiersInUrls() ? array('idno' => $ps_id) : (int)$ps_id)) {
 				// invalid id - throw error
 			}
 			
 			$vs_type = $t_table->getTypeCode();
 			
 			$this->view->setVar('detailType', $vs_table);
 			$this->view->setVar('item', $t_table);
 			$this->view->setVar('itemType', $vs_type);
 			
 			
 			//
 			//
 			//
 			$vs_last_find = ResultContext::getLastFind($this->request, $vs_table);
 			$o_context = new ResultContext($this->request, $vs_table, $vs_last_find);
 			$this->view->setVar('previousID', $vn_previous_id = $o_context->getPreviousID($t_table->getPrimaryKey()));
 			$this->view->setVar('nextID', $vn_next_id = $o_context->getNextID($t_table->getPrimaryKey()));
 			$this->view->setVar('previousURL', caNavUrl($this->request, '*', '*', '*').'/'.$vn_previous_id);
 			$this->view->setVar('nextURL', caNavUrl($this->request, '*', '*', '*').'/'.$vn_next_id);
 			$this->view->setVar('resultsURL', ResultContext::getResultsUrlForLastFind($this->request, $vs_table));
 			
 			$va_options = (isset($this->opa_detail_types[$ps_function]['options']) && is_array($this->opa_detail_types[$ps_function]['options'])) ? $this->opa_detail_types[$ps_function]['options'] : array();
 			
 			$this->view->setVar('previousLink', ($vn_previous_id > 0) ? caNavLink($this->request, caGetOption('previousLink', $va_options, _t('Previous')), '', '*', '*', '*', array($vn_previous_id)) : "");
 			$this->view->setVar('nextLink', ($vn_next_id > 0) ? caNavLink($this->request, caGetOption('nextLink', $va_options, _t('Next')), '', '*', '*', '*', array($vn_next_id)) : "");
 			$this->view->setVar('resultsLink', ResultContext::getResultsLinkForLastFind($this->request, $vs_table, caGetOption('resultsLink', $va_options, _t('Back'))));
 			
 			//
 			//
 			//
 			if ($t_representation = $t_table->getPrimaryRepresentationInstance()) {
 				$this->view->setVar("representationViewer", caObjectDetailMedia($this->request, $t_table->getPrimaryKey(), $t_representation, array()));
 			}
 			
 			// find view
 			//		first look for type-specific view
 			if (!$this->viewExists($vs_path = "Details/{$vs_table}_{$vs_type}_html.php")) {
 				// If no type specific view use the default
 				$vs_path = "Details/{$vs_table}_default_html.php";
 			}
 			
 			//
 			// Tag substitution
 			//
 			// Views can contain tags in the form {{{tagname}}}. Some tags, such as "itemType" and "detailType" are defined by
 			// the detail controller. More usefully, you can pull data from the item being detailed by using a valid "get" expression
 			// as a tag (Eg. {{{ca_objects.idno}}}. Even more usefully for some, you can also use a valid bundle display template
 			// (see http://docs.collectiveaccess.org/wiki/Bundle_Display_Templates) as a tag. The template will be evaluated in the 
 			// context of the item being detailed.
 			//
 			$va_defined_vars = array_keys($this->view->getAllVars());		// get list defined vars (we don't want to copy over them)
 			$va_tag_list = $this->getTagListForView($vs_path);				// get list of tags in view
 			foreach($va_tag_list as $vs_tag) {
 				if (in_array($vs_tag, $va_defined_vars)) { continue; }
 				if ((strpos($vs_tag, "^") !== false) || (strpos($vs_tag, "<") !== false)) {
 					$this->view->setVar($vs_tag, $t_table->getWithTemplate($vs_tag));
 				} elseif (strpos($vs_tag, ".") !== false) {
 					$this->view->setVar($vs_tag, $t_table->get($vs_tag));
 				} else {
 					$this->view->setVar($vs_tag, "?{$vs_tag}");
 				}
 			}
 			
 			$this->render($vs_path);
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
 		 *		order_item_id = ca_commerce_order_items.item_id value to limit representation display to
 		 *
 		 */ 
 		public function GetRepresentationInfo() {
 			$vn_object_id 			= $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id 	= $this->request->getParameter('representation_id', pInteger);
 			if (!$ps_display_type 	= trim($this->request->getParameter('display_type', pString))) { $ps_display_type = 'media_overlay'; }
 			if (!$ps_containerID 	= trim($this->request->getParameter('containerID', pString))) { $ps_containerID = 'caMediaPanelContentArea'; }
 			
 			if(!$vn_object_id) { $vn_object_id = 0; }
 			$t_rep = new ca_object_representations($pn_representation_id);
 			
 			$va_opts = array('display' => $ps_display_type, 'object_id' => $vn_object_id, 'containerID' => $ps_containerID, 'access' => caGetUserAccessValues($this->request));
 			if (strlen($vs_use_book_viewer = $this->request->getParameter('use_book_viewer', pInteger))) { $va_opts['use_book_viewer'] = (bool)$vs_use_book_viewer; }

 			$this->response->addContent($t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts));
 		}
		# -------------------------------------------------------
 		/**
 		 * 
 		 */ 
 		public function GetPageListAsJSON() {
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$ps_content_mode = $this->request->getParameter('content_mode', pString);
 			
 			$this->view->setVar('object_id', $pn_object_id);
 			$this->view->setVar('representation_id', $pn_representation_id);
 			$this->view->setVar('content_mode', $ps_content_mode);
 			
 			$t_rep = new ca_object_representations($pn_representation_id);
 			$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			$vs_download_version = $va_download_display_info['display_version'];
 			$this->view->setVar('download_version', $vs_download_version);
 			
 			$va_page_list_cache = $this->request->session->getVar('caDocumentViewerPageListCache');
 			
 			$va_pages = $va_page_list_cache[$pn_object_id.'/'.$pn_representation_id];
 			if (!isset($va_pages)) {
 				// Page cache not set?
 				$this->postError(1100, _t('Invalid object/representation'), 'ObjectEditorController->GetPage');
 				return;
 			}
 			
 			$va_section_cache = $this->request->session->getVar('caDocumentViewerSectionCache');
 			$this->view->setVar('pages', $va_pages);
 			$this->view->setVar('sections', $va_section_cache[$pn_object_id.'/'.$pn_representation_id]);
 			
 			$this->view->setVar('is_searchable', MediaContentLocationIndexer::hasIndexing('ca_object_representations', $pn_representation_id));
 			
 			$this->render('Details/object_representation_page_list_json.php');
 		}
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */ 
 		public function SearchWithinMedia() {
 			$pn_representation_id = $this->request->getParameter('representation_id', pInteger);
 			$ps_q = $this->request->getParameter('q', pString);
 			
 			$va_results = MediaContentLocationIndexer::SearchWithinMedia($ps_q, 'ca_object_representations', $pn_representation_id, 'media');
 			$this->view->setVar('results', $va_results);
 			
 			$this->render('Details/object_representation_within_media_search_results_json.php');
		}
 		# -------------------------------------------------------
	}
 ?>