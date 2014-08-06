<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = $this->getVar('access_values');
?>

<div id="detail" class='objects'>
	<div class="blockTitle">{{{<unit>^ca_objects.type_id</unit>}}}
		<div class="detailNavBgLeft">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
	</div>	
	<div id="contentArea">
<?php	

		if($t_object->get('ca_objects.nonpreferred_labels.type_id') == '515') {
			print "<h2>".$t_object->get('ca_objects.nonpreferred_labels.name')."</h2>";
		} else {
			print "<h2>".$t_object->get('ca_objects.preferred_labels.name')."</h2>";
		}		
?>	
		
		
		<div id="mediaArea" style='margin:10px 0px 0px -10px;'>
<?php	
			if($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  == "Yes") {
				$va_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('image')));
				
				if (sizeof($va_objects) > 1) {
					print "<div class='mediaThumbs scrollBlock'>";
							print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
							$vn_i = 0;
							$va_object_reps = caGetPrimaryRepresentationsForIDs($va_objects, array('versions' => array('widepreview'), 'return' => array('tags')));			
						
							foreach ($va_object_reps as $object_key => $va_artwork_rep) {	
								if ($vn_i == 0){print "<div class='imageSet'>";}
								print "<div >";
								print caNavLink($this->request, "<div class='rep '>".$va_artwork_rep."</div>", '', '', 'Detail', 'Objects/'.$object_key);						
								print "</div>";
								$vn_i++;
								if ($vn_i == 3) {
									print "</div><!-- end imageSet-->";
									$vn_i = 0;
								}
						
							}
					
							if ((end($va_object_reps) == $va_artwork_rep) && ($vn_i < 3) && ($vn_i != 0)){print "</div>";} 

							print "</div></div>";
					print "</div><!-- end mediaThumbs -->";
				} else {
					$va_object_reps = caGetPrimaryRepresentationsForIDs($va_objects, array('versions' => array('mediumlarge'), 'return' => array('tags')));			
					foreach ($va_object_reps as $object_key => $va_artwork_rep) {	
						print "<div >";
						print caNavLink($this->request, "<div >".$va_artwork_rep."</div>", '', '', 'Detail', 'Objects/'.$object_key);						
						print "</div>";		
					}
				}
			} else {
				print $this->getVar('representationViewer');
			}
?>		
		</div>
<?php
		if ($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  == "Yes") {
			if ($va_description = $t_object->get('ca_objects.description.description_text')) {
				print "<div class='description' style='margin:30px 0px 20px 0px;'>".$va_description."</div>";
			}
		}
?>		
		<div id="detailTools">
			<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
			<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
			<!--<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div> -->
		</div><!-- end detailTools -->
		
		<div class='detailSubtitle'></div>
		
<?php
		if($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  != "Yes") {
		print '<div id="infoArea">';
		
			if ($t_object->get('ca_objects.idno')) {
				print "<div class='collectionHeading'>Identifier</div><p>".$t_object->get('ca_objects.idno')."</p>";
			}
			if ($t_object->get('ca_objects.date.dates_value')) {
				print "<div class='collectionHeading'>Date</div><p>".$t_object->get('ca_objects.date.dates_value')."</p>";
			}			
		}
?>				
			{{{<ifcount code="ca_objects.work_type" min="1"><div class='collectionHeading'>Type</div></ifdef><p><unit delimiter=", ">^ca_objects.work_type</p></unit>}}}
			{{{<ifdef code="ca_objects.dimensions.dimension_note"><div class='collectionHeading'>Dimensions</div><p>^ca_objects.dimensions.dimension_note</p></ifdef>}}}

<?php
			if (($va_description = $t_object->get('ca_objects.description.description_text')) && ($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  != "Yes")) {
				print "<div class='description'><div class='metatitle'>Description</div>".$va_description."</div>";
			}
?>			
		
			<div class="clearfix"></div>
<?php
		if($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  != "Yes") {			
			print "</div>";
		}
		if(($t_object->get('ca_objects.type_id') == 30) && ($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  == "Yes")) {
			$va_documents = $t_object->representationsOfClass('document', array('original'));
			foreach ($va_documents as $doc_id => $va_document) {
				print "<div class='lessonLink'><a href='".$va_document['urls']['original']."' class='downloadButton'>Download Lesson Plan</a></div>";
			}
		}

?>				
	</div><!-- contentArea -->
<?php
	$va_occurrences = $t_object->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));
	$va_entities = $t_object->get('ca_entities', array('returnAsArray' => true, 'checkAccess' => $va_access_values)); 
	$va_collections = $t_object->get('ca_collections', array('returnAsArray' => true, 'restrictToTypes' => array('installation'), 'checkAccess' => $va_access_values));
	
	if($t_object->get('ca_objects.lesson_plan', array('convertCodesToDisplayText' => true))  == "Yes") {
		$va_objects = $t_object->get('ca_objects', array('returnAsArray' => true, 'restrictToTypes' => array('limited_edition', 'av', 'document', 'anecdote'), 'checkAccess' => $va_access_values));
	} else {
		$va_objects = $t_object->get('ca_objects', array('returnAsArray' => true, 'restrictToTypes' => array('limited_edition', 'av', 'document', 'anecdote', 'image'), 'checkAccess' => $va_access_values));
	}
	
	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_collections) > 0) | (sizeof($va_objects) > 0)) {

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
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
				$vn_i = 0;
				foreach ($va_collections as $collection_id => $va_collection) {
					$va_collection_idno = $va_collection['idno'];
					$va_collection_id = $va_collection['collection_id'];
					$t_collection = new ca_collections($va_collection_id);
					$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
					$va_artwork_image = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags')));
					#if ($vn_i == 0) {print "<div class='collectionsSet'>";}
					print "<div class='collectionsResult'>";
							print caNavLink($this->request, "<div class='exImage' {$vs_style}>".array_shift(array_values($va_artwork_image))."</div>", '', '', 'Detail', 'Collections/'.$va_collection_id);
					print "<span style='padding-left:10px; display:block;'>".caNavLink($this->request, $va_collection['name'], '', '', 'Detail', 'Collections/'.$va_collection_idno)."</span>";
					print "</div>";
					#$vn_i++;
					#if ($vn_i == 5) {
					#	print "</div>";
					#	$vn_i = 0;
					#}
				}
				if ((end($va_collections) == $va_collection) && ($vn_i < 5)){print "</div>";}				
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
		print "<div class='blockTitle related'>"._t('Related Objects')."</div>";
			print "<div class='blockResults scrollBlock'>";
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
		print "</div><!-- objectsBlock-->";
	}	
	# Related Exhibitions Block
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults exhibitions scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true, 'restrictToTypes' => array('installation')));
					
					
					print "<div class='occurrencesResult' style='width:320px'>";
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
						print "<div class='exImageSingle'>".array_shift(array_values($va_object_reps))."</div>";
					}	
					print "<div class='exTitle'>".caNavLink($this->request, $va_occurrence['name'], '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
					print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	
					print "</div><!-- end occurrenceResult -->";
				}
				print "</div></div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end occurrencesBlock -->";
		}		
?>		
	</div><!-- end relatedInfo-->
<?php
	}
?>
</div><!-- end detail -->