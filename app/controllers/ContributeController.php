<?php
/* ----------------------------------------------------------------------
 * controllers/ContributeController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_metadata_elements.php');
	require_once(__CA_APP_DIR__."/helpers/contributeHelpers.php");
 
 	class ContributeController extends ActionController {
 		# -------------------------------------------------------
 		private $pt_subject = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            
            $this->config = caGetContributeFormConfig();
            
 			MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": "._t("Contribute"));
 			caSetPageCSSClasses(array("contribute"));
 		}
 		# -------------------------------------------------------
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			
 			if (!($va_form_info = $this->_checkForm($ps_function))) { return; }
 				
 			$this->view->setVar('t_subject', $t_subject = $this->pt_subject);
 			
 			
 			$va_tags = $this->view->getTagList($va_form_info['view']);
 			
 			foreach($va_tags as $vs_tag) {
 				if(in_array($vs_tag, array('form', '/form', 'submit', 'reset'))) { continue; }
 				$va_parse = caParseTagOptions($vs_tag);
 				$vs_tag_proc = $va_parse['tag'];
 				$va_opts = $va_parse['options'];
 				
 				if (($vs_default_value = caGetOption('default', $va_opts, null)) || ($vs_default_value = caGetOption($vs_tag_proc, $va_default_form_values, null))) { 
					$va_default_form_values[$vs_tag_proc] = $vs_default_value;
					unset($va_opts['default']);
				} 
 			
				$vs_tag_val = null;
 				switch(strtolower($vs_tag_proc)) {
 					case 'submit':
 						$this->view->setVar($vs_tag, "<a href='#' class='caContributeFormSubmit'>".((isset($va_opts['label']) && $va_opts['label']) ? $va_opts['label'] : _t('Submit'))."</a>");
 						break;
 					case 'reset':
 						$this->view->setVar($vs_tag, "<a href='#' class='caContributeFormReset'>".((isset($va_opts['label']) && $va_opts['label']) ? $va_opts['label'] : _t('Reset'))."</a>");
 			
 						$vs_script = "<script type='text/javascript'>
	jQuery('.caContributeFormSubmit').bind('click', function() {
		jQuery('#caContribute').submit();
		return false;
	});
	jQuery('.caContributeFormReset').bind('click', function() {
		jQuery('#caContribute').find('input[type!=\"hidden\"],textarea').val('');
		jQuery('#caContribute').find('select.caContributeBoolean').val('AND');
		jQuery('#caContribute').find('select').prop('selectedIndex', 0);
		return false;
	});
	jQuery(document).ready(function() {
		var f, defaultValues = ".json_encode($va_default_form_values).", defaultBooleans = ".json_encode($va_default_form_booleans).";
		for (f in defaultValues) {
			var f_proc = f + '[]';
			jQuery('input[name=\"' + f_proc+ '\"], textarea[name=\"' + f_proc+ '\"], select[name=\"' + f_proc+ '\"]').each(function(k, v) {
				if (defaultValues[f][k]) { jQuery(v).val(defaultValues[f][k]); } 
			});
		}
		for (f in defaultBooleans) {
			var f_proc = f + '[]';
			jQuery('select[name=\"' + f_proc+ '\"].caContributeBoolean').each(function(k, v) {
				if (defaultBooleans[f][k]) { jQuery(v).val(defaultBooleans[f][k]); }
			});
		}
	});
</script>\n";
 						break;
 					default:
 			
						if (preg_match("!^(.*):label$!", $vs_tag_proc, $va_matches)) {
							$this->view->setVar($vs_tag, $vs_tag_val = $t_subject->getDisplayLabel($va_matches[1]));
						} else {
							$va_opts['asArrayElement'] = true;
							if ($vs_tag_val = $t_subject->htmlFormElementForSimpleForm($this->request, $vs_tag_proc, $va_opts)) {
								$this->view->setVar($vs_tag, $vs_tag_val);
							}
							
							$va_tmp = explode('.', $vs_tag_proc);
 							if((($t_element = ca_metadata_elements::getInstance($va_tmp[1])) && ($t_element->get('datatype') == 0))) {
								if (is_array($va_elements = $t_element->getElementsInSet())) {
									foreach($va_elements as $va_element) {
										if ($va_element['datatype'] > 0) {
											$va_form_elements[] = $va_tmp[0].'.'.$va_tmp[1].'.'.$va_element['element_code'];
										}
									}
								}
								break;
							}
						}
						if ($vs_tag_val) { $va_form_elements[] = $vs_tag_proc; }
						break;
				}
 			}
 			
 			$this->view->setVar("form", caFormTag($this->request, "Send", 'caContribute', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)));
 			$this->view->setVar("/form", $vs_script.caHTMLHiddenInput("_contributeFormName", array("value" => $ps_function)).caHTMLHiddenInput("_formElements", array("value" => join(';', $va_form_elements))).caHTMLHiddenInput("_contribute", array("value" => 1))."</form>");
 
 		
			$this->render($va_form_info['view']);
 		}
 		# ------------------------------------------------------
 		public function Send() {
 			global $g_ui_locale_id;
 			$ps_function = $this->request->getParameter('_contributeFormName', pString);
 			
 			if (!($va_form_info = $this->_checkForm($ps_function))) { return; }
 				
 			$this->view->setVar('t_subject', $t_subject = $this->pt_subject);
            
            $t_subject->clear();
            $t_subject->setMode(ACCESS_WRITE);
            $t_subject->purify(true); // run all input through HTMLpurifier
            
            $vs_subject_table = $t_subject->tableName();
            
            // check terms
            
            // check spam
            
            
            // Set content from form
            $va_fields = explode(';', $this->request->getParameter('_formElements', pString));
          	
          	// Assemble content tree
          	$va_content_tree = array();
          	foreach($va_fields as $vs_field) {
          		$va_fld_bits = explode(".", $vs_field);
          		$vs_field_proc = str_replace(".", "_", $vs_field);
          		
          		$vs_table = $va_fld_bits[0];
          		
          		$va_vals = $this->request->getParameter($vs_field_proc, pArray);
          		
          		if ($vs_subject_table == $vs_table) {	// subject table
          			switch(sizeof($va_fld_bits)) {
          				case 2:
          					if ($t_subject->hasField($va_fld_bits[1])) {		// intrinsic
          						$va_content_tree[$vs_subject_table][$va_fld_bits[1]] = $va_vals[0];
          					} elseif ($va_fld_bits[1] == 'preferred_labels') {	// preferred labels
          						
          					} elseif ($va_fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
          						
          					} elseif ($t_subject->hasElement($va_fld_bits[1])) {
          						
          					}
          					break;
          			}
          		}
          	}
          	print_r($va_content_tree); die;
          	// Insert into record
          	foreach($va_fields as $vs_field) {
          		$va_fld_bits = explode(".", $vs_field);
          		$vs_field_proc = str_replace(".", "_", $vs_field);
          		if ($va_fld_bits[0] == $vs_table) {
          			// Field in subject
          			$va_vals = $this->request->getParameter($vs_field_proc, pArray);
          			$vs_val = $va_vals[0];
          			print "val=$vs_val <br>";
          			switch(sizeof($va_fld_bits)) {
          				case 2:
          					if ($t_subject->hasField($va_fld_bits[1])) {		// intrinsic
          						$t_subject->set($va_fld_bits[1], $vs_val);
          					} elseif ($va_fld_bits[1] == 'preferred_labels') {	// preferred labels
          						$t_subject->addLabel(array($t_subject->getLabelDisplayField() => $vs_val), $g_ui_locale_id, null, true);
          					} elseif ($va_fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
          						$t_subject->addLabel(array($t_subject->getLabelDisplayField() => $vs_val), $g_ui_locale_id, null, false);
          					} elseif ($t_subject->hasElement($va_fld_bits[1])) {
          						$t_subject->addAttribute(array(
          							$va_fld_bits[1] =>	$this->request->getParameter($va_fld_bits[1], pString),
          							'locale_id' => $g_ui_locale_id
          						),	
          						$va_fld_bits[1]);
          					}
          					break;
          				case 3:
          					if ($va_fld_bits[1] == 'preferred_labels') {	// preferred labels
          						$t_subject->addLabel(array($va_fld_bits[2] => $vs_val), $g_ui_locale_id, null, true);
          					} elseif ($va_fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
          						$t_subject->addLabel(array($va_fld_bits[2] => $vs_val), $g_ui_locale_id, null, false);
          					} elseif ($t_subject->hasElement($va_fld_bits[1])) {
          						//$t_subject->addAttribute(array(
          						//	$va_fld_bits[2] =>	$this->request->getParameter($va_fld_bits[2], pString),
          						//	'locale_id' => $g_ui_locale_id
          						//),	
          						//$va_fld_bits[1]);	
          					}
          					break;
          			}
          		}
          	}
          	
          	// Set type from config if specified
            if ($va_form_info['type']) { $t_subject->set('type_id', $va_form_info['type']); }
            if ($va_form_info['access']) { $t_subject->set('access', $va_form_info['access']); }
            if ($va_form_info['status']) { $t_subject->set('status', $va_form_info['status']); }
            
            // insert
            $t_subject->insert();
            
            // errors?
            print_R($t_subject->getErrors());
            
            // redirect to thank you page
            
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		private function _checkForm($ps_function) {
 			if (!($va_form_info = caGetInfoForContributeFormType($ps_function))) {
 				// invalid advanced search type – throw error
 				die("Invalid contribute form type");
 			}
 			
 			if (!($this->pt_subject = $this->request->datamodel->getInstanceByTableName($va_form_info['table'], true))) {
 				die("Invalid contribute table setting");
 			}
 			
 			// Does form require login?
 			if ($va_form_info['require_login'] && !($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                return null;
            }
 			
 			return $va_form_info;
 		}
 		# -------------------------------------------------------
 	}