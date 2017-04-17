<?php
/* ----------------------------------------------------------------------
 * controllers/CompareController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 
	require_once(__CA_LIB_DIR__."/core/ApplicationError.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class CompareController extends BasePawtucketController {
 		# -------------------------------------------------------
 		 
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
            
            AssetLoadManager::register("mirador");
            
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": "._t("Compre"));
 			caSetPageCSSClasses(array("compare"));
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function View() {
 			list($ps_table, $t_subject) = $this->_initView();
 			if (!is_array($va_item_ids = $this->request->session->getVar("{$ps_table}_comparison_list"))) { $va_item_ids = []; }
 			
 			$this->view->setVar('ids', $va_item_ids);
 			$this->render("Compare/view_html.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function Manifest() {
 			list($ps_table, $t_subject, $pn_item_id) = $this->_initView();
 			
 			$this->view->setVar('id', $pn_item_id);
 			
 			$va_reps = $t_subject->getRepresentations(['original'], [], ['checkAccess' => $this->opa_access_values]);
 			$this->view->setVar('representations', $va_reps);
 			
 			$this->render("Compare/manifest_json.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function AddToList() {
 			list($ps_table, $t_subject, $pn_item_id) = $this->_initView();
 			
 			if(!is_array($va_item_ids = $this->request->session->getVar("{$ps_table}_comparison_list"))) { $va_item_ids = []; }
 			
 			if (($pn_remove_id = $this->request->getParameter('remove_id', pInteger)) > 0) {
 				foreach($va_item_ids as $vn_i => $vn_id) {
 					if ($vn_id == $pn_remove_id) { unset($va_item_ids[(int)$vn_i]); }
 				}
 			}
 			
 			if ($pn_item_id > 0) {
				if (!in_array($pn_item_id, $va_item_ids)) { 
					$va_item_ids[] = $pn_item_id; 
				}
			}
			
			$va_item_ids = array_values($va_item_ids);
			
			$this->request->session->setVar("{$ps_table}_comparison_list", $va_item_ids);
			$this->request->session->save();
 			
 			// Get title template from config
 			$va_compare_config = $this->request->config->get('compare_images');
 			if (!is_array($va_compare_config = $va_compare_config[$ps_table])) { $va_compare_config = []; }
 			$va_display_list = caProcessTemplateForIDs(caGetOption('title_template', $va_compare_config, "^{$ps_table}.preferred_labels"), "ca_objects", $va_item_ids, ['returnAsArray' => true]);
 			
 			$this->view->setVar('result', ['ok' => 1, 'table' => $ps_table, 'comparison_list' => $va_item_ids, 'comparison_display_list' => $va_display_list]);
 			$this->render("Compare/add_to_list_result_json.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _initView() {
 			$o_dm = Datamodel::load();
 			
 			$ps_table = $this->request->getParameter('table', pString);
 			if (!($o_dm->tableExists($ps_table))) { throw new ApplicationException(_t('Invalid table %1', $ps_table)); }
 			if ($pn_item_id = $this->request->getParameter('id', pInteger)) {
 				if (!($t_subject = $ps_table::find($pn_item_id, ['checkAccess' => $this->opa_access_values]))) {
 					throw new ApplicationException(_t('Invalid id'));
 				}
 			} else {
 				$t_subject = new $ps_table();
 			}
 			if (!is_a($t_subject, "RepresentableBaseModel")) { throw new ApplicationException(_t('Not viewable')); }
 			
 			$this->view->setVar('table', $ps_table);
 			$this->view->setVar('t_subject', $t_subject);
 			$this->view->setVar('id', $pn_item_id);
 			
 			return [$ps_table, $t_subject, $pn_item_id];
 		}
 		# -------------------------------------------------------
 	}