<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);	
	
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
	<div class='col-xs-12 navButtons'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{nextLink}}}<span class='spacer'></span>{{{resultsLink}}} 
	</div><!-- end detailTop -->
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_collections.preferred_labels.name}}}{{{<ifcount code="ca_collections.unitdate.dacs_date_value" min="1"><unit><ifdef code="ca_collections.unitdate.dacs_date_value"><small>, ^ca_collections.unitdate.dacs_date_value</small></ifdef></unit></ifcount>}}}</H4>
					{{{<ifdef code="ca_collections.parent_id"><div class='collectionPath'><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download collection guide", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
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
					if ($vs_extent = $t_item->getWithTemplate('<unit relativeTo="ca_collections.extentDACS"><ifdef code="ca_collections.extentDACS.extent_value">^ca_collections.extentDACS.extent_value ^ca_collections.extentDACS.extent_type</ifdef></unit>')) {
						print "<div class='unit'><h6>Extent of Holdings</h6>".$vs_extent."</div>";
					}
					if ($vs_admin = $t_item->get('ca_collections.adminbiohist')) {
						print "<div class='unit'><h6>About</h6>".$vs_admin."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
						print "<div class='unit'><h6>Description</h6>".$vs_scope."</div>";
					}	
					if ($vs_subjects = $t_item->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Subjects</h6>".$vs_subjects."</div>";
					}
					if ($vs_tgm = $t_item->get('ca_collections.tgm', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Thesaurus for Graphic Materials</h6>".$vs_tgm."</div>";
					}
					if ($vs_lc = $t_item->get('ca_collections.lc_names', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Library of Congress Name Authority File</h6>".$vs_lc."</div>";
					}
					if ($vs_aat = $t_item->get('ca_collections.aat', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Getty Art and Architecture Thesarus</h6>".$vs_aat."</div>";
					}
					if ($vs_ca_list = $t_item->get('ca_list_items.preferred_labels', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>North West Subjects</h6>".$vs_ca_list."</div>";
					}					
					if ($vs_entities = $t_item->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit'><h6>Related People/Organizations</h6>".$vs_entities."</div>";
					}											
/*					if ($vs_repository = $t_item->getWithTemplate('<unit relativeTo="ca_collections.repository"><b> Repository Name:</b> ^ca_collections.repository.repositoryName <br/><b>Repository Location: </b>^ca_collections.repository.repositoryLocation</unit>')) {
						print "<div class='unit'><h6>Repository</h6>".$vs_repository."</div>";
					}
					if ($va_container = $t_item->get('ca_collections.container_info', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Container</h6>";
						foreach ($va_container as $va_key => $va_container_t) {
							foreach ($va_container_t as $va_key => $va_container) {
								if ($va_container['container']) {
									print "<b>Container: </b>".$va_container['container'].'; ';
								}
								if ($va_container['number']) {
									print "<b>Container Number: </b>".$va_container['number'].'; ';
								}
								if ($va_container['container_type']) {
									print "<b>Container Type: </b>".$va_container['container_type'];
								}																	
							}
						}
						print "</div>";
					}
					if ($vs_date = $t_item->getWithTemplate('<unit relativeTo="ca_collections.unitdate">^ca_collections.unitdate.dacs_date_value ^ca_collections.unitdate.dacs_dates_types</unit>')) {
						print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
					}	
					if ($vs_description = $t_item->get('ca_collections.description')) {
						print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
					}


*/																		
?>					
				</div><!-- end col -->
				<div class="col-sm-6">	
					<h6>Collection Guide</h6>
					<div class='unit'>There’s more! What you see here is only what is viewable online; in most cases it is only a small portion of what is available. Please visit the collection guide to find out more.</div>
				</div>
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row"><div class="col-sm-12">
			<br/><br/><hr/>
			<h4>Digitized Holdings</h4>
			<div class="row">
				
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			</div></div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
