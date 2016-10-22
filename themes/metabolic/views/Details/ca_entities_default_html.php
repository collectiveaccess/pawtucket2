<?php
	$t_entity = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	$vn_entity_id = $t_entity->get('ca_entities.entity_id');	

 	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
	
	# --- get all actions associated with the entity so can visualize in chronology timeline
 	AssetLoadManager::register('jcarousel');
 	$t_list = new ca_lists();
 	$vn_action_type_id = $t_list->getItemIDFromList('occurrence_types', 'action');
 	$vn_context_type_id = $t_list->getItemIDFromList('occurrence_types', 'context');

	$o_search = new OccurrenceSearch();
 	$o_search->setTypeRestrictions(array($vn_context_type_id, $vn_action_type_id));
 	#$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $va_access_values));
	$qr_res = $o_search->search("ca_entities.entity_id:{$vn_entity_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc', 'checkAccess' => $va_access_values));

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
				'label' => $qr_res->get('ca_occurrences.preferred_labels.name'),
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
<div id="detailBody">
	<div id="pageNav">
		{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
	</div><!-- end pageNav -->
	<div class='titleBar'>
		<div class='recordTitle'><h1><?php print $t_entity->get('ca_entities.preferred_labels') ?></h1></div>	
		<div class='idno'>
<?php
			if($t_entity->get('idno')){
				print "<b>"._t("Identifier").":</b> ".$t_entity->get('idno')."<!-- end unit -->";
			}
?>
		</div>	
	</div>	<!-- end titleBar -->
<?php
			$vn_rightColText = "";
			# --- identifier
			if ($va_biography = $t_entity->get('ca_entities.biography')) {
				$vn_rightColText .= "<div class='unit'><b>"._t("Biography").":</b> ".$va_biography."</div>";
			}	

			if ($va_jobTitle = $t_entity->get('ca_entities.jobTitle')) {
				$vn_rightColText .= "<div class='unit'><b>"._t("Job title").":</b> ".$va_jobTitle."</div>";
			}			

			# --- description
			if($vs_description_text = $t_entity->get("ca_entities.description")){
				$vn_rightColText .= "<h3>Description</h3><div id='description' class='scrollPane'><p> {$vs_description_text}</p></div>";				

			}				
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
				$vn_rightColText .= "<H3>"._t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization"))."</h3>";
				$vn_rightColText .= "<p>";
				$vn_i = 1;
				foreach($va_entities as $va_entity) {
					$vn_rightColText .= caNavLink($this->request, $va_entity["label"], '', '', 'Detail', 'entities/'.$va_entity["entity_id"])."  <span class='details'>(".$va_entity['relationship_typename'].")</span>";
					if($vn_i < sizeof($va_entities)){
						print ", ";
					}
					$vn_i++;
				}
				$vn_rightColText .= "</p>";
			}

			# --- occurrences
			$va_occurrences = $t_entity->get("ca_occurrences", array("restrictToTypes" => array("event", "exhibition"), "returnWithStructure" => 1, 'checkAccess' => $va_access_values));
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
					$vn_rightColText .= "<div class='scrollPane'>";
					$vn_rightColText .= "<h3>"._t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : "")."</h3>";
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						$vn_rightColText .= "<p>".caNavLink($this->request, $va_info["label"], '', '', 'Detail', 'occurrences/'.$vn_rel_occurrence_id);
						if($vn_exhibition_type_id == $vn_occurrence_type_id){
							# --- this is an exhibition, so try to display organizations related to the exhibition
							$vn_i = 1;
							foreach($va_info['related_entities'] as $va_organization){
								$vn_rightColText .= ", ".$va_organization["displayname"];
								if($vn_i < sizeof($va_info['related_entities'])){
									print ", ";
								}
								$vn_i++;
							}
						}
						$vn_rightColText .= " <span class='details'>(".$va_info['relationship_typename'].")</span></p>";
					}
					$vn_rightColText .= "</div>";
				}
			}
			# --- places
			$va_places = $t_entity->get("ca_places", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				$vn_rightColText .= "<h3>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h3>";
				$vn_rightColText .= "<div class='scrollPane'>";
				foreach($va_places as $va_place_info){
					$vn_rightColText .= "<p>".$va_place_info['label']." <span class='details'>(".$va_place_info['relationship_typename'].")</span></p>";
				}
				$vn_rightColText .= "</div>";				
			}
			# --- collections
			$va_collections = $t_entity->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
