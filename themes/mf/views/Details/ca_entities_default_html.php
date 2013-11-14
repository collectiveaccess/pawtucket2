<?php
	$t_item = $this->getVar('item');
	#$t_item->dump();
?>
<div id='pageArea' class='entities'>
	<div id='pageTitle'>
		<?php print "Artists"; ?>
	</div>
	<div id='contentArea'>
		<div id='detailHeader'>
<?php	
			print "<h2>".$t_item->get('ca_entities.preferred_labels')."</h2>";
			
		if (($t_item->get('ca_entities.nationality') != 211) | ($t_item->get('ca_entities.vital_dates'))) {	
			print "<div class='detailSubtitle'>".$t_item->get('ca_entities.nationality', array('convertCodesToDisplayText' => true))."".$t_item->get('ca_entities.vital_dates', array('template' => ', ^vital_dates'))."</div>"; 
		}
?>
		</div>
		<div id='mediaArea'>
<?php		

		$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true));
		if (sizeof($va_collections) > 0) {
			print "<div class='mediaThumbs'>";
					print "<div style='width:100000px'>";
					$vn_i = 0;
					foreach ($va_collections as $collection_id => $va_collection) {
					
						$va_collection_id = $va_collection['collection_id'];
						$t_collection = new ca_collections($va_collection_id);
						
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));			
						
						$va_artwork_title = $t_collection->get('ca_collections.preferred_labels');
						if ($t_collection->get('ca_collections.date.dc_dates_types') == 188) {
							$va_artwork_date = ", ".$t_collection->get('ca_collections.date.dates_value');
						}
						$va_artwork_materials = '<div class="materials">'.$t_collection->get('ca_collections.mat_tech_display').'</div>';
						$va_artwork_display = $va_artwork_title.$va_artwork_date."<br/>".$va_artwork_materials;
						
						
						foreach ($va_object_reps as $object_key => $va_artwork_rep) {	
							if ($vn_i == 0){print "<div class='imageSet'>";}
							print caNavLink($this->request, "<div class='rep rep{$object_key}' onmouseover='$(\".title{$object_key}\").show()'>".$va_artwork_rep."</div>", '', '', 'Detail', 'Collections/'.$va_collection['idno']);
							print caNavLink($this->request, "<div style='display:none' class='title title{$object_key}' onmouseout='$(\".rep{$object_key}\").show(); $(\".title{$object_key}\").hide()'>".$va_artwork_display."</div>", '', '', 'Detail', 'Collections/'.$va_collection['idno']);
							$vn_i++;
							if ($vn_i == 2) {
								print "</div><!-- end imageSet-->";
								$vn_i = 0;
							}
							
						}
					}
					if ((end($va_collections) == $va_collection) && ($vn_i < 2) && ($vn_i != 0)){print "</div>";} 

					print "</div>";
			print "</div><!-- end mediaThumbs -->";
		}
		
?>
			
		</div><!-- end mediaArea-->
		<div id='infoArea'>
<?php
		if (($vs_collection = $t_item->get('ca_entities.biography.bio_text', array('convertCodesToDisplayText' => true))) != "") {
			print "<div class='description'><div class='title'>"._t('Biography')."</div>".$vs_collection."</div>";
		}
?>	
		</div><!-- end infoArea-->
	</div><!-- end contentArea-->

<?php	
	$va_occurrences = $t_item->get('ca_occurrences', array('returnAsArray' => true, 'restrictToTypes' => array('mf_exhibition')));
	$va_events = $t_item->get('ca_occurrences', array('returnAsArray' => true, 'restrictToTypes' => array('exhibition_event', 'educational', 'fundraising', 'admin_event', 'community_event')));
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true));

	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_events) > 0)) {
?>		
	<div id='relatedInfo'>

	<div id='sortMenu'>
		<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
	</div>
<?php
	
		# Related Exhibitions Block
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
						$vn_i = 0;
						$vn_ii = 0;
						foreach ($va_artworks as $key => $vn_artwork_id) {
							$t_collection = new ca_collections($vn_artwork_id);
							$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
							$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
						

							if ($va_object_reps){
								foreach ($va_object_reps as $img_key => $va_object_rep) {
									if($vn_i < 4) {
										if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}
										print "<div class='exImage' {$vs_style}>".$va_object_rep."</div>";
										$vn_i++;
										$vn_ii++;
									}
								}
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
		if (sizeof($va_events) > 0) {
			print "<div id='occurrencesBlock'>";
			print "<div class='blockTitle'>"._t('Related Events')."</div>";
				print "<div class='blockResults'>";
					print "<div style='width:100000px'>";

					foreach ($va_events as $occurrence_id => $va_event) {
						$vn_occurrence_id = $va_event['occurrence_id'];
						$t_occurrence = new ca_occurrences($vn_occurrence_id);
						$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true));
					
					
						print "<div class='occurrenceResult'>";
						$vn_i = 0;
						$vn_ii = 0;
						foreach ($va_artworks as $key => $vn_artwork_id) {
							$t_collection = new ca_collections($vn_artwork_id);
							$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
							$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
						

							if ($va_object_reps){
								foreach ($va_object_reps as $img_key => $va_object_rep) {
									if($vn_i < 4) {
										if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}
										print "<div class='exImage' {$vs_style}>".$va_object_rep."</div>";
										$vn_i++;
										$vn_ii++;
									}
								}
							}
						}
						print "<div class='exTitle'>".caNavLink($this->request, $va_event['name'], '', '', 'Detail', 'Occurrences/'.$va_event['idno'])."</div>";
						print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
						print "</div><!-- end occurrenceResult -->";
					}
					print "</div>";
				print "</div><!-- end blockResults -->";	
			print "</div><!-- end entitiesBlock -->";
		}	
	
		# Related Entities Block
		if (sizeof($va_entities) > 0) {
			print "<div id='entitiesBlock'>";
			print "<div class='blockTitle'>"._t('Related Entities')."</div>";
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
<?php
	}
?>	
</div>