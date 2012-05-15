<?php
	global $g_ui_locale;
?>
			<div id="loginForm">
				<h1 style='text-align: center; margin-bottom:10px'><?php print _t("Login"); ?></h1>
<?php
				if($this->getVar("loginMessage")){
					print "<div class='formErrors'>".$this->getVar("loginMessage")."</div>";
				}
?>
				<div >
					<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'login', array()); ?>" method="post" name="login">
						<div style='clear:both; padding-bottom:20px;'>
							<span ><?php print _t("Username"); ?></span>
							<input style='float:right' type="text" name="username" />
						</div>
						<div style='clear:both'>
							<span><?php print _t("Password"); ?></span>
							<input style='margin-bottom:10px; float:right;' type="password" name="password" /><br/>
							<div style='float:right; width:200px; clear:left;'><a href="#" name="login" class="button" onclick="document.forms.login.submit(); return false;"><?php print _t("Submit"); ?></a></div>
							<input type="submit" value="Submit" style="position: absolute; top: 0; left: 0; z-index: 0; width: 1px; height: 1px; visibility: hidden;" />
						</div>
						
						
					</form>					
				</div><!-- end bg -->
				<div style="<?php print ($this->getVar("resetFormOpen")) ? "display:none;" : ""; ?>"><a href="#"  onclick='jQuery("#resetPasswordLink").slideDown(1); $("#resetPasswordLink").slideUp(1); jQuery("#resetPassword").slideDown(250); return false;' id="resetPasswordLink" style='clear:both; float:right'><?php print _t("Forgot your password?"); ?></a></div>
				<div id="resetPassword" style="<?php print ($this->getVar("resetFormOpen")) ? "" : "display:none;"; ?>">
					
					<div class="lbg">
					<h1 style='text-align:center; clear:both'><?php print _t("Reset your password"); ?></h1>
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
							<div style='text-align:right;'><span><?php print _t("Email"); ?></span>
								<input type="text" style='margin-bottom:10px;' name="reset_email" value="" /><br/><a href="#" class="button" style='margin: 10px 0px 0px 10px;' onclick="document.forms.reset_password.submit(); return false;"><?php print _t("Submit"); ?></a>
							</div>
							<input  type="hidden" name="action" value="send">
						</form>
					</div>
				</div>
				
			</div><!-- end loginForm -->
			