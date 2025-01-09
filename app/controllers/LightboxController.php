<?php
/* ----------------------------------------------------------------------
 * controllers/LightboxController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
require_once(__CA_APP_DIR__.'/helpers/exportHelpers.php');
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
		
		if($saved_search = Session::getVar("lightbox_search_ca_sets")) {
			$options['set_ids'] = $this->_search('ca_sets', $saved_search);
			$this->view->setVar('search', $saved_search);
		}
		
		$limit = 8;
		$start = (int)$this->request->getParameter('s', pInteger);
		$is_incremental_load = (bool)$this->request->getParameter('incremental', pInteger);
		
		// @TODO generalize for all tables
		$o_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
		$o_context->setAsLastFind();
		
		// Sort list
		$loptions = $this->config->getAssoc('lightbox_options');
		$tconfig = $loptions['ca_sets'] ?? [];
		$this->view->setVar('sorts', $available_sorts = $tconfig['sorts'] ?? []);
		$this->view->setVar('sort_directions', $tconfig['sort_directions'] ?? []);
		
		// Set current sort
		if($sort = $this->request->getParameter('sort', pString)) {
			Session::setVar('lightbox_list_sort', $sort);
		} else {
			$sort = Session::getVar('lightbox_list_sort');
		}
		if($sort_direction = $this->request->getParameter('sortDirection', pString)) {
			Session::setVar('lightbox_list_sort_direction', $sort_direction);
		} else {
			$sort_direction = Session::getVar('lightbox_list_sort_direction');
		}
		
		
		// View modes
		$configured_modes = $tconfig['view_modes'] ?? [];
		$configured_mode_codes = array_keys($configured_modes);
		
		if($mode = $this->request->getParameter('mode', pString)) {
			Session::setVar('lightbox_list_view_mode', $mode);
		} else {
			$mode = Session::getVar('lightbox_list_view_mode');
		}
		if(!in_array($mode, $configured_mode_codes, true)) {
			$mode = $configured_mode_codes[0]; 		// default is images
		}
		$this->view->setVar('mode', $mode);
		$this->view->setVar('configured_modes', $configured_modes);
		
		// @TODO: generalize
		$configured_tables = ['ca_objects'];

		# Get sets for display
		[$read_sets, $write_sets] = array_values($this->_getSetsForUser($this->request->getUserID(), $configured_tables));		

		$this->view->setVar("read_sets", $read_sets);
		$this->view->setVar("write_sets", $write_sets);
	
		$this->view->setVar('current_sort', $sort);
		$this->view->setVar('current_sort_direction', $sort_direction);
		
		$this->view->setVar('mode', $mode);
		$this->view->setVar('type', 'ca_sets');
	
		if(!($set_ids = caGetOption('set_ids', $options, null))) {
			$set_ids = array_merge(array_keys($read_sets), array_keys($write_sets));
		}
		
		$this->view->setVar('start', $start);
		$this->view->setVar('limit', $limit);
		$this->view->setVar('total', sizeof($set_ids));
		$this->view->setVar('is_incremental_load', $is_incremental_load);
		
		$this->view->setVar("set_ids", $set_ids);
		
		$this->view->setVar("qr_sets", sizeof($set_ids) ? caMakeSearchResult('ca_sets', $set_ids, ['sort' => $available_sorts[$sort] ?? null, 'sortDirection' => $sort_direction, 'start' => $start, 'limit' => $limit]) : null);

		MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter").ucfirst($this->lightbox_display_name_singular));
		
		$this->render(caGetOption("view", $options, "Lightbox/list_html.php"));
	}
	# -------------------------------------------------------
	/**
	 * Return contents of lightbox
	 */
	function Detail(?array $options=null) {
		if($this->is_login_redirect) { return; }
		$set_id = caGetOption(['id', 'set_id'], $options, $this->request->getActionExtra());
		
		$limit = 8;
		$start = (int)$this->request->getParameter('s', pInteger);

		$is_incremental_load = (bool)$this->request->getParameter('incremental', pInteger);
		
		// @TODO generalize for all tables
		$o_context = new ResultContext($this->request, 'ca_objects', 'lightbox');
		$o_context->setAsLastFind();
		
		// Sort list
		$loptions = $this->config->getAssoc('lightbox_options');
		
		// @TODO support different types of lightboxes
		$tconfig = $loptions['ca_objects'] ?? [];
		$this->view->setVar('sorts', $available_sorts = $tconfig['sorts'] ?? []);
		$this->view->setVar('sort_directions', $tconfig['sort_directions'] ?? []);
		
		// View modes
		
		$configured_modes = $tconfig['view_modes'] ?? [];
		$configured_mode_codes = array_keys($configured_modes);
		
		if($mode = $this->request->getParameter('mode', pString)) {
			Session::setVar('lightbox_detail_view_mode', $mode);
		} else {
			$mode = Session::getVar('lightbox_detail_view_mode');
		}
		if(!in_array($mode, $configured_mode_codes, true)) {
			$mode = $configured_mode_codes[0]; 		// default is images
		}
		$this->view->setVar('mode', $mode);
		$this->view->setVar('configured_modes', $configured_modes);
		
		// Load set
		if(!($t_set = ca_sets::findAsInstance($set_id))) {
			return $this->Index();
		}
		$this->view->setVar('t_set', $t_set);
		$this->view->setVar('set_id', $set_id);
		$this->view->setVar('table_num', $table_num = $t_set->get('ca_sets.table_num'));
		$this->view->setVar('table', Datamodel::getTableName($table_num));
		
		
		// Set configuration options in view
		$this->view->setVar('caption_template', caGetOption(["caption_template_{$mode}", 'caption_template'], $tconfig, '^ca_objects.preferred_labels'));
				
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
		
		//'checkAccess' => $this->opa_access_values
		$ids = $t_set->getItems(['idsOnly' => true]);
		if($search_ids = caGetOption('ids', $options, null)) {
			$ids = array_intersect($ids, $search_ids);	
		}
		
		$this->view->setVar('start', $start);
		$this->view->setVar('limit', $limit);
	
		//'checkAccess' => $this->opa_access_values,
		$this->view->setVar('items', $qr = caMakeSearchResult('ca_objects', $ids, ['sort' => $current_sort, 'sortDirection' => $current_sort_direction, 'start' => $start, 'limit' => $limit]));

		$this->view->setVar('total', count($ids));
		$this->view->setVar('is_incremental_load', $is_incremental_load);
		
		// TODO: support different types of lightboxes
		$this->view->setVar('type', 'ca_objects');
		
		$downloads = [];
		foreach($tconfig['downloads'] ?? [] as $dcode => $dinfo) {
			switch(strtolower($dinfo['type'] ?? null)) {
				case 'media':
					$downloads[] = array_merge($dinfo, [
						'url' => caNavUrl($this->request, '*', '*', "Download/{$dcode}", ['id' => $set_id,'type' => $dinfo['type'], 'version' => $dinfo['version'] ?? 'original']),
					]);
					break;
			}
		}
		$this->view->setVar('downloads', $downloads);
		
		$exports = [];
		foreach($tconfig['exports'] ?? [] as $dcode => $dinfo) {
			$exports[] = array_merge($dinfo, [
				'url' => caNavUrl($this->request, '*', '*', "Export/{$dcode}", ['id' => $set_id, 'type' => $dinfo['type'], 'display' => $dinfo['display']]),
			]);
		}
		$pdf_exports = caGetAvailablePrintTemplates('results', ['table' => 'ca_objects']);
		if(is_array($pdf_exports) && sizeof($pdf_exports)) {
			foreach($pdf_exports as $dcode => $dinfo) {
				$dinfo['label'] = $dinfo['name'];
				unset($dinfo['name']);
				$exports[] = array_merge($dinfo, [
					'url' => caNavUrl($this->request, '*', '*', "Export/{$dinfo['code']}", ['id' => $set_id, 'type' => $dinfo['type']]),
				]);
			}
		}
		$this->view->setVar('exports', $exports);

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
			'parent_id' => null,
			'access' => $this->request->config->get('lightbox_default_access')
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
				$errors[] = _t('Could not delete %1: %2', $this->lightbox_display_name_singular, join('; ', $t_set->getErrors()));
			}
		}
		
		$this->view->setVar('errors', $errors);
		$this->Index();
	}
	# -------------------------------------------------------
	/**
	 * Delete lightbox items
	 */
	function DeleteItems(?array $options=null) {
		$id = $this->request->getParameter('id', pInteger);
		$item_ids = $this->_getItemIDs($this->request->getParameter('item_id', pString));
		
		$errors = [];
		
		if(!($t_set = ca_sets::findAsInstance(['set_id' => $id]))) {
			$errors[] = _t('Invalid %1 id %2', $this->lightbox_display_name_singular, $id);
		} else {
			$user_id = $this->request->getUserID();
			if(!$t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) {
				$errors[] = _t('You do not have access to this %1', $this->lightbox_display_name_singular);
			} elseif(!$t_set->removeItems($item_ids)) {
				$errors[] = _t('Could not delete item: %1', join('; ', $t_set->getErrors()));
			}
		}
		
		$this->view->setVar('errors', $errors);
		$this->Detail(['id' => $id]);
	}
	# -------------------------------------------------------
	/**
	 * Search
	 */
	function Search(?array $options=null) {
		$t = $this->request->getParameter('t', pString); // table
		$id = $this->request->getParameter('id', pInteger);	// set_id
		$search = $this->request->getParameter('search', pString);	// set_id
		
		$this->view->setVar('search', $search);
		switch($t) {
			case 'ca_sets':	// lightbox list
				$set_ids = $this->_search($t, $search);
				return $this->Index(['set_ids' => $set_ids]);
				break;
			default:	// everything else
				$ids = $this->_search($t, $search, $id);
				return $this->Detail(['ids' => $ids, 'set_id' => $id]);
				break;
		}
	}
	# -------------------------------------------------------
	/**
	 * Download
	 */
	function Download(?array $options=null) {
		$id = $this->request->getParameter('id', pInteger);
		$type = $this->request->getParameter('type', pString);
		$item_ids = $this->_getItemIDs($this->request->getParameter('item_id', pString));
		$version = $this->request->getParameter('version', pString);
		$select_all = (bool)$this->request->getParameter('selectAll', pString);
		$omit_item_ids = $select_all ? $this->_getItemIDs($this->request->getParameter('omit_item_id', pString)) : null;

		$errors = [];
		
		if(!($t_set = ca_sets::findAsInstance(['set_id' => $id]))) {
			$errors[] = _t('Invalid %1 id %2', $this->lightbox_display_name_singular, $id);
		} else {
			$user_id = $this->request->getUserID();
			if(!$t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) {
				$errors[] = _t('You do not have access to this %1', $this->lightbox_display_name_singular);
			} 
		}
		
		if(sizeof($errors)) { 
			$this->view->setVar('errors', $errors);
			return $this->Detail(['id' => $id]);
		} 
		
		$set_items = caExtractValuesByUserLocale($t_set->getItems(['thumbnailVersions' => [$version], 'row_ids' => $select_all ? null : $item_ids]));
		
		$file_paths = [];
		if(is_array($set_items)) {
			$c = 1;
			foreach($set_items as $set_item) {
				if($omit_item_ids && in_array($set_item['row_id'], $omit_item_ids)) { continue; }
				$f = $set_item["representation_path_{$version}"];
				$file_paths[$f] = $set_item['idno'].'-'.$c.'.'.pathinfo($f, PATHINFO_EXTENSION);
				$c++;
			}
		}
		$o_zip = new ZipStream();
		foreach($file_paths as $path => $name) {
			$o_zip->addFile($path, $name);
		}
		$this->view->setVar('zip_stream', $o_zip);
		//$this->view->setVar('archive_name', preg_replace('![^A-Za-z0-9\.\-]+!', '_', $t_object->get('idno')).'.zip');
		$this->view->setVar('archive_name', "download.zip");
		
		$vn_rc = $this->render('Download/download_file_binary.php');
		
	}
	# -------------------------------------------------------
	/**
	 * Download
	 */
	function Export(?array $options=null) {
		$id = $this->request->getParameter('id', pInteger);
		$type = $this->request->getParameter('type', pString);
		$item_ids = $this->_getItemIDs($this->request->getParameter('item_id', pString));
		$select_all = (bool)$this->request->getParameter('selectAll', pString);
		$omit_item_ids = $select_all ? $this->_getItemIDs($this->request->getParameter('omit_item_id', pString)) : null;

		$format = $this->request->getActionExtra();
		
		// Lightbox options
		$loptions = $this->config->getAssoc('lightbox_options');
		$tconfig = $loptions['ca_objects'] ?? []; // @TODO support different types of lightboxes
		
		$errors = [];
		
		if(!($t_set = ca_sets::findAsInstance(['set_id' => $id]))) {
			$errors[] = _t('Invalid %1 id %2', $this->lightbox_display_name_singular, $id);
		} else {
			$user_id = $this->request->getUserID();
			if(!$t_set->haveAccessToSet($user_id, __CA_SET_EDIT_ACCESS__)) {
				$errors[] = _t('You do not have access to this %1', $this->lightbox_display_name_singular);
			} 
		}
		
		if(sizeof($errors)) { 
			$this->view->setVar('errors', $errors);
			return $this->Detail(['id' => $id]);
		} 
		
		$set_items = caExtractValuesByUserLocale($t_set->getItems(['thumbnailVersions' => [$version], 'row_ids' => $select_all ? null : $item_ids]));
		
		$file_paths = $row_ids = [];
		$qr = null;
		if(is_array($set_items)) {
			switch($type) {
				case 'media':
					$c = 1;
					foreach($set_items as $set_item) {
						if($omit_item_ids && in_array($set_item['row_id'], $omit_item_ids)) { continue; }
						
						$f = $set_item["representation_path_{$version}"];
						$file_paths[$f] = $set_item['idno'].'-'.$c.'.'.pathinfo($f, PATHINFO_EXTENSION);
						$c++;
					}
					$this->view->setVar('zip_stream', $o_zip);
					$this->view->setVar('archive_name', "download.zip");	// @TODO: set name properly
					
					return $this->render('Download/download_file_binary.php');
					break;
				default:
					$row_ids = array_values(array_map(function($v) { return $v['row_id']; }, $set_items));
					$qr = caMakeSearchResult('ca_objects', $row_ids);
					
					if($export_config = $tconfig['exports'][$format] ?? null) {
						$t = "_{$export_config['type']}_{$export_config['display']}";
						$ext = $export_config['type'];
					} else {
						$t = $format;
						$ext = 'pdf';
					}
					caExportResult($this->request, $qr, $t, "report.{$ext}", []);
					break;
			}
		}	
		return null;
	}
	# -------------------------------------------------------
	/*
	 * Utilities
	 */
	# -------------------------------------------------------
	/**
	 * 
	 */
	private function _search(string $t, string $search, ?int $set_id=null) : ?array {
		if(!($s = caGetSearchInstance($t))){
			throw new ApplicationException(_t('Invalid type %1', $t));
		}
		
		$key = Datamodel::primaryKey($t);
		if($t === 'ca_sets') {
			//$set_ids = $this->_getSetsForUser($this->request->getUserID(), ['ca_sets']) ?? [0];
			//$s->addResultFilter("{$t}.set_id", 'IN', join(",", $set_ids));
		} elseif($set_id > 0) {
			$search .= " AND (ca_sets.set_id:{$set_id})";
		}
		
		$qr = $s->search($search, ['checkAccess' => $this->opa_access_values]);
		
		Session::setVar("lightbox_search_{$t}", $search);
		$ids = $qr->getAllFieldValues($key);
		
		return $ids;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private function _getSetsForUser(int $user_id, array $configured_tables) : ?array {
		$t_sets = new ca_sets();
		$read_sets = $t_sets->getSetsForUser([
			'tables' => $configured_tables, 
			"user_id" => $user_id, 
			//"checkAccess" => $this->opa_access_values,
			"access" => (!is_null($access = $this->request->config->get('lightbox_default_access'))) ? $access : 1, 
			"parents_only" => true
		]) ?? [];

		$write_sets = $t_sets->getSetsForUser([
			'tables' => $configured_tables, 
			"user_id" => $user_id, 
			//"checkAccess" => $this->opa_access_values, 
			"parents_only" => true
		]) ?? [];
		
		$read_sets = array_diff_key($read_sets, $write_sets);
		
		return['read' => $read_sets, 'write' => $write_sets];
	}
	# -------------------------------------------------------
	/**
	 * 
	 */
	private function _getItemIDs(string $item_list) : ?array {
		$item_ids = array_filter(array_map('intval', explode(';', $item_list)), function($v) {
			return $v > 0;
		});
		
		return $item_ids;
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
