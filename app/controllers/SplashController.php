<?php
/* ----------------------------------------------------------------------
 * controllers/SplashController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 
 	require_once(__CA_LIB_DIR__."/ca/BaseBrowseController.php");
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 
 	class SplashController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = 'ca_objects';
 		 
 		/** 
 		 * Number of items per results page
 		 */
 		protected $opa_items_per_page = array(18, 24, 48);
 		#protected $opa_items_per_page = array(18);
 		 
 		/**
 		 * List of result views supported for this browse
 		 * Is associative array: keys are view labels, values are view specifier to be incorporated into view name
 		 */ 
 		protected $opa_views;
 		 
 		 
 		/**
 		 * List of available result sorting fields
 		 * Is associative array: values are display names for fields, keys are full fields names (table.field) to be used as sort
 		 */
 		protected $opa_sorts;
 		
 		
 		protected $ops_find_type = 'basic_browse';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }
            
			$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
			
			$this->opa_views = array(
				'full' => _t('List'),
				'thumbnail' => _t('Thumbnails')
			 );
			 
			$this->opa_sorts = array(
				'ca_object_labels.name' => _t('title'),
				'ca_objects.type_id' => _t('type'),
				'ca_objects.idno' => _t('idno')
			);
			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
				
			$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 		}
 		# -------------------------------------------------------
 		function Index($pa_options=null) {
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
 			parent::Index(array('dontRenderView' => true));
 			JavascriptLoadManager::register('imageScroller');
 			JavascriptLoadManager::register('browsable');
 			JavascriptLoadManager::register('tabUI');
 			JavascriptLoadManager::register('cycle');
 			
 			$t_object = new ca_objects();
 			$t_featured = new ca_sets();
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			
 			$va_default_versions = array('thumbnail', 'icon', 'small', 'preview', 'medium', 'preview', 'widepreview');
 				
 			# --- featured items set - set name assigned in app.conf
			$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
			 # Enforce access control on set
 			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
  				$this->view->setVar('featured_set_id', $t_featured->get("set_id"));
 				$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the object ids in the set
 			}
 			if(!is_array($va_featured_ids) || (sizeof($va_featured_ids) == 0)){
				# put a random object in the features variable
 				$va_featured_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1)));
			}
			
			$t_object = new ca_objects($va_featured_ids[0]);
			$va_rep = $t_object->getPrimaryRepresentation(array('thumbnail', 'small', 'medium', 'mediumlarge', 'preview', 'widepreview'), null, array('return_with_access' => $va_access_values));
			$this->view->setVar('featured_content_id', $va_featured_ids[0]);
			$this->view->setVar('featured_content_thumb', $va_rep["tags"]["thumbnail"]);
			$this->view->setVar('featured_content_small', $va_rep["tags"]["small"]);
			$this->view->setVar('featured_content_mediumlarge', $va_rep["tags"]["mediumlarge"]);
			$this->view->setVar('featured_content_medium', $va_rep["tags"]["medium"]);
			$this->view->setVar('featured_content_preview', $va_rep["tags"]["preview"]);
			$this->view->setVar('featured_content_widepreview', $va_rep["tags"]["widepreview"]);
			$this->view->setVar('featured_content_label', $t_object->getLabelForDisplay());
			
			$this->view->setVar('featured_content_slideshow_id_list', $va_featured_ids);
			
			
if(!(bool)$this->request->config->get("splash_disable_highest_rated_objects")){
			if(!is_array($va_versions = $this->request->config->getList("splash_highest_rated_display_versions"))){ $va_versions = $va_default_versions; }

 			# --- user favorites get the highest ranked objects to display
			$va_user_favorites_items = $t_object->getHighestRated(true, 12, $va_access_values);
			if(sizeof($va_user_favorites_items) > 0){
				if(is_array($va_user_favorites_items) && (sizeof($va_user_favorites_items) > 0)){
					$t_object = new ca_objects($va_user_favorites_items[0]);
 					$va_rep = $t_object->getPrimaryRepresentation($va_versions, null, array('return_with_access' => $va_access_values));
					$this->view->setVar('user_favorites_id', $va_user_favorites_items[0]);
					
					foreach($va_versions as $vs_version) {
						$this->view->setVar('user_favorites_'.$vs_version, $va_rep['tags'][$vs_version]);
					}
				}
			}else{
				$this->view->setVar('user_favorites_is_random', 1);
				# if no ranks set, choose a random object
				$va_random_items = $t_object->getRandomItems(1, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
				$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_random_items));
				$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_random_items), $va_versions, array("checkAccess" => $va_access_values));

				foreach($va_random_items as $vn_object_id => $va_object_info) {
					$va_object_info['title'] = $va_labels[$vn_object_id];
					$va_object_info['media'] = $va_media[$vn_object_id];
					$va_random_items[$vn_object_id] = $va_object_info;
				}
				$this->view->setVar('random_objects', $va_random_items);
				if(is_array($va_random_items) && (sizeof($va_random_items) > 0)){
					$va_object_info = array_shift($va_random_items);
					$this->view->setVar('user_favorites_id', $va_object_info['object_id']);
					
					foreach($va_versions as $vs_version) {
						$this->view->setVar('user_favorites_'.$vs_version, $va_media[$va_object_info['object_id']]['tags'][$vs_version]);
					}
				} 	
			}
}

