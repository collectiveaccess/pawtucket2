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
	$va_access_values = caGetUserAccessValues($this->request);
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	
	$vb_bottom_box = false;
	if($t_item->get("ca_entities.entity_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
	if($t_item->get("ca_occurrences.occurrence_id", array("checkAccess" => $va_access_values))){
		$vb_bottom_box = true;
	}
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
				<div class='col-sm-12 col-md-7'>
					<H1>{{{^ca_collections.preferred_labels.name<ifdef code="ca_collections.date_container.date"><unit relativeTo="ca_collections.date_container" delimiter=", "><if rule="^ca_collections.date_container.date_type =~ /Created/">, ^ca_collections.date_container.date</if></unit></ifdef>}}}</H1>
					<H2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H2>
					{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></div></ifdef>}}}

				</div>
				<div class='col-sm-12 col-md-5 inquireCol'>
					<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id"))); ?>
<?php					
					if ($vn_pdf_enabled) {
						print " ".caDetailLink($this->request, "<span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span> Download as PDF", "btn btn-default", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
					}
?>
				</div>
			</div>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					{{{<ifdef code="ca_collections.date_container.date"><div class="unit"><label>Date</label><unit relativeTo="ca_collections.date_container" delimiter="<br/>"><ifdef code="ca_collections.date_container.date_type">^ca_collections.date_container.date_type </ifdef>^ca_collections.date_container.date<ifdef code="ca_collections.date_container.date_certainty"> (^ca_collections.date_container.date_certainty)</ifdef><ifdef code="ca_collections.date_container.date_note"><br/>^ca_collections.date_container.date_note</ifdef></unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.extent_medium"><div class="unit"><label>Extent and Medium</label>^ca_collections.extent_medium%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.description">
						<div class='unit'><label>Description</label>
							<span class="trimText">^ca_collections.description</span>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.descriptive_note"><div class="unit"><label>Descriptive Note</label><unit relativeto="ca_collections.descriptive_note" delimiter="<br/>">^ca_collections.descriptive_note</unit></div></ifdef>}}}
					{{{<ifdef code="ca_collections.language"><div class="unit"><label>Language</label>^ca_collections.language%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.lcna"><div class="unit"><label>LOC Names</label>^ca_collections.lcna%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.lcsh"><div class="unit"><label>LOC Subjects</label>^ca_collections.lcsh%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.rights"><div class="unit"><label>Rights</label>^ca_collections.rights%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_collections.access_conditions%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_collections.use_reproduction%delimiter=,_</div></ifdef>}}}
				</div><!-- end col -->
			</div><!-- end row -->

{{{<ifcount code="ca_objects" max="0">
		<div class="row">
			<div class="col-sm-12">
<?php 
				#$vs_reps = $t_item->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.representation_id</unit>", array("checkAccess" => $va_access_values));
				#if($vs_reps){
					print caNavLink($this->request, _t("View Digitized Media"), "btn btn-default", "", "Browse", "objects", array("facets" => "collection_facet:".$t_item->get("ca_collections.collection_id").";has_media_facet:1"));
				#}
?>
			</div>
		</div>
</ifcount>}}}
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
			</div></div><!-- end row -->
<?php
			if($vb_bottom_box){
?>
				<div class="bgLightGray container"><div class="row">
<?php
			}
				$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					print "<div class='col-sm-12 col-md-4'>";
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><label>".$vs_type."</label>".join(", ", $va_entity_links)."</div>";
					}
					print "</div>";
				}
?>
				{{{<ifcount code="ca_occurrences" restrictToTypes="album,song" min="1"><div class="col-sm-12 col-md-4">
					<ifcount code="ca_occurrences" restrictToTypes="album" min="1"><div class="unit"><label>Album<ifcount code="ca_occurrences" restrictToTypes="album" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="album" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="song" min="1"><div class="unit"><label>Song<ifcount code="ca_occurrences" restrictToTypes="song" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="song" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					</div>
				</ifcount>}}}

				{{{<ifcount code="ca_occurrences" restrictToTypes="tour,studio_session,appearance" min="1"><div class="col-sm-12 col-md-4">
					<ifcount code="ca_occurrences" restrictToTypes="tour" min="1"><div class="unit"><label>Tour<ifcount code="ca_occurrences" restrictToTypes="tour" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="tour" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="1"><div class="unit"><label>Studio Session<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="studio_session" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="appearance" min="1"><div class="unit"><label>Related Appearance<ifcount code="ca_occurrences" restrictToTypes="appearance" min="2">s</ifcount></label>
						<unit relativeTo="ca_occurrences" restrictToTypes="appearance" delimiter="<br/>"><l><ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="tour" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>: </ifcount><ifcount code="ca_occurrences.related" restrictToTypes="venue" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="venue" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>, </ifcount><ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.date_occurrence_container.date_occurrence<ifdef code="ca_occurrences.date_occurrence_container.date_note_occurrence"> (^ca_occurrences.date_occurrence_container.date_note_occurrence)</ifdef></ifdef></l></unit></div>
					</ifcount>
					</div>
				</ifcount>}}}
<?php
			if($vb_bottom_box){
?>
				</div></div>
<?php
			}

?>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-6">
					<label>Related Archival Items</label>
				</div>
				<div class="col-sm-6 browseAllLink">
<?php 
					#$vs_reps = $t_item->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.representation_id</unit>", array("checkAccess" => $va_access_values));
					#if($vs_reps){
						print caNavLink($this->request, _t("View Digitized Media"), "btn btn-default", "", "Browse", "objects", array("facets" => "collection_facet:".$t_item->get("ca_collections.collection_id").";has_media_facet:1"));
					#}
?>
				</div>
			</div>
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
