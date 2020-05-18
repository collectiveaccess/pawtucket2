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
?>
<link href='https://cdn.knightlab.com/libs/soundcite/latest/css/player.css' rel='stylesheet' type='text/css'><script type='text/javascript' src='https://cdn.knightlab.com/libs/soundcite/latest/js/soundcite.min.js'></script>
<?php 

$vs_mode = $this->request->getParameter("mode", pString);
#if($vs_mode == "map"){
#	include("map_large_html.php");
#}else{
	AssetLoadManager::register('timeline');
	$va_options = $this->getVar("config_options"); 
	$t_item = 				$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
	
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
		$vs_link_text = "Explore Features";	
	}elseif(strpos($vs_last_find, "school") !== false){
		$vs_link_text = "Explore Schools";	
	}elseif(strpos($vs_last_find, "listing") !== false){
		$vs_link_text = "Explore Digital Exhibitions";	
	}
	if($vs_link_text){
		$va_params["row_id"] = $t_item->getPrimaryKey();
 		$va_breadcrumb_trail[] = $o_context->getResultsLinkForLastFind($this->request, "ca_occurrences", $vs_link_text, null, $va_params);		
 	}else{
 		$va_breadcrumb_trail[] = caNavLink($this->request, "Explore Digital Exhibitions", '', 'Listing', 'DigitalExhibitions', '');
 	}
 	$va_breadcrumb_trail[] = caTruncateStringWithEllipsis($t_item->get('ca_occurrences.preferred_labels.name'), 60);
?>
	<div class="row">
		<div class="col-sm-12 digExh">
			<div class="row">
				<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
			</div>
<?php
			if($vs_hero = $t_item->get("ca_object_representations.media.page.url")){
?>
				<div class="row digExhHeroImg" style="background-image: url('<?php print $vs_hero; ?>');">
					<div class="col-sm-12 digExhHeroContent">
						<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					</div>
				</div>
<?php
			}

	$va_content_block_ids = $t_item->get("ca_occurrences.children.occurrence_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("content_blocks"), "sort" => "ca_occurrences.rank"));
	$qr_content_blocks = caMakeSearchResult("ca_occurrences", $va_content_block_ids);
	$vb_related = false;
	if($t_item->get("ca_occurrences.external_link") || $t_item->get("ca_entities.entity_id", array("checkAccess" => $va_access_values)) || $t_item->get("ca_objects.object_id", array("checkAccess" => $va_access_values)) || $t_item->get("ca_places.place_id", array("checkAccess" => $va_access_values))){
		$vb_related = true;
	}
?>
			<div class="row">
				<div class="col-sm-12 col-md-2">
					<div class="digExhSideNav">
<?php
					if($qr_content_blocks->numHits()){
						while($qr_content_blocks->nextHit()){
							$vs_nav_img = $qr_content_blocks->get("ca_object_representations.media.medium.url");
							if($vs_link_text = $qr_content_blocks->get("ca_occurrences.nav_text")){
								print "<a href='#".$qr_content_blocks->get("ca_occurrences.idno")."'>";							
								if($vs_nav_img){
									print "<div class='digExhSideNavLinkImg' style='background-image: url(\"".$vs_nav_img."\");'><div class='digExhSideNavLink'>".$vs_link_text."</div></div>";
								}else{
									print "<div class='digExhSideNavLink digExhSideNavLinkNoImg'>".$vs_link_text."</div>";
								}
								print "</a>";
							}
						}
					}
					if($vn_num_comments){
						print "<a href='#comments'><div class='digExhSideNavLink digExhSideNavLinkNoImg'>Discussion</div></a>";
					}
					if($vb_related){
						print "<a href='#related'><div class='digExhSideNavLink digExhSideNavLinkNoImg'>Related Resources</div></a>";
					}
?>
					</div>
				</div>
				<div class="col-sm-12 col-md-8">
					<div class="digExhContent">
<?php
					if ($this->getVar("resultsLink")) {
						# --- breadcrumb trail only makes sense when there is a back button
						print "<div class='row'><div class='col-sm-12 breadcrumbTrail'><small>";
						print join(" > ", $va_breadcrumb_trail);
						print "</small></div></div>";
					}

					if(!$vs_hero){
?>
						<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
<?php
					}
					$qr_content_blocks->seek(0);
					if($qr_content_blocks->numHits()){
						while($qr_content_blocks->nextHit()){
							$vs_format = $qr_content_blocks->get("display_options", array("convertCodesToDisplayText" => true));
							$vs_content_block_title = $qr_content_blocks->get("ca_occurrences.preferred_labels.name");
							if($vs_content_block_title == "[BLANK]"){
								$vs_content_block_title = "";
							}
							$vs_quote = $qr_content_blocks->get("description");
							$vs_main_text = $qr_content_blocks->get("main_text");

							$vn_set_id = "";
							$vs_set_code = $qr_content_blocks->get("ca_occurrences.set_code");	
							$t_set = new ca_sets();
							if($vs_set_code){				
								$t_set->load(array("set_code" => $vs_set_code));
								if(!in_array($t_set->get("ca_sets.access"), $va_access_values)){
									$t_set = new ca_sets();
								}
							}
							
							$vs_featured_image = "";
							$vn_featured_object_ids = $qr_content_blocks->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
							$vn_featured_object_id = $vn_featured_object_ids[0];
					
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
										$vs_featured_image .= "<div class='mediaViewerCaption text-center'>".caDetailLink($this->request, $vs_caption, '', "ca_objects", $vn_featured_object_id)."</div>";
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
																	'captionTemplate' => "<unit relativeTo='ca_objects'><l><ifdef code='ca_object_representations.preferred_labels.name'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></ifdef></l></unit>"
																)
															);
								}
							}





