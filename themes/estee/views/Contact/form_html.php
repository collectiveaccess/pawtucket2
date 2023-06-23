<div class="row">
	<div class="col-sm-12 col-md-10 col-md-offset-1">

<?php
	$va_access_values = caGetUserAccessValues($this->request);
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
	$pn_set_id = $this->request->getParameter("set_id", pInteger);
	if($pn_set_id){
		require_once(__CA_MODELS_DIR__."/ca_sets.php");
		$t_item = new ca_sets($pn_set_id);
		# --- what url will we use for sets?
		$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "", "Lightbox", "setDetail", array("set_id" => $pn_set_id));
		$vs_admin_url = $this->request->config->get("site_host")."/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_set_id;
		$vs_name = $t_item->getLabelForDisplay();
		$vs_idno = "";
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
					print "<H1>Item Inquiry</H1>";
				break;
				case "projectInquiry":
					print "<H1>Project Inquiry</H1>";
				break;
				#case "transfer":
				#	print "<H1>Transfer to the Archives</H1>";
				#break;
				case "folderScanRequest":
				case "avScanRequest":
				case "digitizationRequest":
					print "<H1>Digitization Request</H1>";
				break;
				default:
					print "<H1>Contact the Archives</H1>";
?>
					<p>{{{contact_intro}}}</p>
<?php
				break;
			}
?>
		</div>
	</div>
<?php
	if(is_array($va_errors) && sizeof($va_errors["display_errors"])){
		print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
	}
	
	switch($ps_contactType){
		case "inquiry":
		case "projectInquiry":
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

			<div class="row">
				<div class="col-sm-12">
					<hr/>
					<b>Title: </b><?php print $vs_name; ?>
					<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a>
					<br/>
					<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
					<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
					<input type="hidden" name="itemURL" value="<?php print $vs_url; ?>">
					<hr/><br/>
<?php
					if($ps_contactType == "inquiry"){
?>
						<p>{{{contact_item_inquiry_intro}}}</p>
<?php
					}
?>								
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
								<label for="name">Your Name</label>
								<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
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
					<div class="form-group<?php print (($va_errors["request_type"]) ? " has-error" : ""); ?>">
						<label for="name">I would like</label>
						<select class="form-control input-sm" id="request_type" name="request_type">
							<option value=''>Please choose an option</option>
<?php
					if($ps_contactType == "inquiry"){
?>
							<option value='More information about this item' <?php print ($this->getVar("request_type") == "More information about this item") ? "selected" : ""; ?>>More information about this item</option>
							<option value='To request a digital file' <?php print ($this->getVar("request_type") == "To request a digital file") ? "selected" : ""; ?>>To request a digital file</option>
							<option value='To see the item in person' <?php print ($this->getVar("request_type") == "To see the item in person") ? "selected" : ""; ?>>To see the item in person</option>
<?php
					}else{
?>
							<option value='More information about these items' <?php print ($this->getVar("request_type") == "More information about these items") ? "selected" : ""; ?>>More information about these items</option>
							<option value='To request digital files' <?php print ($this->getVar("request_type") == "To request digital files") ? "selected" : ""; ?>>To request digital files</option>
							<option value='To see the items in person' <?php print ($this->getVar("request_type") == "To see the items in person") ? "selected" : ""; ?>>To see the items in person</option>
<?php
					}
?>							
							<option value="A few different things, I'll explain below" <?php print ($this->getVar("request_type") == "A few different things, I'll explain below") ? "selected" : ""; ?>>A few different things, I'll explain below</option>
						</select>
					</div>
							
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["request_date"]) ? " has-error" : ""); ?>">
						<label for="email">Date Needed By</label>
						<input type="text" class="form-control input-sm" id="request_date" placeholder="Enter the date you need the information by" name="request_date" value="<?php print ($this->getVar("request_date")) ? $this->getVar("request_date") : ""; ?>">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
						<label for="message">GENERAL QUESTION AND PURPOSE</label>
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
					<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
						<label for="attachment">Attach A File</label>
						<input type="file" class="form-control-file" id="attachment" name="attachment">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<br/><button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
				</div>
			</div>
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
		<input type="hidden" name="set_id" value="<?php print $pn_set_id; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="contactTypeLabel" value="<?php print ($ps_contactType == "projectInquiry") ? "Project Inquiry" : "Item Inquiry"; ?>">

	</form>
