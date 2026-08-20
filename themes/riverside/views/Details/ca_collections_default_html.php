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
				print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("collection_id")))."</div>";
?>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $t_item->get("ca_collections.collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-12'>
					{{{<ifdef code="ca_collections.coverageDates"><div class="unit"><label>Coverage Dates</label>^ca_collections.coverageDates%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.coverageSpacial"><div class="unit"><label>Spacial Coverage</label>^ca_collections.coverageSpacial%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.extent_text"><div class="unit"><label>Extent</label>^ca_collections.extent_text%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><div class="unit"><label>Creators</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><label>Administrative/biographical history element</label>^ca_collections.adminbiohist%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.originals_location"><div class="unit"><label>Existence and Location of Originals</label>^ca_collections.originals_location%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><label>Scope and Content</label>^ca_collections.scopecontent%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.arrangement"><div class="unit"><label>System of Arrangement</label>^ca_collections.arrangement%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.see_also"><div class="unit"><label>See and See Also Notes</label>^ca_collections.see_also%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><label>Conditions governing access</label>^ca_collections.accessrestrict%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><label>Physcial access</label>^ca_collections.physaccessrestrict%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.techaccessrestrict"><div class="unit"><label>Technical access</label>^ca_collections.techaccessrestrict%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.reproduction_conditions"><div class="unit"><label>Conditions Governing Reproduction</label>^ca_collections.reproduction_conditions%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.langmaterials"><div class="unit"><label>Languages and Scripts of the Material</label>^ca_collections.langmaterials%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.otherfindingaid"><div class="unit"><label>Other Finding Aids</label>^ca_collections.otherfindingaid%convertLineBreaks=1</div></ifdef>}}}
					{{{<ifdef code="ca_collections.url.link_url"><div class="unit"><label>External Link</label><unit delimiter="<br/>"><a href="^ca_collections.url.link_url" target="_blank"><ifdef code="ca_collections.url.link_text">^ca_collections.url.link_text</ifdef><ifnotdef code="ca_collections.url.link_text">^ca_collections.url.link_url</ifnotdef></a></div></ifdef>}}}
					
<?php
					$va_LcshSubjects = $t_item->get("ca_collections.lcsh_terms", array("returnAsArray" => true));
					$va_all_subjects = array();
					if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
						foreach($va_LcshSubjects as $vs_LcshSubjects){
							$vs_lcsh_subject = "";
							if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
								$vs_LcshSubjects = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
							}
							$va_all_subjects[strToLower($vs_LcshSubjects)] = caNavLink($this->request, $vs_LcshSubjects, "", "", "Search", "objects", array("search" => $vs_LcshSubjects));
						
						}
					}
					
					$t_list_item = new ca_list_items;
					if($va_keywords = $t_item->get("ca_collections.internal_keywords", array("returnAsArray" => true))){
						foreach($va_keywords as $vn_kw_id){
							$t_list_item->load($vn_kw_id);
							$va_all_subjects[strToLower($t_list_item->get("ca_list_item_labels.name_singular"))] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), "", "", "Search", "objects", array("search" => $t_list_item->get("ca_list_item_labels.name_singular")));
						}
					}
					
					if(is_array($va_all_subjects) && sizeof($va_all_subjects)){
						ksort($va_all_subjects);
						$vs_keyword_links = join("<br/>", $va_all_subjects);
						print "<div class='unit'><label>Subjects/Keywords</label>".$vs_keyword_links."</div>";	
					}

?>
					
					{{{<ifcount code="ca_entities" excludeRelationshipTypes="creator" min="1"><div class="unit"><label>Related Entities</label><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
				
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
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12 text-right">
					<?php print caNavLink($this->request, 'Browse All Objects', 'btn btn-default', '', 'Browse', 'Objects', array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"), "sort" => "Date", "direction" => "asc")); ?>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id', 'sort' => 'Date', 'direction' => 'asc'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
