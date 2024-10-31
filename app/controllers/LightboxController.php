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
		$this->lightbox_description_element_code = $this->config->get('lightbox_description_element_code');
		
		$this->view->setVar('lightbox_displayname_singular', $this->lightbox_display_name_singular);
		$this->view->setVar('lightbox_displayname_plural', $this->lightbox_display_name_plural);
		$this->view->setVar('lightbox_description_element_code', $this->lightbox_description_element_code);
				
 		$this->opa_access_values = caGetOption('checkAccess', $va_browse_info, $this->opa_access_values);
 		
 		$this->view->setVar('access_values', $this->opa_access_values);
 		
		$this->view->setVar('errors', []);
		
		caSetPageCSSClasses(["lightbox"]);
		
		parent::setTableSpecificViewVars();
	}
	# -------------------------------------------------------
	/**
	 * Return list of lightboxes for user
	 */
	function Index(?array $options=null) {
		if($this->is_login_redirect) { return; }
		
		// @TODO generalize for all tables
		$o_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
		$o_context->setAsLastFind();
		
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
		
		// @TODO: generalize
		$configured_tables = ['ca_objects'];

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
		$set_id = caGetOption('set_id', $options, $this->request->getActionExtra());
		
		// @TODO generalize for all tables
		$o_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
		$o_context->setAsLastFind();
		
		// Sort list
		$loptions = $this->config->getAssoc('lightbox_options');
		$tconfig = $loptions['ca_objects'] ?? [];
		$this->view->setVar('sorts', $available_sorts = $tconfig['sorts'] ?? []);
		$this->view->setVar('sort_directions', $tconfig['sort_directions'] ?? []);
		
		// Load set
		$t_set = ca_sets::findAsInstance($set_id);
		$this->view->setVar('t_set', $t_set);
		$this->view->setVar('set_id', $set_id);
		$this->view->setVar('table_num', $table_num = $t_set->get('ca_sets.table_num'));
		$this->view->setVar('table', Datamodel::getTableName($table_num));
		
		
		// Set current sort
		if(($current_sort_name = $this->request->getParameter('sort', pString)) && isset($available_sorts[$current_sort_name])) {
			$o_context->setCurrentSort($current_sort = $available_sorts[$current_sort_name]);
		} else {
			if(!($current_sort = $o_context->getCurrentSort())) {
				$current_sort = array_shift(array_values($available_sorts));
			}
			$tmp = array_flip($available_sorts);
			$current_sort_name = $tmp[$current_sort] ?? '?';
		}
		if(($current_sort_direction = strtolower($this->request->getParameter('sortDirection', pString))) && in_array($current_sort_direction, ['asc', 'desc'])) {
			$o_context->setCurrentSortDirection($current_sort_direction);
		} else {
			if(!($current_sort_direction = $o_context->getCurrentSortDirection())) {
				$current_sort_direction = 'asc';
			}
		}
		$this->view->setVar('current_sort', $current_sort_name);
		$this->view->setVar('current_sort_direction', $current_sort_direction);
	
		$this->view->setVar('items', $qr = $t_set->getItemsAsSearchResult(['sort' => $current_sort, 'sortDirection' => $current_sort_direction, 'checkAccess' => $this->opa_access_values]));
	
		$max_result_count = 50;
		$o_context->setResultList($qr->getPrimaryKeyValues($max_result_count));
		$qr->seek(0);
		
		$o_context->saveContext();
		
		$this->view->setVar('modalValues', [
			'name' => $t_set->get('ca_sets.preferred_labels.name'),
			'description' => $this->lightbox_description_element_code ? $t_set->get('ca_sets.'.$this->lightbox_description_element_code) : ''
		]);
		
		
		$this->render(caGetOption("view", $options, "Lightbox/detail_html.php"));
	}
	# -------------------------------------------------------
	/**
	 * Add new lightbox
	 */
	function Add(?array $options=null) {
		global $g_ui_locale_id;
		$name = $this->request->getParameter('name', pString);
		$description = $this->request->getParameter('description', pString);
		
		$errors = [];
		$preserve_model_values = false;
		
		$t_set = new ca_sets();
		$t_set->set([
			'table_num' => 57,			// @TODO: allow set by user
			'type_id' => 'user',	// @TODO: make configurable
			'user_id' => $this->request->getUserID(),
			'set_code' => $this->request->getUserID().'_'.time(),
			'parent_id' => null
		]);
		
		if($this->lightbox_description_element_code) {
			$t_set->addAttribute([$this->lightbox_description_element_code => $description, 'locale_id' => $g_ui_locale_id], $this->lightbox_description_element_code);
		}
		if(!$t_set->insert()) {
			$errors[] = _t('Could not create %1: %2', $this->lightbox_display_name_singular, join('; ', $t_set->getErrors()));
			$preserve_model_values = true;
		} elseif(!$t_set->addLabel(['name' => $name], $g_ui_locale_id, null, true)) {
			$errors[] = _t(strlen($name) ? 'Could not label %1 as %2: %3' : 'Could not label %1: %3', $this->lightbox_display_name_singular, $name, join('; ', $t_set->getErrors()));
			$preserve_model_values = true;
			$t_set->delete(true);
		}
		
		$this->view->setVar('modalValues', [
			'name' => $name, 'description' => $description
		]);
		$this->view->setVar('preserveModalValues', $preserve_model_values);
		$this->view->setVar('errors', $errors);
		
		$this->Index();
	}
	# -------------------------------------------------------
	/**
	 * Edit lightbox
	 */
	function Edit(?array $options=null) {
		global $g_ui_locale_id;
		$id = $this->request->getParameter('id', pInteger);
		$name = $this->request->getParameter('name', pString);
		$description = $this->request->getParameter('description', pString);
		
		$errors = [];
		$preserve_model_values = false;
		
		if(!($t_set = ca_sets::findAsInstance(['set_id' => $id]))) {
			$errors[] = _t('Invalid %1 id %2', $this->lightbox_display_name_singular, $id);
		} else {
			$user_id = $this->request->getUserID();
			if(!$t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) {
				$errors[] = _t('You do not have access to this %1', $this->lightbox_display_name_singular);
			}
			
			if(strlen($name)) {
				if(!$t_set->replaceLabel(['name' => $name], $g_ui_locale_id, null, true)) {
					$errors[] = _t('Could not update %1 name: %2', $this->lightbox_display_name_singular, join('; ', $t_set->getErrors()));
				}
			}
			
			$this->view->setVar('modalValues', $z=[
				'name' => $name, 'description' => $description
			]);
			if($this->lightbox_description_element_code) {
				$t_set->replaceAttribute([$this->lightbox_description_element_code => $description, 'locale_id' => $g_ui_locale_id], $this->lightbox_description_element_code);
				if(!$t_set->update()) {
					$errors[] = _t('Could not update %1 description: %2', $this->lightbox_display_name_singular, join('; ', $t_set->getErrors()));
				}
			}
		}
			
		$this->view->setVar('errors', $errors);
		$this->Detail(['set_id' => $id]);
	}
	# -------------------------------------------------------
	/**
	 * Delete lightbox
	 */
	function Delete(?array $options=null) {
		$id = $this->request->getParameter('id', pInteger);
		
		$errors = [];
		
		if(!($t_set = ca_sets::findAsInstance(['set_id' => $id]))) {
			$errors[] = _t('Invalid %1 id %2', $this->lightbox_display_name_singular, $id);
		} else {
			$user_id = $this->request->getUserID();
			if(!$t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) {
				$errors[] = _t('You do not have access to this %1', $this->lightbox_display_name_singular);
			} elseif(!$t_set->delete()) {
				$errors[] = _t('Could not delete %1: %2', $this->lightbox_display_name_singular, $name, join('; ', $t_set->getErrors()));
			}
		}
		
		$this->view->setVar('errors', $errors);
		$this->Index();
	}
	# -------------------------------------------------------
	/**
	 * Export
	 */
	function Export(?array $options=null) {
		$id = $this->request->getParameter('id', pInteger);
		
		$this->Detail(['set_id' => $id]);
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
