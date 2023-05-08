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
					{{{^ca_objects.preferred_labels.name}}}
				</H1>

				{{{<ifdef code="ca_objects.nonpreferred_labels">
					<H3><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>">^ca_object_labels.name</unit></H3>
				</ifdef>}}}	
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

				{{{<ifcount code="ca_entities" min="1">
					<div class="unit">			
						<!-- <label>Related people</label> -->
						<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="donor,collector,provider">
							<l>^ca_entities.preferred_labels</l> (^relationship_typename)
						</unit>
					</div>
				</ifcount>}}}
<?php
				$vs_date = $t_object->getWithTemplate('<unit relativeTo="ca_objects.date" delimiter="<br/>"><if rule="^ca_objects.date.date_types !~ /accepted/ and ^ca_objects.date.date_types !~ /collected/">^ca_objects.date.date_value <ifdef code="ca_objects.date.date_types,ca_objects.date.date_value">(^ca_objects.date.date_types)</ifdef></if></unit>');
				if($vs_date){
					print '<div class="unit">'.$vs_date.'</div>';
				}
?>

				{{{<ifdef code="ca_objects.medium" >
					<div class="unit">			
						<!-- <label>Medium</label> -->
						<unit relativeTo="ca_objects.medium" delimiter=", ">^ca_objects.medium</unit>
					</div>
				</ifdef>}}}	
				
				{{{<ifdef code="ca_objects.material" >
					<div class="unit">			
						<!-- <label>Material</label> -->
						<unit relativeTo="ca_objects.material" delimiter=", ">^ca_objects.material</unit>
					</div>
				</ifdef>}}}	

				{{{<ifdef code="ca_objects.dimensions">
					<div class="unit">
						<!-- <label>Dimensions</label> -->
						<if rule='^ca_objects.dimensions !~ /null/ and ^ca_objects.dimensions !~ /0/'>
							<ifcount code="ca_objects.dimensions" min="1">						
								<unit relativeTo="ca_objects.dimensions" delimiter="">
										<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_width"> X </ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_width"> X </ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_length"> X </ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_diameter">, ^ca_objects.dimensions.dimensions_diameter Diameter</ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_circumference">, ^ca_objects.dimensions.dimensions_circumference Circumference</ifdef>
										<ifdef code="ca_objects.dimensions.measurement_notes">Measurement Notes: ^ca_objects.dimensions.measurement_notes</ifdef>
										<ifdef code="ca_objects.dimensions.measurement_type">Measurement Types: ^ca_objects.dimensions.measurement_type</ifdef>
										<br/>
									</unit>						
							</ifcount>
						</if>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.public_description">
					<div class="unit">					
						<!-- <label>Description</label> -->
						<unit relativeTo="ca_objects.public_description" delimiter="<br/>">
							^ca_objects.public_description%convertLineBreaks=1
						</unit>
					</div>
				</ifdef>}}}
				{{{<ifnotdef code="ca_objects.public_description"><ifdef code="ca_objects.description">
					<div class="unit">
						<unit relativeTo="ca_objects.description" delimiter="<br/>">
							^ca_objects.description%convertLineBreaks=1
						</unit>
					</div>
				</ifdef></ifnotdef>}}}

				{{{<ifdef code="ca_objects.credit_line">
					<div class="unit">			
						<!-- <label>Credit Line</label> -->
						<unit relativeTo="ca_objects.credit_line" delimiter="<br/>">
							^ca_objects.credit_line
						</unit>
					</div>
				</ifdef>}}}

				{{{<ifdef code="ca_objects.idno">
					<div class="unit">
						<label>Accession/ID Number</label>
						<unit relativeTo="ca_objects.idno" delimiter="<br/>">^ca_objects.idno</unit>
					</div>
				</ifdef>}}}

				<!-- {{{<ifdef code="ca_objects.type_id" >
					<div class="unit">
						<label>Classification</label>
						<unit relativeTo="ca_objects.type_id" delimiter="<br/>">^ca_objects.type_id</unit>
					</div>
				</ifdef>}}}	 -->

				<?php
					if($t_object->get("ca_objects.aat")){
						if($links = caGetBrowseLinks($t_object, 'ca_objects.aat', ['template' => '<l>^ca_objects.aat</l>', 'linkTemplate' => '<div>^LINK</div>'])) {
				?>
							<div class="unit">
								<label>Classifications</label>
								<?= join("\n", $links); ?>
							</div>
				<?php
						}
					}
				?>

				<?php
					if($t_object->get("ca_objects.ulan")) {
						$links = caGetBrowseLinks($t_object, 'ca_objects.ulan', [ 'linkTemplate' => '^LINK'])
				?>
						<div class="unit">
							<label>Related People</label>
							<?= join("<br/>", $links); ?>
						</div>
				<?php
					}
					if($t_object->get("ca_objects.lcsh_terms")) {
						$links = caGetSearchLinks($t_object, 'ca_objects.lcsh_terms', [ 'linkTemplate' => '<li>^LINK</li>'])
				?>
						<div class="unit">
							<label>Subjects</label>
							<ul><?= join("\n", $links); ?></ul>
						</div>
				<?php
					}
				
				
					if($t_object->get("ca_objects.lc_names")) {
						$links = caGetSearchLinks($t_object, 'ca_objects.lc_names', ['linkTemplate' => '^LINK'])
				?>
						<div class="unit">
							<label>Related People in LC</label>
							<?= join("<br/>", $links); ?>
						</div>
				<?php
					}
				?>

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
