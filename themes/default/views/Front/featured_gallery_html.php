<?php
	# --- which type of set is configured for display in gallery section
 	
	$o_config = caGetGalleryConfig();
	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
		}
		shuffle($va_sets);
		$va_sets = array_slice($va_sets, 0, 1, true);
	}


	if(is_array($va_sets) && sizeof($va_sets)){
		# --- what is the gallery section called
		if(!$section_name = $o_config->get('gallery_section_name_home_page')){
			$section_name = _t("Featured Galleries");
		}
		if(!$gallery_plural_name = $o_config->get('gallery_section_item_plural')){
			$gallery_plural_name = _t("Galleries");
		}
		
?>

	<div class="container-fluid bg-body-tertiary pt-5 pb-5">
		<div class="row">
			<div class="col">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-12 col-md-10"> 
							<H2><?php print $section_name; ?></H2>
							<div class="row">
	<?php
								$va_set = $va_sets[0];
								$vn_set_id = $va_set["set_id"];
								$va_set_first_items = $t_set->getPrimaryItemsFromSets(array($vn_set_id), array("version" => "large", "checkAccess" => $va_access_values));
								$t_set->load($vn_set_id);
								$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
								print "<div class='col-sm-6 img-fluid'>".caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id)."</div>";
								print "<div class='col-sm-6'>".caNavLink($this->request, $va_set["name"], "fs-4 fw-medium", "", "Gallery", $vn_set_id);
								if($vs_desc = $t_set->get("ca_sets.set_description")){
									if(mb_strlen($vs_desc) > 400){
										$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
									}
									print "<div class='py-2 fs-4'>".$vs_desc."</div>";
								}
								print "<div class='text-center py-2'>".caNavLink($this->request, "View All ".ucwords($gallery_plural_name)." <i class='bi bi-arrow-right'></i>", "btn btn-primary", "", "Gallery", "Index")."</div>";
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