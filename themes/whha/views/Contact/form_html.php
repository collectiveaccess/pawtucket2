<?php
/* ----------------------------------------------------------------------
 * views/Contact/form_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
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
$t_item = $this->getVar('t_item');
$o_config = caGetContactConfig();
$errors = $this->getVar("errors");
$page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
$table = $t_item ? $t_item->tableName() : null;
$id = $t_item ? $t_item->getPrimaryKey() : null;

$num1 = rand(1,10);
$num2 = rand(1,10);
$sum = $num1 + $num2;

$url = $name = $idno = '';
if($id > 0) {
	$url = $this->request->config->get("site_host").caDetailUrl($this->request, $table, $id);
	$name = $t_item->get("{$table}.preferred_labels");
	$idno = $t_item->get("{$table}.idno");
	$page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
}
?>
<H1><?= $page_title; ?></H1>
<?php
	if(is_array($errors["display_errors"]) && sizeof($errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $errors["display_errors"])."</div>";
	}
?>
<form id="contactForm" action="<?= caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">
	<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
<?php
if($id && $t_item->getPrimaryKey()){
?>
	<div class="bg-light px-4 pt-4 pb-2 mb-4">		
		<div class="row mt-2">
			<div class="col-sm-12 mb-4">
				<div class="pb-2"><b>Title: </b><?= $name; ?></div>
				<div class="pb-2"><b>Regarding this URL: </b><a href="<?= $url; ?>" class="text-break"><?= $url; ?></a></div>
				<input type="hidden" name="itemId" value="<?= $idno; ?>">
				<input type="hidden" name="itemTitle" value="<?= $name; ?>">
				<input type="hidden" name="itemURL" value="<?= $url; ?>">
				<input type="hidden" name="id" value="<?= $id; ?>">
				<input type="hidden" name="table" value="<?= $table; ?>">
			</div>
		</div>
	</div>
<?php
}
?>
<div class="row">
	<div class="col-md-8">
		<div class="bg-light px-4 pt-4 pb-2 mb-4">		
			<div class="row mt-2">
				<div class="col-md-6 mb-4">
					<label for="fname" class="form-label"><?= _t("First Name"); ?></label>
					<input type="text" class="form-control<?= (($errors["fname"]) ? " is-invalid" : ""); ?>" aria-label="enter first name" placeholder="Enter first name" name="fname" value="{{{fname}}}" id="fname">
				</div><!-- end col -->
				<div class="col-md-6 mb-4">
					<label for="lname" class="form-label"><?= _t("Last Name"); ?></label>
					<input type="text" class="form-control<?= (($errors["lname"]) ? " is-invalid" : ""); ?>" aria-label="enter last name" placeholder="Enter last name" name="lname" value="{{{lname}}}" id="lname">
				</div><!-- end col -->
			</div>
			<div class="row mt-2">
				<div class="col-md-6 mb-4">
					<label for="email" class="form-label"><?= _t("Email address"); ?></label>
					<input type="text" class="form-control<?= (($errors["email"]) ? " is-invalid" : ""); ?>" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
				</div><!-- end col -->
				<div class="col-md-6 mb-4">
					<label for="confirmemail" class="form-label"><?= _t("Confirm Email address"); ?></label>
					<input type="text" class="form-control<?= (($errors["confirmemail"]) ? " is-invalid" : ""); ?>" id="confirmemail" placeholder="Confirm Enter email" name="confirmemail" value="{{{confirmemail}}}">
					<div class="invalid-feedback"><?= (($errors["confirmemail"]) ? _t("Email addresses are invalid or do not match.") : _t("Email addresses do not match.")); ?></div>
				</div><!-- end col -->
			</div>
		<?php
			if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
		?>
				<div class="row">
					<script type="text/javascript">
						var gCaptchaRender = function(){
							grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
						};
					</script>
					<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
					<div class="col-12 mb-4">
						<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
					</div>
				</div><!-- end row -->
		<?php
			}
		?>
			
			<div class="row mb-2">
				<div class="col-12 mb-4">
					<label for="message" class="form-label"><?= _t("Message"); ?></label>
					<textarea class="form-control<?= (($errors["message"]) ? " is-invalid" : ""); ?>" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div><!-- end col -->
			</div><!-- end row -->
		</div>
			<div class="row mb-4">
				<div class="col-12 mb-4">
					<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-4">
		<div class="bg-light px-4 pt-4 pb-2 mb-4"><H2>Mission</H2>{{{contact_text}}}</div>
	</div>
</div>
<script>
	const form = document.querySelector('form');
	const email = document.getElementById('email');
	const confirmEmail = document.getElementById('confirmemail');
	
	function validateEmails() {
	  if (confirmEmail.value !== email.value) {
		confirmEmail.setCustomValidity('Invalid');
		confirmEmail.classList.add('is-invalid');
	  } else {
		confirmEmail.setCustomValidity('');
		confirmEmail.classList.remove('is-invalid');
	  }
	}
	
	confirmEmail.addEventListener('input', validateEmails);
	email.addEventListener('input', validateEmails);
	
	form.addEventListener('submit', function (event) {
	  validateEmails();
	  if (!form.checkValidity()) {
		event.preventDefault();
		event.stopPropagation();
	  }
	  form.classList.add('was-validated');
	});
</script>