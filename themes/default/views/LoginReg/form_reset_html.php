
<div class="row">
	<div class="col">
		<h1><?= _t("Reset Your Password"); ?></h1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
			switch($this->getVar("action")) {
				case 'send':
?>
					<p><?php print _t("Instructions have been sent to the e-mail address you provided."); ?></p>
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
					<p>
						<?php print _t("You may now"); ?> <?php print caNavLink($this->request, _t("login"), "", "", "LoginReg", "loginForm"); ?>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_failure':
		?>
					<p>
						<?php print _t("Please confirm you have copied the provided link properly.  If you continue to have difficulty, contact us for assistance,"); ?> 
						<a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				case 'reset':
		?>
					<p><?= _t("Please enter your new password."); ?></p>

					<form class="row g-3 my-2" action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSave'); ?>" method="POST">
						<div class="col-md-4">
							<label for="inputPassword" class="form-label"><?= _t("New Password"); ?></label>
							<input type="password" class="form-control" id="inputPassword" required autocomplete="off">
						</div>

						<div class="col-md-4">
							<label for="inputPassword2" class="form-label"><?= _t("Confirm new password"); ?></label>
							<input type="password" class="form-control" id="inputPassword2" required autocomplete="off">
						</div>

						<div class="col-12">
							<button type="submit" class="btn btn-dark"><?= _t("Register"); ?></button>
						</div>
					</form>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				default:
?>

					<p><?= _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password."); ?></p>
					<form class="row row-cols-auto g-3 align-items-end" action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSend'); ?>" method="post">
						<div class="col-6">
							<label for="resetEmail" class="form-label"><?= _t("Email"); ?></label>
							<input type="email" class="form-control" id="resetEmail" aria-label="enter email" placeholder="Enter email" required>
						</div>

						<div class="col-3">
							<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
						</div>
					</form>

<?php				
					break;
				# ---------------------------------------------------------------------------------------------
			}

?>	
	</div>
</div>

