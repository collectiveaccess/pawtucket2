<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_work_html.php : Museum Work
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
 
$vs_mode = $this->request->getParameter("mode", pString);
if($vs_mode == "map"){
	include("map_large_html.php");
}else{
	$va_options = $this->getVar("config_options");
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
	$va_access_values = $this->getVar("access_values");
	$va_breadcrumb_trail = array(caNavLink($this->request, "Home", '', '', '', ''));
	$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_objects");
	$vs_last_find = strToLower($o_context->getLastFind($this->request, "ca_objects"));
	$vs_link_text = "";
	if(strpos($vs_last_find, "browse") !== false){
		$vs_link_text = "Find";	
	}elseif(strpos($vs_last_find, "search") !== false){
		$vs_link_text = "Search";	
	}elseif(strpos($vs_last_find, "gallery") !== false){
		$vs_link_text = "Explore Features";	
	}elseif(strpos($vs_last_find, "narrative") !== false){
		$vs_link_text = "Explore Narrative Threads";	
	}elseif(strpos($vs_last_find, "listing") !== false){
		$vs_link_text = "Explore Resources";	
	}
	if($vs_link_text){
		$va_params["row_id"] = $t_object->getPrimaryKey();
 		$va_breadcrumb_trail[] = $o_context->getResultsLinkForLastFind($this->request, "ca_objects", $vs_link_text, null, $va_params);
 	}
 	$va_breadcrumb_trail[] = caTruncateStringWithEllipsis($t_object->get('ca_objects.preferred_labels.name'), 60);

?>
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
<?php
			 	if ($this->getVar("resultsLink")) {
					# --- breadcrumb trail only makes sense when there is a back button
					print "<div class='row'><div class='col-sm-12 breadcrumbTrail'><small>";
					print join(" > ", $va_breadcrumb_trail);
					print "</small></div></div>";
				}
?>
			<div class="row">
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-5'>
					<?php print $vs_representationViewer; ?>				
<?php
					# --- is there a transcript media
					$t_list = new ca_lists();
					$va_type = $t_list->getItemFromList("object_representation_types", "transcript");
					$va_transcript_rep_ids = array_keys($t_object->getRepresentations(null, null, array("checkAccess" => $va_access_values, "restrict_to_types" => array($va_type["item_id"]))));
					if(is_array($va_transcript_rep_ids) && sizeof($va_transcript_rep_ids)){
						print "<div id='transcriptLink' class='text-center'>";
						foreach($va_transcript_rep_ids as $vn_transcript_rep_id){
							$t_rep = new ca_object_representations($vn_transcript_rep_id);
							
							print " ".caNavLink($this->request, "<span class='glyphicon glyphicon-download'></span> ".$t_rep->get("transcript_translation", array("convertCodesToDisplayText" => true))." Transcript", "btn btn-default btn-small", "", "Detail", "DownloadRepresentation", array("context" => "objects", "download" => "1",  "version" => "original", "representation_id" => $vn_transcript_rep_id, "id" => $t_object->get("object_id")))." ";
						}
						print "</div>";
					}
?>
					<div id="detailAnnotations"></div>
<?php				
					$va_reps = $t_object->getRepresentations("icon", null, array("checkAccess" => $va_access_values));
					if(sizeof($va_reps) > 1){
						print "<div><small>".sizeof($va_reps)." media</small></div>";
					}
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "version" => "iconlarge"));
					
?>
				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<div class="stoneBg">				
<?php
						$vs_source = $t_object->getWithTemplate('<unit relativeTo="ca_entities.related" restrictToRelationshipTypes="source" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>', array("checkAccess" => $va_access_values));						
						$vs_source_link = $t_object->get("ca_objects.link");
						if($vs_source_link){
							$vs_source_link = '<br/><a href="'.$vs_source_link.'" class="redLink" target="_blank">'.(($vs_source) ? $vs_source : 'Source Record').' <span class="glyphicon glyphicon-new-window"></span></a>';
						}
						$vs_title_hover = $t_object->getWithTemplate("<unit relativeTo='ca_objects' delimiter='<br/><br/>'>^ca_objects.ISADG_titleNote</unit>");
						$vs_title = $t_object->get("ca_objects.preferred_labels.name");
						
						print "<H4>";
						if($vs_title_hover){
							print '<span data-toggle="popover" title="Note" data-content="'.$vs_title_hover.'">'.$vs_title.'</span>';
						}else{
							print $vs_title;
						}
						print $vs_source_link."</H4>";
