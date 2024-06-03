<?php
	$o_config = caGetContactConfig();
	# --- ask an archivist, takedown
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if(!$ps_contactType){
		$ps_contactType = "contact";
	}
	$ps_table = $this->request->getParameter("table", pString);
	$pn_row_id = $this->request->getParameter("row_id", pInteger);
	if($pn_row_id && $ps_table){
		$t_instance = Datamodel::getInstanceByTableNum($ps_table);
		$t_instance->load($pn_row_id);
		#$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", str_replace("ca_", "", $ps_table), $pn_row_id);
		$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_row_id);
		$vs_name = $t_instance->get("preferred_labels");
	}
	$va_errors = $this->getVar("errors");
	#$vn_num1 = rand(1,10);
	#$vn_num2 = rand(1,10);
	#$vn_sum = $vn_num1 + $vn_num2;
?>
	<div class="row">
		<div class="col-sm-12 col-md-offset-1 col-md-10">
<?php
	switch($ps_contactType){
		case "askArchivist":
			print "<H1>"._t("Ask A Question")."</H1>";
		break;
		case "takedown":
			print "<H1>"._t("Takedown Request")."</H1>";
		break;
		case "contact":
		default:
			print "<H1>"._t("Contact")."</H1>";
		break;
	}
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
		</div>
	</div>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
<?php
	if(in_array($ps_contactType, array("takedown", "askArchivist"))){
?>
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
<?php
				if($ps_contactType == "askArchivist"){
					print "<h4>Please use this form to inquire about a specific item in our archive.</h4>";
				}elseif($ps_contactType == "takedown"){
					print "<p>Please use this form to request a record be removed from the website for privacy or other reasons.</p><p>Your takedown request will also be forwarded to the archive that holds the original record and, if applicable, the National Centre for Truth and Reconciliation. They will contact you directly to follow up on your request.</p>";
					print "<br/><input type='hidden' name='takedownRequest' value='User Requested Record be Taken Down'>";
				}
?>				
				<H6><b>Item title: </b><?php print $vs_name; ?></H6>
				
				<H6><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a></H6>
				<br/>
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Your Name</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter your name" name="name" value="<?php print ($this->getVar("name")) ? $this->getVar("name") : trim($this->request->user->get("fname")." ".$this->request->user->get("lname")); ?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Your Email address</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter your email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-12 col-md-offset-1 col-md-10">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Message</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	if(!$this->request->isLoggedIn() && __CA_GOOGLE_RECAPTCHA_KEY__){

		# --- only show captcha
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
			<div class="row">
				<div class="col-sm-12 col-md-offset-1 col-md-10">
					<div class="form-group">
						<button type="submit" class="btn btn-default" onClick="$('.loadingForm').toggle();"><span class="loadingForm"><?php print _t('Send'); ?></span><span class="loadingForm" style="display:none;"> <?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></span></button>
					</div><!-- end form-group -->
				</div>
			</div>
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="row_id" value="<?php print $pn_row_id; ?>">
		<input type="hidden" name="table" value="<?php print $ps_table; ?>">
	</form>