<?php
/* ----------------------------------------------------------------------
 * controllers/LightboxController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__."/Datamodel.php");
require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
require_once(__CA_APP_DIR__.'/helpers/lightboxHelpers.php');
require_once(__CA_APP_DIR__."/controllers/FindController.php");
require_once(__CA_LIB_DIR__."/GeographicMap.php");
require_once(__CA_LIB_DIR__.'/Parsers/ZipStream.php');
require_once(__CA_LIB_DIR__.'/Logging/Downloadlog.php');

class LightboxController extends FindController {
	# -------------------------------------------------------
	/**
	 * @var
	 */
	protected $config;

	/**
	 * @var array
	 */
	 protected $user_groups;

	/**
	 * @var
	 */
	 protected $lightbox_display_name_singular;

	/**
	 * @var
	 */
	 protected $lightbox_display_name_plural;

	/**
	 * @var
	 */
	protected $is_login_redirect = false;
	
	/**
	 * @var string
	 */
	protected $table = 'ca_objects';
	
	/**
	 *
	 */
	protected $ops_view_prefix = 'Lightbox';
	
	
	# -------------------------------------------------------
	/**
	 * @param RequestHTTP $request
	 * @param ResponseHTTP $response
	 * @param null $view_paths
	 * @throws ApplicationException
	 */
	public function __construct($request, $response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);

		// Catch disabled lightbox
		if ($this->request->config->get('disable_lightbox')) {
			throw new ApplicationException('Lightbox is not enabled');
		}
		if (!($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
			$this->is_login_redirect = true;
			return;
		}
		
		$t_user_groups = new ca_user_groups();
		$this->user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
		$this->view->setVar("user_groups", $this->user_groups);

		// Lightbox config
		$this->config = caGetLightboxConfig();
		$this->view->setVar('lightbox_config', $this->config);
		
		// Lightbox display name
		$display_name = caGetLightboxDisplayName($this->config);
		
		$this->lightbox_display_name_singular = $display_name["singular"] ?? _t('Lightbox');
		$this->lightbox_display_name_plural = $display_name["plural"] ?? _t('Lightboxes');
		
		$this->view->setVar('lightbox_displayname_singular', $this->lightbox_display_name_singular);
		$this->view->setVar('lightbox_displayname_plural', $this->lightbox_display_name_plural);
		
		
 		$this->opa_access_values = caGetOption('checkAccess', $va_browse_info, $this->opa_access_values);
 		
 		$this->view->setVar('access_values', $this->opa_access_values);
		
		caSetPageCSSClasses(["lightbox"]);
		
		parent::setTableSpecificViewVars();
	}
	# -------------------------------------------------------
	/**
	 * Return list of lightboxes for user
	 */
	function Index(?array $options=null) {
		if($this->is_login_redirect) { return; }
				
		if($sort = $this->request->getParameter('sort', pString)) {
			Session::setVar('lightbox_list_sort', $sort);
		} else {
			$sort = Session::getVar('lightbox_list_sort');
		}
		if($sort_direction = $this->request->getParameter('direction', pString)) {
			Session::setVar('lightbox_list_sort_direction', $sort_direction);
		} else {
			$sort_direction = Session::getVar('lightbox_list_sort_direction');
		}
		
		$lightbox_types = $this->config->get('lightboxTypes');
		$configured_tables = array_values(array_map(function($v) { return $v['table'] ?? null; }, $lightbox_types));
	

		# Get sets for display
		$t_sets = new ca_sets();
		$read_sets = $t_sets->getSetsForUser([
			'tables' => $configured_tables, 
			"user_id" => $this->request->getUserID(), 
			"checkAccess" => $this->opa_access_values,
			"access" => (!is_null($vn_access = $this->request->config->get('lightbox_default_access'))) ? $vn_access : 1, 
			"parents_only" => true, 
			'sort' => $sort, 
			'sortDirection' => $sort_direction]);

		$write_sets = $t_sets->getSetsForUser([
			'tables' => $configured_tables, 
			"user_id" => $this->request->getUserID(), 
			"checkAccess" => $this->opa_access_values, 
			"parents_only" => true, 
			'sort' => $sort, 
			'sortDirection' => $sort_direction
		]);

		# Remove write sets from the read array
		$read_sets = array_diff_key($read_sets, $write_sets);

		$this->view->setVar("read_sets", $read_sets);
		$this->view->setVar("write_sets", $write_sets);
		
		$this->view->setVar('sort', $sort);
		$this->view->setVar('direction', $sort_direction);

		$set_ids = array_merge(array_keys($read_sets), array_keys($write_sets));
		$this->view->setVar("set_ids", $set_ids);
		$this->view->setVar("qr_sets", sizeof($set_ids) ? caMakeSearchResult('ca_sets', $set_ids, ['sort' => 'ca_sets.preferred_labels.name']) : null);

		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->lightbox_display_name_singular));
		
		$this->render(caGetOption("view", $options, "Lightbox/list_html.php"));
	}
	# -------------------------------------------------------
	/**
	 * Return contents of lightbox
	 */
	function Detail(?array $options=null) {
		if($this->is_login_redirect) { return; }
		
		$set_id = $this->request->getActionExtra();
		$t_set = ca_sets::findAsInstance($set_id);
		$this->view->setVar('t_set', $t_set);
		$this->view->setVar('set_id', $set_id);
		$this->view->setVar('table_num', $table_num = $t_set->get('ca_sets.table_num'));
		$this->view->setVar('table', Datamodel::getTableName($table_num));
		
		$this->view->setVar('items', $t_set->getItemsAsSearchResult(['checkAccess' => $this->opa_access_values]));
		
		$this->render(caGetOption("view", $options, "Lightbox/detail_html.php"));
	}
	# -------------------------------------------------------
	/** 
	 * Generate the URL for the "back to results" link from a browse result item
	 * as an array of path components.
	 */
	public static function getReturnToResultsUrl($request) {
		$ret = [
			'module_path' => '',
			'controller' => 'Lightbox',
			'action' => 'setDetail',
			'params' => []
		];
		return $ret;
	}
	# -------------------------------------------------------
}
