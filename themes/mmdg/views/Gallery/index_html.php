<?php
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues($this->request);
 	$va_sets = $this->getVar("sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "medium", "checkAccess" => $va_access_values));
	}
?>

	<H1><?php print $this->getVar("section_name"); ?></H1>
		<div class="galleryIntro">{{{exhibits_intro}}}</div>
				<div class="row galleryGrid">
<?php
					$i = 0;
					foreach($va_sets as $vn_set_id => $va_set){
						$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
						print "<div class='col-sm-12 col-md-4'>";
						print caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
						if($va_set["name"]){
							print "<div class='galleryGridText'>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</div>"; 
						}
						print "</div>";
						$vb_item_output = 1;
						$i++;
						if($i == 6){
							break;
						}
					}
?>
				</div>