?>
							<div class="digExhContentBlock">
								<a name="<?php print $qr_content_blocks->get("ca_occurrences.idno"); ?>" class="digExhAnchors"></a>
<?php
								if($vs_content_block_title){
									print "<h2>".$vs_content_block_title."</h2>";
								}
								
								if($vs_format && ($vs_format != "one column")){
									
									# --- 2 columns
									if($vs_main_text && $vs_featured_image && $vs_quote){
										if($vs_main_text){
											print "<div class='digExhUnit'>".$vs_main_text."</div>";
										}
?>
										<div class="row digExhUnit">
											<div class="col-sm-12 col-md-6 vcenter">
												<div class='quote stoneBg'><?php print $vs_quote; ?></div>
											</div><!-- can't have space between col divs with vcenter class --><div class="col-sm-12 col-md-6 vcenter imgCol">
												<?php print $vs_featured_image; ?>
											</div>
										</div>
<?php	
									}elseif($vs_main_text && $vs_featured_image && !$vs_quote){
?>
										<div class="row digExhUnit">
											<div class="col-sm-12 col-md-6 vcenter imgCol">
												<?php print $vs_featured_image; ?>
											</div><!-- can't have space between col divs with vcenter class --><div class="col-sm-12 col-md-6 vcenter">
												<?php print $vs_main_text; ?>
											</div>
										</div>
<?php									
									}elseif($vs_main_text && !$vs_featured_image && $vs_quote){
?>
										<div class="row digExhUnit">
											<div class="col-sm-12 col-md-6 vcenter">
												<?php print $vs_main_text; ?>
											</div><!-- can't have space between col divs with vcenter class --><div class="col-sm-12 col-md-6 vcenter">
												<div class='quote stoneBg'><?php print $vs_quote; ?></div>
											</div>
										</div>
<?php										
									}elseif(!$vs_main_text && $vs_featured_image && $vs_quote){
?>
										<div class="row digExhUnit">
											<div class="col-sm-12 col-md-6 vcenter">
												<div class='quote stoneBg'><?php print $vs_quote; ?></div>
											</div><!-- can't have space between col divs with vcenter class --><div class="col-sm-12 col-md-6 imgCol vcenter">
												<?php print $vs_featured_image; ?>
											</div>
										</div>
<?php										
									
									}else{
										#print "vn_featured_object_id: ".$vn_featured_object_id;
									}
									
								}else{
									# --- one column
									if($vs_main_text){
										print "<div class='digExhUnit'>".$vs_main_text."</div>";
									}
									if($vs_featured_image){								
										print "<div class='digExhUnit text-center'>".$vs_featured_image."</div>";
									}
									if($vs_quote){
										print "<div class='quoteMargin stoneBg'>".$vs_quote."</div>";
									}
								}
								# --- set at bottom - needs to be full width
								if($t_set->get("ca_sets.set_id", array("convertCodesToDisplayText" => true))){
									$vn_set_id = $t_set->get("ca_sets.set_id");
?>
									<div class="digExhUnit digExhUnitSet">
<?php
										switch(strToLower($t_set->get("set_presentation_type", array("convertCodesToDisplayText" => true)))){
											case "story map":
?>
												<div id="storymap<?php print $vn_set_id; ?>" style="width: 100%; height: 600px;"></div><!-- end browseResultsContainer -->
												
												<link rel="stylesheet" href="https://cdn.knightlab.com/libs/storymapjs/latest/css/storymap.css">
												<script type="text/javascript" src="https://cdn.knightlab.com/libs/storymapjs/latest/js/storymap-min.js"></script>

												<script>
													// storymap_data can be an URL or a Javascript object
													//var storymap_data = '//media.knightlab.com/StoryMapJS/demo/demo.json';
													var storymap_data = '<?php print $this->request->config->get("site_host").caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'storymap', 'set_id' => $vn_set_id)); ?>';

													// certain settings must be passed within a separate options object
													var storymap_options = {};

													var storymap = new VCO.StoryMap('storymap<?php print $vn_set_id; ?>', storymap_data, storymap_options);
													window.onresize = function(event) {
														storymap.updateDisplay(); // this isn't automatic
													}
												</script>
<?php
											break;
											# ------------------------------------------------------
											case "timelines":
?>
												<div id="digExhTimeline">
													<div id="timeline-embed"></div>
												</div>

												<script type="text/javascript">
													jQuery(document).ready(function() {
														createStoryJS({
															type:       'timeline',
															width:      '100%',
															height:     '100%',
															source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $vn_set_id)); ?>',
															embed_id:   'timeline-embed',
															initial_zoom: '5'
														});
													});
												</script>
