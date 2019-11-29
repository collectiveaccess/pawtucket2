<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">

<?php
	$va_access_values = caGetUserAccessValues($this->request);
	# --- inquire about item/ contact form / digitization request
	# inquiry/contact/digitizationRequest
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if(!$ps_contactType){
		$ps_contactType = "bookRequest";
	}
	$pn_object_id = $this->request->getParameter("object_id", pInteger);
	if($pn_object_id){
		require_once(__CA_MODELS_DIR__."/ca_objects.php");
		$t_item = new ca_objects($pn_object_id);
		# --- is this bulk media?  We need to use the url of the container the bulk media is linked to
		$t_list_item = new ca_list_items();
		$t_list_item->load($t_item->get("type_id"));
		$vs_typecode = $t_list_item->get("idno");
		if($vs_typecode == "bulk"){
			$vn_container_id = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("folder"), "limit" => 1));
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, "ca_objects", $vn_container_id);
		}else{
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, "ca_objects", $t_item->get("ca_objects.object_id"));
		}
		$vs_name = $t_item->get("ca_objects.ns_title");
		$vs_idno = $t_item->get("ca_objects.idno");
		
	}
	
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	if($this->request->isAjax()){
?>
		<div id="caFormOverlay" class="caFormOverlayWide"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
	}

?>
	<div class="row detailContentContainer">
		<div class="col-sm-12 ">
			<H1>
<?php
				print "<H1>Book Request</H1>";
?>
		</div>
	</div>
<?php
	if(is_array($va_errors) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
	
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

			<div class="row ">
				<div class="col-sm-12">
					<hr/>
					<b>Request title: </b><a href="<?php print $vs_url; ?>"><?php print $vs_name; ?></a>
					<b>Library number: </b><a href="<?php print $vs_url; ?>"><?php print $vs_idno; ?></a>
					<br/>
					<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
					<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
					<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
					<hr/><br/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
								<label for="name">Your Name</label>
								<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print ($this->getVar("name")) ? $this->getVar("name") : trim($this->request->user->get("fname")." ".$this->request->user->get("lname")); ?>">
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
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["museum"]) ? " has-error" : ""); ?>">
					    <label for="messge">Museum</label>
						<input class="form-control input-sm" id="museum" name="museum" rows="5">{{{museum}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					    <label for="messge">Message</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<p>{{{contact_item_inquiry_conclusion}}}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<br/><button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
				</div>
			</div>
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">

	</form>
<?php		

	if($this->request->isAjax()){
		print "<br/><br/><br/></div>";
?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				jQuery('#contactForm').submit(function(e){		
					jQuery('#caMediaPanelContentArea').load(
						'<?php print caNavUrl($this->request, '', 'Contact', 'send', null); ?>',
						jQuery('#contactForm').serialize()
					);
					e.preventDefault();
					return false;
				});
			});
		</script>
<?php
	}
?>
	</div>
</div>