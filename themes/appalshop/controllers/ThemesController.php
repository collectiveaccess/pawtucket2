<?php
/* ----------------------------------------------------------------------
 * app/controllers/ThemesController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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
 
class ThemesController extends BasePawtucketController {
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
		caSetPageCSSClasses(array("themes"));
		$this->view->setVar('access_values', $this->opa_access_values);
	
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name"));
	}
	# -------------------------------------------------------
	public function Theme() {
		# --- displays a list of all projects (ca_occurrences records) tagged with a specific proj_theme
		$t_list = new ca_lists();
		$item_id = $this->request->getParameter('item_id', pInteger);
		if(!$item_id){
			# --- redirect to front
			$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
			return;
		}
		$theme_name = $t_list->getItemForDisplayByItemID($item_id, array("return" => "plural"));
		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").$theme_name);

		$o_browse = caGetBrowseInstance("ca_occurrences");
		$o_browse->setTypeRestrictions(array("project"), array('dontExpandHierarchically' => true)); 
		$o_browse->addCriteria("theme_facet", $item_id);
		#$o_browse->addResultFilter('ca_occurrences.parent_id', 'is', 'null');
		$o_browse->execute(array('checkAccess' => $this->opa_access_values, 'request' => $this->request, 'showAllForNoCriteriaBrowse' => false, 'expandResultsHierarchically' => false, 'omitChildRecords' => 'true'));
		$qr_res = $o_browse->getResults(array('sort' => 'ca_occurrence_labels', 'sort_direction' => 'asc'));
		
		$this->view->setVar("item_id", $item_id);
		$this->view->setVar("theme_name", $theme_name);
		$this->view->setVar("results", $qr_res);
		$this->render("Themes/theme_html.php");
	}
	# -------------------------------------------------------
}