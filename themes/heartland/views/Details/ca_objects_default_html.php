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
			<div class='col-sm-6 col-md-6 col-lg-6'>
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
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Inquire About This Item", "", "", "Contact", "Form", array("contactType" => "inquire", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Takedown", "", "", "Contact", "Form", array("contactType" => "takedown", "table" => "ca_objects", "id" => $t_object->get("object_id")))."</div>";
					
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
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR></HR>
				{{{<ifdef code="ca_objects.date_created"><label>Date</label>^ca_objects.date_created<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.description">
						<label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				
				{{{<ifcount code="ca_entities" min="1"><hr></hr></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="partnering_organization"><div class="unit"><label>Partnering Organization<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="partnering_organization">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="partnering_organization" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="Source"><div class="unit"><label>Source<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="Source">s</ifcount></label><unit relativeTo="ca_entities" restrictToRelationshipTypes="Source" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="partnering_organization,Source"><div class="unit"><label>Contributor<ifcount code="ca_entities" min="2" excludeRelationshipTypes="partnering_organization,Source">s</ifcount></label><unit relativeTo="ca_entities" excludeRelationshipTypes="partnering_organization,Source" delimiter="<br/>"><l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
				
				
				{{{<ifdef code="ca_objects.idno|ca_objects.object_category|ca_objects.language|ca_objects.date_digitized"><hr></hr></ifdef>}}}
				{{{<ifdef code="ca_objects.idno"><label>Identifier</label>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.object_category"><label>Category</label>^ca_objects.object_category<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.language"><label>Language</label>^ca_objects.language%delimiter=,_<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.date_digitized"><label>Date Digitized</label>^ca_objects.date_digitized%delimiter=,_<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.aat"><label>Format</label>^ca_objects.aat%delimiter=,_<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.aat"><label>Keywords</label>^ca_objects.keywords%delimiter=,_<br/></ifdef>}}}
			
				
				{{{<ifcount code="ca_places" min="1"><div class="unit"><label>Place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l></unit></div></ifcount>}}}
				
<?php
				if($vs_map = trim($this->getVar("map"))){
					print "<div class='unit'>".$vs_map."</div>";
				}
?>

				{{{<ifdef code="ca_objects.rights"><HR></HR><div class="unit">
					<ifdef code="ca_objects.rights.rightsText"><label>Rights</label>^ca_objects.rights.rightsText</ifdef>
					<ifdef code="ca_objects.rights.rightsHolder"><label>Rights Holder</label>^ca_objects.rights.rightsHolder<br/></ifdef>
					<ifdef code="ca_objects.rights.creditline"><label>Creditline</label>^ca_objects.rights.creditline<br/></ifdef>
					<ifdef code="ca_objects.rights.rightsNotes"><label>Rights Notes</label>^ca_objects.rights.rightsNotes<br/></ifdef>
				</div></ifdef>}}}
				
				
						
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
		  maxHeight: 125
		});
	});
</script>