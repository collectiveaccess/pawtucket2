<?php
	$t_item = $this->getVar('item');
	#$t_item->dump();
?>
<div id='pageArea' class='artwork'>
	<div id='pageTitle'>
		<?php print "Installation"; ?>
	</div>
	<div id='contentArea'>
		<div id='detailHeader'>
<?php	
			print "<h2>".$t_item->get('ca_collections.preferred_labels.name');
			if ($vs_artist_name = $t_item->get('ca_entities.preferred_labels')) { 
				print "<span class='artist'> / ".$vs_artist_name."</span>";
			}
			print "</h2>";
			print "<div class='detailSubtitle'>".$t_item->get('ca_collections.date.dates_value')."</div>"; 
?>
		</div>
		<div id='mediaArea'>
			<div class='mediaLarge'>
<?php
			$va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_related_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('medium', 'widepreview')));
			$va_primary_rep = array_shift(array_values($va_related_reps));
			$va_media_thumbs_width = (775 - $va_primary_rep['info']['medium']['WIDTH']) - 20;
			$va_media_thumbs_height = $va_primary_rep['info']['medium']['HEIGHT'];
			$va_media_thumb_stack = floor(($va_media_thumbs_height - 20) / 90);
			
			$va_main_image_object = $t_item->get('ca_objects.preferred_labels', array('returnAsArray' => true));
			$va_main_image_caption = array_shift(array_values($va_main_image_object));
			if ($va_primary_rep['tags']['medium']) {
				print $va_primary_rep['tags']['medium'];
				print "<div class='caption' style='width:".$va_primary_rep['info']['medium']['WIDTH']."px;'>".$va_main_image_caption."</div>";
			}
?>			
			</div><!-- end mediaLarge-->
<?php		
			if (sizeof($va_related_reps) > 1) {
?>			
			<div class='views' style='width:<?php print $va_media_thumbs_width;?>px;'>Views</div>			
			<div class='mediaThumbs' style='width:<?php print $va_media_thumbs_width;?>px; height:<?php print $va_media_thumbs_height;?>px'>
	
				<div style='width:10000px;'>
<?php
				$stack = 0;
				foreach(array_slice($va_related_reps, 1) as $rep_key => $va_related_rep) {
					if ($stack == 0) { print "<div class='thumbResult'>";}
					print "<div class='rep'>".$va_related_rep['tags']['widepreview']."</div>";
					$stack++;
					if ($stack == $va_media_thumb_stack) {
						print "</div>";
						$stack = 0;
					}
				}
				if ((end($va_related_reps) == $va_related_rep) && ($stack < $va_media_thumb_stack) && ($stack != 0)){print "</div>";} 
?>
				</div>
			</div><!-- end mediaThumbs-->	
<?php
			}
?>
			
		</div><!-- end mediaArea-->
		<div id='infoArea'>
<?php
		if (($vs_collection = $t_item->get('ca_collections.description', array('convertCodesToDisplayText' => true))) != " ") {
			print "<div class='description'><div class='title'>"._t('Description')."</div>".$vs_collection."</div>";
		}
?>	
			<div class='floorplan'>
<?php
				print "<div class='title'>"._t('Install Location')."</div>";
				print "<div class='floor'>Fourth Floor</div>";
				print "<div class='plan'><img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/floorplan.png' border='0'></div>";
?>		
			</div>
		</div><!-- end infoArea-->
	</div><!-- end contentArea-->
	<div id='relatedInfo'>
	<div id='sortMenu'>
		<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
	</div>
<?php

	# Related Exhibitions Block
	$va_occurrences = $t_item->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true));
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true));
					
					
					print "<div class='occurrenceResult'>";
					$vn_ii = 0;
					foreach ($va_artworks as $key => $vn_artwork_id) {
						$t_collection = new ca_collections($vn_artwork_id);
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
						
						if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}

						if ($va_primary_rep = array_shift(array_values($va_object_reps))){
							print "<div class='exImage' {$vs_style}>".caNavLink($this->request, $va_primary_rep, '', '', 'Detail', 'Occurrences/'.$va_occurrence['idno'])."</div>";
							$vn_i++;
							$vn_ii++;
						}
						if($vn_i == 4) {break;}

					}
					if ($vn_i < 4) {
						while ($vn_i < 4) {
							if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}

							print "<div class='exImage' {$vs_style}></div>";
							$vn_i++;
							$vn_ii++;
						}
					}
					print "<div class='exTitle'>".caNavLink($this->request, $va_occurrence['name'], '', '', 'Detail', 'Occurrences/'.$va_occurrence['idno'])."</div>";
					print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
					print "</div><!-- end occurrenceResult -->";
				}
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}

	# Related Events Block
	$va_events = $t_item->get('ca_occurrences', array('restrictToTypes' => array('exhibition_event', 'educational', 'fundraising', 'admin_event', 'community_event'), 'returnAsArray' => true));
	if (sizeof($va_events) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle'>"._t('Related Events')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
					$vn_i = 0;
					foreach ($va_events as $event_id => $va_event) {
						$vn_event_id = $va_event['idno'];
						if ($vn_i == 0) {print "<div class='eventSet'>";}
						print "<div class='eventResult'>";
						print "<div>".caNavLink($this->request, $va_event['label'], '', '', 'Detail', 'Occurrences/'.$vn_event_id)."</div>";
						print "</div>";
						$vn_i++;
						if ($vn_i == 5) {
							print "</div>";
							$vn_i = 0;
						}
					}
					if ((end($va_events) == $va_event) && ($vn_i < 5) && ($vn_i != 0)){print "</div>";}								

				print "</div>";	
			print "</div><!-- end blockResults -->";
		print "</div><!-- end occurrencesBlock-->";
	}
	
	# Related Entities Block
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true));
	if (sizeof($va_entities) > 0) {
		print "<div id='entitiesBlock'>";
		print "<div class='blockTitle'>"._t('Related People')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
				$vn_i = 0;
				foreach ($va_entities as $entity_id => $va_entity) {
					$vn_entity_id = $va_entity['entity_id'];
					if ($vn_i == 0) {print "<div class='entitySet'>";}
					print "<div class='entityResult'>";
					print "<div>".caNavLink($this->request, $va_entity['displayname'], '', '','Detail', 'Entities/'.$va_entity['idno'])."</div>";
					print "</div>";
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_entities) == $va_entity) && ($vn_i < 5)){print "</div>";}								
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}

	
?>		
	</div><!-- end relatedInfo-->
</div>