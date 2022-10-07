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
 
	$vn_benefit_id = $this->request->config->get("virtual_benefit_id");
	$vs_disabled = " disabled";
	if($vn_benefit_id){
		$t_occurrences = new ca_occurrences($vn_benefit_id);
		if($t_occurrences->get("ca_occurrences.access") == 1){
			$vs_disabled = "";
		}
	}
	$vn_label_col = 3;
	if($this->request->isAjax()){
		$vn_label_col = 4;
?>
		<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}else{
?>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
<?php
	}
?>
			<H1 class='text-center'><?php print _t("Virtual Benefit Login"); ?></H1>
			<br/><p class='text-center'>{{{benefitLoginText}}}</p><br/>
<?php
	if($this->getVar("message")){
		print "<div class='alert alert-danger'>".$this->getVar("message")."</div>";
	}
?>
			<H2 class="text-center" id="demo"></H2>
			<form id="LoginForm" action="<?php print caNavUrl($this->request, "", "LoginReg", "login"); ?>" class="form-horizontal" role="form" method="POST">
				<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="form-group">
					<label for="username" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Username"); ?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="username" name="username"<?php print $vs_disabled; ?>>
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<label for="password" class="col-sm-<?php print $vn_label_col; ?> control-label"><?php print _t("Password"); ?></label>
					<div class="col-sm-7">
						<input type="password" name="password" class="form-control" id="password" <?php print $vs_disabled; ?>/>
					</div><!-- end col-sm-7 -->
				</div><!-- end form-group -->
				<div class="form-group">
					<div class="col-sm-offset-<?php print $vn_label_col; ?> col-sm-7">
						<button type="submit" class="btn btn-default<?php print ($vs_disabled) ? " disabled" : ""; ?>" <?php print $vs_disabled; ?>><?php print _t("login"); ?></button>
					</div>
				</div>
				
				

<script>
// Set the date we're counting down to
var countDownDate = new Date("Oct 15, 2022 09:00:00").getTime();
//var countDownDate = new Date("Oct 7, 2022 15:57:00").getTime();
var initNow = new Date().getTime();
var initDistance = countDownDate - initNow;
if (initDistance > 0) {
	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get today's date and time
	  var now = new Date().getTime();
	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		if (distance > 0) {
		  // Display the result in the element with id="demo"
		  var timeleft = "";
		  if(days > 0){
			timeleft = days + " day";
			if(days > 1){
				timeleft += "s ";
			}else{
				timeleft += " ";
			}
		  }
		  if(hours > 0){
			timeleft += hours + " hour";
			if(hours > 1){
				timeleft += "s ";
			}else{
				timeleft += " ";
			}
		  }
		  if(minutes > 0){
			timeleft += minutes + " minute";
			if(minutes > 1){
				timeleft += "s ";
			}else{
				timeleft += " ";
			}
		  }
		  if(seconds > 0){
			timeleft +=  seconds + " seconds ";
		  }
		  document.getElementById("demo").innerHTML = "Login opens in " + timeleft;
		}
	  // If the count down is finished, write some text
	  if (distance < 0) {
		clearInterval(x);
		document.getElementById("demo").innerHTML = "Please refresh the page to login!";
		//$('#LoginForm input').removeAttr("disabled");
		//$('#LoginForm button').removeAttr("disabled");
		//$('#LoginForm button').removeClass("disabled");
	  }
	}, 1000);

}
</script>

				<div class="form-group">
					<div class="col-sm-offset-<?php print $vn_label_col; ?> col-sm-7">
<?php
			# --- don't show standard login reg / reset links - this is only for benefit patrons
			if($x){
				if($this->request->isAjax()){
				
					if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) {
?>
					<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'registerForm', null); ?>');"><?php print _t("Click here to register"); ?></a>
					<br/>
<?php
					}
?>
					<a href="#" onClick="jQuery('#caMediaPanelContentArea').load('<?php print caNavUrl($this->request, '', 'LoginReg', 'resetForm', null); ?>');"><?php print _t("Forgot your password?"); ?></a>
<?php
				}else{
					if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) {
						print caNavLink($this->request, _t("Click here to register"), "", "", "LoginReg", "registerForm", array());
					}
					print "<br/>".caNavLink($this->request, _t("Forgot your password?"), "", "", "LoginReg", "resetForm", array());
				}
			}
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
			return false;
		});
	});
</script>
<?php
	}else{
?>
			</div>
		</div>
<?php
	}
?>