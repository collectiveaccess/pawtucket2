<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	$t_occurrence 			= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	$vs_title 					= $this->getVar('label');
	$va_access_values	= $this->getVar('access_values');
	
	JavascriptLoadManager::register('smoothDivScrollVertical');
	
	$qr_hits = $this->getVar('browse_results');

?>
		<div id="subnav">
<?php
		if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', _t("Back"), ''))) {
			print "<ul><li>";
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "&laquo; "._t("Previous"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}else{
				print "&laquo; "._t("Previous");
			}
			print "</li>";
			print "<li>&nbsp;&nbsp;&nbsp;".$vs_back_link."</li>";
			print "<li>";
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, "&raquo; "._t("Next"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
			}else{
				print "&raquo; "._t("Next");
			}
			print "</li></ul>";
		}else{
			print "<ul><li>".caNavLink($this->request, "&laquo; "._t("Chronology"), "", "eastend", "Chronology", "Index")."</li></ul>";
		}
?>
		</div><!--end subnav-->
		<div id="ex_content">		
<?php
			print "<div id='ex_title'><span class='listhead caps'>".$vs_title;
			if($vs_event_date = $t_occurrence->get("event_date ")){
				print "<br />".$vs_event_date;
			}
			print "</span></div>";		

			# --- if there is only one object associated to this exhibition, display it here rather than loading the scrolling grid of images
			if($qr_hits->numHits() == 1){
				while($qr_hits->nextHit()){
					$va_media_info = $qr_hits->getMediaInfo('ca_object_representations.media', 'mediumlarge');
					print "<div id='ex_img' style='width:".$va_media_info['WIDTH']."px;'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'mediumlarge', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')), array("id" => "searchThumbnail".$qr_hits->get('ca_objects.object_id')))."</div>";
				}
			}else{
				// set parameters for paging controls view
				$this->setVar('other_paging_parameters', array(
					'occurrence_id' => $vn_occurrence_id,
					'detail_type' => 'occ_detail'
				));
				$this->setVar('num_cols', 3);
				$this->setVar('detailType', 'occurrence');
				print "<div id='ex_grid'>".$this->render('related_objects_grid.php')."</div>";
			}
?>		
			<div id="ex_detail_info">
<?php
			$vn_descriptionOutput = 0;
			if($vs_description_text = $t_occurrence->get("ca_occurrences.description")){
				$vn_descriptionOutput = 1;
				print "<div id='ex_description'><div class='caption'>".$vs_description_text."</div></div>";
?>
				<script type="text/javascript">
					// Initialize the plugin
					$(document).ready(function () {
						$("div.#ex_description").smoothDivScroll({
							visibleHotSpotBackgrounds: "hover",
							hotSpotScrollingInterval: 45
						});
					});
				</script>
<?php
			}
			# --- entities
			$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$vn_scrollEntities = 0;
			if(sizeof($va_entities) > 0){	
				if(sizeof($va_entities) > 7){
					$vn_scrollEntities = 1;
				}
?>
				<div class='listhead caps' style='padding-bottom:0px;'><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("People") : _t("Person")); ?></div>
<?php
				$va_entities_sorted = array();
				foreach($va_entities as $va_entity) {
					$va_entities_sorted[$va_entity['relationship_typename']][] = "<div style='padding-bottom:3px;'>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."</div>";
				}
?>
				<div class='ex_related_list' <?php print ($vn_scrollEntities) ? "" : "style='height:auto;'"; ?>>
<?php
					foreach($va_entities_sorted as $vs_relationship_type => $va_links){
						print "<div class='caption'><i>".$vs_relationship_type."</i></div>";
						foreach($va_links as $vs_link){
							print $vs_link;
						}
					}
					if($vn_scrollEntities){
?>
					<script type="text/javascript">
						// Initialize the plugin
						$(document).ready(function () {
							$("div.ex_related_list").smoothDivScroll({
								visibleHotSpotBackgrounds: "hover",
								hotSpotScrollingInterval: 45
							});
						});
					</script>
<?php
					}
?>
				</div><!-- end ex_related_list -->
<?php
			}
			# --- places
			$va_places = $t_occurrence->get("ca_places", array("restrictToRelationshipTypes" => array("site"),"returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				$vn_map_height = 97;
				if(!$vn_descriptionOutput || !$vn_scrollEntities){
					$vn_map_height = 200;
				}
				$va_place_info = array_pop($va_places);
				$t_place = new ca_places($va_place_info['place_id']);
				$o_map = new GeographicMap(238, $vn_map_height, 'map');
				$o_map->mapFrom($t_place, "ca_places.georeference");
				print "<div class='captionSmall'>".$o_map->render('HTML');
				print (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])."</div>";
			}
?>
			</div>
		
		
		
		</div><!-- end ex_content -->