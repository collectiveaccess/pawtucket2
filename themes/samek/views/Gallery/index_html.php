<?php
$o_gallery_config = caGetGalleryConfig();

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
$va_set_groups = $this->getVar("groups");
$lastElement = array_pop($va_set_groups);
array_unshift($va_set_groups, $lastElement);

// print_R($va_set_groups);
// print_R($lastElement);

?>
<div class="row">
	<div class='col-12'>
		<h1><?= $this->getVar("section_name"); ?></h1>
<?php
	if($vs_intro_global_value = $o_gallery_config->get("landing_page_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='mb-4 mt-3 fs-4'>".$vs_tmp."</div>";
		}
	}
	if(is_array($va_set_groups) && sizeof($va_set_groups)){
?>
		<div class="row">
<?php
		foreach($va_set_groups as $vn_group_id => $va_set_group){
			$vs_desc = "";
			if($vs_desc = $va_set_group["description"]){
				if(mb_strlen($vs_desc) > 400){
					$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
				}
				$vs_desc = "<div class='card-text small text-body-secondary'>".$vs_desc."</div>";
			}
			print "<div class='col-sm-6 d-flex'>";
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'><img src='".$va_set_group["image"]."' class='".$vs_image_class."' alt=''>
							<div class='card-body'>
								<div class='card-title fw-medium lh-sm fs-4 text-decoration-underline'>".$va_set_group["name"]."</div>
								".$vs_desc."
							</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
						
			print caNavLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "", "gallery", "list", array("group" => $vn_group_id));
			print "</div>";
		}
?>
		</div>
<?php
	}
?>
	</div><!-- end col -->
</div><!-- end row -->

<?php
	//
	// Output named collections
	//
	$qr_collections = ca_collections::findAsSearchResult('*');
	
	if($qr_collections && ($qr_collections->numHits() > 0)) {
?>
<div class="row">
	<div class='col-12'>
		<h1>Collections</h1>
		<div class="row">
<?php
		while($qr_collections->nextHit()) {
			$collection_id = $qr_collections->get('ca_collections.collection_id');
			$image = $qr_collections->get('ca_object_representations.media.large.url');
			$name = $qr_collections->get('ca_collections.preferred_labels');
		
			$vs_desc = "";
			if($vs_desc = $qr_collections->get('ca_collections.description')){
				if(mb_strlen($vs_desc) > 400){
					$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
				}
				$vs_desc = "<div class='card-text small text-body-secondary'>".$vs_desc."</div>";
			}
			print "<div class='col-sm-6 d-flex'>";
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'><img src='".$image."' class='".$vs_image_class."' alt=''>
							<div class='card-body'>
								<div class='card-title fw-medium lh-sm fs-4 text-decoration-underline'>".$name."</div>
								".$vs_desc."
							</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
						
			print caDetailLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", 'ca_collections', $collection_id);
			print "</div>";
		}
?>
		</div>
<?php
		}
?>