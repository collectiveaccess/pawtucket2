<?php
	$t_item = $this->getVar('item');
	$va_access_values = $this->getVar('access_values');
	$this->request->session->setVar("repViewerResults", "");
	$va_object_results = array();
?>

<div id="detail">
	<div id='pageTitle'>
<?php 
	if ($t_item->get('ca_collections.type_id') == 131) {
		print "Institutional Records Collection";
	} else {
		print "Artwork"; 
	}
?>
	</div>
	<div id="contentArea">
		<div id='detailHeader'>
			<h2>
				{{{<unit>^ca_collections.preferred_labels.name</unit>}}}
<?php
				if ($va_artist_title = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'delimiter' => ' / '))) {
					print "<span class='artist'> / ".$va_artist_title."</span>";
				}
?>				
			</h2>
			{{{<ifcount code="ca_collections.date.dates_value" min="1"><div class='detailSubtitle'><unit delimiter="<br/>">^ca_collections.date.dates_value</unit></div></ifcount>}}}
		</div>
		
		<div id='mediaArea'>
			<div class='mediaLarge'>
<?php
			$va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'excludeTypes' => array('document'), 'checkAccess' => $va_access_values));
			$va_related_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('checkAccess'=> $va_access_values, 'versions' => array('medium', 'smallthumb')));
			
			$vn_rep_id = key($va_related_reps);
			$va_primary_rep = reset($va_related_reps);
			$va_primary_id = reset($va_related_objects);
			
			$va_media_thumbs_width = (775 - $va_primary_rep['info']['medium']['WIDTH']) - 20;
			$va_media_thumbs_height = $va_primary_rep['info']['medium']['HEIGHT'];
			$va_media_thumb_stack = floor(($va_media_thumbs_height - 20) / 90);
			
			if ($t_item->get('ca_objects.nonpreferred_labels.type_id') == '515') {
				$va_main_image_object = $t_item->get('ca_objects.nonpreferred_labels.name', array('excludeTypes' => array('document')));				
			} else {
				$va_main_image_captions = $t_item->get('ca_objects.preferred_labels', array('returnAsArray' => true, 'excludeTypes' => array('document')));
				$va_main_image_object = $va_main_image_captions[0];
			}
			if ($va_primary_rep['tags']['medium']) {
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $va_primary_id, 'representation_id' => $va_primary_rep['representation_id']))."\"); return false;' >".$va_primary_rep['tags']['medium']."</a>";
			
				print "<div class='caption' style='width:".$va_primary_rep['info']['medium']['WIDTH']."px;'>".$va_main_image_object."</div>";
				$va_object_results[] = array("object_id" => $va_primary_id, "representation_id" => $va_primary_rep['representation_id']);
			}
?>			
			</div><!-- end mediaLarge-->
<?php
			if (sizeof($va_related_reps) > 1) {
?>			
			<div class='views' style='width:<?php print $va_media_thumbs_width;?>px;'>Views</div>			
			<div class='mediaThumbs scrollBlock' style='width:<?php print $va_media_thumbs_width;?>px; height:<?php print $va_media_thumbs_height;?>px'>
	
				<div class='scrollingDiv'><div class='scrollingDivContent'>
<?php
				$stack = 0;
				foreach(array_slice($va_related_reps, 1, null, true) as $vn_related_rep_id => $va_related_rep) {
					if ($stack == 0) { print "<div class='thumbResult'>";}
					
					print "<div class='rep'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $vn_related_rep_id, 'representation_id' => $va_related_rep['representation_id']))."\"); return false;' >".$va_related_rep['tags']['smallthumb']."</a></div>";
					//print "<div class='rep'>".$va_related_rep['tags']['widepreview']."</div>";
					
					$stack++;
					if ($stack == $va_media_thumb_stack) {
						print "</div>";
						$stack = 0;
					}
					$va_object_results[] = array("object_id" => $vn_related_rep_id, "representation_id" => $va_related_rep['representation_id']);
				}
				if ((end($va_related_reps) == $va_related_rep) && ($stack < $va_media_thumb_stack) && ($stack != 0)){print "</div>";} 
?>
				</div></div>
			</div><!-- end mediaThumbs-->	
<?php
			}
			$this->request->session->setVar("repViewerResults", $va_object_results);
?>
			
		</div><!-- end mediaArea-->
		
		<div id='infoArea'>
