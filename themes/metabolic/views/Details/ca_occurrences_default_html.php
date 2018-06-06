<?php
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	

	$t_occurrence 			= $this->getVar('item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	$t_list = new ca_lists();
	$vn_silo_id = $t_list->getItemIDFromList('collection_types', 'silo');
	

if (!$this->request->isAjax()) {
?>
	<div id="detailBody" >
		<div id="pageNav">
			{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
		</div><!-- end nav -->
		<div class='recordTitle'><h1><?php print caUcFirstUTF8Safe($t_occurrence->getTypeName()).': '.$t_occurrence->get('ca_occurrences.preferred_labels'); ?></h1></div>
		<div id="rightCol" class="occurrence">	
<?php

			# --- identifier
			print "<h3>"._t("Identifier")."</h3><p>";
			print $t_occurrence->get('idno');
			print "</p>";
			if($va_alt_name = $t_occurrence->get('ca_occurrences.nonpreferred_labels')){
				print "<h3>"._t("Alternate Title")."</h3><p> ".$va_alt_name."</p>";
			}			
			if(($va_dates = $t_occurrence->get('ca_occurrences.date', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true)))&&(($this->getVar('typename') != 'Audio/Film/Video'))){
				if(sizeof($va_dates)){
					$va_dates_for_display = array();
					foreach($va_dates as $va_date){
						#print_r($va_date);
						if($va_date["dates_value"]){
							$va_dates_for_display[] = "<p>".$va_date["dates_value"]." <span class='details'>(".strtolower($va_date["dc_dates_types"]).")</span></p><!-- end unit -->";
						}
					}
					if(sizeof($va_dates_for_display)){
						print "<h3>"._t("Date%1", ((sizeof($va_dates) > 1) ? "s" : ""))."</h3>";
						print implode("\n", $va_dates_for_display);
					}
				}
			}
			if($va_links = $t_occurrence->get("ca_occurrences.external_link", array("returnWithStructure" => true))){
				$va_linksToOutput = array();
				foreach($va_links as $va_link){
					if($va_link['url_source']){
						$vs_link = "<a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_source']."</a>";
					}elseif($va_link['url_entry']){
						$vs_link = "<a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_entry']."</a>";
					}
					if($vs_link){
						$va_linksToOutput[] = $vs_link;
					}
				}
				if(sizeof($va_linksToOutput)){
					print "<h3>"._t("Link")."</h3><p>";
					print join("<br/>", $va_linksToOutput);
					print "</p>";
				}
			}			
			# --- description
				if($vs_description_text = $t_occurrence->get("ca_occurrences.description")){
					print "<h3>Description</h3><div id='description' class='scrollPane'><p>".$vs_description_text."</p></div>";				

				}

			# --- entities
			$va_entities = $t_occurrence->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<h3><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization")); ?></h3>
				<p>
<?php
				$vn_i = 1;
				foreach($va_entities as $va_entity) {
					print caNavLink($this->request, $va_entity["label"], '', '', 'Detail', 'entities/'.$va_entity["entity_id"])." <span class='details'>(".$va_entity['relationship_typename'].")</span>";
					if($vn_i < sizeof($va_entities)){
						print ", ";
					}
					$vn_i++;
				}
?>
				</p>
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_rel_entities = array();
					$va_rel_entities = $t_occ->get("ca_entities", array('restrictToTypes' => array('organization'), "returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
					$va_occurrence["related_entities"] = $va_rel_entities;
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				$t_list = new ca_lists();
				$vn_exhibition_type_id = $t_list->getItemIDFromList("occurrence_types", "exhibition");
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<h3><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h3>
				<div class='scrollPane'>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<p>".caNavLink($this->request, $va_info["label"], '', '', 'Detail', 'occurrences/'.$vn_rel_occurrence_id);
						if($vn_exhibition_type_id == $vn_occurrence_type_id){
							# --- this is an exhibition, so try to display organizations related to the exhibition
							$vn_i = 1;
							foreach($va_info['related_entities'] as $va_organization){
								print ", ".$va_organization["displayname"];
								if($vn_i < sizeof($va_info['related_entities'])){
									print ", ";
								}
								$vn_i++;
							}
						}
						print " <span class='details'>(".$va_info['relationship_typename'].")</span></p>";
					}
?>
				</div>
<?php					
				}
			}
			# --- places
			$va_places = $t_occurrence->get("ca_places", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<h3>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_places as $va_place_info){
					print "<p>".$va_place_info['label']." <span class='details'>(".$va_place_info['relationship_typename'].")</span></p>";
				}
?>
				</div>
<?php				
			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
// 				print "<h3>"._t("Related Project/Silo")."</h3><div class='scrollPane'>";
// 				foreach($va_collections as $va_collection_info){
// 					print "<p>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
// 				}
// 				print "</div>";

				print "<h3>"._t("Related Project/Silo").((sizeof($va_collections) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				$va_silos = array();
				$va_collection_links = array();
				$t_related_collection = new ca_collections();
				foreach($va_collections as $va_collection_info){
					if($va_collection_info["item_type_id"] != $vn_silo_id){
						# --- if the related collection is not a silo, check for a related silo to list it under
						$t_related_collection->load($va_collection_info['collection_id']);
						$va_related_silos = $t_related_collection->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('silo')));
						if(sizeof($va_related_silos)){
							foreach($va_related_silos as $va_related_silo){
								$va_silos[$va_related_silo["collection_id"]][] = $va_collection_info['collection_id'];
								$va_collection_links[$va_related_silo["collection_id"]] = caNavLink($this->request, $va_related_silo['label'], '', '', 'Detail', 'collections/'.$va_related_silo['collection_id']);						
							}
						}else{
							if(!$va_silos[$va_collection_info['collection_id']]){
								$va_silos[$va_collection_info['collection_id']] = array();
							}
						}
					}else{
						if(!$va_silos[$va_collection_info['collection_id']]){
							$va_silos[$va_collection_info['collection_id']] = array();
						}
					}
					$va_collection_links[$va_collection_info['collection_id']] = caNavLink($this->request, $va_collection_info['label'], '', '', 'Detail', 'collections/'.$va_collection_info['collection_id']);
					#print "<p> <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
				}
				if(sizeof($va_silos)){
					foreach($va_silos as $vn_silo_id => $va_projectsPhases){
						print "<p>".$va_collection_links[$vn_silo_id];
							$i = 0;
							if(sizeof($va_projectsPhases)){
								print " (";
							}
							foreach($va_projectsPhases as $vn_projectPhase_id){
								print "<span class='grayLink'>".$va_collection_links[$vn_projectPhase_id]."</spn>";
								$i++;
								if($i < sizeof($va_projectsPhases)){
									print ", ";
								}
							}
							if(sizeof($va_projectsPhases)){
								print ")";
							}
						print "</p>";
					}
				}
?>
				</div>
<?php
			}
			# --- vocabulary terms
			$va_terms = $t_occurrence->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<h3>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h3>";
?>
				<div class='scrollPane'>
<?php
				foreach($va_terms as $va_term_info){
					print "<p>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</p>";
				}
?>
				</div>
<?php				
			}
			# --- map
			if($t_occurrence->get('ca_occurrences.georeference.geocode')){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_occurrence, 'ca_occurrences.georeference.geocode');
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
				if($t_occurrence->get('ca_occurrences.georeference.geo_notes')) {
					print "<p><b>Location notes: </b>".$t_occurrence->get('ca_occurrences.georeference.geo_notes')."</p>";
				}
				if($t_occurrence->get('ca_occurrences.georeference.geo_date')) {
					print "<p><b>Location dates: </b>".$t_occurrence->get('ca_occurrences.georeference.geo_date')."</p>";
				}
			}

?>
	</div><!-- end rightCol -->
			
	<div id="leftCol">
		<div id="resultBox">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'occurrence_id' => $vn_occurrence_id
		));
		print $this->render('Details/related_objects_grid_carousel.php');
		#print $this->render('related_objects_grid.php');

if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->


	</div><!-- end leftCol -->
</div><!-- end detailBody -->

<?php
}
?>

	<script type="text/javascript">

		jQuery('.scrollPane').jScrollPane({
			
			animateScroll: true,
		});
	</script>