<?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	$vs_inquire_type = $this->request->getParameter("inquire_type", pString);
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
			$vs_item_type = $t_item->getWithTemplate("^".$ps_table.".type_id");
			switch($vs_inquire_type){
				# -----------------
				case "request_permissions":
					$vs_page_title = ($o_config->get("request_permissions_page_title")) ? $o_config->get("request_permissions_page_title") : _t("Request Permissions");
				break;
				# -----------------
				case "item_inquiry":
					$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
				break;
				# -----------------
			}
		}
	}
?>
<div class="row"><div class="col-sm-12 col-lg-10 col-lg-offset-1">
	<H1><?php print $vs_page_title; ?></H1>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
	    <input type="hidden" name="csrfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
	if($pn_id && $t_item->getPrimaryKey()){
?>
		<div class="row">
			<div class="col-sm-12">
				<p><b>Title: </b><?php print $vs_name; ?>
				<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
				</p>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<input type="hidden" name="itemtype" value="<?php print $vs_item_type; ?>">
				<hr/>
	
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12">
						<b>Contact Information</b>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Name*</label>
							<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}">
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Email address*</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
						</div>
					</div><!-- end col -->					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
							<label for="phone">Phone*</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Phone number" name="phone" value="{{{phone}}}">
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["organization"]) ? " has-error" : ""); ?>">
							<label for="phone">Affiliated Organization</label>
							<input type="text" class="form-control input-sm" id="organization" placeholder="Organization" name="organization" value="{{{organization}}}">
						</div>
					</div><!-- end col -->
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12">
						<hr/>
					</div>
				</div>
<?php
			switch($vs_inquire_type){
				# -----------------
				case "request_permissions":
					$vs_intended_use = $this->request->getParameter("intended_use", pString);
?>
					<div class="form-group<?php print (($va_errors["intended_use"]) ? " has-error" : ""); ?>">
						<label for="message">Intended Use</label>
						<select name="intended_use" class="form-control input-sm">
							<option value="Personal or Research only, not for publication or commercial use" <?php print ($vs_intended_use == "Personal or Research only, not for publication or commercial use") ? "selected":""; ?>>Personal or Research only, not for publication or commercial use</option>
							<option value="Educational (e.g. lesson plans, curriculum development, presentation, assignments)" <?php print ($vs_intended_use == "Educational (e.g. lesson plans, curriculum development, presentation, assignments)") ? "selected":""; ?>>Educational (e.g. lesson plans, curriculum development, presentation, assignments)</option>
							<option value="Publication (e.g. book, newspaper, newsletter, magazine, report, website, social media)" <?php print ($vs_intended_use == "Publication (e.g. book, newspaper, newsletter, magazine, report, website, social media)") ? "selected":""; ?>>Publication (e.g. book, newspaper, newsletter, magazine, report, website, social media)</option>
							<option value="Commercial (e.g. books for sale, paid journals, advertisements)" <?php print ($vs_intended_use == "Commercial (e.g. books for sale, paid journals, advertisements)") ? "selected":""; ?>>Commercial (e.g. books for sale, paid journals, advertisements)</option>
							<option value="Other" <?php print ($vs_intended_use == "Other") ? "selected":""; ?>>Other</option>
						</select>
					</div>
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
						<label for="message">Rationale*</label><br/><small>Please provide your rationale for requesting access and use.</small>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
<?php
				break;
				# -----------------
				case "item_inquiry":
				default:
?>
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Message*</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>

<?php
				break;
				# -----------------
			}
?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-12">
						<hr/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
							<label for="security">Security Question</label>
							<div class='row'>
								<div class='col-sm-6'>
									<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
								</div>
								<div class='col-sm-6'>
									<input name="security" value="" id="security" type="text" class="form-control input-sm" />
								</div>
							</div><!--end row-->	
						</div><!-- end form-group -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-12">
						<hr/>
					</div>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		
<?php
	if(!$this->request->isLoggedIn() && defined("__CA_GOOGLE_RECAPTCHA_KEY__") && __CA_GOOGLE_RECAPTCHA_KEY__){
?>
		<script type="text/javascript">
			var gCaptchaRender = function(){
                grecaptcha.render('regCaptcha', {'sitekey': '<?php print __CA_GOOGLE_RECAPTCHA_KEY__; ?>'});
        	};
		</script>
		<script src='https://www.google.com/recaptcha/api.js?onload=gCaptchaRender&render=explicit' async defer></script>


			<div class="row">
				<div class="col-sm-12 col-md-offset-1 col-md-10">
					<div class='form-group<?php print (($va_errors["recaptcha"]) ? " has-error" : ""); ?>'>
						<div id="regCaptcha" class="col-sm-8 col-sm-offset-4"></div>
					</div>
				</div>
			</div><!-- end row -->
<?php
	}
?>
		<div class="form-group">
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>
	
</div><!-- end col --></div><!-- end row -->
