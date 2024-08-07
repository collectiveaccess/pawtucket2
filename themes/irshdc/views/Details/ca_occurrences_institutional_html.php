<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_occurrences_institutional_html.php : 
 * EVENTS
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
$vs_mode = $this->request->getParameter("mode", pString);
if($vs_mode == "map"){
	include("map_large_html.php");
}else{
	$va_options = $this->getVar("config_options"); 
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
	}elseif(strpos($vs_last_find, "school") !== false){
		$vs_link_text = "Schools";	
	}elseif(strpos($vs_last_find, "front") !== false){
		# --- home link is always in breadcrumb trail
		$vs_link_text = "";	
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
				#$vs_featured_image = $t_item->getWithTemplate("<unit relativeTo='ca_objects' length='1' restrictToRelationshipTypes='featured'><ifdef code='ca_object_representations.media.large'><l>^ca_object_representations.media.large</l><ifdef code='ca_object_representations.preferred_labels.name'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></ifdef></ifdef></unit>", array("checkAccess" => $va_access_values, "limit" => 1));
				$vs_featured_image = "";
				$vn_featured_object_id = $t_item->get("ca_objects.object_id", array("restrictToRelationshipTypes" => array("featured"), "checkAccess" => $va_access_values, "limit" => 1));
				$vs_representationViewer = trim($this->getVar("representationViewer"));
					
				if($vn_featured_object_id){
					# --- display the rep viewer for the featured object so if it's video, it will play
 					$t_featured_object = new ca_objects($vn_featured_object_id);
 					$t_representation = $t_featured_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
 					$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
 					$vs_version = $va_media_display_info["display_version"];
 					if($vs_version == "large"){
 						$vs_featured_image = $t_representation->get("ca_object_representations.media.".$vs_version);
 						$vs_featured_image = caDetailLink($this->request, $vs_featured_image, '', "ca_objects", $vn_featured_object_id);
 						if($vs_caption = $t_representation->get("ca_object_representations.preferred_labels.name")){
							if($vs_caption != "[BLANK]"){
								$vs_featured_image .= "<div class='mediaViewerCaption text-center'>".caDetailLink($this->request, $vs_caption, '', "ca_objects", $vn_featured_object_id)."</div>";
							}
						};
 					}else{
 						$vs_featured_image =  caRepresentationViewer(
													$this->request, 
													$t_featured_object, 
													$t_featured_object,
													array(
														'display' => 'detail',
														'showAnnotations' => true, 
														'primaryOnly' => true, 
														'dontShowPlaceholder' => true, 
														'captionTemplate' => "<unit relativeTo='ca_objects'><l><if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></if></l></unit>"
													)
												);
 					}
 					
				
				}
				if($vs_featured_image){								
?>
				<div class='col-sm-12 col-md-5 fullWidth'>
					<?php print $vs_featured_image; ?>
				</div><!-- end col -->
<?php
				}else{
					if($vs_representationViewer){
?>
					<div class='col-sm-12 col-md-5'>
						<?php print $vs_representationViewer; ?>				
						<div id="detailAnnotations"></div>
<?php				
						print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-3", "version" => "iconlarge"));
?>
					</div><!-- end col -->
<?php
					}
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer || $vs_featured_image) ? "5" : "7"; ?>'>
					<div class="stoneBg">				
						<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
						{{{<if rule='^ca_occurrences.hideDate%convertCodesToDisplayText=1 !~ /Yes/'><ifdef code="ca_occurrences.displayDate"><div class="unit">^ca_occurrences.displayDate</unit></ifdef><ifnotdef code="ca_occurrences.displayDate"><ifdef code="ca_occurrences.occurrence_dates"><div class="unit">^ca_occurrences.occurrence_dates</div></ifdef><ifnotdef></if>}}}
						
						{{{<ifcount code="ca_entities" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></div></ifcount>}}}
						{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class="unit"><H6>Creator<ifcount code="ca_entities.related" restrictToRelationshipTypes="creator" min="2">s</ifcount></H6><div class="trimTextShort"><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></div></ifcount>}}}
						{{{<ifcount code="ca_places" min="1"><div class="unit"><H6>Location<ifcount code="ca_places" min="2">s</ifcount></H6><unit relativeTo="ca_places">^ca_places.preferred_labels.name</unit></div></ifcount>}}}
						{{{<ifdef code="ca_occurrences.description_new.description_new_txt">
							<div class="unit" data-toggle="popover" title="Source" data-content="^ca_occurrences.description_new.description_new_source"><h6>Description</h6>
								<div class="trimTextDescription">^ca_occurrences.description_new.description_new_txt</div>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_occurrences.community_input_items.comments_objects">
							<div class='unit' data-toggle="popover" title="Source" data-content="^ca_occurrences.community_input_items.comment_reference_objects"><h6>Dialogue</h6>
								<div class="trimText">^ca_occurrences.community_input_items.comments_objects</div>
							</div>
						</ifdef>}}}
					</div><!-- end stoneBg -->
					{{{<ifdef code="ca_occurrences.public_notes">
						<div class="collapseBlock">
							<h3>More Information <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
							<div class="collapseContent">
								<ifdef code="ca_occurrences.public_notes"><div class='unit'><h6>Notes</h6>^ca_occurrences.public_notes%delimiter=<br/></div></ifdef>
							</div>
						</div>
					</ifdef>}}}
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer || $vs_featured_image) ? "2" : "5"; ?>'>
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

					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_occurrences", "row_id" => $t_item->get("occurrence_id")))."</div>";
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
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_occurrences", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
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

<?php
					if($t_item->get("ca_places.georeference", array("checkAccess" => $va_access_values))){
						include("map_html.php");
					}
?>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">
<?php
		include("related_tabbed_occ_html.php");
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
									jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_occurrence', 'id' => '^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		$('.trimTextDescription').readmore({
		  speed: 75,
		  maxHeight: 200,
		  moreLink: '<a href="#" class="moreLess">More</a>',
		  lessLink: '<a href="#" class="moreLess">Less</a>'
		});
		
		var options = {
			placement: function () {
<?php
			if($vs_representationViewer || $vs_featured_image){
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