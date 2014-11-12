<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar('access_values');
	$this->request->session->setVar("repViewerResults", "");
	$va_object_results = array();
?>

<div id="detail" class="entities">
	<div id='pageTitle'>
<?php
	if ($t_item->get('ca_collections', array('restrictToRelationshipTypes' => 'artist'))) {
		print "Artist";
	} else {
		print $t_item->get('ca_entities.type_id');
	}
?>	
		<div class="detailNavBgLeft">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
	</div>
	<div id='contentArea'>
	
		<div id='detailHeader'>
			<h2>{{{^ca_entities.preferred_labels.displayname}}}</h2>
<?php	
		$va_subtitle = array();
		if ($t_item->get('ca_entities.nationality') != 211)	{$va_subtitle[] = $t_item->get('ca_entities.nationality', array('convertCodesToDisplayText' => true));}
		if ($t_item->get('ca_entities.vital_dates')) {$va_subtitle[] = $t_item->get('ca_entities.vital_dates');}
		
		print "<div class='detailSubtitle'>".join($va_subtitle, ', ')."</div>";
?>
		</div>
		
		<div id='mediaArea'>
<?php
		$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('artist')));
		if (sizeof($va_collections) > 0) {
			print "<div class='mediaThumbs scrollBlock'>";
					print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
					$vn_i = 0;
					foreach ($va_collections as $collection_id => $va_collection) {
					
						$va_collection_id = $va_collection['collection_id'];
						$t_collection = new ca_collections($va_collection_id);
						
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true, 'excludeRelationshipTypes' => array('secondary'), 'excludeTypes' => array('document'), 'checkAccess' => $va_access_values));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags', 'ids')));			
					
						$va_artwork_title = $t_collection->get('ca_collections.preferred_labels');
						if ($t_collection->get('ca_collections.date.dc_dates_types') == "Date created") {
							$va_artwork_date = ", ".$t_collection->get('ca_collections.date.dates_value');
						}
						#$va_artwork_materials = '<div class="materials">'.$t_collection->get('ca_collections.mat_tech_display').'</div>';
						$va_artwork_display = $va_artwork_title.$va_artwork_date;
						
						
						foreach ($va_object_reps as $object_key => $va_artwork_rep) {	
						
							if ($vn_i == 0){print "<div class='imageSet'>";}
							print "<div class='rep' onmouseover='$(\".title{$object_key}\").show();' onmouseout='$(\".title{$object_key}\").hide();'>";
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $object_key, 'representation_id' => $va_artwork_rep['representation_id']))."\"); return false;' ><div class='rep rep{$object_key}'>".$va_artwork_rep['tags']."</div></a>";
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $object_key, 'representation_id' => $va_artwork_rep['representation_id']))."\"); return false;' ><div style='display:none' class='title title{$object_key}'>".$va_artwork_display."</div></a>";

							print "</div>";
							$vn_i++;
							if ($vn_i == 2) {
								print "</div><!-- end imageSet-->";
								$vn_i = 0;
							} 
							$va_object_results[] = array("object_id" => $object_key, "representation_id" => $va_artwork_rep['representation_id']);
						}
					}
					if ((end($va_collections) == $va_collection) && ($vn_i < 2) && ($vn_i != 0)){print "</div>";} 

					print "</div></div>";
			print "</div><!-- end mediaThumbs -->";
		}
		$this->request->session->setVar("repViewerResults", $va_object_results);
?>		
		</div><!-- end mediaArea-->	
		
		<div id='infoArea'>
<?php
		if (($vs_collection = $t_item->get('ca_entities.biography.bio_text', array('convertCodesToDisplayText' => true))) != "") {
			print "<div class='description'><div class='metatitle'>"._t('Biography')."</div>".$vs_collection."</div>";
		}