<?php
											break;
											# ------------------------------------------------------
											case "slideshow":
											default:
												$va_set_item_ids = array_keys(is_array($va_tmp = $t_set->getItemIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
												#$va_row_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
												if(is_array($va_set_item_ids) && sizeof($va_set_item_ids)){
													#$qr_res = caMakeSearchResult('ca_objects', $va_row_ids);
													#if($qr_res && $qr_res->numHits()){
	?>   
														<div class="jcarousel-wrapper jcarousel-wrapper<?php print $vn_set_id; ?>">
															<!-- Carousel -->
															<div class="jcarousel jcarousel<?php print $vn_set_id; ?>">
																<ul>
	<?php
																	#while($qr_res->nextHit()){
																	foreach($va_set_item_ids as $vn_item_id){	
																		
																		
					
								$t_set_item = new ca_set_items($vn_item_id);
								# --- display the rep viewer for the featured object so if it's video, it will play
								$vn_row_id = $t_set_item->get("ca_set_items.row_id");
								$t_object = new ca_objects($vn_row_id);
								$t_representation = $t_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
								if($t_representation){
									$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
									$vs_version = $va_media_display_info["display_version"];
									if($vs_version == "large"){
										$vs_media = $t_representation->get("ca_object_representations.media.".$vs_version);
										$vs_media = caDetailLink($this->request, $vs_media, '', "ca_objects", $vn_row_id);
										if($vs_caption = $t_set_item->get("ca_set_items.preferred_labels")){
											$vs_media .= "<div class='mediaViewerCaption text-center'>".caDetailLink($this->request, $vs_caption, '', "ca_objects", $vn_row_id)."</div>";
										};
									}else{
										$vs_media =  caRepresentationViewer(
																	$this->request, 
																	$t_object, 
																	$t_object,
																	array(
																		'display' => 'detail',
																		'showAnnotations' => true, 
																		'primaryOnly' => true, 
																		'dontShowPlaceholder' => true, 
																		#'captionTemplate' => "<unit relativeTo='ca_objects'><l><ifdef code='ca_object_representations.preferred_labels.name'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></ifdef></l></unit>"
																		'captionTemplate' => $t_set_item->get("ca_set_items.preferred_labels")
																	)
																);
									}
									print "<li><div class='digExhSlide'>".$vs_media."</div></li>";
									$vb_item_output = true;
								}
																														
																		
																		
																		
																		
																		#if($qr_res->get("ca_object_representations.media.large")){
																		#	if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.mediumlarge</l>', array("checkAccess" => $va_access_values))){
																		#		print "<li><div class='digExhSlide'>".$vs_media;
																		#		#$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
																		#		if($vs_caption){
																		#			#print "<div class='digExhCaption'>".$vs_caption."</div>";
																		#		}
																		#		print "</div></li>";
																		#		$vb_item_output = true;
																		#	}
																		#}
																	}
	?>
																</ul>
															</div><!-- end jcarousel -->
	<?php
															if($vb_item_output){
	?>
															<!-- Prev/next controls -->
															<a href="#" class="digExhDetailPrev"><i class="fa fa-angle-left" aria-label="<?php print _t("Previous"); ?>"></i></a>
															<a href="#" class="digExhDetailNext"><i class="fa fa-angle-right" aria-label="<?php print _t("Next"); ?>"></i></a>
		
															<!-- Pagination -->
															<p class="jcarousel-pagination digExhPagination">
															<!-- Pagination items will be generated in here -->
															</p>
	<?php
															}
	?>
														</div><!-- end jcarousel-wrapper --><br/>
														<script type='text/javascript'>
															jQuery(document).ready(function() {
																/*
																Carousel initialization
																*/
																$('.jcarousel<?php print $vn_set_id; ?>')
																	.on('jcarousel:create jcarousel:reload', function() {
																		var element = $(this),
																			width = element.innerWidth();

																		// This shows 1 item at a time.
																		// Divide `width` to the number of items you want to display,
																		// eg. `width = width / 3` to display 3 items at a time.
																		element.jcarousel('items').css('width', width + 'px');
																	})
																	.jcarousel({
																		// Options go here
																		wrap:'circular'
																	});
		
																/*
																 Prev control initialization
																 */
																$('.jcarousel-wrapper<?php print $vn_set_id; ?> .digExhDetailPrev')
																	.on('jcarouselcontrol:active', function() {
																		$(this).removeClass('inactive');
																	})
																	.on('jcarouselcontrol:inactive', function() {
																		$(this).addClass('inactive');
																	})
																	.jcarouselControl({
																		// Options go here
																		target: '-=1'
																	});
		
																/*
																 Next control initialization
																 */
																$('.jcarousel-wrapper<?php print $vn_set_id; ?> .digExhDetailNext')
																	.on('jcarouselcontrol:active', function() {
																		$(this).removeClass('inactive');
																	})
																	.on('jcarouselcontrol:inactive', function() {
																		$(this).addClass('inactive');
																	})
																	.jcarouselControl({
																		// Options go here
																		target: '+=1'
																	});
		
																/*
																 Pagination initialization
																 */
																$('.jcarousel-wrapper<?php print $vn_set_id; ?> .jcarousel-pagination')
																	.on('jcarouselpagination:active', 'a', function() {
																		$(this).addClass('active');
																	})
																	.on('jcarouselpagination:inactive', 'a', function() {
																		$(this).removeClass('active');
																	})
																	.jcarouselPagination({
																		// Options go here
																	});
															});
														</script>
	<?php
													#}											
												}
											break;
										}
?>
									</div>
<?php
								}
