<?php
/* ----------------------------------------------------------------------
 * controllers/ContributeController.php
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
 
 	require_once(__CA_MODELS_DIR__.'/ca_metadata_elements.php');
	require_once(__CA_APP_DIR__."/helpers/contributeHelpers.php");
	require_once(__CA_LIB_DIR__."/Utils/DataMigrationUtils.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 
 	class ContributeController extends BasePawtucketController {
 		# -------------------------------------------------------
 		/**
 		 * Instance for record being contributed
 		 */
 		private $pt_subject = null;
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
            $this->config = caGetContributeFormConfig();
            if (!$this->config->get('enabled')) { 
            	$this->notification->addNotification(_t('Contribute form is not enabled'), __NOTIFICATION_TYPE_ERROR__);
				$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
				return;
            }
            
            if ($this->request->config->get('pawtucket_requires_login') && !($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
            }
            if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
            	print "You do not have access to view this page.";
            	die;
            }
 			caSetPageCSSClasses(array("contribute"));
 		}
 		# -------------------------------------------------------
 		/**
 		 * Generate form
 		 */
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			
 			if (!($va_form_info = $this->_checkForm($ps_function))) { return; }
 			
 			MetaTagManager::setWindowTitle(caGetOption('formTitle', $va_form_info, $this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contribute")));
 	
 			$this->view->setVar('t_subject', $t_subject = $this->pt_subject);
 			
 			$t_subject->set('type_id', $va_form_info['type']);
 			
 			$va_response_data = $this->view->getVar('response');
 			$va_form_data = caGetOption('formData', $va_response_data, null);
 			$va_tags = $this->view->getTagList($va_form_info['form_view']);
 			
 			// Format to wrap field-level error messages in
 			$vs_error_format = caGetOption('errorFormat', $va_form_info, '<div class="error">^ERRORS</div>');
 			
 			// Move errors for fields not in form to "general" errors list
 			if (is_array($va_response_data['errors']) && is_array($va_tags)) {
 				$va_tag_list = [];
 				foreach($va_tags as $vs_tag){ 
 					$va_tag_info = caParseTagOptions($vs_tag);
 					$va_tag_list[$va_tag_info['tag']] = true;
 				}
 				
 				if(!is_array($va_response_data['errors']['_general_'])) { $va_response_data['errors']['_general_'] = []; }
 				foreach($va_response_data['errors'] as $vs_field => $va_errors_for_field) {
 					if (!isset($va_tag_list[$vs_field])) { 
 						foreach($va_errors_for_field as $vn_i => $vs_error_for_field) {
 							$va_errors_for_field[$vn_i] = "<strong>".$t_subject->getDisplayLabel($vs_field)."</strong>: {$vs_error_for_field}";
 						}
 						$va_response_data['errors']['_general_'] = array_merge($va_response_data['errors']['_general_'], $va_errors_for_field);
 					}	
 				}
 			}
 			$this->view->setVar('errors', is_array($va_response_data['errors']['_general_']) ? join("; ", $va_response_data['errors']['_general_']) : "");
 			
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
		
		jQuery('.caContributeFormSubmit').bind('click', function(e) {
			jQuery('#ContributeForm').submit();
			return false;
		});
		jQuery('.caContributeFormReset').bind('click', function(e) {
			jQuery('#ContributeForm').find('input[type!=\"hidden\"],textarea').val('');
			jQuery('#ContributeForm').find('select.caContributeBoolean').val('AND');
			jQuery('#ContributeForm').find('select').prop('selectedIndex', 0);
			e.preventDefault();
			return false;
		});
	});
