<?php
/* ----------------------------------------------------------------------
 * app/controllers/FavoritesController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');

 	class FavoritesController extends ActionController {
 		# -------------------------------------------------------
 		public function Index() {
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			$t_object = new ca_objects();
 			$t_user_favs = new ca_sets();
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }	
            
 			# --- user favs - highest ranked
 			$va_user_favs = array();
 			$va_user_favs_ids = $t_object->getHighestRated(true, 12, $va_access_values);
			if(is_array($va_user_favs_ids) && (sizeof($va_user_favs_ids) > 0)){
				foreach($va_user_favs_ids as $vn_uf_object_id){
					$t_object = new ca_objects($vn_uf_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_user_favs[$vn_uf_object_id] = $va_reps["tags"]["preview"];
				}
 			}else{
 				# --- get random objects
 				$this->view->setVar('user_favorites_is_random', 1);
 				$va_random_ids = $t_object->getRandomItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
				if(is_array($va_random_ids) && sizeof($va_random_ids) > 0){
					$va_random = array();
					foreach($va_random_ids as $va_item_info){
						$vn_rand_object_id = $va_item_info['object_id'];
						$t_object->load($vn_rand_object_id);
						$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
						$va_random[$vn_rand_object_id] = $va_reps["tags"]["preview"];
					}
					$va_user_favs = $va_random;
				}
 			}
			$this->view->setVar('user_favs', $va_user_favs);
 			
 			
 			# --- featured items set set_code defined in app.conf
 			$t_featured = new ca_sets();
 			$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
 			 # Enforce access control on set
 			if(sizeof($va_access_values) && !in_array($t_featured->get("access"), $va_access_values)){
  				$t_featured = new ca_sets();
 			}
 			$va_featured = array();
			if(is_array($va_row_ids = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values)))){
				$va_featured_ids = array_keys($va_row_ids);	// These are the object ids in the set
				foreach($va_featured_ids as $vn_f_object_id){
					$t_object = new ca_objects($vn_f_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_featured[$vn_f_object_id] = $va_reps["tags"]["preview"];
				}
 			}else{
 				# --- get random objects
 				$va_random_ids = $t_object->getRandomItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
				if(is_array($va_random_ids) && sizeof($va_random_ids) > 0){
					$va_random = array();
					foreach($va_random_ids as $va_item_info){
						$vn_rand_object_id = $va_item_info['object_id'];
						$t_object->load($vn_rand_object_id);
						$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
						$va_random[$vn_rand_object_id] = $va_reps["tags"]["preview"];
					}
					$va_featured = $va_random;
				}
 			}
 			$this->view->setVar('featured', $va_featured);
 			
 			# --- most viewed
 			$va_most_viewed_ids = $t_object->getMostViewedItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
 			if(is_array($va_most_viewed_ids) && sizeof($va_most_viewed_ids) > 0){
				$va_most_viewed = array();
				foreach($va_most_viewed_ids as $va_item_info){
					$vn_r_object_id = $va_item_info['object_id'];
					$t_object->load($vn_r_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_most_viewed[$vn_r_object_id] = $va_reps["tags"]["preview"];
				}
			}
 			$this->view->setVar('most_viewed', $va_most_viewed);

			# --- recently added
			$va_recently_added_ids = $t_object->getRecentlyAddedItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
 			if(is_array($va_recently_added_ids) && sizeof($va_recently_added_ids) > 0){
				$va_recently_added = array();
				foreach($va_recently_added_ids as $va_item_info){
					$vn_r_object_id = $va_item_info['object_id'];
					$t_object->load($vn_r_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_recently_added[$vn_r_object_id] = $va_reps["tags"]["preview"];
				}
			}
 			$this->view->setVar('recently_added', $va_recently_added);

 			$this->render('Favorites/favorites_landing_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>