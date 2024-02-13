<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_register_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
 
	$va_errors = $this->getVar("errors");
	$t_user = $this->getVar("t_user");
	$co_security = $this->request->config->get('registration_security');
	if($co_security == 'captcha'){
		if((!defined("__CA_GOOGLE_RECAPTCHA_SECRET_KEY__") || !__CA_GOOGLE_RECAPTCHA_SECRET_KEY__) || (!defined("__CA_GOOGLE_RECAPTCHA_KEY__") || !__CA_GOOGLE_RECAPTCHA_KEY__)){
			//Then the captcha will not work and should not be implemenented. Alert the user in the console
			print "<script>console.log('reCaptcha disabled, please provide a valid site_key and secret_key to enable it.');</script>";
			$co_security = 'equation_sum';
		}
	}
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	if($this->request->isAjax()){}
?>

<script>
	// initialize CA Utils
	caUI.initUtils();
</script>

<div class="row">
	<div class="col">

		<h1><?= _t("Register"); ?></h1>

		<form class="row g-3 my-2" action="<?php print caNavUrl($this->request, "", "LoginReg", "register"); ?>" method="POST">
			<div class="col-md-4">
				<label for="inputFirstName" class="form-label"><?= _t("First Name"); ?></label>
				<input type="text" class="form-control" id="inputFirstName" aria-label="enter name" placeholder="Enter first name" required>
			</div>

			<div class="col-md-4">
				<label for="inputLastName" class="form-label"><?= _t("Last Name"); ?></label>
				<input type="text" class="form-control" id="inputLastName" aria-label="enter name" placeholder="Enter last name" required>
			</div>

			<div class="col-md-4">
				<label for="inputEmail" class="form-label"><?= _t("Email"); ?></label>
				<input type="email" class="form-control" id="inputEmail" aria-label="enter email" placeholder="Enter email" required>
			</div>

			<div class="col-md-4">
				<label for="inputPassword" class="form-label"><?= _t("Password"); ?></label>
				<input type="password" class="form-control" id="inputPassword" required>
			</div>

			<div class="col-md-4">
				<label for="inputPassword2" class="form-label"><?= _t("Re-Type Password"); ?></label>
				<input type="password" class="form-control" id="inputPassword2" required>
			</div>

			<div class="col-md-4">
				<label for="inputCode" class="form-label"><?= _t("Group Code (optional)"); ?></label>
				<input type="text" class="form-control" id="inputCode">
			</div>

			<div class="col-12">
				<button type="submit" class="btn btn-dark"><?= _t("Register"); ?></button>
			</div>
		</form>

	</div>
</div>

