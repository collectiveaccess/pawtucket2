<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>

<div id="detail">
	<div class="blockTitle">{{{<unit>^ca_objects.type_id</unit>}}}
		<div class="detailNavBgLeft">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
	</div>	
	<div id="contentArea">
		<h2>{{{ca_objects.preferred_labels.name}}}</h2>
		<div class='detailSubtitle'></div>
		
		<div id="mediaArea">
		{{{representationViewer}}}
		</div>
		
		<div id="infoArea">
			{{{<ifdef code="ca_objects.description"><div class='description'><div class='metatitle'>Description</div>^ca_objects.description.description_text</ifdef></div>}}}
			<div class="clearfix"></div>
		</div>
	</div><!-- contentArea -->
<?php
	$va_occurrences = $t_object->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true));
	$va_entities = $t_object->get('ca_entities', array('returnAsArray' => true));
	$va_collections = $t_object->get('ca_collections', array('returnAsArray' => true, 'restrictToTypes' => array('installation')));
	
	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_collections) > 0)) {

?>	
	<div id='relatedInfo'>
<?php
	# Related Entities Block
	if (sizeof($va_entities) > 0) {
		print "<div id='entitiesBlock'>";
		print "<div class='blockTitle related'>"._t('Related People')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100%'>";
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
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}

	# Related Artworks Block
	if (sizeof($va_collections) > 0) {
		print "<div id='collectionsBlock'>";
		print "<div class='blockTitle related'>"._t('Related Installations')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
				$vn_i = 0;
				foreach ($va_collections as $collection_id => $va_collection) {
					$va_collection_idno = $va_collection['idno'];
					$va_collection_id = $va_collection['collection_id'];
					$t_collection = new ca_collections($va_collection_id);
					$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
					$va_artwork_image = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
					if ($vn_i == 0) {print "<div class='collectionsSet'>";}
					print "<div class='collectionsResult'>";
							print caNavLink($this->request, "<div class='exImage' {$vs_style}>".array_shift(array_values($va_artwork_image))."</div>", '', '', 'Detail', 'Collections/'.$va_collection_id);
					print "<div>".caNavLink($this->request, $va_collection['name'], '', '', 'Detail', 'Collections/'.$va_collection_idno)."</div>";
					print "</div>";
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_collections) == $va_collection) && ($vn_i < 5)){print "</div>";}				
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}
	
	# Related Exhibitions Block
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults exhibitions'>";
				print "<div style='width:100000px'>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true, 'restrictToTypes' => array('installation')));
					
					
					print "<div class='occurrencesResult' style='width:320px'>";
					$vn_ii = 0;
					$vn_i = 0;
					foreach ($va_artworks as $key => $vn_artwork_id) {
						$t_collection = new ca_collections($vn_artwork_id);
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
						
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
					print "<div class='exTitle'>".caNavLink($this->request, $va_occurrence['name'], '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
					print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
					print "</div><!-- end occurrenceResult -->";
				}
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end occurrencesBlock -->";
		}		
?>		
	</div><!-- end relatedInfo-->
<?php
	}
?>
</div><!-- end detail -->