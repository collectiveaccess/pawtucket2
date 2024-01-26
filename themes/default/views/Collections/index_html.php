<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$va_access_values = $this->getVar("access_values");
	$vs_image_format = ($o_collections_config->get("landing_page_item_image_format")) ? $o_collections_config->get("landing_page_item_image_format"): "cover";
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

	$vs_item_display_template = ($o_collections_config->get("landing_page_item_display_template")) ? $o_collections_config->get("landing_page_item_display_template") : "<div class='card-title'><div class='fw-medium lh-sm fs-5'><l>^ca_collections.preferred_labels</l></div></div>";
?>
	<div class="row">
		<div class='col-12'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_collections_config->get("landing_page_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='my-3 fs-4'>".$vs_tmp."</div>";
		}
	}
	if($qr_collections && $qr_collections->numHits()) {
?>
		<div class="row">
<?php
		while($qr_collections->nextHit()) { 
			# --- image on collection record or related object?
			if($vs_image_class){
				if(!($vs_thumbnail = $qr_collections->get("ca_object_representations.media.medium", array("checkAccess" => $va_access_values, "class" => $vs_image_class)))){
					$vs_thumbnail = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium</ifdef></unit>", array("checkAccess" => $va_access_values, "class" => $vs_image_class));
				}
			}			
			
			print "<div class='col-sm-6 col-lg-4 d-flex'>";
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>".$vs_thumbnail."
							<div class='card-body'>".$qr_collections->getWithTemplate($vs_item_display_template)."</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
			print caDetailLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
			print "</div>";
		}
?>
		</div>
<?php
	} else {
		print "<div class='my-3 fs-4'>"._t('No collections available')."</div>";
	}
?>
		</div>
	</div>