<?php		
		break;
		# -----------------------------
		case "folderScanRequest":
		case "avScanRequest":
		case "digitizationRequest":
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

			<div class="row">
				<div class="col-sm-12">
					<hr/>
					<b>Title: </b><?php print $vs_name; ?>
					<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>"><?php print $vs_url; ?></a>
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
								<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
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
<?php
						$ps_contactTypeLabel = "";
						switch($ps_contactType){
							case "folderScanRequest":
								$ps_contactTypeLabel = "Folder Scan Request";
?>
								<label for="message">I would like the full contents of this folder to be scanned</label>
<?php
							break;
							case "avScanRequest":
								$ps_contactTypeLabel = "AV Scan Request";
?>
								<label for="message">I would like this audiovisual item to be digitized</label>
<?php
							break;
							case "digitizationRequest":
								$ps_contactTypeLabel = "Digitization Request";
?>
								<label for="message">I would like this item to be digitized</label>
<?php							
							break;						
						}
?>
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
					<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
						<label for="attachment">Attach A File</label>
						<input type="file" class="form-control-file" id="attachment" name="attachment">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<br/><button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
				</div>
			</div>
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
		<input type="hidden" name="set_id" value="<?php print $pn_set_id; ?>">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
		<input type="hidden" name="contactTypeLabel" value="Folder Scan Request">

	</form>
<?php		
		break;
		# -----------------------------
		case "transferOLD":
?>
	<form id="contactForm" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

			<div class="row">
				<div class="col-sm-12">
					<p>{{{transfer_text}}}</p>
					<hr/>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
								<label for="name">Your Name</label>
								<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
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
						<label for="message">I AM INTERESTED IN TRANSFERING THE FOLLOWING MATERIAL</label>
						<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
						<label for="attachment">Attach A File</label>
						<input type="file" class="form-control-file" id="attachment" name="attachment">
					</div>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<br/><button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
				</div>
			</div>
		<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
		<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
		<input type="hidden" name="contactTypeLabel" value="Transfer Request">
		<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">

	</form>
<?php
		break;
		# -----------------------------
		default:
