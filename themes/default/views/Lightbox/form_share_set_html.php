<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/form_share_set_html.php :
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
	$va_user_groups = $this->getVar("user_groups");
	$va_errors = $this->getVar("errors");
	$vs_display_name = $this->getVar("display_name");
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Share %1", ucfirst($vs_display_name)); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-info'>".$this->getVar("message")."</div>";
	}
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ShareSetForm" action="#" class="form-horizontal" role="form">
<?php
		if(is_array($va_user_groups) && sizeof($va_user_groups)){
			if($va_errors["group_id"]){
				print "<div class='alert alert-danger'>".$va_errors["group_id"]."</div>\n";
			}
			print "<div class='form-group".(($va_errors["group_id"]) ? " has-error" : "")."'><label for='group_id' class='col-sm-4 control-label'>"._t("Select a group")."</label><div class='col-sm-7'><select name='group_id' class='form-control'>\n";
			print "<option value='0'>"._t("Select a user group")."</option>\n";
			foreach($va_user_groups as $va_user_group){
				print "<option value='".$va_user_group["group_id"]."'>".$va_user_group["name"]."</option>\n";
			}
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		}
		if($va_errors["user"]){
			print "<div class='alert alert-danger'>".$va_errors["user"]."</div>\n";
		}
		print "<div class='form-group".(($va_errors["user"]) ? " has-error" : "")."'><label for='user' class='col-sm-4 control-label'>".((is_array($va_user_groups) && sizeof($va_user_groups)) ? _t("OR enter a user") : _t("Enter a user"))."</label><div class='col-sm-7'><input type='text' name='user' class='form-control'><small>"._t("email address or multiple addresses separated by comma")."</small></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["access"]){
			print "<div class='alert alert-danger'>".$va_errors["access"]."</div>\n";
		}
		if($this->request->getController() == "Lightbox"){
			print "<div class='form-group".(($va_errors["access"]) ? " has-error" : "")."'><label for='access' class='col-sm-4 control-label'>"._t("Access")."</label><div class='col-sm-7'><select name='access' class='form-control'>\n";
			print "<option value='1'>"._t("Can read")."</option>\n";
			print "<option value='2'>"._t("Can edit")."</option>\n";
			print "</select>\n";
			print "</div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		}else{
			print "<input type='hidden' name='access' value='1'>";
		}
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default">Save</button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ShareSetForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', '*', 'saveShareSet', null); ?>',
				jQuery('#ShareSetForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>