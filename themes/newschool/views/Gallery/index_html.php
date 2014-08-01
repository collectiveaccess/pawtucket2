<div>
	<H1><?php print $this->getVar("section_name"); ?></H1>
<?php
	$o_config = caGetGalleryConfig();
	$va_access_values = caGetUserAccessValues($this->request);
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	print "<div class='container'>";	
	if(is_array($va_sets) && sizeof($va_sets)){
		$t_set = new ca_sets();
		foreach($va_sets as $vn_set_id => $va_set){
			$t_set->load($vn_set_id);
			print "<div class='row'>";
			print "<div class='col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3'><div class='galleryListItem'>";
			$va_first_item = array_shift(array_shift($t_set->getFirstItemsFromSets(array($vn_set_id), array("version" => "small", "checkAccess" => $va_access_values))));
			print "<div class='galleryListItemImg'>".$va_first_item["representation_tag"]."</div>";
			print "<H3>".$t_set->getLabelForDisplay()."</H3>";
			print "<p class='count'>".$t_set->getItemCount(array("checkAccess" => $va_access_values))." items</p>";
			if($vs_description = $t_set->get($o_config->get('gallery_set_description_element_code'))){
				print "<p><strong>".$vs_description."</strong></p>";
			}
			print caNavLink($this->request, "<span class='glyphicon glyphicon-th-large'></span>", "", "", "Gallery", $t_set->get("set_id"))."&nbsp;&nbsp;".caNavLink($this->request, "<strong>"._t("VIEW GALLERY")."</strong>", "", "", "Gallery", $t_set->get("set_id"));
			print "<div style='clear:both;'></div></div></div></div>\n";
		}
	}
	print "</div>";
?>
</div>