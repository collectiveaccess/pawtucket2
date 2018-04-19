<?php
	$t_collection = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	
	$vn_collection_id 		= $t_collection->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	$t_list = new ca_lists();
	$vn_silo_id = $t_list->getItemIDFromList('collection_types', 'silo');

 	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
	
	# --- get all actions associated with the collection so can visualize in chronology timeline
 	AssetLoadManager::register('jcarousel');
 	$t_list = new ca_lists();
 	$vn_action_type_id = $t_list->getItemIDFromList('occurrence_types', 'action');
 	$vn_context_type_id = $t_list->getItemIDFromList('occurrence_types', 'context');

	$o_search = new OccurrenceSearch();
 	$o_search->setTypeRestrictions(array($vn_context_type_id, $vn_action_type_id));
 	$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $va_access_values));
	$qr_res = $o_search->search("ca_collections.collection_id:{$vn_collection_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));

	$va_actions = array();
	$va_action_map = array();	
	if($qr_res->numHits() > 0){
		$t_occ = new ca_occurrences();
		$i = 0;
		while($qr_res->nextHit()) { // && $i <= 25) {		// limit to 25 when ajax loading is reinstated
			$va_silos = array();
			$va_projects = array();
			$t_occ->load($qr_res->get('ca_occurrences.occurrence_id'));
			$va_silos = $t_occ->get("ca_collections", array("restrictToTypes" => array("silo"), "returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			$va_projects = $t_occ->get("ca_collections", array("restrictToTypes" => array("project"), "returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited', 'timeOmit' => true))))) { continue; }
			if ($vs_date == 'present') { continue; }
			$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnWithStructure' => true)));
			$va_actions[$vn_id = $qr_res->get('ca_occurrences.occurrence_id')] = array(
				'occurrence_id' => $vn_id,
				'label' => $qr_res->get('ca_occurrences.preferred_labels.name', ['returnAsLink' => true]),
				'idno' => $qr_res->get('ca_occurrences.idno'),
				'date' => $vs_date,
				'timestamp' => $va_timestamps['start'],
				'location' => $qr_res->get('ca_occurrences.georeference.geocode'),
				'silos' => $va_silos,
				'projects' => $va_projects
			);
			$i++;
		}
		$qr_res->seek(0);
		while($qr_res->nextHit()) {
			if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
			if ($vs_date == 'present') { continue; }
			$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnWithStructure' => true)));
			$va_action_map[] = array(
				'timestamp' => $va_timestamps['start'],
				'date' => $vs_date,
				'id' => $vn_id
			);
		}
		$vn_num_actions = sizeof($va_action_map);
	}

if (!$this->request->isAjax()) {
?>
	<div id="detailBody" class="collection">
		<div id="pageNav">
			{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
		</div><!-- end nav -->
		<div class='titleBar'>
			<div class='recordTitle'><h1><?php print $vs_title; ?></h1></div>

		</div>
		<div style='clear:both;height:1px;'></div>
		<div id="rightCol">	
<?php
			print "<h3>"._t("Identifier")."</h3><p>";
			print $t_collection->get('idno');
			print "</p>";
			print "<h3>Type</h3><p>".caUcFirstUTF8Safe($t_collection->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)))."</p>";
			if($va_alt_name = $t_collection->get('ca_collections.nonpreferred_labels')){
				print "<h3>"._t("Alternate title")."</h3><p> ".$va_alt_name."</p><!-- end unit -->";
			}
			if($va_date = $t_collection->get('ca_collections.spanDates')){
				print "<h3>"._t("Date")."</h3><p> ".$va_date."</p><!-- end unit -->";
			}			

			# --- description
			if($vs_description_text = $t_collection->get("ca_collections.description")){
				print "<h3>Description</h3><div id='description' class='scrollPane'><p>{$vs_description_text}</p></div><!-- end unit -->";				

			}
			
			# --- entities
			$va_entities = $t_collection->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<h3><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization")); ?></h3>
				<p>
<?php
				$vn_i = 1;
				foreach($va_entities as $va_entity) {
					print caNavLink($this->request, $va_entity["label"], '', '', 'Detail', 'entities/'.$va_entity["entity_id"])." <span class='details'>(".$va_entity['relationship_typename'].")</span>\n";
					if($vn_i < sizeof($va_entities)){
						print ", ";
					}
					$vn_i++;
				}
?>
				</p>
<?php
			}
?>
			
<?php			
			# --- occurrences
			$va_occurrences = $t_collection->get("ca_occurrences", array("restrictToTypes" => array("event", "exhibition"), "returnWithStructure" => 1, 'checkAccess' => $va_access_values));
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
						print "<p style='margin-bottom:5px;'>".caNavLink($this->request, $va_info["label"], '', '', 'Detail', 'occurrences/'.$vn_rel_occurrence_id);
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
					print "</div>";
				}
			}