?>
	<br/><br/>
		<div class="tabModuleContent">
			<article class="tabModuleContentInner float100">	
				<section class="tabsTitle float100">
					<ul role="tablist">
						<li role="presentation" class="active"><a href="#general" aria-controls="General Questions" role="tab" data-toggle="tab">General Questions</a></li>
						<li role="presentation"><a href="#tours" aria-controls="profile" role="tab" data-toggle="tab">Tours</a></li>
						<li role="presentation"><a href="#research" aria-controls="settings" role="tab" data-toggle="tab">Research Appointments</a></li>
						<li role="presentation"><a href="#transfer" aria-controls="settings" role="tab" data-toggle="tab">Transfer to Archives</a></li>
					</ul>
				</section>
				<section class="tabsContent float100">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="general">	
	
							<form id="contactFormGeneral" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
								<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

									<div class="row">
										<div class="col-sm-12">
											<h2>General Questions</H2>
											<p>{{{contact_general_intro}}}</p>
					
										</div>
									</div>		
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
														<label for="name">Your Name</label>
														<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
														<label for="email">Your Email Address</label>
														<input type="text" class="form-control input-sm" id="email" placeholder="Enter your email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
												<label for="message">General Question</label>
												<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["request_date"]) ? " has-error" : ""); ?>">
												<label for="email">Date Information Needed By</label>
												<input type="text" class="form-control input-sm" id="request_date" placeholder="Enter the date you need the information by" name="request_date" value="<?php print ($this->getVar("request_date")) ? $this->getVar("request_date") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
												<label for="attachment">Attach A File</label>
												<input type="file" class="form-control-file" id="attachment" name="attachment">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
			
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<br/><button type="submit" class="btn btn-default">Send</button>
											</div><!-- end form-group -->
										</div>
									</div>
		
								<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
								<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
								<input type="hidden" name="contactTypeLabel" value="General Questions">
								<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">

							</form>	
						</div>
		
						<div role="tabpanel" class="tab-pane" id="tours">
	
							<form id="contactFormHeritageTour" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
								<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
		
									<div class="row">
										<div class="col-sm-12">
											<H2>Heritage Tours</H2>
											<p>{{{contact_heritage_tours_intro}}}</p>

										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
														<label for="name">Your Name</label>
														<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
														<label for="email">Your Email Address</label>
														<input type="text" class="form-control input-sm" id="email" placeholder="Enter your email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->					
											<div class="row">
												<div class="col-md-12">
													<div class="form-group<?php print (($va_errors["tour_reason"]) ? " has-error" : ""); ?>">
														<label for="email">Reason For Tour</label>
														<input type="text" class="form-control input-sm" id="tour_reason" placeholder="Enter the reason for the tour (e.g. Company orientation, visiting NY offices from out of town. . .)" name="tour_reason" value="<?php print ($this->getVar("tour_reason")) ? $this->getVar("tour_reason") : ""; ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["tour_date"]) ? " has-error" : ""); ?>">
														<label for="email">Requested Date Of Tour</label>
														<input type="text" class="form-control input-sm" id="tour_date" placeholder="Enter your preferred tour date" name="tour_date" value="<?php print ($this->getVar("tour_date")) ? $this->getVar("tour_date") : ""; ?>">
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["tour_time"]) ? " has-error" : ""); ?>">
														<label for="email">Requested Time of tour</label>
														<input type="text" class="form-control input-sm" id="tour_time" placeholder="Enter your preferred tour time" name="tour_time" value="<?php print ($this->getVar("tour_time")) ? $this->getVar("tour_time") : ""; ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["elc_employee"]) ? " has-error" : ""); ?>">
														<label for="name">The Tour Is For</label>
														<select class="form-control input-sm" id="elc_employee" name="elc_employee">
															<option value=''>Please choose an option</option>
															<option value='ELC employee(s)' <?php print ($this->getVar("elc_employee") == "ELC employee(s)") ? "selected" : ""; ?>>ELC employee(s)</option>
															<option value='Non ELC employee(s)' <?php print ($this->getVar("elc_employee") == "Non ELC employee(s)") ? "selected" : ""; ?>>Non ELC employee(s)</option>
														</select>
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["brand"]) ? " has-error" : ""); ?>">
														<label for="email">Brand/Team</label>
														<input type="text" class="form-control input-sm" id="email" placeholder="Enter your Brand/Team" name="brand" value="<?php print ($this->getVar("brand")) ? $this->getVar("brand") : ""; ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["office_contact"]) ? " has-error" : ""); ?>">
														<label for="email">Contact</label>
														<input type="text" class="form-control input-sm" id="office_contact" placeholder="Enter the primary contact person for the tour" name="office_contact" value="<?php print ($this->getVar("office_contact")) ? $this->getVar("office_contact") : ""; ?>">
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["num_attendees"]) ? " has-error" : ""); ?>">
														<label for="email">Number Of Attendees</label>
														<input type="text" class="form-control input-sm" id="num_attendees" placeholder="Enter the number of tour attendees" name="num_attendees" value="<?php print ($this->getVar("num_attendees")) ? $this->getVar("num_attendees") : ""; ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
											<div class="row">
												<div class="col-md-12">
													<div class="form-group<?php print (($va_errors["guest_names"]) ? " has-error" : ""); ?>">
														<label for="email">Names & Titles Of Attendees</label>
														<input type="text" class="form-control input-sm" id="guest_names" placeholder="Enter the names & titles of guests attending the tour" name="guest_names" value="<?php print ($this->getVar("guest_names")) ? $this->getVar("guest_names") : ""; ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
														<label for="message">Additional Comments</label>
														<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
												<label for="attachment">Attach A File</label>
												<input type="file" class="form-control-file" id="attachment" name="attachment">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<br/><button type="submit" class="btn btn-default">Send</button>
											</div><!-- end form-group -->
										</div>
									</div>
		
								<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
								<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
								<input type="hidden" name="contactType" value="Heritage Tours">
								<input type="hidden" name="contactTypeLabel" value="<?php print $ps_contactType; ?>">

							</form>	
		
						<hr/>
	
		
									<div class="row">
										<div class="col-sm-12">
											<H2>Tours of Mrs. Estée Lauder’s Office</H2>
											<p>{{{contact_office_tours_intro}}}</p>
										</div>
									</div>
