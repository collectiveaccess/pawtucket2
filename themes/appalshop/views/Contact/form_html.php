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
<div class="mb-2">{{{contact_intro}}}</div>
<form id="contactForm" action="<?= caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">
	<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
<?php
if($id && $t_item->getPrimaryKey()){
?>
	<div class="bg-light px-4 pt-4 pb-2 mb-4">		
		<div class="row mt-2">
			<div class="col-sm-12 mb-4">
				<div class="pb-2"><b>Title: </b><?= $name; ?></div>
				<div class="pb-2"><b>Regarding this URL: </b><a href="<?= $url; ?>" class="purpleLink"><?= $url; ?></a></div>
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
<div class="bg-light px-4 pt-4 pb-2 mb-4">		
	<div class="row mt-2">
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="name" class="form-label"><?= _t("Name (required)"); ?></label>
			<input type="text" class="form-control<?= (($errors["name"]) ? " is-invalid" : ""); ?>" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}" id="name">
		</div><!-- end col -->
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="email" class="form-label"><?= _t("Email address (required)"); ?></label>
			<input type="text" class="form-control<?= (($errors["email"]) ? " is-invalid" : ""); ?>" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
		</div><!-- end col -->
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="phone" class="form-label"><?= _t("Phone number"); ?></label>
			<input type="text" class="form-control<?= (($errors["phone"]) ? " is-invalid" : ""); ?>" aria-label="enter phone number" placeholder="Enter your phone number" name="phone" value="{{{phone}}}" id="phone">
		</div><!-- end col -->
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
				grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
			};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
		<div class="col-md-4 mb-4">
			<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
		</div>
<?php
	}
?>
	</div><!-- end row -->
	<div class="row mb-2">
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="message" class="form-label"><?= _t("Message (required)"); ?></label>
			<textarea class="form-control<?= (($errors["message"]) ? " is-invalid" : ""); ?>" id="message" name="message" rows="5">{{{message}}}</textarea>
		</div><!-- end col -->
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="licensing" class="form-label"><?= _t("Interested in licensing materials from the Archive?"); ?></label>
			<textarea class="form-control<?= (($errors["licensing"]) ? " is-invalid" : ""); ?>" id="licensing" name="licensing" rows="5">{{{licensing}}}</textarea>
		</div><!-- end col -->
		<div class="col-lg-8 col-xl-4 mb-4">
			<label for="project" class="form-label"><?= _t("Tell us about your project"); ?></label>
			<textarea class="form-control<?= (($errors["project"]) ? " is-invalid" : ""); ?>" id="project" name="project" rows="5">{{{project}}}</textarea>
		</div><!-- end col -->
	</div><!-- end row -->
</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
			<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
		</div>
	</div>
</form>
