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
$ps_contactType = $this->request->getParameter("contactType", pString);
	
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
$va_reasons = array("School Paper", "Research Paper or Other Academic Publication","Upcoming Research Visit to the Museum", "Documentation on a Specific Survivor or Victim", "Family History", "Personal Interest", "Photographs", "Film Footage", "Lesson Planning or Curriculum Development", "Donating Items to the Museum", "Other");
$va_education_levels = array("Intermediate; Middle School", "Secondary; High School", "Undergraduate", "Graduate School; Postgraduate", "Other");
	
?>
<H1><?= $page_title; ?></H1>
<?php
	if(is_array($errors["display_errors"]) && sizeof($errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $errors["display_errors"])."</div>";
	}
?>
<form id="contactForm" action="<?= caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">
	<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
	<div class="bg-light px-4 pt-4 pb-2 mb-4">		
	
<?php
if($id && $t_item->getPrimaryKey()){
?>
		<div class="row mt-2">
			<div class="col-sm-12 mb-4">
				<div class="pb-4">Please use this form to provide us with any information about our catalog. For example, do you recognize someone in a photograph? Can you add to our knowledge about this item? Have we made a mistake of any kind? We want to hear from you.</div>
				<div class="pb-2"><b>Item Title: </b><?= $name; ?></div>
				<div class="pb-2"><b>Item Identifier: </b><?= $idno; ?></div>
				<div class="pb-2"><b>Regarding this URL: </b><a href="<?= $url; ?>" class="text-break"><?= $url; ?></a></div>
				<input type="hidden" name="itemId" value="<?= $idno; ?>">
				<input type="hidden" name="itemTitle" value="<?= $name; ?>">
				<input type="hidden" name="itemURL" value="<?= $url; ?>">
				<input type="hidden" name="id" value="<?= $id; ?>">
				<input type="hidden" name="table" value="<?= $table; ?>">
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-md-10 mb-4">
				<label for="message" class="form-label"><?= _t("Your Message"); ?></label>
				<textarea class="form-control<?= (($errors["message"]) ? " is-invalid" : ""); ?>" id="message" name="message" rows="5">{{{message}}}</textarea>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
}else{
?>
		<div class="row mb-2">
			<div class="col-md-10 mb-4">
				<label for="information" class="form-label"><?= _t("What information are you seeking?"); ?></label>
				<textarea class="form-control<?= (($errors["information"]) ? " is-invalid" : ""); ?>" id="information" name="information" rows="5">{{{information}}}</textarea>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row mt-2">
			<div class="col-md-5 mb-4">
				<label for="reason" class="form-label"><?= _t("What is the reason for your request?"); ?></label><br/><br/>
				<select class="form-select" id="reason" name="reason">
					<option value="">Choose...</option>
<?php
						foreach($va_reasons as $vs_reason){
							print "<option value='".$vs_reason."'".(($vs_reason == $this->getVar("reason")) ? " selected" : "").">".$vs_reason."</option>";
						}
?>
				</select>
			</div><!-- end col -->
			<div class="col-md-5 mb-4">
				<label for="education" class="form-label"><?= _t("If your research is for a school project or research paper, please indicate your education level?"); ?></label>
				<select class="form-select" id="education" name="education">
					<option value="">Choose...</option>
<?php
						foreach($va_education_levels as $vs_education_level){
							print "<option value='".$vs_education_level."'".(($vs_education_level == $this->getVar("education")) ? " selected" : "").">".$vs_education_level."</option>";
						}
?>
				</select>
			</div><!-- end col -->
		</div>
		<div class="row mb-2">
			<div class="col-md-10 mb-4">
				<label for="sources" class="form-label"><?= _t("What sources have you already consulted?"); ?></label>
				<textarea class="form-control<?= (($errors["sources"]) ? " is-invalid" : ""); ?>" id="sources" name="sources" rows="5" aria-describedby="sourcesHelp">{{{sources}}}</textarea>
				<div id="sourcesHelp" class="form-text"><?= _t("Please list the sources you have already consulted so that we do not repeat your efforts."); ?></div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row mb-2">
			<div class="col-md-10 mb-4">
				<label for="deadline" class="form-label"><?= _t("When is your deadline for the information?"); ?></label>
				<textarea class="form-control<?= (($errors["deadline"]) ? " is-invalid" : ""); ?>" id="deadline" name="deadline" rows="5">{{{deadline}}}</textarea>
				<div class="form-text"><?= _t("We will make every effort to meet your deadline, but we cannot guarantee response in fewer than 10 business days."); ?></div>
			</div><!-- end col -->
		</div><!-- end row -->

<?php
}
?>
	<div class="row mt-2">
		<div class="col mb-4"><H2><?= _t("Contact Information"); ?></H2></div>
	</div>
	<div class="row mt-2">
		<div class="col-md-5 mb-4">
			<label for="name" class="form-label"><?= _t("Name"); ?>*</label>
			<input type="text" class="form-control<?= (($errors["name"]) ? " is-invalid" : ""); ?>" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}" id="name">
		</div><!-- end col -->
		<div class="col-md-5 mb-4">
			<label for="email" class="form-label"><?= _t("Email address"); ?>*</label>
			<input type="text" class="form-control<?= (($errors["email"]) ? " is-invalid" : ""); ?>" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
		</div><!-- end col -->
	</div>
	<div class="row mt-2">
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
				grecaptcha.render('regCaptcha', {'sitekey': '<?= __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
			};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>
		<div class="col-md-5 mb-4">
			<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
		</div>
<?php
	}
?>
	</div><!-- end row -->
</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
			<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
		</div>
	</div>
</form>
