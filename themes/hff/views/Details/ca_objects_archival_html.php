<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_artwork_html.php : 
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
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download Printable PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
							<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				{{{<ifdef code="ca_objects.unitdate.dacs_date_text"><div class="unit"><H6>Date</H6>^ca_objects.unitdate.dacs_date_text</div></ifdef>}}}
				{{{<ifnotdef code="ca_objects.unitdate.dacs_date_text"><ifdef code="ca_objects.unitdate.dacs_date_value"><div class="unit"><H6>Date</H6>^ca_objects.unitdate.dacs_date_value</div></ifdef></ifnotdef>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Identifier</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code='ca_object_representations.use_notice'><div class="unit red">^ca_object_representations.use_notice</div></ifdef>}}}
				{{{<ifdef code="ca_object_representations.media_types"><div class="unit"><H6>Media Type</H6>^ca_object_representations.media_types%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_object_representations.caption"><div class="unit"><H6>Preferred Caption</H6>^ca_object_representations.caption</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.extentDACS.extent_number|ca_objects.extentDACS.extent_type|ca_objects.extentDACS.physical_details|ca_objects.extentDACS.extent_dimensions">
					<div class="unit"><H6>Extent & Medium</H6>
						<unit relativeTo="ca_objects.extentDACS" delimiter="<br/>">
							<ifdef code="ca_objects.extentDACS.extent_number">^ca_objects.extentDACS.extent_number </ifdef>
							<ifdef code="ca_objects.extentDACS.extent_type">^ca_objects.extentDACS.extent_type: </ifdef>
							<ifdef code="ca_objects.extentDACS.physical_details">^ca_objects.extentDACS.physical_details</ifdef><ifdef code="ca_objects.extentDACS.physical_details,ca_objects.extentDACS.extent_dimensions">; </ifdef>
							<ifdef code="ca_objects.extentDACS.extent_dimensions">^ca_objects.extentDACS.extent_dimensions </ifdef>
						</unit>
					</div>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_object_representations.copyright_statement"><div class="unit"><H6>Rights</H6>^ca_object_representations.copyright_statement</div></ifdef>}}}
				
<?php
				if($va_rel_entities = $t_object->get("ca_entities", array("checkAccess" => $va_access_values, "returnWithStructure" => true))){
					$va_entities_by_type = array();
					foreach($va_rel_entities as $va_rel_entity){
						$va_entities_by_type[$va_rel_entity["relationship_typename"]][] = $va_rel_entity["displayname"];
					}
					foreach($va_entities_by_type as $vs_rel_type => $va_ents){
						print "<div class='unit'><H6>".ucfirst($vs_rel_type)."</H6>".join("<br/>", $va_ents)."</div>";
					}
				}
?>				
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><H6>Location in Archives Collection</H6><unit relativeTo="ca_collections" delimiter=" > "><l>^ca_collections.hierarchy.preferred_labels</l></unit></div></ifcount>}}}

				
						
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