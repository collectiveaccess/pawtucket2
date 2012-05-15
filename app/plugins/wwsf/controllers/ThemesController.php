<?php
/* ----------------------------------------------------------------------
 * includes/ThemesController.php
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
 	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
 	require_once(__CA_MODELS_DIR__.'/ca_set_items.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 
 	class ThemesController extends ActionController {
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			JavascriptLoadManager::register('panel');
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/wwsf/conf/wwsf.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('wwsf plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/wwsf/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			$this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'themes');
			$this->opo_result_context->setAsLastFind();
			$this->opo_result_context->saveContext();
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			$va_access_values = caGetUserAccessValues($this->request);
 			// get sets for public display
 			$t_list = new ca_lists();
 			$vn_set_type_theme = $t_list->getItemIDFromList('set_types', 'theme');
 			
 			$t_set = new ca_sets();
 			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array("table" => "ca_objects", "checkAccess" => $va_access_values, "setType" => $vn_set_type_theme)));
 			
 			$this->view->setVar('page', $pn_page = $this->opo_result_context->getCurrentResultsPageNumber());
 			
 			# page nav vars
 			$vn_items_per_page = 9;
 			$this->view->setVar('numPages', $vn_num_pages = ceil(sizeof($va_sets)/$vn_items_per_page));
			if (($pn_page > $vn_num_pages) || ($pn_page < 1)) { $pn_page = 1; }
			$this->view->setVar('itemsPerPage', $vn_items_per_page);
 			$this->view->setVar("numResults", sizeof($va_sets));
 			
 			$va_sets = array_slice($va_sets, ($vn_items_per_page * ($pn_page - 1)), $vn_items_per_page, TRUE);
 			$this->view->setVar('sets', $va_sets);
 			$va_set_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "preview160", "checkAccess" => $va_access_values));
			$this->view->setVar('first_items_from_sets', $va_set_first_items);
 			
 			$this->render('themes_landing_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>