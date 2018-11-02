<?php
/* ----------------------------------------------------------------------
 * controllers/CompareController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2018 Whirl-i-Gig
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
            
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Compare"));
 			caSetPageCSSClasses(array("compare"));
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function View() {
 			if (!is_array($va_item_ids = Session::getVar("comparison_list"))) { $va_item_ids = []; }
 			
 			if($u = str_replace('|', '/', $this->request->getParameter('url', pString))) { Session::setVar('compare_last_page', $u); }
 			$this->view->setVar('items', $va_item_ids);
 			$this->render("Compare/view_html.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function Manifest() {
 			if(!is_array($va_comparison_list = Session::getVar("comparison_list"))) { $va_comparison_list = []; }
 			$ps_id = $this->request->getParameter('id', pString);
 			
 			if (!is_array($va_ids = array_filter($va_comparison_list, function($v) use ($ps_id) { return $v['resolved_id'] === $ps_id; })) || !sizeof($va_ids)) {
 			     throw new ApplicationException(_t('Invalid id %1', $ps_id));
 			}
 			$va_info = array_shift($va_ids);
 			
 			// check access to subject and media identifiers 
 			if (!caParseMediaIdentifier($va_info['id'], ['checkAccess' => $this->opa_access_values]) || (($va_info['id'] !== $va_info['resolved_id']) && !caParseMediaIdentifier($va_info['resolved_id'], ['checkAccess' => $this->opa_access_values]))) {
 			    throw new ApplicationException(_t('Invalid access for id %1', $ps_id));
 			}
 			
 		    $this->view->setVar('id', $ps_id);
 		    $this->view->setVar('info', $va_info);
 		    
 			$this->render("Compare/manifest_json.php");
 		}
 		# ------------------------------------------------------
 		/**
 		 *
 		 */
 		public function AddToList() {
 			if(!is_array($va_comparison_list = Session::getVar("comparison_list"))) { $va_comparison_list = []; }
 			
 			if ($ps_remove_id = $this->request->getParameter('remove_id', pString)) {
 				foreach($va_comparison_list as $vn_i => $va_item) {
 					if ($va_item['id'] === $ps_remove_id) { unset($va_comparison_list[$vn_i]); }
 				}
 			}
 			
 			if ($ps_id = $this->request->getParameter('id', pString)) {
				if (sizeof(array_filter($va_comparison_list, function($v) use ($ps_id) { return $v['id'] == $ps_id; })) == 0) {
				    if (is_array($va_id = caParseMediaIdentifier($ps_id, ['checkAccess' => $this->opa_access_values, 'includeInstance' => true]))) {
				        $va_compare_config = $this->request->config->get('compare_images');
				        
				        if (!is_array($va_compare_config = $va_compare_config[$va_id['subject']])) { $va_compare_config = []; }
				        
				        $vs_template = caGetOption('title_template', $va_compare_config, "^".$va_id['subject'].".preferred_labels");
				        if (($va_id['type'] == 'attribute') && is_object($va_id['instance'])) {
				            if ($vs_template = caGetOption('attribute_template', $va_compare_config, null)) {
				                $vs_prefix = $va_id['subject'].".".ca_metadata_elements::getElementCodeForId(ca_metadata_elements::getElementHierarchyID($va_id['instance']->get('element_id')));
				            } 
				            
				            $attr_ids = array_keys(array_shift($va_id['subject_instance']->get($vs_prefix, ['returnWithStructure' => true])));
				            $index = array_search($va_id['instance']->get('ca_attribute_values.attribute_id'), $attr_ids);
				       
				            $vs_display = caProcessTemplateForIDs($vs_template, $va_id['subject'], [$va_id['subject_id']], [ 'relativeToContainer' => $vs_prefix, 'unitStart' => $index, 'unitLength' => 1, 'returnAsArray' => false, 'checkAccess' => $this->opa_access_values]);

				        } else {
				            $vs_display = caProcessTemplateForIDs($vs_template, $va_id['subject'], [$va_id['subject_id']], ['returnAsArray' => false, 'checkAccess' => $this->opa_access_values]);
                        }
                        if (!($vs_display = strip_tags($vs_display))) {
                            $vs_display = '['._t('BLANK').']';
                        }
                        
                        if (($c = sizeof(array_filter($va_comparison_list, function($v) use ($vs_display) { return ($v['display'] === $vs_display); }))) > 0) {
                            $vs_display .= " [".($c + 1)."]";
                        }
                        
                        $va_comparison_list[] = [
                            'id' => $ps_id,
                            'resolved_id' => $va_id['type'].':'.$va_id['id'],
                            'display' => $vs_display
                        ];
                    }
				}
			}
			
			$va_comparison_list = array_values($va_comparison_list);
			
			Session::setVar("comparison_list", $va_comparison_list);
			Session::save();
			
 			$this->view->setVar('result', ['ok' => 1, 'comparison_list' => $va_comparison_list]);
 			$this->render("Compare/add_to_list_result_json.php");
 		}
 		# -------------------------------------------------------
 	}