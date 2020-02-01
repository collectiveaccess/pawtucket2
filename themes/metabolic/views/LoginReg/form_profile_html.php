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
?>
<script type="text/javascript">
	// initialize CA Utils
	caUI.initUtils();
</script>
<div class="row mt-5 mb-5">
	<div class="col-sm-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
		<H1><?php print _t("User information"); ?></H1>
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
			print $t_user->htmlFormElement($vs_field,"<div class='form-group".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."'>^LABEL</label>^ELEMENT</div><!-- end form-group -->\n", array("classname" => "form-control"));
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
			<label for='password'><?php print _t('Reset Password'); ?></label>
			<div class='small mb-1'><?php print _t("Only enter if you would like to change your current password"); ?></div>
			<input type="password" name="password" size="40" class="form-control"  autocomplete="off" />
		</div><!-- end form-group -->
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2'><?php print _t('Re-Type password'); ?></label>
			<input type="password" name="password2" size="40" class="form-control" />
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">

		<div class="form-group<?php print (($va_errors["group_code"]) ? " has-error" : ""); ?>">
			<H2><?php print _t("Groups"); ?></H2>
			<label for='group_code'><?php print _t('Join group'); ?></label>
			<div class="small mb-1"><?php print _t("If you have been provided with a group code enter it here to join the group."); ?></div>
			<input type="text" name="group_code" size="40" class="form-control"  autocomplete="off" />
		</div><!-- end form-group -->
<?php
	if (is_array($groups = $t_user->getUserGroups()) && (sizeof($groups) > 0)) {
?>
		<div class="form-group">
			<div><?php print _t('Group memberships'); ?></div>
				
				<ul style="list-style: none; padding:0px;">
<?php
					foreach($groups as $group) {
						print "<li><div class='small mb-3 mt-1 ml-2'><b>{$group['name']}</b><br/>{$group['description']}</div></li>";
					}
?>
				</ul>
		</div><!-- end form-group -->
<?php
	}
?>
		<div class="form-group">
			<button type="submit" class="btn btn-primary"><?php print _t('Save'); ?></button>
		</div><!-- end form-group -->
	</form>
	</div>
</div>