?>	
		</div><!-- end infoArea-->
	
	</div><!-- end contentArea-->
	<?php	
	$va_occurrences = $t_item->get('ca_occurrences', array('returnAsArray' => true, 'restrictToTypes' => array('mf_exhibition'), 'checkAccess' => $va_access_values));
	$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true, 'restrictToTypes' => array('installation'), 'checkAccess' => $va_access_values));	
	$va_events = $t_item->get('ca_occurrences', array('returnAsArray' => true, 'restrictToTypes' => array('exhibition_event', 'educational', 'fundraising', 'admin_event', 'community_event'), 'checkAccess' => $va_access_values));
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'excludeRelationshipTypes' => array('partner')));
	$va_objects = $t_item->get('ca_objects', array('returnAsArray' => true, 'restrictToTypes' => array('limited_edition', 'av', 'document', 'anecdote', 'image'), 'checkAccess' => $va_access_values));
	

	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_events) > 0) | (sizeof($va_objects) > 0)) {
?>		
	<div id='relatedInfo'>

<?php
	# Related Installations Block
	if (sizeof($va_collections) > 0) {
		print "<div id='collectionsBlock'>";
		print "<div class='blockTitle related'>"._t('Artworks Exhibited at the MF')."</div>";
			print "<div class='blockResults scrollBlock entities'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
				$vn_i = 0;
				foreach ($va_collections as $collection_id => $va_collection) {
					$vn_collection_id = $va_collection['collection_id'];
					$t_collection = new ca_collections($vn_collection_id);
					
					if ($vn_i == 0) {print "<div class='collectionsSet entities'>";}
					print caNavLink($this->request, "<div class='collectionsResult'>".$va_collection['name'].", ".$t_collection->get('ca_collections.date.dates_value')."</div>", '', '','Detail', 'Collections/'.$va_collection['collection_id']);
					$vn_i++;
					if ($vn_i == 4) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_collections) == $va_collection) && ($vn_i < 4)){print "</div>";}								
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end collectionsBlock -->";
	}
		
	# Related Exhibitions Block
	$va_occurrences = $t_item->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults exhibitions scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true));
					
					
					print "<div class='occurrencesResult'>";
					$vn_ii = 0;
					$vn_i = 0;
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
				print "</div></div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}
	# Related Objects Block
	if (sizeof($va_objects) > 0) {
		foreach ($va_objects as $va_object_id => $va_object) {
			$vn_object_ids[] = $va_object['object_id'];
		}
		$qr_res = caMakeSearchResult('ca_objects', $vn_object_ids);
		
		print "<div id='objectsBlock'>";
		print "<div class='blockTitle related'>"._t('Related Materials')."</div>";
			print "<div class='blockResults exhibitions scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
				while ($qr_res->nextHit()) {
					print "<div class='objectsResult'>";
					print "<div class='objImage'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.resultthumb'), '', '', 'Detail', 'Objects/'.$qr_res->get('ca_objects.object_id'))."</div>";
					
					if($qr_res->get('ca_objects.nonpreferred_labels.type_id') == '515') {
						print "<h2>".$qr_res->get('ca_objects.nonpreferred_labels.name', array('returnAsLink' => true))."</h2>";
					} else {
						print "<h2>".$qr_res->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))."</h2>";
					}	

					print "</div>";
				}
				print "</div></div>";
			print "</div><!-- blockResults-->";
		print "</div><!-- blockTitle-->";
		print "</div><!-- occurrencesBlock-->";
	}
	# Related Events Block
	if (sizeof($va_events) > 0) {
		print "<div id='eventsBlock'>";
		print "<div class='blockTitle related'>"._t('Related Events')."</div>";
			print "<div class='blockResults scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";

				foreach ($va_events as $occurrence_id => $va_event) {
					$vn_occurrence_id = $va_event['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_objects = $t_occurrence->get('ca_objects.object_id', array('returnAsArray' => true));
					$va_object_reps = caGetPrimaryRepresentationsForIDs($va_objects, array('versions' => array('resultthumb'), 'return' => array('tags')));

				
					print "<div class='occurrencesResult'>";	
					print "<div class='exImage' {$vs_style}>".$va_object_reps[0]."</div>";
					print "<div class='exTitle'>".caNavLink($this->request, $va_event['name'], '', '', 'Detail', 'Occurrences/'.$va_event['occurrence_id'])."</div>";
					print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
					print "</div><!-- end occurrenceResult -->";
				}
				print "</div></div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}	
	
	# Related Entities Block
	if (sizeof($va_entities) > 0) {
		print "<div id='entitiesBlock'>";
		print "<div class='blockTitle related'>"._t('Related People')."</div>";
			print "<div class='blockResults'>";
				print "<div>";
				$vn_i = 0;
				foreach ($va_entities as $entity_id => $va_entity) {
					$vn_entity_id = $va_entity['entity_id'];
					if ($vn_i == 0) {print "<div class='entitiesSet'>";}
					print caNavLink($this->request, "<div class='entitiesResult'>".$va_entity['displayname']."</div>", '', '','Detail', 'Entities/'.$va_entity['entity_id']);
					$vn_i++;
					if ($vn_i == 4) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_entities) == $va_entity) && ($vn_i < 4)){print "</div>";}								
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}		
		

?>		
	</div><!-- end relatedInfo-->
<?php
	}
?>	
</div><!-- end detail -->


