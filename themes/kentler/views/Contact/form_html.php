 <?php
	$o_config = caGetContactConfig();
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$vs_page_title = ($o_config->get("contact_page_title")) ? $o_config->get("contact_page_title") : _t("Contact");
	
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	$ps_contactType = $this->request->getParameter("contactType", pString);

	$vs_name_default = "";
	$vs_email_default = "";
	if($this->request->isLoggedIn()){
		$vs_name_default = $this->request->user->get("fname")." ".$this->request->user->get("lname");
		$vs_email_default = $this->request->user->get("email");
	}
	$vb_user_able_to_select = true;
	$vn_num_items_for_user = $this->request->user->getPreference("user_profile_number_of_items");
	if(!$vn_num_items_for_user){
		$vn_num_items_for_user = 1;
	}
	if($vn_num_items_for_user <= $this->request->user->getPreference("user_profile_number_of_items_selected")){
		$vb_user_able_to_select = false;	
	}
	$vb_item_available = true;
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			if(strtolower($t_item->get("ca_objects.removed.removal_text", array("convertCodesToDisplayText" => true))) == "yes"){
				$vb_item_available = false;
			}	
			
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
			$vs_name = $t_item->get($ps_table.".preferred_labels.name");
			$vs_idno = $t_item->get($ps_table.".idno");






# --- summary for benefit item
					$vs_image = "";
					$vs_image = $t_item->get('ca_object_representations.media.mediumlarge', array("checkAccess" => $va_access_values));
					$vb_no_rep = false;
					if(!$vs_image){
						$vs_image = "<div class='detailPlaceholder'>".caGetThemeGraphic($this->request, 'KentlerLogoWhiteBG.jpg')."</div>";
						$vb_no_rep = true;
					}
					$vs_caption = "";
					$vs_sort_key = "";
					$vs_sort_key = array_shift(explode(" ", $t_item->get('ca_entities.preferred_labels.surname', array("restrictToRelationshipTypes" => array("artist"), 'checkAccess' => $va_access_values))));
					if($vs_artist = $t_item->get('ca_entities.preferred_labels.displayname', array("restrictToRelationshipTypes" => array("artist"), 'checkAccess' => $va_access_values))){
						$vs_caption = $vs_artist.", ";
					}
					$vs_caption .= "<i>".$t_item->get("ca_objects.preferred_labels.name")."</i>, ";
					$vs_medium = "";
					if($t_item->get("medium_text")){
						$vs_medium = $t_item->get("medium_text");
					}else{
						if($t_item->get("medium")){
							$vs_medium .= $t_item->get("medium", array("delimiter" => ", ", "convertCodesToDisplayText" => true));
						}
					}
					if($vs_medium){
						$vs_caption .= $vs_medium.", ";
					}					
					if($t_item->get("ca_objects.dimensions")){
						$vs_caption .= $t_item->get("ca_objects.dimensions.dimensions_height")." X ".$t_item->get("ca_objects.dimensions.dimensions_width").", ";
					}
					if($t_item->get("ca_objects.date")){
						$vs_caption .= $t_item->get("ca_objects.date").".";
					}
					#$vs_label_detail_link 	= caDetailLink($this->request, $vs_caption, '', 'ca_objects', $t_item->get("ca_objects.object_id"));
					#print '<div class="col-sm-3"><div class="fullWidthImg" data-toggle="popover" data-trigger="hover" data-placement="auto" data-container="body" data-html="true" data-content="'.$vs_image.'">'.(($vb_no_rep) ? $vs_image : "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $t_item->get("ca_objects.object_id"), 'representation_id' => $t_item->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)), 'overlay' => 1))."\"); return false;' >".$vs_image."</a>");
					$vs_artwork = "";
					$vs_artwork .= '<div class="fullWidthImg">'.(($vb_no_rep) ? $vs_image : "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $t_item->get("ca_objects.object_id"), 'representation_id' => $t_item->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)), 'overlay' => 1))."\"); return false;' >".$vs_image."</a>");
					
					if($vs_caption){
						$vs_artwork .= "<br/><small>".$vs_caption."</small>";
					}
					$vs_artwork .= '</div>';









		}
		if($ps_contactType == "benefit"){
			$vs_page_title = _t("Virtual Benefit: Select Item");
			$vs_intro = $this->getVar("benefitSelectText");
			$vs_benefit_message = "Item selected for virtual benefit";
		}else{
			$vs_page_title = ($o_config->get("item_inquiry_page_title")) ? $o_config->get("item_inquiry_page_title") : _t("Item Inquiry");
		}
	}
?>
<div class="row"><div class="col-sm-12 col-md-10 col-md-offset-1">
	<H1><?php print $vs_page_title; ?></H1>
<?php
	if($vb_item_available && $vb_user_able_to_select){
		if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
			print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
		}
?>
		<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
			<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
<?php
		if($pn_id && $t_item->getPrimaryKey()){
?>
			<div class="row">
				<div class="col-sm-12 col-md-4">
					<?php print $vs_artwork; ?>
					<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
					<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
					<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
					<input type="hidden" name="id" value="<?php print $pn_id; ?>">
					<input type="hidden" name="table" value="<?php print $ps_table; ?>">
					<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
					<input type="hidden" name="benefit" value="<?php print $vs_benefit_message; ?>">
					<input type="hidden" name="artist" value="<?php print $vs_artist; ?>">
				</div>
				<div class="col-sm-12 col-md-8">
<?php
				if($vs_intro){
					print "<p>".$vs_intro."</p><hr/>";
				}
	
		}else{
?>
			<div class="row">
				<div class="col-md-12">
<?php		
		}
?>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
								<label for="name">Name</label>
								<input type="text" class="form-control input-sm" aria-label="enter name" placeholder="Enter Name" name="name" value="<?php print ($this->getVar("name")) ? $this->getVar("name") : $vs_name_default; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-6">
							<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
								<label for="email">Email address</label>
								<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $vs_email_default; ?>">
							</div>
						</div><!-- end col -->
<?php
					if(!$this->request->isLoggedIn()){
?>
						<div class="col-sm-12">
							<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
								<label for="security">Security Question</label>
								<div class='row'>
									<div class='col-sm-6'>
										<div class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </div>
									</div>
									<div class='col-sm-6'>
										<input name="security" value="" id="security" type="text" class="form-control input-sm" />
									</div>
								</div><!--end row-->	
							</div><!-- end form-group -->
						</div><!-- end col -->
<?php
					}
?>
					</div><!-- end row -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
						<label for="message">Message</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
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
				<button type="submit" class="btn btn-default">Confirm Selection</button>
			</div><!-- end form-group -->
			<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		</form>
	
	</div><!-- end col --></div><!-- end row -->
<?php
	}else{
		if(!$vb_user_able_to_select){
?>
			<div class='alert alert-danger'>You are not able to select more items</div>
			{{{benefitCantSelectItems}}}
<?php		
		}else{
?>
			<div class='alert alert-danger'>Item is no longer available</div>
			<p class="text-center">Please return to the benefit page and select another item</p>
<?php
		}
		print "<p class='text-center'>".caNavLink($this->request, "Back to Virtual Benefit", "btn btn-default", "Detail", "exhibitions", $this->request->config->get("virtual_benefit_id"))."</p>";
	}
?>
</div><!-- end col --></div><!-- end row -->
