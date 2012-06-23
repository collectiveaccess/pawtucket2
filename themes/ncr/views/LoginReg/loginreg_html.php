<?php
	global $g_ui_locale;

	JavascriptLoadManager::register("cycle");
?>
		<div id="loginRegFeatured">
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_2.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_3.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_5.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_1.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_7.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_6.jpg" width="500" height="625" border="0"></div>
		</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#loginRegFeatured').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  1000,
		timeout: 4000
	});
});
</script>
	<div id="loginRegFormArea">
		<div id="loginForm" <?php print (is_array($this->getVar("reg_errors")) && sizeof($this->getVar("reg_errors")) > 0) ? " style='display:none'" : ""; ?>>
			<div class="heading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_login.gif' width='63' height='23' border='0'></div>
<?php
			print "<div>";
			print _t("Click here to %1register%2.", "<a href='#'  onclick='$(\"#loginForm\").slideUp(1); $(\"#registerForm\").slideDown(250); return false;'>", "</a>");
			print "</div>";

			if($this->getVar("loginMessage")){
				print "<div class='formErrors'>".$this->getVar("loginMessage")."</div>";
			}
	?>
				<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'login', array()); ?>" method="post" name="login">
					<div>
						<b><?php print _t("Email address"); ?></b><br/>
						<input type="text" name="username" />
					</div>
					<div>
						<b><?php print _t("Password"); ?></b><br/>
						<input type="password" name="password" style="float:left;" /> <a href="#" name="searchButtonSubmit" onclick="document.forms.login.submit(); return false;"> <div class="form-submit" style="margin-left:5px;"></div></a>
					</div>
					<div style="clear:left;"><?php print _t("Research for the <i>Isamu Noguchi Catalogue Raisonn&eacute;</i> is currently ongoing and information provided on this site is subject to change at any time. The site and its content are for noncommercial, educational, and scholarly use only. Unauthorized reproduction of images and content is strictly prohibited. By entering, I agree to the %1.", caNavLink($this->request, _t("Terms & Conditions of Use"), "", "", "About", "TermsConditions")); ?></div>
					<input type="submit" name="" value="" style="display:none;">
				</form>
				<div style="<?php print ($this->getVar("resetFormOpen")) ? "display:none;" : ""; ?>"><a href="#"  onclick='$("#resetPasswordLink").slideDown(1); $("#resetPasswordLink").slideUp(1); $("#resetPassword").slideDown(250); return false;' id="resetPasswordLink"><?php print _t("Forgot your password?"); ?></a></div>
			<div id="resetPassword" style="<?php print ($this->getVar("resetFormOpen")) ? "" : "display:none;"; ?>">
				<div class="heading"><?php print _t("Reset your password"); ?></div>
					<p>
	<?php
					print _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password.");
	?>
					</p>
			
					<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSend'); ?>" name="reset_password" method="post">
	<?php
						if($this->getVar("reset_email_error")){
							print "<div class='formErrors' style='text-align: left;'>".$this->getVar("reset_email_error")."</div>";
						}
	
	?>
						<div><b><?php print _t("Your e-mail address"); ?></b><br/>
							<input type="text" name="reset_email" value="" /><a href="#" class="button" onclick="document.forms.reset_password.submit(); return false;"><?php print _t("Go"); ?>  &rsaquo;</a>
						</div>
						<input type="hidden" name="action" value="send">
					</form>
			</div>
		</div><!-- end loginForm -->
		<div id="registerForm"<?php print (is_array($this->getVar("reg_errors")) && sizeof($this->getVar("reg_errors")) > 0) ? "" : " style='display:none'"; ?>">
			<div class="heading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_register.gif' width='95' height='23' border='0'></div>
			<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'register', array()); ?>" method="post" name="registration">
			<p>
<?php
				print _t("Please register to gain access to the <i>Isamu Noguchi Catalogue Raisonn&eacute;</i>");
?>
			</p>
<?php
				$va_errors = $this->getVar("reg_errors");
				
				
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
if($x){
				$va_research_fields = array("Art Collector", "Gallerist/Dealer", "Collections Manager", "Auction House Professional", "Appraiser", "Insurance Professional", "Librarian", "Curator", "Museum Professional", "Researcher/Scholar", "Educator", "Student", "Other");
				if($va_errors["field_of_research"]){
					print "<div class='formErrors' style='text-align: left;'>".$va_errors["field_of_research"]."</div>";
				}
				
?>
				<div><b><?php print _t("Field of Research"); ?></b><br/>
					<select name="field_of_research">
						<option value="">- please select -</option>
<?php
						foreach($va_research_fields as $vs_research_field){
							print "<option value='".$vs_research_field."'".(($_REQUEST["field_of_research"] == $vs_research_field) ? " selected" : "").">".$vs_research_field."</option>";
						}
?>
					</select>
				</div>
<?php
}
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
				
				
				
				if($va_errors["security"]){
					print "<div class='formErrors' style='text-align: left;'>".$va_errors["security"]."</div>";
				}
				$vn_num1 = rand(1,10);
				$vn_num2 = rand(1,10);
				$vn_sum = $vn_num1 + $vn_num2;
?>
				<div><b><?php print _t("Security Question (to prevent SPAMbots)"); ?></b><br/>
					<span id="securityText"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </span><input name="security" value="" id="security" type="text" size="3" style="width:30px;" />
				</div>
<?php
				if($va_errors["password"]){
					print "<div class='formErrors' style='text-align: left;'>".$va_errors["password"]."</div>";
				}
				print $this->getVar("password");
?>
				<div><b><?php print _t('Re-Type password'); ?></b><br/><input type="password" name="password2" size="60" /></div>
				<div><?php print _t("Research for the <i>Isamu Noguchi Catalogue Raisonn&eacute;</i> is currently ongoing and information provided on this site is subject to change at any time. The site and its content are for noncommercial, educational, and scholarly use only. Unauthorized reproduction of images and content is strictly prohibited. By registering, I agree to the %1.", caNavLink($this->request, _t("Terms & Conditions of Use"), "", "", "About", "TermsConditions")); ?></div>
				<div><a href="#" name="register" class="button" onclick="document.forms.registration.submit(); return false;"><?php print _t("Register"); ?> &rsaquo;</a></div>
				<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
			</form>	
		</div><!-- end registerForm -->
	</div><!-- end loginRegFormArea -->