<?php
	# --- reference or feedback
	$ps_contactType = $this->request->getParameter("contactType", pString);
	$pn_object_id = $this->request->getParameter("object_id", pInteger);
	if($pn_object_id){
		require_once(__CA_MODELS_DIR__."/ca_objects.php");
		$t_object = new ca_objects($pn_object_id);
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $t_object->get("ca_objects.object_id"));
	}
	$va_errors = $this->getVar("errors");
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	
	if($this->request->isLoggedIn()){
		$vs_user_name = $this->request->user->get("fname")." ".$this->request->user->get("lname");
		$vs_user_email = $this->request->user->get("email");
	}
	
	$va_reasons = array("School Paper", "Research Paper or Other Academic Publication","Upcoming Research Visit to the Museum", "Documentation on a Specific Survivor or Victim", "Family History", "Personal Interest", "Photographs", "Film Footage", "Lesson Planning or Curriculum Development", "Donating Items to the Museum", "Other");
	$va_education_levels = array("Intermediate; Middle School", "Secondary; High School", "Undergraduate", "Graduate School; Postgraduate", "Other");
	if($ps_contactType == "feedback"){
		print "<H1>"._t("Feedback")."</H1>";
	}else{
		print "<H1>"._t("Your Reference Question")."</H1>";	
	}
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
<?php
	if($ps_contactType == "feedback"){
?>
		<div class="row">
			<div class="col-sm-10">
				Please use this form to provide us with any information about our catalog. For example, do you recognize someone in a photograph? Can you add to our knowledge about this item? Have we made a mistake of any kind? We want to hear from you.
				<H2><b>Item title: </b><?php print $t_object->get("ca_objects.preferred_labels.name"); ?></H2>
				<H2><b>Item identifier: </b><?php print $t_object->get("ca_objects.idno"); ?></H2>

				<H2><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a></H2>
				<br/>
				<input type="hidden" name="itemId" value="<?php print $t_object->get("ca_objects.idno"); ?>">
				<input type="hidden" name="itemTitle" value="<?php print $t_object->get("ca_objects.preferred_labels.name"); ?>">
				<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				<div class="form-group<?php print (($va_errors["feedback"]) ? " has-error" : ""); ?>">
					<label for="feedback">Your message</label>
					<textarea class="form-control input-sm" id="sources" name="feedback" rows="5"><?php print $this->getVar("feedback");?></textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		
<?php
	}else{
?>
		<div class="row">
			<div class="col-sm-10">
				<div class="form-group<?php print (($va_errors["information"]) ? " has-error" : ""); ?>">
					<label for="information">What information are you seeking?</label>
					<textarea class="form-control input-sm" id="information" name="information" rows="5"><?php print $this->getVar("information");?></textarea>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-md-10">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["reason"]) ? " has-error" : ""); ?>">
							<label for="reason">What is the reason for your request?<br/><br/></label>
							<select class="form-control input-sm" id="reason" name="reason">
								<option value="">Choose...</option>
<?php
									foreach($va_reasons as $vs_reason){
										print "<option value='".$vs_reason."'".(($vs_reason == $this->getVar("reason")) ? " selected" : "").">".$vs_reason."</option>";
									}
?>
							</select>
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["education"]) ? " has-error" : ""); ?>">
							<label for="education">If your research is for a school project or research paper, please indicate your education level?</label>
							<select class="form-control input-sm" id="education" name="education">
								<option value="">Choose...</option>
<?php
									foreach($va_education_levels as $vs_education_level){
										print "<option value='".$vs_education_level."'".(($vs_education_level == $this->getVar("education")) ? " selected" : "").">".$vs_education_level."</option>";
									}
?>	
							</select>
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row -->		
		<div class="row">
			<div class="col-sm-10">
				<div class="form-group<?php print (($va_errors["sources"]) ? " has-error" : ""); ?>">
					<label for="sources">What sources have you already consulted?</label>
					<textarea class="form-control input-sm" id="sources" name="sources" rows="5"><?php print $this->getVar("sources");?></textarea>
					<small>Please list the sources you have already consulted so that we do not repeat your efforts.</small>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-10">
				<div class="form-group<?php print (($va_errors["deadline"]) ? " has-error" : ""); ?>">
					<label for="deadline">When is your deadline for the information?</label>
					<textarea class="form-control input-sm" id="deadline" name="deadline" rows="2"><?php print $this->getVar("deadline");?></textarea>
					<small>We will make every effort to meet your deadline, but we cannot guarantee response in fewer than 10 business days.</small>
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	}
?>
		<div class="row">
			<div class="col-sm-12">
				<H2>Contact Information</H2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
							<label for="name">Name*</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter name" name="name" value="<?php print ($this->getVar("name")) ? $this->getVar("name") : $vs_user_name; ?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
							<label for="email">Email address*</label>
							<input type="text" class="form-control input-sm" id="email" placeholder="Enter email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $vs_user_email; ?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-4">
						<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
							<label for="security">Security Question*</label>
							<div class='row'>
								<div class='col-sm-5'>
									<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
								</div>
								<div class='col-sm-4'>
									<input name="security" value="" id="security" type="text" class="form-control input-sm" />
								</div>
							</div><!--end row-->	
						</div><!-- end form group -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["address1"]) ? " has-error" : ""); ?>">
							<label for="address1">Address line 1</label>
							<input type="text" class="form-control input-sm" id="address1" placeholder="Enter address" name="address1" value="<?php print $this->getVar("address1");?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["address2"]) ? " has-error" : ""); ?>">
							<label for="address2">Address line 2</label>
							<input type="text" class="form-control input-sm" id="address2" placeholder="Enter address" name="address2" value="<?php print $this->getVar("address2");?>">
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group<?php print (($va_errors["city"]) ? " has-error" : ""); ?>">
							<label for="city">City</label>
							<input type="text" class="form-control input-sm" id="city" placeholder="Enter city" name="city" value="<?php print $this->getVar("city");?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-3">
						<div class="form-group<?php print (($va_errors["state"]) ? " has-error" : ""); ?>">
							<label for="state">State</label>
							<input type="text" class="form-control input-sm" id="state" placeholder="Enter state" name="state" value="<?php print $this->getVar("state");?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-3">
						<div class="form-group<?php print (($va_errors["postalCode"]) ? " has-error" : ""); ?>">
							<label for="postalCode">Postal/Zip code</label>
							<input type="text" class="form-control input-sm" id="postalCode" placeholder="Enter postal code" name="postalCode" value="<?php print $this->getVar("postalCode");?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-3">
						<div class="form-group<?php print (($va_errors["country"]) ? " has-error" : ""); ?>">
							<label for="country">Country</label>
							<input type="text" class="form-control input-sm" id="country" placeholder="Enter country" name="country" value="<?php print $this->getVar("country");?>">
						</div>
					</div><!-- end col -->
				</div><!-- end row -->
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["phone"]) ? " has-error" : ""); ?>">
							<label for="phone">Daytime telephone</label>
							<input type="text" class="form-control input-sm" id="phone" placeholder="Enter phone number" name="phone" value="<?php print $this->getVar("phone");?>">
						</div>
					</div><!-- end col -->
					<div class="col-sm-6">
						<div class="form-group<?php print (($va_errors["fax"]) ? " has-error" : ""); ?>">
							<label for="fax">Fax number</label>
							<input type="text" class="form-control input-sm" id="fax" placeholder="Enter fax" name="fax" value="<?php print $this->getVar("fax");?>">
						</div>
					</div><!-- end col -->
				</div><!-- end row -->

			</div><!-- end col -->
		</div><!-- end row -->
		<div class="form-group">
			<button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
	</form>