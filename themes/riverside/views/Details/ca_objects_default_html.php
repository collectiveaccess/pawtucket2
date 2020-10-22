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
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
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
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections.hierarchy" delimiter=" > "><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.parent_id"><div class="unit"><label>Part of</label><l>^ca_objects.parent.preferred_labels.name</l></div></ifdef>}}}
				{{{<ifcount code="ca_objects.children" min="1"><div class="unit"><label>Contains</label><unit relativeTo="ca_objects.children" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.date"><div class="unit"><label>Date</label>^ca_objects.date.date_value <ifdef code="ca_objects.date.date_types">(^ca_objects.date.date_types)</ifdef></div></ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="Dedicated,Related"><div class="unit"><label>Creators & Contributors</label><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="Dedicated,Related"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
				<!-- art/arch related people;ulan -->
				{{{<ifdef code="ca_objects.ulan"><div class="unit"><label>ULAN Preferred Name</label>^ca_objects.ulan%delimiter=,_</div></ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Dedicated,Related"><div class="unit"><label>Related People & Organizations</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="Dedicated,Related"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Publisher"><div class="unit"><label>Publisher</label><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="Publisher"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}

				
				{{{<ifdef code="ca_objects.description"><div class="unit"><label>Description</label>^ca_objects.description</div></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language</div></ifdef>}}}
				<!-- exent; spacial coverage: photos/artifacts/documents -->
				{{{<ifdef code="ca_objects.extent"><div class="unit"><label>Extent</label>^ca_objects.extent</div></ifdef>}}}
				{{{<ifdef code="ca_objects.coverageSpacial"><div class="unit"><label>Spacial Coverage</label>^ca_objects.coverageSpacial</div></ifdef>}}}
				
				<!-- Library fields -->
				{{{<ifdef code="ca_objects.isbn"><div class="unit"><label>ISBN</label>^ca_objects.isbn</div></ifdef>}}}
				{{{<ifdef code="ca_objects.lOCcontrol"><div class="unit"><label>LOC Control Number</label>^ca_objects.lOCcontrol</div></ifdef>}}}
				{{{<ifdef code="ca_objects.cataloging_source"><div class="unit"><label>Cataloging Source</label>^ca_objects.cataloging_source</div></ifdef>}}}
				{{{<ifdef code="ca_objects.edition_statement"><div class="unit"><label>Edition Statement</label>^ca_objects.edition_statement</div></ifdef>}}}
				{{{<ifdef code="ca_objects.rights_statement"><div class="unit"><label>Rights Statement</label>^ca_objects.rights_statement</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publication_information"><div class="unit"><label>Publication & Distribution Information</label>^ca_objects.publication_information</div></ifdef>}}}
				{{{<ifdef code="ca_objects.physical_description"><div class="unit"><label>Physical Description</label>^ca_objects.physical_description</div></ifdef>}}}
				{{{<ifdef code="ca_objects.general_notes"><div class="unit"><label>General Notes</label>^ca_objects.general_notes</div></ifdef>}}}
				{{{<ifdef code="ca_objects.library_series"><div class="unit"><label>Series Statement</label>^ca_objects.library_series</div></ifdef>}}}
				<!-- end Library fields -->
				<!-- vol; issue: documents/library -->
				{{{<ifdef code="ca_objects.volume_number"><div class="unit"><label>Volume Number</label>^ca_objects.volume_number</div></ifdef>}}}
				{{{<ifdef code="ca_objects.issue_number"><div class="unit"><label>Issue Number</label>^ca_objects.issue_number</div></ifdef>}}}
				
				<!-- number of copies: documents/art-arch/library -->
				{{{<ifdef code="ca_objects.num_copies"><div class="unit"><label>Number of Copies</label>^ca_objects.num_copies</div></ifdef>}}}
				<!-- Library fields -->
				{{{<ifdef code="ca_objects.rare_book"><div class="unit"><label>Rare Book</label>^ca_objects.rare_book</div></ifdef>}}}
				{{{<ifdef code="ca_objects.rare_book_info"><div class="unit"><label>Rare Book Cataloging</label>^ca_objects.rare_book_info</div></ifdef>}}}
				<!-- end Library fields -->
				<!-- Format tab: Photo/Artifact/Art_arch -->
				{{{<ifdef code="ca_objects.material_techniques"><div class="unit"><label>Material & Techniques</label>^ca_objects.material_techniques%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions"><div class="unit"><label>Dimensions</label>
					<ifdef code="ca_objects.dimensions.dimensions_length">Length: ^ca_objects.dimensions.dimensions_length<br/></div>
					<ifdef code="ca_objects.dimensions.dimensions_width">Width: ^ca_objects.dimensions.dimensions_width<br/></div>
					<ifdef code="ca_objects.dimensions.dimensions_height">Height: ^ca_objects.dimensions.dimensions_height<br/></div>
					<ifdef code="ca_objects.dimensions.dimensions_depth">Depth: ^ca_objects.dimensions.dimensions_depth<br/></div>
					<ifdef code="ca_objects.dimensions.dimensions_weight">Weight: ^ca_objects.dimensions.dimensions_weight<br/></div>
					<ifdef code="ca_objects.dimensions.dimension_notes">Notes: ^ca_objects.dimensions.dimension_notes<br/></div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.photograph_format"><div class="unit"><label>Photograph Format (AAT)</label>^ca_objects.photograph_format%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.copies_originals"><div class="unit"><label>Copies/Originals</label>^ca_objects.copies_originals%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.object_work_type"><div class="unit"><label>Object Work/Type (AAT)</label>^ca_objects.object_work_type%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.components_parts"><div class="unit"><label>Components/Parts</label>^ca_objects.components_parts%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.classification"><div class="unit"><label>Classification (AAT)</label>^ca_objects.classification%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.culture"><div class="unit"><label>Culture</label>^ca_objects.culture%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.style"><div class="unit"><label>Style</label>^ca_objects.style%,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.inscriptions"><div class="unit"><label>Inscriptions & Markings</label>^ca_objects.inscriptions%,_</div></ifdef>}}}
				
				
				{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Event<ifcount code="ca_occurrences" min="2" restrictToTypes="event">s</ifcount></label><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l></unit></div></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label>Related Object<ifcount code="ca_objects.related" min="2">s</ifcount></label><unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_object_representations.media.icon</l> <l>^ca_objects.preferred_labels</l> (^relationship_typename)</unit></div></ifcount>}}}
				
				
				
				
				
				
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