<?php
/* ----------------------------------------------------------------------
 * themes/default/views/find/SearchBuilder/search_controls_html.php 
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
$vs_table = 			$this->getVar('table');
$va_lookup_urls = 		caJSONLookupServiceUrl($this->request, $vs_table, array('noInline' => 1));
$vo_result_context =	$this->getVar('result_context');

$vs_type_id_form_element = '';
if ($vn_type_id = intval($this->getVar('type_id'))) {
	$vs_type_id_form_element = '<input type="hidden" name="type_id" value="'.$vn_type_id.'"/>';
}
$show_query = $this->getVar('show_search_builder_query');
	
?>
<?= caFormTag($this->request, 'objects', 'SearchBuilderForm', null, 'post', 'multipart/form-data', '_top', array('noCSRFToken' => true, 'disableUnsavedChangesWarning' => true)); ?>
<?='<input type="'.($show_query ? 'text' : 'hidden').'" id="SearchBuilderInput" name="search" size="80" value="'.htmlspecialchars($this->getVar('search'), ENT_QUOTES, 'UTF-8').'" />'.$vs_type_id_form_element; ?>
</form>

<script type="text/javascript">
	function caSetSearchInputQueryFromQueryBuilder() {
		var query, rules;
		rules = jQuery('#searchBuilder').queryBuilder('getRules');
		if (rules) {
			query = caUI.convertQueryBuilderRuleSetToSearchQuery(rules);
			if (query) {
				jQuery('#SearchBuilderInput').val(query);
			}
		}
	}

	function caGetSearchQueryBuilderUpdateEvents() {
		return [
			'afterAddGroup.queryBuilder',
			'afterDeleteGroup.queryBuilder',
			'afterAddRule.queryBuilder',
			'afterDeleteRule.queryBuilder',
			'afterUpdateRuleValue.queryBuilder',
			'afterUpdateRuleFilter.queryBuilder',
			'afterUpdateRuleOperator.queryBuilder',
			'afterUpdateGroupCondition.queryBuilder',
			'afterSetFilters.queryBuilder'
		].join(' ');
	}
	 	
	jQuery(document).ready(function() {
		// Show "add to set" controls if set tools is open
		if (jQuery("#searchSetTools").is(":visible")) { jQuery(".addItemToSetControl").show(); }
		
		// Set up query builder UI
		var opts = <?= json_encode($this->getVar('form_options')); ?>;
		opts['rules'] = caUI.convertSearchQueryToQueryBuilderRuleSet(jQuery('#SearchBuilderInput').val().replace(/\\(.)/mg, "\\$1"));
		
		try {
			jQuery('#searchBuilder').queryBuilder(opts)
				.on(caGetSearchQueryBuilderUpdateEvents(), caSetSearchInputQueryFromQueryBuilder);
		} catch (e) {
			// Reset with no rules after initialization exception (caused by now-invalid config)
			jQuery('#searchBuilder').queryBuilder('destroy');
			jQuery('#searchBuilder').queryBuilder(jQuery.extend(opts, {'rules': null }))
				.on(caGetSearchQueryBuilderUpdateEvents(), caSetSearchInputQueryFromQueryBuilder);
		}
	});
</script>
