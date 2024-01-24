<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
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
				<div class='col-md-8 col-lg-8'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
				</div><!-- end col -->
				<div class='col-md-4 col-lg-4'>
					<div id="detailTools">
						<?php
							print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("collection_id")))."</div>";					
							if ($vn_pdf_enabled) {
								print "<div class='detailTool'>".caDetailLink($this->request, "<span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
							}
						?>
					</div>
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

				<div class='col-md-12'>
					{{{<ifdef code="ca_collections.description"><div class="unit"><label>About</label>^ca_collections.description</div></ifdef>}}}
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

<?php
					if($t_item->get("source_id")){
						$vs_source_as_link = getSourceAsLink($this->request, $t_item->get("source_id"), null);
?>
						<div class="unit"><label>Contributor</label>
							<?php print $vs_source_as_link; ?>
						</div>
<?php
					}				
?>						

					{{{
						<ifdef code="ca_collections.date">
							<div class="unit"><label>Date</label>^ca_collections.date%delimiter=,_</div></ifdef>
					}}}
					{{{<ifdef code="ca_collections.RAD_extent"><div class="unit"><label>Extent</label>^ca_collections.RAD_extent%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_scopecontent"><div class="unit"><label>Scope and Content</label>^ca_collections.RAD_scopecontent</div></ifdef>}}}
					{{{<ifdef code="ca_collections.description"><div class="unit"><label>Description</label>^ca_collections.description</div></ifdef>}}}
					{{{<ifdef code="ca_collections.physical_description"><div class="unit"><label>Physical Description</label>^ca_collections.physical_description</div></ifdef>}}}

					{{{<ifdef code="ca_collections.historyUse"><div class="unit"><label>Administrative / Biographical History</label><span class="trimText"><unit relativeTo="ca_collections.historyUse" delimiter="<br/><br/>">^ca_collections.historyUse%convertLineBreaks=1</unit></span></div></ifdef>}}}
					{{{<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><label>System of Arrangement</label><span class="trimText">^ca_collections.RAD_arrangement%convertLineBreaks=1</span></div></ifdef>}}}

					{{{<ifcount code="ca_entities" min="1"><div class="unit"><label>Related Peopleand Organizations</label>
							<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div>
					</ifcount>}}}

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
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
					});
				</script>
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						$('.trimText').readmore({
						speed: 75,
						maxHeight: 120
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
