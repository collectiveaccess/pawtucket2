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
					<H2>{{{^ca_collections.preferred_labels.name}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></H6></ifdef>}}}

					{{{<ifdef code="ca_collections.public_notes"><div class="unit"><br/><p>^ca_collections.public_notes</p></div></ifdef>}}}
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><br/><p>^ca_collections.scopecontent</p></div></ifdef>}}}
					
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
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

{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<br/>
				<div id="browseResultsDetailContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsDetailContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'collection_objects', array('search' => 'collection_id:^ca_collections.collection_id', 'sort' => 'Rank', 'direction' => 'asc', 'showFilterPanel' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
//						jQuery('#browseResultsDetailContainer').jscroll({
//							autoTrigger: true,
//							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
//							padding: 20,
//							nextSelector: 'a.jscroll-next'
//						});
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