?>
						{{{<ifdef code="ca_objects.displayDate"><div class="unit">^ca_objects.displayDate</div></ifdef>}}}
				
						<H6>
							{{{<ifdef code="ca_objects.resource_type">^ca_objects.resource_type%useSingular=1</ifdef><ifdef code="ca_objects.genre,ca_objects.resource_type"> > </ifdef><ifdef code="ca_objects.genre">^ca_objects.genre%delimiter=,_</unit></ifdef>}}}
						</H6>
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
<?php
						$vs_display_creator = $t_object->getWithTemplate("<unit delimiter=', '>^ca_objects.cdwa_display_creator</unit>");
						$vs_creators_contributors = $t_object->getWithTemplate("<unit relativeTo='ca_entities.related' restrictToRelationshipTypes='artist,author,composer,contributor,creator,curator,director,editor,filmmaker,funder,illustrator,interviewee,interviewer,narrator,organizer,performer,photographer,producer,researcher,speaker,translator,subject,videographer,venue' delimiter=', '><l>^ca_entities.preferred_labels.displayname</l></unit>", array("checkAccess" => $va_access_values));
						if($vs_display_creator || $vs_creators_contributors){
							print "<div class='unit'><H6>Creators and Contributors</H6><div class='trimTextShort'>".$vs_display_creator.(($vs_display_creator && $vs_creators_contributors) ? ", " : "").$vs_creators_contributors."</div></div>";
						}
?>
						{{{<ifdef code="ca_objects.cultural_context"><div class='unit'><h6>Culture</h6>^ca_objects.cultural_context</div></ifdef>}}}
						{{{<ifdef code="ca_objects.place_made"><div class='unit'><h6>Place Made</h6>^ca_objects.place_made</div></ifdef>}}}
						{{{<ifdef code="ca_objects.curatorial_description.curatorial_desc_value">
							<div class="unit" data-toggle="popover" title="Source" data-content="^ca_objects.curatorial_description.curatorial_desc_source"><h6>Description</h6>
								<div class="trimText">^ca_objects.curatorial_description.curatorial_desc_value</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.narrative"><div class="unit"><H6>Narrative</H6><unit delimiter="<br/>">^ca_objects.narrative</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.history_use"><div class="unit"><H6>History of Use</H6><unit delimiter="<br/>">^ca_objects.history_use</unit></div></ifdef>}}}
						{{{<ifdef code="ca_objects.curators_comments.comments">
							<div class="unit" data-toggle="popover" title="Source" data-content="^ca_objects.curators_comments.comment_reference"><h6>Curatorial comment</h6>
								<div class="trimText">^ca_objects.curators_comments.comments</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_objects.community_input_objects.comment_reference_objects"><h6>Dialogue</h6>
								<div class="trimText">^ca_objects.community_input_objects.comments_objects</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_objects.language">
							<div class="unit" data-toggle="popover" title="Note" data-content="^ca_objects.language_note"><h6>Language</h6>
								^ca_objects.language
							</div>
						</ifdef>}}}
					</div><!-- end stoneBg -->
<?php
						include("themes_html.php");
