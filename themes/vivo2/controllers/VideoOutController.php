<?php
/* ----------------------------------------------------------------------
 * app/controllers/ActivationsController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 	require_once(__CA_MODELS_DIR__."/ca_sets.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	require_once(__CA_MODELS_DIR__."/ca_object_representations.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class VideoOutController extends BasePawtucketController {
 		# -------------------------------------------------------
  		/**
 		 *
 		 */ 
 		public function __construct(&$request, &$response, $view_paths=null) {
 			parent::__construct($request, $response, $view_paths);
 			
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
 			$this->view->setVar("section_item_name", $section_item_name);
 			caSetPageCSSClasses(array("videoout"));
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Video Out"));
 			
 			AssetLoadManager::register("panel");
 			AssetLoadManager::register("mediaViewer");
 			AssetLoadManager::register("readmore");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Index($pa_options = null) {
 			$va_access_values = caGetUserAccessValues($this->request);
 			$this->view->setVar('access_values', $va_access_values);

 			#
 			# --- if there is a set configured to show on the front page, load it now
 			#
 			$va_featured_ids = array();
 			if($vs_set_code = $this->request->config->get("video_out_set_code")){
 				$t_set = new ca_sets();
 				$t_set->load(array('set_code' => $vs_set_code));
 				$vn_shuffle = 1;
 				# Enforce access control on set
				if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
					$this->view->setVar('featured_set_id', $t_set->get("set_id"));
					$this->view->setVar('featured_set', $t_set);
					$this->view->setVar('featured_set_name', $t_set->get("ca_sets.preferred_labels"));
					$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
					$this->view->setVar('featured_set_item_ids', $va_featured_ids);
					$this->view->setVar('featured_set_items_as_search_result', caMakeSearchResult('ca_objects', $va_featured_ids));
				}
 			}
 			
 			$this->render("VideoOut/index_html.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */ 
 		public function Artists($pa_options = null) {
 			$o_browse = caGetBrowseInstance("ca_objects");
 			$o_browse->setTypeRestrictions(array("analogue_vid"), array('dontExpandHierarchically' => true));
 			$o_browse->addCriteria("collection_facet", "80");
 			$va_artists = $o_browse->getFacet("artist_facet");
 			$this->request->view->setVar("artists", $va_artists);
 			
 			$this->render("VideoOut/artists_html.php");
 		}
 		# -------------------------------------------------------
		/** 
		 * Generate the URL for the "back to results" link
		 * as an array of path components.
		 */
 		public static function getReturnToResultsUrl($request) {
 			$va_ret = array(
 				'module_path' => '',
 				'controller' => 'VideoOut',
 				'action' => 'Index',
 				'params' => []
 			);
			return $va_ret;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _getSet($set_id) {
 			$t_set = new ca_sets();
 			if (!$t_set->load($set_id) || (sizeof($this->opa_access_values) && !in_array((int)$t_set->get('access'), $this->opa_access_values, true))) { throw new ApplicationException(_t('Invalid set')); }
 			return $t_set;
 		}
 		# -------------------------------------------------------
	}