<?php
	# --- hide the form for this, but keep code in case they want it back
	if($vs_show_form){
?>
							<form id="contactFormOfficeTour" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
								<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
												<label for="name">Your Name</label>
												<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
												<label for="email">Your Email Address</label>
												<input type="text" class="form-control input-sm" id="email" placeholder="Enter your email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group<?php print (($va_errors["tour_reason"]) ? " has-error" : ""); ?>">
												<label for="email">Reason For Tour</label>
												<input type="text" class="form-control input-sm" id="tour_reason" placeholder="Enter the reason for the tour" name="tour_reason" value="<?php print ($this->getVar("tour_reason")) ? $this->getVar("tour_reason") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["tour_date"]) ? " has-error" : ""); ?>">
												<label for="email">Requested Date Of Tour</label>
												<input type="text" class="form-control input-sm" id="tour_date" placeholder="Enter your preferred tour date" name="tour_date" value="<?php print ($this->getVar("tour_date")) ? $this->getVar("tour_date") : ""; ?>">
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["tour_time"]) ? " has-error" : ""); ?>">
												<label for="email">Requested Time of tour</label>
												<input type="text" class="form-control input-sm" id="tour_time" placeholder="Enter your preferred tour time" name="tour_time" value="<?php print ($this->getVar("tour_time")) ? $this->getVar("tour_time") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["elc_employee"]) ? " has-error" : ""); ?>">
												<label for="name">The Tour Is For</label>
												<select class="form-control input-sm" id="elc_employee" name="elc_employee">
													<option value=''>Please choose an option</option>
													<option value='ELC employee(s)' <?php print ($this->getVar("elc_employee") == "ELC employee(s)") ? "selected" : ""; ?>>ELC employee(s)</option>
													<option value='Non ELC employee(s)' <?php print ($this->getVar("elc_employee") == "Non ELC employee(s)") ? "selected" : ""; ?>>Non ELC employee(s)</option>
												</select>
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["brand"]) ? " has-error" : ""); ?>">
												<label for="email">Brand/Team</label>
												<input type="text" class="form-control input-sm" id="email" placeholder="Enter your Brand/Team" name="brand" value="<?php print ($this->getVar("brand")) ? $this->getVar("brand") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["office_contact"]) ? " has-error" : ""); ?>">
												<label for="email">Contact</label>
												<input type="text" class="form-control input-sm" id="office_contact" placeholder="Enter the primary contact person for the tour" name="office_contact" value="<?php print ($this->getVar("office_contact")) ? $this->getVar("office_contact") : ""; ?>">
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["num_attendees"]) ? " has-error" : ""); ?>">
												<label for="email">Number Of Attendees</label>
												<input type="text" class="form-control input-sm" id="num_attendees" placeholder="Enter the number of tour attendees" name="num_attendees" value="<?php print ($this->getVar("num_attendees")) ? $this->getVar("num_attendees") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group<?php print (($va_errors["guest_names"]) ? " has-error" : ""); ?>">
												<label for="email">Names & Titles Of Attendees</label>
												<input type="text" class="form-control input-sm" id="guest_names" placeholder="Enter the names & titles of guests attending the tour" name="guest_names" value="<?php print ($this->getVar("guest_names")) ? $this->getVar("guest_names") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
												<label for="message">Additional Comments</label>
												<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
												<label for="attachment">Attach A File</label>
												<input type="file" class="form-control-file" id="attachment" name="attachment">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
			
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<br/><button type="submit" class="btn btn-default">Send</button>
											</div><!-- end form-group -->
										</div>
									</div>
		
								<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
								<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
								<input type="hidden" name="contactTypeLabel" value="Tours of Mrs. Estée Lauder's Office">
								<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">

							</form>	
<?php
	}
