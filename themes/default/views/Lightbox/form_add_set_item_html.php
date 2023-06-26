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
	$va_write_sets = $t_set->getSetsForUser(array("table" => "ca_objects", "user_id" => $this->request->getUserID(), "access" => 2));
 	$va_errors = $this->getVar("errors");
	$vs_display_name = $this->getVar("display_name");
	$vs_description_attribute 		= $this->getVar("description_attribute");
	$vs_set_name = $this->getVar("set_name");
	$vs_set_description = $this->getVar("set_description");
	$vn_last_set_id = $this->getVar("lightboxLastSetId");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Add item to %1", $vs_display_name); ?></H1>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="AddItemForm" action="#" class="form-horizontal" role="form">
<?php
		print caHTMLHiddenInput('csrfToken', array('value' => caGenerateCSRFToken($this->request)));
		if(is_array($va_write_sets) && sizeof($va_write_sets)){
			$t_write_set = new ca_sets();
			print "<div class='form-group'><label for='set' class='col-sm-4 control-label'>".$vs_display_name."</label><div class='col-sm-7'><select name='set_id' id='set' class='form-control'>";
			print "<option value=''>"._t("Select a %1", $vs_display_name)."</option>\n";
			foreach($va_write_sets as $va_write_set){
				$t_write_set->load($va_write_set["set_id"]);
				print "<option value='".$va_write_set["set_id"]."'".(($vn_last_set_id == $va_write_set["set_id"]) ? " selected" : "").">".$t_write_set->getLabelForDisplay()."</option>\n";
			}
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
			print "<div class='form-group'><div class='col-sm-offset-4 col-sm-7'><H2 class='uppercase'>"._t("OR Create a New %1", ucfirst($vs_display_name))."</H2></div></div><!-- end form-group -->\n";
		}
		print "<div class='form-group'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' id='name' placeholder='"._t("Your %1", $vs_display_name)."' class='form-control' value='".$vs_set_name."'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		#print $t_set->htmlFormElement("access","<div class='form-group'><label for='access' class='col-sm-4 control-label'>"._t("Display Option")."</label><div class='col-sm-7' class='form-control'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		print "<div class='form-group'><label for='description' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='".$vs_description_attribute."' id='description' class='form-control' rows='3'>".$vs_set_description."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";

?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default"><?php print _t("Save"); ?></button>
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
	});
</script>