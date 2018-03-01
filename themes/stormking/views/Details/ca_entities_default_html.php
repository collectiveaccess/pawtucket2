<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
					if ($vs_nationality = $t_item->get('ca_entities.nationality_text')) {
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
					<div style='padding-left:15px;'>
					{{{representationViewer}}}		
					</div>	
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_remarks_images = $t_item->get('ca_entities.bibliography', array('returnWithStructure' => true, 'version' => 'medium'))) {
						foreach ($va_remarks_images as $vn_attribute_id => $va_remarks_image_info) {
							foreach ($va_remarks_image_info as $vn_value_id => $va_remarks_image) {
								print "<div class='unit' style='margin-bottom:20px;'>";

								$o_db = new Db();
								$t_element = ca_attributes::getElementInstance('bibliography');
								$vn_media_element_id = $t_element->getElementID('bibliography');							

								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_value_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<div class='zoomIcon'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('id' => $t_item->get("entity_id"), 'context' => 'entities', 'identifier' => 'attribute:'.$qr_res->get("value_id"), 'overlay' => 1))."\"); return false;'><h6>View Bibliography <i class='fa fa-file'></i></h6></a></div>";
								}
								print "</div>";
							}
						}
					}
?>					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			# Related Exhibitions
			if ($va_related_exhibitions = $t_item->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('exhibition', 'program')))) {
				$va_ex_images = caGetDisplayImagesForAuthorityItems('ca_occurrences', $va_related_exhibitions, array('version' => 'iconlarge', 'relationshipTypes' => 'includes', 'objectTypes' => 'artwork', 'checkAccess' => $va_access_values));
				print "<hr><div class='row'><div class='col-sm-12'>";
				print '<h6 class="header">Related Exhibitions and Programs</h6>';
				foreach ($va_related_exhibitions as $va_key => $va_related_exhibition_id) {
					$t_exhibition = new ca_occurrences($va_related_exhibition_id);
					print "<div class='col-sm-3'> <div class='relatedArtwork'>";
					print "<div class='relImg'>".caDetailLink($this->request, $va_ex_images[$va_related_exhibition_id], '', 'ca_occurrences', $t_exhibition->get('ca_occurrences.occurrence_id'))."</div>";
					print "<p>".caDetailLink($this->request, $t_exhibition->get('ca_occurrences.preferred_labels'), '', 'ca_occurrences', $t_exhibition->get('ca_occurrences.occurrence_id'))."</p>";
					print "<p>".$t_exhibition->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>'))."</p>";
					print "</div></div>";
				}
				print "</div><!-- end col --></div><!-- end row -->";
			}
			#Related Artworks
			if ($va_related_artworks = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork')))) {
				print "<hr><div class='row'><div class='col-sm-12'>";
				print '<h6 class="header">Related Artworks</h6>';
				foreach ($va_related_artworks as $va_key => $vn_related_artwork_id) {
					$t_artwork = new ca_objects($vn_related_artwork_id);
					print "<div class='col-sm-3'> <div class='relatedArtwork bResultItem'>";
					if ($t_artwork->get('ca_object_representations.media.medium')) {
						print "<div class='relImg bResultItemContent'><div class='text-center bResultItemImg'>".caDetailLink($this->request, $t_artwork->get('ca_object_representations.media.medium'), '', 'ca_objects', $t_artwork->get('ca_objects.object_id'))."</div></div>";
					} else {
						print "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
					}
					print "<div class='bResultItemText'>";
					print "<p><i>".caDetailLink($this->request, $t_artwork->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_artwork->get('ca_objects.object_id'))."</i>";
					if ($vs_art_date = $t_artwork->get('ca_objects.display_date')) {
						print ", ".$vs_art_date;
					}
					print "</p></div>";
					print "</div></div>";
				}
				print "</div><!-- end col --></div><!-- end row -->";
			}
			#Related Archival
			if ($va_related_archival = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('archival')))) {
				print "<hr><div class='row'><div class='col-sm-12'>";
				print '<h6 class="header">Related Archives</h6>';
				foreach ($va_related_archival as $va_key => $vn_related_archival_id) {
					$t_archival = new ca_objects($vn_related_archival_id);
					print "<div class='col-sm-3'> <div class='relatedArtwork bResultItem'>";
					print "<div class='relImg bResultItemContent'><div class='text-center bResultItemImg'>".caDetailLink($this->request, $t_archival->get('ca_object_representations.media.medium'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</div></div>";
					print "<p>".caDetailLink($this->request, $t_archival->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</p>";
					print "</div></div>";
				}
				print "</div><!-- end col --></div><!-- end row -->";
			}	
			#Related Oral History
			if ($va_related_oralh = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history')))) {
				print "<hr><div class='row'><div class='col-sm-12'>";
				print '<h6 class="header">Related Oral History</h6>';
				foreach ($va_related_oralh as $va_key => $vn_related_oralh_id) {
					$t_oralh = new ca_objects($vn_related_oralh_id);
					print "<div class='col-sm-3'> <div class='relatedArtwork bResultItem'>";
					print "<div class='relImg bResultItemContent'><div class='text-center bResultItemImg'>".caDetailLink($this->request, $t_oralh->get('ca_object_representations.media.medium'), '', 'ca_objects', $t_oralh->get('ca_objects.object_id'))."</div></div>";
					print "<p>".caDetailLink($this->request, $t_oralh->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_oralh->get('ca_objects.object_id'))."</p>";
					print "</div></div>";
				}
				print "</div><!-- end col --></div><!-- end row -->";
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