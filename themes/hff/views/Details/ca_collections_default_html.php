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
	#$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

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
					<H4>{{{<ifdef code="ca_collections.fa_title">^ca_collections.fa_title</ifdef><ifnotdef code="ca_collections.fa_title">^ca_collections.preferred_labels</ifnotdef>}}}</H4>
					<H6>{{{^ca_collections.idno}}}{{{<ifdef code="ca_collections.fa_sponsor,ca_collections.idno">, </ifdef><ifdef code="ca_collections.fa_sponsor">^ca_collections.fa_sponsor</ifdef>}}}</H6>
					
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $t_item->get("ca_collections.collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
					{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><H6>Date</H6>^ca_collections.unitdate.dacs_date_text</div></ifdef>}}}
					{{{<ifdef code="ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
						<div class="unit">
							<H6>Extent</H6>
							<unit relativeTo="ca_collections" delimiter="<br/><br/>">
							<ifdef code="ca_collections.extentDACS.portion_label">^ca_collections.extentDACS.portion_label </ifdef><ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef><ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
							<ifdef code="ca_collections.extentDACS.container_summary"><br/>Container Summary: ^ca_collections.extentDACS.container_summary</ifdef>
							<ifdef code="ca_collections.extentDACS.physical_details"><br/>Physical Details: ^ca_collections.extentDACS.physical_details</ifdef>
							<ifdef code="ca_collections.extentDACS.extent_dimensions"><br/>Dimensions: ^ca_collections.extentDACS.extent_dimensions</ifdef>
							</div>
						</div>
					</ifdef>}}}
					{{{<ifcount code="ca_storage_locations">
						<div class="unit">
							<ifcount code="ca_storage_locations" min="1" max="1">
								<H6>Location</H6>
							</ifcount>
							<ifcount code="ca_storage_locations" min="2">
								<H6>Locations</H6>
							</ifcount>
							<unit relativeTo="ca_storage_locations.related" delimiter="<br/>">
								<unit relativeTo="ca_storage_locations.hierarchy" delimiter=" &gt; ">^ca_storage_locations.preferred_labels</unit>
							</unit>
						</div>
					</ifcount>}}}
					
					{{{<ifdef code="ca_collections.abstract"><div class="unit"><H6>Abstract</H6>^ca_collections.abstract</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict</div></ifdef>}}}
					
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
				<div class='col-md-12 col-lg-12'>
					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History</H6>^ca_collections.adminbiohist</div></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent</div></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><div class="unit"><H6>System of Arrangement</H6>^ca_collections.arrangement</div></ifdef>}}}
					{{{<ifdef code="ca_collections.govtuse"><div class="unit"><H6>Conditions Governing Use</H6>^ca_collections.govtuse</div></ifdef>}}}
					{{{<ifdef code="ca_collections.related_materials"><div class="unit"><H6>Related Materials</H6>^ca_collections.related_materials</div></ifdef>}}}
					{{{<ifdef code="ca_collections.acqinfo"><div class="unit"><H6>Provenance</H6>^ca_collections.acqinfo</div></ifdef>}}}
					{{{<ifdef code="ca_collections.fa_language"><div class="unit"><H6>Language of Description</H6>^ca_collections.fa_language</div></ifdef>}}}
					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><H6>Preferred Citation</H6>^ca_collections.preferCite</div></ifdef>}}}
					{{{<ifdef code="ca_collections.fa_author"><div class="unit"><H6>Finding Aid Author</H6>^ca_collections.fa_author</div></ifdef>}}}
					{{{<ifdef code="ca_collections.fa_date"><div class="unit"><H6>Finding Aid Date</H6>^ca_collections.fa_date</div></ifdef>}}}
					{{{<ifcount code="ca_entities.related" min="1" restrictToRelationshipTypes="creator,subject,source"><div class="unit"><H6>Creator Agent (Collective Access Agent)</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator,subject,source" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
					{{{<ifdef code="ca_collections.loc_agent.loc_agent_value"><div class="unit"><H6>Agents (LOC)</H6><unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.loc_agent.loc_agent_value</unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></div></ifdef>}}}
					
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id', 'sort' => 'Rank'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