?>
						{{{<ifdef code="ca_objects.alternate_text.alternate_desc_upload.url">
							<div class="collapseBlock">
								<h3>Research Guide <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
								<div class="collapseContent">
									<div class='unit icon transcription'><h6></h6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.alternate_text.alternate_desc_upload"><a href="^ca_objects.alternate_text.alternate_desc_upload.url%version=original">View ^ca_objects.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_objects.alternate_text.alternate_desc_note">^ca_objects.alternate_text.alternate_desc_note</ifdef></unit></div>
								</div>
							</div>
						</ifdef>}}}
						<div class="collapseBlock">
							<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								{{{<ifcount min="1" code="ca_objects.nonpreferred_labels.name" excludeTypes="exhibition_title"><div class='unit'><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>" excludeTypes="exhibition_title">^ca_objects.nonpreferred_labels.name</unit></div></ifcount>}}}
								{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="repository" min="1"><div class="unit"><H6>Repository</H6><div class="trimTextShort"><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></div></ifcount>}}}
								{{{<ifdef code="ca_objects.source_identifer"><div class='unit'><h6>Repository Object Identifier</h6>^ca_objects.source_identifer</div></ifdef>}}}
								{{{<ifdef code="ca_objects.cdwa_displayMeasurements"><div class='unit'><H6>Display Measurements</H6><unit delimiter=", ">^ca_objects.cdwa_displayMeasurements</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.material_tech"><div class='unit'><H6>Materials and Techniques</H6><unit delimiter=", ">^ca_objects.material_tech</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.ownership_provenance"><div class='unit'><H6>Provenance Description</H6><unit delimiter="<br/>">^ca_objects.ownership_provenance</unit></div></ifdef>}}}
<?php
								$vs_transfer = "";
								if($t_object->get("ca_objects.internal_external", array("convertCodesToDisplayText" => true)) == "internal"){
									if($vs_tmp = $t_object->get("ca_objects.ownership_transfer", array("delimiter" => "<br/>", "convertCodesToDisplayText" => true))){
										$vs_transfer .= "<div class='unit'><h6>Transfer Mode</h6>".$vs_tmp."</div>";
									}
									if($vs_tmp = $t_object->get("ca_objects.ownership_transfer_notes", array("delimiter" => "<br/>"))){
										$vs_transfer .= "<div class='unit'><h6>Note: Transfer Mode</h6>".$vs_tmp."</div>";
									}
									if($vs_transfer){
										print $vs_transfer;
									}
								}
?>								
								{{{<ifdef code="ca_objects.ownership_credit"><div class='unit'><h6>Credit/Caption</h6><unit delimiter="<br/>">^ca_objects.ownership_credit</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>Notes</h6><unit delimiter="<br/>">^ca_objects.MARC_generalNote</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.ISADG_archNote"><div class='unit'><h6>Note on Description</h6><unit delimiter="<br/>">^ca_objects.ISADG_archNote</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.dc_rights"><div class='unit'><h6>Rights Management</h6><unit delimiter="<br/>">^ca_objects.dc_rights</unit></div></ifdef>}}}
								{{{<ifdef code="ca_objects.rights_new"><div class='unit'><h6>Terms Governing Use and Reproduction</h6><unit delimiter="<br/>">^ca_objects.rights_new</unit></div></ifdef>}}}								

<?php							
								print "<div class='unit'><H6>Permalink</H6><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("object_id"))."</textarea></div>";		
?>
							</div>
						</div>
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "2" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($this->getVar("resultsLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("resultsLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("previousLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("previousLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("nextLink")) {
						print '<div class="detailTool detailToolInline detailNavFull">'.$this->getVar("nextLink").'</div><!-- end detailTool -->';
					}
					print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]." ".$va_add_to_set_link_info["link_text"]."</a></div>";
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_objects", "row_id" => $t_object->get("object_id")))."</div>";
					if($t_object->get("trc", array("convertCodesToDisplayText" => true)) == "yes"){
						print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Request Takedown", "", "", "Contact", "Form", array("contactType" => "takedown", "table" => "ca_objects", "row_id" => $t_object->get("object_id")))."</div>";
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
					include("map_html.php");
?>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">		
<?php
		include("related_tabbed_html.php");
		include("related_objects_html.php");
		
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
		
		var options = {
			placement: function () {
<?php
			if($vs_representationViewer){
?>
				if ($(window).width() > 992) {
					return "left";
				}else{
					return "auto top";
				}
<?php
			}else{
?>
				return "auto top";
<?php			
			}
?>
			},
			trigger: "hover",
			html: "true"
		};
		$('[data-toggle="popover"]').each(function() {
  			if($(this).attr('data-content')){
  				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
  			}
		});
		
		$('.collapseBlock h3').click(function() {
  			block = $(this).parent();
  			block.find('.collapseContent').toggle();
  			block.find('.fa').toggleClass("fa-toggle-down");
  			block.find('.fa').toggleClass("fa-toggle-up");
  			
		});
	});
</script>
<?php
}
?>