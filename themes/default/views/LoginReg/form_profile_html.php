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
?>
<div class="row">
	<div class="col-8">
		<H1><?php print _t("Profile"); ?></H1>	
	</div>
	<div class="col-4 mt-1 mb-4 text-end">
		<button type="submit" class="btn btn-primary"><?php print _t('Save'); ?></button>
	</div>
</div>

<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ProfileForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "profileSave"); ?>" class="form-horizontal" method="POST">
        <input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
	<div class="bg-light px-4 pt-1 pb-2 mb-4">
		<div class="row mt-4">
			<div class='col-12'>
				<H2><?php print _t("User information"); ?></H2>
			</div>
		</div>
		<div class="row my-2">
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			print "<div class='col-md-4 mb-4'>";
			print $t_user->htmlFormElement($vs_field,"<label for='".$vs_field."' class='form-label'>^LABEL</label>^ELEMENT\n", array("classname" => "form-control".(($va_errors[$vs_field]) ? " is-invalid" : "")));
			if($va_errors[$vs_field]){
				print "<div class='invalid-feedback'>".$va_errors[$vs_field]."</div>";
			}	
			print "</div>";
		}
?>
		</div>
<?php
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			print "<div class='row my-2'>";
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<div class='col-md-4 mb-4'>";
				print $va_profile_element["bs_formatted_element"];
				print "</div>";
			}
			print "</div>";
		}
		
?>
	</div>
	<div class="bg-light px-4 pt-1 pb-2 mb-4">
		<div class="row mt-2">
			<div class='col-12'>
				<H2><?php print _t("Password"); ?></H2>
			</div>
		</div>
		<div class="row my-2">
			<div class='col-md-6 mb-4'>
				<label for='password' class='form-label'>Password</label>
				<input type="password" name="password" id="password" size="40" class="form-control<?php print (($va_errors["password"]) ? " is-invalid" : ""); ?>" autocomplete="off" />
				<div class="form-text"><?php print _t("Only enter if you would like to change your current password"); ?></div>
<?php
				if($va_errors["password"]){
					print "<div class='invalid-feedback'>".$va_errors["password"]."</div>";
				}
?>
			</div>
			<div class='col-md-6 mb-4'>
				<label for='password2' class='form-label'><?php print _t('Re-Type password'); ?></label>
				<input type="password" name="password2" id="password2" class="form-control<?php print (($va_errors["password"]) ? " is-invalid" : ""); ?>"  autocomplete="off" />
			</div>
		</div>
	</div>

		
<?php
	if($this->request->config->get('registration_show_group_code')){
?>	
	<div class="bg-light px-4 pt-1 pb-2 mb-4">
		<div class="row mt-2">
			<div class='col-12'>
				<H2><?php print _t("Groups"); ?></H2>
			</div>
		</div>
		<div class="row mt-2">
			<div class='col-12'>
				<label for='group_code' class='form-label'><?php print _t('Join group'); ?></label>
				<input type="text" name="group_code" id="group_code" class="form-control<?php print (($va_errors["group_code"]) ? " is-invalid" : ""); ?>"  autocomplete="off" />
				<div class="form-text"><?php print _t("If you have been provided with a group code enter it here to join the group."); ?></div>
			</div>
		</div>
<?php
		if (is_array($groups = $t_user->getUserGroups()) && (sizeof($groups) > 0)) {
?>
		<div class="row my-2">
			<div class="col-12">
				<div class='form-label'><?php print _t('Group memberships'); ?></div>
			
				
				<dl>
<?php
					foreach($groups as $group) {
						print "<dt class='fw-medium'>{$group['name']}</dt> <dd>{$group['description']}</dd>";
					}
?>
				</dl>
			</div>
		</div>
<?php
		}
?>
	</div>
<?php
	}
?>
		<div class="row mb-4">
			<div class="col text-end">
				<button type="submit" class="btn btn-primary"><?php print _t('Save'); ?></button>
			</div>
		</div>
	</form>