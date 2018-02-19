<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row">
	<div class='col-xs-12 '>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
				<div class='detailNav'>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 ">
				<H4>{{{ca_occurrences.preferred_labels.name}}}</H4>
<?php				
				if ($vs_ex_dates = $t_item->get('ca_occurrences.exhibition_dates')) {
					print "<div>".$vs_ex_dates."</div>";
				}
?>								
			</div>		
		</div>
		<hr style='padding-bottom:5px;'>
		<div class="row">			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if ($vs_exhibition_types = $t_item->get('ca_occurrences.solo_group', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Type</h6>".$vs_exhibition_types."</div>";
				}
				if ($va_venue = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('venue')))){
					print "<div class='unit'><h6>Venue</h6>".$va_venue."</div>";
				}
				if ($va_rel_programs = $t_item->get('ca_occurrences.related.preferred_labels', array('restrictToTypes' => array('exhibition', 'public_program'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Programs</h6>".$va_rel_programs."</div>";
				}
				if ($va_related_or_history = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history')))) {
					print '<h6>Related Oral Histories</h6>';
					foreach ($va_related_or_history as $va_id => $va_related_or_history_id) {
						$t_rel_or = new ca_objects($va_related_or_history_id);
						print "<div class='detailLine'>";
						print "<p>".caDetailLink($this->request, $t_rel_or->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_or->get('ca_objects.object_id'))."</p>";
						print "</div>";
					}
				}				
								
?>
			</div><!-- end col -->
			<div class='col-md-6 col-lg-6'>
<?php
				if ($vs_description = $t_item->get('ca_occurrences.description')) {
					print "<div class='unit'>".$vs_description."</div>";
				}
				if ($va_remarks_images = $t_item->get('ca_occurrences.bibliography', array('returnWithStructure' => true, 'version' => 'medium'))) {
					foreach ($va_remarks_images as $vn_attribute_id => $va_remarks_image_info) {
						foreach ($va_remarks_image_info as $vn_value_id => $va_remarks_image) {
							print "<div class='unit' style='margin-bottom:20px;'>";

							$o_db = new Db();
							$t_element = ca_attributes::getElementInstance('bibliography');
							$vn_media_element_id = $t_element->getElementID('bibliography');							

							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_value_id, $vn_media_element_id)) ;
							if ($qr_res->nextRow()) {
								print "<div class='zoomIcon'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('id' => $t_item->get("occurrence_id"), 'context' => 'occurrences', 'identifier' => 'attribute:'.$qr_res->get("value_id"), 'overlay' => 1))."\"); return false;'><h6><i class='fa fa-file'></i> View Bibliography </h6></a></div>";
							}
							print "</div>";
						}
					}
				}
				if ($va_checklist_images = $t_item->get('ca_occurrences.checklist', array('returnWithStructure' => true, 'version' => 'medium'))) {
					foreach ($va_checklist_images as $vn_check_attribute_id => $va_checklist_image_info) {
						foreach ($va_checklist_image_info as $vn_check_value_id => $va_checklist_image) {
							print "<div class='unit' style='margin-bottom:20px;'>";

							$o_db = new Db();
							$t_check_element = ca_attributes::getElementInstance('checklist');
							$vn_check_media_element_id = $t_element->getElementID('checklist');							

							$qr_check_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_check_value_id, $vn_check_media_element_id)) ;
							if ($qr_check_res->nextRow()) {
								print "<div class='zoomIcon'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('id' => $t_item->get("occurrence_id"), 'context' => 'occurrences', 'identifier' => 'attribute:'.$qr_check_res->get("value_id"), 'overlay' => 1))."\"); return false;'><h6><i class='fa fa-file'></i> View Checklist </h6></a></div>";
							}
							print "</div>";
						}
					}
				}
				if ($vs_website = $t_item->get('ca_occurrences.exhibition_website')) {
					print "<div class='unit'><h6><i class='fa fa-external-link-square'></i> <a href='".$vs_website."' target='_blank'>View Website</a></h6></div>";
				}				
?>			
			</div><!-- end col -->
		</div><!-- end row -->
<?php		
		if ($va_related_archival = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('archival')))) {
			print "<hr><div class='row'><div class='col-sm-12'>";
			print '<h6 class="header">Related Archival Items</h6>';
			foreach ($va_related_archival as $va_key => $va_related_archival_id) {
				$t_archival = new ca_objects($va_related_archival_id);
				print "<div class='col-sm-2'> <div class='relatedArtwork' style='word-break: break-all;'>";
				print "<div class='relImg'>".caDetailLink($this->request, $t_archival->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</div>";
				print "<p>".caDetailLink($this->request, $t_archival->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_archival->get('ca_objects.object_id'))."</p>";
				print "</div></div>";
			}
			print "</div><!-- end col --></div><!-- end row -->";
		}	
?>				
{{{<ifcount code="ca_objects" min="1" restrictToTypes="sk_artwork,loaned_artwork">
			<hr>
			<h6>Related Artworks</h6>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'allworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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