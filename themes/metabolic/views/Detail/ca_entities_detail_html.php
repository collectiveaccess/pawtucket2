<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	
 	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
	
	# --- get all actions associated with the entity so can visualize in chronology timeline
 	JavascriptLoadManager::register('jcarousel');
 	$t_list = new ca_lists();
 	$vn_action_type_id = $t_list->getItemIDFromList('occurrence_types', 'action');
 	$vn_context_type_id = $t_list->getItemIDFromList('occurrence_types', 'context');

	$o_search = new OccurrenceSearch();
 	$o_search->setTypeRestrictions(array($vn_context_type_id, $vn_action_type_id));
 	$o_search->addResultFilter("ca_occurrences.access", "IN", join(',', $va_access_values));
	$qr_res = $o_search->search("ca_entities.entity_id:{$vn_entity_id}", array('sort' => 'ca_occurrences.date.dates_value', 'sort_direction' => 'asc'));

	$va_actions = array();
	$va_action_map = array();	
	if($qr_res->numHits() > 0){
		$t_occ = new ca_occurrences();
		$i = 0;
		while($qr_res->nextHit() && $i <= 25) {
			$va_silos = array();
			$va_projects = array();
			$t_occ->load($qr_res->get('ca_occurrences.occurrence_id'));
			$va_silos = $t_occ->get("ca_collections", array("restrictToTypes" => array("silo"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_projects = $t_occ->get("ca_collections", array("restrictToTypes" => array("project"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (!($vs_date = trim($qr_res->get('ca_occurrences.date.dates_value', array('dateFormat' => 'delimited'))))) { continue; }
			if ($vs_date == 'present') { continue; }
			$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
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
			$va_timestamps = array_shift($qr_res->get('ca_occurrences.date.dates_value', array('rawDate' => true, 'returnAsArray' => true)));
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
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<div class='titleBar'><div class='recordTitle'><h1><?php print $vs_title; ?></h1></div>	
			<div class='idno'>
<?php
			if($t_entity->get('idno')){
				print "<b>"._t("Identifier").":</b> ".$t_entity->get('idno')."<!-- end unit -->";
			}
?>
			</div>		
		</div>
<?php
			$vn_rightColText = "";
			# --- identifier
			if ($va_biography = $t_entity->get('ca_entities.biography')) {
				$vn_rightColText .= "<div class='unit'><b>"._t("Biography").":</b> ".$va_biography."</div>";
			}	

			if ($va_jobTitle = $t_entity->get('ca_entities.jobTitle')) {
				$vn_rightColText .= "<div class='unit'><b>"._t("Job title").":</b> ".$va_jobTitle."</div>";
			}			
			# --- attributes
			$va_attributes = $this->request->config->get('ca_entities_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_entity->get("ca_entities.{$vs_attribute_code}")){
						$vn_rightColText .= "<div class='unit'><b>".$t_entity->getDisplayLabel("ca_entities.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_entities_description_attribute')){
				if($vs_description_text = $t_entity->get("ca_entities.".$this->request->config->get('ca_entities_description_attribute'))){
					$vn_rightColText .= "<h3>".$t_entity->getDisplayLabel('ca_entities.'.$this->request->config->get('ca_entities_description_attribute'))."</h3><div id='description' class='scrollPane'><p> {$vs_description_text}</p></div>";				

				}
			}	
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
				$vn_rightColText .= "<H3>"._t("Related")." ".((sizeof($va_entities) > 1) ? _t("People/Organizations") : _t("Person/Organization"))."</h3>";
				$vn_rightColText .= "<div class='scrollPane'>";
				foreach($va_entities as $va_entity) {
					$vn_rightColText .= "<p>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." <br/><span class='details'>(".$va_entity['relationship_typename'].")</span></p>";		
				}
				$vn_rightColText .= "</div>";
			}

			# --- occurrences
			$va_occurrences = $t_entity->get("ca_occurrences", array("restrictToTypes" => array("event", "exhibition"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
					$vn_rightColText .= "<div class='scrollPane'>";
					$vn_rightColText .= "<h3>"._t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : "")."</h3>";
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						$vn_rightColText .= "<p>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." <br/><span class='details'>(".$va_info['relationship_typename'].")</span></p>";
					}
					$vn_rightColText .= "</div>";
				}
			}
			# --- places
			$va_places = $t_entity->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				$vn_rightColText .= "<h3>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h3>";
				$vn_rightColText .= "<div class='scrollPane'>";
				foreach($va_places as $va_place_info){
					$vn_rightColText .= "<p>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." <br/><span class='details'>(".$va_place_info['relationship_typename'].")</span></p>";
				}
				$vn_rightColText .= "</div>";				
			}
			# --- collections
			$va_collections = $t_entity->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
// 				$vn_rightColText .= "<h3>"._t("Related Project/Silo")."</h3>";
// 				$vn_rightColText .= "<div class='scrollPane'>";
// 				foreach($va_collections as $va_collection_info){
// 					$vn_rightColText .= "<p>";
// 					$vn_rightColText .= (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." <br/><span class='details'>(".$va_collection_info['relationship_typename'].")</span></p>";
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
						$va_related_silos = $t_related_collection->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('silo')));
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
					$va_collection_links[$va_collection_info['collection_id']] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
					#print "<p>".."<br/><span class='details'> (".$va_collection_info['relationship_typename'].")</span></p>";
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
			$va_terms = $t_entity->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
	print $this->render('related_objects_grid_carousel.php');
	#print $this->render('related_objects_grid.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
	</div><!-- end leftColEntity -->

	
	
	
	
	
	
	
	
	
	
	
	
	
<?php
	if(sizeof($va_actions)){
?>		
				<H3 style="clear:both;"><?php print _t("Related Action%1", ($vn_num_actions > 1) ? "s" : ""); ?></H3><div class="timelineContainer"><ul id="actionTimeline" class="jcarousel-skin-chronology">
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
							print caNavLink($this->request, "<div class='actionSiloIcon siloIcon".$va_silo_info["collection_id"]."' style='background-color:".$vs_bgColor."'><!-- empty --></div>", '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_silo_info["collection_id"]), array("title" => $va_silo_info["label"]));
						}
						print "</div>";
					}
					print "<div class='actionMoreInfo'>".caNavLink($this->request, _t("More Info >"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_action["occurrence_id"]))."</div></div></li>\n"; // format used on load only
				}
?>
				</ul>
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
			</div><!-- end timelineContainer -->
			<div style="clear:both;"><!-- empty --></div>	
<?php
	}
?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

</div><!-- end detailBody -->
	<div id='bottomBar'>
<?php
		if($this->request->config->get('enable_bookmarks')){
?>
			<!-- bookmark link BEGIN -->
			
<?php
			if($this->request->isLoggedIn()){
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
			}else{
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='Bookmark'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
			}
		}
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', $this->request->getController(), 'GetViz', array('id' => $t_entity->getPrimaryKey()))."\"); return false;' ><img src='".$this->request->getThemeUrlPath()."/graphics/icons/visualization.png' border='0' title='Visualize relationships'></a>";

?>
	</div>
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
			jQuery('#actionTimeline').jcarousel({size: <?php print (int)$vn_num_actions; ?><?php print ($vn_num_actions > 5) ? ",  itemLoadCallback:loadActions" : ""; ?>});
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
					jQuery('#sliderPosInfo').css('display', 'none');
					jQuery('#actionTimeline').data('jcarousel').scroll(ui.value, jQuery('#actionTimeline').data('jcarousel').has(ui.value));
				}
			});
<?php
			}
?>

		});
		
		

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