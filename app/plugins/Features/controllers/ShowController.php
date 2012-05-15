<?php
/* ----------------------------------------------------------------------
 * includes/ShowController.php
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 
 	class ShowController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			JavascriptLoadManager::register("panel");
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			JavascriptLoadManager::register('imageScroller');
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			// get sets for public display
 			$t_list = new ca_lists();
 			$vn_public_set_type_id = $t_list->getItemIDFromList('set_types', $t_list->getAppConfig()->get('features_set_type'));
 			
 			// get value for public access status value
 			$va_tmp = $t_list->getItemFromList('access_statuses', 'public_access');
 			$vn_public_access = $va_tmp['item_value'];
 			
 			$t_set = new ca_sets();
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_public_set_type_id)));
 		
 			$va_set_ids = array();
 			foreach($va_sets as $va_set) {
 				$va_set_ids[] = $va_set['set_id'];
 			}
 		
 			$this->view->setVar('sets', $va_sets);
 			$this->view->setVar('set_ids', $va_set_ids);
 			
 			$this->view->setVar('set_display_items', ca_sets::getFirstItemsFromSets($va_set_ids, array("version" => "preview160")));
 			
 			
 			$this->render('features_landing_html.php');
 		}
 		# -------------------------------------------------------
 		public function displaySet() {
 			$pn_set_id = $this->request->getParameter('set_id', pInteger);
 			$t_set = new ca_sets($pn_set_id);
 			
 			$t_list = new ca_lists();
 			
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$this->view->setVar('t_set', $t_set);
 			$this->view->setVar('set_presentation_types', caExtractValuesByUserLocale($t_list->getItemsForList('set_presentation_types')));
 			
 			$this->view->setVar('access_values', $va_access_values);
 			
 			$this->render('features_contents_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>
