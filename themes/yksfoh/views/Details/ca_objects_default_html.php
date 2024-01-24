<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$vs_representationViewer = trim($this->getVar("representationViewer"));
	
	$o_icons_conf = caGetIconsConfig();
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6'>
<?php
			if($vs_representationViewer){
				print $vs_representationViewer;
?>
					<div id="detailAnnotations"></div>				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>				
<?php
			}else{
				print "<div class='mainImg'>".$vs_default_placeholder_tag."</div>";
			}
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<HR>
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="in_the_collection_of" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="in_the_collection_of"><H3><l>^ca_entities.preferred_labels</l></H3><HR></unit></ifcount>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Accession Number</label>^ca_objects.idno%delimiter=,_</div></ifdef>}}}
				{{{<ifcount code="ca_objects.nonpreferred_labels" min="1"><div class="unit"><label>Alternate Name(s)</label><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>">^ca_objects.nonpreferred_labels.name</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.date"><unit relativeTo="ca_objects.date"><if rule='^ca_objects.date.dc_dates_types =~ /Created/'><div class="unit"><label>Date</label><ifdef code="ca_objects.date.date_certainty">^ca_objects.date.date_certainty </ifdef>^ca_objects.date.dates_value</div></if></unit></ifdef>}}}
				{{{<ifdef code="ca_objects.cultural_region"><div class="unit"><label>Culture/Region</label><unit relativeTo="ca_objects.cultural_region" delimiter="<br/>"><ifdef code="ca_objects.cultural_region.cultural_region_list">^ca_objects.cultural_region.cultural_region_list</ifdef><ifdef code="ca_objects.cultural_region.cultural_region_list,ca_objects.cultural_region.other_culture">, </ifdef><ifdef code="ca_objects.cultural_region.other_culture">^ca_objects.cultural_region.other_culture</ifdef></unit></div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.narrative">
					<div class='unit'><label>Narrative/Stories</label>
						<span class="trimText">^ca_objects.narrative</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.materials_other"><div class="unit"><label>Specific/Other Materials</label>^ca_objects.materials_other%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimension_notes"><div class="unit"><label>Dimension Remarks</label>^ca_objects.dimension_notes%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.credit"><div class="unit"><label>Credit Line</label>^ca_objects.credit%delimiter=,_</div></ifdef>}}}
				
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="in_the_collection_of"><div class="unit">
					<ifcount code="ca_entities" min="1" max="1" excludeRelationshipTypes="in_the_collection_of"><label>Related person</label></ifcount>
					<ifcount code="ca_entities" min="2" excludeRelationshipTypes="in_the_collection_of"><label>Related people</label></ifcount>
					<unit relativeTo="ca_entities" excludeRelationshipTypes="in_the_collection_of" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_places" min="1"><div class="unit">
					<ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount>
					<ifcount code="ca_places" min="2"><label>Related places</label></ifcount>
					<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
				</div></ifcount>}}}
				
				{{{<ifcount code="ca_objects.related" min="1"><div class="unit">
					<ifcount code="ca_objects.related" min="1" max="1"><label>Related artifact</label></ifcount>
					<ifcount code="ca_objects.related" min="2"><label>Related artifacts</label></ifcount>
					<unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels</l> (^ca_objects.idno)</unit>
				</div></ifcount>}}}
			
				{{{map}}}
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
