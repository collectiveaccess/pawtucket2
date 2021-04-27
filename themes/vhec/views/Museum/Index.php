<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Museum Collections");
	
	$va_access_values = caGetUserAccessValues($this->request);
	$t_set = $this->getVar('featured_set');
	$qr_res = $this->getVar('featured_set_items_as_search_result');	
	include_once(__CA_LIB_DIR__."/Search/SetSearch.php");
	#AssetLoadManager::register("cycle");
?>
<H1><?php print _t("Museum"); ?></H1>
<div class='row'>
	<div class='col-sm-6'>
<?php		
		if ($t_set && $va_description = $t_set->get('ca_sets.description')) {
			print "<p>".$va_description."</p>";
		}
		print caNavLink($this->request, 'About the Museum Collection <i class="fa fa-chevron-right"></i>', '', '', 'Museums', 'collection'); 
?>
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
					print "<div class='slide'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.large', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px')), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'));
					print "<div class='frontSlideCaption'>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'))."</div>";
					print "</div>";
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

?>


<?php	
	$vn_i = 0;
	if (sizeof($qr_sets) > 0) {
		while ($qr_sets->nextHit()) {
			$t_set = new ca_sets($qr_sets->get('ca_sets.set_id'));
			$va_featured_ids = array_keys($t_set->getItemRowIDs(array('checkAccess' => $va_access_values)));
			print '<div class="row featuredLanding">';
			print "<div class='col-sm-12'><h6>".$t_set->get('ca_sets.preferred_labels')."</h6></div>";
			foreach ($va_featured_ids as $vn_id => $va_featured_id) {
				$t_object = new ca_objects($va_featured_id);
				print "<div class='col-sm-3'><div class='featuredObj'>";
				print caNavLink($this->request, $t_object->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$va_featured_id);								
				print "<div class='caption'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_featured_id)."</div>";								
				print "<p>".$t_object->get('ca_objects.displayDate')."</p>";
				print "	</div></div>"; 			
			}
			print "</div><!--end row-->";
			$vn_i++;
			if ($vn_i != $qr_sets->numHits()) {
				print "<hr class='divide'>";
			}
		}	
	}

	

?>