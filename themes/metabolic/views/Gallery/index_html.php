<?php
	$t_set = new ca_sets();
	$va_access_values = caGetUserAccessValues();
?>
<div class="row galleryLanding"><div class="col-sm-12 offset-xl-1 col-xl-10">
	<H1><?php print $this->getVar("section_name"); ?></H1>
	
<?php
	$va_unsorted_sets = $this->getVar("sets");
	shuffle($va_unsorted_sets);
	$va_sets = array();
	foreach($va_unsorted_sets as $va_set){
		$va_sets[$va_set["set_id"]] = $va_set;
	}
	
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$va_first_items_from_set_iconlarge = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
	$va_first_items_from_set_widepreview = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
					
	if(is_array($va_sets) && sizeof($va_sets)){
		$i = 0;
?>
		<div class="row mb-5">
			<div class='col-md-6 offset-md-3'>
				<div class="row">
<?php
		foreach($va_sets as $vn_set_id => $va_set){
			$i++;
			$va_image_array = array();
			switch($i){
				case 1:
					print "<div class='col-md-8'>";
					$va_image_array = $va_first_items_from_set_iconlarge;
				break;
				# ----------------------------------
				case 2:
					print "<div class='col-md-3 offset-md-1'>";
					$va_image_array = $va_first_items_from_set_iconlarge;
				break;
				# ----------------------------------
				default:
					$va_image_array = $va_first_items_from_set_iconlarge;
				break;
				# ----------------------------------
			}
			$va_first_item = array_shift($va_image_array[$vn_set_id]);
?>
			<div class="card mb-5">
<?php
				print caNavLink($va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
?>
				<div class="card-body">
					<div class="card-title"><?php print caNavLink($va_set["name"], "", "", "Gallery", $vn_set_id); ?></div>
					<p class="card-text"><small class="text-muted"><?php print $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")); ?></small></p>
				</div>
			</div>
<?php
			if(in_array($i, array(1,3))){
				print "</div>";
			}
			unset($va_sets[$vn_set_id]);
			if($i == 3){
				break;
			}
		}
?>
  				</div>
  			</div>
  		</div>
		<div class="card-columns">
<?php
		foreach($va_sets as $vn_set_id => $va_set){
			$i++;
			$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
?>
			<div class="card mb-5">
<?php
    			print caNavLink($va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
?>
    			<div class="card-body">
      				<div class="card-title"><?php print caNavLink($va_set["name"], "", "", "Gallery", $vn_set_id); ?></div>
      				<p class="card-text"><small class="text-muted"><?php print $va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items")); ?></small></p>
      			</div>
  			</div>
<?php
		}
?>
		</div><!-- end card-columns -->
<?php
	}
?>
</div><!-- end col --></div><!-- end row -->