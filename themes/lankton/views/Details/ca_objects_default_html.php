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
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_rep_count = "";
	$va_reps = $t_object->get("ca_object_representations.representation_id", array("filterNonPrimaryRepresentations" => false, "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(is_array($va_reps)){
		$vn_rep_count = sizeof($va_reps);
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
				{{{representationViewer}}}
				
				
<?php
				if($vn_rep_count < 10){
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));

				}else{
?>
					<div class="text-center"><a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, "", "Detail", "GetMediaOverlay", array("context" => "objects", "id" => $vn_id, "representation_id" => $this->getVar("representation_id"), "overlay" => 1)); ?>'); return false;">View all images</a></div>
<?php
				}
?>
				<div id="detailAnnotations"></div>
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
				<H1>{{{<unit>^ca_objects.type_id</unit>}}}</H1>
				{{{<if rule='^ca_objects.preferred_labels.name !~ /BLANK/'><H2>^ca_objects.preferred_labels.name</H2></if>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifcount code="ca_collections" min="1"><unit relativeTo="ca_collections"><div class="unit"><label>Part of</label><l><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></l></div></unit></ifcount>}}}
				<!--{{{<ifnotdef code="ca_objects.description"><unit relativeTo="ca_collections"><ifdef code="ca_collections.scope_contents"><div class="unit">^ca_collections.scope_contents</div></ifdef></unit></ifnotdef>}}}-->
				{{{<ifdef code="ca_objects.date.dates_value"><div class="unit"><label>Date</label>^ca_objects.date.dates_value</div></ifdef>}}}
				{{{<ifdef code="ca_objects.format"><div class="unit"><label>Format</label>^ca_objects.format</div></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description.description_text">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description.description_text</span>
					</div>
				</ifdef>}}}
				
				{{{<ifcount code="ca_list_items" min="1"><div class='unit'><label>Subjects</label><unit relativeTo="ca_list_items" delimiter="; " sort="ca_list_item_labels.name_singular">^ca_list_item_labels.name_singular</unit></div></ifcount>}}}				
<?php

				print "<div class='detailButton'><span class='glyphicon glyphicon-envelope'></span> ".caNavLink($this->request, "Inquire", "", "", "Contact", "Form", array("table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
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