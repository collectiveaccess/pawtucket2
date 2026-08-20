<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_repository_html.php : 
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
	$t_item = 				$this->getVar("item");
	$va_comments =			$this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$va_tags = 				$this->getVar("tags_array");
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
		$vs_link_text = "Features";	
	}elseif(strpos($vs_last_find, "school") !== false){
		$vs_link_text = "Schools";	
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
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-5 noToolBar'>
					<?php print $vs_representationViewer; ?>
				
				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "version" => "iconlarge"));
?>

				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}
						{{{<ifdef code="ca_entities.link"><br/><unit delimiter="<br/>"><a href="^ca_entities.link" class="redLink" target="_blank">^ca_entities.link <span class="glyphicon glyphicon-new-window"></span></a></unit></ifdef>}}}
					</H4>
					{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities_x_entities" restrictToTypes="school" delimiter=", "><unit relativeTo="ca_entities.related"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename<ifdef code="relationshipDate">, ^relationshipDate</ifdef>)</unit></div></ifcount>}}}
					{{{<ifdef code="ca_entities.description_new.description_new_txt">
						<div class="unit" data-toggle="popover" title="Source" data-content="^ca_entities.description_new.description_new_source"><h6>Description</h6>
							<div class="trimText">^ca_entities.description_new.description_new_txt</div>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.public_notes|ca_entities.nonpreferred_labels.displayname">
						<div class="collapseBlock">
							<h3>More Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
							<div class="collapseContent">
								<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class='unit'><H6>Alternate Name(s)</H6><unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.nonpreferred_labels.displayname</unit></div></ifdef>
								<ifdef code="ca_entities.public_notes"><div class='unit'><h6>Notes</h6>^ca_entities.public_notes%delimiter=<br/></div></ifdef>
								
							</div>
						</div>
					</ifdef>}}}
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
									Do you have a story or comment to contribute?<br/>
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
					if($t_item->get("ca_places.georeference", array("checkAccess" => $va_access_values))){
						include("map_html.php");
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
								<h3>Records</H3>
									<div class="row">
										<div id="browseResultsContainer">
											<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
										</div><!-- end browseResultsContainer -->
									</div><!-- end row -->
									<script type="text/javascript">
										jQuery(document).ready(function() {
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_entity', 'id' => '^ca_entities.entity_id', 'detailNav' => 'repository'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 110
		});
		$('.trimTextShort').readmore({
		  speed: 75,
		  maxHeight: 22
		});
		$('.trimTextSubjects').readmore({
		  speed: 75,
		  maxHeight: 85,
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
  			block.find('.glyphicon').toggleClass("glyphicon-collapse-down");
  			block.find('.glyphicon').toggleClass("glyphicon-collapse-up");
  			
		});
	});
</script>
<?php
}
?>