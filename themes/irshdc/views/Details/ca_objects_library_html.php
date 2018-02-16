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
						
						
						<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
						{{{<ifdef code="ca_objects.MARC_copyrightDate"><div class='unit'>&copy; ^ca_objects.MARC_copyrightDate</div></ifdef>}}}
						<H6>
							{{{<ifdef code="ca_objects.resource_type">^ca_objects.resource_type%useSingular=1</ifdef><ifdef code="ca_objects.genre,ca_objects.resource_type"> > </ifdef><ifdef code="ca_objects.genre">^ca_objects.genre%delimiter=,_</unit></ifdef>}}}
						</H6>
						{{{<ifdef code="ca_objects.record_type"><H6>Record type</H6>^ca_objects.record_type%=_</ifdef>}}}
						{{{<ifdef code="ca_objects.contributors|ca_objects.creators"><H6>Creators and Contributors</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.contributors</unit><ifdef code="ca_objects.contributors,ca_objects.creators"><br/></ifdef><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.creators</unit></ifdef>}}}
						{{{<ifcount code="ca_entities.related" restrictToTypes="repository" min="1"><H6>Holding Library</H6><unit relativeTo="ca_entities.related" restrictToTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>}}}
				
<!-- description? -->				
						{{{<ifdef code="ca_objects.curators_comments.comments">
							<div class="unit" data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.curators_comments.comment_reference"><h6>Curatorial comment</h6>
								<span class="trimText">^ca_objects.curators_comments.comments</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.community_input_objects.comment_reference_objects"><h6>Community input</h6>
								<span class="trimText">^ca_objects.community_input_objects.comments_objects</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter="; ">^ca_objects.language</unit></div></ifdef>}}}
					</div><!-- end stoneBg -->
					<div class="row">
						<div class="col-sm-12">
							<div class="collapseBlock">
								<h3>Related <i class="fa fa-toggle-up" aria-hidden="true"></i></H3>
								<div class="collapseContent open">
									{{{<ifcount code="ca_objects.related" restrictToTypes="library" min="1"><H6>Related Library Items</H6><unit relativeTo="ca_objects.related" restrictToTypes="library" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}
									{{{<ifcount code="ca_objects.related" excludeTypes="library" min="1"><H6>Related Archival Items, Museum Works, and Testimonies</H6><unit relativeTo="ca_objects.related" excludeTypes="library" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></ifcount>}}}
<?php
							include("related_html.php");
?>
								</div>
							</div>
<?php
							$va_loc = array();
							$vs_loc = "";
							if($vs_entity_subjects = $t_object->getWithTemplate('<ifdef code="ca_objects.themes"><div class="unit"><h6>Local</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.themes</unit></div></ifdef>')){
								$va_loc[] = $vs_entity_subjects;
							}
							if($vs_subjects = $t_object->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="subject" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l>')){
								$va_loc[] = $vs_subjects;
							}
							if($vs_topical = $t_object->get("ca_objects.LOC_text", array("delimiter" => "<br/>"))){
								$va_loc[] = $vs_topical;
							}
							if($vs_tgn = $t_object->get("ca_objects.tgn", array("delimiter" => "<br/>"))){
								$va_loc[] = $vs_tgn;
							}
							if(sizeof($va_loc)){
								$vs_loc = "<div class='unit'><H6>Library of Congress</H6>".join("<br/>", $va_loc)."</div>";
							}
							
							if($vs_tmp = $t_object->get("ca_objects.local_subject", array("delimiter" => "<br/>"));){
								$vs_local_subjects = "<div class='unit'><H6>Holding Libraries</H6>".$vs_tmp."</div>";
							}
							
							if(sizeof($va_loc)){
?>							
								<div class="collapseBlock">
									<h3>Subjects <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<div class="unit">
<?php
											print .$vs_local_subjects; 
											
?>
										</div>									
									</div>
								</div>
<?php
							}
?>				
							
							{{{<ifdef code="ca_objects.MARC_isbn|ca_objects.nonpreferred_labels.name|ca_objects.MARC_generalNote|ca_objects.local_note|ca_objects.MARC_formattedContents|ca_objects.ISADG_titleNote|ca_objects.participant_performer|ca_objects.electronic_URL">
								<div class="collapseBlock">
									<h3>Notes <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<ifdef code="ca_objects.MARC_isbn"><div class='unit'><h6>ISBN</h6><unit delimiter="; ">^ca_objects.MARC_isbn</unit></div></ifdef>
										<ifdef code="ca_objects.nonpreferred_labels.name"><HR/><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>">^nonpreferred_labels.name</unit></ifdef>
										<ifdef code="ca_objects.MARC_formattedContents|ca_objects.ISADG_titleNote"><div class='unit'><h6>Contents</h6><ifdef code="ca_objects.MARC_formattedContents">^ca_objects.MARC_formattedContents</ifdef><ifdef code="ca_objects.ISADG_titleNote">^ca_objects.ISADG_titleNote</ifdef></div></ifdef>			
										<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>General Note</h6>^ca_objects.MARC_generalNote</div></ifdef>									
									</div>
								</div>
							</ifdef>}}}
						</div><!-- end col -->
					</div><!-- end row -->
									

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
					{{{<ifdef code="ca_objects.link"><div class='detailTool'><span class='glyphicon glyphicon-link'></span><a href="^ca_objects.link" target="_blank">Source record</a></div></ifdef>}}}
					
<?php					
					print "<div class='detailTool'><span class='glyphicon glyphicon-link'></span><a href='".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'objects/815')."'>Permalink</a></div>";
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask an Archivist", "", "", "Contact", "Form")."</div>";
					
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