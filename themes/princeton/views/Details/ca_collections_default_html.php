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
	$va_access_values = $this->getVar("access_values");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	$vs_rep_viewer = 	trim($this->getVar("representationViewer"));
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
				<div class='col-sm-12 col-md-10'>
					<H1>{{{^ca_collections.preferred_labels.name}}}</H1>
				</div>
				<div class='col-sm-12 col-md-2 inquireCol'>
					<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id"))); ?>
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
					<HR>
				</div>
			</div>
			<div class="row">

<?php
			if($vs_rep_viewer){
?>
				<div class='col-sm-6 col-md-6 col-lg-5'>
					{{{representationViewer}}}
				</div>
				<div class='col-sm-6 col-md-6 col-lg-7'>
				
<?php
			}else{
?>
				<div class='col-sm-12'>
<?php
			}
?>
					<div class="unit"><b>{{{^ca_collections.type_id}}}</b></div>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}
<?php					
					if ($vn_pdf_enabled) {
						print "<div class='exportCollection'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> ".caDetailLink($this->request, "Download as PDF", "", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'))."</div>";
					}
?>
					{{{<ifdef code="ca_collections.idno"><div class="unit"><label>Identifier</label>^ca_collections.idno</div></ifdef>}}}
					{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="contributor,creator">
						<div class="unit"><label>Creator<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="contributor,creator">s</ifcount></label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="contributor,creator" delimiter="<br/>">
							<l>^ca_entities.preferred_labels.displayname</l>
						</unit>
					</div></ifcount>}}}
					{{{<ifdef code="ca_collections.date.sort_date|ca_collections.date.display_date">
						<div class="unit"><label>Date</label>
							<unit relativeTo="ca_collections.date" delimiter="<br/>">
								<ifdef code="ca_collections.date.date_display">^ca_collections.date.date_display</ifdef><ifnotdef code="ca_collections.date.date_display">^ca_collections.date.sort_date</ifnotdef><ifdef code="ca_collections.date.date_note">, ^ca_collections.date.date_note</ifdef>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.collection_contents"><div class="unit"><label>Collection Contents</label>^ca_collections.collection_contents</div></ifdef>}}}
					{{{<ifdef code="ca_collections.description">
						<div class='unit'><label>Description</label>
							<span class="trimText">^ca_collections.description</span>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.rights_container.rights|ca_collections.rights_container.access_conditions|ca_collections.rights_container.use_reproduction|ca_collections.credit|ca_collections.exhibition_publication">
						<hr/>
						<ifdef code="ca_collections.rights_container.rights"><div class="unit"><label>Rights Statement</label>^ca_collections.rights_container.rights</div></ifdef>
						<ifdef code="ca_collections.rights_container.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_collections.rights_container.use_reproduction</div></ifdef>
						<ifdef code="ca_collections.credit"><div class="unit"><label>Credit</label>^ca_collections.credit</div></ifdef>
						<ifdef code="ca_collections.exhibition_publication"><div class="unit"><label>Exhibition and Publication History</label>^ca_collections.exhibition_publication</div></ifdef>

					</ifdef>}}}
					{{{<ifcount code="ca_places" min="1">
						<div class="unit"><label>Related Place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="work">
						<div class="unit"><label>Related Work<ifcount code="ca_occurrences" min="2" restrictToTypes="work">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="work" delimiter="<br/>">
							<l>^ca_occurrences.preferred_labels.name</l>
						</unit>
					</div></ifcount>}}}
					{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor">
						<div class="unit"><label>Related <ifcount code="ca_entities" max="1" excludeRelationshipTypes="creator,contributor">Entity</ifcount><ifcount code="ca_entities" min="2" excludeRelationshipTypes="creator,contributor">Entities</ifcount></label>
						<unit relativeTo="ca_entities" excludeRelationshipTypes="creator,contributor" delimiter="<br/>">
							<l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)
						</unit>
					</div></ifcount>}}}
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
		$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("featured"), "limit" => 8));
		if(!$va_object_ids){
			$va_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "limit" => 8));
		}
		if(is_array($va_object_ids) && sizeof($va_object_ids)){
			$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
			if($qr_objects->numHits()){
?>
				<div class="row">
					<div class="col-sm-12">
						<br/><H2>Featured Object<ifcount code="ca_objects" min="2">s</ifcount></H2>
						<hr/>
					</div>
				</div>
				<div class="row featuredObjects">
<?php
				while($qr_objects->nextHit()){
					print "<div class='col-sm-3'>".$qr_objects->getWithTemplate("<l><div class='featuredObject'><div class='featuredObjectImage'>^ca_object_representations.media.medium</div><div class='featuredObjectsCaption'><small>^ca_objects.idno</small><br/>^ca_objects.preferred_labels<ifdef code='ca_objects.date.date_display|ca_objects.date.sort_date'><br/><ifdef code='ca_objects.date.date_display'>^ca_objects.date.date_display</ifdef><ifnotdef code='ca_objects.date.date_display'>^ca_objects.date.sort_date</ifnotdef></ifdef></div></l></div>")."</div>";
				}
?>					
				</div>
<?php
			}
		}
?>


{{{<ifcount code="ca_objects" min="9">
			<div class="row">
				<div class="col-sm-12 text-center">
					<?php print caNavLink($this->request, "Browse All Collection Objects", "btn btn-default", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
				</div>
			</div>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
