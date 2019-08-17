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
<main class="ca archive">

        <section class="login">
            <div class="wrap">
                <div class="wrap-max-content">
                	<h3 class="subheadline-bold text-align-center">Profile</h3>

<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="ProfileForm" action="<?php print caNavUrl("", "LoginReg", "profileSave"); ?>" role="form" method="POST">
        <input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
		foreach(array("fname", "lname", "email") as $vs_field){
			if($va_errors[$vs_field]){
				print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
			}	
			print $t_user->htmlFormElement($vs_field,"<div class='block-half".(($va_errors[$vs_field]) ? " has-error" : "")."'><label for='".$vs_field."'>^LABEL</label><br/>^ELEMENT</div><!-- end block-half -->\n");
		}
		$va_profile_settings = $this->getVar("profile_settings");
		if(is_array($va_profile_settings) and sizeof($va_profile_settings)){
			foreach($va_profile_settings as $vs_field => $va_profile_element){
				if($va_errors[$vs_field]){
					print "<div class='alert alert-danger'>".$va_errors[$vs_field]."</div>";
				}
				print "<div class='block-half".(($va_errors[$vs_field]) ? " has-error" : "")."'>";
				print $va_profile_element["bs_formatted_element"];
				print "</div><!-- end block-half -->";
			}
		}
		if($va_errors["password"]){
			print "<div class='alert alert-danger'>".$va_errors["password"]."</div>";
		}		
?>
		<div class="block-half<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password'><?php print _t('Reset Password'); ?></label>
			<div class="caption-text"><?php print _t("Only enter if you would like to change your current password"); ?></div>
			<input type="password" name="password" size="40" class="form-control"  autocomplete="off" />
		</div><!-- end block-half -->
		<div class="block-half<?php print (($va_errors["password"]) ? " has-error" : ""); ?>">
			<label for='password2'><?php print _t('Re-Type password'); ?></label><br/>
			<input type="password" name="password2" size="40" class="form-control" />
		</div><!-- end block-half -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">

		<div class="block-half">
			<button type="submit" class="btn btn-default"><?php print _t('Save'); ?></button>
		</div><!-- end block-half -->
	</form>






			</div>
		</div>
	</section>
</main>	
