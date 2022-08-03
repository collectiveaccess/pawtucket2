<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
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
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
<?php
					$vs_more_information_link = "";
					if($vs_more_information_link = $t_item->get("ca_collections.external_link.url_entry")){
						print "<div class='pull-right'><a href='".$vs_more_information_link."' target='_blank' class='btn btn-default btn-small' title='View Collection in ArchiveSpace'>More Information <i class='fa fa-external-link'></i></a></div>";
					}
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection pull-right'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}

					{{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier</label>^ca_collections.idno</div></ifdef>}}}
					{{{<ifdef code="ca_collections.alt_id"><div class="unit"><label>Alternate Identifier(s)</label>^ca_collections.alt_id%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.processing_status.collection_status|ca_collections.processing_status.process_date"><div class="unit"><label>Processing Status</label>^ca_collections.processing_status.collection_status<ifdef code="ca_collections.processing_status.process_date">, ^ca_collections.processing_status.process_date</ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_collections.repository.repository_location"><div class="unit"><label>Repository</label>^ca_collections.repository.repository_location<ifdef code="ca_collections.repository.repository_country">, ^ca_collections.repository.repository_country</ifdef></div></ifdef>}}}
					{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_collections.unitdate" delimiter="<br/>"><ifdef code="ca_collections.unitdate.dacs_dates_labels">^ca_collections.unitdate.dacs_dates_labels: </ifdef>^ca_collections.unitdate.dacs_date_text</unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.extentDACS.portion_label|ca_objects.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
						<div class="unit"><label>Extent</label>
							<unit relativeTo="ca_collections.extentDACS" delimiter="<br/>">
								<ifdef code="ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type">
									<ifdef code="ca_collections.extentDACS.portion_label">^ca_collections.extentDACS.portion_label: </ifdef>^ca_collections.extentDACS.extent_number<ifdef code="ca_collections.extentDACS.extent_type"> ^ca_collections.extentDACS.extent_type</ifdef><br/>
								</ifdef>
								<ifdef code="ca_collections.extentDACS.container_summary">Container Summary: ^ca_collections.extentDACS.container_summary<br/></ifdef>
								<ifdef code="ca_collections.extentDACS.physical_details">Physical Details: ^ca_collections.extentDACS.physical_details<br/></ifdef>
								<ifdef code="ca_collections.extentDACS.extent_dimensions">Dimensions: ^ca_collections.extentDACS.extent_dimensions<br/></ifdef>
							</unit>
						</div>
					</ifdef>}}}
<?php
				if ($va_entity_rels = $t_item->get('ca_entities_x_collections.relation_id', array('returnAsArray' => true))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_entities_x_collections($va_entity_rel);
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = $t_rel->get('ca_entities.preferred_labels');
					}
					print "<div class='unit'>";
					foreach ($va_entities_by_type as $va_type => $va_entity_id) {
						print "<h6>".$va_type."(s)</h6>";
						foreach ($va_entity_id as $va_key => $va_entity_link) {
							print "<div>".caNavLink($this->request, $va_entity_link, '', '', 'browse', 'collections', array('facet' => 'entity_facet', 'id' => $t_rel->get('ca_entities.entity_id')))."</div>";
						} 
					}
					print "</div>";
				}				
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
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
					{{{<ifdef code="ca_collections.abstract"><div class="unit"><label>Abstract</label>^ca_collections.abstract</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accruals"><div class="unit"><label>Accruals</label>^ca_collections.accruals</div></ifdef>}}}
					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><label>Administrative/Biographical History</label>^ca_collections.adminbiohist</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><label>Conditions Governing Access Statement</label>^ca_collections.accessrestrict</div></ifdef>}}}
					{{{<ifdef code="ca_collections.govtuse"><div class="unit"><label>Conditions Governing Reproductions and Use</label>^ca_collections.govtuse</div></ifdef>}}}
					{{{<ifdef code="ca_collections.custodhist"><div class="unit"><label>Provenance</label>^ca_collections.custodhist</div></ifdef>}}}
					{{{<ifdef code="ca_collections.altformavail"><div class="unit"><label>Existence and Location of Copies</label>^ca_collections.altformavail</div></ifdef>}}}
					{{{<ifdef code="ca_collections.originalsloc"><div class="unit"><label>Existence and Location of Originals</label>^ca_collections.originalsloc</div></ifdef>}}}
					{{{<ifdef code="ca_collections.general_notes"><div class="unit"><label>Notes</label>^ca_collections.general_notes</div></ifdef>}}}
					{{{<ifdef code="ca_collections.acqinfo"><div class="unit"><label>Immediate Source of Acquisition</label>^ca_collections.acqinfo</div></ifdef>}}}
					{{{<ifdef code="ca_collections.langmaterial"><div class="unit"><label>Languages and Scripts of Collection Materials</label>^ca_collections.langmaterial</div></ifdef>}}}
					{{{<ifdef code="ca_collections.otherfindingaid"><div class="unit"><label>Other Finding Aids</label>^ca_collections.otherfindingaid</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><label>Physical Access</label>^ca_collections.physaccessrestrict</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physical_description"><div class="unit"><label>Physical Description</label>^ca_collections.physical_description</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physfacet"><div class="unit"><label>Physical Facet</label>^ca_collections.physfacet</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physloc"><div class="unit"><label>Physical Location</label>^ca_collections.physloc</div></ifdef>}}}
					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><label>Preferred Citation</label>^ca_collections.preferCite</div></ifdef>}}}
					{{{<ifdef code="ca_collections.processInfo"><div class="unit"><label>Processing Information</label>^ca_collections.processInfo</div></ifdef>}}}
					{{{<ifdef code="ca_collections.publication_note"><div class="unit"><label>Publication Note</label>^ca_collections.publication_note</div></ifdef>}}}
					{{{<ifdef code="ca_collections.relation"><div class="unit"><label>Related Archival Materials</label>^ca_collections.relation</div></ifdef>}}}
					{{{<ifdef code="ca_collections.related_materials"><div class="unit"><label>Related Archival Materials</label>^ca_collections.related_materials</div></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><label>Scope and Content</label>^ca_collections.scopecontent</div></ifdef>}}}
					{{{<ifdef code="ca_collections.separated_materials"><div class="unit"><label>Separated Materials</label>^ca_collections.separated_materials</div></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><div class="unit"><label>System of Arrangement</label>^ca_collections.arrangement</div></ifdef>}}}
					{{{<ifdef code="ca_collections.techaccessrestrict"><div class="unit"><label>Technical Access</label>^ca_collections.techaccessrestrict</div></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects_all', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
