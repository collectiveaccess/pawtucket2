<?php
/* ----------------------------------------------------------------------
 * app/plugins/tabu/views/tabu/advanced_search_html.php : 
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
 
 //
 // Set options for all form element here
 //
 $va_bundle_opts = array(
 	'width' => 30, 'height' => 1, 
 	'values' => $o_result_context->getParameter('form_data')	// saved form data to pre-fill fields with
 );
 
 $va_type_ids = array(
 	(int)$t_subject->getTypeIDForCode('take') => 'take',
 	(int)$t_subject->getTypeIDForCode('continuity') => 'continuity',
 	(int)$t_subject->getTypeIDForCode('script_clerk') => 'script_clerk'
 );
 
 //
 // List out form elements to display here
 //
 $va_form_fields = array(
 	'ca_objects.einstellungs_nr' => array(
 		'label' => _t("Einstellungs-Nr.")
 	),
 	'ca_objects.date_translated' => array(
 		'label' => _t("Datum")
 	),
 	'ca_objects.location' => array(
 		'label' => _t("Drehort")
 	),
 	'ca_objects.cameraman' => array(
 		'label' => _t("Kameramann")
 	),
 	'ca_objects.people' => array(
 		'label' => _t("Person")
 	),
 	'keywords' => array(
 		'label' => _t("Stichwort")
 	),
 );
 
?>
<H1><?php print _t("Erweiterte Suche"); ?></H1>
<div id="advancedSearch">
<?php  print caFormTag($this->request, 'Index', 'caAdvancedSearch',  null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true)); ?>
	<table class="typeList" border="0">
		<tr>
			<td valign="bottom" style="text-align:left;"><a href="#" class="type_outtakes"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_video_search.gif' border='0' class="tabu_search"></a></td>
			<td valign="bottom" style="text-align:left; padding: 0px 0px 4px; width:200px;"><a href="#" class="type_outtakes"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_off_white.gif' border='0'  class="tabu_box"></a> <?php print _t("Clips"); ?></div>
		</tr>
		<tr>
			<td valign="bottom" style="text-align:left; padding: 10px 0px 0px;"><a href="#" class="type_con"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_continuity_search.gif' border='0'  class="tabu_search"></a></td>
			<td valign="bottom" style="text-align:left; padding: 0px 0px 4px; width:200px;"><a href="#" class="type_con"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_off_white.gif' border='0'  class="tabu_box"></a> <?php print _t("Drehbuch"); ?></div>
		</tr>
		<tr>
			<td valign="bottom" style="text-align:left; padding: 10px 0px 0px;"><a href="#" class="type_scr"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_script_search.gif' border='0'  class="tabu_search"></a></td>
			<td valign="bottom" style="text-align:left; padding: 0px 0px 4px; width:200px;"><a href="#" class="type_scr"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_off_white.gif' border='0'  class="tabu_box"></a> <?php print _t("Tagesberichte"); ?></div>
		</tr>
		<tr>
			<td valign="bottom" style="text-align:left; padding: 10px 0px 0px;"><a href="#" class="type_all"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_all_search.gif' border='0' class="tabu_search"></a></td>
			<td valign="bottom" style="text-align:left; padding: 0px 0px 4px; width:200px;"><a href="#" class="type_all"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_off_white.gif' border='0'  class="tabu_box"></a> <?php print _t("alle"); ?></div>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" style="text-align:left; padding: 30px 0px 0px 0px;"><div class="buttonBg"><a href="#" onclick="jQuery('#caAdvancedSearch').submit(); return false;"><?php print _t("Suche"); ?></a></div></td>
		</tr>
	</table><!-- end typeList -->
	<div id="advSearchLeft">
<?php
	foreach($va_form_fields as $vs_bundle => $va_bundle_info) {
?>
		<div class="advSearchElement">
			<div class="advSearchLabelBg"><div class="advSearchLabel"><?php print $va_bundle_info['label']; ?></div></div>
			<?php print $t_subject->htmlFormElementForSearch($this->request, $vs_bundle,array_merge($va_bundle_info,$va_bundle_opts)); ?>
		</div><!-- end advSearchElement -->
<?php
	}
?>
	</div>
	<input type="hidden" name="ca_objects_type_id" value="" id="tabu_type_id"/>
	<?php print caHTMLHiddenInput("target", array('value' => $t_subject->tableName())); ?>
	<?php print caHTMLHiddenInput("_fields", array('value' => join(';', array_merge(array_keys($va_form_fields), array('ca_objects.type_id'))))); ?>
	<input type="submit" style="position: absolute; left: -9999px"/>
	</form>

</div><!-- end advancedSearch -->
<div style="clear:right; height:1px;">&nbsp;</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.type_outtakes').click(function() {
			tabuClearTypes();
			jQuery('.type_outtakes .tabu_box').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_on_red.gif');
			jQuery('.type_outtakes .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_video_search_on.gif');
			jQuery('#tabu_type_id').val('<?php print (int)$t_subject->getTypeIDForCode('take'); ?>');
			return false;
		});
		jQuery('.type_con').click(function() {
			tabuClearTypes();
			jQuery('.type_con .tabu_box').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_on_red.gif');
			jQuery('.type_con .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_continuity_search_on.gif');
			jQuery('#tabu_type_id').val('<?php print (int)$t_subject->getTypeIDForCode('continuity'); ?>');
			return false;
		});
		jQuery('.type_scr').click(function() {
			tabuClearTypes();
			jQuery('.type_scr .tabu_box').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_on_red.gif');
			jQuery('.type_scr .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_script_search_on.gif');
			jQuery('#tabu_type_id').val('<?php print (int)$t_subject->getTypeIDForCode('script_clerk'); ?>');
			return false;
		});
		jQuery('.type_all').click(function() {
			tabuClearTypes();
			jQuery('.type_all .tabu_box').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_on_red.gif');
			jQuery('.type_all .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_all_search_on.gif');
			jQuery('#tabu_type_id').val('');
			return false;
		});
<?php
		switch($va_type_ids[$va_bundle_opts['values']['ca_objects.type_id']]) {
			case 'take':
				print "jQuery('.type_outtakes').click();\n";
				break;
			case 'continuity':
				print "jQuery('.type_con').click();\n";
				break;
			case 'script_clerk':
				print "jQuery('.type_scr').click();\n";
				break;
			default:
				print "jQuery('.type_all').click();\n";
				break;
		}
?>
	});
	
	function tabuClearTypes() {
		jQuery('.tabu_box').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/box_off_white.gif');
		
		jQuery('.type_outtakes .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_video_search.gif');
		jQuery('.type_con .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_continuity_search.gif');
		jQuery('.type_scr .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_script_search.gif');
		jQuery('.type_all .tabu_search').attr('src', '<?php print $this->request->getThemeUrlPath(); ?>/graphics/type_all_search.gif');
	}
</script>
