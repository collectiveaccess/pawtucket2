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
			switch($vs_inquire_type){
				case "cultural_narrative":
					$vs_page_title = ($o_config->get("item_inquiry_cultural_narrative_page_title")) ? $o_config->get("item_inquiry_cultural_narrative_page_title") : _t("Share Your Cultural Narrative");
				break;
				# -----------------
				case "loan":
					$vs_page_title = ($o_config->get("item_inquiry_loan_page_title")) ? $o_config->get("item_inquiry_loan_page_title") : _t("Loan Request");
				break;
				# -----------------
				default:
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
				<hr/><br/><br/>
	
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Name</label>
							<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Email address</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}">
						</div>
					</div><!-- end col -->
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
			</div><!-- end col -->
		</div><!-- end row -->
<?php
			switch($vs_inquire_type){
				case "cultural_narrative":
?>
					<div class="row">
						<div class="col-md-9">
							<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
								<label for="message">Share your narrative about the item</label>
								<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{cultural_narrative}}}</textarea>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
<?php
				break;
				# -----------------
				case "loan":
					$vs_loan_type = $this->request->getParameter("loan_type", pString);
?>					
					<div class="row">
						<div class="col-sm-4 col-md-2">
							<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
								<label for="loan_type">Loan Type</label>
								<select name="loan_type" class="form-control input-sm">
									<option value="digital" <?php print ($vs_loan_type == "digital") ? "selected":""; ?>>Digital</option>
									<option value="physical" <?php print ($vs_loan_type == "physical") ? "selected":""; ?>>Physical</option>
								</select>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class="col-md-9">
							<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
								<label for="message">Please explain your interest in this item and the purpose of the loan</label>
								<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
<?php
				break;
				# -----------------
				default:
?>
					<div class="row">
						<div class="col-md-9">
							<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
								<label for="message">Message</label>
								<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
<?php
				break;
				# -----------------
			}
?>
	<p class='unit'>*{{{contact_comment_privacy}}}</p>
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
