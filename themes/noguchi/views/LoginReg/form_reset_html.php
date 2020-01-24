<main id="main" role="main" class="ca archive">

	<section>
		<div class="wrap">
            <div class="wrap-text-large">
				<div class="block-quarter">
					<H3 class="subheadline-bold text-align-center"><?php print _t("Reset Your Password"); ?></H3>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
			switch($this->getVar("action")) {
				case 'send':
?>
					<p class='text-align-center'>
						<?php print _t("Instructions have been sent to the e-mail address you provided."); ?>
					</p>
					<p class='text-align-center'>
						<?php print _t("You should receive the instructions within the hour. If you do not, contact us for assistance at "); ?>
						 <a href="mailto:<?php print $this->getVar("email"); ?>"><?php print $this->getVar("email"); ?></a>.
					</p>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------
				case 'reset_success':
		?>
					<div class='alert alert-success text-align-center'><?php print _t("Your password has been reset!"); ?></div>
					<p align="center">
						<br/><?php print caNavLink(_t("Login"), "button", "", "LoginReg", "loginForm"); ?>
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
					<p><H4><?php print _t("Please enter your new password."); ?></b></H4></p>
					<form id="ResetForm" action="<?php print caNavUrl('', 'LoginReg', 'resetSave'); ?>" method="post" class="form-horizontal" role="form" method="POST">


						<div class="block-half">
							<label for="password" class="eyebrow"><?php print _t("New password"); ?></label><br/>
							<input type="password" name="password" class="form-control" id="password" autocomplete="off" />
						</div>
						<div class="block-half">
							<label for="password" class="eyebrow"><?php print _t("Confirm new password"); ?></label><br/>
							<input type="password" name="password_confirm" class="form-control" id="password_confirm" autocomplete="off" />
						</div>
						<div class="block-half">
							<button type="submit" class="button">Save</button>
						</div><!-- end form-group -->
						<input type="hidden" name="key" value="<?php print $this->getVar("key"); ?>">
						<input type="hidden" name="action" value="reset_save">
					</form><br/>
		<?php
					break;
				
				# ---------------------------------------------------------------------------------------------	
				default:
?>
					<p><?php print _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password."); ?></p>
					<form id="ResetForm" action="<?php print caNavUrl('', 'LoginReg', 'resetSend'); ?>" method="post" role="form">
							<div class="block-half">
								<input type="text" name="reset_email" id="reset_email" autocomplete="off" placeholder="Email Address" />
						 	</div>
						 	<div class="block-half text-align-center">
								<button type="submit" class="button">Send</button>
							</div>
					</form>
<?php				
					break;
				# ---------------------------------------------------------------------------------------------
			}

?>
					</div>
				</div>
			</div>
	</section>
</main>