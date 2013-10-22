<?php
	$t_item = $this->getVar('item');
	#$t_item->dump();
	
#	print_R(caGetPrimaryRepresentationsForIDs(array(4), array('return' => 'tags', 'versions' => 'icon')));
?>
<div id='pageArea'>
	<div id='pageTitle'>
		<?php print $t_item->get('type_id', array('convertCodesToDisplayText' => true)); ?>
	</div>
	<div id='contentArea'>
		<div id='detailHeader'>
<?php	
			print "<h2>".$t_item->get('ca_objects.preferred_labels.name')."</h2>"; 
			print "<div class='detailSubtitle'>".$t_item->get('ca_objects.creation_date')."</div>"; 
?>
		</div>
		<div id='mediaArea'>
			<div class='mediaLarge'>
<?php
			$va_rep = $t_item->getPrimaryRepresentation(array('large'));
			print $va_rep['tags']['large'];
?>			
			</div>
			<div class='mediaThumbs'>
			
			</div>
		</div><!-- end mediaArea-->
		<div id='infoArea'>
<?php
		if (($vs_description = $t_item->get('ca_objects.description', array('convertCodesToDisplayText' => true, 'template' => '^description_text'))) != "") {
			print "<div class='description'><div class='title'>"._t('Description')."</div>".$vs_description."</div>";
		}
?>	
	
		</div><!-- end infoArea-->
	</div><!-- end contentArea-->
<?php
	$va_occurrences = $t_item->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true));
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true));
	$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true, 'restrictToTypes' => array('installation')));
	
	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_collections) > 0)) {

?>	
	<div id='relatedInfo'>
	<div id='sortMenu'>
		<span>Sort by: <a href='#'>has media</a> / <a href='#'>date</a> / <a href='#'>title</a></span>
	</div>
<?php
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

	# Related Artworks Block
	if (sizeof($va_collections) > 0) {
		print "<div id='collectionsBlock'>";
		print "<div class='blockTitle'>"._t('Related Installations')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";
				$vn_i = 0;
				foreach ($va_collections as $collection_id => $va_collection) {
					$va_collection_idno = $va_collection['idno'];
					$va_collection_id = $va_collection['collection_id'];
					$t_collection = new ca_collections($va_collection_id);
					$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
					$va_artwork_image = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
					if ($vn_i == 0) {print "<div class='collectionSet'>";}
					print "<div class='collectionResult'>";
						if ($va_artwork_rep = array_shift(array_values($va_artwork_image))){
							print "<div class='exImage' {$vs_style}>".$va_artwork_rep."</div>";

						}
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
		print "<div class='blockTitle'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults'>";
				print "<div style='width:100000px'>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true, 'restrictToTypes' => array('installation')));
					
					
					print "<div class='occurrenceResult' style='width:320px'>";
					$vn_ii = 0;
					$vn_i = 0;
					foreach ($va_artworks as $key => $vn_artwork_id) {
						$t_collection = new ca_collections($vn_artwork_id);
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
						
						if ($vn_ii % 2 == 0){$vs_style = "style='margin-right:10px;'";} else {$vs_style = "";}

						if ($va_primary_rep = array_shift(array_values($va_object_reps))){
							print "<div class='exImage' {$vs_style}>".$va_primary_rep."</div>";
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
		print "</div><!-- end occurrencesBlock -->";
	}		
?>		
	</div><!-- end relatedInfo-->
<?php
}
?>	
</div>