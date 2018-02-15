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
					print trim($t_item->get('ca_entities.preferred_labels'))."<br/>";
					if ($vs_nationality = $t_item->get('ca_entities.nationality_text')) {
						print $vs_nationality.", ";
					}
					if ($vs_lifespan = $t_item->get('ca_entities.entity_display_date')) {
						print $vs_lifespan;
					}					
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
							
					if ($va_related_or_history = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history')))) {
						print '<div class="unit"><h6>Related Oral Histories</h6>';
						foreach ($va_related_or_history as $va_id => $va_related_or_history_id) {
							$t_rel_or = new ca_objects($va_related_or_history_id);
							print "<div class='detailLine'>";
							print "<p>".caDetailLink($this->request, $t_rel_or->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_or->get('ca_objects.object_id'))."</p>";
							print "</div>";
						}
						print "</div>";
					}	
					if ($va_related_library = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('library')))) {
						print '<div class="unit"><h6>Related Library Items</h6>';
						foreach ($va_related_library as $va_id => $va_related_library_id) {
							$t_rel_lib = new ca_objects($va_related_library_id);
							print "<div class='detailLine'>";
							print "<p>".caDetailLink($this->request, $t_rel_lib->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_lib->get('ca_objects.object_id'))."</p>";
							print "</div>";
						}
						print "</div>";
					}									
?>				
				</div><!-- end col -->
			</div><!-- end row -->
<?php
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
			if ($va_related_archival = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('archival')))) {
				print "<hr><div class='row'><div class='col-sm-12'>";
				print '<h6 class="header">Related Archival Items</h6>';
				foreach ($va_related_archival as $va_key => $va_related_archival_id) {
					$t_archival = new ca_objects($va_related_archival_id);
					print "<div class='col-sm-3'> <div class='relatedArtwork'>";
					print "<div class='relImg'>".caDetailLink($this->request, $t_archival->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</div>";
					print "<p>".caDetailLink($this->request, $t_archival->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</p>";
					print "</div></div>";
				}
				print "</div><!-- end col --></div><!-- end row -->";
			}			
?>
			
{{{<ifcount code="ca_objects" min="1">
			<hr>
			<h6>Related Artworks</h6>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'allworks', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
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