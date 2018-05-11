<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values =		caGetUserAccessValues($this->request);
	$vn_item_id = $t_item->get("entity_id");
	$va_config_options = $this->getVar("config_options");
?>
<div class="row">
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div class='detailNav'>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 objectInfo">
<?php
					print "<div class='artistName'>".trim($t_item->get('ca_entities.preferred_labels'))."</div>";
					print "<div>";
					if ($vs_nationality = trim($t_item->get('ca_entities.nationality_text'))) {
						print $vs_nationality.", ";
					}
					if ($vs_lifespan = $t_item->get('ca_entities.entity_display_date')) {
						print $vs_lifespan;
					}
					print "</div>";					
?>				
					<hr></hr> 
				</div>		
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if($va_primary_rep = $t_item->getPrimaryRepresentation(array('version' => 'page'), null, array('return_with_access' => $va_access_values))){
						print "<div class='repViewerCont'>".$va_primary_rep["tags"]["page"]."</div>";
						print $t_item->getWithTemplate($va_config_options['representationViewerCaptionTemplate']);
					}
?>	
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_bio = $t_item->get('<unit relativeTo="ca_entities.biography"><if rule="^ca_objects.biography.display_bio =~ /yes/">^ca_entities.biography.bio_text</if></unit>')) {
						print $vs_bio;
					}					
