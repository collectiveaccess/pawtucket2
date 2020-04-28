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
					<H4>{{{^ca_collections.preferred_labels.name}}}</H4>
					<H6>{{{^ca_collections.type_id}}}</H6>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}

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
					{{{<ifdef code="ca_collections.repository.repositoryName"><h6>Repository</h6>^ca_collections.repository.repositoryName <br/>^ca_collections.repository.repositoryLocation</ifdef>}}}
					{{{<ifdef code="ca_collections.material_type"><h6>Material Type</h6>^ca_collections.material_type</ifdef>}}}					
					{{{<ifdef code="ca_collections.unitdate"><H6>Date</H6><unit relativeTo="ca_collections.unitdate" delimiter="<br/>">^ca_collections.unitdate.dacs_date_value ^ca_collections.unitdate.dacs_dates_types</unit><br/></ifdev>}}}
					{{{<ifdef code="ca_collections.description"><H6>Description</H6>^ca_collections.description<br/></ifdef>}}}					
					{{{<ifdef code="ca_collections.extentDACS"><H6>Extent</H6>^ca_collections.extentDACS<br/></ifdev>}}}
					{{{<ifdef code="ca_collections.extent_units"><H6>Extent Units</H6>^ca_collections.extent_units<br/></ifdev>}}}
					
					{{{<ifcount code="ca_entities" min="1" ><H6>Creators</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>"><unit relativeTo="ca_entities" ><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit>}}}
					
					{{{<ifdef code="ca_collections.adminbiohist"><H6>Administrative/Biographical History</H6>^ca_collections.adminbiohist<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><H6>Scope and Content</H6>^ca_collections.scopecontent<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><H6>System of Arrangement</H6>^ca_collections.arrangement<br/></ifdef>}}}
				
					{{{<ifdef code="ca_collections.contents_list"><H6>Contents List</H6><span class="trimText">^ca_collections.contents_list</span><br/></ifdef>}}}

				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_collections.accessrestrict"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.physaccessrestrict"><H6>Physical Access</H6>^ca_collections.physaccessrestrict<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.techaccessrestrict"><H6>Technical Access</H6>^ca_collections.techaccessrestrict<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.reproduction"><H6>Conditions Governing Reproduction</H6>^ca_collections.reproduction<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.langmaterial"><H6>Languages and Scripts on the Material</H6>^ca_collections.langmaterial<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.otherfindingaid"><H6>Other Finding Aids</H6>^ca_collections.otherfindingaid<br/></ifdef>}}}	
					{{{<ifdef code="ca_collections.originalsloc"><H6>Existence and Location of Originals</H6>^ca_collections.originalsloc<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.altformavail"><H6>Existence and Location of Copies</H6>^ca_collections.altformavail<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.relation"><H6>Related Archival Materials</H6>^ca_collections.relation<br/></ifdef>}}}
					{{{<ifdef code="ca_collections.publication_note"><H6>Publication Note</H6>^ca_collections.publication_note<br/></ifdef>}}}
					
					{{{<ifdef code="ca_collections.lcsh_terms"><H6>LOC Terms</H6>^ca_collections.lcsh_terms%delimiter=,_ <br/></ifdef>}}}
					{{{<ifdef code="ca_collections.tgm"><H6>Thesaurus for Graphic Materials</H6>^ca_collections.tgm%delimiter=,_ <br/></ifdef>}}}
					{{{<ifdef code="ca_collections.lc_names"><H6>Library of Congress Name Authority File</H6>^ca_collections.lc_names%delimiter=,_ <br/></ifdef>}}}
					{{{<ifdef code="ca_collections.aat"><H6>Getty Art and Architecture Thesarus</H6>^ca_collections.aat%delimiter=,_ <br/></ifdef>}}}
					{{{<ifdef code="ca_list_items.preferred_labels"><H6>Subjects</H6>^ca_list_items.preferred_labels%delimiter=,_ <br/></ifdef>}}}
					
					{{{<ifcount code="ca_collections.related" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections.related" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections_x_collections"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
					

					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences_x_collections"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
	if ($t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true)) == 'File') {
?>			
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
<?php
	}
?>	
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
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
