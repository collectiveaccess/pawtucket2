<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$vn_label_col = 2;
?>
<div class="uk-section-default uk-section">
<div class="container unit">	
	<div class="row">
		<div class="col-sm-5 fullWidthImg maxWidth text-center">
			<?php print caGetThemeGraphic($this->request, 'Chirkof-Reburial.jpg', array("alt" => "Chirkof Reburial")); ?>
		</div>
		<div class="col-sm-7">
			<hr class="uk-divider-small">
			<h2 class="uk-h1">How to Access the Repatriation Database</h2>
			<p>{{{repatriation_login_intro}}}</p>
			<div class="unit text-center"><a href="mailto:amanda@alutiiqmuseum.org" target="_blank" class="uk-button uk-button-default"><span class="uk-margin-small-right uk-icon" uk-icon="mail"><svg width="20" height="20" viewBox="0 0 20 20"><polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline><path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path></svg></span> Contact Us</a></div>		
		</div>
	</div><!-- end row -->
</div>
</div>
<div class="uk-section">
<div class="container unit">
	<div class="uk-card-default uk-card uk-card-body">    
		<hr class="uk-divider-small">
		<h3 class="uk-h2"><?php print _t("Login"); ?></h3>
		<div class="row unitLarge">	
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" method="POST">
				<input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="form-group">
					<label for="username" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Username"); ?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="username" name="username" autocomplete="off" />
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<label for="password" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Password"); ?></label>
					<div class="col-sm-7">
						<input type="password" name="password" class="form-control" id="password" autocomplete="off"/>
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-offset-<?php print $vn_label_col; ?> col-sm-7">
						<button type="submit" class="uk-button uk-button-default">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div></div>