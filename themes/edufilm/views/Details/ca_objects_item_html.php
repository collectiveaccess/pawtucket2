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
				<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><label>Identifier:</label>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><label>Box/series:</label>^ca_objects.containerID<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_Title.TitleText"><label>Title:</label>^ca_objects.vhh_Title.TitleText<br/></ifdef>}}}
								
				{{{<ifdef code="ca_objects.vhh_Identifier"><label>External Identifier:</label>^ca_objects.vhh_Identifier<br/></ifdef>}}}	
							
				{{{<ifdef code="ca_objects.vhh_CountryOfReference"><label>Country of Reference:</label>^ca_objects.vhh_CountryOfReference<br/></ifdef>}}}	

				{{{<ifdef code="ca_objects.vhh_Date"><label>Date:</label>^ca_objects.vhh_Date<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
					<span class="trimText">^ca_objects.description</span>
				</div>
				</ifdef>}}}
			
				{{{<ifdef code="ca_objects.vhh_URLe"><label>URL:</label>^ca_objects.vhh_URL<br/></ifdef>}}}	

				{{{<ifdef code="ca_objects.vhh_Note"><label>Note:</label>^ca_objects.vhh_Note<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_MediaType"><label>Media Type:</label>^ca_objects.vhh_MediaType<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.vhh_GenreAV"><label>Genre(AV):</label>^ca_objects.vhh_GenreAV<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.edu_FilmDevices"><label>Devices:</label>^ca_objects.edu_FilmDevices<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.edu_KnowledgeField"><label>Field of Knowledge:</label>^ca_objects.edu_KnowledgeField<br/></ifdef>}}}
				
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><label>Date:</label>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
			
				<hr></hr>

				<div class="row">
					<div class="col-sm-12">		

						{{{<ifdef code="ca_objects"><label>Related objects</label></ifdef>}}}
						{{{<unit relativeTo="ca_objects" delimiter="<br/>">
							<label>Related objects</label>
							<l>^ca_objects.preferred_labels</l>
						</unit>}}}
						
					</div><!-- end col -->				
					<!-- <div class="col-sm-6 colBorderLeft">
						{{{map}}}
					</div> -->
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
