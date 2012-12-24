<?php
	$va_access_values = $this->getVar('access_values');
	$pn_silo_id = $this->getVar('silo_id');
	$pn_next_id = $this->getVar('next_id');
	$pn_previous_id = $this->getVar('previous_id');
	$va_action = $this->getVar('action');
	
	$vs_thumbnail = "<img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/imagePlaceholder.jpg' border='0'>";

?>
	<div class="siloMoreInfoContent"><div class="siloPrevious">
<?php
		if($pn_previous_id){
			#print "<a href='#' onclick='jQuery(\"#siloMoreInfo".$pn_silo_id."\").load(\"".caNavUrl($this->request, 'MetabolicChronology', 'Show', 'getAction', array('action_id' => $pn_previous_id, 'silo_id' => $pn_silo_id))."\"); jQuery(\"#silo".$pn_silo_id."\").data(\"jcarousel\").scroll(jQuery(\"#silo".$pn_silo_id."\").data(\"jcarousel\").first - 1, true); $(\"#silo".$pn_silo_id."\").find(\".actionHighlighted\").removeClass(\"actionHighlighted\").addClass(\"action\"); jQuery(\"#actionContainer".$pn_previous_id."\").removeClass(\"action\").addClass(\"actionHighlighted\"); return false;'><img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowLeftChronoSmall.png' border='0'></a>";
			print "<a href='#' onclick='jQuery(\"#siloMoreInfo".$pn_silo_id."\").load(\"".caNavUrl($this->request, 'MetabolicChronology', 'Show', 'getAction', array('action_id' => $pn_previous_id, 'silo_id' => $pn_silo_id))."\"); scrollTimelineToPreviousAction({$pn_silo_id}, {$pn_previous_id}); return false;'><img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowLeftChronoSmall.png' border='0'></a>";
		}else{
			print "<img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowLeftChronoSmallOff.png' border='0'>";
		}
?>
	</div><!-- end siloPrevious -->
	<div class="siloNext">
<?php
		if($pn_next_id){
			#print "<a href='#' onclick='jQuery(\"#siloMoreInfo".$pn_silo_id."\").load(\"".caNavUrl($this->request, 'MetabolicChronology', 'Show', 'getAction', array('action_id' => $pn_next_id, 'silo_id' => $pn_silo_id))."\"); jQuery(\"#silo".$pn_silo_id."\").data(\"jcarousel\").scroll(jQuery(\"#silo".$pn_silo_id."\").data(\"jcarousel\").first + 1, true); $(\"#silo".$pn_silo_id."\").find(\".actionHighlighted\").removeClass(\"actionHighlighted\").addClass(\"action\"); jQuery(\"#actionContainer".$pn_next_id."\").removeClass(\"action\").addClass(\"actionHighlighted\"); return false;'><img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowRightChronoSmall.png' border='0'></a>";
			print "<a href='#' onclick='jQuery(\"#siloMoreInfo".$pn_silo_id."\").load(\"".caNavUrl($this->request, 'MetabolicChronology', 'Show', 'getAction', array('action_id' => $pn_next_id, 'silo_id' => $pn_silo_id))."\"); scrollTimelineToNextAction({$pn_silo_id}, {$pn_next_id}); return false;'><img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowRightChronoSmall.png' border='0'></a>";
		}else{
			print "<img src='".__CA_URL_ROOT__."/app/plugins/MetabolicChronology/themes/metabolic/graphics/arrowRightChronoSmallOff.png' border='0'>";
		}
?>
	</div><!-- end siloNext -->
	<div class="hide"><a href="#" onclick="jQuery('#siloMoreInfo<?php print $pn_silo_id; ?>').slideUp(); jQuery('#actionContainer<?php print $va_action["occurrence_id"]; ?>').removeClass('actionHighlighted').addClass('action'); return false;"><?php print _t("Hide"); ?> ></a></div><!-- end hide -->
	<H1><?php print $va_action["date"]; ?></H1>
