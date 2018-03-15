<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3")); ?>
				
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
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id<ifdef code="ca_objects.resourceType">: ^ca_objects.ca_objects.resourceType%useSingular=1</ifdef></unit>}}}</H6>
				
				
				{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><HR/><H6>Related school(s)</H6><unit relativeTo="ca_objects_x_entities" restrictToTypes="school" delimiter=", "><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></ifcount>}}}
		{{{<ifdef code="ca_objects.narrative_thread|ca_objects.theme|ca_objects.genre|ca_objects.denomination|ca_objects.keywords|ca_objects.local_subject"><HR/></ifdef>}}}
				{{{<ifdef code="ca_objects.narrative_thread"><div class='unit'><h6>Narrative thread(s)</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.narrative_thread</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.theme"><div class='unit'><h6>Theme(s)</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.theme</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.genre"><div class='unit'><h6>Genre(s)</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.genre</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.keywords"><div class='unit'><h6>Keywords</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.keywords</unit></div></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.description|ca_objects.historical_note|ca_objects.curators_comments.comments|ca_objects.community_input_objects.comments_objects"><HR/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.historical_note">
					<div class='unit'><h6>Contextual note</h6>
						<span class="trimText">^ca_objects.historical_note</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.curators_comments.comments">
					<div class='unit'><h6>Curatorial comment</h6>
						<span class="trimText">^ca_objects.curators_comments.comments</span>
						<br/>^ca_objects.curators_comments.comment_reference
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.community_input_objects.comments_objects">
					<div class='unit'><h6>Community input</h6>
						<span class="trimText">^ca_objects.community_input_objects.comments_objects</span>
						^ca_objects.community_input_objects.comment_reference_objects
					</div>
				</ifdef>}}}
				
				
				
				{{{<ifcount code="ca_places" min="1" max="1"><hr/><H6>Related place</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><hr/><H6>Related places</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
						
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