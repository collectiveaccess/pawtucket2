<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_profile_html.php
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
 
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	if($this->request->isAjax()){
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();
</script>
<div class="row"><div class="col-sm-4"><H1<?php print (!$this->request->isAjax()) ? ' class="text-right"' : ''; ?>><?php print _t("User information"); ?></H1></div></div>

<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ProfileForm" action="<?php print caNavUrl("", "LoginReg", "profileSave"); ?>" class="form-horizontal" role="form" method="POST">
        <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."' class='col-sm-4 control-label'>^LABEL</label><div class='col-sm-7'>^ELEMENT</div><!-- end col-sm-7 --></div><!-- end form-group -->\n", array("classname" => "form-control"));
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'>";
				print $va_profile_element["bs_formatted_element"];
				print "</div><!-- end form-group -->";
			}
		}
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}		
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password' class='col-sm-4 control-label'><?php print _t('Reset Password'); ?></label>
			<div class="col-sm-7"><p class="help-block"><?php print _t("Only enter if you would like to change your current password"); ?></p><input type="password" name="password" size="40" class="form-control"  autocomplete="off" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2' class='col-sm-4 control-label'><?php print _t('Re-Type password'); ?></label>
			<div class="col-sm-7"><input type="password" name="password2" size="40" class="form-control" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">

	<div class="row"><div class="col-sm-4"><H1<?php print (!$this->request->isAjax()) ? ' class="text-right"' : ''; ?>><?php print _t("Groups"); ?></H1></div></div>
		<div class="form-group<?php print (($va_errors["group_code"]) ? " has-error" : ""); ?>">
			<label for='group_code' class='col-sm-4 control-label'><?php print _t('Join group'); ?></label>
			<div class="col-sm-7"><p class="help-block"><?php print _t("If you have been provided with a group code enter it here to join the group."); ?></p><input type="text" name="group_code" size="40" class="form-control"  autocomplete="off" /></div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
<?php
	if (is_array($groups = $t_user->getUserGroups()) && (sizeof($groups) > 0)) {
?>
		<div class="form-group">
			<label class='col-sm-4 control-label'><?php print _t('Group memberships'); ?></label>
			<div class="col-sm-7">
				
				<ul style="list-style: none; padding: 3px;">
<?php
					foreach($groups as $group) {
						print "<li><label>{$group['name']}</label> <blockquote class='help-block'>{$group['description']}</blockquote></li>";
					}
?>
				</ul>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
<?php
	}
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default"><?php print _t('Save'); ?></button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
	</form>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ProfileForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl('', 'LoginReg', 'profileSave', null); ?>',
				jQuery('#ProfileForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>
