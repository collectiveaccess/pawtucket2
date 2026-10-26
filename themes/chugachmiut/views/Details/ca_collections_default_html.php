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
	if($t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)) == "Repository"){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$va_access_values = caGetUserAccessValues($this->request);
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
			if($vs_image = $t_item->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values))){
?>
				<div class="col-sm-2">
					<div class="collectionImage"><?php print $vs_image; ?></div>
				</div>
				<div class='col-sm-10'>
<?php			
			}else{
?>
				<div class="col-sm-12">
<?php
			}
?>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<hr/>
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator,contributor,author"><div class="unit"><label>Creators and Contributors</label>
									<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator,contributor,author"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
								</div></ifcount>}}}
					{{{<ifdef code="ca_collections.parent_id"><div class="unit"><label>Part of</label><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}

					{{{<ifdef code="ca_collections.summary">
						<div class='unit'><label>Summary</label>
							<span class="trimText">^ca_collections.summary</span>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.cultural_narrative">
						<div class='unit'><label>Cultural Narrative</label>
							<span class="trimText">^ca_collections.cultural_narrative</span>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.description">
						<div class='unit'><label>Description</label>
							<span class="trimText">^ca_collections.description</span>
						</div>
					</ifdef>}}}
				</div>
			</div>
			<div class="row">
			<div class="col-sm-12">
				<div class="container">
				<div class="row bgLightGray detailBottom">
					<div class="col-sm-12 col-md-3">
						{{{<ifdef code="ca_collections.date|ca_collections.date_note"><div class="unit"><label>Date</label>^ca_collections.date<ifdef code="ca_collections.date_note"><ifdef code="ca_collections.date">, </ifdef>^ca_collections.date_note</ifdef></div></ifdef>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><div class="unit"><label>Related Organizations</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><div class="unit"><label>Related People</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifdef code="ca_collections.language"><div class="unit"><label>Language</label>^ca_collections.language%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier</label>^ca_collections.idno</div></ifdef>}}}
					</div>
					{{{<ifdef code="ca_collections.content_warning|ca_collections.subjects|ca_collections.terms_container.term">
						<div class="col-sm-12 col-md-3">			
				
						<ifdef code="ca_collections.content_warning"><div class="unit warning"><unit relativeTo="ca_collections.content_warning" delimiter="<br/>">^ca_collections.content_warning</unit></div></ifdef>
						<ifdef code="ca_collections.subjects"><div class="unit"><label>Subjects</label>^ca_collections.subjects%delimiter=,_</div></ifdef>
						<ifdef code="ca_collections.terms_container.term"><div class="unit"><label>Related Terms</label><unit relativeTo="ca_collections.terms_container"><ifdef code="ca_collections.terms_container.term_link"><a href="^ca_collections.terms_container.term_link">^ca_collections.terms_container.term</a></ifdef><ifnotdef code="ca_collections.terms_container.term_link">^ca_collections.terms_container.term</ifnotdef></unit></div></ifdef>
						
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.rights|ca_collections.access_conditions|ca_collections.use_reproduction|ca_collections.source">
						<div class="col-sm-12 col-md-3">
							<ifdef code="ca_collections.rights"><div class="unit"><label>Rights</label>^ca_collections.rights</div></ifdef>
							<ifdef code="ca_collections.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_collections.access_conditions</div></ifdef>
							<ifdef code="ca_collections.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_collections.use_reproduction</div></ifdef>
							<ifdef code="ca_collections.source"><div class="unit"><label>Source</label>^ca_collections.source</div></ifdef>
						</div>
					</ifdef>}}}
					<div class="col-sm-12 col-md-3">
						{{{<ifcount min="1" code="ca_collections.related"><div class="unit"><label>Related Collections</label><unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></div></unit>}}}
						{{{<ifcount code="ca_places" min="1" restrictToTypes="community"><div class="unit"><label>Related Communities</label>
										<unit relativeTo="ca_places" delimiter="<br/>" restrictToTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_places" min="1" excludeTypes="community"><div class="unit"><label>Related Places</label>
										<unit relativeTo="ca_places" delimiter="<br/>" excludeTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						<div class="unit">{{{map}}}</div>
						
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
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
<?php
	if($t_item->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)) == "Repository"){
?>
	{{{<ifdef code="ca_collections.children.collection_id">
				<div class="row">
					<div class="col-sm-12">
						<H3>Collections</H3>
					</div>
				</div>
				<div class="row">
					<div id="browseResultsContainerCollections">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainerCollections -->
				</div><!-- end row -->
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#browseResultsContainerCollections").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('search' => 'ca_collections.parent_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
							jQuery('#browseResultsContainerCollections').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
					
					
					});
				</script>
	</ifdef>}}}
<?php	
	}
?>
	{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<H3>Heritage Items</H3>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'collection_facet', 'id' => '^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