?>
			
<?php
			# --- places
			$va_places = $t_collection->get("ca_places", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
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
			$va_collections = $t_collection->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				// print "<h3>"._t("Related Project/Silo")."</h3>";
// 				print "<div class='scrollPane'>";
// 				foreach($va_collections as $va_collection_info){
// 					print "<p>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
// 					print " <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
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
					#print "<p> <span class='details'> (".$va_collection_info['relationship_typename'].")</span></p>";
				}
				if(sizeof($va_silos)){
					foreach($va_silos as $vn_silo_id => $va_projectsPhases){
						print "<p>".$va_collection_links[$vn_silo_id];
							$i = 0;
							if(sizeof($va_projectsPhases)){
								print " (";
							}
							foreach($va_projectsPhases as $vn_projectPhase_id){
								print "<span class='grayLink'>".$va_collection_links[$vn_projectPhase_id]."</span>";
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
			$va_terms = $t_collection->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<h3>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h3>";
				foreach($va_terms as $va_term_info){
					print "<p>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['name_singular']))."</p>";
				}
			}		
			
?>
		</div>

			
	<div id="leftCol">
		<div id="resultBox">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'collection_id' => $vn_collection_id
		));
		$qr_res = $t_collection->get('ca_objects', array('returnAsSearchResult' => true));
		$this->setVar('browse_results', $qr_res);
		print $this->render('Details/related_objects_grid_carousel.php');
		#print $this->render('related_objects_grid.php');
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
	</div><!-- end leftColCollection -->		
<?php
	if(sizeof($va_actions)){
?>		
				<H3 style="clear:both;padding-bottom:15px;"><?php print _t("Related Action%1", ($vn_num_actions > 1) ? "s" : ""); ?></H3><div class="jcarousel-wrapper"><div class="jcarousel" id="actionTimeline"><ul>
<?php
				$t_object = new ca_objects();
				$va_siloIconToolTips = array();
				foreach($va_actions as $vn_action_id => $va_action) {
					$vs_label = $va_action['label'];
					if(strlen($va_action['label']) > 125){
						$vs_label = substr($va_action['label'], 0, 122)."...";
					}
					print "<li><div class='action'><div class='actionDate'>".$va_action['date']."</div><div class='actionTitle'>".$vs_label."</div>";
					if(is_array($va_action["silos"]) && sizeof($va_action["silos"]) > 0){
						print "<div class='actionSiloIcons'>";
						foreach($va_action["silos"] as $vn_i => $va_silo_info){
						
							$vs_bgColor = "";
							switch($va_silo_info["collection_id"]){
								case $this->request->config->get('silo_strawberry_flag'):
									$vs_bgColor = $this->request->config->get('silo_strawberry_flag_bg');
									break;
								# --------------------------------------
								case $this->request->config->get('silo_silver_water'):
									$vs_bgColor = $this->request->config->get('silo_silver_water_bg');
									break;
								# --------------------------------------
								default:
									$vs_bgColor = "#000000";
									break;
							}
							print caNavLink($this->request, "<div class='actionSiloIcon siloIcon".$va_silo_info["collection_id"]."' style='background-color:".$vs_bgColor."'><!-- empty --></div>", '', '', 'Detail', 'collections/'.$va_silo_info["collection_id"], array("title" => $va_silo_info["label"]));
						}
						print "</div>";
					}
					print "<div class='actionMoreInfo'>".caNavLink($this->request, _t("More Info >"), '', '', 'Detail', 'occurrences/'.$va_action["occurrence_id"])."</div></div></li>\n"; // format used on load only
				}
?>
				</ul>
			</div><!-- end timelineContainer --></div>	
<?php
				if($vn_num_actions > 5){
?>
				<div class="sliderContainer">
					<div class="slider" id="slider" style="position: relative;">
						<div id="sliderPosInfo" class="sliderInfo"></div>
					</div><!-- end slider -->
				</div><!-- end sliderContainer -->
<?php
				}
?>			
			<div style="clear:both;"><!-- empty --></div>	
<?php
	}
