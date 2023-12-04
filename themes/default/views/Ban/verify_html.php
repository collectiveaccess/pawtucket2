<?php
if($this->request->isAjax()) { return; }
$errors = $this->getVar('errors');

if(is_array($errors)) {
	foreach($errors as $e) {
		print "Error: $e\n<br/>";
	}
}
?>

<?= caFormTag($this->request, 'confirm', 'banCaptcha', 'Ban', 'post', 'multipart/form-data', '_top', ['disableUnsavedChangesWarning' => true]); ?>


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
        	jQuery(document).ready(function() {
        		jQuery('#banContinueButton').on('click', function() {
        			jQuery('#banCaptcha').submit(); 
        			return false;
        		});
        	});
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class='banHeadline'>
					<h1><?= _t('Please confirm that you are not a robot'); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-offset-3 col-md-6">
				<div class='banDescription'>
					<?= _t("We have a hunch that you might be a robot scanning this site for data. Please click on the <i>I'm not a robot</i> button and follow the provided instructions to confirm your status as a sentient human being."); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class='form-group<?= (($errors["recaptcha"]) ? " has-error" : ""); ?>'>
					<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
				</div>
			</div>
		</div><!-- end row -->
		
		<div id='regCaptchaSubmit' class='banContinue'>
			<span class="btn btn-default"><a href="#" id='banContinueButton'><?= _t('Click here to continue'); ?></a></span>
		</div>
<?php
	} else {
?>
	<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class='banHeadline'>
					<h1><?= _t('We think you might be a robot'); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-offset-3 col-md-6">
				<div class='banDescription'>
					<?= _t("We have a hunch that you might be a robot scanning this site for data. If you're a real, live sentient human being please contact the site administrator at <a href='mailto:%1'>%1</a> to regain access.", __CA_ADMIN_EMAIL__); ?>
				</div>
			</div>
		</div>
<?php
	}
?>
</form>
