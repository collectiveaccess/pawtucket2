<?php
	# --- if a table has been passed this is coming from the Item Inquiry/Ask An Archivist contact form on detail pages
	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	# --- ask a curator/ contact form
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if(!$ps_contactType){
		$ps_contactType = "contact";
	}
	$vs_title = "Contact";
	if($ps_contactType == "askCurator"){
		$vs_title = "Ask a Curator";
		if($vs_table == "ca_objects"){
			$vs_title .= " / Request an Image";
		}
	}
	
	if($pn_id && $ps_table){
		$t_item = Datamodel::getInstanceByTableName($ps_table);
		if($t_item){
			$t_item->load($pn_id);
			$vs_url = $this->request->config->get("site_host").caDetailUrl($this->request, $ps_table, $pn_id);
			$vs_name = $t_item->get($ps_table.".preferred_labels");
			$vs_idno = $t_item->get($ps_table.".idno");
		}
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
	<div class="row">
		<div class="col-sm-12 ">
			<H1><?php print $vs_title; ?></H1>
		</div>
	</div>
<?php
	if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
<?php
	if($ps_contactType == "askCurator"){
?>
		<div class="row">
			<div class="col-sm-12">
				<hr/>
				<h2>Do you have a question about this item<?php print ($vs_table == "ca_objects") ? " or wish to request an image" : ""; ?>?</h2>
				Complete this form, and NHS collections staff will follow up with you by email.
				<br/><br/><b>Item title: </b><?php print $vs_name; ?>
				<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a>
				<br/>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
				<hr/><br/>
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-12">
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
			<div class="col-sm-12">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Question / Request</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-4">
					<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
						<label for="security">Security Question</label>
						<div class='row'>
							<div class='col-sm-4'>
								<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
							</div>
							<div class='col-sm-4'>
								<input name="security" value="" id="security" type="text" class="form-control input-sm" />
							</div>
						</div><!--end row -->	
					</div>
			</div><!-- end col -->
		</div><!-- end row -->
				
		<div class="form-group">
			<br/><button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
	</form>
	
<?php
	if(($ps_contactType == "askCurator") && ($ps_table == "ca_objects")){
?>
		<div class="row">
			<div class="col-sm-12 text-center">
				{{{request_image_link}}}
			</div>
		</div>

<?php
	}
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