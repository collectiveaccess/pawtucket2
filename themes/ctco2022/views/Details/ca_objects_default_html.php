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
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>
					<!-- {{{<unit relativeTo="ca_collections" delimiter="<br/>">
							<l>^ca_collections.preferred_labels.name</l>
						</unit>
						<ifcount min="1" code="ca_collections"> ➔ </ifcount>}}} -->
					{{{ca_objects.preferred_labels.name}}}
				</H1>

				{{{<ifdef code="ca_objects.nonpreferred_labels">
					<H2>^nonpreferred_labels</H2>
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
				<?php
					}		
				?>

				<HR>

				{{{<ifdef code="ca_objects.idno">
					<div class="unit">
						<!-- <label>Accession/ID Number</label> -->
						<unit relativeTo="ca_objects.idno" delimiter="<br/>">^idno</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.type_id" >
					<div class="unit">
						<!-- <label>Classification</label> -->
						<unit relativeTo="ca_objects.type_id" delimiter="<br/>">^type_id</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.date" >
					<div class="unit">
						<!-- <label>Date</label> -->
						<unit relativeTo="ca_objects.date" delimiter="<br/>">
							<if rule='^ca_objects.date.date_types !~ /accepted/ and ^ca_objects.date.date_types !~ /collected/'>^date_value <ifdef code="ca_objects.date.date_types,ca_objects.date.date_value">(^date_types)</ifdef></if>
						</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.material" >
					<label>Material</label>
					<div class="unit">			
						<unit relativeTo="ca_objects.material" delimiter=", ">^material</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.medium" >
					<label>Medium</label>
					<div class="unit">			
						<unit relativeTo="ca_objects.medium" delimiter=", ">^medium</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.dimensions">
					<label>Dimensions</label>
					<ifcount code="ca_objects.dimensions" min="1">
						<div class="unit">
							<unit relativeTo="ca_objects.dimensions" delimiter="">
								<ifdef code="ca_objects.dimensions.dimensions_height">^dimensions_height H</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_width"> X </ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_width">^dimensions_width W</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_width"> X </ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_depth">^dimensions_depth D</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_length"> X </ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_length">^dimensions_length L</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_weight">, ^dimensions_weight Weight</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_diameter">, ^dimensions_diameter Diameter</ifdef>
								<ifdef code="ca_objects.dimensions.dimensions_circumference">, ^dimensions_circumference Circumference</ifdef>
								<ifdef code="ca_objects.dimensions.measurement_notes">Measurement Notes: ^measurement_notes</ifdef>
								<ifdef code="ca_objects.dimensions.measurement_type">Measurement Types: ^measurement_type</ifdef>
								<br/>
							</unit>
						</div>
					</ifcount>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.credit_line">
					<label>Credit Line</label>
					<div class="unit">			
						<unit relativeTo="ca_objects.credit_line" delimiter="<br/>">
							^credit_line
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_entities">
					<label>Related people</label>
					<div class="unit">			
						<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="donor, collector, provider">
							<l>^preferred_labels</l> (^relationship_typename)
						</unit>
					</div>
				</ifdef>}}}

				<?php
					if($t_object->get("ca_objects.aat")){
						if($links = caGetBrowseLinks($t_object, 'ca_objects.aat', ['template' => '<l>^ca_objects.aat</l>', 'linkTemplate' => '<div>^LINK</div>'])) {
				?>
							{{{<ifdef code="ca_objects.aat">
								<label>Object Type</label>
							</ifdef>}}}

							<div class="unit">
								<?= join("\n", $links); ?>
							</div>
				<?php
						}
					}
				?>

				<?php
					if($links = caGetBrowseLinks($t_object, 'ca_objects.lcsh_terms', ['template' => '<l>^ca_objects.lcsh_terms</l>', 'linkTemplate' => '<li>^LINK</li>'])) {
				?>
						{{{<ifdef code="ca_objects.lcsh_terms">
							<label>Subjects</label>
						</ifdef>}}}

						<div class="unit">
							<ul><?= join("\n", $links); ?></ul>
						</div>
				<?php
					}
				?>

				{{{<ifdef code="ca_objects.ulan">
					<label>Artist Name</label>
					<div class="unit">
						<unit relativeTo="ca_objects.ulan" delimiter="<br/>">^ulan</unit>
					</div>
				</ifdef>}}}
				
				{{{<ifdef code="ca_objects.lc_names">
					<label>Related People and Organizations</label>
					<div class="unit">			
						<unit relativeTo="ca_objects.lc_names" delimiter="<br/>">^lc_names</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.public_description">
					<div class="unit">					
						<!-- <label>Description</label> -->
						<unit relativeTo="ca_objects.public_description" delimiter="<br/>">
							^public_description
							<!-- <span class="trimText">^public_description</span> -->
						</unit>
					</div>
				</ifdef>}}}

				<hr></hr>

				<div class="row">
					<div class="col-sm-6"></div>
					<!-- end col -->				
					<div class="col-sm-6 colBorderLeft">
						{{{map}}}
					</div>
				</div><!-- end row -->
						
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
