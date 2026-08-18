<?php
	$o_gallery_config = caGetGalleryConfig();

	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$vs_image_format = ($o_gallery_config->get("landing_page_item_image_format")) ? $o_gallery_config->get("landing_page_item_image_format"): "cover";
	$vs_image_class = "";
	switch($vs_image_format){
		case "contain":
			$vs_image_class = "card-img-top object-fit-contain px-3 pt-3 rounded-0";
		break;
		# --------------------
		case "cover":
			$vs_image_class = "card-img-top object-fit-cover rounded-0";
		break;
		# --------------------
	}
	$vs_description_element_code = $o_gallery_config->get("gallery_set_description_element_code");
 	$vb_landing_page_show_featured_gallery = ($o_gallery_config->get("landing_page_dont_show_featured_gallery") > 0) ? ($vb_landing_page_show_featured_gallery = false) : ($vb_landing_page_show_featured_gallery = true);
 	$va_sets = $this->getVar("sets");
 	$va_first_items_from_set = $this->getVar("first_items_from_sets");
?>

<div class="row">
	<div class='col-12'>
<?php
	if($vs_intro_global_value = $o_gallery_config->get("landing_page_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='mb-4 mt-3 fs-4'>".$vs_tmp."</div>";
		}
	}
	$va_set_links = array();
	if(is_array($va_sets) && sizeof($va_sets)){
		foreach($va_sets as $vn_set_id => $va_set){
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			$t_set = new ca_sets();
			$t_set->load($vn_set_id);
			if($t_set->get("ca_sets.featured", array("convertCodesToDisplayText" => true)) == "Yes"){
?>
				<H2><?php print $o_gallery_config->get("landing_page_featured_heading"); ?></H2>
				<div id="galleryLandingFeatured" class="bg-body-tertiary mb-5 py-3 double-border">
					<div class="row justify-content-center pt-3 pb-4 px-2 px-lg-5">
						<div class="col">
							
							<div class="row">
<?php
								if($va_first_item["representation_url"]){
									print "<div class='col-sm-6 img-fluid'>".caNavLink($this->request, "<img src='".$va_first_item["representation_url"]."' alt='Image from ".$va_set["name"]."' class='object-fit-".$vs_image_format." w-100'>", "", "", "Gallery", $vn_set_id)."</div>";
								
									print "<div class='col-sm-6'>";
								}else{
									print "<div class='col-12'>";
								}
								
								print caNavLink($this->request, $va_set["name"], "fs-2 fw-bold", "", "Gallery", $vn_set_id);
								if($vs_desc = strip_tags($t_set->get("ca_sets.".$vs_description_element_code))){
									if(mb_strlen($vs_desc) > 400){
										$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
									}
									print "<div class='py-2 fs-4 mb-3'>".$vs_desc."</div>";
								}
								print "<div class='text-center py-2 text-capitalize'>".caNavLink($this->request, _t("View ").$o_gallery_config->get("gallery_section_item_name")." <i class='bi bi-arrow-right'></i>", "btn btn-primary", "", "Gallery", $vn_set_id)."</div>";
								print "</div>";
								
?>
							</div>
								
						</div>
					</div>
				</div>		
				<div class="row">
					<div class='col-12'>
						<h3 class="text-capitalize"><?php print _t("More ").$o_gallery_config->get("gallery_section_item_name_plural"); ?></h3>
					</div>
				</div>
<?php				
			}else{
				$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 mb-4 outlineItem double-border h-100 text-center'>
								<div class='card-body p-3 fs-3 text-black text-decoration-none fst-italic align-content-center'>
									<div class='card-title fw-medium lh-sm fs-3 text-decoration-underline'>".$va_set["name"]."</div>
									<div class='card-text small text-body-secondary mb-0 pb-0'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("record") : _t("records"))."</div>
								</div>
							</div>";
				$va_set_links[] = "<div class='col-sm-6 col-lg-4 d-flex mb-4'>".caNavLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "", "gallery", $vn_set_id)."</div>";
			}
		}
		
?>
		<div class="row mb-5">
<?php
			print join("", $va_set_links);
?>
		</div>
<?php
	}
	
	
	
	
	
?>
	</div><!-- end col -->
</div><!-- end row -->