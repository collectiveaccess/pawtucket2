<?php
/* ----------------------------------------------------------------------
 * themes/default/views/LoginReg/form_login_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
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
 
	$vn_label_col = 2;
	if($this->request->isAjax()){
		$vn_label_col = 4;
?>
		<div id="caFormOverlay" class="caFormOverlayLogin">
			<div class="loginFormHeader">
				<div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
				<?php print caGetThemeGraphic($this->request, 'steelcaseLoginLogo.png'); ?>
			</div>
<?php
	}else{
?>
			<H1><?php print _t("Login"); ?></H1>
<?php	
	}

	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
				<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="text" class="form-control" id="username" name="username" placeholder="Email">
					</div><!-- end col -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-12">
						<input type="password" name="password" class="form-control" id="password" placeholder="Password" />
					</div><!-- end col -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default">Log In</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
<?php
					print caNavLink($this->request, _t("INSTRUCTIONS"), "", "", "About", "login_instructions", array());
?>
					</div>
				</div><!-- end form-group -->
			</form>
<?php
	if($this->request->isAjax()){
?>
		</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#LoginForm').submit(function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'login', null); ?>',
				jQuery('#LoginForm').serialize()
			);
			e.preventDefault();
			window.location.replace('<?php print caNavUrl($this->request, '', 'Browse', 'occurrences'); ?>');
			return false;
		});
	});
</script>
<?php
	}
?>