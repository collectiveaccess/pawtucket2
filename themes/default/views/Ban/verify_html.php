<?php
$errors = $this->getVar('errors');

if(is_array($errors)) {
	foreach($errors as $e) {
		print "Error: $e\n<br/>";
	}
}
?>

<?= caFormTag($this->request, 'confirm', 'banCaptcha', 'Ban', 'post', 'multipart/form-data', '_top'); ?>

<div style="text-align: center">
	<h1>Please confirm that you are not a robot</h1>
</div>

<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
        	};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class='form-group<?= (($errors["recaptcha"]) ? " has-error" : ""); ?>'>
					<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
				</div>
			</div>
		</div><!-- end row -->
		
		<div style="text-align: center">
			<input type='submit' value='I am not a robot'/>
		</div>
<?php
	}
?>
</form>
