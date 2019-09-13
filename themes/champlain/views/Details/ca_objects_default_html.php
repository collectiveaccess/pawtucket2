<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
	
	$vs_rep_viewer = trim($this->getVar("representationViewer"));
	if(!$vs_rep_viewer){
		$o_icons_conf = caGetIconsConfig();
		$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
		if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
			$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
		}
		$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
		$va_collection_specific_icons = $o_icons_conf->getAssoc("collection_placeholders");
		
		if($vn_collection_idno = $t_object->get('ca_collections.idno')){
			if($vs_collection_placeholder_graphic = caGetOption($vn_collection_idno, $va_collection_specific_icons, null)){
				$vs_placeholder = "<div class='detailPlaceholder'>".caGetThemeGraphic($this->request, $vs_collection_placeholder_graphic)."</div>";
			}
		}
		if(!$vs_placeholder){
			$t_list_item = new ca_list_items();
			$t_list_item->load($t_object->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
			if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
				$vs_placeholder = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
			}else{
				$vs_placeholder = $vs_default_placeholder_tag;
			}
		}		
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
<?php
				if($vs_rep_viewer){
					print $vs_rep_viewer;
				}else{
					print $vs_placeholder;
				}
?>				

				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}

					print '</div><!-- end detailTools -->';
				}				

?>
					<h6>Share</h6>
					<div class="addthis_inline_share_toolbox"></div> 

				<div><br>
					{{{<ifdef code="ca_objects.georeference"><H6>Georeference</H6><unit realtiveTo="ca_objects.georeference" delimiter="<br/>">^ca_objects.georeference</unit><br/></ifdef>}}}<br>			
					{{{map}}}
				</div><br>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				{{{<unit relativeTo="ca_collections" delimiter="<br/>"><h3><l>^ca_collections.preferred_labels.name</l></h3></unit>}}}
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				{{{<ifdef code="ca_objects.idno"><H6>Identifier</H6>^ca_objects.idno<br/></ifdef>}}}
				
				{{{<ifcount min="1" code="ca_objects.date"><h6>Date</h6></ifcount>}}}
				{{{<ifdef code="ca_objects.date.dates_value">^ca_objects.date.dates_value</ifdef><ifdef code="ca_objects.date.dates_types"> (^ca_objects.date.dates_types)</ifdef>}}}

				{{{<ifdef code="ca_objects.publication_place"><h6>Place of Publication</h6></ifdef>}}}
				{{{<ifdef code="ca_objects.publication_place">^ca_objects.publication_place</ifdef>}}}

				{{{<ifdef code="ca_objects.published_subtype"><h6>Object Type</h6></ifdef>}}}
				{{{<ifdef code="ca_objects.published_subtype">^ca_objects.published_subtype</ifdef>}}}
				
				{{{<ifdef code="ca_objects.archival_object_subtype"><h6>Object Type</h6></ifdef>}}}
				{{{<ifdef code="ca_objects.archival_object_subtype">^ca_objects.archival_object_subtype</ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_depth"><h6>Dimensions</h6></ifcount>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (W)</ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (H)</ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth (D)</ifdef>}}}
				
				{{{<ifdef code="ca_objects.material"><H6>Material</H6>^ca_objects.material%delimiter=,_<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.public_notes"><H6>Notes</H6>^ca_objects.public_notes<br/></ifdef>}}}				
				
							
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit></unit>}}}						
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}						
							
							{{{<ifdef code="ca_objects.lcsh_terms"><ifcount code="ca_objects.lcsh_terms" min="1" max="1"><H6>Library of Congress Subject Heading</H6></ifcount>
							<ifcount code="ca_objects.lcsh_terms" min="2"><H6>Library of Congress Subject Headings</H6></ifcount>
							<unit relativeTo="ca_objects.lcsh_terms" delimiter="<br/>">^ca_objects.lcsh_terms</unit></ifdef>}}}
						
							{{{<ifdef code="ca_objects.lcsh_names"><ifcount code="ca_objects.lcsh_names" min="1" max="1"><H6>Library of Congress Name Authority</H6></ifcount>
							<ifcount code="ca_objects.lcsh_names" min="2"><H6>Library of Congress Name Authorities</H6></ifcount>
							<unit relativeTo="ca_objects.lcsh_names" delimiter="<br/>">^ca_objects.lcsh_names</unit></ifdef>}}}		
		
						</div><!-- end col -->				
						<div class="col-sm-12">
<?php
							print $t_object->getWithTemplate('<ifcount code="ca_list_items" min="1" max="1"><H6>Subject</H6></ifcount><ifcount code="ca_list_items" min="2"><H6>Subjects</H6></ifcount><unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_singular (^relationship_typename)</unit>', array("restrictToLists" => array("custom_subject_authority")));
?>
							
							
						</div><br>
					</div><!-- end row -->
						
			</div><!-- end col -->
		</div><!-- end row --></div><br><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d10f6071c79de60"></script>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>