</script>\n";
 						break;
 					default:
 			
						if (preg_match("!^(.*):label$!", $vs_tag_proc, $va_matches)) {
							$this->view->setVar($vs_tag, $vs_tag_val = $t_subject->getDisplayLabel($va_matches[1]));
						} elseif (preg_match("!^(.*):error$!", $vs_tag_proc, $va_matches)) {
							if (is_array($va_response_data['errors'][$va_matches[1]]) && sizeof($va_response_data['errors'][$va_matches[1]])) {
								$vs_error_message = join("; ", $va_response_data['errors'][$va_matches[1]]);
								if ($vs_error_format) { $vs_error_message = str_replace("^ERRORS", $vs_error_message, $vs_error_format); }
								$this->view->setVar($vs_tag, $vs_error_message);
							}
						} else {
							if ($vs_tag_proc == 'errors') { break; } // skip general errors tag
							$va_opts['asArrayElement'] = true;
							$va_opts['IDNumberingConfig'] = $this->config;
							
							$va_vals = array();
							
							$va_tmp = explode('.', $vs_tag_proc);
 							if((($t_element = ca_metadata_elements::getInstance($va_tmp[1])) && ($t_element->get('datatype') == 0))) {
								if (is_array($va_elements = $t_element->getElementsInSet())) {
									foreach($va_elements as $va_element) {
										if ($va_element['datatype'] > 0) {
											$va_form_elements[] = $vs_subfld = $va_tmp[0].'.'.$va_tmp[1].'.'.$va_element['element_code'];
											if (is_array($va_form_data[$va_tmp[0].'.'.$va_tmp[1].'.'.$va_element['element_code']])) { $va_vals[$va_tmp[0].'.'.$va_tmp[1].'.'.$va_element['element_code']] = array_shift($va_form_data[$va_tmp[0].'.'.$va_tmp[1].'.'.$va_element['element_code']]); }
										}
									}
								}
							} else {
								if (is_array($va_form_data[$vs_tag_proc])) { $va_vals[$vs_tag_proc] = array_shift($va_form_data[$vs_tag_proc]); }
							}
							$va_opts['values'] = $va_vals;
							
							if ($vs_tag_val = $t_subject->htmlFormElementForSimpleForm($this->request, $vs_tag_proc, $va_opts)) {
								$this->view->setVar($vs_tag, $vs_tag_val);
							}
						}
						if ($vs_tag_val) { $va_form_elements[] = $vs_tag_proc; }
						break;
				}
 			}
 			
 			$this->view->setVar("form", caFormTag($this->request, "Send", 'ContributeForm', null, 'post', 'multipart/form-data', '_top', array('noTimestamp' => true, 'submitOnReturn' => true, 'disableUnsavedChangesWarning' => true)));
 			$this->view->setVar("/form", $vs_script.caHTMLHiddenInput("_contributeFormName", array("value" => $ps_function)).caHTMLHiddenInput("_formElements", array("value" => join(';', $va_form_elements))).caHTMLHiddenInput("_contribute", array("value" => 1))."</form>");
 
 			$this->view->setVar('spam_protection', caGetOption('spam_protection', $va_form_info, false) ? 1 : 0);
 			$this->view->setVar('terms_and_conditions', caGetOption('terms_and_conditions', $va_form_info, false));
 		
			$this->render($va_form_info['form_view']);
 		}
 		# ------------------------------------------------------
 		/**
 		 * Process form submission
 		 */
 		public function Send() {
 			global $g_ui_locale_id;
 			$ps_function = $this->request->getParameter('_contributeFormName', pString);
 			
 			$va_response_data = array('errors' => array(), 'numErrors' => 0, 'status' => 'OK');
 			$vn_num_errors = 0;
 			
 			if (!($va_form_info = $this->_checkForm($ps_function))) { return; }
 			$va_related_form_item_config = caGetOption('related', $va_form_info, array());
 				
 			$this->view->setVar('t_subject', $t_subject = $this->pt_subject);
 			$vs_idno_fld_name = $t_subject->getProperty('ID_NUMBERING_ID_FIELD');
            
            $t_subject->clear();
            $t_subject->setMode(ACCESS_WRITE);
            $t_subject->purify(true); // run all input through HTMLpurifier
            
 			$t_subject->setTransaction($o_trans = new Transaction());
            $vs_subject_table = $t_subject->tableName();
            
 			$t_subject->set('type_id', $va_form_info['type'] ?  $va_form_info['type'] : $this->request->getParameter('type_id', pInteger));	// set type so idno's reflect proper format
    		
    		// Set window title        
            MetaTagManager::setWindowTitle(caGetOption('formTitle', $va_form_info, $this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contribute")));
            
            // Get list of form elements to process
            $va_fields = explode(';', $this->request->getParameter('_formElements', pString));
            
            // Clean up field names, which PHP has mangled by replacing periods with underscores
			if (is_array($va_fields) && (sizeof($va_fields) > 0)) {
				foreach($va_fields as $vs_orig_fld_name) {
					$vs_orig_fld_name_proc = str_replace(".", "_", $vs_orig_fld_name);
					$_REQUEST[$vs_orig_fld_name] = $_REQUEST[$vs_orig_fld_name_proc];
					unset($_REQUEST[$vs_orig_fld_name_proc]);
				}
			}
            
            // Check terms
			if (caGetOption('terms_and_conditions', $va_form_info, false)) {
				// Check terms and conditions checkbox
				if ($this->request->getParameter('iAgreeToTerms', pInteger) != 1) {
					$this->notification->addNotification(_t("You must agree to the terms and conditions before proceeding."), __NOTIFICATION_TYPE_ERROR__);
				
					$va_response_data['numErrors'] = 1;
					$va_response_data['status'] = 'ERR';
					$va_response_data['errors']['_general_'][] = _t("You must agree to the terms and conditions before proceeding.");
					$va_response_data['formData'] = $_REQUEST;
					$this->view->setVar('response', $va_response_data);
					$t_subject->getTransaction()->rollback();
					
					call_user_method($ps_function, $this);
					return;
				}
			}            
            // Spam check
			if (caGetOption('spam_protection', $va_form_info, false)) {
				// Check SPAM-preventing security question
				if ($this->request->getParameter('security', pInteger) != $this->request->getParameter('sum', pInteger)) {
					$this->notification->addNotification(_t("Please correctly answer the security question."), __NOTIFICATION_TYPE_ERROR__);
					
					$va_response_data['numErrors'] = 1;
					$va_response_data['status'] = 'ERR';
					$va_response_data['errors']['_general_'][] = _t("Please correctly answer the security question.");
					$va_response_data['formData'] = $_REQUEST;
					$this->view->setVar('response', $va_response_data);
					$t_subject->getTransaction()->rollback();
					
					call_user_method($ps_function, $this);
					return;
				}
			}

            // Set content from form
          	$vm_type = $vs_idno = $vn_status = $vn_access = null;
          	$vb_has_media = false;
          	
          	// Assemble content tree
          	$va_content_tree = array();
          	foreach($va_fields as $vs_field) {
          		$va_fld_bits = explode(".", $vs_field);
          		$vs_field_proc = str_replace(".", "_", $vs_field);		// PHP replaces periods in names with underscores :-(
          		
          		$vs_table = $va_fld_bits[0];
          		
          		$va_vals = $this->request->getParameter($vs_field_proc, pArray);
          		
          		if ($vs_subject_table == $vs_table) {	// subject table
          			switch(sizeof($va_fld_bits)) {
          				case 2:
          				case 3:
          					if ($t_subject->hasField($va_fld_bits[1])) {		// intrinsic
          						$va_content_tree[$vs_subject_table][$va_fld_bits[1]] = $va_vals[0];
          						
          						switch($va_fld_bits[1]) {
          							case $t_subject->getTypeFieldName():
          								$vm_type = $va_vals[0];
          								break;
          							case $vs_idno_fld_name:
          								// parse out value
          								if (method_exists($t_subject, "loadIDNoPlugInInstance") && ($o_numbering_plugin = $t_subject->loadIDNoPlugInInstance(array('IDNumberingConfig' => $this->config)))) {
          									$vs_idno = $o_numbering_plugin->htmlFormValue($vs_idno_fld_name, null, true);
          								} else {
          									$vs_idno = $va_vals[0];
          								}
          								break;
          							case 'status':
          								$vn_status = (int)$va_vals[0];
          								break;
          							case 'access':
          								$vn_access = (int)$va_vals[0];
          								break;
          						}
          						
          					} elseif ($va_fld_bits[1] == 'preferred_labels') {	// preferred labels
          						if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $t_subject->getLabelDisplayField(); }
          						
          						foreach($va_vals as $vn_i => $vs_val) {
          							$va_content_tree[$vs_subject_table]['preferred_labels'][$vn_i][$va_fld_bits[2]] = $va_vals[$vn_i]; 
          						}
          					} elseif ($va_fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
          						if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $t_subject->getLabelDisplayField(); }
          						
          						foreach($va_vals as $vn_i => $vs_val) {
          							$va_content_tree[$vs_subject_table]['nonpreferred_labels'][$vn_i][$va_fld_bits[2]] = $va_vals[$vn_i]; 
          						}
          					} elseif ($t_subject->hasElement($va_fld_bits[1])) {
          						if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $va_fld_bits[1]; }
          						if (!is_array($va_vals)) { break; }
          						foreach($va_vals as $vn_i => $vs_val) {
          							$va_content_tree[$vs_subject_table][$va_fld_bits[1]][$vn_i][$va_fld_bits[2]] = $va_vals[$vn_i]; 
          						}
          					}
          					break;
          			}
          		} else {
          			// Process related
          			switch(sizeof($va_fld_bits)) {
          				case 2:
          				case 3:
          					if (($t_instance = Datamodel::getInstance($vs_table, true))) { 
								if ($t_instance->hasField($va_fld_bits[1])) {		// intrinsic
								
									if($t_instance->getFieldInfo($va_fld_bits[1], 'FIELD_TYPE') == FT_MEDIA) {
										$va_files = array();
										foreach($_FILES[$vs_field_proc]['tmp_name'] as $vn_index => $vs_tmp_name) {
											if (!trim($vs_tmp_name)) { continue; }
											$va_files[$vn_index] = array(
												'tmp_name' => $vs_tmp_name,
												'name' => $_FILES[$vs_field_proc]['name'][$vn_index],
												'type' => $_FILES[$vs_field_proc]['type'][$vn_index],
												'error' => $_FILES[$vs_field_proc]['error'][$vn_index],
												'size' => $_FILES[$vs_field_proc]['size'][$vn_index]
											);
										}
										foreach($va_files as $vn_index => $va_file) {
											$va_content_tree[$vs_table][$vn_index][$va_fld_bits[1]] = $va_file;
										}
									} else {
										foreach($va_vals as $vn_index => $vm_val) {
											$va_content_tree[$vs_table][$vn_index][$va_fld_bits[1]] = $vm_val;
										}
									}
								} elseif ($va_fld_bits[1] == 'preferred_labels') {	// preferred labels
									if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $t_instance->getLabelDisplayField(); }
								
									foreach($va_vals as $vn_i => $vs_val) {
										$va_content_tree[$vs_table][$vn_i]['preferred_labels'][$va_fld_bits[2]] = $va_vals[$vn_i]; 
									}
								} elseif ($va_fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
									if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $t_instance->getLabelDisplayField(); }
								
									foreach($va_vals as $vn_i => $vs_val) {
										$va_content_tree[$vs_table][$vn_i]['nonpreferred_labels'][$va_fld_bits[2]] = $va_vals[$vn_i]; 
									}
								} elseif ($t_instance->hasElement($va_fld_bits[1])) {
									if (!isset($va_fld_bits[2])) { $va_fld_bits[2] = $va_fld_bits[1]; }
									foreach($va_vals as $vn_i => $vs_val) {
										$va_content_tree[$vs_table][$vn_i][$va_fld_bits[1]][$va_fld_bits[2]] = $va_vals[$vn_i]; 
									}
								}
							}
							
							
							if (is_array($va_rel_types = $this->request->getParameter($vs_field_proc.'_relationship_type', pArray))) {
								foreach($va_rel_types as $vn_i => $vs_rel_type) {
									$va_content_tree[$vs_table][$vn_i]['_relationship_type'] = $vs_rel_type; 
								}
							}
							if (is_array($va_types = $this->request->getParameter($vs_field_proc.'_type', pArray))) {
								foreach($va_types as $vn_i => $vs_type) {
									$va_content_tree[$vs_table][$vn_i]['_type'] = $vs_type; 
								}
							}
							break;
						}
          		}	
          	}
          	
          	// Set type and idno (from config or tree) and insert
          	// 		Configured values are always used in preference
          	
          	foreach(array('type_id' => 'type', $vs_idno_fld_name => $vs_idno_fld_name, 'access' => 'access', 'status' => 'status') as $vs_fld => $vs_name) {
          		if ($vs_fld == $vs_idno_fld_name) {
          			$t_subject->setIdnoWithTemplate($va_form_info[$vs_idno_fld_name] ? $va_form_info[$vs_idno_fld_name] : $vs_idno, array('IDNumberingConfig' => $this->config));
          		} else {
					$vs_varname = "vs_{$vs_name}";
					$t_subject->set($vs_fld, $va_form_info[$vs_name] ? $va_form_info[$vs_name] : $$vs_varname);
				}
          		$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
            }
            
            if (isset($va_form_info['access'])) { $t_subject->set('access', $va_form_info['access']); }
            if (isset($va_form_info['status'])) { $t_subject->set('status', $va_form_info['status']); }
        
            // Insert
            $t_subject->insert();
            $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
          	
          	// Set other content
          	foreach($va_content_tree as $vs_table => $va_content_by_table) {
          		if ($vs_subject_table == $vs_table) {	// subject table
          			foreach($va_content_by_table as $vs_bundle => $va_data_for_bundle) {
          				switch($vs_bundle) {
          					case 'preferred_labels':
          						foreach($va_data_for_bundle as $va_data) {
          							$t_subject->addLabel($va_data, $g_ui_locale_id, null, true);
          							$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
          						}
          						break;
          					case 'nonpreferred_labels':
          						foreach($va_data_for_bundle as $va_data) {
          							$t_subject->addLabel($va_data, $g_ui_locale_id, null, false);
          							$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
          						}
          						break;
          					default:
          						if($t_subject->hasField($vs_bundle) && !in_array($vs_bundle, array('type_id', $vs_idno_fld_name, 'access', 'status'))) {
          							$t_subject->set($vs_bundle, $va_data_for_bundle[0]);
          						} elseif($t_subject->hasElement($vs_bundle)) {
          							foreach($va_data_for_bundle as $va_data) {
										$t_subject->addAttribute(
											array_merge($va_data, array('locale_id' => $g_ui_locale_id)), 
											$vs_bundle
										);
									}
          						}
          						
          						$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
          						break;
          				}
          			}
          		} else {
          			// Related table
          			switch($vs_table) {
          				case 'ca_object_representations':
          					$vb_is_primary = true;
          					foreach($va_content_by_table as $vn_index => $va_representation) {
          						if (!$va_representation['media']['tmp_name'] || ($va_representation['media']['size'] == 0)) { continue; }
          						if (isset($va_form_info['representation_type'])) { $va_representation['type_id']  = $va_form_info['representation_type']; }
          						if (isset($va_form_info['representation_access'])) { $va_representation['access']  = $va_form_info['representation_access']; }
          						if (isset($va_form_info['representation_status'])) { $va_representation['status']  = $va_form_info['representation_status']; }
          						$vn_rc = $t_subject->addRepresentation($va_representation['media']['tmp_name'], $va_representation['type_id'], $g_ui_locale_id, $va_representation['status'], $va_representation['access'], $vb_is_primary, $va_representation, array('original_filename' => $va_representation['media']['name']));
          						
          						if ($t_subject->numErrors()) {
          							$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 
								} else {
									$vb_has_media = true;
          							$vb_is_primary = false;
          						}
          					}
          					break;
          				case 'ca_entities':
          					$va_rel_config = caGetOption('ca_entities', $va_related_form_item_config, array());
          					foreach($va_content_by_table as $vn_index => $va_rel) {
          						foreach(array('idno', 'access', 'status') as $vs_f) { $va_rel[$vs_f] = $va_rel_config[$vs_f]; }
								if ($vn_rel_id = DataMigrationUtils::getEntityID(DataMigrationUtils::splitEntityName($va_rel['preferred_labels']['displayname']), $va_rel['_type'], $g_ui_locale_id, $va_rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($vs_rel_type = trim($va_rel['_relationship_type']))) { break; }
								
									$t_subject->addRelationship($vs_table, $vn_rel_id, $vs_rel_type);
								
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors);} 
								}
							}
          					break;
          				case 'ca_places':
          					$va_rel_config = caGetOption('ca_places', $va_related_form_item_config, array());
          					foreach($va_content_by_table as $vn_index => $va_rel) {
          						foreach(array('idno', 'access', 'status') as $vs_f) { $va_rel[$vs_f] = $va_rel_config[$vs_f]; }
								if ($vn_rel_id = DataMigrationUtils::getPlaceID($va_rel['preferred_labels']['name'], caGetOption('parent_id', $va_rel_config, null), $va_rel['_type'], $g_ui_locale_id, null, $va_rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($vs_rel_type = trim($va_rel['_relationship_type']))) { break; }
								
									$t_subject->addRelationship($vs_table, $vn_rel_id, $vs_rel_type);
								
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors);} 
								}
							}
          					break;
          				case 'ca_occurrences':
          					$va_rel_config = caGetOption('ca_occurrences', $va_related_form_item_config, array());
          					foreach($va_content_by_table as $vn_index => $va_rel) {
          						foreach(array('idno', 'access', 'status') as $vs_f) { $va_rel[$vs_f] = $va_rel_config[$vs_f]; }
								if ($vn_rel_id = DataMigrationUtils::getOccurrenceID($va_rel['preferred_labels']['name'], caGetOption('parent_id', $va_rel_config, null), $va_rel['_type'], $g_ui_locale_id, $va_rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($vs_rel_type = trim($va_rel['_relationship_type']))) { break; }
								
									$t_subject->addRelationship($vs_table, $vn_rel_id, $vs_rel_type);
								
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors);} 
								}
							}
          					break;
          				case 'ca_collections':
          					$va_rel_config = caGetOption('ca_collections', $va_related_form_item_config, array());
          					foreach($va_content_by_table as $vn_index => $va_rel) {
          						foreach(array('idno', 'access', 'status', 'parent_id') as $vs_f) { $va_rel[$vs_f] = $va_rel_config[$vs_f]; }
								if ($vn_rel_id = DataMigrationUtils::getCollectionID($va_rel['preferred_labels']['name'], $va_rel['_type'], $g_ui_locale_id, $va_rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($vs_rel_type = trim($va_rel['_relationship_type']))) { break; }
								
									$t_subject->addRelationship($vs_table, $vn_rel_id, $vs_rel_type);
								
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors);} 
								}
							}
          					break;
          				default:
          					// (noop for now)
          					break;
          			}
          		}
          	}
          	
          	$t_subject->update();
          	$this->_checkErrors($t_subject, $va_response_data, $vn_num_errors); 

			# references -> links to table that are embeded in form/ not created by the user
			# this is useful for cases where the contribute form is linked to from another record and you want to create a link to that record          	
          	if(($ps_ref_table = $this->request->getParameter('ref_table', pString)) && ($ps_ref_row_id = $this->request->getParameter('ref_row_id', pInteger))){
          		# --- look up if the relationship type is configured for this reference table
          		$va_ref_config = caGetOption('references', $va_form_info, array());
          		if($vs_rel_type = $va_ref_config[$ps_ref_table]){
          			$t_subject->addRelationship($ps_ref_table, $ps_ref_row_id, $vs_rel_type);
					if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $va_response_data, $vn_num_errors);} 
          		}
          	}
          	
            if($vn_num_errors > 0) {            
            	$va_response_data['numErrors'] = $vn_num_errors;
            	$va_response_data['status'] = 'ERR';
            	$va_response_data['formData'] = $_REQUEST;
            	$this->view->setVar('response', $va_response_data);
            	$t_subject->getTransaction()->rollback();
            	
            	$this->notification->addNotification(_t('There were errors in your submission. See below for details.'), __NOTIFICATION_TYPE_ERROR__);
            	
            	call_user_method($ps_function, $this);
            } else {
            	$t_subject->getTransaction()->commit();
            
            	if (caGetOption('set_post_submission_notification', $va_form_info, false)) {
            		$this->notification->addNotification(caGetOption($vb_has_media ? 'post_submission_notification_message_with_media' : 'post_submission_notification_message', $va_form_info, _t('Thank you!')), __NOTIFICATION_TYPE_INFO__);
            	}
            	if($vs_admin_email = $this->config->get('admin_notification_email')){	
            	 	# --- send admin email notification
 					$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
 					# -- generate email subject line from template
					$vs_subject_line = $o_view->render("mailTemplates/admin_contribute_subject.tpl");
						
					# -- generate mail text from template - get both the text and the html versions
					$vs_mail_message_text = $o_view->render("mailTemplates/admin_contribute_notification.tpl");
					$vs_mail_message_html = $o_view->render("mailTemplates/admin_contribute_notification_html.tpl");
					caSendmail($vs_admin_email, $this->request->config->get("ca_admin_email"), $vs_subject_line, $vs_mail_message_text, $vs_mail_message_html);
				}
            	// Redirect to "thank you" page. Options are:        
				#		splash = redirect to Pawtucket splash/front page
				#		url = redirect to Pawtucket url specified in post_submission_destination_url directive
				#		page = use result_html view to format direct response (no redirect)
				switch($va_form_info['post_submission_destination']) {
					case 'url':
						if (!is_array($va_form_info['post_submission_destination_url']) || !sizeof($va_form_info['post_submission_destination_url']) || !isset($va_form_info['post_submission_destination_url']['controller'])) {
							$this->notification->addNotification(_t('No destination url configured for form %1', $ps_function), __NOTIFICATION_TYPE_ERROR__);
							$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
							break;
						}
						$va_url = $va_form_info['post_submission_destination_url'];
						$this->response->setRedirect(caNavUrl($this->request, $va_url['module'], $va_url['controller'], $va_url['action']));
						break;
					case 'page':
						if (!isset($va_form_info['post_submission_view']) || !$va_form_info['post_submission_view']) {
							$this->notification->addNotification(_t('No destination view configured for form %1', $ps_function), __NOTIFICATION_TYPE_ERROR__);
							$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
							break;
						}
						$this->render($va_form_info['post_submission_view']);
						break;
					default:
					case 'front':
						$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
						break;
				}
            }
            
            return;
 		}
 		# -------------------------------------------------------
 		/**
 		 * Load configuration for the selected form
 		 *
 		 * @param string $ps_form The identifier of the form to load, as defined in contribute.conf
 		 * 
 		 * @return array An array containing configuration for the specified form, taken from contribute.conf, or null if the form is not defined.
 		 */
 		private function _checkForm($ps_form) {
 			if (!($va_form_info = caGetInfoForContributeFormType($ps_form))) {
 				// invalid form type (shouldn't happen unless misconfigured)
 				throw new ApplicationException("Invalid contribute form type");
 			}
 			
 			if (!($this->pt_subject = Datamodel::getInstance($va_form_info['table']))) {
 				// invalid form table (shouldn't happen unless misconfigured)
 				throw new ApplicationException("Invalid contribute table setting");
 			}
 			
 			// Does form require login?
 			if ($va_form_info['require_login'] && !($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                return null;
            }
 			
 			return $va_form_info;
 		}
 		
 		# -------------------------------------------------------
 		/**
 		 * Record errors posted in the subject instance for display in the form. Once processed errors are cleared from the subject.
 		 *
 		 * @param BundlableLabelableBaseModelWithAttributes $pt_subject
 		 * @param array $pa_response_data An array containing the JSON response for the form; errors should be inserted into this array for later display
 		 * @param int $pn_num_errors The error count
 		 *
 		 * @return int The number of errors processed 
 		 */
 		private function _checkErrors($pt_subject, &$pa_response_data, &$pn_num_errors) {
 			$vn_c = 0;
 			if ($pt_subject->numErrors()) { 
				foreach($pt_subject->errors as $o_error) {
					if(!($vs_source = $o_error->getErrorSource())) { $vs_source = '_general_'; }
					
					if (!is_array($pa_response_data['errors'][$vs_source])) { $pa_response_data['errors'][$vs_source] = array(); }
					if(!in_array($vs_error_desc = $o_error->getErrorDescription(), $pa_response_data['errors'][$vs_source])) {
						$pa_response_data['errors'][$vs_source][] = $vs_error_desc;
						$pn_num_errors++;
						$vn_c++;
					}
				}
				$pt_subject->clearErrors(); 
			}
			
			return $vn_c;
 		}
 		# -------------------------------------------------------
 	}