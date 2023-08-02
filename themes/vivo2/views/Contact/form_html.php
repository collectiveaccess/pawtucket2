<?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			if($ps_table = "ca_sets"){
				$vs_name = $t_item->getLabelForDisplay();
				$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "", "Lightbox", "setDetail", array("set_id" => $pn_id));
				$vs_admin_url = $this->request->config->get("site_host")."/admin/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_id;
				$vs_idno = "";
			}else{
				$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
				$vs_name = $t_item->get($ps_table.".preferred_labels");
				$vs_idno = $t_item->get($ps_table.".idno");
			}
		}
	}
	$vs_contactType = $this->request->getParameter("contactType", pString);
	switch($vs_contactType){
		case "ResearchRequest":
			$vs_page_title = "Research Request";
		break;
		# --------------------------
		case "Reproduction":
			$vs_page_title = "Reproduction Request";
		break;
		# --------------------------
		case "RentalPurchase":
			$vs_page_title = "Rental or Purchase Request";
		break;
		# --------------------------
		case "Feedback":
			$vs_page_title = "Feedback";
		break;
		# --------------------------
		default:
			if($pn_id && $ps_table){
				$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
			}else{
				$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
			}
		break;
		# --------------------------
	}
	
?>
<div class="row staticPage">
	<div class="col-sm-12 col-md-6">
		<div class="bodyTextCol">
<?php
	if($vs_contactType == "Reproduction"){
?>
		<H1>Rights & Reproduction</H1>
		{{{rights_reproduction_intro}}}
		<H2><?php print $vs_page_title; ?></H2>
<?php	
	}elseif($vs_contactType == "RentalPurchase"){
?>
		<H1>Rental & Sales</H1>
		{{{rental_purchase_intro}}}
		<H2><?php print $vs_page_title; ?></H2>
<?php	
	}else{
?>
	<H1><?php print $vs_page_title; ?></H1>
<?php	
	}
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" method="post">
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
				<input type="hidden" name="itemURL" value="<?php print ($ps_table == "ca_sets") ? $vs_admin_url : $vs_url; ?>">
				<input type="hidden" name="id" value="<?php print $pn_id; ?>">
				<input type="hidden" name="table" value="<?php print $ps_table; ?>">
				<hr/><br/>
	
			</div>
		</div>
<?php
	}
	if(!$vs_contactType){
?>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group<?php print (($va_errors["contactType"]) ? " has-error" : ""); ?>">
							<label for="contactType">Contact Type</label>
							<select name="requestType" id="contactType">
								<option value="Research Request">Research Request</option>
								<option value="Reproduction Request">Reproduction Request</option>
								<option value="General Inquiry">General Inquiry</option>
							</select>
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->

<?php
	}else{
?>
	<input type="hidden" name="requestType" value="<?php print $vs_page_title; ?>">
<?php
	}
?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Name</label>
							<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter name" name="name" value="{{{name}}}" id="name">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Email address</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="{{{email}}}" id="email">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["organisation"]) ? " has-error" : ""); ?>">
							<label for="Organisation">Organisation or project</label>
							<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter organisation" name="organisation" value="{{{organisation}}}" id="Organisation">
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
<?php
		if($vs_contactType && ($vs_contactType != "Feedback")){
?>
		<div class="row">
			<div class="col-md-9">
				<div class="form-group<?php print (($va_errors["item_info"]) ? " has-error" : ""); ?>">
					<label for="item_info">Items</label>
					<textarea class="form-control input-sm" id="item_info" name="item_info" rows="5">{{{item_info}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
		}
		if($vs_contactType == "Reproduction"){
?>		
		<div class="row">
			<div class="col-md-9">
				<div class="form-group<?php print (($va_errors["formats_files"]) ? " has-error" : ""); ?>">
					<label for="formatsFiles">Formats / File Sizes</label>
					<textarea class="form-control input-sm" id="item_info" name="formats_files" rows="5" id="formatsFiles">{{{formats_files}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php		
		}
		if($vs_contactType == "RentalPurchase"){
?>		
		<div class="row">
			<div class="col-md-9">
				<div class="form-group<?php print (($va_errors["rental_purchase"]) ? " has-error" : ""); ?>">
					<label for="rentalPurchase">Rental or Purchase</label>
					<select name="rental_purchase" id="rentalPurchase">
						<option value="Rental">Rental</option>
						<option value="Purchase">Purchase</option>
					</select>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php		
		}
?>
		<div class="row">
			<div class="col-md-9">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Message / Additional Information</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5" id="message">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-9">
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
		<div class="form-group text-right">			
			<input type="hidden" name="contactType" value="<?php print $vs_contactType; ?>">
			
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
	</form>

		</div>
	</div>
	<div class="col-sm-12 col-md-6">
		<?php print caGetThemeGraphic($this->request, 'rental1.jpg', array("alt" => "Image of tapes on shelves")); ?>
		<?php print caGetThemeGraphic($this->request, 'rental2.jpg', array("alt" => "Image of vhs tapes and equipment")); ?>
	</div>
</div>