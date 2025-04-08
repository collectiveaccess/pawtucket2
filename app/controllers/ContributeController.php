<?php
/* ----------------------------------------------------------------------
 * controllers/ContributeController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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
	private $subject = null;
	
	/**
	 * List of statuses considered "final" – submissions with any of these statuses may not be edited by their submitters
	 */
	private $completed_status_list = null;
	
	/**
	 * List of tables for which forms may be generated
	 */
	static $tables = ['ca_objects', 'ca_entities', 'ca_places', 'ca_occurrences', 'ca_collections', 'ca_storage_locations', 'ca_object_lots', 'ca_object_representations', 'ca_loans', 'ca_movements'];
	
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $view_paths=null) {
		parent::__construct($po_request, $po_response, $view_paths);
		
		$this->config = caGetContributeFormConfig();
		if (!$this->config->get('enabled')) { 
			$this->notification->addNotification(_t('Contribute form is not enabled'), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
			return;
		}
		
		if ($this->request->config->get('pawtucket_requires_login') && !($this->request->isLoggedIn())) {
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
		}
		
		$this->completed_status_list = $this->config->get('completed_status');
		
		caSetPageCSSClasses(array("contribute"));
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function Index() {
		if (!$this->request->config->get('use_submission_interface')) {
			$this->notification->addNotification(_t('Not available'), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
			return;
		}
		# --- don't require login so can display intro text and link to login if not logged in on list page
		#if (!$this->request->isLoggedIn()) { 
		#	$this->notification->addNotification(_t('You are not logged in'), __NOTIFICATION_TYPE_ERROR__);
		#	$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
		#	return;
		#}
		$forms = $this->config->getAssoc('formTypes');
		#if (!$this->request->isLoggedIn()) { 
		#	$this->notification->addNotification(_t('No forms are configured'), __NOTIFICATION_TYPE_ERROR__);
		#	$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
		#	return;
		#}
		$submissions_by_form = [];
		foreach($forms as $form_code => $form_info) {
			$t = $form_info['table'];
			if (!Datamodel::getInstance($t, true)) { continue; }
			if (($qr = $t::find(['submission_user_id' => $this->request->getUserID(), 'submission_via_form' => $form_code], ['returnAs' => 'searchResult'])) && ($qr->numHits() > 0)) {
				$submissions_by_form[$form_code] = $qr;
			}
		}	
		$this->view->setVar('submissions_by_form', $submissions_by_form);
		$this->view->setVar('completed_status_list', $this->completed_status_list);
		$this->view->setVar('available_forms', $this->config->getAssoc('formTypes'));
		$this->view->setVar('introduction_global_value', $this->config->get("introduction_global_value"));
		
		$this->render("Contribute/list_html.php");
	}
	# -------------------------------------------------------
	/**
	 * Generate form
	 */
	public function __call($function, $args) {
		$function = strtolower($function);
		
		if (!($form_info = $this->_checkForm($function))) { return; }
		
		MetaTagManager::setWindowTitle(caGetOption('formTitle', $form_info, $this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contribute")));

		$this->view->setVar('t_subject', $t_subject = $this->subject);
		$this->view->setVar('form_info', $form_info);
		
		if (isset($form_info['type']) && $form_info['type']) {
			$t_subject->set('type_id', $form_info['type']);
		}
		
		$response_data = $this->view->getVar('response');
		$form_data = caGetOption('formData', $response_data, null);
		$tags = $this->view->getTagList($form_info['form_view']);
		
		// Format to wrap field-level error messages in
		$error_format = caGetOption('errorFormat', $form_info, '<div class="error">^ERRORS</div>');
		
		// Move errors for fields not in form to "general" errors list
		if (is_array($response_data['errors']) && is_array($tags)) {
			$tag_list = [];
			foreach($tags as $tag){ 
				$tag_info = caParseTagOptions($tag);
				$tag_list[$tag_info['tag']] = true;
			}
			
			if(!is_array($response_data['errors']['_general_'])) { $response_data['errors']['_general_'] = []; }
			foreach($response_data['errors'] as $field => $errors_for_field) {
				if (!isset($tag_list[$field])) { 
					foreach($errors_for_field as $vn_i => $error_for_field) {
						$errors_for_field[$vn_i] = "<strong>".$t_subject->getDisplayLabel($field)."</strong>: {$error_for_field}";
					}
					$response_data['errors']['_general_'] = array_merge($response_data['errors']['_general_'], $errors_for_field);
				}	
			}
		}
		$this->view->setVar('errors', is_array($response_data['errors']['_general_']) ? join("; ", $response_data['errors']['_general_']) : "");
	
		$this->view->setVar('id', $t_subject->getPrimaryKey());	// set the primary key of the currently loaded record; will be null for new records
	
		$form_elements = $form_element_tags = [];
		
		$tag_counts = [];
		$default_form_values = [];
		foreach($tags as $c => $tag) {
			if(strpos($tag, "^")) { // process any display templates in the context of the currently loaded record
				$this->view->setVar($tag, $t_subject->getWithTemplate($tag, ['filterNonPrimaryRepresentations' => false]));	// pull all media if that's what we're pulling; filterNonPrimaryRepresentations ignored for non-media
				continue; 
			}
			if(in_array($tag, array('form', '/form', 'submit', 'reset', 'id'))) { continue; }
			$parse = caParseTagOptions($tag);
			$tag_proc = $parse['tag'];
			$opts = $parse['options'];
			
			$xproc = array_filter(array_map(function($v) use ($opts) {
				if(in_array($v, ['restrictToTypes', 'restrictToRelationshipTypes', 'limitToItemsWithID', 'type'])) { return $opts[$v]; }
				return null;
			}, array_keys($opts)), 'strlen');
			$tag_proc_with_opts = $tag_proc.'%'.join('&', $xproc);

			if (isset($opts['limitToItemsWithID'])) { $opts['limitToItemsWithID'] = preg_split("![,;]+!", $opts['limitToItemsWithID']); } 				
			if (isset($opts['restrictToTypes'])) { $opts['restrictToTypes'] = preg_split("![,;]+!", $opts['restrictToTypes']); }
			if (isset($opts['restrictToRelationshipTypes'])) { $opts['restrictToRelationshipTypes'] = preg_split("![,;]+!", $opts['restrictToRelationshipTypes']); }		
			
			if (($default_value = caGetOption('default', $opts, null)) || ($default_value = caGetOption($tag_proc, $default_form_values, null))) { 
				$default_form_values[$tag_proc] = $default_value;
				unset($opts['default']);
			} 
		
			$tag_val = null;
			switch(strtolower($tag_proc)) {
				case 'submit':
					$this->view->setVar($tag, "<button class='caContributeFormSubmit ".((isset($opts['class']) && $opts['class']) ? $opts['class'] : '')."' hx-on:click='htmx.find(\"#ContributeForm\").submit();'>".((isset($opts['label']) && $opts['label']) ? $opts['label'] : _t('Submit'))."</button>");
					break;
				case 'reset':
					$this->view->setVar($tag, "<button class='caContributeFormReset ".((isset($opts['class']) && $opts['class']) ? $opts['class'] : '')."' type='button' hx-on:click='contributeFormReset(); return false;'>".((isset($opts['label']) && $opts['label']) ? $opts['label'] : _t('Reset'))."</button>");
		
					$script = "<script type='text/javascript'>
	let f, defaultValues = ".json_encode($default_form_values).", defaultBooleans = ".json_encode($default_form_booleans).";

	 htmx.onLoad(function(elt) {	
	 	// Set default values
		for (f in defaultValues) {
			var f_proc = f.replace(/\./, '_') + '[]';
			const elems  = htmx.findAll('input[name=\"' + f_proc+ '\"], textarea[name=\"' + f_proc+ '\"], select[name=\"' + f_proc+ '\"]');
			
			if(elems) {
				for(let i in elems) {
					if((elems[i].value.length == 0) && defaultValues[f] && defaultValues[f].length) { 
						elems[i].value = defaultValues[f];
					}
				}
			}
		}
	 });
	 
	 function contributeFormReset() {
	 	const textElems = htmx.findAll('input[type=\"text\"],textarea');
	 	const selectElems = htmx.findAll('select');
	 	const boolElems = htmx.findAll('elect.caContributeBoolean');
	 	for(let i in textElems) {
	 		if(!textElems[i].getAttribute) { continue; }
	 		textElems[i].value = '';
	 	}
	 	for(let i in selectElems) {
	 		if(!selectElems[i].getAttribute) { continue; }
	 		selectElems[i].selectedIndex = 0;
	 	}
	 	for(let i in boolElems) {
	 		if(!boolElems[i].getAttribute) { continue; }
	 		textElboolElemsems[i].value = 'AND';
	 	}
	 };
</script>\n";
					break;
				default:
		
					$rel_type = null;
					if (preg_match("!^(.*):label$!", $tag_proc, $matches)) {
						$this->view->setVar($tag, $tag_val = $t_subject->getDisplayLabel($matches[1]));
					} elseif (preg_match("!^(.*):error$!", $tag_proc, $matches)) {
						if (is_array($response_data['errors'][$matches[1]]) && sizeof($response_data['errors'][$matches[1]])) {
							$error_message = join("; ", $response_data['errors'][$matches[1]]);
							if ($error_format) { $error_message = str_replace("^ERRORS", $error_message, $error_format); }
							$this->view->setVar($tag, $error_message);
						}
					} else {
						if ($tag_proc == 'errors') { break; } // skip general errors tag
						$opts['asArrayElement'] = true;
						$opts['IDNumberingConfig'] = $this->config;
						$opts['useCurrentRowValueAsDefault'] = true;
						
						$vals = [];
						$tmp = explode('.', $tag_proc);
						
						if (caGetOption('previewExistingValues', $opts, false) && ($preview = $t_subject->get($tag_proc, ['delimiter' => caGetOption('delimiter', $opts, ' ')]))) {
							$this->view->setVar($tag, $preview);
							break;
						}
						
						if((($t_element = ca_metadata_elements::getInstance($tmp[1])) && ($t_element->get('datatype') == 0))) {
							if (is_array($elements = $t_element->getElementsInSet())) {
								foreach($elements as $element) {
									if ($element['datatype'] > 0) {
										$form_elements[] = $subfld = $tmp[0].'.'.$tmp[1].'.'.$element['element_code'];
										$form_element_tags[] = $tag;
										if (is_array($form_data[$tmp[0].'.'.$tmp[1].'.'.$element['element_code']])) { $vals[$tmp[0].'.'.$tmp[1].'.'.$element['element_code']] = array_shift($form_data[$tmp[0].'.'.$tmp[1].'.'.$element['element_code']]); }
									}
								}
							}
						} else {	// intrinsic
							if (is_array($form_data[$tag_proc])) { $vals[$tag_proc] = array_shift($form_data[$tag_proc]); }
						}
						$opts['values'] = $vals;
						if (!isset($tag_counts[$tag_proc])) { $tag_counts[$tag_proc] = 0; }
						if (!isset($tag_counts[$tag_proc_with_opts])) { $tag_counts[$tag_proc_with_opts] = 0; }
						
						
						if ($rel_type = caGetOption('relationshipType', $opts, null)) {
							$opts['restrictToRelationshipTypes'] = [$rel_type];
						}
						$opts['noJQuery'] = true;
						if ($tag_val = $t_subject->htmlFormElementForSimpleForm($this->request, $tag_proc, array_merge($opts, caGetOption('multiple', $opts, null) ? [] : ['index' => $tag_counts[$tag_proc], 'valueIndex' => $tag_counts[$tag_proc_with_opts]]))) {
							$this->view->setVar($tag, $tag_val);
							$tag_counts[$tag_proc]++;
							$tag_counts[$tag_proc_with_opts]++;
						}
					}
					if ($tag_val) { $form_elements[] = $tag_proc; $form_element_tags[] = $tag; }
					break;
			}
		}
		
		$this->view->setVar("form", caFormTag($this->request, "Send", 'ContributeForm', null, 'post', 'multipart/form-data', '_top', array('noTimestamp' => true, 'submitOnReturn' => false, 'disableUnsavedChangesWarning' => true)));
		$this->view->setVar("/form", $script.caHTMLHiddenInput("_contributeFormName", array("value" => $function)).caHTMLHiddenInput("_formElements", array("value" => join(';', $form_elements))).caHTMLHiddenInput("_formElementTags", array("value" => join(';', $form_element_tags))).caHTMLHiddenInput("_contribute", array("value" => 1)).caHTMLHiddenInput("id", array("value" => $t_subject->getPrimaryKey()))."</form>");

		$this->view->setVar('spam_protection', caGetOption('spam_protection', $form_info, false) ? 1 : 0);
		$this->view->setVar('terms_and_conditions', caGetOption('terms_and_conditions', $form_info, false));
	
		$this->render($form_info['form_view']);
	}
	# ------------------------------------------------------
	/**
	 * Process form submission
	 */
	public function Send() {
		global $g_ui_locale;
		$function = $this->request->getParameter('_contributeFormName', pString);
		
		$response_data = array('errors' => array(), 'numErrors' => 0, 'status' => 'OK');
		$vn_num_errors = 0;
		
		if (!($form_info = $this->_checkForm($function))) { return; }
		$related_form_item_config = caGetOption('related', $form_info, array());
		
		if(!($locale = caGetOption('alwaysUseLocale', $form_info, $g_ui_locale))) { $locale = __CA_DEFAULT_LOCALE__; }
		$locale_id = ca_locales::codeToID($locale);
			
		$this->view->setVar('t_subject', $t_subject = $this->subject);
		$idno_fld_name = $t_subject->getProperty('ID_NUMBERING_ID_FIELD');
		
		$t_subject->purify(true); // run all input through HTMLpurifier
		
		$o_trans = new Transaction();
		$t_subject->setTransaction($o_trans);
		$subject_table = $t_subject->tableName();
	  
		$t_subject->set('type_id', ($form_info['type'] ? $form_info['type'] : $this->request->getParameter("{$subject_table}_type_id", pInteger)), ['allowSettingOfTypeID' => true]);	// set type so idno's reflect proper format
		
		// Set window title        
		MetaTagManager::setWindowTitle(caGetOption('formTitle', $form_info, $this->request->config->get("app_display_name").$this->request->config->get("page_title_delimiter")._t("Contribute")));
		
		// Get list of form elements to process
		$fields = explode(';', $this->request->getParameter('_formElements', pString));
		$field_tags = explode(';', $this->request->getParameter('_formElementTags', pString));
		
		// Clean up field names, which PHP has mangled by replacing periods with underscores
		if (is_array($fields) && (sizeof($fields) > 0)) {
			foreach($fields as $orig_fld_name) {
				$orig_fld_name_proc = str_replace(".", "_", $orig_fld_name);
				$_REQUEST[$orig_fld_name] = $_REQUEST[$orig_fld_name_proc];
				unset($_REQUEST[$orig_fld_name_proc]);
			}
		}
		
		// Check terms
		if (caGetOption('terms_and_conditions', $form_info, false) && !$this->request->isLoggedIn()) {
			// Check terms and conditions checkbox
			if ($this->request->getParameter('iAgreeToTerms', pInteger) != 1) {
				$this->notification->addNotification(_t("You must agree to the terms and conditions before proceeding."), __NOTIFICATION_TYPE_ERROR__);
			
				$response_data['numErrors'] = 1;
				$response_data['status'] = 'ERR';
				$response_data['errors']['_general_'][] = _t("You must agree to the terms and conditions before proceeding.");
				$response_data['formData'] = $_REQUEST;
				$this->view->setVar('response', $response_data);
				$t_subject->getTransaction()->rollback();
				
				call_user_func_array(array($this, $function), []);
				return;
			}
		}            
		// Spam check
		if (caGetOption('spam_protection', $form_info, false) && !$this->request->isLoggedIn()) {
			// Check SPAM-preventing security question
			if ($this->request->getParameter('security', pInteger) != $this->request->getParameter('sum', pInteger)) {
				$this->notification->addNotification(_t("Please correctly answer the security question."), __NOTIFICATION_TYPE_ERROR__);
				
				$response_data['numErrors'] = 1;
				$response_data['status'] = 'ERR';
				$response_data['errors']['_general_'][] = _t("Please correctly answer the security question.");
				$response_data['formData'] = $_REQUEST;
				$this->view->setVar('response', $response_data);
				$t_subject->getTransaction()->rollback();
				
				call_user_func_array(array($this, $function), []);
				return;
			}
		}

		// Set content from form
		$vm_type = $idno = $vn_status = $vn_access = null;
		$has_media = false;
		
		$text_delimiters = caGetOption('text_delimiters', $form_info, []);
		$required_list = caGetOption('required', $form_info, []);
		
		// Assemble content tree
		$content_tree = [];
		foreach($fields as $fi => $field) {
			$fld_bits = explode(".", $field);
			$field_proc = str_replace(".", "_", $field);		// PHP replaces periods in names with underscores :-(
			
			$fld_tag_parsed = caParseTagOptions($field_tags[$fi]);
			$fld_tag_opts = $fld_tag_parsed['options'];
			
			$is_required = in_array($field, $required_list, true);
			
			$table = $fld_bits[0];
			if ($field_proc == "{$subject_table}_type_id") { continue; }
			$vals = $this->request->getParameter($field_proc, pArray);
			if (($subject_table == $table) && ($fld_bits[1] !== 'related')) {	// subject table
				switch(sizeof($fld_bits)) {
					case 2:
					case 3:
						if ($t_subject->hasField($fld_bits[1])) {		// intrinsic
							$content_tree[$subject_table][$fld_bits[1]] = $vals[0];
							
							switch($fld_bits[1]) {
								case $t_subject->getTypeFieldName():
									$vm_type = $vals[0];
									break;
								case $idno_fld_name:
									// parse out value
									if (method_exists($t_subject, "loadIDNoPlugInInstance") && ($o_numbering_plugin = $t_subject->loadIDNoPlugInInstance(array('IDNumberingConfig' => $this->config)))) {
										$idno = $o_numbering_plugin->htmlFormValue($idno_fld_name, null, true);
									} else {
										$idno = $vals[0];
									}
									break;
								case 'status':
									$vn_status = (int)$vals[0];
									break;
								case 'access':
									$vn_access = (int)$vals[0];
									break;
							}
							
						} elseif ($fld_bits[1] == 'preferred_labels') {	// preferred labels
							if (!isset($fld_bits[2])) { $fld_bits[2] = $t_subject->getLabelDisplayField(); }
							
							foreach($vals as $vn_i => $val) {
								if (!strlen($vals[$vn_i])) { continue; }
								$content_tree[$subject_table]['preferred_labels'][$vn_i][$fld_bits[2]] = $vals[$vn_i]; 
							}
						} elseif ($fld_bits[1] == 'nonpreferred_labels') {	// preferred labels
							if (!isset($fld_bits[2])) { $fld_bits[2] = $t_subject->getLabelDisplayField(); }
							
							foreach($vals as $vn_i => $val) {
								 if (!strlen($vals[$vn_i])) { continue; }
								$content_tree[$subject_table]['nonpreferred_labels'][$vn_i][$fld_bits[2]] = $vals[$vn_i]; 
							}
						} elseif ($t_subject->hasElement($fld_bits[1])) {
							if (!isset($fld_bits[2])) { $fld_bits[2] = $fld_bits[1]; }
							
							if(in_array(ca_metadata_elements::getDataTypeForElementCode($fld_bits[2]), [__CA_ATTRIBUTE_VALUE_MEDIA__, __CA_ATTRIBUTE_VALUE_FILE__], true)) {
								$vals = $_FILES[$field_proc]['tmp_name'] ?? null;
							}
							
							if (!is_array($vals)) { break; }
						
							$vals = self::_applyTextDelimiters($vals, $fld_tag_opts, $text_delimiters);
					
							foreach($vals as $vn_i => $val) {
								if(strlen($val) === 0) { continue; }
								$content_tree[$subject_table][$fld_bits[1]][$vn_i][$fld_bits[2]] = $vals[$vn_i]; 
							}
						}
						break;
				}
			} else {
				// Process related
				switch(sizeof($fld_bits)) {
					case 1:
					case 2:
					case 3:
						if (($t_instance = Datamodel::getInstance($table, true))) { 
							if ($subject_table == $table) { $table = "{$table}.related"; }
							if ($t_instance->hasField($fld_bits[1])) {		// intrinsic
							
								if($t_instance->getFieldInfo($fld_bits[1], 'FIELD_TYPE') == FT_MEDIA) {
									$files = array();
									if(is_array($_FILES[$field_proc]['tmp_name'])) {
										foreach($_FILES[$field_proc]['tmp_name'] as $vn_index => $tmp_name) {
											if (!trim($tmp_name)) { continue; }
											$files[$vn_index] = array(
												'tmp_name' => $tmp_name,
												'name' => $_FILES[$field_proc]['name'][$vn_index],
												'type' => $_FILES[$field_proc]['type'][$vn_index],
												'error' => $_FILES[$field_proc]['error'][$vn_index],
												'size' => $_FILES[$field_proc]['size'][$vn_index]
											);
										}
										foreach($files as $vn_index => $file) {
											$content_tree[$table][$vn_index][$fld_bits[1]] = $file;
										}
									}
								} else {
									foreach($vals as $vn_index => $vm_val) {
									if (!strlen($vm_val)) { continue; }
										$content_tree[$table][$vn_index][$fld_bits[1]] = $vm_val;
									}
								}
							} elseif ($fld_bits[1] == 'preferred_labels') {	// preferred labels
								if (!isset($fld_bits[2])) { $fld_bits[2] = $t_instance->getLabelDisplayField(); }
							
								foreach($vals as $vn_i => $val) {
									if (!strlen($vals[$vn_i])) { continue; }
									$content_tree[$table][$vn_i]['preferred_labels'][$fld_bits[2]] = $vals[$vn_i]; 
								}
							} elseif ($fld_bits[1] == 'nonpreferred_labels') {	// nonpreferred labels
								if (!strlen($vals[$vn_i])) { break; }
								if (!isset($fld_bits[2])) { $fld_bits[2] = $t_instance->getLabelDisplayField(); }
							
								foreach($vals as $vn_i => $val) {
									if (!strlen($vals[$vn_i])) { continue; }
									$content_tree[$table][$vn_i]['nonpreferred_labels'][$fld_bits[2]] = $vals[$vn_i]; 
								}
							} elseif ($t_instance->hasElement($fld_bits[1])) {
								if (!strlen($vals[$vn_i])) { break; }
								if (!isset($fld_bits[2])) { $fld_bits[2] = $fld_bits[1]; }
								
								$vals = self::_applyTextDelimiters($vals, $fld_tag_opts, $text_delimiters);
								foreach($vals as $vn_i => $val) {
									if (!strlen($vals[$vn_i])) { continue; }
									$content_tree[$table][$vn_i][$fld_bits[1]][$fld_bits[2]] = $vals[$vn_i]; 
								}
							} else {
								foreach($vals as $vn_i => $val) {
									if (!strlen($vals[$vn_i])) { continue; }
									$content_tree[$table][$vn_i][$t_instance->primaryKey()] = $vals[$vn_i];
								}
							}
						}
						
						if (is_array($rel_types = $this->request->getParameter($field_proc.'_relationship_type', pArray))) {
							foreach($rel_types as $vn_i => $rel_type) {
								if (!strlen($vals[$vn_i])) { continue; }
								$content_tree[$table][$vn_i]['_relationship_type'] = $rel_type; 
							}
						}
						if (is_array($types = $this->request->getParameter($field_proc.'_type', pArray))) {
							foreach($types as $vn_i => $type) {
									if (!strlen($vals[$vn_i])) { continue; }
								$content_tree[$table][$vn_i]['_type'] = $type; 
							}
						}
						break;
					}
			}	
		}
		
		// Set type and idno (from config or tree) and insert
		// 		Configured values are always used in preference
		foreach(array($idno_fld_name => $idno_fld_name, 'access' => 'access', 'status' => 'status') as $fld => $name) {
			if ($fld == $idno_fld_name) {
				$t_subject->setIdnoWithTemplate($form_info[$idno_fld_name] ? $form_info[$idno_fld_name] : $idno, array('IDNumberingConfig' => $this->config));
			} else {
				$varname = "vs_{$name}";
				$t_subject->set($fld, $form_info[$name] ? $form_info[$name] : $$varname);
			}
			$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 
		}
		
		if (isset($form_info['access'])) { $t_subject->set('access', $form_info['access']); }
		if (isset($form_info['status'])) { $t_subject->set('status', $form_info['status']); }
	
		// Set submission origination
		$submission_values = [];
		if ($this->request->isLoggedIn()) {
			$t_subject->set('submission_user_id', $submission_values['submission_user_id'] = $this->request->getUserID());
			$t_subject->set('submission_via_form', $submission_values['submission_via_form'] = $function);
			
			if (is_array($groups = $this->request->user->getUserGroups()) && sizeof($groups)) {
				$group = array_shift(array_values($groups));
				$t_subject->set('submission_group_id', $submission_values['submission_group_id'] = $group['group_id']);
			}
			$t_subject->set('submission_status_id', $submission_values['submission_status_id'] = $this->config->get('initial_status'));
			
		}
		
		if ($t_subject->getPrimaryKey()) {
			$t_subject->update();
		} else {
			$t_subject->insert();
		}
		$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 

		// Set other content
		$cleared_rels = [];
		
		// check required fields
		foreach($required_list as $r) {
			$tmp = explode('.', $r);
			if(sizeof($tmp) <= 2) { $tmp[2] = $tmp[1]; }
			$b = $content_tree[$tmp[0]][$tmp[1]] ?? [];
			$fld = array_pop($tmp);
			$bx = array_filter($b, function($v) use ($fld) {
				if(!is_array($v) || !sizeof($v)) { return false; }
				if(!isset($v[$fld]) || !strlen($v[$fld])) { return false; }
				return true;
			});
			if(!sizeof($bx)) {
				$l = $r;
				if($t = Datamodel::getInstance($tmp[0], true)) { $l = $t->getDisplayLabel($r); }
				$response_data['errors'][$r][] = _t('%1 must be set', trim($l));
				$vn_num_errors++;
			}
		}
		
		foreach($content_tree as $table => $content_by_table) {
			if ($subject_table == $table) {	// subject table
				foreach($content_by_table as $bundle => $data_for_bundle) {
					switch($bundle) {
						case 'preferred_labels':
							foreach($data_for_bundle as $data) {
								$t_subject->replaceLabel($data, $locale_id, null, true);
								$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 
							}
							break;
						case 'nonpreferred_labels':
							foreach($data_for_bundle as $data) {
								$t_subject->replaceLabel($data, $locale_id, null, false);
								$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 
							}
							break;
						default:
							if($t_subject->hasField($bundle) && !in_array($bundle, array('type_id', $idno_fld_name, 'access', 'status'))) {
								$t_subject->set($bundle, $data_for_bundle[0]);
							} elseif($t_subject->hasElement($bundle)) {
								$t_subject->removeAttributes($bundle);
								$i =0;
								foreach($data_for_bundle as $data) {
									if ($i == 0) {
										$t_subject->replaceAttribute(
											array_merge($data, array('locale_id' => $locale_id)), 
											$bundle
										);
									} else {
										$t_subject->addAttribute(
											array_merge($data, array('locale_id' => $locale_id)), 
											$bundle
										);
									}
									$i++;
								}
							}
							
							$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 
							break;
					}
				}
			} else {
				// Related table
				$rel_tmp = explode(".", $table);
				if (sizeof($rel_tmp) > 1) { $table = $rel_tmp[0]; }
				if(!isset($cleared_rels[$table])) {
					$t_subject->removeRelationships($table);
					$cleared_rels[$table] = true;
				}
				
				switch($table) {
					case 'ca_object_representations':
						$is_primary = true;
						foreach($content_by_table as $vn_index => $representation) {
							if (!$representation['media']['tmp_name'] || ($representation['media']['size'] == 0)) { continue; }
							if (isset($form_info['representation_type'])) { $representation['type_id']  = $form_info['representation_type']; }
							if (isset($form_info['representation_access'])) { $representation['access']  = $form_info['representation_access']; }
							if (isset($form_info['representation_status'])) { $representation['status']  = $form_info['representation_status']; }
							$vn_rc = $t_subject->addRepresentation($representation['media']['tmp_name'], $representation['type_id'], $locale_id, $representation['status'], $representation['access'], $is_primary, $representation, array('original_filename' => $representation['media']['name']));
							
							if ($t_subject->numErrors()) {
								$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 
							} else {
								$has_media = true;
								$is_primary = false;
							}
						}
						break;
					case 'ca_objects':
						$rel_config = caGetOption('ca_objects', $related_form_item_config, array());
						foreach($content_by_table as $vn_index => $rel) {
							if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
							$rel = array_merge($rel, $submission_values);
							if(isset($rel['object_id']) && ((int)$rel['object_id'] > 0) && ca_objects::find(['object_id' => $rel['object_id']])) {
									$t_subject->addRelationship($table, (int)$rel['object_id'], $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
							} else {
								if(isset($rel['object_id']) && !is_numeric($rel['object_id']) && !$rel['preferred_labels']['name']) {
									$rel['preferred_labels']['name'] = $rel['object_id'];
								}
								foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
								if (!$rel['preferred_labels']['name']) { continue; }
								if ($vn_rel_id = DataMigrationUtils::getObjectID($rel['preferred_labels']['name'], $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
									$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
								}
							}
						}
						break;
					case 'ca_entities':
						$rel_config = caGetOption('ca_entities', $related_form_item_config, array());
						foreach($content_by_table as $vn_index => $rel) {
							if (!($rel_type = trim($rel['_relationship_type']))) { break; }
			
							$rel = array_merge($rel, $submission_values);
							if(isset($rel['entity_id']) && ((int)$rel['entity_id'] > 0) && ca_entities::find(['entity_id' => $rel['entity_id']])) {
									$t_subject->addRelationship($table, (int)$rel['entity_id'], $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
							} else {
								if(isset($rel['entity_id']) && !is_numeric($rel['entity_id']) && !$rel['preferred_labels']['displayname']) {
									$rel['preferred_labels']['displayname'] = $rel['entity_id'];
								}
								foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
								if (!$rel['preferred_labels']['displayname']) { continue; }
								if ($vn_rel_id = DataMigrationUtils::getEntityID(DataMigrationUtils::splitEntityName($rel['preferred_labels']['displayname']), $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
								}
							}
						}
						break;
					case 'ca_places':
						$rel_config = caGetOption('ca_places', $related_form_item_config, array());
						foreach($content_by_table as $vn_index => $rel) {
							
							$rel = array_merge($rel, $submission_values);
							foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
							if ($vn_rel_id = DataMigrationUtils::getPlaceID($rel['preferred_labels']['name'], caGetOption('parent_id', $rel_config, null), $rel['_type'], $locale_id, null, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
								if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
								$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
								if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
							} else {
								if(isset($rel['place_id']) && !is_numeric($rel['place_id']) && !$rel['preferred_labels']['name']) {
									$rel['preferred_labels']['name'] = $rel['place_id'];
								}
								foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
								if (!$rel['preferred_labels']['name']) { continue; }
								if ($vn_rel_id = DataMigrationUtils::getPlaceID($rel['preferred_labels']['name'], $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
									$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
								}
							}
						}
						break;
					case 'ca_occurrences':
						$rel_config = caGetOption('ca_occurrences', $related_form_item_config, array());
						foreach($content_by_table as $vn_index => $rel) {
							
							$rel = array_merge($rel, $submission_values);
							foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
							if ($vn_rel_id = DataMigrationUtils::getOccurrenceID($rel['preferred_labels']['name'], caGetOption('parent_id', $rel_config, null), $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
								if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
								$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
								if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
							} else {
								if(isset($rel['occurrence_id']) && !is_numeric($rel['occurrence_id']) && !$rel['preferred_labels']['name']) {
									$rel['preferred_labels']['name'] = $rel['occurrence_id'];
								}
								foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
								if (!$rel['preferred_labels']['name']) { continue; }
								if ($vn_rel_id = DataMigrationUtils::getOccurrenceID($rel['preferred_labels']['name'], $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
									$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
								}
							}
						}
						break;
					case 'ca_collections':
						$rel_config = caGetOption('ca_collections', $related_form_item_config, array());
						foreach($content_by_table as $vn_index => $rel) {
							
							$rel = array_merge($rel, $submission_values);
							foreach(array('idno', 'access', 'status', 'parent_id') as $f) { $rel[$f] = $rel_config[$f]; }
							if ($vn_rel_id = DataMigrationUtils::getCollectionID($rel['preferred_labels']['name'], $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
								if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
								$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
								if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
							} else {
								if(isset($rel['collection_id']) && !is_numeric($rel['collection_id']) && !$rel['preferred_labels']['name']) {
									$rel['preferred_labels']['name'] = $rel['collection_id'];
								}
								foreach(array('idno', 'access', 'status') as $f) { $rel[$f] = $rel_config[$f]; }
								if (!$rel['preferred_labels']['name']) { continue; }
								if ($vn_rel_id = DataMigrationUtils::getCollectionID($rel['preferred_labels']['name'], $rel['_type'], $locale_id, $rel, array('transaction' => $o_trans, 'matchOn' => array('label'), 'IDNumberingConfig' => $this->config))) {
									if (!($rel_type = trim($rel['_relationship_type']))) { break; }
							
									$t_subject->addRelationship($table, $vn_rel_id, $rel_type);
							
									if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
								}
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
		$this->_checkErrors($t_subject, $response_data, $vn_num_errors); 

		# references -> links to table that are embeded in form/ not created by the user
		# this is useful for cases where the contribute form is linked to from another record and you want to create a link to that record          	
		if(($ref_table = $this->request->getParameter('ref_table', pString)) && ($ref_row_id = $this->request->getParameter('ref_row_id', pInteger))){
			# --- look up if the relationship type is configured for this reference table
			$ref_config = caGetOption('references', $form_info, array());
			if($rel_type = $ref_config[$ref_table]){
				$t_subject->addRelationship($ref_table, $ref_row_id, $rel_type);
				if ($t_subject->numErrors()) { $this->_checkErrors($t_subject, $response_data, $vn_num_errors);} 
			}
		}
		
		if($vn_num_errors > 0) {            
			$response_data['numErrors'] = $vn_num_errors;
			$response_data['status'] = 'ERR';
			$response_data['formData'] = $_REQUEST;
			$this->view->setVar('response', $response_data);
			$t_subject->getTransaction()->rollback();
			
			$this->notification->addNotification(_t('There were errors in your submission. See below for details.'), __NOTIFICATION_TYPE_ERROR__);
			
			call_user_func_array(array($this, $function), []);
		} else {
			$t_subject->getTransaction()->commit();
		
			if (caGetOption('set_post_submission_notification', $form_info, false)) {
				$this->notification->addNotification(caGetOption($has_media ? 'post_submission_notification_message_with_media' : 'post_submission_notification_message', $form_info, _t('Thank you!')), __NOTIFICATION_TYPE_INFO__);
			}
			if($admin_email = $this->config->get('admin_notification_email')){	
				# --- send admin email notification
				$o_view = new View($this->request, array($this->request->getViewsDirectoryPath()));
				# -- generate email subject line from template
				$subject_line = $o_view->render("mailTemplates/admin_contribute_notification_subject.tpl");
					
				# -- generate mail text from template - get both the text and the html versions
				$mail_message_text = $o_view->render("mailTemplates/admin_contribute_notification.tpl");
				$mail_message_html = $o_view->render("mailTemplates/admin_contribute_notification_html.tpl");
				caSendmail($admin_email, $this->request->config->get("ca_admin_email"), $subject_line, $mail_message_text, $mail_message_html);
			}
			// Redirect to "thank you" page. Options are:        
			#		splash = redirect to Pawtucket splash/front page
			#		url = redirect to Pawtucket url specified in post_submission_destination_url directive
			#		page = use result_html view to format direct response (no redirect)
			switch($form_info['post_submission_destination']) {
				case 'url':
					if (!is_array($form_info['post_submission_destination_url']) || !sizeof($form_info['post_submission_destination_url']) || !isset($form_info['post_submission_destination_url']['controller'])) {
						$this->notification->addNotification(_t('No destination url configured for form %1', $function), __NOTIFICATION_TYPE_ERROR__);
						$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
						break;
					}
					$url = $form_info['post_submission_destination_url'];
					$this->response->setRedirect(caNavUrl($this->request, $url['module'], $url['controller'], $url['action']));
					break;
				case 'page':
					if (!isset($form_info['post_submission_view']) || !$form_info['post_submission_view']) {
						$this->notification->addNotification(_t('No destination view configured for form %1', $function), __NOTIFICATION_TYPE_ERROR__);
						$this->response->setRedirect(caNavUrl($this->request, "", "Front", "Index"));
						break;
					}
					$this->render($form_info['post_submission_view']);
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
	 * Check that form name, basic configuration and record id to edit (if set) are valid for the current user. 
	 * If valid then load configuration for the selected form.
	 *
	 * @param string $form The identifier of the form to load, as defined in contribute.conf
	 * 
	 * @return array An array containing configuration for the specified form, taken from contribute.conf, or null if the form is not defined.
	 */
	private function _checkForm($form) {
		if (!($form_info = caGetInfoForContributeFormType($form))) {
			// invalid form type (shouldn't happen unless misconfigured)
			throw new ApplicationException("Invalid contribute form type");
		}
		
		if (!($this->subject = Datamodel::getInstance($table = $form_info['table']))) {
			// invalid form table (shouldn't happen unless misconfigured)
			throw new ApplicationException("Invalid contribute table setting");
		}
		
		if ($id = $this->request->getParameter('id', pInteger)) {	// Try to load an existing submission
			// Bail if id is not submitted by current user or has already been reviewed and approved.
			if (!($this->subject = $table::find([$this->subject->primaryKey() => $id, 'submission_user_id' => $this->request->getUserID(), 'submission_status_id' => ['NOT IN', $this->completed_status_list]], ['returnAs' => 'firstModelInstance']))) {
				throw new ApplicationException("Invalid contribute item id");
			}
		}
		
		// Does form require login?
		if ($form_info['require_login'] && !($this->request->isLoggedIn())) {
			$this->notification->addNotification(_t('Login is required'), __NOTIFICATION_TYPE_ERROR__);
			$this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
			return null;
		}
		
		return $form_info;
	}
	# -------------------------------------------------------
	/**
	 * Record errors posted in the subject instance for display in the form. Once processed errors are cleared from the subject.
	 *
	 * @param BundlableLabelableBaseModelWithAttributes $subject
	 * @param array $response_data An array containing the JSON response for the form; errors should be inserted into this array for later display
	 * @param int $pn_num_errors The error count
	 *
	 * @return int The number of errors processed 
	 */
	private function _checkErrors($subject, &$response_data, &$pn_num_errors) {
		$vn_c = 0;
		if ($subject->numErrors()) { 
			foreach($subject->errors as $o_error) {
				if(!($source = $o_error->getErrorSource())) { $source = '_general_'; }
				
				if (!is_array($response_data['errors'][$source])) { $response_data['errors'][$source] = array(); }
				if(!in_array($error_desc = $o_error->getErrorDescription(), $response_data['errors'][$source])) {
					$response_data['errors'][$source][] = $error_desc;
					$pn_num_errors++;
					$vn_c++;
				}
			}
			$subject->clearErrors(); 
		}
		
		return $vn_c;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	private static function _applyTextDelimiters($vals, $fld_tag_opts, $text_delimiters) {
		if(($dt = caGetOption('useTextDelimiters', $fld_tag_opts, null)) && isset($text_delimiters[$dt]) && is_array($text_delimiters[$dt]) && sizeof($text_delimiters[$dt])) {
			$exp_vals = [];
			$regex_delimiters = join("|", array_map(function($v) { return preg_quote($v, "!"); }, $text_delimiters[$dt]));
			foreach($vals as $vn_i => $val) {
				$exp_vals = array_merge($exp_vals, preg_split("!{$regex_delimiters}!", $val));
			}
			return array_map(function($v) { return trim($v); }, $exp_vals);
		}
		
		return $vals;
	}
	# -------------------------------------------------------
}
