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
	
	$rep = $t_object->get('ca_object_representations.media.small');
?>
<div class="row detailContainer">
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="detailContentContainer"><div class="row">

		
			<div class='<?php print $rep ? 'col-sm-7 col-md-7 col-lg-6' : 'col-sm-12 col-md-12 col-lg-11'; ?>'>
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				<HR>
				
				{{{<ifdef code="ca_objects.date"><div class='detailLabel'>Year published: </div><div class='detailContent'>^ca_objects.date</div></ifdef>}}}
				{{{<ifdef code="ca_objects.idno"><div class='detailLabel'>Library number: </div><div class='detailContent'>^ca_objects.library_number</div></ifdef>}}}
				{{{<ifdef code="ca_objects.isbn"><div class='detailLabel'>ISBN: </div> <div class='detailContent'>^ca_objects.isbn</div></ifdef>}}}
				{{{<ifdef code="ca_objects.num_pages"><div class='detailLabel'>Number of pages: </div><div class='detailContent'>^ca_objects.num_pages</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><div class='detailLabel'>Description</div>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				
				
				    <hr></hr>
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="author"><div class='detailLabel'>Author</div></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="author"><div class='detailLabel'>Authors</div></ifcount>}}}
							{{{<ifcount code="ca_entities" min="1"><div class='detailContent'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></div></ifcount>}}}
						
							
							{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="publisher"><div class='detailLabel'>Publisher</div></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="publisher"><div class='detailLabel'>Publishers</div></ifcount>}}}
							{{{<ifcount code="ca_entities" min="1"><div class='detailContent'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="publisher">^ca_entities.preferred_labels</unit></dic></ifcount>}}}
						
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><div class='detailLabel'>Subject</div></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><div class='detailLabel'>Subjects</div></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="1"><div class='detailContent'><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></div></ifcount>}}}
						
							
						</div><!-- end col -->		
					</div><!-- end row -->
						
			</div><!-- end col -->
<?php
    if ($rep) {
?>			
			<div class='col-sm-5 col-md-5 col-lg-4 col-lg-offset-1'>
				{{{^ca_object_representations.media.small}}}
				
				
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
<?php
    }
?>
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