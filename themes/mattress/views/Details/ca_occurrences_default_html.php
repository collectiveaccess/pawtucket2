<?php
	$t_item = $this->getVar('item');
	$va_access_values = $this->getVar('access_values');
	#$t_item->dump();
	$this->request->session->setVar("repViewerResults", "");
	$va_object_results = array();
?>
<div id='detail' class='occurrences'>
	<div id='pageTitle'>
		<?php print ucwords($t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))); ?>
	</div>
	<div id='contentArea'>
		<div id='detailHeader'>

			<h2>
				{{{<unit>^ca_occurrences.preferred_labels.name</unit>}}}
<?php
				if ($va_curator = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('curator')))) {
					print "<span class='curator'>curator ".$va_curator."</span>";
				}
?>				
			</h2>
<?php
			print "<div class='detailSubtitle'>";
			if (($t_item->getTypeCode() == 'mf_exhibition') | ($t_item->getTypeCode() == 'external_exhibition')) {			
				print $t_item->get('ca_occurrences.event_dates', array('delimiter' => '<br/>'));
			}
			print "</div>"; 
		
?>
		</div>
		<div id='mediaArea' style="margin-left:-10px;">
<?php
	if (($t_item->getTypeCode() == 'mf_exhibition') | ($t_item->getTypeCode() == 'external_exhibition')) {
		$va_collections = $t_item->get('ca_collections', array('returnAsArray' => true, 'checkAccess' => $va_access_values));
		if (sizeof($va_collections) > 0) {
			print "<div class='mediaThumbs scrollBlock'>";
					print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
					$vn_i = 0;
					foreach ($va_collections as $collection_id => $va_collection) {
					
						$va_collection_id = $va_collection['collection_id'];
						$t_collection = new ca_collections($va_collection_id);
						
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true, 'excludeRelationshipTypes' => array('secondary', 'installation_view'), 'restrictToTypes' => array('image'), 'checkAccess' => $va_access_values));
						$va_installation_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('installation_view'), 'restrictToTypes' => array('image'), 'checkAccess' => $va_access_values));

						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('widepreview'), 'return' => array('tags', 'ids')));			
						$va_installation_reps = caGetPrimaryRepresentationsForIDs($va_installation_objects, array('versions' => array('widepreview'), 'return' => array('tags', 'ids')));			

						
						$va_artwork_title = $t_collection->get('ca_collections.preferred_labels');
						if ($t_collection->get('ca_collections.date.dc_dates_types') == "Date created") {
							$va_artwork_date = ", ".$t_collection->get('ca_collections.date.dates_value');
						}
						$va_artwork_artist = '<div class="materials">'.$t_collection->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'))).'</div>';
						$va_artwork_display = $va_artwork_artist.$va_artwork_title.$va_artwork_date;
						
						foreach ($va_installation_reps as $install_key => $va_installation_rep) {
							if ($vn_i == 0){print "<div class='imageSet'>";}
							print "<div class='rep' onmouseover='$(\".title{$install_key}\").show();' onmouseout='$(\".title{$install_key}\").hide();'>";
							
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $install_key, 'representation_id' => $va_installation_rep['representation_id']))."\"); return false;' ><div class='rep rep{$install_key}'>".$va_installation_rep['tags']."</div></a>";
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $install_key, 'representation_id' => $va_installation_rep['representation_id']))."\"); return false;' ><div style='display:none' class='title title{$install_key}'>Installation View</div></a>";
					
							print "</div>";
							$vn_i++;
							if ($vn_i == 3) {
								print "</div><!-- end imageSet-->";
								$vn_i = 0;
							}
							$va_object_results[] = array("object_id" => $object_key, "representation_id" => $va_artwork_rep['representation_id']);
							
						}						
						
						foreach ($va_object_reps as $object_key => $va_artwork_rep) {
							if ($vn_i == 0){print "<div class='imageSet'>";}
							print "<div class='rep' onmouseover='$(\".title{$object_key}\").show();' onmouseout='$(\".title{$object_key}\").hide();'>";
							#print caNavLink($this->request, "<div class='rep rep{$object_key}'>".$va_artwork_rep."</div>", '', '', 'Detail', 'Collections/'.$va_collection['collection_id']);
							#print caNavLink($this->request, "<div style='display:none' class='title title{$object_key}'>".$va_artwork_display."</div>", '', '', 'Detail', 'Collections/'.$va_collection['collection_id']);
							
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $object_key, 'representation_id' => $va_artwork_rep['representation_id']))."\"); return false;' ><div class='rep rep{$object_key}'>".$va_artwork_rep['tags']."</div></a>";
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $object_key, 'representation_id' => $va_artwork_rep['representation_id']))."\"); return false;' ><div style='display:none' class='title title{$object_key}'>".$va_artwork_display."</div></a>";
					
							print "</div>";
							$vn_i++;
							if ($vn_i == 3) {
								print "</div><!-- end imageSet-->";
								$vn_i = 0;
							}
							$va_object_results[] = array("object_id" => $object_key, "representation_id" => $va_artwork_rep['representation_id']);
							
						}
					}
					if ((end($va_collections) == $va_collection) && ($vn_i < 3) && ($vn_i != 0)){print "</div>";} 

					print "</div></div>";
			print "</div><!-- end mediaThumbs -->";
		}
	} else {
?>	
		
			<div class='mediaLarge'>
<?php
			$va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_related_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('medium', 'smallthumb')));
			
			$vn_rep_id = key($va_related_reps);
			$va_primary_rep = reset($va_related_reps);
			$va_primary_id = reset($va_related_objects);
			
			$va_media_thumbs_width = (775 - $va_primary_rep['info']['medium']['WIDTH']) - 20;
			$va_media_thumbs_height = $va_primary_rep['info']['medium']['HEIGHT'];
			$va_media_thumb_stack = floor(($va_media_thumbs_height - 20) / 90);
			
			if ($t_item->get('ca_objects.nonpreferred_labels.type_id') == '515') {
				$va_main_image_object = $t_item->get('ca_objects.nonpreferred_labels.name');				
			} else {
				$va_main_image_captions = $t_item->get('ca_objects.preferred_labels', array('returnAsArray' => true));
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
					
					print "<div class='smallrep'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $vn_related_rep_id, 'representation_id' => $va_related_rep['representation_id']))."\"); return false;' >".$va_related_rep['tags']['smallthumb']."</a></div>";
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
	}	
	$this->request->session->setVar("repViewerResults", $va_object_results);	
