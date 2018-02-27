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
	$va_access_values = $this->getVar("access_values");
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
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-4'>
					{{{representationViewer}}}
				
				
					<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				</div><!-- end col -->
				<div class='col-sm-8 col-md-6'>
				
					<div class="stoneBg">
						<H4><?php print ucwords(strtolower($t_object->get("ca_objects.preferred_labels.name"))); ?></H4>
						{{{<ifdef code="ca_objects.dc_website"><h6><unit delimiter="<br/>"><a href="^ca_objects.dc_website" target="_blank">^ca_objects.dc_website <span class="glyphicon glyphicon-new-window"></span></a></unit><h6></ifdef>}}}

						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter=", ">^ca_objects.language</unit></div></ifdef>}}}
						
						{{{<ifdef code="ca_objects.description"><div class='unit'>^ca_objects.description</div></ifdef>}}}
					</div><!-- end stoneBg -->
<?php
					$vs_related = "";
					$vs_related .= $t_object->getWithTemplate('<ifcount code="ca_objects.related" restrictToTypes="resource" min="1"><H6>Resources</H6><unit relativeTo="ca_objects.related" restrictToTypes="file" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>');
					$vs_related .= $t_object->getWithTemplate('<ifcount code="ca_objects.related" excludeTypes="file" min="1"><H6>Archival Items, Library Items, Museum Works, and Testimonies</H6><unit relativeTo="ca_objects.related" excludeTypes="file" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>');
					$vs_related .= $t_object->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><H6><ifcount code="ca_entities.related" restrictToTypes="school" min="1" max="1">School</ifcount><ifcount code="ca_entities.related" restrictToTypes="school" min="2">Schools</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></ifcount>');
					$vs_related .= $t_object->getWithTemplate('<ifcount code="ca_entities.related" excludeRelationshipTypes="subject" excludeTypes="school" min="1"><H6><ifcount code="ca_entities.related" excludeRelationshipTypes="subject" excludeTypes="school" min="1" max="1">Person/Organization</ifcount><ifcount code="ca_entities.related" excludeRelationshipTypes="subject" excludeTypes="school" min="2">People/Organizations</ifcount></H6><unit relativeTo="ca_entities" excludeRelationshipTypes="subject" excludeTypes="school"><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></ifcount>');
					$vs_related .= $t_object->getWithTemplate('<ifdef code="ca_objects.themes"><div class="unit"><h6>Subject<ifcount code="ca_objects.themes" min="2">s</ifcount></h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.themes</unit></div></ifdef>');
					if($vs_related){
?>
						<div class="row">
							<div class="col-sm-12">
								<div class="collapseBlock last">
									<h3>Related <i class="fa fa-toggle-up" aria-hidden="true"></i></H3>
									<div class="collapseContent open">
									<?php print $vs_related; ?>
									</div>
								</div>
							</div><!-- end col -->
						</div><!-- end row -->
<?php
					}
?>									

				</div>
				<div class='col-sm-4 col-md-2'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
?>
					{{{<ifdef code="ca_objects.dc_website"><div class='detailTool'><span class='glyphicon glyphicon-new-window'></span><a href="^ca_objects.dc_website" target="_blank">View Website</a></div></ifdef>}}}
					
<?php					
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "object_id" => $t_object->get("object_id")))."</div>";
					
					print '</div><!-- end detailTools -->';			
					
					if($t_object->get("narrative_thread")){
						include("narrative_threads_html.php");
					}
					if($vs_map = $this->getVar("map")){
						print "<hr/>";
						print $vs_map;
					}
?>
				</div>
			</div>
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
		
		$('[data-toggle="popover"]').popover();
		
		$('.collapseBlock h3').click(function() {
  			block = $(this).parent();
  			block.find('.collapseContent').toggle();
  			block.find('.fa').toggleClass("fa-toggle-down");
  			block.find('.fa').toggleClass("fa-toggle-up");
  			
		});
	});
</script>