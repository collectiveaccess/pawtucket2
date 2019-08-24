<div class="tab-pane active" id="featured" role="tabpanel" aria-labelledby="featured-tab">
<?php
	$va_access_values = caGetUserAccessValues();
	$o_config = caGetFrontConfig();
	
	if($vs_set_code = $o_config->get("front_page_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		$vn_shuffle = 0;
		if($o_config->get("front_page_set_random")){
			$vn_shuffle = 1;
		}
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			if(is_array($va_featured_ids) && sizeof($va_featured_ids)){
				$q_featured_exhibitions = caMakeSearchResult('ca_occurrences', $va_featured_ids);
				if($q_featured_exhibitions && $q_featured_exhibitions->numHits()){
					$i = $vn_col = 0;
					while($q_featured_exhibitions->nextHit()){
						if($vn_col == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4 col-xs-6'>".$q_featured_exhibitions->getWithTemplate("<unit relativeTo='ca_occurrences'><l><ifcount code='ca_objects' min='1'><unit relativeTo='ca_objects' length='1'><ifcount code='ca_object_representations' min='1'>^ca_object_representations.media.large%length=1</ifcount></unit></ifcount></l></unit>");
						print "<div class='masonry-title'>".$q_featured_exhibitions->getWithTemplate("<l>^ca_occurrences.preferred_labels.name</l>")."</div>";
						print "</div>";
						$vb_item_output = true;
						$i++;
						$vn_col++;
						if($vn_col == 3){
							print "</div>";
							$vn_col = 0;
						}
					}
					if($vn_col > 0){
						print "</div><!-- end handing rows -->";
					}
					
				}
			}
		}
	}
?>
</div>
