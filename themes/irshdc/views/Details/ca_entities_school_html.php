<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_school_html.php : 
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
 
	$t_item = 				$this->getVar("item");
	$va_comments =			$this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_id =				$t_item->get('ca_entities.entity_id');
	
	$va_access_values = $this->getVar("access_values");
	$va_breadcrumb_trail = array(caNavLink($this->request, "Home", '', '', '', ''));
	$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_entities");
	$vs_last_find = strToLower($o_context->getLastFind($this->request, "ca_entities"));
	$vs_link_text = "";
	if(strpos($vs_last_find, "browse") !== false){
		$vs_link_text = "Find";	
	}elseif(strpos($vs_last_find, "search") !== false){
		$vs_link_text = "Search";	
	}elseif(strpos($vs_last_find, "gallery") !== false){
		$vs_link_text = "Explore Features";	
	}elseif(strpos($vs_last_find, "school") !== false){
		$vs_link_text = "Explore Schools";	
	}elseif(strpos($vs_last_find, "front") !== false){
		# --- home link is always in breadcrumb trail
		$vs_link_text = "";	
	}
	if($vs_link_text){
		$va_params["row_id"] = $t_item->getPrimaryKey();
 		$va_breadcrumb_trail[] = $o_context->getResultsLinkForLastFind($this->request, "ca_entities", $vs_link_text, null, $va_params);		
 	}
 	$va_breadcrumb_trail[] = caTruncateStringWithEllipsis($t_item->get('ca_entities.preferred_labels.displayname'), 60);


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
				$vs_featured_image = $t_item->getWithTemplate("<unit relativeTo='ca_objects' length='1' restrictToRelationshipTypes='featured'><ifdef code='ca_object_representations.media.large'><l>^ca_object_representations.media.large</l><ifdef code='ca_object_representations.preferred_labels.name'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></ifdef></ifdef></unit>", array("checkAccess" => $va_access_values, "limit" => 1));
				if($vs_featured_image){
?>
				<div class='col-sm-12 col-md-5 fullWidth'>
					<?php print $vs_featured_image; ?>
				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_featured_image) ? "5" : "7"; ?>'>
					<div class="stoneBg">	
						{{{<ifdef code="ca_entities.preferred_labels.displayname">
							<H4><span data-toggle="popover" title="Source" data-content="^ca_entities.school_name_source">^ca_entities.preferred_labels.displayname</span>
								<ifdef code="ca_entities.entity_website"><br/><a href="^ca_entities.entity_website" class='redLink' target="_blank">^ca_entities.entity_website <span class="glyphicon glyphicon-new-window"></span></a></div></ifdef>
							</H4>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.school_dates.school_dates_value">
							<div class='unit'>
								<H6>Dates of Operation</H6>
								<unit delimiter=" "><div  data-toggle="popover" title="Source" data-content="^ca_entities.school_dates.date_source">
									<ifdef code="ca_entities.school_dates.school_dates_value">^ca_entities.school_dates.school_dates_value<br/></ifdef>
									<ifdef code="ca_entities.school_dates.date_narrative"><div class="trimText">^ca_entities.school_dates.date_narrative</div><br/></ifdef>
								</div></unit>
							</div>
						</ifdef>}}}
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities_x_entities" restrictToTypes="school" delimiter=", "><l><unit relativeTo="ca_entities.related">^ca_entities.preferred_labels.displayname</unit></l> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</unit></div></ifcount>}}}
						{{{<ifdef code="ca_entities.description_new.description_new_txt">
							<div class="unit" data-toggle="popover" title="Source" data-content="^ca_entities.description_new.description_new_source"><h6>Description</h6>
								<div class="trimText">^ca_entities.description_new.description_new_txt</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_entities.community_input_objects.comment_reference_objects"><h6>Dialogue</h6>
								<div class="trimText">^ca_entities.community_input_objects.comments_objects</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.denomination"><div class='unit'><H6>Denomination</H6>^ca_entities.denomination%delimiter=,_</div></ifdef>}}}		
						{{{<ifdef code="ca_entities.home_community.home_community_text"><div class='unit'><H6>Home Communities of Students</H6><unit delimiter="<br/>"><span data-toggle="popover" title="Source" data-content="^ca_entities.home_community.home_community_source"><div class="trimText">^ca_entities.home_community.home_community_text</div></span></unit></div></ifdef>}}}					
					</div><!-- end stoneBg -->
<?php
						include("themes_html.php");
?>
					{{{<ifdef code="ca_entities.alternate_text.alternate_desc_upload.url">
						<div class="collapseBlock">
							<h3>Research Guide <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								<div class='unit icon transcription'><h6></h6><unit relativeTo="ca_entities" delimiter="<br/>"><ifdef code="ca_entities.alternate_text.alternate_desc_upload"><a href="^ca_entities.alternate_text.alternate_desc_upload.url%version=original">View ^ca_entities.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_entities.alternate_text.alternate_desc_note">^ca_entities.alternate_text.alternate_desc_note</ifdef></unit></div>
							</div>
						</div>
					</ifdef>}}}
					<div class="collapseBlock">
						<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
						<div class="collapseContent"><h6></h6>	
							{{{<unit relativeTo="ca_entities" delimiter="<br/>">
								<div class="unit" data-toggle="popover" title="Source" data-content="^ca_entities.alt_name_source">
									<H6>Alternate Name(s)</H6>
									^ca_entities.nonpreferred_labels.displayname
								<div>
							</unit>}}}
							{{{<ifdef code="ca_entities.public_notes"><div class='unit'><h6>Notes</h6>^ca_entities.public_notes%delimiter=<br/></div></ifdef>}}}
<?php
							print "<div class='unit'><H6>Permalink</H6><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'entities/'.$t_item->get("entity_id"))."</textarea></div>";					
?>
						</div>
					</div>
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_featured_image) ? "2" : "5"; ?>'>
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
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_entities", "row_id" => $t_item->get("entity_id")))."</div>";
					print '</div><!-- end detailTools -->';			

					if ($vn_comments_enabled) {
						$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
						<div class="collapseBlock last discussion">
							<h3>Discussion</H3>
							<div class="collapseContent open">
								<div id='detailDiscussion'>
									Do you have a story or comment about this school?<br/>
<?php
									
									if($this->request->isLoggedIn()){
										print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_entities", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
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
					include("related_tabbed_entities_html.php");
					
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

					{{{<ifcount code="ca_objects" min="1">
								<div class="relatedBlock">
								<h3>Objects</H3>
									<div class="row">
										<div id="browseResultsContainer">
											<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
										</div><!-- end browseResultsContainer -->
									</div><!-- end row -->
									<script type="text/javascript">
										jQuery(document).ready(function() {
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id', 'detailNav' => 'school'), array('dontURLEncodeParameters' => true)); ?>", function() {
												jQuery('#browseResultsContainer').jscroll({
													autoTrigger: true,
													loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
													padding: 20,
													nextSelector: 'a.jscroll-next'
												});
											});
					
					
										});
									</script>
								</div>
					</ifcount>}}}					
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
			if($vs_featured_image){
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