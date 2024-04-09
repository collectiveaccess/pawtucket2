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
		<h1><?php print $this->getVar("section_name").(($this->getVar("group_name")) ? ": ".$this->getVar("group_name") : ""); ?></h1>
<?php
	if($vs_intro = $this->getVar("group_description")){
		print "<div class='mb-4 mt-3 fs-4'>".$vs_intro."</div>";
	}
	if(is_array($va_sets) && sizeof($va_sets)){
		if($vb_landing_page_show_featured_gallery){
?>
		<div id="galleryLandingFeatured" class="bg-body-tertiary mb-5 py-3">
			<div class="row justify-content-center pt-3 pb-4 px-5">
				<div class="col">
					
					<H2 class="display-6 text-dark"><?php print $o_gallery_config->get("landing_page_featured_heading"); ?></H2>
					<div class="row">
<?php
						$vn_featured_set_id = array_rand($va_sets);
						$va_set = $va_sets[$vn_featured_set_id];
						$t_set = new ca_sets();
						$va_first_item = array_shift($va_first_items_from_set[$vn_featured_set_id]);
						$t_set->load($vn_featured_set_id);
						print "<div class='col-sm-6 img-fluid'>".caNavLink($this->request, "<img src='".$va_first_item["representation_url"]."' alt='Image from ".$va_set["name"]."' class='object-fit-cover w-100'>", "", "", "Gallery", $vn_featured_set_id)."</div>";
						
						print "<div class='col-sm-6'>".caNavLink($this->request, $va_set["name"], "fs-4 fw-medium", "", "Gallery", $vn_featured_set_id);
						if($vs_desc = $t_set->get("ca_sets.".$vs_description_element_code)){
							if(mb_strlen($vs_desc) > 400){
								$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
							}
							print "<div class='py-2 fs-4'>".$vs_desc."</div>";
						}
						print "<div class='text-center py-2 text-capitalize'>".caNavLink($this->request, _t("View ").$o_gallery_config->get("gallery_section_item_name")." <i class='bi bi-arrow-right'></i>", "btn btn-primary", "", "Gallery", $vn_featured_set_id)."</div>";
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
		}
?>
		<div class="row">
<?php
		foreach($va_sets as $vn_set_id => $va_set){
			if($vn_set_id == $vn_featured_set_id){
				continue;
			}
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			print "<div class='col-sm-6 col-lg-4 d-flex'>";
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'><img src='".$va_first_item["representation_url"]."' class='".$vs_image_class."' alt=''>
							<div class='card-body'>
								<div class='card-title fw-medium lh-sm fs-4 text-decoration-underline'>".$va_set["name"]."</div>
								<div class='card-text small text-body-secondary'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div>
							</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
			print caNavLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "", "gallery", $vn_set_id);
			print "</div>";
		}
?>
		</div>
<?php
	}
	
	
	
	
	
?>
	</div><!-- end col -->
</div><!-- end row -->