?>					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
		#Related Artworks	
		if ($va_related_artworks = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork'), 'sort' => 'ca_object_labels.name'))) {
			$vs_art_count = 0;
			print '<div class="row objInfo">';
			print '	<div class="col-sm-12"><hr><h6 class="header">Artworks</h6></div>';
			foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
				$t_rel_obj = new ca_objects($va_related_artwork_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_obj->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
					$vs_art_image = caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
				} else {
					$vs_art_image = null;
				}
				print "<div class='relImg'>".($vs_art_image ? $vs_art_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>")."</div>";
				print "<div class='relArtTitle'><p>".$t_rel_obj->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, ( $t_rel_obj->get('ca_objects.preferred_labels') == "Untitled" ? $t_rel_obj->get('ca_objects.preferred_labels') : "<i>".$t_rel_obj->get('ca_objects.preferred_labels')."</i>"), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
				if ($vs_art_date = $t_rel_obj->get('ca_objects.display_date')) {
					print ", ".$vs_art_date;
				}
				print "</p></div></div>";
				print "</div><!-- end col -->";
				$vs_art_count++;
				if ($vs_art_count == 4) {
					break;
				}

			}
			if ($vs_art_count == 4) {
				print "<div class='viewAll'>".caNavLink($this->request, "View all <i class='fa fa-angle-right'></i>", '', '', 'Browse', 'allworks', array('facet' => 'entity_facet', 'id' => $vn_item_id))."</div>";
			}
			print "</div><!-- end row -->";			
		}		
		if ($vs_ext_link = $t_item->getWithTemplate('<ifcount min="1" code="ca_entities.external_link.url_entry"><unit relativeTo="ca_entities.external_link" delimiter=" "><ifdef code="ca_entities.external_link.url_entry"><div class="unit zoomIcon"><h6><i class="fa fa-external-link-square"></i> <a href="^ca_entities.external_link.url_entry">^ca_entities.external_link.url_source</a></h6></div></ifdef></unit></ifcount>')) {
			print "<div class='row'><div class='col-sm-12'><hr>".$vs_ext_link."</div></div>";
		}
		# Related Exhibitions
		if ($va_related_exhibitions = $t_item->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('exhibition', 'program'), 'sort' => 'ca_occurrences.exhibition_dates', 'sortDirection' => 'desc'))) {
			$va_ex_images = caGetDisplayImagesForAuthorityItems('ca_occurrences', $va_related_exhibitions, array('version' => 'iconlarge', 'relationshipTypes' => 'includes', 'objectTypes' => 'artwork', 'checkAccess' => $va_access_values));
			print "<div class='row relatedExhibitions'><div class='col-sm-12'><hr><h6 class='header'>Exhibitions and Programs</h6></div></div>";
			print "<div class='row'>";
			foreach ($va_related_exhibitions as $va_key => $va_related_exhibition_id) {
				$t_exhibition = new ca_occurrences($va_related_exhibition_id);
				print "<div class='col-sm-12'> <div class='relatedArtwork' style='margin-bottom:20px;'>";
				print "<p>".caDetailLink($this->request, "<i>".$t_exhibition->get('ca_occurrences.preferred_labels')."</i>", '', 'ca_occurrences', $t_exhibition->get('ca_occurrences.occurrence_id'))."</p>";
				print "<p>".$t_exhibition->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>'))."</p>";
				print "</div></div>";
			}
			print "</div><!-- end row -->";
		}				
		#Related Special Collections
		if ($va_related_collections = $t_item->get('ca_collections.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('record_group'), 'sort' => 'ca_collections.collection_rank'))) {
			print '<div class="row objInfo">';

			print '	<div class="col-sm-12"><hr><h6 class="header">Special Collections</h6></div>';
			foreach ($va_related_collections as $va_related_collection_id) {
				$t_rel_collection = new ca_collections($va_related_collection_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_collection->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values, 'primaryOnly' => true))) {
					$vs_image = caDetailLink($this->request, $t_rel_collection->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values, 'primaryOnly' => true)), '', 'ca_collections', $t_rel_collection->get('ca_collections.collection_id'));
				} else {
					$vs_image = null;
				}				
				print "<div class='relImg'>".caDetailLink($this->request, ($vs_image ? $vs_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>"), '', 'ca_collections', $t_rel_collection->get('ca_collections.collection_id'))."</div>";
				print "<p>".caDetailLink($this->request, $t_rel_collection->get('ca_collections.preferred_labels'), '', 'ca_collections', $t_rel_collection->get('ca_collections.collection_id'));
				print "</p></div>";
				print "</div><!-- end col -->";				
			}
			print "</div><!-- end row -->";			
		}
		#Related Archival Items
		if ($va_related_archival = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('archival')))) {
			$vs_archival_count = 0;
			print '<div class="row objInfo">';

			print '	<div class="col-sm-12"><hr><h6 class="header">Archival Items</h6></div>';
			foreach ($va_related_archival as $va_id => $va_related_archival_id) {
				$t_rel_archival = new ca_objects($va_related_archival_id);
				print "<div class='col-sm-3'>";
				print "<div class='relatedArtwork'>";
				if ($t_rel_archival->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
					$vs_archival_image = caDetailLink($this->request, $t_rel_archival->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'));
				} else {
					$vs_archival_image = null;
				}				
				print "<div class='relImg'>".caDetailLink($this->request, ($vs_archival_image ? $vs_archival_image : "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>"), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'))."</div>";
				print "<p>".$t_rel_archival->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
				print "<p>".caDetailLink($this->request, $t_rel_archival->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_archival->get('ca_objects.object_id'));
				print "</p></div>";
				print "</div><!-- end col -->";
				$vs_archival_count++;
				if ($vs_archival_count == 4) {
					break;
				}				
			}
			if ($vs_archival_count == 4) {
				print "<div class='viewAll'>".caNavLink($this->request, "View all <i class='fa fa-angle-right'></i>", '', '', 'Browse', 'archival', array('facet' => 'rel_entity_facet', 'id' => $vn_item_id))."</div>";
			}	
			print "</div><!-- end row -->";			
		}
		#Related Oral Histories
		if ($va_related_or_history = array_unique($t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history'))))) {
			print '<div class="row objInfo">';
			print '<div class="col-sm-12"><hr><h6 class="header">Oral Histories</h6>';
			foreach ($va_related_or_history as $va_id => $va_related_or_history_id) {
				$t_rel_or = new ca_objects($va_related_or_history_id);
				print "<p>".caNavLink($this->request, $t_rel_or->get('ca_objects.preferred_labels'), '', 'Detail', 'oralhistory', $t_rel_or->get('ca_objects.object_id'))."</p>";
			}
			print "</div></div>";
		}
											
?>			
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>