?>
							</div>
<?php
						}
?>


<?php
					}
					if($vn_num_comments){
?>
						<div class="digExhContentBlock">
							<a name="comments" class="digExhAnchors"></a><div class="block">
								<h2>Discussion</h2>
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
						</div>
<?php
					}
					if($vb_related){
?>
						<div class="digExhContentBlock digExhRelated">
							<a name="related" class="digExhAnchors"></a>
							<h2>Related Resources</h2>
							{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1">
								<div class="relatedBlock digExhLinks">
									<H3>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H3>
									<unit relativeTo="ca_entities" restrictToTypes="school" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>
								</div>
							</ifcount>}}}
							{{{<ifdef code="ca_occurrences.external_link.external_link_link">
								<div class="relatedBlock digExhLinks">
									<h3>Links</h3>
									<unit relativeTo="ca_occurrences.external_link" delimiter="<br/>">
										<a href="^ca_occurrences.external_link.external_link_link" target="_blank"><ifdef code="ca_occurrences.external_link.external_link_text">^ca_occurrences.external_link.external_link_text</ifdef><ifnotdef code="ca_occurrences.external_link.external_link_text">^ca_occurrences.external_link.external_link_link</ifnotdef> <span class="glyphicon glyphicon-new-window"></span></a>
									</unit>
								</div>
							</ifdef>}}}
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
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'detail_occurrence', 'id' => '^ca_occurrences.occurrence_id', 'detailNav' => 'digital_exhibition', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
<?php
					}
?>				
				
					</div>
				</div>
				<div class='col-sm-12 col-md-2'>
					<div class='digExhRightCol'>
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
					print "<div class='detailTool'><span class='glyphicon glyphicon-download'></span>".caDetailLink($this->request, "Download as PDF", "", "ca_occurrences", $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
					print '</div><!-- end detailTools -->';			

						if ($vn_comments_enabled) {
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
#					if($t_item->get("ca_places.georeference", array("checkAccess" => $va_access_values))){
#						include("map_html.php");
#					}
?>
					</div>
				</div>
			</div>
			


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
	});

	jQuery(document).ready(function() {
		if(jQuery('.digExh').height() > jQuery(window).height()){
			var scrollLimit = jQuery('.digExhRightCol').offset();
			jQuery(window).scroll(function () {
				var scrollTop = $(window).scrollTop();
				var initWidth = $('.digExhSideNav').width();
				// check the visible top of the browser
				if (scrollTop > scrollLimit.top - jQuery('nav').height()) { // 83 = height of header
					jQuery('.digExhRightCol').addClass('fixed');
					jQuery('.digExhSideNav').addClass('fixed');
					
					jQuery('.digExhSideNav').width(initWidth);
					jQuery('.digExhRightCol').width(initWidth);
				} else {
					jQuery('.digExhRightCol').removeClass('fixed');
					jQuery('.digExhSideNav').removeClass('fixed');
					
					jQuery('.digExhSideNav').width('100%');
					jQuery('.digExhSideNav').width('100%');
				}
			});
		}
	});
</script>
<?php
#}
?>