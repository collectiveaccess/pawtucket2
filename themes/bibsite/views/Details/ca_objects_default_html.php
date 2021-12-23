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
			<div class='col-sm-7 col-md-7 col-lg-6 col-lg-offset-1'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-7 col-md-7 col-lg-6 col-lg-offset-1'>
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
			
			<div class='col-sm-5 col-md-5 col-lg-4'>
				{{{<ifdef code="ca_objects.date"><unit relativeTo="ca_objects.date" delimiter=" "><div class="unit"><label>^ca_objects.date.dc_dates_types</label>^ca_objects.date.dates_value</div></unit></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.type_id"><div class="unit"><label>Resource Type</label>^ca_objects.type_id</div></ifdef>}}}
				{{{<ifdef code="ca_objects.audio_format"><div class="unit"><label>Format</label>^ca_objects.audio_format%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.video_format"><div class="unit"><label>Format</label>^ca_objects.video_format%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.image_format"><div class="unit"><label>Format</label>^ca_objects.image_format%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.text_format"><div class="unit"><label>Format</label>^ca_objects.text_format%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.gen_format"><div class="unit"><label>Format</label>^ca_objects.gen_format%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.gen_format"><div class="unit"><label>Format</label>^ca_objects.gen_format%delimiter=,_</div></ifdef>}}}
							
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-12 col-lg-10 col-lg-offset-1">
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						^ca_objects.description
					</div>
				</ifdef>}}}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-lg-5 col-lg-offset-1">
				{{{<ifdef code="ca_objects.coverageDates"><div class="unit"><label>Date Range</label>^ca_objects.coverageDates%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.tgn"><div class="unit"><label>Geographic Area</label>^ca_objects.tgn%delimiter=,_</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.audience"><div class="unit"><label>Audiences</label>^ca_objects.audience%delimiter=,_</div></ifdef>}}}
				
			</div>
			<div class="col-sm-6 col-lg-5">
				{{{<ifcount code="ca_entities" min="1"><div class="unit"><label>Related Entities</label><unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities">^ca_entities.preferred_labels</unit> (^relationship_typename)</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.instructional_context"><div class="unit"><label>Instructional Methods</label>^ca_objects.instructional_context%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.identifier_bib_citation"><div class="unit"><label>Citation</label>^ca_objects.identifier_bib_citation%delimiter=<br/></div></ifdef>}}}
				{{{<ifdef code="ca_objects.external_link.url_entry"><div class="unit"><label>Link</label><unit relativeTo="ca_objects.external_link" delimiter="<br/>"><a href="^ca_objects.external_link.url_entry"><ifdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_source</ifdef><ifnotdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_entry</ifnotdef></a></unit></div></ifdef>}}}
				
			
			</div>
		</div>
{{{<ifcount code="ca_objects.related" min="1">
		<div class="row">
			<div class="col-sm-12">
				<div id="browseResultsContainer" class="browse results">
					<div class="row">
						<unit relativeTo="ca_objects.related" delimiter=" ">
							<div class="col-sm-6 col-md-4 bResultItemCol">
								<div class='bResultItem'>
									<div class='bResultItemContent'>
										<div class='bibtype medium'>
											<l>^ca_objects.preferred_labels</l>
											<ifcount code="ca_entities" min="1">
												<div class='resultEntity'><unit relativeTo="ca_entities" delimiter=", ">^ca_entities.preferred_labels</unit></div>
											</ifcount>
										</div><!-- end bResultItemText -->
										<div class='text-center bResultItemImg'><l>^ca_object_representations.media.medium</l></div>
									</div><!-- end bResultItemContent -->
								</div><!-- end bResultItem -->
							</div>
						</unit>
					</div>
				</div>
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>