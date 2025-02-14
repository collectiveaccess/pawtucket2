<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Bam/verify_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024-2025 Whirl-i-Gig
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
if($this->request->isAjax()) { return; }
$errors = $this->getVar('errors');

if(is_array($errors) && sizeof($errors)){
	print "<div class='alert alert-danger'>".implode("<br />", $errors)."</div>";
}
?>

<?= caFormTag($this->request, 'confirm', 'banCaptcha', 'Ban', 'post', 'multipart/form-data', '_top', ['disableUnsavedChangesWarning' => true]); ?>
	<div class="bg-light px-4 pt-4 pb-2 mb-4">
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {
                	'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>',
                	'callback': function() {
                		jQuery('#regCaptchaSubmit').show()
                	}
                });
        	};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
		<div class="row justify-content-center">
			<div class="col-12 col-md-10">
				<div class='banHeadline'>
					<h1><?= _t('Please confirm that you are not a robot'); ?></h1>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 col-md-6">
				<div class='banDescription'>
					<?= _t("We have a hunch that you might be a robot scanning this site for data. Please click on the <i>I'm not a robot</i> button and follow the provided instructions to confirm your status as a sentient human being."); ?>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 text-center">
				<div class='form-group<?= (($errors["recaptcha"]) ? " has-error" : ""); ?> d-flex justify-content-center'>
					<div id="regCaptcha" class=""></div>
				</div>
			</div>
		</div><!-- end row -->
		
		<div class="row justify-content-center mb-4">
			<div class="col-12 col-md-10 text-center">
				<div id='regCaptchaSubmit' class="banContinue d-flex justify-content-center">
					<button href="#" class="btn btn-primary" id="banContinueButton" onclick="document.getElementById('banCaptcha').submit(); return false;">
                        <?= _t('Click here to continue'); ?>
                    </button>
				</div>
			</div>
		</div>

<?php
	} else {
?>
	<div class="row justify-content-center">
		<div class="col-12 col-md-10">
			<div class='banHeadline'>
				<h1><?= _t('We think you might be a robot'); ?></h1>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-12 col-md-6">
			<div class='banDescription'>
				<?= _t("We have a hunch that you might be a robot scanning this site for data. If you're a real, live sentient human being please contact the site administrator at <a href='mailto:%1'>%1</a> to regain access.", __CA_ADMIN_EMAIL__); ?>
			</div>
		</div>
	</div>
<?php
	}
?>
	</div>
</form>