<?php
	if($va_action["label"]){
		print "<div class='unit actionText'>";
		print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_action["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_action["occurrence_id"])) : $va_action["label"]);
		print "</div>";
	}
	if($va_action["description"]){
		print "<div class='unit'>";
		print $va_action["description"];
		print "</div>";
	}
?>
	<div class="leftCol">
		<div class="scrollPane">
<?php

		# --- entities
		if($va_action["entities"]){	
?>
			<div class="unit"><h3><?php print _t("Related")." ".((sizeof($va_action["entities"]) > 1) ? _t("People/Organizations") : _t("Person/Organization")); ?></h3>
			
<?php
			$i = 0;
			foreach($va_action["entities"] as $va_entity){
				print (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"]);
				$i++;
				if($i < sizeof($va_action["entities"])){
					print ", ";
				}
			}
?>
			</div>				
<?php
		}
		# --- occurrences
		$va_sorted_occurrences = array();
		if($va_action["occurrences"]){	
			$t_occ = new ca_occurrences();
			$va_item_types = $t_occ->getTypeList();
			foreach($va_action["occurrences"] as $va_occurrence) {
				$t_occ->load($va_occurrence['occurrence_id']);
				$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
			}
			
			foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
					<div class="unit"><h3><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h3>
<?php
				$i = 0;
				foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
					print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"]);
					$i++;
					if($i < sizeof($va_occurrence_list)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
		}
		# --- collections
		if($va_action["collections"]){	
			print "<div class='unit'><h3>"._t("Related Project/Silo").((sizeof($va_action["collections"]) > 1) ? "s" : "")."</h3>";
			$i = 0;
			foreach($va_action["collections"] as $va_collection_info){
				print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
				$i++;
				if($i < sizeof($va_action["collections"])){
					print ", ";
				}
			}
?>
			</div>
<?php
		}		
		# -- display the map in the left column if there are media to display
		if(is_array($va_action["objects"]) && sizeof($va_action["objects"])){
			if($va_action["map"] && $va_action["georeference"]){
				print "<div class='unit'><H3>"._t("Location")."</H3>";
				print $va_action["map"];
				print "</div>";
			}
		}
?>
	</div><!-- end scrollPane --></div><!-- end leftCol -->
	<div class="rightCol">
<?php
// 	if(is_array($va_action["objects"]) && sizeof($va_action["objects"])){
// 		$t_rel_object = new ca_objects();
// 		foreach($va_action["objects"] as $vn_i => $va_object_info){
// 			$t_rel_object->load($va_object_info['object_id']);
// 			#$va_reps = $t_rel_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values));
// 			$va_reps = $t_rel_object->getPrimaryRepresentation(array('widepreview'));
// 			print caNavLink($this->request, $va_reps["tags"]["widepreview"], '', 'Detail', 'Object', 'Show', array('object_id' => $va_object_info['object_id']));
// 					
// 		}
// 	}





	$vn_c = 0;
	$vn_numCols = 4;
	$vn_max_images = 12;
	
	

	if(is_array($va_action["objects"]) && sizeof($va_action["objects"])){
		# --- if there is only one image, show a larger one - which is configured in media_display_conf under chronology. Otherwise show a grid of images
		if(sizeof($va_action["objects"]) == 1){
			$t_rel_object = new ca_objects();
			foreach($va_action["objects"] as $vn_i => $va_object_info){
				$t_rel_object->load($va_object_info['object_id']);
				$t_rep = $t_rel_object->getPrimaryRepresentationInstance(array('return_with_access' => $va_access_values));
				# -- get version to display configured in media_display.conf
				$va_chrono_display_info = caGetMediaDisplayInfo('chronology', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
				$vs_chrono_version = $va_chrono_display_info['display_version'];
				$vn_object_id = $va_object_info['object_id'];
$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
				print "<div style='text-align:center;'>".caNavLink($this->request, $t_rel_object->getLabelForDisplay().", ID:".$t_rel_object->get('idno'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
				print "<div id='contchrono'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";

			}
		}else{
?>
			<table border="0" cellpadding="0px" cellspacing="0px" width="100%">
<?php
			$t_rel_object = new ca_objects();
			$vn_itemc = 0;
			# --- only show the first 12 images then a link that says how many more there are
			foreach($va_action["objects"] as $vn_i => $va_object_info){
				$t_rel_object->load($va_object_info['object_id']);
				$va_reps = $t_rel_object->getPrimaryRepresentation(array('widethumbnail', 'small'), null, array('return_with_access' => $va_access_values));
				if ($vn_c == 0) { print "<tr>\n"; }
				$vn_object_id = $va_object_info['object_id'];
				$vs_caption = $t_rel_object->getLabelForDisplay();
				# --- get the height of the image so can calculate padding needed to center vertically
				$vn_padding_top = 0;
				$vs_display = "";
				if(!($vs_display = $va_reps["tags"]["widethumbnail"])){
					$vs_display = "<div class='textResult'>ID: ".$t_rel_object->get('idno')."</div>";
				}
				print "<td align='left' valign='top' class='searchResultTd' style='width:110px;'><div class='relatedThumbBg searchThumbnail".$vn_object_id."'>";
				print caNavLink($this->request, $vs_display, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
				
				// Get thumbnail caption
				$this->setVar('object_id', $vn_object_id);
				$this->setVar('caption_title', $vs_caption);
				$this->setVar('caption_idno', $t_rel_object->get('idno'));
				
				print "</div>";
		#		print "<div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>";
				print "</td>\n";
		
				
				// set view vars for tooltip
				$this->setVar('tooltip_representation', $va_reps["tags"]["small"]);
				$this->setVar('tooltip_title', $vs_caption);
				$this->setVar('tooltip_idno', $t_rel_object->get('idno'));
				TooltipManager::add(
					".searchThumbnail{$vn_object_id}", $this->render('ca_objects_result_tooltip_html.php')
				);
				
				$vn_c++;
				$vn_itemc++;
				
				if ($vn_c == $vn_numCols) {
					print "</tr>\n";
					$vn_c = 0;
				}else{
					print "<td><!-- empty for spacing --></td>";
				}
				if($vn_max_images == $vn_itemc){
					break;
				}
			}
			if(($vn_c > 0) && ($vn_c < $vn_numCols)){
				while($vn_c < $vn_numCols){
					print "<td class='searchResultTd'><!-- empty --></td>\n";
					$vn_c++;
					if($vn_c < $vn_numCols){
						print "<td><!-- empty for spacing --></td>";
					}
				}
				print "</tr>\n";
			}
?>
		</table>
<?php
		if(sizeof($va_action["objects"]) > $vn_max_images){
?>
		<div class='moreImagesLink'><?php print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, _t("View all %1 images", sizeof($va_action["objects"]))." >", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_action["occurrence_id"])) : _t("%1 more images", (sizeof($va_action["objects"]) - $vn_max_images))); ?></div>
<?php
		}
		}
	}else{
		# -- no media to display so show a large map instead - if available!
		if($va_action["map"] && $va_action["georeference"]){
			print "<H3>"._t("Location")."</H3>";
			print $va_action["map"];
		}
	}







?>
	</div><!-- end rightCol -->
	<div style="clear:both;"><!-- empty --></div>
	</div><!-- end siloMoreInfoContent -->
<?php
	if(!$this->request->getParameter("dontInitiateScroll", pInteger)){
?>
	<script type="text/javascript">
		jQuery('.scrollPane').jScrollPane({
			animateScroll: true,
		});
	</script>
<?php
	}
?>
<script type="text/javascript">
	function scrollTimelineToNextAction(silo_id, action_id){
		var currentActionTimeline = jQuery("#silo" + silo_id).data("jcarousel");
		currentActionTimeline.jcarousel_selected_action_id = action_id;	// set a variable in the carousel so it knows which action to highlight once the ajax load is complete
		
		currentActionTimeline.scroll(getIndexForActionID(silo_id, action_id), true); 
	}
	function scrollTimelineToPreviousAction(silo_id, action_id){
		var currentActionTimeline = jQuery("#silo<?php print $pn_silo_id; ?>").data("jcarousel");
		currentActionTimeline.jcarousel_selected_action_id = action_id;	// set a variable in the carousel so it knows which action to highlight once the ajax load is complete
		
		currentActionTimeline.scroll(getIndexForActionID(silo_id, action_id), true); 
	}
</script>