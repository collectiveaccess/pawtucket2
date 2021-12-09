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
					if ($vn_pdf_enabled) {
						print "<div class='detailButton'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $t_item->get("ca_collections.collection_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
					
?>
					<H1>{{{^ca_collections.type_id: ^ca_collections.preferred_labels.name}}}</H1>
<?php
					print "<div class='unit'><label>Part of</label>";
					if(strToLower($t_item->getWithTemplate("^ca_collections.parent.type_id")) != "collection"){
						print caNavLink($this->request, $t_item->getWithTemplate("<unit relativeTo='ca_collections.parent'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '>^ca_collections.preferred_labels.name</unit></unit>"), "", "", "Search",  "collections", array("search" => "ca_collections.parent_id:".$t_item->get("ca_collections.parent_id")));
					}else{
						print caNavLink($this->request, $t_item->getWithTemplate("<unit relativeTo='ca_collections.parent'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '>^ca_collections.preferred_labels.name</unit></unit>"), "", "", "Collections",  "Index");
					}
					print "</div>";
?>
	
					
					{{{<ifdef code="ca_collections.institutional_date.inclusive_date"><div class='unit'><b>^ca_collections.institutional_date.inclusive_date</b></div></ifdef>}}}
					{{{<ifdef code="ca_collections.scope_contents"><div class='unit'>^ca_collections.scope_contents</div></ifdef>}}}
					{{{<ifcount code="ca_list_items" min="1"><div class='unit'><label>Subjects</label><unit relativeTo="ca_list_items" delimiter="; " sort="ca_list_item_labels.name_singular">^ca_list_item_labels.name_singular</unit></div></ifcount>}}}				
				
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
				<div class="col-sm-12">
					<H2>^ca_objects._count Item<if rule='^ca_objects._count !~ /1/'>s</if></H2>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'related_collection_facet', 'id' => '^ca_collections.collection_id', 'dontSetFind' => true), array('dontURLEncodeParameters' => true)); ?>", function() {
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
