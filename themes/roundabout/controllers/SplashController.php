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
 		function Index() {
 			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
			
 			parent::Index(true);
 			JavascriptLoadManager::register('imageScroller');
 			JavascriptLoadManager::register('browsable');
 			JavascriptLoadManager::register('tabUI');
 			
 			$t_object = new ca_objects();
 			$t_featured = new ca_sets();
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			
			# --- featured items set - set name assigned in app.conf 
			$featured_sets = $this->request->config->get('featured_sets');
			$len = count($featured_sets);
			if($len > 3) { $len = 3; }
			for($i = 0; $i < $len; $i++) {
				$t_featured->load(array('set_code' => $featured_sets[$i]));
				$set_id = $t_featured->getPrimaryKey();
				$set_title = $t_featured->getLabelForDisplay();
				$set_desc = $t_featured->getAttributeFromSets('description', Array(0 => $set_id ) );
				$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());	// These are the object ids in the set
				if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
	 				$t_object = new ca_objects($va_featured_ids[0]);
	 				$va_rep = $t_object->getPrimaryRepresentation(array('thumbnail', 'small', 'medium', 'mediumlarge', 'preview', 'widepreview'), null, array('return_with_access' => $va_access_values));
					$featured_set_id_array[$i] = array(
						'featured_set_code' => $featured_sets[$i],
						'featured_content_id' => $va_featured_ids[0],
						'featured_content_small' => $va_rep["tags"]["small"],
						'featured_content_label' => $set_title,
						'featured_content_description' => $set_desc[$set_id][0],
						'featured_set_id' => $set_id
					);
				}
			}
			$this->view->setVar('featured_set_id_array', $featured_set_id_array);
			
			 			
 			# --- user favorites get the highest ranked objects to display
			$va_user_favorites_items = $t_object->getHighestRated(true, 12, $va_access_values);
			if(sizeof($va_user_favorites_items) > 0){
				if(is_array($va_user_favorites_items) && (sizeof($va_user_favorites_items) > 0)){
					$t_object = new ca_objects($va_user_favorites_items[0]);
 					$va_rep = $t_object->getPrimaryRepresentation(array('thumbnail', 'small', 'preview', 'widepreview'), null, array('return_with_access' => $va_access_values));
					$this->view->setVar('user_favorites_id', $va_user_favorites_items[0]);
					$this->view->setVar('user_favorites_thumb', $va_rep["tags"]["thumbnail"]);
					$this->view->setVar('user_favorites_small', $va_rep["tags"]["small"]);
					$this->view->setVar('user_favorites_preview', $va_rep["tags"]["preview"]);
					$this->view->setVar('user_favorites_widepreview', $va_rep["tags"]["widepreview"]);
				}
			}else{
				$this->view->setVar('user_favorites_is_random', 1);
				# if no ranks set, choose a random object
				$va_random_items = $t_object->getRandomItems(1, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
				$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_random_items));
				$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_random_items), array('small', 'thumbnail', 'preview','medium', 'widepreview'), array("checkAccess" => $va_access_values));

				foreach($va_random_items as $vn_object_id => $va_object_info) {
					$va_object_info['title'] = $va_labels[$vn_object_id];
					$va_object_info['media'] = $va_media[$vn_object_id];
					$va_random_items[$vn_object_id] = $va_object_info;
				}
				$this->view->setVar('random_objects', $va_random_items);
				if(is_array($va_random_items) && (sizeof($va_random_items) > 0)){
					$va_object_info = array_shift($va_random_items);
					$this->view->setVar('user_favorites_id', $va_object_info['object_id']);
					$this->view->setVar('user_favorites_thumb', $va_media[$va_object_info['object_id']]["tags"]["thumbnail"]);
					$this->view->setVar('user_favorites_small', $va_media[$va_object_info['object_id']]["tags"]["small"]);
					$this->view->setVar('user_favorites_preview', $va_media[$va_object_info['object_id']]["tags"]["preview"]);
					$this->view->setVar('user_favorites_widepreview', $va_media[$va_object_info['object_id']]["tags"]["widepreview"]);
					$this->view->setVar('user_favorites_medium', $va_media[$va_object_info['object_id']]["tags"]["medium"]);
				} 	
			}
			
			
			#---- new 'recently added' 
			$t_set = new ca_sets();
			$ra_set_code = $this->request->config->get('recently_added_set_id');
			$t_set->load(array('set_code' => $ra_set_code));
			$set_id = $t_set->getPrimaryKey();
			$ra_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('thumbnail', 'preview'), "checkAccess" => 1)));
			$va_recently_added = array();
			foreach($ra_items as $va_item_info){
				$vn_r_object_id = $va_item_info['object_id'];
				$t_object->load($vn_r_object_id);
				$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
				$va_recently_added[$vn_r_object_id] = $va_reps["tags"]["preview"];
			}
			
 			# --- get the 12 most recently added objects to display
			/*$va_recently_added_ids = $t_object->getRecentlyAddedItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
 			if(is_array($va_recently_added_ids) && sizeof($va_recently_added_ids) > 0){
				$va_recently_added = array();
				foreach($va_recently_added_ids as $va_item_info){
					$vn_r_object_id = $va_item_info['object_id'];
					$t_object->load($vn_r_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_recently_added[$vn_r_object_id] = $va_reps["tags"]["preview"];
				}
			}*/
 			$this->view->setVar('recently_added', $va_recently_added);
			
 			$this->render('Splash/splash_html.php');
 		}
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('browse') : _t('browses');
 		}
 		# ------------------------------------------------------
 	}
 ?>
