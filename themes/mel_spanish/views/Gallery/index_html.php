<div class="row">
	<div class="col-sm-12 text-center">
		<H1><?php print caGetThemeGraphic($this->request, 'leaf_left_black.jpg', array("alt" => "leaf detail", "class" => "imgLeft")); ?><?php print $this->getVar("section_name"); ?><?php print caGetThemeGraphic($this->request, 'leaf_right_black.jpg', array("alt" => "leaf right detail", "class" => "imgRight")); ?></H1>	
	</div><!-- end col -->
</div><!-- end row -->
<?php
	$va_access_values = caGetUserAccessValues($this->request);;
	$va_sets = $this->getVar("sets");
	$t_set = new ca_sets();
	$va_first_items_from_set = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	if(is_array($va_sets) && sizeof($va_sets)){
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-8 col-md-offset-2 featuresList'>
					<div class="row">
						<div class='col-sm-12 col-md-10 col-md-offset-1'>
<?php
					$i = 0;
					foreach($va_sets as $vn_set_id => $va_set){
						$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);

						if($i == 0){
							print "<div class='row'>";
						}
						print caNavLink($this->request, "<div class='col-sm-4 featuresItem'>".$va_first_item["representation_tag"]."<br/>".$va_set["name"]."<p><small class='uppercase'>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</small></p>", "", "", "Gallery", $vn_set_id)."</div>";
						$i++;
						if($i == 3){
							print "</div>";
							$i = 0;
						} 
					}
					if($i > 0){
						print "</div>";
					}	
?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		
		
		

<?php
	}
?>