?>
			
		</div><!-- end mediaArea-->
		<div id='infoArea'>
<?php
		#if ($t_item->get('ca_occurrences.event_series.series_title')) {
		#	$va_series = $t_item->get('ca_occurrences.event_series.series_title', array('convertCodesToDisplayText' => true, 'template' => '^series_title (^series_types)'));
		#	print "<div class='description'><div class='metatitle'>"._t('Series')."</div>".$va_series."</div>";
		#}
		if (($vs_collection = $t_item->get('ca_occurrences.description', array('convertCodesToDisplayText' => true, 'template' => '^description_text'))) != "") {
			print "<div class='description'>";
			if (($t_item->getTypeCode() == 'mf_exhibition') | ($t_item->getTypeCode() == 'external_exhibition')){
				print "<div class='metatitle'>"._t('Description')."</div>";
			}
			print $vs_collection."</div>";
		}
		if (($vs_statement = $t_item->get('ca_occurrences.statement.statement_text', array('template' => '^statement_text'))) != "") {
			print "<div class='description'><div class='metatitle'>"._t('Artist Statement')."</div>".$vs_statement."</div>";
		}		
?>	

		</div><!-- end infoArea-->
	</div><!-- end contentArea-->
<?php
	$va_occurrences = $t_item->get('ca_occurrences', array('restrictToTypes' => array('mf_exhibition'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));
	$va_events = $t_item->get('ca_occurrences', array('restrictToTypes' => array('exhibition_event', 'educational', 'fundraising', 'admin_event', 'community_event'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_occurrences.preferred_labels'));
	$va_entities = $t_item->get('ca_entities', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('curator', 'contributor', 'artist'), 'checkAccess' => $va_access_values, 'sort' => 'ca_entities.preferred_labels.surname'));
	$va_funders = $t_item->get('ca_entities', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('funder'), 'checkAccess' => $va_access_values));
	$va_collections = $t_item->get('ca_collections', array('restrictToTypes' => array('installation'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.preferred_labels'));
	$va_objects = $t_item->get('ca_objects', array('excludeTypes' => array('image'), 'returnAsArray' => true, 'checkAccess' => $va_access_values));


	if ((sizeof($va_occurrences) > 0) | (sizeof($va_entities) > 0) | (sizeof($va_events) > 0) | (sizeof($va_collections) > 0) | (sizeof($va_funders) > 0) | (sizeof($va_objects) > 0)) {
?>	
	<div id='relatedInfo'>
<?php

		
	# Related Exhibitions Block
	if (sizeof($va_occurrences) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Exhibitions')."</div>";
			print "<div class='blockResults exhibitions'>";
				print "<div>";

				foreach ($va_occurrences as $occurrence_id => $va_occurrence) {
					$vn_occurrence_id = $va_occurrence['occurrence_id'];
					$t_occurrence = new ca_occurrences($vn_occurrence_id);
					$va_artworks = $t_occurrence->get('ca_collections.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values));
					
					
					print "<div class='occurrencesResult'>";
					$vn_ii = 0;
					if (sizeof($va_artworks) >= 4) {
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
					} else {
						$va_artwork_id = $va_artworks[0];
						$t_collection = new ca_collections($va_artwork_id);
						$va_related_objects = $t_collection->get('ca_objects.object_id', array('returnAsArray' => true));
						$va_object_reps = caGetPrimaryRepresentationsForIDs($va_related_objects, array('versions' => array('exsingle'), 'return' => array('tags')));
					
						if ($va_primary_rep = array_shift(array_values($va_object_reps))){
							print "<div class='exImageSingle' {$vs_style}>".caNavLink($this->request, $va_primary_rep, '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";

						}
						
					}
					print "<div class='exTitle'>".caNavLink($this->request, $va_occurrence['name'], '', '', 'Detail', 'Occurrences/'.$va_occurrence['occurrence_id'])."</div>";
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
		print "<div class='blockTitle related'>"._t('Participating Artists + Curators')."</div>";
			print "<div class='blockResults'>";
				print "<div class='scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
				$vn_i = 0;
				foreach ($va_entities as $entity_id => $va_entity) {
					$vn_entity_id = $va_entity['entity_id'];
					if ($vn_i == 0) {print "<div class='entitySet'>";}
					if ($va_entity['relationship_type_code'] == "curator") {
						$vs_curator = " (curator)";
					} else {
						$vs_curator = "";
					}
					print caNavLink($this->request, "<div class='entitiesResult'>".$va_entity['displayname']." {$vs_curator}</div>", '', '','Detail', 'Entities/'.$va_entity['entity_id']);
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_entities) == $va_entity) && ($vn_i < 5)){print "</div>";}								
				print "</div>"; 
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}
	# Related Funders Block
	if (sizeof($va_funders) > 0) {
		print "<div id='fundersBlock'>";
		print "<div class='blockTitle related'>"._t('Related Funders')."</div>";
			print "<div class='blockResults'>";
				print "<div>";
				$vn_i = 0;
				foreach ($va_funders as $funder_id => $va_funder) {
					$vn_funder_id = $va_funder['entity_id'];
					if ($vn_i == 0) {print "<div class='entitySet'>";}
					print caNavLink($this->request, "<div class='entitiesResult'>".$va_funder['displayname']."</div>", '', '','Detail', 'Entities/'.$va_funder['entity_id']);
					$vn_i++;
					if ($vn_i == 5) {
						print "</div>";
						$vn_i = 0;
					}
				}
				if ((end($va_funders) == $va_funder) && ($vn_i < 5)){print "</div>";}								
				print "</div>";
			print "</div><!-- end blockResults -->";	
		print "</div><!-- end entitiesBlock -->";
	}	
	# Related Events Block
	if (sizeof($va_events) > 0) {
		print "<div id='occurrencesBlock'>";
		print "<div class='blockTitle related'>"._t('Related Events')."</div>";
			print "<div class='blockResults scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
					$vn_i = 0;
					foreach ($va_events as $event_id => $va_event) {
						$vn_event_idno = $va_event['idno'];
						$vn_event_id = $va_event['occurrence_id'];
						$t_occurrence = new ca_occurrences($vn_event_id);

						if ($vn_i == 0) {print "<div class='eventSet'>";}
						print "<div class='eventsResult'>";
						print "<div>".caNavLink($this->request, $va_event['label'], '', '', 'Detail', 'Occurrences/'.$vn_event_id)."</div>";
						print "<div class='exDate'>".$t_occurrence->get('ca_occurrences.event_dates')."</div>";	

						print "</div>";
						$vn_i++;
						if ($vn_i == 5) {
							print "</div>";
							$vn_i = 0;
						}
					}
					if ((end($va_events) == $va_event) && ($vn_i < 5) && ($vn_i != 0)){print "</div>";}								

				print "</div></div>";	
			print "</div><!-- end blockResults -->";
		print "</div><!-- end occurrencesBlock-->";
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
		print "</div><!-- objectsBlock-->";
	}
	# Related Installation Block
	if (sizeof($va_collections) > 0) {
		print "<div id='collectionsBlock'>";
		print "<div class='blockTitle related'>"._t('Artworks Exhibited at the MF')."</div>";
			print "<div class='blockResults'>";
			print "<div class='scrollBlock'>";
				print "<div class='scrollingDiv'><div class='scrollingDivContent'>";
					$vn_i = 0;
					foreach ($va_collections as $collection_id => $va_collection) {
						$vn_collection_id = $va_collection['collection_id'];
						$t_collection = new ca_collections($vn_collection_id);

						if ($vn_i == 0) {print "<div class='collectionSet'>";}
						print "<div class='artworkResult'>";
						print "<div>".caNavLink($this->request, $va_collection['label'], '', '', 'Detail', 'Collections/'.$vn_collection_id)."</div>";
						print "</div>";
						$vn_i++;
						if ($vn_i == 5) {
							print "</div>";
							$vn_i = 0;
						}
					}
					if ((end($va_collections) == $va_collection) && ($vn_i < 5) && ($vn_i != 0)){print "</div>";}								

				print "</div></div>";	
				print "</div>";	
			print "</div><!-- end blockResults -->";
		print "</div><!-- end collectionsBlock-->";
	}	
?>		
	</div><!-- end relatedInfo-->
<?php
	}
?>	
</div>