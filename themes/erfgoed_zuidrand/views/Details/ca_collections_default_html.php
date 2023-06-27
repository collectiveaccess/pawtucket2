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
	$vs_map = trim($this->getVar("map"));
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
<?php
				if($vs_map){
					print "<div class='col-md-8 col-lg-8'>";
				}else{
					print "<div class='col-md-12 col-lg-12'>";
				}
?>					
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<div class="unit"><label>{{{^ca_collections.type_id}}}</label></div>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit"><label>Onderdeel van: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></label></div></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file'></span> ".caDetailLink($this->request, _t("Download as PDF"), "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
					{{{<ifdef code="ca_collections.external_link.url_entry"><unit relativeTo="ca_collections" delimiter="<br/>"><div class="unit"><a href="^ca_collections.external_link.url_entry"><ifdef code="ca_collections.external_link.url_source">^ca_collections.external_link.url_source</ifdef><ifnotdef code="ca_collections.external_link.url_source">^ca_collections.external_link.url_entry</ifnotdef></a> <i class="fa fa-external-link"></i></div></unit></ifdef>}}}
					{{{<ifdef code="ca_collections.collection_description"><div class="unit">^ca_collections.collection_description</div></ifdef>}}}
					{{{<ifdef code="ca_collections.institution"><div class="unit"><label>Instituut</label>^ca_collections.institution</div></ifdef>}}}
					{{{<ifdef code="ca_collections.archived_by"><div class="unit"><label>Archiefvormer</label>^ca_collections.archived_by</div></ifdef>}}}
					{{{<ifdef code="ca_collections.collection_size.physical_or_logical_size"><div class="unit"><label>Omvang van de beschrijvingseenheid</label>^ca_collections.collection_size.physical_or_logical_size ^ca_collections.collection_size.collection_medium</div></ifdef>}}}
					
					
					
					
					{{{<ifcount code="ca_collections.related" min="1">
							<ifcount code="ca_collections.related" min="1" max="1"><label>Collectie</label></ifcount>
							<ifcount code="ca_collections.related" min="2"><label>Collecties</label></ifcount>
							<unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>
					</ifcount>}}}
<?php
				print '<div id="detailTools">';
				print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, _t("Inquire About This Collection"), "", "", "Contact",  "form", array('table' => 'ca_collections', 'id' => $t_item->get("ca_collections.collection_id")))."</div>";
					
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span><?php print _t("Comments"); ?> (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					
				}
				print '</div><!-- end detailTools -->';			
?>
					

				</div><!-- end col -->
<?php
				if($vs_map){
					print "<div class='col-md-4 col-lg-4'>".$vs_map."</div>";
				}
?>
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
{{{
		<ifdef code="ca_collections.children.collection_id" min="1">
			<div class="row">
				<div class="col-sm-12"><H2>Subcollecties</H2></div>
			</div>
			<div class="row">
				<div id="browseResultsCollectionContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsCollectionContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('view' => 'list', 'search' => 'ca_collections.parent_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsCollectionContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
		</ifdef>
}}}
{{{
		
			<div class="row">
				<div class="col-sm-12"><H2>Objecten</H2></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('view' => 'images', 'facet' => 'collection_facet', 'id' => '^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