<?php

		if ($t_item->get('ca_collections.type_id') != '131') {
?>	
			<div class='floorplan'>
<?php
			#	print "<div class='title'>"._t('Install Location')."</div>";
			#	print "<div class='floor'>Fourth Floor</div>";
			#	print "<div class='plan'><img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/floorplan.png' border='0'></div>";
?>		
			</div>
<?php
		}
		if ($t_item->get('ca_collections.type_id') != '131') { 
			print "<div class='collectionHeading'>Identifier</div><p>".$t_item->get('ca_collections.idno')."</p>";
		}
		if ($va_mat_display = $t_item->get('ca_collections.mat_tech_display')) {
			print "<div class='collectionHeading'>Materials</div><p>".$va_mat_display."<p>";
		}		
		if (($vs_collection = $t_item->get('ca_collections.description.description_text')) && ($t_item->get('ca_collections.type_id') != '131')) {
			print "<div class='description trimText'><div class='metatitle'>"._t('Description')."</div>".$t_item->get('ca_collections.description.description_text')."</div>";
		}
		if (($t_item->get('ca_collections.statement.statement_source', array('convertCodesToDisplayText' => true))) == "Artist") {
			$va_statement = $t_item->get('ca_collections.statement.statement_text');
			print "<div class='artist description' style='max-height:205px;overflow:hidden;'><div class='metatitle'>"._t('Artist Statement')."</div>".$va_statement."</div>";
		}		
		if (($vs_bio = $t_item->get('ca_entities.biography.bio_text', array('restrictToRelationshipTypes' => array('artist'), 'delimiter' => '<br/><br/>')))) {
			print "<div class='artist description' style='max-height:205px;overflow:hidden;'><div class='metatitle'>"._t('About the Artist')."</div>".$vs_bio."</div>";
			print "<div class='readArtist'>".caNavLink($this->request, 'Read More', '', '', 'Detail', 'entities/'.$t_item->get('ca_entities.entity_id'))."</div>";
		}		
		if ($t_item->get('ca_collections.type_id') == '131') {
			print "<div class='metatitle'>Collection Identifier</div><p>".$t_item->get('ca_collections.idno')."</p>";
		}

		if ($t_item->get('ca_collections.collection_note')) {
			$va_collection_notes = $t_item->get('ca_collections.collection_note', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
			foreach ($va_collection_notes as $key_collection => $va_collection_note) {
				if ($va_collection_note['collectio_note_type'] == "Abstract") {
					print "<div class='metatitle'>".$va_collection_note['collectio_note_type']."</div><p>".$va_collection_note['collection_note_content']."</p>\n";		
				}
			}
		}
?>	
		{{{<unit><ifdef code="ca_collections.institutional_date.inclusive_date"><div class="metatitle">Inclusive Dates</div><p> ^ca_collections.institutional_date.inclusive_date</p></ifdef></unit>}}}
		{{{<unit><ifdef code="ca_collections.institutional_date.bulk_dates"><div class="metatitle">Bulk Dates</div><p> ^ca_collections.institutional_date.bulk_dates</p></ifdef></unit>}}}
		{{{<unit><ifdef code="ca_collections.extent.extent_value"><div class="metatitle">Extent</div><p> ^ca_collections.extent.extent_value ^ca_collections.extent.extent_units</p></ifdef></unit>}}}
<?php
		if ($t_item->get('ca_collections.collection_note')) {
			$va_collection_notes = $t_item->get('ca_collections.collection_note', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
			foreach ($va_collection_notes as $key_collection => $va_collection_note) {
				if ($va_collection_note['collectio_note_type'] == "Scope & Content") {
					print "<div class='metatitle'>".$va_collection_note['collectio_note_type']."</div><p>".$va_collection_note['collection_note_content']."</p>\n";		
				}
			}
		}
		if ($t_item->get('ca_collections.collection_note')) {
			$va_collection_notes = $t_item->get('ca_collections.collection_note', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
			foreach ($va_collection_notes as $key_collection => $va_collection_note) {
				if (($va_collection_note['collectio_note_type'] != "Scope & Content") && ($va_collection_note['collectio_note_type'] != "Abstract")) {
					print "<div class='metatitle'>".$va_collection_note['collectio_note_type']."</div><p>".$va_collection_note['collection_note_content']."</p>\n";		
				}
			}
		}
?>
		</div><!-- end infoArea-->
	</div><!-- end contentArea-->
	<div id='relatedInfo'>
<?php
	# Related Exhibitions Block
	$va_occurrences = $t_item->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults exhibitions'>";
				print "<div>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true));
					
					
					print "<div class='occurrencesResult'>";
					$vn_ii = 0;
					if (sizeof($va_artworks) >= 4) {
						foreach ($va_artworks as $key => $vn_artwork_id) {
							$t_collection = new ca_collections($vn_artwork_id);
							$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
							$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('resultthumb'), 'return' => array('tags')));
						
							if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}

							if ($va_primary_rep = array_shift(array_values($va_object_reps))){
								print "<div class='exImage' {$vs_style}>".caNavLink($this->request, $va_primary_rep, '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
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
					} else {
							$t_collection = new ca_collections($va_artworks[0]);
							$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
							$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('exsingle'), 'return' => array('tags')));
							print "<div class='exImageSingle'>".caNavLink($this->request, array_shift(array_values($va_object_reps)), '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
					}
					print "<div class='exTitle'>".caNavLink($this->request, $va_occurrence['name'], '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
					print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
					print "</div><!-- end occurrenceResult -->";
				}
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}

	# Related Events Block
	$va_events = $t_item->get('ca_occurrences', array('restrictToTypes' => array('exhibition_event', 'educational', 'fundraising', 'admin_event', 'community_event'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));
	if (sizeof($va_events) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Events')."</div>";
			print "<div class='blockResults'>";
				print "<div>";
					$vn_i = 0;
					foreach ($va_events as $event_id => $va_event) {
						$vn_event_id = $va_event['occurrence_id'];
						if ($vn_i == 0) {print "<div class='eventSet'>";}
						print "<div class='eventsResult'>";
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
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true, 'checkAccess' => $va_access_values));
	if (sizeof($va_entities) > 0) {
		print "<div id='entitiesBlock'>";
		print "<div class='blockTitle related'>"._t('Related People')."</div>";
			print "<div class='blockResults scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
				$vn_i = 0;
				foreach ($va_entities as $entity_id => $va_entity) {
					$vn_entity_id = $va_entity['entity_id'];
					if ($vn_i == 0) {print "<div class='entitiesSet'>";}
					print caNavLink($this->request, "<div class='entitiesResult'>".$va_entity['displayname']."</div>", '', '','Detail', 'Entities/'.$va_entity['entity_id']);
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_entities) == $va_entity) && ($vn_i < 5)){print "</div>";}								
				print "</div></div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}	
?>		
	</div><!-- end relatedInfo-->
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 205
		});
	});
</script>

