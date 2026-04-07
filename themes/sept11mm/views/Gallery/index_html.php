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
 	$va_sets = $this->getVar("sets");
 	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$va_first_items_from_set = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
			
	$set_ids_next_previous = array();
?>

<div class="row">
	<div class='col-12'>
		<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_gallery_config->get("landing_page_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='mb-4 mt-3 fs-4'>".$vs_tmp."</div>";
		}
	}
	if(is_array($va_sets) && sizeof($va_sets)){
?>
		<div class="row">
<?php
		$va_first_sets = array();
		$va_other_sets = array();
		# --- loop through all sets and pull out the ones flagged to display first
		foreach($va_sets as $vn_set_id => $va_set){
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'><img src='".$va_first_item["representation_url"]."' class='".$vs_image_class."' alt=''>
							<div class='card-body'>
								<div class='card-title fw-medium lh-sm fs-4 text-decoration-underline'>".$va_set["name"]."</div>
								<div class='card-text small text-body-secondary'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div>
							</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View Gallery<i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
			$output = "";
			$output = "<div class='col-sm-6 col-lg-4 d-flex'>".caNavLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "", "gallery", $vn_set_id)."</div>";
			$va_sets[$va_set["set_code"]] = array("id" => $vn_set_id, "output" => $output);
		}
		# --- output sets flagged to display first
		#ksort($va_first_sets);
		#foreach($va_first_sets as $set_id => $tmp){
		#	print $tmp;
		#	$set_ids_next_previous[] = $set_id;			
		#}
		# --- output remaining sets
		ksort($va_sets);
		foreach($va_sets as $tmp){
			print $tmp["output"];
			$set_ids_next_previous[] = $tmp["id"];
		}
?>
		</div>
<?php
	}
	
	
	
	
	
?>
	</div><!-- end col -->
</div><!-- end row -->
<?php
		$o_context = new ResultContext($this->request, 'ca_sets', 'gallery');
		$o_context->setAsLastFind();
		$o_context->setResultList($set_ids_next_previous);
		$o_context->saveContext();

?>