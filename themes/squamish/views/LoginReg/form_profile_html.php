<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_profile_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
	$vb_nation_member = $t_user->hasRole("nation_member");
	$vb_nation_staff = $t_user->hasRole("nation_staff");
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

<div class="row"><div class="col-md-12 col-lg-10 col-lg-offset-1"><H1><?php print _t("User profile"); ?></H1></div></div>
<div class="row"><div class="col-md-12 col-lg-10 col-lg-offset-1">
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ProfileForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "profileSave"); ?>" class="form-horizontal" role="form" method="POST">
        <input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
		print "<div class='form-group'>";
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<div class='col-sm-4'>";
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."''>^LABEL</label>^ELEMENT</div></div>\n", array("classname" => "form-control"));
		}
		print "</div>";
?>
		<div class="form-group<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<div class='col-sm-4'>
<?php
				if($va_errors["password"]){
					print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
				}
?>
				<label for='password' class='control-label'><?php print _t('Reset Password'); ?></label>
				<p class="help-block"><?php print _t("Only enter if you would like to change your current password"); ?></p>
				<input type="password" name="password" id="password" size="40" class="form-control"  autocomplete="off" />

			</div>
			<div class='col-sm-4'>
				<p class="help-block">&nbsp;</p>
				<label for='password2' class='control-label'><?php print _t('Re-Type password'); ?></label>
				<input type="password" name="password2" id="password2" size="40" class="form-control"  autocomplete="off" />
		
			</div>
		</div>
<?php		
		$va_profile_settings = $this->getVar("profile_settings");
?>
		<div class="row bgLightGray">
			<div class="col-sm-12">
				<H2>Squamish Nation Members and Staff</H2>
<?php
				if(!$vb_nation_member || !$vb_nation_staff){
?>				
					<p class="formTextLarge">{{{register_member_staff_instructions}}}</p>
<?php
				}
?>				
				<div class="form-group">
					<div class="col-sm-6 <?php print (($va_errors["user_profile_band_number"]) ? " has-error" : ""); ?>">
						<b>Squamish Nation Members</b>
						
<?php

						if($va_errors["user_profile_band_number"]){
							print "<div class='alert alert-danger'>".$va_errors["user_profile_band_number"]."</div>";
						}
						if($vb_nation_member){
							print "<div><i>".$this->getVar("profile_member_account")."</i></div>";
						}else{
?>
						<p>{{{register_member_instructions}}}</p>
						<label for="member_code" class="control-label">Squamish Nation Member Registration Code</label>
						<input type="text" name="member_code" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("member_code", pString))); ?>">
<?php
						}
?>						
						<label for="pref_user_profile_band_number" class="control-label"><?php print $va_profile_settings["user_profile_band_number"]["label"]; ?></label>
						<div class="profileElement"><?php print $va_profile_settings["user_profile_band_number"]["element"]; ?></div>
					</div><!-- end col-sm-6 -->
					<div class="col-sm-6 <?php print (($va_errors["user_profile_staff_jde_number"]) ? " has-error" : ""); ?>">
						<b>Squamish Nation Staff</b>
<?php
						if($va_errors["user_profile_staff_jde_number"]){
							print "<div class='alert alert-danger'>".$va_errors["user_profile_staff_jde_number"]."</div>";
						}
						if($vb_nation_staff){
							print "<div><i>".$this->getVar("profile_staff_account")."</i></div>";
						}else{
?>
							<p>{{{register_staff_instructions}}}</p>
						<label for="staff_code" class="control-label">Squamish Nation Staff Registration Code</label>
						<input type="text" name="staff_code" maxlength="70" class="form-control" value="<?php print html_entity_decode(strip_tags($this->request->getParameter("staff_code", pString))); ?>">
<?php
						}
?>						
						<label for="pref_user_profile_staff_jde_number" class="control-label"><?php print $va_profile_settings["user_profile_staff_jde_number"]["label"]; ?></label>
						<div class="profileElement"><?php print $va_profile_settings["user_profile_staff_jde_number"]["element"]; ?></div>
					</div><!-- end col-sm-6 -->
				</div>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-12">
				<br/><button type="submit" class="btn btn-default"><?php print _t('Save'); ?></button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
	</form>
</div></div>
<?php
	if($this->request->isAjax()){
?>
</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ProfileForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'profileSave', null); ?>',
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
