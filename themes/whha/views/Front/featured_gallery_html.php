<?php
	# --- which type of set is configured for display in gallery section
 	$va_access_values = $this->getVar("access_values");
	$o_config = caGetGalleryConfig();
	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_entities");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$o_front_config = caGetFrontConfig();
		foreach($va_sets as $vn_set_id => $va_set) {
			$t_set->load($vn_set_id);
			if($t_set->get("ca_sets.featured", array("convertCodesToDisplayText" => true)) == "Yes"){
			
			}else{
				unset($va_sets[$vn_set_id]); 
			}
		}
		shuffle($va_sets);
		$va_sets = array_slice($va_sets, 0, 1, true);
	}


	if(is_array($va_sets) && sizeof($va_sets)){
?>

	<div class="container-fluid double-border bg-body-tertiary pt-5 pb-5">
		<div class="row">
			<div class="col">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-12 col-md-10"> 
							<div class="row">
	<?php
								$va_set = $va_sets[0];
								$vn_set_id = $va_set["set_id"];
								$va_set_first_items = $t_set->getPrimaryItemsFromSets(array($vn_set_id), array("version" => "large", "checkAccess" => $va_access_values));
								$t_set->load($vn_set_id);
								$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
								if($va_first_item["representation_tag"]){
									print "<div class='col-sm-3 img-fluid'>".caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id)."</div>";
									print "<div class='col-sm-9'>";
								}else{
									print "<div class='col-sm-12'>";
								}
								print caNavLink($this->request, $va_set["name"], "fs-3 fw-medium", "", "Gallery", $vn_set_id);
								if($vs_desc = $t_set->get("ca_sets.set_description")){
									if(mb_strlen($vs_desc) > 400){
										$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
									}
									print "<div class='py-2 fs-3'>".$vs_desc."</div>";
								}
								print "<div class='text-center py-2'>".caNavLink($this->request, "View All Collections".ucwords($gallery_plural_name)." <i class='bi bi-arrow-right'></i>", "btn btn-primary", "", "Gallery", "Index")."</div>";
								print "</div>";
								
	?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
			
				
<?php
	}
?>