<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2017 Whirl-i-Gig
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
	<div class="row mt-5 mb-5">
		<div class="col-sm-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
			<H1><?php print _t("Login"); ?></H1>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
				<form id="LoginForm" action="<?php print caNavUrl("", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
					<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
					<div class="form-group">
						<label for="username"><?php print _t("Username"); ?></label>
						<input type="text" class="form-control" id="username" name="username" autocomplete="off" />
					</div><!-- end form-group -->
					<div class="form-group">
						<label for="password"><?php print _t("Password"); ?></label>
						<input type="password" name="password" class="form-control" id="password" autocomplete="off"/>
					</div><!-- end form-group -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
					<div class="form-group">
<?php
					if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
						print caNavLink(_t("Click here to register"), "", "", "LoginReg", "registerForm", array());
					}
					print "<br/>".caNavLink(_t("Forgot your password?"), "", "", "LoginReg", "resetForm", array());
?>
					</div><!-- end form-group -->
				</form>
			</div>
		</div>