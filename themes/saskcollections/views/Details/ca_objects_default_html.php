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
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Inquire, Comment and Share Tools
						
					print '<div id="detailTools">';
					print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";					
						
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

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				<H1>
					{{{^ca_objects.preferred_labels.name}}}
				</H1>

				{{{<ifdef code="ca_objects.type_id">
					<H2>^ca_objects.type_id</H2>
				</ifdef>}}}	

				<HR>

				<?php
					if($t_object->get("source_id")){
						$vs_source_as_link = getSourceAsLink($this->request, $t_object->get("source_id"), null);
				?>
						<div class="unit">
							<label style="display: inline;"><t>From</t></label>
							<span style="display: inline;"><?php print $vs_source_as_link; ?></span>
						</div>
						<HR>
				<?php
					}		
				?>

				{{{<ifdef code="ca_objects.idno">
					<div class="unit"><label><t>Accession Number</t></label>
						<unit relativeTo="ca_objects.idno" delimiter="<br/>">^ca_objects.idno</unit>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist,manufacturer" min="1">
					<div class="unit"><label><t>Artist/Maker</t></label>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist,manufacturer" delimiter="<br/>">^ca_entities.preferred_labels</unit>
					</div>
				</ifcount>}}}
				
				{{{<ifdef code="ca_objects.date" >
					<div class="unit"><label><t>Date</t></label>
						<unit relativeTo="ca_objects.date" delimiter=", ">^ca_objects.date</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class="unit">					
						<label><t>Description</t></label>
						<unit relativeTo="ca_objects.description" delimiter="<br/><br/>">
							^ca_objects.description
						</unit>
					</div>
				</ifdef>}}}				
				{{{<ifdef code="ca_objects.materials" >
					<div class="unit">			
						<label><t>Materials</t></label>
						<unit relativeTo="ca_objects.materials" delimiter=", ">^ca_objects.materials</unit>
					</div>
				</ifdef>}}}	
				{{{<ifdef code="ca_objects.dimensions.measurement_type|ca_objects.dimensions.dimensions_length|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_depth|ca_objects.dimensions.dimensions_weight|ca_objects.dimensions.dimensions_circ|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diam|ca_objects.dimensions.measurement_notes">
					<div class="unit">
					<label><t>Measurements</t></label>					
					<unit relativeTo="ca_objects.dimensions" delimiter="<br/><br/>">
						<ifdef code="ca_objects.dimensions.measurement_type">^ca_objects.dimensions.measurement_type:<br/></ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_length"><t>Length</t>: ^ca_objects.dimensions.dimensions_length; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_width"><t>Width</t>: ^ca_objects.dimensions.dimensions_width; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_height"><t>Height</t>: ^ca_objects.dimensions.dimensions_height; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_depth"><t>Depth</t>: ^ca_objects.dimensions.dimensions_depth; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_weight"><t>Weight</t>: ^ca_objects.dimensions.dimensions_weight; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_circ"><t>Circumference</t>: ^ca_objects.dimensions.dimensions_circ; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_thickness"><t>Thickness</t>: ^ca_objects.dimensions.dimensions_thickness; </ifdef>
						<ifdef code="ca_objects.dimensions.dimensions_diam"><t>Diameter</t>: ^ca_objects.dimensions.dimensions_diam; </ifdef>
						<ifdef code="ca_objects.dimensions.measurement_notes"><br/><t>Notes</t>: ^ca_objects.dimensions.measurement_notes</ifdef>
						<br/>
					</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.marksLabel" >
					<div class="unit">			
						<label><t>Marks/Labels</t></label>
						<unit relativeTo="ca_objects.marksLabel" delimiter="<br/><br/>">^ca_objects.marksLabel</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.ns_category_as_text">
					<div class="unit">			
						<label><t>Category</t></label>
						<unit relativeTo="ca_objects.ns_category_as_text" delimiter=", ">^ca_objects.ns_category_as_text</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.creditLine">
					<div class="unit">			
						<label><t>Credit Line</t></label>
						<unit relativeTo="ca_objects.creditLine" delimiter="<br/>">
							^ca_objects.creditLine
						</unit>
					</div>
				</ifdef>}}}

				
<?php
				if($vs_map = $this->getVar("map")){
					print "<hr></hr><div class='unit'>".$vs_map."</div>";
				}
?>
						
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
