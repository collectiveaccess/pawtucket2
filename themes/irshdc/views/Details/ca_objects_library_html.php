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
			</div>
			<div class="row">
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-5'>
					<?php print $vs_representationViewer; ?>				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3"));
?>
				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<div class="stoneBg">				
<?php
						$vs_source = $t_object->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="source" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>');						
						$vs_source_link = $t_object->get("ca_objects.link");
						if($vs_source_link){
							$vs_source_link = '<br/><a href="'.$vs_source_link.'" class="redLink" target="_blank">'.(($vs_source) ? $vs_source : 'Source Record').' <span class="glyphicon glyphicon-new-window"></span></a>';
						}
?>
						<H4>
							{{{^ca_objects.preferred_labels.name}}}
							<?php print $vs_source_link; ?>
						</H4>
						{{{<ifdef code="ca_objects.MARC_copyrightDate"><div class='unit'>&copy; ^ca_objects.MARC_copyrightDate</div></ifdef>}}}
						<H6>
							{{{<ifdef code="ca_objects.resource_type">^ca_objects.resource_type%useSingular=1</ifdef><ifdef code="ca_objects.genre,ca_objects.resource_type"> > </ifdef><ifdef code="ca_objects.genre">^ca_objects.genre%delimiter=,_</unit></ifdef>}}}
						</H6>
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
						{{{<ifdef code="ca_objects.record_type"><div class="unit"><H6>Record type</H6>^ca_objects.record_type%=_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.contributors|ca_objects.creators"><div class="unit"><H6>Creators and Contributors</H6><span class="trimTextShort"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.creators</unit><ifdef code="ca_objects.contributors,ca_objects.creators">, </ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.contributors</unit></span></div></ifdef>}}}
						{{{<ifdef code="ca_objects.description_new.description_new_txt">
							<div class="unit" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.description_new.description_new_source"><h6>Description</h6>
								<span class="trimText">^ca_objects.description_new.description_new_txt</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.curators_comments.comments">
							<div class="unit" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.curators_comments.comment_reference"><h6>Curatorial comment</h6>
								<span class="trimText">^ca_objects.curators_comments.comments</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.community_input_objects.comment_reference_objects"><h6>Dialogue</h6>
								<span class="trimText">^ca_objects.community_input_objects.comments_objects</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter="; ">^ca_objects.language</unit></div></ifdef>}}}
					</div><!-- end stoneBg -->
<?php
						include("themes_html.php");

							$va_loc = array();
							$vs_loc = "";
							# --- LOC are rel entities as subjects, Subject access topical and geographical
							if($vs_subjects = $t_object->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="subject" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit>')){
								$va_loc[] = $vs_subjects;
							}
							if($vs_topical = $t_object->get("ca_objects.LOC_text", array("delimiter" => "<br/>"))){
								$va_loc[] = $vs_topical;
							}
							if($vs_tgn = $t_object->get("ca_objects.tgn", array("delimiter" => "<br/>"))){
								$va_loc[] = $vs_tgn;
							}
							if(sizeof($va_loc)){
								$vs_loc = "<div class='unit'><H6>Library of Congress</H6><div class='trimTextSubjects'>".join("<br/>", $va_loc)."</div></div>";
							}
							
							if($vs_tmp = $t_object->get("ca_objects.local_subject", array("delimiter" => "<br/>", "convertCodesToDisplayText" => true))){
								$vs_local_subjects = "<div class='unit'><H6>Holding Libraries</H6><div class='trimTextSubjects'>".$vs_tmp."</div></div>";
							}
							
							if($vs_themes || $vs_loc || $vs_local_subjects){
?>							
								<div class="collapseBlock">
									<h3>Subjects <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<div class="unit">
<?php
											print $vs_loc.$vs_local_subjects; 											
?>
										</div>									
									</div>
								</div>
<?php
							}
?>
							<div class="collapseBlock">
								<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
								<div class="collapseContent">
									{{{<ifdef code="ca_objects.nonpreferred_labels.name" excludeTypes="exhibition_title"><div class='unit'><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>" excludeTypes="exhibition_title">^ca_objects.nonpreferred_labels.name</unit></div></ifdef>}}}
									{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="repository" min="1"><div class="unit"><H6>Repository</H6><span class="trimTextShort"><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></span></div></ifcount>}}}
									{{{<ifdef code="ca_objects.MARC_isbn"><div class='unit'><h6>ISBN</h6><unit delimiter="; ">^ca_objects.MARC_isbn</unit></div></ifdef>}}}
									{{{<ifdef code="ca_objects.MARC_formattedContents|ca_objects.ISADG_titleNote"><div class='unit'><h6>Contents</h6><ifdef code="ca_objects.MARC_formattedContents">^ca_objects.MARC_formattedContents</ifdef><ifdef code="ca_objects.ISADG_titleNote">^ca_objects.ISADG_titleNote</ifdef></div></ifdef>}}}		
									{{{<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>General Note</h6>^ca_objects.MARC_generalNote</div></ifdef>}}}							

<?php
									print "<div class='unit'><H6>Permalink</H6><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("object_id"))."</textarea></div>";					
?>						
								</div>
							</div>
<!--
							{{{<ifdef code="ca_objects.MARC_isbn|ca_objects.nonpreferred_labels.name|ca_objects.MARC_generalNote|ca_objects.local_note|ca_objects.MARC_formattedContents|ca_objects.ISADG_titleNote|ca_objects.participant_performer|ca_objects.electronic_URL">
								<div class="collapseBlock">
									<h3>Notes <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<ifdef code="ca_objects.MARC_isbn"><div class='unit'><h6>ISBN</h6><unit delimiter="; ">^ca_objects.MARC_isbn</unit></div></ifdef>
										<ifdef code="ca_objects.nonpreferred_labels.name" excludeTypes="exhibition_title"><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>" excludeTypes="exhibition_title">^nonpreferred_labels.name</unit></ifdef>
										<ifdef code="ca_objects.MARC_formattedContents|ca_objects.ISADG_titleNote"><div class='unit'><h6>Contents</h6><ifdef code="ca_objects.MARC_formattedContents">^ca_objects.MARC_formattedContents</ifdef><ifdef code="ca_objects.ISADG_titleNote">^ca_objects.ISADG_titleNote</ifdef></div></ifdef>			
										<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>General Note</h6>^ca_objects.MARC_generalNote</div></ifdef>									
									</div>
								</div>
							</ifdef>}}}
-->
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "2" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($this->getVar("resultsLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("resultsLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("previousLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("previousLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("nextLink")) {
						print '<div class="detailTool detailToolInline">'.$this->getVar("nextLink").'</div><!-- end detailTool -->';
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_objects", "row_id" => $t_object->get("object_id")))."</div>";
					if($t_object->get("trc", array("convertCodesToDisplayText" => true)) == "yes"){
						print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Takedown", "", "", "Contact", "Form", array("contactType" => "takedown", "object_id" => $t_object->get("object_id")))."</div>";
					}
					print '</div><!-- end detailTools -->';			


						if ($vn_comments_enabled) {
							$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
							<div class="collapseBlock last discussion">
								<h3>Discussion <i class="fa fa-toggle-up" aria-hidden="true"></i></H3>
								<div class="collapseContent open">
									<div id='detailDiscussion'>
										Do you have a story to contribute related to these records or a comment about this item?<br/>
<?php
										
										if($this->request->isLoggedIn()){
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
										}else{
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment")."</button>";
										}
										if($vn_num_comments){
											print "<br/><br/><a href='#comments'>Read All Comments <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
										}
?>
									</div><!-- end itemComments -->
								</div>
							</div>
<?php				
						}

					if($vs_map = $this->getVar("map")){
						print "<div class='unit'>".$vs_map."</div>";
					}
?>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">		
<?php
		include("related_tabbed_html.php");
?>
					{{{<ifcount code="ca_objects.related" min="1">
						<div class="relatedBlock">
							<h3>Objects</H3>
							<div class="row" id="browseResultsContainer">
								<unit relativeTo="ca_objects.related" delimiter=" ">
									<div class="bResultItemCol col-xs-12 col-sm-6 col-md-3">
										<div class="bResultItem" onmouseover="jQuery("#bResultItemExpandedInfo^ca_objects.object_id").show();" onmouseout="jQuery("#bResultItemExpandedInfo^ca_objects.object_id").hide();">
											<div class="bResultItemContent"><div class="text-center bResultItemImg"><l>^ca_object_representations.media.medium</l></div>
												<div class="bResultItemText">
													<small><l>^ca_objects.preferred_labels.name</l></small>
												</div><!-- end bResultItemText -->
											</div><!-- end bResultItemContent -->
											<div class="bResultItemExpandedInfo" id="bResultItemExpandedInfo^ca_objects.object_id" style="display: none;">
											</div><!-- bResultItemExpandedInfo -->
										</div><!-- end bResultItem -->
									</div>
								</unit>
							</div>
						</div>
					</ifcount>}}}
<?php
					if($vn_num_comments){
?>
						<a name="comments"></a><div class="block">
							<h3>Discussion</H3>
							<div class="blockContent">
								<div id="detailComments">
<?php
								if(sizeof($va_comments)){
									print "<H2>Comments</H2>";
								}
								print $this->getVar("itemComments");
?>
								</div>
							</div>
						</div>
<?php
					}
?>				
				</div>
			</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 60
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 18
		});
		$('.trimTextSubjects').readmore({
		  speed: 75,
		  maxHeight: 80,
		  moreLink: '<a href="#" class="moreLess">More</a>',
		  lessLink: '<a href="#" class="moreLess">Less</a>'
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