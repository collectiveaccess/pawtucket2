<?php
/* ----------------------------------------------------------------------
 * controllers/FrontController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2016 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__."/ApplicationError.php");
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');

class FrontController extends BasePawtucketController {
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct($request, $response, $view_paths=null) {
		$this->view_class = 'AdvancedSearchView';
		parent::__construct($request, $response, $view_paths);
		
		$this->config = caGetFrontConfig();
		caSetPageCSSClasses(['front']);
		
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function __call($function, $args) {
		$access_values = caGetUserAccessValues($this->request);
		$this->view->setVar('access_values', $access_values);

		// If there is a set configured to show on the front page, load it now
		$t_set = null;
		$featured_ids = [];
		if($set_code = $this->config->get("set_code")){
			$t_set = new ca_sets();
			$t_set->load(['set_code' => $set_code]);
			$shuffle = (bool)$this->config->get("set_random");
			
			// Enforce access control on set
			if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
				$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => $shuffle])) ? $tmp : []);
			}
		}
		// No configured set/items in set so grab random objects with media
		if(sizeof($featured_ids) == 0){
			$t_object = new ca_objects();
			if($intrinsic_values = $this->config->get("intrinsic_filter")){
				foreach($intrinsic_values as $instrinsic_field => $intrinsic_value){
					$intrinsic_restrictions[$instrinsic_field] = $intrinsic_value;
				}
			}
			$featured_ids = array_keys($t_object->getRandomItems(200, ['checkAccess' => $access_values, 'hasRepresentations' => 1, 'restrictByIntrinsic' => $intrinsic_restrictions]));
			shuffle($featured_ids);
			$featured_ids = array_slice($featured_ids, 0, 10);
		}
		
		$o_result_context = new ResultContext($this->request, 'ca_objects', 'front');
		$o_result_context->setAsLastFind();
		
		//
		// Try to load selected page if it exists in Front/, otherwise load default Front/front_page_html.php
		//
		$function = preg_replace("![^A-Za-z0-9_\-]+!", "", $function);
		$path = "Front/{$function}_html.php";
		if (!file_exists(__CA_THEME_DIR__."/views/{$path}")) {
			$path = "Front/front_page_html.php";
		}
		
		$this->view->setVar('config', $this->config);
		$this->view->setVar('featured_set', $t_set);
		$this->view->setVar('featured_set_id', $t_set ? $t_set->get("set_id") : null);
		$this->view->setVar('featured_set_item_ids', $featured_ids);
		$this->view->setVar('featured_set_items_as_search_result', sizeof($featured_ids) ? caMakeSearchResult('ca_objects', $featured_ids) : null);
		$this->view->setVar('result_context', $o_result_context);
		
		$this->render($path);
	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($request) {
		$ret = [
			'module_path' => '',
			'controller' => 'Front',
			'action' => 'Index',
			'params' => []
		];
		return $ret;
	}
	# ------------------------------------------------------
}