if(!(bool)$this->request->config->get("splash_disable_recently_added_objects")){
			if(!is_array($va_versions = $this->request->config->getList("splash_recently_added_display_versions"))){ $va_versions = $va_default_versions; }
				
 			# --- get the 12 most recently added objects to display
			$va_recently_added_items = $t_object->getRecentlyAddedItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));	
 			$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_recently_added_items));
 			$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_recently_added_items), $va_versions, array("checkAccess" => $va_access_values));
			
			foreach($va_recently_added_items as $vn_object_id => $va_object_info){
				$va_object_info['title'] = $va_labels[$vn_object_id];
				$va_object_info['media'] = $va_media[$vn_object_id];
 				$va_recently_added_objects[$vn_object_id] = $va_object_info;
 				
				foreach($va_versions as $vs_version) {
					$this->view->setVar('recently_added_'.$vs_version, $va_media[$va_object_info['object_id']]['tags'][$vs_version]);
				}
			}
			$this->view->setVar('recently_added_objects', $va_recently_added_objects);
			if(is_array($va_recently_added_objects) && (sizeof($va_recently_added_objects) > 0)){
				$va_object_info = array_shift($va_recently_added_objects); 
				$this->view->setVar('recently_added_id', $va_object_info['object_id']);
				
			} 	
} else {
			$this->view->setVar('recently_added_objects', array());
}		
			# --- get the 12 most viewed objects
if(!(bool)$this->request->config->get("splash_disable_most_viewed_objects")){
			if(!is_array($va_versions = $this->request->config->getList("splash_most_viewed_display_versions"))){ $va_versions = $va_default_versions; }
			
			$va_most_viewed_objects = $t_object->getMostViewedItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
 			$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_most_viewed_objects));
 			$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_most_viewed_objects), $va_versions, array("checkAccess" => $va_access_values));
			foreach($va_most_viewed_objects as $vn_object_id => $va_object_info){
				$va_object_info['title'] = $va_labels[$vn_object_id];
				$va_object_info['media'] = $va_media[$vn_object_id];
 				$va_most_viewed_objects[$vn_object_id] = $va_object_info;
			}
			$this->view->setVar('most_viewed_objects', $va_most_viewed_objects);
			if(is_array($va_most_viewed_objects) && (sizeof($va_most_viewed_objects) > 0)){
				$va_object_info = array_shift($va_most_viewed_objects);
				$this->view->setVar('most_viewed_id', $va_object_info['object_id']);
				
				foreach($va_versions as $vs_version) {
					$this->view->setVar('most_viewed_'.$vs_version, $va_media[$va_object_info['object_id']]['tags'][$vs_version]);
				}
			} 
}

if(!(bool)$this->request->config->get("splash_disable_recently_viewed_objects")){
			if(!is_array($va_versions = $this->request->config->getList("splash_recently_viewed_display_versions"))){ $va_versions = $va_default_versions; }
				
			# --- get the 12 recently viewed objects
			$va_recently_viewed_objects = $t_object->getRecentlyViewedItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
 			$va_labels = $t_object->getPreferredDisplayLabelsForIDs($va_recently_viewed_objects);
 			$va_media = $t_object->getPrimaryMediaForIDs($va_recently_viewed_objects, $va_versions, array("checkAccess" => $va_access_values));
			$va_recently_viewed_objects_for_display = array();
			foreach($va_recently_viewed_objects as $vn_object_id){
				$va_recently_viewed_objects_for_display[$vn_object_id] = array(
					'object_id' => $vn_object_id,
					'title' => $va_labels[$vn_object_id],
					'media' => $va_media[$vn_object_id]
				);
			}

			$this->view->setVar('recently_viewed_objects', $va_recently_viewed_objects_for_display);
			if(is_array($va_recently_viewed_objects) && (sizeof($va_recently_viewed_objects) > 0)){
				$va_object_info = array_shift($va_recently_viewed_objects_for_display);
				$this->view->setVar('recently_viewed_id', $va_object_info['object_id']);
				
				foreach($va_versions as $vs_version) {
					$this->view->setVar('recently_viewed_'.$vs_version, $va_media[$va_object_info['object_id']]['tags'][$vs_version]);
				}
			} 
} else {
			$this->view->setVar('recently_viewed_objects', array());
}

if(!(bool)$this->request->config->get("splash_disable_random_objects")){	
			if(!is_array($va_versions = $this->request->config->getList("splash_random_display_versions"))){ $va_versions = $va_default_versions; }
					
			# --- get random objects
			$va_random_items = $t_object->getRandomItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
			$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_random_items));
			$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_random_items), $va_versions, array("checkAccess" => $va_access_values));
	
			foreach($va_random_items as $vn_object_id => $va_object_info) {
				$va_object_info['title'] = $va_labels[$vn_object_id];
				$va_object_info['media'] = $va_media[$vn_object_id];
				$va_random_items[$vn_object_id] = $va_object_info;
			}
			$this->view->setVar('random_objects', $va_random_items);
			if(is_array($va_random_items) && (sizeof($va_random_items) > 0)){
				$va_object_info = array_shift($va_random_items);
				$this->view->setVar('random_object_id', $va_object_info['object_id']);
				
				foreach($va_versions as $vs_version) {
					$this->view->setVar('random_object_'.$vs_version, $va_media[$va_object_info['object_id']]['tags'][$vs_version]);
				}
			} 	
} else {
			$this->view->setVar('random_objects', array());
}
 			$this->render('Splash/splash_html.php');
 		}
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('browse') : _t('browses');
 		}
 		# ------------------------------------------------------
 	}
 ?>