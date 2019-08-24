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
						$vs_source_link = $t_object->get("ca_objects.nctr_URL");
						if($vs_source_link){
							$vs_source_link = '<br/><a href="'.$vs_source_link.'" class="redLink" target="_blank">'.(($vs_source) ? $vs_source : 'Source Record').' <span class="glyphicon glyphicon-new-window"></span></a>';
						}
?>
						<H4>
							{{{^ca_objects.preferred_labels.name}}}
							<?php print $vs_source_link; ?>
						</H4>
						
						{{{<ifdef code="ca_objects.displayDate"><div class='unit'>^ca_objects.displayDate</div></ifdef>}}}
						<H6>
							{{{<ifdef code="ca_objects.resource_type">^ca_objects.resource_type%useSingular=1</ifdef><ifdef code="ca_objects.genre,ca_objects.resource_type"> > </ifdef><ifdef code="ca_objects.genre">^ca_objects.genre%delimiter=,_</unit></ifdef>}}}
						</H6>
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
						{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="creator" min="1"><div class="unit"><H6>Creator</H6><div class="trimTextShort"><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></div></ifcount>}}}
						
						<div class="unit"><H6>Description</H6>{{{<ifdef code="ca_objects.record_group_id|ca_objects.file_series">^ca_objects.record_group_id%=_<ifdef code="ca_objects.record_group_id,ca_objects.file_series">: </ifdef>^ca_objects.file_series%delimiter=,_.</ifdef>}}} The School Files Series from RG-10 (Record Group 10) contains records relating to the administration of Indian residential schools and education in Canada between 1879 and 1953.</div>
				
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
						{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit delimiter=", ">^ca_objects.language</unit></div></ifdef>}}}
						
					</div><!-- end stoneBg -->
<?php
						include("themes_html.php");
?>

					{{{<ifdef code="ca_objects.alternate_text.alternate_desc_upload.url">
						<div class="collapseBlock">
							<h3>Research Guide <i class="fa fa-toggle-down" aria-hidden="true"></i></h3>
							<div class="collapseContent">
								<div class='unit icon transcription'><h6></h6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.alternate_text.alternate_desc_upload"><a href="^ca_objects.alternate_text.alternate_desc_upload.url%version=original">View ^ca_objects.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_objects.alternate_text.alternate_desc_note">^ca_objects.alternate_text.alternate_desc_note</ifdef></unit></div>
							</div>
						</div>
					</ifdef>}}}
					<div class="collapseBlock">
						<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></h3>
						<div class="collapseContent">
							{{{<ifcount min="1" code="ca_objects.nonpreferred_labels.name" excludeTypes="exhibition_title"><div class='unit'><H6>Alternate Title(s)</H6><unit relativeTo="ca_objects" delimiter="<br/>" excludeTypes="exhibition_title">^ca_objects.nonpreferred_labels.name</unit></div></ifcount>}}}
							{{{<ifdef code="ca_objects.record_type"><div class='unit'><H6>Record type</H6>^ca_objects.record_type%=_</div></ifdef>}}}
							{{{<ifcount code="ca_entities.related" restrictToRelationshipTypes="repository" min="1"><div class="unit"><H6>Repository</H6><unit relativeTo="ca_entities.related" restrictToRelationshipTypes="repository" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}							
							{{{<ifdef code="ca_objects.lac_URL"><div class='unit'><H6 class="inline">Repository URL:</H6> <unit delimiter=", "><a href="^ca_objects.lac_URL">^ca_objects.lac_url</a></unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.file_series"><div class='unit'><H6 class="inline">Series:</H6> <unit delimiter=", ">^ca_objects.file_series</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.record_group_id"><div class='unit'><H6 class="inline">Record group:</H6> <unit delimiter=", ">^ca_objects.record_group_id</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.mikan_number"><div class='unit'><H6 class="inline">Mikan Number:</H6> <unit delimiter=", ">^ca_objects.mikan_number</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.microfilm_reel"><div class='unit'><H6 class="inline">Microfilm Reel:</H6> <unit delimiter="<br/>">^ca_objects.microfilm_reel</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.volume"><div class='unit'><H6 class="inline">Volume:</H6> <unit delimiter="<br/>">^ca_objects.volume</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.file_number"><div class='unit'><H6 class="inline">File Number:</H6> <unit delimiter="<br/>">^ca_objects.file_number</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.part"><div class='unit'><H6 class="inline">Part:</H6> <unit delimiter="<br/>">^ca_objects.part</unit></div></ifdef>}}}
							{{{<ifdef code="ca_objects.MARC_generalNote"><div class='unit'><h6>Notes</h6>^ca_objects.MARC_generalNote</div></ifdef>}}}
							{{{<ifdef code="ca_objects.ISADG_archNote"><div class='unit'><h6>Note on Description</h6>^ca_objects.ISADG_archNote</div></ifdef>}}}
<?php
							print "<div class='unit'><H6>Permalink</H6><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("object_id"))."</textarea></div>";		
?>
						</div>
					</div>
					{{{<ifdef code="ca_objects.NCTR_URL|ca_objects.Koerner_URL">
						<div class="collapseBlock">
							<h3>Other Repositories <i class="fa fa-toggle-down" aria-hidden="true"></i></h3>
							<div class="collapseContent">
								<ifdef code="ca_objects.nctr_URL"><div class='unit'><h6>National Centre for Truth and Reconciliation</h6><unit delimiter=", "><a href="^ca_objects.nctr_URL" target="_blank">^ca_objects.nctr_URL</a></unit></div></ifdef>
								<ifdef code="ca_objects.Koerner_URL"><div class='unit'><h6>University of British Columbia Libraries</h6><unit delimiter=", "><a href="^ca_objects.Koerner_URL" target="koerner_URL">^ca_objects.Koerner_URL</a></unit></div></ifdef>				
							</div>
						</div>
					</ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "2" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools">';
					if ($this->getVar("resultsLink")) {
						print '<div class="detailTool detailToolInline detailNavFull detailNavFull">'.$this->getVar("resultsLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("previousLink")) {
						print '<div class="detailTool detailToolInline detailNavFull detailNavFull">'.$this->getVar("previousLink").'</div><!-- end detailTool -->';
					}
					if ($this->getVar("nextLink")) {
						print '<div class="detailTool detailToolInline detailNavFull detailNavFull">'.$this->getVar("nextLink").'</div><!-- end detailTool -->';
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
								<h3>Discussion</H3>
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