?>	
	
</div><!-- end detailBody -->
<?php
}
?>
<script type="text/javascript">
	jQuery('.scrollPane').jScrollPane({	animateScroll: true });
</script>		
	
<?php
	if(sizeof($va_actions)){
?>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#actionTimeline').jcarousel({size: <?php print (int)$vn_num_actions; ?>});
			jQuery('#actionTimeline').data('actionmap', <?php print json_encode($va_action_map); ?>);
			var actionmap = jQuery('#actionTimeline').data('actionmap');
<?php
			if($vn_num_actions > 5){
?>
			jQuery('#sliderPosInfo').html(actionmap[0]['date']);
			jQuery('#slider').slider({min:1, max:<?php print ($vn_num_actions - 5); ?>, animate: 'fast', 
				start: function(event, ui) {
					jQuery('#sliderPosInfo').css('display', 'block');
				},
				slide: function(event, ui) {
					var actionmap = jQuery('#actionTimeline').data('actionmap');
					setTimeout(function() {
						jQuery('#sliderPosInfo').css('left', jQuery(ui.handle).position().left + 15 + "px").html(actionmap[ui.value]['date']);
					}, 10);
				},
				stop: function(event, ui) { 
					console.log(ui, ui.value);
					jQuery('#sliderPosInfo').css('display', 'none');
					jQuery('#actionTimeline').jcarousel('scroll', ui.value);
				}
			});
<?php
			}
?>
			$('#actionTimeline').on('jcarousel:scrollend', function(event, carousel) {
				//console.log("scroll", event, carousel, carousel.items(), jQuery(carousel.items()).index(carousel.last()));
				
				// TODO: call ajax load here
			});
		});	
			
		// TODO: fix to do proper ajax load with jCarousel 0.3
		// (this is 0.2 code)
		function loadActions(carousel, state) {
			var collection_id = <?php print (int)$vn_collection_id; ?>;
			for (var i = carousel.first; i <= (carousel.last + 6); i++) {
				// Check if the item already exists
				if (!carousel.has(i)) {
					jQuery.getJSON('<?php print caNavUrl($this->request, 'Chronology', 'Show', 'GetActionsCollection'); ?>', {collection_id: collection_id, s: i, n: 10}, function(actions) {
						jQuery.each(actions, function(k, v) {
							
							// clip label text if too long
							var label = v['label'];
							
							if(label.length > 125){
								label = label.substr(0, 122) + "...";
							}
							
							carousel.add(i, "<li><div class='action'><div class='actionDate'>" + v['date'] + "</div><div class='actionTitle'>" + label + "</div>" + v['silos_formatted'] + "<div class='actionMoreInfo'><a href='<?php print caNavUrl($this->request, '', 'Detail', 'occurrences'); ?>/occurrence_id/" + v['occurrence_id'] + "'><?php print _t("More Info"); ?> ></a></div></div></li>");	// format used when dynamically loading
							
							i++;
						});
					});
					
					break;
				}
			}
			
			// Update slider with current position
			jQuery('#slider').slider("value", carousel.first);
			
		}		
		
	</script>
<?php
	}
?>

