<?php
	$config = caGetGalleryConfig();
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
 	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	#if(is_array($va_sets) && sizeof($va_sets)){
	#	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
	#}
?>

<?php
	if($vs_intro_global_value = $config->get("gallery_intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='setDescription'>".$vs_tmp."</div>";
		}
	}
	if(is_array($va_sets) && sizeof($va_sets)){				
			$i = 0;
			print "<div class='galleryList'>";
			foreach($va_sets as $vn_set_id => $va_set){
				$t_set->load($vn_set_id);
				$vs_description = $t_set->get($config->get("gallery_set_description_element_code"));
				$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
				print "<div class='row'>";
				print "<div class='col-sm-4'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id)."</div>";
				print "<div class='col-sm-8'><label>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $vn_set_id)."</label><span class='trimText'>".$vs_description."</span></div>";
				print "</div><!-- end row -->";
				print "<div class='row'><div class='col-sm-12'><hr/></div></div>";
				
			}
			print "</div>";
	}
?>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 385
		});
	});
</script>