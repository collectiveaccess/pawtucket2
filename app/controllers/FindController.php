<?php
/* ----------------------------------------------------------------------
 * app/controllers/FindController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
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
 	require_once(__CA_LIB_DIR__.'/ApplicationPluginManager.php');
 	require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
 	require_once(__CA_APP_DIR__."/helpers/searchHelpers.php");
 	require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
 	require_once(__CA_APP_DIR__."/helpers/exportHelpers.php");
 	require_once(__CA_APP_DIR__."/helpers/printHelpers.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
	
 	class FindController extends BasePawtucketController {
 		# -------------------------------------------------------
        /**
         * @var Configuration
         */
 		 protected $opo_config;
 		 
        /**
         * @var 
         */
 		 protected $ops_view_prefix=null;
 		 
 		 /**
 		  * 
 		  */
 		  protected $opo_app_plugin_manager;
 		 
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			// Make application plugin manager available to superclasses
 			$this->opo_app_plugin_manager = new ApplicationPluginManager();
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 		}
 		# ------------------------------------------------------------------
 		/**
 		 * 
 		 */
 		protected function setTableSpecificViewVars() {
 			// merge displays with drop-in print templates
			$va_export_options = (bool)$this->request->config->get('disable_pdf_output') ? array() : caGetAvailablePrintTemplates('results', array('table' => $this->ops_tablename)); 
			
			// add Excel/PowerPoint export options configured in app.conf
			$va_export_config = (bool)$this->request->config->get('disable_export_output') ? array() : $this->request->config->getAssoc('export_formats');
	
			if(is_array($va_export_config) && is_array($va_export_config[$this->ops_tablename])) {
				foreach($va_export_config[$this->ops_tablename] as $vs_export_code => $va_export_option) {
					$va_export_options[] = array(
						'name' => $va_export_option['name'],
						'code' => $vs_export_code,
						'type' => $va_export_option['type']
					);
				}
			}
			$this->view->setVar('isNav', $vb_is_nav = (bool)$this->request->getParameter('isNav', pInteger));	// flag for browses that originate from nav bar
			$this->view->setVar('export_formats', $va_export_options);
			
			$va_options = array();
			foreach($va_export_options as $vn_i => $va_format_info) {
				$va_options[$va_format_info['name']] = $va_format_info['code'];
			}
			// Get current display list
			$t_display = new ca_bundle_displays();
 			foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(array('table' => $this->ops_tablename, 'user_id' => $this->request->getUserID(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'checkAccess' => caGetUserAccessValues()))) as $va_display) {
 				$va_options[$va_display['name']] = "_display_".$va_display['display_id'];
 			}
 			ksort($va_options);
 			
 			// Set comparison list view vars
 			$this->view->setVar('comparison_list', $va_comparison_list = caGetComparisonList($this->ops_tablename));
 			
			$this->view->setVar('export_format_select', caHTMLSelect('export_format', $va_options, array('class' => 'searchToolsSelect'), array('value' => $this->view->getVar('current_export_format'), 'width' => '150px')));
 		}
 		# ------------------------------------------------------------------
 		/**
 		 *
 		 */
 		protected function getFacet($po_browse) {
			$facet = $this->request->getParameter(['facet'], pString, ['forcePurify' => true]);

			$start = ($s = $this->request->getParameter('s', pInteger)) > 0 ? $s : 0;	// start menu-based browse menu facet data at page boundary; all others get the full facet
			$limit = ($l = $this->request->getParameter('l', pInteger)) > 0 ? $l : 0;
			$key = $po_browse->getBrowseID();
			$facet_info  = $po_browse->getInfoForFacet($facet);

			$content = $po_browse->getFacet($facet, ["checkAccess" => $this->opa_access_values, 'start' => $start, 'limit' => $limit]);

			$size = $content ? 0 : (($limit > 0) ? (is_array($f = $po_browse->getFacet($facet, array("checkAccess" => $this->opa_access_values))) && sizeof($f)) : sizeof($content));

			return [
				'facet' => $facet,
				'start' => $start, 'limit' => $limit,
				'key' => $key,
				'info' => $facet_info,
				'size' => $size,
				'content' => $content
			];
 		}
		# ------------------------------------------------------------------
 		/**
 		 * Returns summary of search or browse parameters suitable for display.
 		 * This is a base implementation and should be overridden to provide more 
 		 * detailed and appropriate output where necessary.
 		 *
 		 * @return string Summary of current search expression or browse criteria ready for display
 		 */
 		public function getCriteriaForDisplay($po_browse=null) {
 			return $this->opo_result_context ? $this->opo_result_context->getSearchExpression() : '';		// just give back the search expression verbatim; works ok for simple searches	
 		}
 		# -------------------------------------------------------
 	}
