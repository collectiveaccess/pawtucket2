<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$t_set = new ca_sets($pn_set_id);
	
	
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	$vn_featured_home = caNavLink($this->request, 'Featured', '', '', 'Gallery', 'Index');
	$vn_set_title = $t_set->get('ca_sets.preferred_labels');
	MetaTagManager::setWindowTitle($va_home." > ".$vn_featured_home." > ".$vn_set_title);	
	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php
			print "<div class='entityThumb'>".$t_set->get('ca_sets.set_media', array('version' => 'medium'))."</div>";
?>		
		</div>
		<div class="content-wrapper">
			<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>	
<?php
					print "<h4>".$t_set->get('ca_sets.preferred_labels')."</h4>";	
					#print "<p>".$t_set->get('ca_sets.set_description')."</p>";
					print "<p>".$t_set->get('ca_sets.rich_description')."</p>";

					$va_set_items = array();
					foreach ($pa_set_items as $va_set_item_id => $pa_set_item) {
						if ($pa_set_item['entity_id']) {
							$t_entity = new ca_entities($pa_set_item['entity_id']);
							$va_entity_type = $t_entity->get('ca_entities.type_id', array('convertCodesToDisplayText' => true));
							$va_set_info = null;
							$va_set_info .= caNavLink($this->request, $t_entity->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$pa_set_item['entity_id']);
							$va_set_items[$va_entity_type][$pa_set_item['entity_id']] = $va_set_info;
						} else {
							$t_object = new ca_objects($pa_set_item['row_id']);
							$va_object_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
							$va_set_info = null;
							if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Bib') {
								$va_set_info .= caNavLink($this->request, "<div class='bookLabel'>".$t_object->get('ca_objects.preferred_labels')."</div>", '', '', 'Detail', 'objects/'.$pa_set_item['row_id']);
								$va_set_info .= $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author')));
								$va_set_info .= "<br/>".$t_object->get('ca_objects.publication_date');
							}
							if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Ledger' | $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Institutional Document' | $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Catalog'  | $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Page'){
								if ($t_object->get('ca_object_representations.media.widepreview')){
									$va_set_info.= caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$pa_set_item['row_id']);
								} else {
									$va_set_info.= caNavLink($this->request, "<div class='multisearchImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>", '', '', 'Detail', 'objects/'.$pa_set_item['row_id']);
								}
								$va_set_info .= caNavLink($this->request, $t_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$pa_set_item['row_id']);
							}
							$va_set_items[$va_object_type][$pa_set_item['row_id']] = $va_set_info;
						} 
					}
					foreach ($va_set_items as $va_item_type => $va_item_info) {
						if ($va_item_type == "Bib") {
							$va_type_label = "Books";
						} elseif ($va_item_type == "Ledger") {
							$va_type_label = "Ledgers";
						} elseif ($va_item_type == "Page") {
							$va_type_label = "Pages";
						} elseif ($va_item_type == "Catalog") {
							$va_type_label = "Catalogs";
						} elseif ($va_item_type == "Individual") {
							$va_type_label = "Individuals";
						} elseif ($va_item_type == "Organization") {
							$va_type_label = "Organizations";
						}
						print "<h3>".$va_type_label." <small>(".sizeof($va_item_info).")</small></h3>";;
						if ($va_item_type == "Bib") {
							$va_class = "class='bookButton'";
						} elseif ($va_item_type == "Individual" | $va_item_type == "Organization") {
							$va_class = "class='entityButton'";
						} else {
							$va_class = "class='thumbButton'";
						}
						print "<div class='row'>";

						foreach ($va_item_info as $va_item_id => $va_item_info_text) {
							if (($va_item_type == "Bib") | ($va_item_type == "Individual" ) | ($va_item_type == "Organization")) {
								print "<div class='col-sm-4 col-md-4 col-lg-4'>";
							}
							print "<div {$va_class}>".$va_item_info_text."</div>";
							if (($va_item_type == "Bib") | ($va_item_type == "Individual" ) | ($va_item_type == "Organization")) {
								print "</div>";
							}
						}
						print "</div>";
						
					}
?>										
					</div><!-- end col -->
				</div><!-- end row -->	</div><!-- end container -->
			</div><!-- end content-inner -->			
		</div><!-- end content-wrapper -->	
	</div><!-- end wrapper -->	
</div><!-- end page -->