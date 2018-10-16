<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">

<?php
	# --- inquire about item/ contact form / digitization request
	# inquiry/contact/digitizationRequest
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
		$vs_idno = $t_item->get("ca_objects.idno");
	}
	$pn_collection_id = $this->request->getParameter("collection_id", pInteger);
	if($pn_collection_id){
		require_once(__CA_MODELS_DIR__."/ca_collections.php");
		$t_item = new ca_collections($pn_collection_id);
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "collections", $t_item->get("ca_collections.collection_id"));
		$vs_name = $t_item->get("ca_collections.preferred_labels.name");
		$vs_idno = $t_item->get("ca_collections.idno");
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
			<H1>
<?php
			switch($ps_contactType){
				case "inquiry":
				case "digitizationRequest":
					print "Item Inquiry";
				break;
				case "transfer":
					print "Transfer";
				break;
				default:
					print "Contact or Tour Request";
				break;
			}
?>
		</div>
	</div>
<?php
	if(sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
<?php
	switch($ps_contactType){
		case "digitizationRequest":
		case "inquiry":
?>
			<div class="row">
				<div class="col-sm-12">
					<hr/>
					<b>Item title: </b><?php print $vs_name; ?>
					<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a>
					<br/>
					<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
					<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
					<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
					<hr/><br/>
					<p>The Archives team is happy to help you with tour requests as well as reference and research assistance.  <?php print caNavLink($this->request, "Click here for tour requests", "", "", "Contact", "Form"); ?>.</p>
					
					<p>For all reference and research assistance please provide the following:</p>
					
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
							<div class="form-group<?php print (($va_errors["reference_question"]) ? " has-error" : ""); ?>">
								<label for="message">Reference question:</label>
								<textarea class="form-control input-sm" id="reference_question" name="reference_question" rows="5">{{{reference_question}}}</textarea>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class="col-sm-12">
							<h2>Archives Material request</H2>
							<br/>Digital
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group<?php print (($va_errors["digitization_status"]) ? " has-error" : ""); ?>">
										<label for="name">The item is:</label>
										<select class="form-control input-sm" id="digitization_status" name="digitization_status">
											<option value=''>Please choose and option</option>
											<option value='Already digitized' <?php print ($this->getVar("digitization_status") == "Already digitized") ? "selected" : ""; ?>>Already digitized</option>
											<option value='Requires digitization' <?php print ($this->getVar("digitization_status") == "Requires digitization") ? "selected" : ""; ?>>Requires digitization</option>
										</select>
									</div>
								</div><!-- end col -->
								<div class="col-sm-4">
									<div class="form-group<?php print (($va_errors["use"]) ? " has-error" : ""); ?>">
										<label for="name">Use:</label>
										<select class="form-control input-sm" id="use" name="use">
											<option value=''>Please choose and option</option>
											<option value='Internal' <?php print ($this->getVar("use") == "Internal") ? "selected" : ""; ?>>Internal</option>
											<option value='External' <?php print ($this->getVar("use") == "External") ? "selected" : ""; ?>>External</option>
										</select>
									</div>
								</div><!-- end col -->
								
								<div class="col-sm-4">
									<div class="form-group<?php print (($va_errors["request_date"]) ? " has-error" : ""); ?>">
										<label for="email">Date needed by:</label>
										<input type="text" class="form-control input-sm" id="request_date" placeholder="Enter the date you need the request fulfilled by" name="request_date" value="<?php print ($this->getVar("request_date")) ? $this->getVar("request_date") : ""; ?>">
									</div>
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class="col-sm-12">
							<br/><br/>For physical requests please use the Research Appointment form.
						</div>
					</div>				
				</div>
			</div>
<?php		
		break;
		# -----------------------------
		case "transfer":
?>
			<div class="row">
				<div class="col-sm-12">
					<p>Collecting scope and instructions on transfering physical material to the Archives.....text to come.</p>
					<hr/>
					
				</div>
			</div>
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
						<label for="message">Message</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
<?php
		break;
		# -----------------------------
		default:
?>
			<div class="row">
				<div class="col-sm-12">
					<p>The Archives team is happy to help you with tour requests as well as reference and research assistance.</p>
					<hr/>
					<h2>General Questions</H2>
					
				</div>
			</div>		
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
						<label for="message">General Question / Request</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<HR/>
					<h2>Tours</H2>
					<p>We offer tours of the permanent exhibit in the Archives Gallery where you will learn about the Company’s founders, see rare and early packaging, photographs, and letters among other collection items. Tours focus on the early history of the Company and are approximately one hour long. To view specific items in the collection please submit a reference request below or schedule a research appointment.</p>
 
					<p>Tours of Mrs. Estée Lauder’s office require approval from Executive Management and are considered based on availability and scheduling in the executive suite.</p>

					
					<p>If you would like to attend an Archives Gallery tour you may sign-up for upcoming dates: Monday 10/15 1:00pm; Thursday 11/15 1:00pm; Friday 12/14 1:00pm.</p>
					<p>Or provide the following information: </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["elc_employee"]) ? " has-error" : ""); ?>">
								<label for="name">Is the tour for:</label>
								<select class="form-control input-sm" id="elc_employee" name="elc_employee">
									<option value=''>Please choose and option</option>
									<option value='ELC employee(s)' <?php print ($this->getVar("elc_employee") == "ELC employee(s)") ? "selected" : ""; ?>>ELC employee(s)</option>
									<option value='Non ELC employee(s)' <?php print ($this->getVar("elc_employee") == "Non ELC employee(s)") ? "selected" : ""; ?>>Non ELC employee(s)</option>
								</select>
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["brand"]) ? " has-error" : ""); ?>">
								<label for="email">Brand/Team:</label>
								<input type="text" class="form-control input-sm" id="email" placeholder="Enter your Brand/Team" name="brand" value="<?php print ($this->getVar("brand")) ? $this->getVar("brand") : ""; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["num_attendees"]) ? " has-error" : ""); ?>">
								<label for="email">Number of attendees:</label>
								<input type="text" class="form-control input-sm" id="num_attendees" placeholder="Enter the number of tour attendees" name="num_attendees" value="<?php print ($this->getVar("num_attendees")) ? $this->getVar("num_attendees") : ""; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["archive_date"]) ? " has-error" : ""); ?>">
								<label for="email">Date of tour:</label>
								<input type="text" class="form-control input-sm" id="archive_date" placeholder="Enter your preferred tour date" name="archive_date" value="<?php print ($this->getVar("archive_date")) ? $this->getVar("archive_date") : ""; ?>">
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<p>For tours of Mrs. Lauder’s office please submit the following information:</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["office_date"]) ? " has-error" : ""); ?>">
								<label for="email">Date of tour:</label>
								<input type="text" class="form-control input-sm" id="office_date" placeholder="Enter your preferred tour date" name="office_date" value="<?php print ($this->getVar("office_date")) ? $this->getVar("office_date") : ""; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["office_time"]) ? " has-error" : ""); ?>">
								<label for="email">Time of tour:</label>
								<input type="text" class="form-control input-sm" id="office_time" placeholder="Enter your preferred tour time" name="office_time" value="<?php print ($this->getVar("office_time")) ? $this->getVar("office_time") : ""; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["office_num_guests"]) ? " has-error" : ""); ?>">
								<label for="email">Number of guests:</label>
								<input type="text" class="form-control input-sm" id="office_num_guests" placeholder="Enter the number of tour guests" name="office_num_guests" value="<?php print ($this->getVar("office_num_guests")) ? $this->getVar("office_num_guests") : ""; ?>">
							</div>
						</div><!-- end col -->
						<div class="col-sm-3">
							<div class="form-group<?php print (($va_errors["office_contact"]) ? " has-error" : ""); ?>">
								<label for="email">Contact:</label>
								<input type="text" class="form-control input-sm" id="office_contact" placeholder="Enter the primary contact person for the tour" name="office_contact" value="<?php print ($this->getVar("office_contact")) ? $this->getVar("office_contact") : ""; ?>">
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="form-group<?php print (($va_errors["office_guest_names"]) ? " has-error" : ""); ?>">
						<label for="email">Names of guests & titles:</label>
						<input type="text" class="form-control input-sm" id="office_guest_names" placeholder="Enter the names & titles of guests attending the tour" name="office_guest_names" value="<?php print ($this->getVar("office_guest_names")) ? $this->getVar("office_guest_names") : ""; ?>">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="form-group<?php print (($va_errors["office_reason"]) ? " has-error" : ""); ?>">
						<label for="email">Reason for tour:</label>
						<input type="text" class="form-control input-sm" id="office_reason" placeholder="Enter the reason for the tour" name="office_reason" value="<?php print ($this->getVar("office_reason")) ? $this->getVar("office_reason") : ""; ?>">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
<?php		
		break;
		# -----------------------------
	}
?>

				
		<div class="form-group">
			<br/><button type="submit" class="btn btn-default">Send</button>
		</div><!-- end form-group -->
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">

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