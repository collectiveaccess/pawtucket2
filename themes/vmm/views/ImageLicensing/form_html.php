<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$va_errors = $this->getVar("errors");
	if(!is_array($va_errors)){
		$va_errors = array();
	}
	$vn_num1 = rand(1,10);
	$vn_num2 = rand(1,10);
	$vn_sum = $vn_num1 + $vn_num2;
	$o_config = Configuration::load(__CA_THEME_DIR__.'/conf/image_licensing.conf');
	$va_licensing_form_elements = $o_config->get("licensing_form_elements");
	$va_licensing_form_elements_per_object = $o_config->get("licensing_form_elements_per_object");

	$pn_id = $this->request->getParameter("id", pInteger);
	$ps_table = $this->request->getParameter("table", pString);
	$vs_typecode = "";
	switch($ps_table){
		case "ca_objects":
			$t_item = new ca_objects($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Detail", "objects", $pn_id);
			$t_list_item = new ca_list_items();
			$t_list_item->load($t_item->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
		break;
		# ---------------------------
		case "ca_sets":
			$t_item = new ca_sets($pn_id);
			$vs_url = $this->request->config->get("site_host").caNavUrl($this->request, "Lightbox", "setDetail", $pn_id);
			$vs_admin_url = $o_config->get("admin_url")."/admin/index.php/manage/sets/SetEditor/Edit/set_id/".$pn_id;
			$vs_name = $t_item->getLabelForDisplay();
			# --- default to ask archivist
		break;
		# ---------------------------
	}
	if(!$vs_name && $t_item){
		$vs_name = $t_item->get($ps_table.".preferred_labels.name");
	}
	if($t_item && $ps_table){
		$vs_idno = $t_item->get($ps_table.".idno");
	}
?>
<div class="row"><div class="col-sm-12 col-lg-8 col-lg-offset-2">
			<H1>Image Licensing / Reproduction Request</H1>
		<?php
			if(is_array($va_errors["display_errors"]) && sizeof($va_errors["display_errors"])){
				print "<div class='alert alert-danger'>".implode("<br/>", $va_errors["display_errors"])."</div>";
			}
		?>
			<form id="licensingForm" action="<?php print caNavUrl($this->request, "", "ImageLicensing", "send"); ?>" role="form" method="post">
				<input type="hidden" name="crsfToken" value="<?php print caGenerateCSRFToken($this->request); ?>"/>
				<div class="row">
					<div class="col-md-12">
						<p>{{{image_licensing_intro}}}</p>
<?php
						print "<p>".caNavLink($this->request, _t("Schedule of Fees for Reproduction Services"), "", "", "About", "ReproLicenseFees")."</p>";
						if($t_item && $ps_table){
?>
							<hr/>
							<p><b>Title: </b><?php print $vs_name; ?>
							<br/><b>Regarding this URL: </b><a href="<?php print $vs_url; ?>" class="purpleLink"><?php print $vs_url; ?></a>
							</p>
							<input type="hidden" name="itemId" value="<?php print $vs_idno; ?>">
							<input type="hidden" name="itemTitle" value="<?php print $vs_name; ?>">
							<input type="hidden" name="itemURL" value="<?php print ($vs_admin_url) ? $vs_admin_url : $vs_url; ?>">
							<input type="hidden" name="id" value="<?php print $pn_id; ?>">
							<input type="hidden" name="table" value="<?php print $ps_table; ?>">
<?php
						}
?>
						<hr/>
					</div>
				</div>
					


				
					<div class="row">
						<div class="col-sm-12"><H2>Contact Information</H2><hr/></div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "name", $va_licensing_form_elements, $this->getVar("name"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "company", $va_licensing_form_elements, $this->getVar("company"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-4">
							<div class="form-group<?php print (($va_errors["security"]) ? " has-error" : ""); ?>">
								<label for="security">Security Question*</label>
								<div class='row'>
									<div class='col-sm-4'>
										<p class="form-control-static"><?php print $vn_num1; ?> + <?php print $vn_num2; ?> = </p>
									</div>
									<div class='col-sm-4'>
										<input name="security" value="" id="security" type="text" class="form-control input-sm" />
									</div>
								</div><!--end row-->
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "email", $va_licensing_form_elements, $this->getVar("email"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "telephone", $va_licensing_form_elements, $this->getVar("telephone"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "fax", $va_licensing_form_elements, $this->getVar("fax"), $va_errors); ?>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "address", $va_licensing_form_elements, $this->getVar("address"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-2">
							<?php print OutputFormElement($this->request, "city", $va_licensing_form_elements, $this->getVar("city"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-2">
							<?php print OutputFormElement($this->request, "state", $va_licensing_form_elements, $this->getVar("state"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-2">
							<?php print OutputFormElement($this->request, "country", $va_licensing_form_elements, $this->getVar("country"), $va_errors); ?>
						</div><!-- end col -->
						<div class="col-sm-2">
							<?php print OutputFormElement($this->request, "postal_code", $va_licensing_form_elements, $this->getVar("postal_code"), $va_errors); ?>
						</div><!-- end col -->
					</div><!-- end row -->
<?php
				if($t_item && $ps_table){
?>
					<div class="row">
						<div class="col-sm-12"><H2>Details of Order</H2><hr/></div>
					</div>
<?php
					$va_object_ids = array();
					if($ps_table == "ca_objects"){
						$va_object_ids[] = $pn_id;
					}elseif($ps_table == "ca_sets"){
						$va_object_ids = array_keys($t_item->getItemRowIDs(array("checkAccess" => $this->opa_access_values)));
					}
					$qr_objects = caMakeSearchResult('ca_objects', $va_object_ids, array('checkAccess' => $va_access_values));
					if($qr_objects->numHits()){
						while($qr_objects->nextHit()){
							$vs_img = $qr_objects->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values));
?>					
					<div class="row">
						<div class="col-sm-4 licensingFormItem"><label>Item</label><br/>
<?php
							if($vs_img){
								print caDetailLink($this->request, $vs_img, '', 'ca_objects', $qr_objects->get("ca_objects.object_id"))."<br/>";
							}
							print caDetailLink($this->request, $qr_objects->get("ca_objects.preferred_labels"), '', 'ca_objects', $qr_objects->get("ca_objects.object_id"));
?>
						<br/><br/></div><!-- end col -->
						<div class="col-sm-4">
<?php 
							print OutputFormElement($this->request, "print_size", $va_licensing_form_elements_per_object, $this->getVar("print_size".$qr_objects->get("ca_objects.object_id")), $va_errors, $qr_objects->get("ca_objects.object_id"));
?>
						</div><!-- end col -->
						<div class="col-sm-4">
<?php 
							print OutputFormElement($this->request, "resolution", $va_licensing_form_elements_per_object, $this->getVar("resolution".$qr_objects->get("ca_objects.object_id")), $va_errors, $qr_objects->get("ca_objects.object_id"));
?>
						</div><!-- end col -->
					</div>
<?php
						}
					}
				}
?>
					<div class="row">
						<div class="col-sm-12"><H2>Intended Use</H2><hr/></div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group<?php print (($va_errors["use"]) ? " has-error" : ""); ?>">
								<label for="use">Use*</label>
<?php
										if(is_array($va_licensing_form_elements["use"]["values"])){
?>
											<select name='use' id='use'><option value="">Please choose an option</option>
<?php
												foreach($va_licensing_form_elements["use"]["values"] as $vs_code => $vs_value){
													print "<option id='".$vs_code."' value='".$vs_value."' ".(($vs_value == $this->getVar("use")) ? "selected" : "").">".$vs_value."</option>";
												}
?>
											</select>
<?php
	
										}
?>
							</div>
						</div><!-- end col -->
					</div>				
					
					<div class="row imageLicenseUseElementGroup" id="use_publication">
						<div class="col-sm-3">
							<?php print OutputFormElement($this->request, "use_publication_title", $va_licensing_form_elements, $this->getVar("use_publication_title"), $va_errors); ?>
						</div>
						<div class="col-sm-3">
							<?php print OutputFormElement($this->request, "use_publication_publisher", $va_licensing_form_elements, $this->getVar("use_publication_publisher"), $va_errors); ?>
						</div>
						<div class="col-sm-3">
							<?php print OutputFormElement($this->request, "use_publication_date", $va_licensing_form_elements, $this->getVar("use_publication_date"), $va_errors); ?>
						</div>
						<div class="col-sm-3">
							<?php print OutputFormElement($this->request, "use_publication_print_run", $va_licensing_form_elements, $this->getVar("use_publication_print_run"), $va_errors); ?>
						</div>
					</div>
					<div class="row imageLicenseUseElementGroup" id="use_commercial_print">
						<div class="col-sm-6">
							<?php print OutputFormElement($this->request, "use_commercial_print_distribution", $va_licensing_form_elements, $this->getVar("use_commercial_print_distribution"), $va_errors); ?>
						</div>
						<div class="col-sm-6">
							<?php print OutputFormElement($this->request, "use_commercial_print_print_run", $va_licensing_form_elements, $this->getVar("use_commercial_print_print_run"), $va_errors); ?>
						</div>
					</div>	
					<div class="row imageLicenseUseElementGroup" id="use_commercial_video">
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "use_commercial_video_tv_title", $va_licensing_form_elements, $this->getVar("use_commercial_video_tv_title"), $va_errors); ?>
						</div>
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "use_commercial_video_air_date", $va_licensing_form_elements, $this->getVar("use_commercial_video_air_date"), $va_errors); ?>
						</div>
						<div class="col-sm-4">
							<?php print OutputFormElement($this->request, "use_commercial_video_copies", $va_licensing_form_elements, $this->getVar("use_commercial_video_copies"), $va_errors); ?>
						</div>
					</div>
					<div class="row imageLicenseUseElementGroup" id="use_commercial_exhibit">
						<div class="col-sm-6">
							<?php print OutputFormElement($this->request, "use_commercial_exhibit_location", $va_licensing_form_elements, $this->getVar("use_commercial_exhibit_location"), $va_errors); ?>
						</div>
						<div class="col-sm-6">
							<?php print OutputFormElement($this->request, "use_commercial_exhibit_duration", $va_licensing_form_elements, $this->getVar("use_commercial_exhibit_duration"), $va_errors); ?>
						</div>
					</div>
					<div class="row imageLicenseUseElementGroup" id="use_other">
						<div class="col-sm-12">
							<?php print OutputFormElement($this->request, "use_other", $va_licensing_form_elements, $this->getVar("use_other"), $va_errors); ?>
						</div>
					</div>					
					
					
					
					
					
					
					
					<div class="row">
						<div class="col-sm-12"><H2>Additional Comments</H2><hr/></div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group<?php print (($va_errors["message"]) ? " has-error" : ""); ?>">
								<label for="message">Comments</label>
								<textarea class="form-control input-sm" id="message" name="message" rows="5">{{{message}}}</textarea>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="form-group">
						<button type="submit" class="btn btn-default">Send</button>
					</div><!-- end form-group -->
					<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
				</form>
	
		
		
	</div><!-- end col --></div><!-- end row -->
<script type="text/javascript">

$(document).ready(function(){
	$(".imageLicenseUseElementGroup").hide();
	var selectedOption = $("#use").find("option:selected");
	if(selectedOption){
		var idCode = selectedOption.attr("id");
		if(idCode){
			$("#use_" + idCode).show();
		}
	}
		
	
	$("#use").change(function(){

        $(this).find("option:selected").each(function(){
			$(".imageLicenseUseElementGroup").hide();
            var idCode = $(this).attr("id");
			if(idCode){
				$("#use_" + idCode).show();
			}
		});
	});

});
</script>
<?php
	function OutputFormElement($po_request, $vs_element_code, $va_config_array=array(), $vs_element_value, $va_errors, $vn_object_id = null){
		if(!$va_config_array[$vs_element_code]){
			return false;
		}
		$vs_element = "<div class='form-group".(($va_errors[$vs_element_code.$vn_object_id]) ? " has-error" : "")."'>
								<label for='".$vs_element_code.$vn_object_id."'>".$va_config_array[$vs_element_code]["label"].(($va_config_array[$vs_element_code]["required"]) ? "*" : "")."</label>
								<input type='text' class='form-control input-sm' id='".$vs_element_code.$vn_object_id."' placeholder='".$va_config_array[$vs_element_code]["placeholder"]."' name='".$vs_element_code.$vn_object_id."' value='".$vs_element_value."'>
							</div>";
		return $vs_element;
	}
?>