?>
						</div>
						<div role="tabpanel" class="tab-pane" id="research">		
	
							<form id="contactFormResearchAppointment" action="<?php print caNavUrl($this->request, "", "Contact", "send"); ?>" role="form" method="post" enctype="multipart/form-data">
								<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>	
		
			
									<div class="row">
										<div class="col-sm-12">
											<H2>Research Appointments</H2>
											<p>{{{contact_research_appointment_intro}}}</p>
										</div>
									</div>
			
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["name"]) ? " has-error" : ""); ?>">
														<label for="name">Your Name</label>
														<input type="text" class="form-control input-sm" id="name" placeholder="Enter your name" name="name" value="<?php print $this->getVar("name"); ?>">
													</div>
												</div><!-- end col -->
												<div class="col-sm-6">
													<div class="form-group<?php print (($va_errors["email"]) ? " has-error" : ""); ?>">
														<label for="email">Your Email Address</label>
														<input type="text" class="form-control input-sm" id="email" placeholder="Enter your email" name="email" value="<?php print ($this->getVar("email")) ? $this->getVar("email") : $this->request->user->get("email"); ?>">
													</div>
												</div><!-- end col -->
											</div><!-- end row -->
										</div><!-- end col -->
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group<?php print (($va_errors["research_reason"]) ? " has-error" : ""); ?>">
												<label for="email">Reason for Research Appointment</label>
												<input type="text" class="form-control input-sm" id="research_reason" placeholder="Enter the reason for the research appointment" name="research_reason" value="<?php print ($this->getVar("research_reason")) ? $this->getVar("research_reason") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group<?php print (($va_errors["materials_requested"]) ? " has-error" : ""); ?>">
												<label for="email">Materials Requested</label>
												<input type="text" class="form-control input-sm" id="materials_requested" placeholder="Enter the materials requested" name="materials_requested" value="<?php print ($this->getVar("materials_requested")) ? $this->getVar("materials_requested") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["tour_date"]) ? " has-error" : ""); ?>">
												<label for="email">Requested Appointment Date</label>
												<input type="text" class="form-control input-sm" id="tour_date" placeholder="Enter your preferred appointment date" name="tour_date" value="<?php print ($this->getVar("tour_date")) ? $this->getVar("tour_date") : ""; ?>">
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["tour_time"]) ? " has-error" : ""); ?>">
												<label for="email">Requested Appointment Time</label>
												<input type="text" class="form-control input-sm" id="tour_time" placeholder="Enter your preferred appointment time" name="tour_time" value="<?php print ($this->getVar("tour_time")) ? $this->getVar("tour_time") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["brand"]) ? " has-error" : ""); ?>">
												<label for="email">Brand/Team</label>
												<input type="text" class="form-control input-sm" id="email" placeholder="Enter your Brand/Team" name="brand" value="<?php print ($this->getVar("brand")) ? $this->getVar("brand") : ""; ?>">
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["office_contact"]) ? " has-error" : ""); ?>">
												<label for="email">Contact</label>
												<input type="text" class="form-control input-sm" id="office_contact" placeholder="Enter the primary contact person for the appointment" name="office_contact" value="<?php print ($this->getVar("office_contact")) ? $this->getVar("office_contact") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["num_attendees"]) ? " has-error" : ""); ?>">
												<label for="email">Number of Attendees</label>
												<select class="form-control input-sm" id="num_attendees" name="num_attendees">
													<option value=''>Please choose an option</option>
													<option value='1' <?php print ($this->getVar("num_attendees") == "1") ? "selected" : ""; ?>>1</option>
													<option value='2' <?php print ($this->getVar("num_attendees") == "2") ? "selected" : ""; ?>>2</option>
													<option value='3' <?php print ($this->getVar("num_attendees") == "3") ? "selected" : ""; ?>>3</option>
													<option value='4' <?php print ($this->getVar("num_attendees") == "4") ? "selected" : ""; ?>>4</option>
												</select>
											</div>
										</div><!-- end col -->
										<div class="col-sm-6">
											<div class="form-group<?php print (($va_errors["guest_names"]) ? " has-error" : ""); ?>">
												<label for="email">Names & Titles Of Attendees</label>
												<input type="text" class="form-control input-sm" id="guest_names" placeholder="Enter the names & titles of guests attending the tour" name="guest_names" value="<?php print ($this->getVar("guest_names")) ? $this->getVar("guest_names") : ""; ?>">
											</div>
										</div><!-- end col -->
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
												<label for="message">Special Requests / Comments</label>
												<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group<?php print (($va_errors["attachment"]) ? " has-error" : ""); ?>">
												<label for="attachment">Attach A File</label>
												<input type="file" class="form-control-file" id="attachment" name="attachment">
											</div>
										</div><!-- end col -->
									</div><!-- end row -->
			
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<br/><button type="submit" class="btn btn-default">Send</button>
											</div><!-- end form-group -->
										</div>
									</div>
			
		
								<input type="hidden" name="object_id" value="<?php print $pn_object_id; ?>">
								<input type="hidden" name="collection_id" value="<?php print $pn_collection_id; ?>">
								<input type="hidden" name="contactTypeLabel" value="Research Appointments">
								<input type="hidden" name="contactType" value="<?php print $ps_contactType; ?>">
							</form>
						</div>
						<div role="tabpanel" class="tab-pane" id="transfer">
							
									<div class="row">
										<div class="col-sm-12">
											<H2>Transfer to Archives</H2>
											<p>{{{transfer_text}}}</p>
					
										</div>
									</div>
									

						</div>
					</div>
				</section>
			</article>
		</div>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			$('#contactTabs a').click(function (e) {
				e.preventDefault()
				$(this).tab('show')
			});
			$('#myTabs a[href="#general"]').tab('show');
		});
	</script>
<?php		
		break;
		# -----------------------------
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
	</div>
</div>