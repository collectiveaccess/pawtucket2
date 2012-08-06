<?php
/* ----------------------------------------------------------------------
 * themes/default/views/search_advanced_controls_html.php : 
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
  
 $t_subject 				= $this->getVar('t_subject');
 $o_result_context 	= $this->getVar('result_context');
 $va_forms				= $this->getVar('form_codes');
 $vs_form					= $this->getVar('form');					// name of form to display
 $va_form_info			= caGetInfoForAdvancedSearchForm($vs_form, $t_subject->tableName());

 // 
 // Set options for all form element here
 //
 $va_bundle_opts = array(
 	'values' => $o_result_context->getParameter('form_data')	// saved form data to pre-fill fields with
 );
 
//
// List out form elements to display here
//
$va_form_fields = caGetAdvancedSearchFormElementNames($vs_form, $t_subject->tableName());
$va_form_field_with_subelements = caGetAdvancedSearchFormElementNames($vs_form, $t_subject->tableName(), array('includeSubElements' => true));

if (!$this->request->isAjax()) {
	if (sizeof($va_forms) > 1) {
		 print "<div style='float: right;'><form action='#'>".caHTMLSelect('form', $va_forms, array('onchange' => 'caLoadAdvancedSearchForm();', 'id' => 'caAdvancedSearchFormSelector'), array('value' => $vs_form))."</form></div>\n";
	}
?>
	<H1><?php print _t("Advanced Search"); ?></H1>
<?php
}

 if ($va_form_fields && is_array($va_form_fields) && sizeof($va_form_fields)) {
?>
		<div id="caAdvancedSearchForm">
			<?php  print caFormTag($this->request, 'Index', 'caAdvancedSearch',  null, 'POST', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)); ?>



				<table border="0">
<?php
				$vn_cnt = 0;
				if (($vn_max_cols = (int)$va_form_info['settings']['columns']) < 1) {
					$vn_max_cols = 3;
				}
				foreach($va_form_fields as $vs_bundle => $va_bundle_info) {
					if (!$vn_cnt) { print "<tr valign='top'>"; }
?>
					<td class="advSearchElement">
						<div class="advSearchLabel"><?php print isset($va_bundle_info['label']) ? $va_bundle_info['label'] : $t_subject->getDisplayLabel($vs_bundle); ?></div>
						<?php print $t_subject->htmlFormElementForSearch($this->request, $vs_bundle, array_merge($va_bundle_opts, $va_bundle_info)); ?>
					</td><!-- end advSearchElement -->
<?php
					$vn_cnt++;
					if ($vn_cnt >= $vn_max_cols) {
						$vn_cnt = 0;
						print "</tr>\n";
					}
				}
				if ($vn_cnt > 0) {
					print "</tr>\n";
				}
?>
				</table>
			<?php print caHTMLHiddenInput("target", array('value' => $t_subject->tableName())); ?>
			<?php print caHTMLHiddenInput("_fields", array('value' => join(';', array_keys($va_form_field_with_subelements)))); ?>
		</form>
			<div id="buttons">
				<input type="submit" style="position: absolute; left: -9999px"/>
				<div style="float:right; margin-left:15px;">
					<a href="#" onclick="jQuery('#caAdvancedSearch').submit(); return false;"><?php print _t('Search'); ?></a>
				</div>
				<div style="float:left;">
					<a href="#" onclick="jQuery('#caAdvancedSearch input[type!=hidden]').val(''); jQuery('#caAdvancedSearch select').val('');"><?php print _t('Clear'); ?></a>
				</div>
			</div>
	</div><!-- end advancedSearch -->
	<script type="text/javascript">
		function caLoadAdvancedSearchForm() {
			jQuery('#caAdvancedSearchForm').load('<?php print caNavUrl($this->request, '', 'AdvancedSearch', 'getAdvancedSearchForm', array()); ?>/form/' + jQuery('#caAdvancedSearchFormSelector').val());
		}
	</script>
<?php
	}
?>