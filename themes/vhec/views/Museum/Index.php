<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Museum Collections");
	
	$va_access_values = $this->getVar("access_values");
	$t_set = $this->getVar('featured_set');
	$qr_res = $this->getVar('featured_set_items_as_search_result');	
?>
<div class='container'>
<H1><?php print _t("Museum Collections"); ?></H1>
<div class='row'>

<?php	
	if ($qr_res) {
		while($qr_res->nextHit()) {		
			print "<div class='col-sm-3'>";
			print "<div class='featuredObj'>";
			print caNavLink($this->request, $qr_res->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$qr_res->get('ca_objects.object_id'));
			print "<span class='caption'>".$qr_res->get('ca_objects.preferred_labels').": </span>";
			print "<span>".$qr_res->get('ca_objects.description')."</span>";
			print "</div>";
			print "</div>";
		}
	}
?>
			
</div>	
<hr class='divide'>
<div class="row">
	<div class="col-sm-12">
		<h6>Featured Objects</h6>
		<p>
<?php				
		print $t_set->get('ca_sets.description');
?>					
		</p>


	</div>
</div>
<hr class='divide'>
<div class="row">
	<div class="col-sm-8">
		<h6>About the Museum Collection</h6>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		<p>Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
	</div>
	<div class="col-sm-4">
		<div class='highlight'>
			<h6>More Info</h6>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui.</p>
		</div>
	</div>
</div>

	

</div>