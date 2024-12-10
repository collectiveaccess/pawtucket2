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
$o_config = caGetContactConfig();
$va_errors = $this->getVar("errors");
$vn_num1 = rand(1,10);
$vn_num2 = rand(1,10);
$vn_sum = $vn_num1 + $vn_num2;
$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");

# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
$pn_id = $this->request->getParameter("id", pInteger);
$ps_table = $this->request->getParameter("table", pString);

if($pn_id && $ps_table){
	$t_item = Datamodel::getInstanceByTableName($ps_table);
	if($t_item){
		$t_item->load($pn_id);
		$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
		$vs_name = $t_item->get($ps_table.".preferred_labels");
		$vs_idno = $t_item->get($ps_table.".idno");
		$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
	}
}
?>
<H1><?= $vs_page_title; ?></H1>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
<form id="contactForm" action="<?= caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">
	<input type="hidden" name="csrfToken" value="<?= caGenerateCSRFToken($this->request); ?>"/>
<?php
if($pn_id && $t_item->getPrimaryKey()){
?>
	<div class="bg-light px-4 pt-4 pb-2 mb-4">		
		<div class="row mt-2">
			<div class="col-sm-12 mb-4">
				<div class="pb-2"><b>Title: </b><?= $vs_name; ?></div>
				<div class="pb-2"><b>Regarding this URL: </b><a href="<?= $vs_url; ?>" class="purpleLink"><?= $vs_url; ?></a></div>
				<input type="hidden" name="itemId" value="<?= $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?= $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?= $vs_url; ?>">
				<input type="hidden" name="id" value="<?= $pn_id; ?>">
				<input type="hidden" name="table" value="<?= $ps_table; ?>">
			</div>
		</div>
	</div>
<?php
}
if($vs_contact_intro = $this->getVar("contact_intro")){
?>
	<div class="pb-4 fs-4">
		<?php print $vs_contact_intro; ?>
	</div>
<?php
}
?>
<div class="bg-light px-4 pt-4 pb-2 mb-4">		
	<div class="row mt-2">
		<div class="col-md-4 mb-4">
			<label for="name" class="form-label"><?= _t("Name"); ?></label>
			<input type="text" class="form-control<?= (($va_errors["name"]) ? " is-invalid" : ""); ?>" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}" id="name">
		</div><!-- end col -->
		<div class="col-md-4 mb-4">
			<label for="email" class="form-label"><?= _t("Email address"); ?></label>
			<input type="text" class="form-control<?= (($va_errors["email"]) ? " is-invalid" : ""); ?>" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
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
		<div class="col-md-8 mb-4">
			<label for="message" class="form-label"><?= _t("Message"); ?></label>
			<textarea class="form-control<?= (($va_errors["message"]) ? " is-invalid" : ""); ?>" id="message" name="message" rows="5">{{{message}}}</textarea>
		</div><!-- end col -->
	</div><!-- end row -->
</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
			<button type="submit" class="btn btn-primary"><?= _t("Send"); ?></button>
		</div>
	</div>
</form>
