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
		#$vn_label_col = 4;
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}
?>
	<div class="row">
		<div class="col-sm-6 col-md-5 introWrapper">
			<div class="loginIntro">
				<H1><?php print _t("Login"); ?></H1>
<?php
				print ($vs_login_intro = $this->getVar("login_intro")) ? "<p>".$vs_login_intro."</p>" : "";

				if($this->getVar("message")){
					print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
				}
?>
				<div id="termsError" class="alert alert-danger" style="display:none;">Please accept the terms and conditions</div>
				<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
					<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
					<div class="form-group">
						<label for="username" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Username"); ?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="username" name="username" autocomplete="off" />
						</div><!-- end col-sm-10 -->
					</div><!-- end form-group -->
					<div class="form-group">
						<label for="password" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Password"); ?></label>
						<div class="col-sm-10">
							<input type="password" name="password" class="form-control" id="password" autocomplete="off"/>
						</div><!-- end col-sm-10 -->
					</div><!-- end form-group -->
					<div class="form-group">
						<div class="col-sm-<?php print $vn_label_col; ?> text-right">
							<input type="checkbox" id="login_terms" name="login_terms" value="accept">
						</div>
						<div class="col-sm-10">
							I agree to the <a href="#" onClick="$('.hpTerms').slideToggle(); return false">Terms & Conditions</a>
						</div><!-- end col-sm-10 -->
					</div><!-- end form-group -->
					<div class="form-group">
						<div class="col-sm-offset-<?php print $vn_label_col; ?> col-sm-10">
							<button type="submit" class="btn btn-default">login</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-<?php print $vn_label_col; ?> col-sm-10">
<?php
					if($this->request->isAjax()){				
?>
						<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'resetForm', null); ?>');"><?php print _t("Forgot your password?"); ?></a>
<?php
					}else{
						print "<br/>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array());
					}
?>
						</div>
					</div><!-- end form-group -->
				</form>
				<div class="hpTerms">
					<div class="hpTermsText">
						<b>Terms & Conditions</b><br/>
						{{{terms_conditions}}}
					</div>
					<br/><p class="text-center"><a href="#" onClick="$('.hpTerms').slideToggle(); return false" class="btn btn-small btn-default"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Close</a></p>
				</div>
			</div><!-- end loginIntro -->
		</div><!-- end col -->
		<div class="col-sm-6 col-md-7">
			<div class="loginImage"><?php print caGetThemeGraphic($this->request, '434-SelfPortrait-1980.jpg', array("alt" => "Self Portrait")); ?></div>
		</div> <!--end col-->	
	</div><!-- end row -->
		
<?php
	if($this->request->isAjax()){
?>
		</div><!-- end caFormOverlay -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#LoginForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'LoginReg', 'login', null); ?>',
				jQuery('#LoginForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
	##### NOTE!!!!! ######
	# --- jquery in page footer to fade in form and size div for vertical alignment
?>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#LoginForm').submit(function(e) {
			if ($('#LoginForm').find('input[name="login_terms"]')[0].checked === false) {
				e.preventDefault();
				$('#termsError').fadeIn(800);
				return false;
			}
		});
	});
</script>