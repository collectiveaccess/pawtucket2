<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id = $t_item->get('ca_collections.collection_id');
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

?>
<div class="row">
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<div class='detailNav'>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6>
<?php					
					if ($va_media = $t_item->get('ca_collections.finding_aid_upload', array('returnWithStructure' => true))) {
						$va_media = array_pop($va_media);
						foreach ($va_media as $vn_attribute_id => $va_media_info) {
							$t_attribute_values = new ca_attribute_values(array("attribute_id" => $vn_attribute_id));
							$vn_value_id = $t_attribute_values->get("value_id");
							print "<div class='exportCollection'>".caNavLink($this->request, "<span class='glyphicon glyphicon-file'></span> Download PDF", '', 'Detail', 'DownloadAttributeMedia', '', array('value_id' => $vn_value_id, "collection_id" => $vn_id, "id" => $vn_id, "subject_id" => $vn_id, "download" => 1, "version" => "original"));
							
						}
					} elseif ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
				<script>
					$(document).ready(function(){
						$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
					})
				</script>
<?php				
			} 							
?>				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
				
<?php				
					if ($va_dates = $t_item->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'returnWithStructure' => true))) {
						
						$va_unit_dates = array();
						foreach ($va_dates as $va_key => $va_dates_t) {
							foreach ($va_dates_t as $va_key => $va_date) {
								
								$va_unit_dates[$va_date['dacs_dates_types']][] = $va_date['dacs_date_value'];
							}
						}	
						foreach ($va_unit_dates as $va_date_type => $va_date_value){	
							print "<div class='unit'>";
							if ($va_date_type == " ") {
								print "<h6>Date</h6>";
							} else {
								print "<h6>".$va_date_type."</h6>";
							}
							foreach ($va_date_value as $va_date_date) {
								print $va_date_date;
							}
							print "</div>";
						}			
						
					}
					if ($vs_extent = $t_item->get('ca_collections.extentDACS')) {
						print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					} 
					if ($vs_access = $t_item->get('ca_collections.accessrestrict')) {
						print "<div class='unit'><h6>Conditions Governing Access</h6>".$vs_access."</div>";
					}
					if ($vs_repro = $t_item->get('ca_collections.reproduction')) {
						print "<div class='unit'><h6>Conditions Governing Reproduction</h6>".$vs_repro."</div>";
					}
					if ($vs_lang = $t_item->get('ca_collections.langmaterial')) {
						print "<div class='unit'><h6>Languages and Scripts on the Material</h6>".$vs_lang."</div>";
					}										
																
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php
					if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
						print "<div class='unit'><h6>Scope and Content</h6>".$vs_scope."</div>";
					}
					if ($vs_notes = $t_item->get('ca_collections.general_notes')) {
						print "<div class='unit'><h6>Notes</h6>".$vs_notes."</div>";
					}
					if ($vs_storage_location = $t_item->get('ca_storage_locations.hierarchy.preferred_labels', array('delimiter' => ' > '))) {
						print "<div class='unit'><h6>Location</h6>".$vs_storage_location."</div>";
					}	 
?>					
				</div><!-- end col -->
			</div><!-- end row -->
			<hr>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'archival', array('search' => 'collection_id:^ca_collections.collection_id', 'sort' => 'Relevance'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
