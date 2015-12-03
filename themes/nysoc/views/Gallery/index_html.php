<div>
<?php

 	$t_set = new ca_sets();
  	$t_list = new ca_lists();
 	$this->config = caGetGalleryConfig();

 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $this->config->get('gallery_set_type')); 			

	$va_sets = $this->getVar("sets");
	$va_entity_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_entities', 'checkAccess' => $this->opa_access_values, 'setType' => $vn_gallery_set_type_id)));

	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > Featured");	

	
	foreach ($va_entity_sets as $va_entity_set) {
		$va_sets[] = $va_entity_set;
	}

	$va_first_items_from_set = $this->getVar("first_items_from_sets");

	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'viz_sidebar.jpg'), '', '', 'About', 'visualizations');
?>		
		</div><!-- end sideBar -->
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
				<h4>Featured Content</h4>
<?php
					if(sizeof($va_sets) > 1){
						foreach($va_sets as $vn_set_id => $va_set){
							$t_set = new ca_sets($va_set['set_id']);

							print "<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>";
							print "<div class='galleryItem'>
										<div class='galleryItemImg'>".caNavLink($this->request, $t_set->get('ca_sets.set_media', array('version' => 'largeicon')), '', '', 'Gallery', $va_set['set_id'])."</div>
										<div class='galleryItemText'><h5>".caNavLink($this->request, $va_set["name"], '', '', 'Gallery', $va_set['set_id'])."</h5>";
											#<p>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</p>";
											print $t_set->get('ca_sets.set_description');
							print		"</div>
										<div style='clear:both;'><!-- empty --></div>
									</div>\n";
							print "</div><!-- end col-6 -->";

						}
					}
?>
			</div><!-- end row --></div><!-- end container -->
			</div><!-- end content-inner -->
		</div><!-- end content-wrapper -->
	</div><!-- end wrapper -->
</div><!-- end page -->	
		<script type='text/javascript'>
			jQuery(document).ready(function() {		
				jQuery("#gallerySetInfo").load("<?php print caNavUrl($this->request, '*', 'Gallery', 'getSetInfo', array('set_id' => $vn_first_set_id)); ?>");
			});
		</script>
<?php
	}
?>
</div>