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

	$t_item = 				$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
		
	$va_access_values = $this->getVar("access_values");
	$va_breadcrumb_trail = array(caNavLink($this->request, "Home", '', '', '', ''));
	$o_context = ResultContext::getResultContextForLastFind($this->request, "ca_occurrences");
	$vs_last_find = strToLower($o_context->getLastFind($this->request, "ca_occurrences"));
	$vs_link_text = "";
	if(strpos($vs_last_find, "browse") !== false){
		$vs_link_text = "Find";	
	}elseif(strpos($vs_last_find, "search") !== false){
		$vs_link_text = "Search";	
	}elseif(strpos($vs_last_find, "gallery") !== false){
		$vs_link_text = "Features";	
	}
	if($vs_link_text){
		$va_params["row_id"] = $t_item->getPrimaryKey();
 		$va_breadcrumb_trail[] = $o_context->getResultsLinkForLastFind($this->request, "ca_occurrences", $vs_link_text, null, $va_params);		
 	}
 	$va_breadcrumb_trail[] = caTruncateStringWithEllipsis($t_item->get('ca_occurrences.preferred_labels.name'), 60);

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
				if($vs_map = $this->getVar("map")){
?>
					<div class='col-sm-12 col-md-5'>
						<?php print $vs_map; ?>				
					</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_map) ? "5" : "7"; ?>'>
					<div class="stoneBg">				
						<H4>{{{^ca_places.preferred_labels.name}}}</H4>
						{{{<ifdef code="ca_places.parent_id"><H6><unit relativeTo="ca_places.parent"><l>^ca_places.preferred_labels.name</l></unit> > <unit relativeTo="ca_places">^ca_places.preferred_labels.name</unit></H6></ifdef>}}}
						
						{{{<ifdef code="ca_places.nonpreferred_labels.name"><div class='unit'><H6>Alternate Name(s)</H6><unit relativeTo="ca_places" delimiter="<br/>">^ca_places.nonpreferred_labels.name</unit></div></ifdef>}}}
						{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
						
						{{{<ifdef code="ca_places.description">
							<div class="unit"><h6>Description</h6>
								<div class="trimText">^ca_places.description</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_places.community_input_items.comments_objects">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_places.community_input_items.comment_reference_objects"><h6>Dialogue</h6>
								<div class="trimText">^ca_places.community_input_items.comments_objects</div>
							</div>
						</ifdef>}}}
					</div><!-- end stoneBg -->
					{{{<ifdef code="ca_places.public_notes">
						<div class="collapseBlock">
							<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								<ifdef code="ca_places.public_notes"><div class='unit'><h6>Notes</h6>^ca_places.public_notes%delimiter=<br/></div></ifdef>
							</div>
						</div>
					</ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_map) ? "2" : "5"; ?>'>
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
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_places", "row_id" => $t_item->get("place_id")))."</div>";
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
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_places", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
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
?>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">
<?php
		include("related_tabbed_html.php");
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
									jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_place', 'id' => '^ca_places.place_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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