// 				$vn_rightColText .= "<h3>"._t("Related Project/Silo")."</h3>";
// 				$vn_rightColText .= "<div class='scrollPane'>";
// 				foreach($va_collections as $va_collection_info){
// 					$vn_rightColText .= "<p>";
// 					$vn_rightColText .= (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." <span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
// 				}
// 				$vn_rightColText .= "</div>";
				$vn_rightColText .= "<h3>"._t("Related Project/Silo").((sizeof($va_collections) > 1) ? "s" : "")."</h3>";
				$vn_rightColText .= "<div class='scrollPane'>";
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
								$va_collection_links[$va_related_silo["collection_id"]] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_related_silo['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_related_silo['collection_id'])) : $va_related_silo['label']);						
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
						$vn_rightColText .= "<p>".$va_collection_links[$vn_silo_id];
							$i = 0;
							if(sizeof($va_projectsPhases)){
								$vn_rightColText .= " (";
							}
							foreach($va_projectsPhases as $vn_projectPhase_id){
								$vn_rightColText .= "<span class='grayLink'>".$va_collection_links[$vn_projectPhase_id]."</span>";
								$i++;
								if($i < sizeof($va_projectsPhases)){
									$vn_rightColText .= ", ";
								}
							}
							if(sizeof($va_projectsPhases)){
								$vn_rightColText .= ")";
							}
						$vn_rightColText .= "</p>";
					}
				}
				$vn_rightColText .= "</div>";
			}
			# --- vocabulary terms
			$va_terms = $t_entity->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				$vn_rightColText .= "<h3>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h3>";
				$vn_rightColText .= "<div class='scrollPane'>";
				foreach($va_terms as $va_term_info){
					$vn_rightColText .= "<p>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</p>";
				}
				$vn_rightColText .= "</div>";				
			}			
			if($vn_rightColText){
				# --- only display right column if there is text to output.  This way the left col can expand to fit the full page if there is no text
				print "<div id='rightCol'>".$vn_rightColText."</div><!-- end rightCol -->";
			}						
?>
	<div id="leftCol"<?php print ($vn_rightColText) ? "" : " style='width:100%;'"; ?>>
		<div id="resultBox">
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	$this->setVar('columns', ($vn_rightColText) ? 4 : 6);
	print $this->render('Details/related_objects_grid_carousel.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
	</div><!-- end leftCol -->
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
							print caNavLink($this->request, "<div class='actionSiloIcon siloIcon".$va_silo_info["collection_id"]."' style='background-color:".$vs_bgColor."'><!-- empty --></div>", '', '', 'Detail', 'collections/'.$va_silo_info["collection_id"]);
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
			var entity_id = <?php print $vn_entity_id; ?>;
			for (var i = carousel.first; i <= (carousel.last + 6); i++) {
				// Check if the item already exists
				if (!carousel.has(i)) {
					jQuery.getJSON('<?php print caNavUrl($this->request, 'Chronology', 'Show', 'GetActionsEntity'); ?>', {entity_id: entity_id, s: i, n: 10}, function(actions) {
						jQuery.each(actions, function(k, v) {
							
							// clip label text if too long
							var label = v['label'];
							
							if(label.length > 125){
								label = label.substr(0, 122) + "...";
							}
							
							carousel.add(i, "<li><div class='action'><div class='actionDate'>" + v['date'] + "</div><div class='actionTitle'>" + label + "</div>" + v['silos_formatted'] + "<div class='actionMoreInfo'><a href='<?php print caNavUrl($this->request, 'Detail', 'Occurrence', 'Show'); ?>/occurrence_id/" + v['occurrence_id'] + "'><?php print _t("More Info"); ?> ></a></div></div></li>");	// format used when dynamically loading
							
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
	