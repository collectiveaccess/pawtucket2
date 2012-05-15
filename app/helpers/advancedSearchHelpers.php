<?php
/* ----------------------------------------------------------------------
 * app/helpers/advancedSearchHelpers.php : utility functions for handling the Pawtucket advanced search form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
 require_once(__CA_LIB_DIR__.'/core/Configuration.php');
 require_once(__CA_MODELS_DIR__.'/ca_metadata_elements.php');
 
	 # --------------------------------------------------------------------------------------------
	 /**
	  * Returns array of name for bundles in the specified form. The array is keyed on bundle name (in <table>.<name> format) with values set to arrays of bundle-specific form options (no such options are currently supported however)
	  *
	  * @param string $ps_code The code for the form
	  * @param string $ps_target The type of search the form targets. This should be a table name (ca_objects, ca_entities, etc.). If omitted defaults to ca_objects.
	  * @return array An array of bundle names with associated bundle-level form option arrays
	  */
	function caGetAdvancedSearchFormElementNames($ps_code, $ps_target='ca_objects', $pa_options=null) {
		$o_config = Configuration::load(Configuration::load()->get('advanced_search_config'));
		
		$va_forms = $o_config->getAssoc($ps_target);
		$va_form_elements = array();
		if (isset($va_forms[$ps_code]) && is_array($va_forms[$ps_code])) {
			
			$t_element = new ca_metadata_elements();
			foreach($va_forms[$ps_code]['bundles'] as $vs_bundle => $va_info) {
				$va_tmp = explode('.',  $vs_bundle);
				
				if ($t_element->load(array('element_code' => $va_tmp[1]))) {
					if ($t_element->get('datatype') > 0) {
						$va_form_elements[$vs_bundle] = $va_info;
						continue;
					}
					
					if (isset($pa_options['includeSubElements']) && $pa_options['includeSubElements']) {
						if (sizeof($va_sub_elements = $t_element->getElementsInSet()) > 1) {
							foreach($va_sub_elements as $vn_element_id => $va_element_info) {
								if ($va_tmp[1] == $va_element_info['element_code']) { continue; }
								if ($va_element_info['datatype'] == 0) { continue; }
								$va_form_elements[$va_tmp[0].'.'.$va_element_info['element_code']] = array();
							}
						}
					}
				}
				$va_form_elements[$vs_bundle] = $va_info;
			}
			
			return $va_form_elements;
		}
		return null;
	}
	# --------------------------------------------------------------------------------------------
	 /**
	  * Extracts field data and constructs a Lucene-compatible query string given an associative array of request parameters
	  * from an advanced search form submission 
	  *
	  * @param array $pa_request An associative array of request parameters (eg. $_REQUEST)
	  * @return array An associative array with three keys:
	  *			expression = a Lucene-compatible query expression extracted from the form submission
	  *			elements = an array of query elements; each element is in <bundle>:<value> format
	  *			form_data = an associative array of form data with keys set to bundle names and values set to values
	  */
	function caGetSearchExpressionFromAdvancedSearchForm($pa_request) {
		// look for elements
		$va_fields = explode(';', $pa_request['_fields']);
		$va_query_elements = $va_form_data = array();
		foreach($va_fields as $vs_bundle_name) {
			$vs_proc_bundle_name = preg_replace('![^A-Za-z0-9_]+!', '_', $vs_bundle_name);
			
			if (strlen($vs_val = $pa_request[$vs_proc_bundle_name])) {
				$va_form_data[$vs_bundle_name] = $vs_val;
				$vs_val = str_replace('"', '', $vs_val);
				if (preg_match('![ ]+!', $vs_val)) { $vs_val = '"'.$vs_val.'"'; }
				
				switch($vs_bundle_name) {
					case '_fulltext':
						$va_query_elements[] = $vs_val;
						break;
					default:
						$va_query_elements[] = "{$vs_bundle_name}:{$vs_val}";
						break;
				}
			}
		}
		
		return array(
			'expression' =>  join(" AND ", $va_query_elements),
			'elements' => $va_query_elements,
			'form_data' => $va_form_data
		);
	}
	# --------------------------------------------------------------------------------------------
	 /**
	  * Returns a list of valid form codes for the specific search target. The returned array has displayable form names as keys
	  * and form codes as values, so it can be passed as-is to caHTMLSelect() to generate a drop-down list of available forms.
	  *
	  * @param string $ps_target The type of search the form targets. This should be a table name (ca_objects, ca_entities, etc.). 
	  * @return array An associative array of form codes where keys are form display names and values are form codes.
	  */
	function caGetAvailableAdvancedSearchFormCodes($ps_target) {
		$o_config = Configuration::load(Configuration::load()->get('advanced_search_config'));
		
		$va_forms = $o_config->getAssoc($ps_target);
		
		$va_form_codes = array();
		foreach($va_forms as $vs_form_code => $va_form_info) {
			$va_form_codes[isset($va_form_info['settings']['name']) ? $va_form_info['settings']['name'] : $vs_form_code] = $vs_form_code;
		}
		
		return $va_form_codes;
	}
	# --------------------------------------------------------------------------------------------
	 /**
	  * Returns an array with all information about the specified form. The array is taken verbatim from the advanced_search_forms.conf configuration file 
	  * and contains form settings as well as the complete bundle list.
	  *
	  * @param string $ps_code The code for the form
	  * @param string $ps_target The type of search the form targets. This should be a table name (ca_objects, ca_entities, etc.).
	  * @return array An array of contaning full information for the specified form
	  */
	function caGetInfoForAdvancedSearchForm($ps_code, $ps_target) {
		$o_config = Configuration::load(Configuration::load()->get('advanced_search_config'));
		
		$va_forms = $o_config->getAssoc($ps_target);
		
		
		return isset($va_forms[$ps_code]) ? $va_forms[$ps_code] : null;
	}
	# ---------------------------------------------------------------------------------------------
 ?>