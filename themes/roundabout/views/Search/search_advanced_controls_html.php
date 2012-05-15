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

?>
	<div id="right-col">
		<div class="promo-block">
			<div class="shadow"></div>
			<h3>Contact the Archivist</h3>
			<p>Restricted items are available by contacting the archivist.</p>
			<p>Call 212-719-9393 or <a href="mailto:archives@roundabouttheatre.org">email us</a></p>
		<!--end .promo-block -->
		</div>
	</div>
	<div id="left-col">
<?php
	if (sizeof($va_forms) > 1) {
		 print "<div style='float: right;'><form action='#'>".caHTMLSelect('form', $va_forms, array('onchange' => 'caLoadAdvancedSearchForm();', 'id' => 'caAdvancedSearchFormSelector'), array('value' => $vs_form))."</form></div>\n";
	}
?>
	<H1><?php print _t("Advanced Search"); ?></H1>
<?php


 if ($va_form_fields && is_array($va_form_fields) && sizeof($va_form_fields)) {
?>
		<div id="caAdvancedSearchForm">
			<?php  print caFormTag($this->request, 'Index', 'caAdvancedSearch',  null, 'POST', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)); ?>

			
			<ul class="advanced_search_controls_list">
<?php
	
				foreach($va_form_fields as $vs_bundle => $va_bundle_info) {
?>
					<li class="advSearchElement">
						<label><?php print isset($va_bundle_info['label']) ? $va_bundle_info['label'] : $t_subject->getDisplayLabel($vs_bundle); ?></label>
						<div><?php print $t_subject->htmlFormElementForSearch($this->request, $vs_bundle, array_merge($va_bundle_opts, $va_bundle_info)); ?></div>
						<span class="clearfix"></span>
					</li><!-- end advSearchElement -->
					
<?php 		
				} //end foreach 
?>
			</ul>
			
			<ul class="advanced-search-button-list">
				<li>	
					<input type="submit" style="position: absolute; left: -9999px"/>
				</li>
				<li>
					<a class="block-btn" href="#" onclick="jQuery('#caAdvancedSearch').submit(); return false;"><?php print _t('Search'); ?></a>
				</li>
				<li>
					<a class="block-btn" href="#" onclick="jQuery('#caAdvancedSearch input').val(''); jQuery('#caAdvancedSearch select').val(''); $(':checked').removeAttr('checked');"><?php print _t('Reset'); ?></a>
				</li>
			</ul>
				
			<?php print caHTMLHiddenInput("target", array('value' => $t_subject->tableName())); ?>
			<?php print caHTMLHiddenInput("_fields", array('value' => join(';', array_keys($va_form_field_with_subelements)))); ?>
			<div class="clearfix"></div>
		</form>
		
	</div><!-- end advancedSearch -->
	<script type="text/javascript">
		function caLoadAdvancedSearchForm() {
			jQuery('#caAdvancedSearchForm').load('<?php print caNavUrl($this->request, '', 'AdvancedSearch', 'getAdvancedSearchForm', array()); ?>/form/' + jQuery('#caAdvancedSearchFormSelector').val());
		}
	</script>
<?php
	}
?>
</div><!--end #left-col-->
<?php
	
?>