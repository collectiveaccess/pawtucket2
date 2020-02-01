<div class="row mt-5 mb-5">
	<div class="col-sm-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
		<H1><?php print _t("Reset Your Password"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
			switch($this->getVar("action")) {
				case 'send':
?>
					<p>
						<?php print _t("Instructions have been sent to the e-mail address you provided."); ?>
					</p>
					<p>
						<?php print _t("You should receive the instructions within the hour. If you do not, contact us for assistance at "); ?>
						 <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_success':
		?>
					<div class='alert alert-success'><?php print _t("Your password has been reset!"); ?></div>
					<p align="center">
						<?php print _t("You may now"); ?> <?php print caNavLink(_t("login"), "", "", "LoginReg", "loginForm"); ?>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_failure':
		?>
					<p align="center">
						<?php print _t("Please confirm you have copied the provided link properly.  If you continue to have difficulty, contact us for assistance,"); ?> <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				case 'reset':
		?>
					<p><?php print _t("Please enter your new password."); ?></p>
					<form id="ResetForm" action="<?php print caNavUrl('', 'LoginReg', 'resetSave'); ?>" method="post" class="form-horizontal" role="form" method="POST">


						<div class="form-group">
							<label for="password"><?php print _t("New password"); ?></label>
							<input type="password" name="password" class="form-control" id="password" autocomplete="off" />
						</div><!-- end form-group -->
						<div class="form-group">
							<label for="password"><?php print _t("Confirm new password"); ?></label>
							<input type="password" name="password_confirm" class="form-control" id="password_confirm" autocomplete="off" />
						</div><!-- end form-group -->
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Save</button>
						</div><!-- end form-group -->
						<input type="hidden" name="key" value="<?php print $this->getVar("key"); ?>">
						<input type="hidden" name="action" value="reset_save">
					</form>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				default:
?>
					<p><?php print _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password."); ?></p>
					<form id="ResetForm" action="<?php print caNavUrl('', 'LoginReg', 'resetSend'); ?>" method="post" class="form-horizontal" role="form">
						<div class="form-group">
							<label for="reset_email"><?php print _t("E-mail"); ?></label>
							<input type="test" name="reset_email" class="form-control" id="reset_email" autocomplete="off" />
						</div><!-- end form-group -->
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Send</button>
						</div><!-- end form-group -->
					</form>
<?php				
					break;
				# ---------------------------------------------------------------------------------------------
			}
?>
			</div>
		</div>