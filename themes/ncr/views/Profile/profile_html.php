<?php
	global $g_ui_locale;
?>
		<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_account_information.gif' width='244' height='23' border='0'></div><!-- end pageHeading -->
			<div id="accountInfoForm">
				<!--<p><i>* indicates required fields.</i></p>-->
					<form action="<?php print caNavUrl($this->request, '', 'Profile', 'Save', array()); ?>" method="post" name="profile">
<?php
						$va_errors = $this->getVar("errors");
						
						if($va_errors["fname"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors["fname"]."</div>";
						}
						print $this->getVar("fname");
						if($va_errors["lname"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors["lname"]."</div>";
						}
						print $this->getVar("lname");
						if($va_errors["email"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors["email"]."</div>";
						}
						print $this->getVar("email");
						
						// Output user profile settings if defined
						$va_user_profile_settings = $this->getVar('profile_settings');
						if (is_array($va_user_profile_settings) && sizeof($va_user_profile_settings)) {
							foreach($va_user_profile_settings as $vs_field => $va_info) {
								if($va_errors[$vs_field]){
									print "<div class='formErrors' style='text-align: left;'>".$va_errors[$vs_field]."</div>";
								}
								print $va_info['formatted_element'];
							}
						}
						if($va_errors["password"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors["password"]."</div>";
						}
						print $this->getVar("password");
						if($va_errors["password_confirm"]){
							print "<div class='formErrors' style='text-align: left;'>".$va_errors["password_confirm"]."</div>";
						}
						print $this->getVar("password_confirm");
?>
						<a href="#" name="profile" class="button" onclick="document.forms.profile.submit(); return false;"><?php print _t("Save"); ?></a>
					</form>
		</div><!-- end accountInfoForm -->