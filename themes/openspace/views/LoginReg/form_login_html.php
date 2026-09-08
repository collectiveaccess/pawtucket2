<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
?> 
<div class="row">
	<div class="col-md-12 col-lg-8 offset-lg-2">
		<H1><?= _t("Login"); ?></H1>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-lg-8 offset-lg-2">
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
		<form id="LoginForm" action="<?= caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal needs-validation" method="POST" novalidate>
			<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
			<div class="row">
				<div class="col-md-12 col-lg-12">			
					<div class="bg-light px-4 pt-4 pb-2 mb-4">
						<div class="row">
							<div class="col mb-4">
								<label for="username" class="form-label"><?= _t("Username"); ?></label>
								<input type="text" class="form-control" id="username" name="username" autocomplete="off" required/>
								<div class="invalid-feedback">
									Please enter your username
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mb-4">
								<label for="password" class="form-label"><?= _t("Password"); ?></label>
								<input type="password" name="password" class="form-control" id="password" autocomplete="off" required/>
								<div class="invalid-feedback">
									Please enter your password
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mb-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="terms" required>
									<label class="form-check-label" for="terms">
										Agree to the   <a data-bs-toggle="collapse" href="#termsConditions" role="button" aria-expanded="false" aria-controls="termsConditions">terms and conditions</a>
									</label>
									<div class="collapse form-text py-3" id="termsConditions">
										<div class="overflow-y-scroll" style="max-height:300px;"><h2 class="fs-4">Terms & Conditions</h2>{{{terms_conditions}}}</div>
										<div class="text-center pt-2">
											<button class="btn btn-small btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#termsConditions" aria-expanded="false" aria-controls="termsConditions">Close</button>
										</div>
									</div>
									<div class="invalid-feedback">
										You must agree before logging in.
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col mb-4">
							<button type="submit" class="btn btn-primary"><?= _t("Login"); ?></button>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-4">
		<?php
			if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
				print '<div class="col-12 mb-2">'.caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array()).'</div>';
			}
			print "<div class='col-12 mb-2'>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array()).'</div>';
		?>
			</div>
		</form>
	</div>
</div>
<script>
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>