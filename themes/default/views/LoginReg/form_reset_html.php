			<H1><?php print _t("Reset Your Password"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
			switch($this->getVar("action")) {
				case 'send':
?>
					<div class="my-3 fs-4 fw-medium">
						<?php print _t("Instructions have been sent to the e-mail address you provided."); ?>
					</div>
					<div class="mb-3 fs-4">
						<?php print _t("You should receive the instructions within the hour. If you do not, contact us for assistance at "); ?>
						 <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</div>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_success':
		?>
					<div class='alert alert-success'><?php print _t("Your password has been reset!"); ?></div>
					<div class="my-3 fs-4">
						<?php print _t("You may now"); ?> <?php print caNavLink($this->request, _t("login"), "", "", "LoginReg", "loginForm"); ?>.
					</div>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_failure':
		?>
					<div class="my-3 fs-4">
						<?php print _t("Please confirm you have copied the provided link properly.  If you continue to have difficulty, contact us for assistance,"); ?> <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</div>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				case 'reset':
		?>
					<div class="my-3 fs-4"><?php print _t("Please enter your new password."); ?></div>
					<form id="ResetForm" action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSave'); ?>" method="post" class="form-horizontal" method="POST">
					<div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="bg-light px-4 pt-4 pb-2 mb-4">
								<div class="row">
									<div class="col mb-4">
										<label for="password" class="form-label"><?php print _t("New password"); ?></label>
										<input type="password" name="password" class="form-control" id="password" autocomplete="off" />
									</div>
								</div>
								<div class="row">
									<div class="col mb-4">
										<label for="password" class="form-label"><?php print _t("Confirm new password"); ?></label>
										<input type="password" name="password_confirm" class="form-control" id="password_confirm" autocomplete="off" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 mb-4">
							<button type="submit" class="btn btn-primary"><?php print _t("Save"); ?></button>
						</div>
					</div>
						<input type="hidden" name="key" value="<?php print $this->getVar("key"); ?>">
						<input type="hidden" name="action" value="reset_save">
					</form>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				default:
?>
					<div class="my-3 fs-4"><?php print _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password."); ?></div>
					<form id="ResetForm" action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSend'); ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-md-12 col-lg-6">			
							<div class="bg-light px-4 pt-4 pb-2 mb-4">
								<div class="row">
									<div class="col mb-4">
										<label for="reset_email" class="form-label"><?php print _t("E-mail"); ?></label>
										<input type="test" name="reset_email" class="form-control" id="reset_email" autocomplete="off" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col mb-4">
							<button type="submit" class="btn btn-primary"><?php print _t("Send"); ?></button>
						</div>
					</div>
					</form>
<?php				
					break;
				# ---------------------------------------------------------------------------------------------
			}
?>