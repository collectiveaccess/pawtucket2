<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/form_add_set_item_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$t_set = $this->getVar("set");
	#$va_write_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 	$va_errors = $this->getVar("errors");
	$vs_display_name = $this->getVar("display_name");
	$vs_description_attribute 		= $this->getVar("description_attribute");
	$va_access_values = caGetUserAccessValues($this->request);

	$va_write_parent_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "setType" => "user", "parents_only" => true, "access" => 2));
	#$va_write_palette_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "setType" => "palette", "access" => 2));
	$va_object_ids = explode(";", $this->getVar("object_ids"));
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Add item%1 to %2", ((sizeof($va_object_ids) > 1) ? "s" : ""), $vs_display_name); ?></H1>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="AddItemForm" action="#" class="form-horizontal" role="form">
<?php
		$vs_parent_dropdowns = "";
		if(is_array($va_write_parent_sets) && sizeof($va_write_parent_sets)){
			$t_write_set = new ca_sets();
			print "<div class='form-group'><div class='col-sm-offset-4 col-sm-7'><select name='set_id' class='form-control'>";
			print "<option value=''>"._t("Select a %1", $vs_display_name)."</option>\n";
			foreach($va_write_parent_sets as $va_write_parent){
				$t_write_set->load($va_write_parent["set_id"]);
				$vs_palettes = $t_write_set->getWithTemplate("<unit relativeTo='ca_sets.children' delimiter=' '><option value='^ca_sets.set_id'>&nbsp;&nbsp;&nbsp;^ca_sets.preferred_labels</option></unit>");
				if($vs_palettes){
					print "<option value='".$va_write_parent["set_id"]."' disabled>".$t_write_set->getLabelForDisplay()."</option>\n";
					print $vs_palettes;
				}
				$vs_parent_dropdowns .= "<option value='".$va_write_parent["set_id"]."'>".$t_write_set->getLabelForDisplay()."</option>\n";
			}
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
			print "<div class='form-group'><div class='col-sm-offset-4 col-sm-7'><H3>"._t("OR<br/>Create a New %1", ucfirst($vs_display_name))."</H3></div></div><!-- end form-group -->\n";
		}
		print "<div class='form-group'><label for='parent' class='col-sm-4 control-label'>"._t("Part of")."</label><div class='col-sm-7'><select id='parent_id' name='parent_id' class='form-control'>".$vs_parent_dropdowns."<option value='-1'>Create a New Gallery</option></select></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print "<div id='newParent' class='form-group' ".(($vs_parent_dropdowns) ? "style='display:none;'" : "")."><div class='col-sm-7 col-sm-offset-4'><input type='text' name='parent_name' placeholder='"._t("New Gallery Name")."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		print "<div class='form-group'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' placeholder='"._t("Your %1", $vs_display_name)."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		#print $t_set->htmlFormElement("access","<div class='form-group'><label for='access' class='col-sm-4 control-label'>"._t("Display Option")."</label><div class='col-sm-7' class='form-control'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		print "<div class='form-group'><label for='description' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='".$vs_description_attribute."' class='form-control' rows='3'></textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";

?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="object_id" value="<?php print $this->getVar("object_id"); ?>">
		<input type="hidden" name="object_ids" value="<?php print $this->getVar("object_ids"); ?>">
		<input type="hidden" name="saveLastResults" value="<?php print $this->getVar("saveLastResults"); ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#AddItemForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Lightbox', 'AjaxAddItem', null); ?>',
				jQuery('#AddItemForm').serialize()
			);
			e.preventDefault();
			return false;
		});
		
		jQuery('#parent_id').on('change', function () {
			if ($(this).val() == -1) {
				$('#newParent').show();
			} else {
				$('#newParent').hide();
			}
		});
	});
</script>