<?php
	global $g_ui_locale;

	JavascriptLoadManager::register("cycle");
?>
		<div id="loginRegFeatured">
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_2.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_4.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_3.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_5.jpg" width="500" height="625" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/homePage/hp_1.jpg" width="500" height="625" border="0"></div>
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
		<div id="forgotPW">
		<div class="heading"><?php print _t("Reset your password"); ?></div>
<?php
		switch($this->getVar("action")) {
			case 'send':
	?>
				<p>
					<?php print _t("Instructions have been sent to the e-mail address you provided."); ?>
				</p>
				<p>
					<?php print _t("You should receive the instructions within the hour. If you do not, contact us for assistance, "); ?>
					 <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
				</p>
	<?php
				break;
			
			# ---------------------------------------------------------------------------------------------
			case 'reset_success':
	?>
				<div align="center" class="formErrors">
					<?php print _t("Your password has been reset!"); ?>
				</div>
				<p align="center">
					<?php print _t("You may now"); ?> <?php print caNavLink($this->request, _t("login"), "", "", "LoginReg", "form"); ?>.
				</p>
	<?php
				break;
			
			# ---------------------------------------------------------------------------------------------
			case 'reset_failure':
	?>
				<div align="center" class="formErrors">
					<?php print _t("Your password could not be reset!"); ?>
				</div>
				<p align="center">
					<?php print _t("Please contact us for assistance,"); ?> <a href="mailto:<?php print $this->getVar("email"); ?>" class="content"><?php print $this->getVar("email"); ?></a>.
				</p>
	<?php
				break;
			
			# ---------------------------------------------------------------------------------------------	
			case 'reset':
			default:
	?>
				<form action="exhibit/index.php/LoginReg/resetSave/" method="post" name="reset_password" id="resetPasswordForm">
					<p><?php print _t("Please enter your new password."); ?></p>
<?php
						if($this->getVar("password_error")){
							print "<div class='formErrors' style='text-align: left;'>".$this->getVar("password_error")."</div>";
						}

?>
					<div><b><?php print _t("New password"); ?></b><br/>
						<input type="password" name="password" value="" maxlength="100"/>
					</div>
					<div style="margin-top:10px;"><b><?php print _t("Confirm new password"); ?></b><br/>
						<input type="password" name="password_confirm" value="" maxlength="100"/>
					</div>
					<div style="margin-top:10px;">
						<a href="#" class="button" onclick="document.forms.reset_password.submit(); return false;"><?php print _t("Save"); ?></a>
					</div>
					<input type="hidden" name="action" value="reset_save">
					<input type="hidden" name="key" value="<?php print $this->getVar("key"); ?>">
				</form>
	<?php
				break;
			
			# ---------------------------------------------------------------------------------------------
		}
?>
		</div>
	</div>