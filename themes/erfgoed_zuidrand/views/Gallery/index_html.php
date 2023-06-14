<?php
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	}
?>

<div class="row"><div class="col-sm-12 col-md-8 col-md-offset-2">
	<H1><?php print $this->getVar("section_name"); ?></H1>
	<div class="galleryIntro">{{{expos_intro}}}</div>
<?php
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax				
			$i = 0;
			foreach($va_sets as $vn_set_id => $va_set){
				$i++;
				if($i == 1){
					print "<div class='row'>";
				}
				print "<div class='col-xs-6 col-sm-3'>";
				$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
				print "<div class='galleryList'>".caNavLink($this->request, $va_first_item["representation_tag"], '', '', 'Gallery', $vn_set_id).caNavLink($this->request, $va_set["name"]."<br/><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small>", 'labelLink', '', 'Gallery', $vn_set_id)."
						</div>\n";
				print "</div><!-- end col -->";
				if($i == 4){
					print "</div><!-- end row -->";
					$i = 0;
				}
			}
			if($i){
				print "</div><!-- end row -->";
			}
	}
?>
</div><!-- end col --></div><!-- end row -->