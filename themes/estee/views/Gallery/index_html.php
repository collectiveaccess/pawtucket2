<div class="row"><div class="col-sm-12 col-md-10 col-md-offset-1">
	<H1><?php print $this->getVar("section_name"); ?></H1>
	<p>{{{stories_intro}}}</p>
</div><!-- end col --></div><!-- end row -->

<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$t_set = new ca_sets();
	$va_set_first_items_media = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	$va_set_subtitle = $t_set->getAttributeFromSets("subtitle", array_keys($va_sets));
	if(is_array($va_sets) && sizeof($va_sets)){
		$i = 0;
		foreach($va_sets as $vn_set_id => $va_set){
			if($vn_featured_set_id == $vn_set_id){
				continue;
			}
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4 col-sm-offset-1'>
						<div class='row'>
							<div class='col-xs-9'>
								<div class='storyItem text-center'>";
			$t_set->load($vn_set_id);
			$va_set_media = $t_set->getRepresentationTags("iconlarge", array("checkAccess" => $va_access_values));
			if(is_array($va_set_media) && sizeof($va_set_media)){
				$va_set_media = array_slice($va_set_media, 1, 3);
			}
			#$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
			$va_first_item = array_shift($va_set_first_items_media[$vn_set_id]);
			$vs_rep = $va_first_item["representation_tag"];
			print caNavLink($this->request, $vs_rep, "", "", "Gallery", $vn_set_id);
			print "<div class='storyItemTitle'>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</div>";
			print "<div><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small></div>";
			if($va_tmp = $va_set_subtitle[$vn_set_id]){
				$vs_desc = "";
				$vs_desc = array_pop($va_tmp);
				print "<div>".((mb_strlen($vs_desc) > 160) ? substr(strip_tags($vs_desc), 0, 160)."..." : $vs_desc)."</div>";
			}
			print "</div><!-- storyItem --></div><div class='col-xs-3 storyItemThumbs'>";
			foreach($va_set_media as $vs_media){
				print $vs_media."<br/>";
			}
			print "</div></div><div class='col-sm-4'></div></div>";
			$i++;
			if($i == 3){
				print "</div>";
				$i = 0;
			}
		}
		if($i){
			print "</div>";
		}
	}
?>

