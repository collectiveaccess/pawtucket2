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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
<?php
		if($t_object->get("ca_objects.sensitive_material", array("convertCodesToDisplayText" => true)) == "Yes"){
?>
			<div class="alert alert-danger">{{{sensitive_materials_message}}}</div>
<?php
		}else{
?>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
<?php
				print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
	}				

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
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>
					{{{^ca_objects.preferred_labels.name}}}
				</H1>

				{{{<ifdef code="ca_objects.nonpreferred_labels">
					<H2>^ca_objects.nonpreferred_labels</H2>
				</ifdef>}}}	

				<HR>

				<?php
					if($t_object->get("source_id")){
						$vs_source_as_link = getSourceAsLink($this->request, $t_object->get("source_id"), null);
				?>
						<div class="unit">
							<label style="display: inline;">From</label>
							<span style="display: inline;"><?php print $vs_source_as_link; ?></span>
						</div>
						<HR>
				<?php
					}		
				?>

				

				{{{<ifdef code="ca_objects.idno">
					<div class="unit">
						<unit relativeTo="ca_objects.idno" delimiter="<br/>">^ca_objects.idno</unit>
					</div>
				</ifdef>}}}
<?php
		if($t_object->get("ca_objects.sensitive_material", array("convertCodesToDisplayText" => true)) != "Yes"){
?>
				{{{<ifdef code="ca_objects.type_id" >
					<div class="unit">
						<unit relativeTo="ca_objects.type_id" delimiter="<br/>">^ca_objects.type_id</unit>
					</div>
				</ifdef>}}}	
				{{{<ifdef code="ca_objects.date" >
					<div class="unit">
						<unit relativeTo="ca_objects.date" delimiter=", ">^ca_objects.date</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.title" >
					<div class="unit">
						<unit relativeTo="ca_objects.title" delimiter=", ">^ca_objects.title</unit>
					</div>
				</ifdef>}}}
				
				
				
				
				{{{<ifdef code="ca_objects.material" >
					<div class="unit">			
						<label>Material</label>
						<unit relativeTo="ca_objects.material" delimiter=", ">^ca_objects.material</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.medium" >
					<div class="unit">			
						<label>Medium</label>
						<unit relativeTo="ca_objects.medium" delimiter=", ">^ca_objects.medium</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.technique" >
					<div class="unit">			
						<label>Technique</label>
						<unit relativeTo="ca_objects.technique" delimiter=", ">^ca_objects.technique</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.doc_type" >
					<div class="unit">			
						<label>Document Type</label>
						<unit relativeTo="ca_objects.doc_type" delimiter=", ">^ca_objects.doc_type</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.measurements">
					<div class="unit">
					<label>Measurements</label>
					<ifcount code="ca_objects.measurements" min="1">						
						<unit relativeTo="ca_objects.measurements" delimiter="<br/><br/>">
							<ifdef code="ca_objects.measurements.dimensions_height">^ca_objects.measurements.dimensions_height Height </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_width">^ca_objects.measurements.dimensions_width Width </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_depth">^ca_objects.measurements.dimensions_depth Depth </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_length">^ca_objects.measurements.dimensions_length Length </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_weight">^ca_objects.measurements.dimensions_weight Weight </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_thick">^ca_objects.measurements.dimensions_thick Thickness </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_diam">^ca_objects.measurements.dimensions_diam Diameter </ifdef>
							<ifdef code="ca_objects.measurements.dimensions_circumference">^ca_objects.measurements.dimensions_circumference Circumference</ifdef>
							<ifdef code="ca_objects.measurements.measurement_remarks"><br/>Measurement Remarks: ^ca_objects.measurements.measurement_remarks</ifdef>
							<br/>
						</unit>						
					</ifcount>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.culture" >
					<div class="unit">			
						<label>Culture</label>
						<unit relativeTo="ca_objects.culture" delimiter=", ">^ca_objects.culture</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.credit_line">
					<div class="unit">			
						<label>Credit Line</label>
						<unit relativeTo="ca_objects.credit_line" delimiter="<br/>">
							^ca_objects.credit_line
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist,author,honoured,is_featured_for_manufacturer,manufacturer,merchant,publisher,related,creator">
					<div class="unit">			
						<label>Related People and Organizations</label>
						<unit relativeTo="ca_entities" delimiter="<br/>" estrictToRelationshipTypes="artist,author,honoured,is_featured_for_manufacturer,manufacturer,merchant,publisher,related,creator">
							<l>^ca_entities.preferred_labels</l> (^relationship_typename)
						</unit>
					</div>
				</ifcount>}}}

				
				{{{<ifcount code="ca_collections" min="1">
					<div class="unit">			
						<label>Related Collection</label>
						<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>
					</div>
				</ifcount>}}}

				{{{<ifdef code="ca_objects.description">
					<div class="unit">					
						<label>Description</label>
						<unit relativeTo="ca_objects.description" delimiter="<br/>">
							^ca_objects.description%convertLineBreaks=1
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.narrative">
					<div class="unit">					
						<label>Narrative</label>
						<unit relativeTo="ca_objects.narrative" delimiter="<br/>">
							^ca_objects.narrative%convertLineBreaks=1
						</unit>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.RAD_scopecontent">
					<div class="unit">					
						<label>Scope and Content</label>
						<unit relativeTo="ca_objects.RAD_scopecontent" delimiter="<br/>">
							^ca_objects.RAD_scopecontent%convertLineBreaks=1
						</unit>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.historyUse">
					<div class="unit">					
						<label>History of Use</label>
						<unit relativeTo="ca_objects.historyUse" delimiter="<br/>">
							^ca_objects.historyUse%convertLineBreaks=1
						</unit>
					</div>
				</ifdef>}}}

				
<?php
				if($vs_map = $this->getVar("map")){
					print "<hr></hr><div class='unit'>".$vs_map."</div>";
				}
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
