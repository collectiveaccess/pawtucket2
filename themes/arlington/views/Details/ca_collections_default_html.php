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
				<div class='col-md-10 col-lg-10'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>					
					<!-- <H2>{{{^ca_collections.type_id}}}</H2> -->

					{{{<ifdef code="ca_collections.parent_id">
						<div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">
							<l>^ca_collections.preferred_labels.name</l></unit>
						</div>
					</ifdef>}}}

				</div><!-- end col -->
				<div class='col-md-2 col-lg-2'>
					<?php					
						if ($vn_pdf_enabled) {
							print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
						}
					?>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">

				<div class='col-md-6 col-lg-6'>

					<?php
						# --- image
						if($t_item->get('ca_collections.collection_still')){
							print "\n<div class='unit'><div>".$t_item->get('ca_collections.collection_still', array('version' => "medium", "showMediaInfo" => false))."</div>";
							if($t_item->get('ca_collections.collection_still_credit')){
								print "<div class='imageCaption'>"._t("Credit:")." ".$t_item->get('ca_collections.collection_still_credit')."</div>";
							}
							print "</div><!-- end unit -->";
						}
					?>

					{{{
						<ifdef code="ca_collections.idno"><div class="unit"><H6>Collection Number</H6>^ca_collections.idno</div></ifdef>
						<ifdef code="ca_collections.date"><div class="unit"><H6>Date(s)</H6>^ca_collections.date_created</div></ifdef>
						<!-- <ifdef code="ca_collections.description"><div class="unit"><H6>About</H6><span class="trimText">^ca_collections.description</span></div></ifdef> -->
						<ifdef code="ca_collections.biohist"><div class="unit"><H6>History</H6><span class="trimText">^ca_collections.biohist</span></div></ifdef>
						<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6><span class="trimText">^ca_collections.scopecontent</span></div></ifdef>
						<ifdef code="ca_collections.arrangement_description"><div class="unit"><H6>Arrangement and Description</H6><span class="trimText">^ca_collections.arrangement_description</span></div></ifdef>
						<ifdef code="ca_collections.collections_provenance"><div class="unit"><H6>Provenance</H6><span class="trimText">^ca_collections.collections_provenance</span></div></ifdef>
						<ifdef code="ca_collections.collection_restrictions"><div class="unit"><H6>Restrictions</H6><span class="trimText">^ca_collections.collection_restrictions</span></div></ifdef>
						<ifdef code="ca_collections.related_collections_text"><div class="unit"><H6>Related Collections</H6><span class="trimText">^ca_collections.related_collections_text</span></div></ifdef>
					}}}


					<?php
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

			<br/>

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

			</br>

			{{{<ifcount code="ca_objects" min="1">
				<h1>Related Objects</h1>
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





			
<!-- <div class='col-md-6 col-lg-6'>
	{{{<ifcount code="ca_collections.related" min="1" max="1"><label>Related collection</label></ifcount>}}}
	{{{<ifcount code="ca_collections.related" min="2"><label>Related collections</label></ifcount>}}}
	{{{<unit relativeTo="ca_collections_x_collections"><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.related.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
	
	{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
	{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
	{{{<unit relativeTo="ca_entities_x_collections"><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit>}}}
	
	{{{<ifcount code="ca_occurrences" min="1" max="1"><label>Related occurrence</label></ifcount>}}}
	{{{<ifcount code="ca_occurrences" min="2"><label>Related occurrences</label></ifcount>}}}
	{{{<unit relativeTo="ca_occurrences_x_collections"><unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}
	
	{{{<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>}}}
	{{{<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>}}}
	{{{<unit relativeTo="ca_places_x_collections"><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit> (^relationship_typename)</unit>}}}					
</div> -->
<!-- end col -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>