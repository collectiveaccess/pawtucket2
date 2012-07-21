<?php
	global $g_ui_locale;
?>
			<div id="loginForm">
				<h1 style="text-align:center; margin-bottom:30px;"><?php print _t("Login"); ?></h1>
<?php
				if($this->getVar("loginMessage")){
					print "<div class='formErrors'>".$this->getVar("loginMessage")."</div>";
				}
?>
				<div >
					<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'login', array()); ?>" method="post" name="login">
						<div>
							<div style='width:90px; float:left; margin-top:19px; margin-bottom: 10px; font-family: "Vollkorn";'><b><?php print _t("Username"); ?></b></div>
							<div style='float:right;'><input type="text" name="username" /></div>
						</div>
						<div>
							<div style='width:90px; float:left; font-family: "Vollkorn";'><b><?php print _t("Password"); ?></b></div>
							<div style='float:right; margin-top:3px;'><input type="password" name="password" /><br/>
							<div style="<?php print ($this->getVar("resetFormOpen")) ? "display:none;" : ""; ?>; float:left; clear:both;"><a href="#"  onclick='jQuery("#resetPasswordLink").slideDown(1); $("#resetPasswordLink").slideUp(1); jQuery("#resetPassword").slideDown(250); return false;' id="resetPasswordLink"><?php print _t("Forgot your password?"); ?></a></div>
							</div>
							<a href="#" name="login" class="button" onclick="document.forms.login.submit(); return false;"><?php print _t("Login") ; ?></a>
						</div>
						<input type="submit" value="Submit" style="position: absolute; top: 0; left: 0; z-index: 0; width: 1px; height: 1px; visibility: hidden;" /> 
						
					</form>					
				</div><!-- end bg -->
				
				<div id="resetPassword" style="<?php print ($this->getVar("resetFormOpen")) ? "" : "display:none;"; ?>; clear:both;">
					
					<div >
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
							<div style="font-family: 'Vollkorn'"><div style='width: 90px; float:left; margin-top:3px; font-family: "Vollkorn";'><b><?php print _t("E-mail"); ?></b></div>
								<input type="text" name="reset_email" value="" /><br/>
								<a href="#" class="button" onclick="document.forms.reset_password.submit(); return false;"><?php print _t("Submit"); ?></a>
							</div>
							<input type="hidden" name="action" value="send">
						</form>
					</div>
				</div>
				
			</div><!-- end loginForm -->
			