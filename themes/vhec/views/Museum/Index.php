<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Museum Collections");
	
	$va_access_values = caGetUserAccessValues($this->request);
	$t_set = $this->getVar('featured_set');
	$qr_res = $this->getVar('featured_set_items_as_search_result');	
	include_once(__CA_LIB_DIR__."/ca/Search/SetSearch.php");
	#AssetLoadManager::register("cycle");
?>
<div class='container'>
<H1><?php print _t("Museum Collections"); ?></H1>
<div class='row'>
	<div class='col-sm-6'>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		<p>Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>	
		<?php print caNavLink($this->request, 'About the Museum Collection <i class="fa fa-chevron-right"></i>', '', '', 'About', 'Index'); ?>
	</div>
	<div class='col-sm-6 spotlight'>
		<div class="cycle-prev" id="prev"><i class="fa fa-angle-left"></i></div>
    	<div class="cycle-next" id="next"><i class="fa fa-angle-right"></i></div>
		<div class="cycle-slideshow" 
			data-cycle-fx=scrollHorz
			data-cycle-timeout=0
			data-cycle-pager=".example-pager"
			data-cycle-slides="> div"
			data-cycle-prev="#prev"
        	data-cycle-next="#next"
			>


<?php	
			if ($qr_res) {
				while($qr_res->nextHit()) {		
					print "<div class='slide'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.medium'), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'))."</div>";
				}
			}
?>

			</div>
		<div class="example-pager"></div>
	</div>

				
</div>	
<hr class='divide'>
<?php
	$o_set_search = new SetSearch();
	$qr_sets = $o_set_search->search("ca_sets.homepage_displays:'Museum Homepage'", array("checkAccess" => $va_access_values));
	while($qr_sets->nextHit()) {
		if ($qr_sets->get('ca_sets.lightbox_cats', array('convertCodesToDisplayText' => true)) == "In Focus") {
			$va_in_focus[] = $qr_sets->get('ca_sets.set_id');
		} 
		if ($qr_sets->get('ca_sets.lightbox_cats', array('convertCodesToDisplayText' => true)) == "Thematic Guide") {
			$va_thematic[] = $qr_sets->get('ca_sets.set_id');
		} 
		if ($qr_sets->get('ca_sets.lightbox_cats', array('convertCodesToDisplayText' => true)) == "Timeline") {
			$va_timeline[] = $qr_sets->get('ca_sets.set_id');
		}
	}
?>
<div class="row">

<?php	
	if (sizeof($va_timeline) > 0) {
		$va_timeline_first_items = $t_set->getPrimaryItemsFromSets($va_thematic, array("version" => "iconlarge", "checkAccess" => $va_access_values));

		print "<div class='col-sm-4'>
			<div class='featuredObj'>
				<h6>Timeline</h6>";
				foreach ($va_timeline_first_items as $va_timeline_set_id => $va_timeline_first_item_t) {
					foreach ($va_timeline_first_item_t as $va_key => $va_timeline_first_item) {
						print caNavLink($this->request, $va_timeline_first_item['representation_tag'], '', '', 'Gallery', $va_timeline_set_id);
					}
					break;
				}
		print "	</div>
		</div>";
	}
	if (sizeof($va_in_focus) > 0) {
		
		$va_set_first_items = $t_set->getPrimaryItemsFromSets($va_in_focus, array("version" => "iconlarge", "checkAccess" => $va_access_values));

		print "<div class='col-sm-4'>
			<div class='featuredObj'>
				<h6>In Focus</h6>";
				foreach ($va_set_first_items as $va_set_id => $va_set_first_item_t) {
					foreach ($va_set_first_item_t as $va_key => $va_set_first_item) {
						print caNavLink($this->request, $va_set_first_item['representation_tag'], '', '', 'Gallery', $va_set_id);
					}
					break;
				}
		print "	</div>
		</div>";
	}
	
	if (sizeof($va_thematic) > 0) {
		$va_thematic_first_items = $t_set->getPrimaryItemsFromSets($va_thematic, array("version" => "iconlarge", "checkAccess" => $va_access_values));

		print "<div class='col-sm-4'>
			<div class='featuredObj'>
				<h6>Thematic Guide</h6>";
				foreach ($va_thematic_first_items as $va_thematic_set_id => $va_thematic_first_item_t) {
					foreach ($va_thematic_first_item_t as $va_key => $va_thematic_first_item) {
						print caNavLink($this->request, $va_thematic_first_item['representation_tag'], '', '', 'Gallery', $va_thematic_set_id);
					}
					break;
				}
		print "	</div>
		</div>";
	}
?>			

</div>

	

</div>