<?php
	# --- ask an archivist, takedown
	$ps_contactType = $this->request->getParameter("contactType", pString);
	if(!$ps_contactType){
		$ps_contactType = "contact";
	}
	$pn_object_id = $this->request->getParameter("object_id", pInteger);
	if($pn_object_id){
		require_once(__CA_MODELS_DIR__."/ca_objects.php");
		$t_item = new ca_objects($pn_object_id);
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $t_item->get("ca_objects.object_id"));
		$vs_name = $t_item->get("ca_objects.preferred_labels.name");
	}
	$pn_entity_id = $this->request->getParameter("entity_id", pInteger);
	if($pn_entity_id){
		require_once(__CA_MODELS_DIR__."/ca_entities.php");
		$t_item = new ca_collections($pn_entity_id);
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "entities", $t_item->get("ca_entities.collection_id"));
		$vs_name = $t_item->get("ca_entities.preferred_labels.name");
	}
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;

	switch($ps_contactType){
		case "askArchivist":
			print "<H1>"._t("Ask An Archivist")."</H1>";
		break;
		case "takedown":
			print "<H1>"._t("Takedown Request")."</H1>";
		break;
		case "contact":
		default:
			print "<H1>"._t("Contact")."</H1>";
		break;
	}
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
<?php
	if(in_array($ps_contactType, array("takedown", "askArchivist"))){
?>
		<div class="row">
			<div class="col-sm-10">
<?php
				if($ps_contactType == "askArchivist"){
					print "<h4>Please use this form to inquire about a specific item in our archive.</h4>";
				}elseif($ps_contactType == "takedown"){
					print "<h4>Please use this form to request a record be removed from the website for privacy or other reasons.</h4>";
					print "<input type='hidden' name='takedownRequest' value='User Requested Record be Taken Down'>";
				}
?>				
				<H6><b>Item title: </b><?php print $vs_name; ?></H6>
				
				<H6><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a></H6>
				<br/>
				<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
				<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-12 col-lg-8">
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
			<div class="col-md-12 col-lg-8">
				<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
					<label for="message">Message</label>
					<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	if($this->request->isLoggedIn()){
		print '<input type="hidden" name="security" value="'.$vn_sum.'">';
	}else{
		# --- only show security question if not logged in
?>
			<div class="row">
				<div class="col-md-12 col-lg-8">
					<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
						<label for="security">Security Question</label>
						<div class='row'>
							<div class='col-sm-4'>
								<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
							</div>
							<div class='col-sm-4'>
								<input name="security" value="" id="security" type="text" class="form-control input-sm" />
							</div>
						</div><!-- end row -->
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
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="entity_id" value="<?php print $pn_entity_id; ?>">
	</form>