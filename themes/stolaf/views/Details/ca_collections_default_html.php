<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if(!$t_item->get("ca_collections.children.collection_id")){
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
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
				</div>
				<div class='col-sm-12 col-md-6 col-lg-6'>
<?php					
					print "<div class='exportCollection'>";
					if($vs_ead = $t_item->get("ca_collections.ead_file.url")){
						print "<a href='$vs_ead' target='_blank' class='btn btn-default'><span class='glyphicon glyphicon-download'></span> EAD Finding Aid</a>";
					}
					if ($vn_pdf_enabled) {
						print caDetailLink($this->request, "<span class='glyphicon glyphicon-download'></span> PDF Finding Aid", "btn btn-default", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
					}
					print "</div>";
					print "<div class='inquireButtonCollection'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";					
?>
				</div>
			</div>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					
					<h2>{{{^ca_collections.repository.repository_country}}}</h2>
					{{{<ifdef code="ca_collections.parent_id"><label>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></label></ifdef>}}}
<?php
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
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-<?php print ($vb_show_hierarchy_viewer) ? "7" : "12"; ?>'>
					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><label>Administrative/Biographical History</label>^ca_collections.adminbiohist%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.abstract"><div class="unit"><label>Abstract</label>^ca_collections.abstract%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><label>Scope and Content</label>^ca_collections.scopecontent%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_collections.unitdate" delimiter="<br/>"><ifdef code="ca_collections.unitdate.dacs_dates_labels">^ca_collections.unitdate.dacs_dates_labels: </ifdef>^ca_collections.unitdate.dacs_date_text <ifdef code="ca_collections.unitdate.dacs_dates_types">^ca_collections.unitdate.dacs_dates_types</ifdef></unit></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details">
						<div class="unit"><label>Extent</label>
							<unit relativeTo="ca_collections.extentDACS">
								<ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef>
								<ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
								<ifdef code="ca_collections.extentDACS.container_summary"><br/>^ca_collections.extentDACS.container_summary</ifdef>
								<ifdef code="ca_collections.extentDACS.physical_details"><br/>^ca_collections.extentDACS.physical_details</ifdef>
							</unit>
						</div>
					</ifdef>}}}
					
					{{{<if rule="^ca_collections.type_id =~ /Folder/"><ifcount code="ca_storage_locations" min="1"><div class="unit"><label>Location</label>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.hierarchy.preferred_labels%delimiter=_➔_</unit>
					</div></ifcount></if>}}}
				
					{{{<ifdef code="ca_collections.material_type"><div class="unit"><label>Material Format</label>^ca_collections.material_type%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.LcshSubjects"><div class="unit"><label>Subjects</label><unit relativeTo="ca_collections.LcshSubjects" delimiter="<br>">^ca_collections.LcshSubjects</unit></div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.relation"><div class="unit"><label>Related Collections</label>^ca_collections.relation%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><label>Restrictions</label>^ca_collections.accessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><label>Physical access</label>^ca_collections.physaccessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.LcshGenre|ca_collections.aat"><div class="unit"><label>Genres</label><unit delimiter="<br/>">^ca_collections.LcshGenre</unit><ifdef code="ca_collections.LcshGenre"><br/></ifdef><unit delimiter="<br/>">^ca_collections.aat</unit></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><label>Preferred citation</label>^ca_collections.preferCite%delimiter=,_</div></ifdef>}}}
									
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><label>Related person</label></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="ind"><label>Related people</label></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="ind" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
				
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><label>Related organization</label></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="org"><label>Related organizations</label></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="org" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
				
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><label>Related family</label></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="fam"><label>Related families</label></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="fam" delimiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>}}}
				
					<br/>{{{map}}}
				
				</div>
				
<?php
			if ($vb_show_hierarchy_viewer) {	
?>
				<div class='col-sm-5'>
					<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
					<script>
						$(document).ready(function(){
							$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
						})
					</script>
				</div><!-- end col -->
<?php				
			}									
?>				
			</div>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
