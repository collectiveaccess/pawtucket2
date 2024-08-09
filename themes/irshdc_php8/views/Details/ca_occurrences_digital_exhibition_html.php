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

	AssetLoadManager::register("storymap");
	AssetLoadManager::register("soundcite");

	AssetLoadManager::register('timeline');
	$va_options = $this->getVar("config_options"); 
	$t_item = 				$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");	# --- not you can enable / disable the discussion section per exhibition too with include_discussion attribute
	$vb_include_discussion = false;
	if($t_item->get("include_discussion") && strToLower($t_item->get("include_discussion", array("convertCodesToDisplayText" => true))) == "yes"){
		$vb_include_discussion = true;
	}
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
	
	# --- section indicated which content_block section to load for the exhibition.  If not defined, load the first section
	$pn_content_block_id = $this->request->getParameter('section', pInteger);
	$vb_show_related = false;
	if($this->request->getParameter('related', pString) == "resources"){
		$vb_show_related = true;
	}
	
	$t_list = new ca_lists();
 	$vn_digital_exhibit_object_type_id = $t_list->getItemIDFromList('object_types', 'digitalExhibitObject'); 		
 					
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
	}elseif(strpos($vs_last_find, "listing") !== false){
		$vs_link_text = "Exhibitions";	
	}
	if($vs_link_text){
		$va_params["row_id"] = $t_item->getPrimaryKey();
 		$va_breadcrumb_trail[] = $o_context->getResultsLinkForLastFind($this->request, "ca_occurrences", $vs_link_text, null, $va_params);		
 	}else{
 		$va_breadcrumb_trail[] = caNavLink($this->request, "Explore Exhibitions", '', 'Listing', 'DigitalExhibitions', '');
 	}
 	$va_breadcrumb_trail[] = caTruncateStringWithEllipsis($t_item->get('ca_occurrences.preferred_labels.name'), 60);
?>
	<div class="row">
		<div class="col-sm-12 digExh">
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
					# --- build an array of each content block in a section - section is a content block that has side navigation (ca_occurrences.nav_text is defined)
					$va_section_ids = array();
					$va_sections = array();
					if($qr_content_blocks->numHits()){
						while($qr_content_blocks->nextHit()){
							if(!$pn_content_block_id && !$vb_show_related){
								$pn_content_block_id = $qr_content_blocks->get("ca_occurrences.occurrence_id");
							}
							$vs_nav_img = $qr_content_blocks->get("ca_object_representations.media.medium.url");
							if($vs_link_text = $qr_content_blocks->get("ca_occurrences.nav_text")){
								$va_section_ids[] = $qr_content_blocks->get("ca_occurrences.occurrence_id");
								$va_section_names[$qr_content_blocks->get("ca_occurrences.occurrence_id")] = $vs_link_text;
								$vn_last_section_id = $qr_content_blocks->get("ca_occurrences.occurrence_id");
								$vs_link = "";
								
								if($pn_content_block_id == $qr_content_blocks->get("ca_occurrences.occurrence_id")){
									$vs_link_text = "<i class='fas fa-caret-right'></i> ".$vs_link_text;					
								}
								if($vs_nav_img){
									$vs_link = "<div class='digExhSideNavLinkImg' style='background-image: url(\"".$vs_nav_img."\");'><div class='digExhSideNavLink'>".$vs_link_text."</div></div>";
								}else{
									$vs_link = "<div class='digExhSideNavLink digExhSideNavLinkNoImg'>".$vs_link_text."</div>";
								}
								print caDetailLink($this->request, $vs_link, (($pn_content_block_id == $qr_content_blocks->get("ca_occurrences.occurrence_id")) ? "currentSection" : ""), 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("section" => $qr_content_blocks->get("ca_occurrences.occurrence_id")));
							}
							$va_sections[$vn_last_section_id][] = $qr_content_blocks->get("ca_occurrences.occurrence_id");
						}
						$qr_content_blocks->seek(0);
					}
					if($vn_comments_enabled && $vb_include_discussion){
						$vs_nav_img = $t_item->get("ca_occurrences.discussionBG.medium.url");
						if($vs_nav_img){
							$vs_link = "<div class='digExhSideNavLinkImg' style='background-image: url(\"".$vs_nav_img."\");'><div class='digExhSideNavLink'>Discussion</div></div>";
						}else{
							$vs_link = "<div class='digExhSideNavLink digExhSideNavLinkNoImg'>Discussion</div>";
						}
						print "<a href='#comments'>".$vs_link."</a>";
					}
					if($vb_related){
						$vs_nav_img = $t_item->get("ca_occurrences.resourcesBG.medium.url");
						if($vs_nav_img){
							$vs_link = "<div class='digExhSideNavLinkImg' style='background-image: url(\"".$vs_nav_img."\");'><div class='digExhSideNavLink'>Related Resources</div></div>";
						}else{
							$vs_link = "<div class='digExhSideNavLink digExhSideNavLinkNoImg'>Related Resources</div>";
						}
						print caDetailLink($this->request, $vs_link, (($vb_show_related) ? "currentSection" : ""), 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("related" => "resources"));
						#print "<a href='#related'><div class='digExhSideNavLink digExhSideNavLinkNoImg'>Related Resources</div></a>";
					}
					print "<div class='digExhSideNavLinkOut'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_occurrences", "row_id" => $t_item->get("occurrence_id")));
					print "<a href='https://irshdc.ubc.ca/for-survivors/healing-and-wellness-resources/' target='_blank'>Wellness & Support</a>";
					#print caDetailLink($this->request, "<span class='glyphicon glyphicon-download'></span> Download as PDF", "", "ca_occurrences", $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
					print "</div>";
					
?>
					</div>
				</div>
				<div class="col-sm-12 col-md-10 col-lg-8 col-lg-offset-1">
					<div class="digExhContent">
<?php
					#if ($this->getVar("resultsLink")) {
					#	# --- breadcrumb trail only makes sense when there is a back button
					#	print "<div class='row'><div class='col-sm-12 breadcrumbTrail'><small>";
					#	print join(" > ", $va_breadcrumb_trail);
					#	print "</small></div></div>";
					#}

					if(!$vs_hero){
?>
						<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
<?php
					}
?>
					<div class="digExhSideNavMobile">
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle" type="button" id="JumpToMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-bars" aria-hidden="true"></i> MENU
							</button>
							<div class="dropdown-menu" aria-labelledby="JumpToMenu">
<?php
								if($qr_content_blocks->numHits()){
									while($qr_content_blocks->nextHit()){
										if($vs_link_text = $qr_content_blocks->get("ca_occurrences.nav_text")){
											print "<li>".caDetailLink($this->request, $vs_link_text, '', 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("section" => $qr_content_blocks->get("ca_occurrences.occurrence_id")))."</li>";
							
										}
									}
								}
								if($vn_comments_enabled && $vb_include_discussion){
									print "<li><a href='#comments'>Discussion</a></li>";
								}
								if($vb_related){
									print "<li>".caDetailLink($this->request, "Related Resources", '', 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("related" => "resources"))."</li>";
								}
								print "<li role='separator' class='divider'></li>";
								print "<li class='redLink'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "table" => "ca_occurrences", "row_id" => $t_item->get("occurrence_id")))."</li>";
								#print "<li class='redLink'>".caDetailLink($this->request, "<span class='glyphicon glyphicon-download'></span> Download as PDF", "", "ca_occurrences", $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</li>";

?>						
							</div>
						</div>
					</div>
<?php
					#$qr_content_blocks->seek(0);
					#if($qr_content_blocks->numHits()){
					# --- only display the content blocks for the current section
				
									
				if($pn_content_block_id){
					$qr_section_content_blocks = caMakeSearchResult("ca_occurrences", $va_sections[$pn_content_block_id]);
					if(is_array($va_sections[$pn_content_block_id]) && sizeof($va_sections[$pn_content_block_id])){
						if($qr_section_content_blocks->numHits()){
							$vn_block_count;
							while($qr_section_content_blocks->nextHit()){
								$vn_block_count++;
								$vs_format = $qr_section_content_blocks->get("display_options", array("convertCodesToDisplayText" => true));
								$vs_content_block_title = $qr_section_content_blocks->get("ca_occurrences.preferred_labels.name");
								if($vs_content_block_title == "[BLANK]"){
									$vs_content_block_title = "";
								}
								$vs_content_block_subtitle = $qr_section_content_blocks->get("ca_occurrences.contentBlockSubtitle");
								$vs_quote = $qr_section_content_blocks->get("description");
								$vs_main_text = $qr_section_content_blocks->get("main_text");

								$vn_set_id = "";
								$vs_set_code = $qr_section_content_blocks->get("ca_occurrences.set_code");	
								$t_set = new ca_sets();
								if($vs_set_code){				
									$t_set->load(array("set_code" => $vs_set_code));
									if(!in_array($t_set->get("ca_sets.access"), $va_access_values)){
										$t_set = new ca_sets();
									}
								}
							
								$vs_featured_image = "";
								$vn_featured_object_ids = $qr_section_content_blocks->get("ca_objects.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
								$vn_featured_object_id = $vn_featured_object_ids[0];
					
								if($vn_featured_object_id){
									# --- display the rep viewer for the featured object so if it's video, it will play
									$t_featured_object = new ca_objects($vn_featured_object_id);
									$t_representation = $t_featured_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
									if($t_representation){
										$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
										$vs_version = $va_media_display_info["display_version"];
										$vb_link_to_object = false;
										if(($t_featured_object->get("ca_objects.type_id") != $vn_digital_exhibit_object_type_id) || (($t_featured_object->get("ca_objects.type_id") == $vn_digital_exhibit_object_type_id) && ($t_featured_object->get("ca_objects.display_detail_page", array("convertCodesToDisplayText" => true)) == "Yes"))){
											$vb_link_to_object = true;
										}
										if($qr_section_content_blocks->get("ca_occurrences.caption")){
											$vs_caption = $qr_section_content_blocks->get("ca_occurrences.caption");
										}else{
											$vs_caption = $t_featured_object->get("ca_objects.preferred_labels.name");
										}
										#if($vb_link_to_object){
										#	$vs_caption = "<div class='mediaViewerCaption text-center'>".caDetailLink($this->request, $vs_caption, '', "ca_objects", $vn_featured_object_id)."</div>";
										#}else{
											$vs_caption = "<div class='mediaViewerCaption text-center'>".$vs_caption."</div>";
										#}
										if($vs_version == "large"){
											$vs_featured_image = $t_representation->get("ca_object_representations.media.".$vs_version);
											#if($vb_link_to_object){
											#	$vs_featured_image = caDetailLink($this->request, $vs_featured_image, '', "ca_objects", $vn_featured_object_id);
											#}
											$vs_featured_image = '<a href="#" onclick="caMediaPanel.showPanel(\''.caNavUrl($this->request, "", "Detail", "GetMediaOverlay", array("context" => "objects", "id" => $t_featured_object->get("ca_objects.object_id"), "representation_id" => $t_representation->get("ca_object_representations.representation_id"), "overlay" => 1)).'\'); return false;">'.$vs_featured_image.'</a>';
											if($vs_caption){
												$vs_featured_image .= $vs_caption;
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
																			'captionTemplate' => $vs_caption
																		)
																	);
										}
									}
								}

	?>
								<div class="digExhContentBlock">
									<a name="<?php print $qr_section_content_blocks->get("ca_occurrences.idno"); ?>" class="digExhAnchors<?php print ($vn_block_count > 1) ? " offset" : ""; ?>"></a>
	<?php
									if($vs_content_block_title){
										if($vn_block_count > 1){
											print "<HR></HR>";
										}
										print "<h2>".$vs_content_block_title."</h2>";
									}
									if($vs_content_block_subtitle){
										print "<div class='contentBlockSubTitle'>".$vs_content_block_subtitle."</div>";
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
													<div class='quote'><?php print $vs_quote; ?></div>
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
													<div class='quote'><?php print $vs_quote; ?></div>
												</div>
											</div>
	<?php										
										}elseif(!$vs_main_text && $vs_featured_image && $vs_quote){
	?>
											<div class="row digExhUnit">
												<div class="col-sm-12 col-md-6 vcenter">
													<div class='quote'><?php print $vs_quote; ?></div>
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
											print "<div class='digExhUnit digExhUnitOneColImage text-center'>".$vs_featured_image."</div>";
										}
										if($vs_quote){
											print "<div class='quoteMargin'>".$vs_quote."</div>";
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
													<div id="storymap<?php print "{$vn_set_id}_{$vn_block_count}"; ?>" class="storymapContainer"></div><!-- end browseResultsContainer -->
												
													<script>
														jQuery(document).ready(function() {
															// storymap_data can be an URL or a Javascript object
															//var storymap_data = '//media.knightlab.com/StoryMapJS/demo/demo.json';
															var storymap_data = '<?php print $this->request->config->get("site_host").caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'storymap', 'set_id' => $vn_set_id, 'download' => 1)); ?>';

															// certain settings must be passed within a separate options object
															var storymap_options = {};

															var storymap = new VCO.StoryMap('storymap<?php print "{$vn_set_id}_{$vn_block_count}"; ?>', storymap_data, storymap_options);
															window.onresize = function(event) {
																storymap.updateDisplay(); // this isn't automatic
															}
														});
													</script>
	<?php
												break;
												# ------------------------------------------------------
												case "timelines":
	?>
													<div id="digExhTimeline">
														<div id="timeline-embed-<?php print $vn_set_id."-".$vn_block_count; ?>"></div>
													</div>

													<script type="text/javascript">
														jQuery(document).ready(function() {
															createStoryJS({
																type:       'timeline',
																width:      '100%',
																height:     '500px',
																source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $vn_set_id)); ?>',
																embed_id:   'timeline-embed-<?php print $vn_set_id."-".$vn_block_count; ?>',
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
	?>
														<div class="digExhSlideContainer">
															<div class='digExhSlide digExhSlide<?php print $vn_set_id; ?>'></div>
															<!-- Prev/next controls -->
															<a href="#" class="digExhDetailPrev digExhDetailPrev<?php print $vn_set_id; ?>" onClick="previousSlide<?php print $vn_set_id; ?>(); return false;"><i class="fa fa-angle-left" aria-label="<?php print _t("Previous"); ?>"></i></a>
															<a href="#" class="digExhDetailNext digExhDetailNext<?php print $vn_set_id; ?>" onClick="nextSlide<?php print $vn_set_id; ?>(); return false;"><i class="fa fa-angle-right" aria-label="<?php print _t("Next"); ?>"></i></a>

															<!-- Pagination -->
															<p class="digExhPagination" id="digExhPagination<?php print $vn_set_id; ?>">
														<?php
															$i = 0;
															foreach($va_set_item_ids as $vn_item_id){
																$i++;
																print "<a href='#' id='pageNum".$vn_set_id.$vn_item_id."' onClick='showLoading".$vn_set_id."(); highlightPagination".$vn_set_id."(\"".$vn_item_id."\"); jQuery(\".digExhSlide".$vn_set_id."\").load(\"".caNavUrl($this->request, '', 'Gallery', 'ajaxGetDigExhibitionSlide', array('set_id' => $vn_set_id, 'set_item_id' => $vn_item_id))."\"); return false;'>".$i."</a>";
															}
														?>
															</p>
														</div><!-- end digExhSlideContainer -->
	
														<script type='text/javascript'>
																jQuery(document).ready(function() {		
																	jQuery(".digExhSlide<?php print $vn_set_id; ?>").load("<?php print caNavUrl($this->request, '', 'Gallery', 'ajaxGetDigExhibitionSlide', array('set_id' => $vn_set_id, 'set_item_id' => $va_set_item_ids[0])); ?>");
																	highlightPagination<?php print $vn_set_id; ?>("<?php print $va_set_item_ids[0]; ?>");
																});
																var i<?php print $vn_set_id; ?> = 0;    
																var slides<?php print $vn_set_id; ?> = <?php print json_encode($va_set_item_ids); ?>; 
																function showLoading<?php print $vn_set_id; ?>(){
																	jQuery(".digExhSlide<?php print $vn_set_id; ?>").html("<div class='digExhSlideLoader'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>");
																}
																function highlightPagination<?php print $vn_set_id; ?>(id) {		
																	i<?php print $vn_set_id; ?> = slides<?php print $vn_set_id; ?>.indexOf(parseInt(id));
																	jQuery("#digExhPagination<?php print $vn_set_id; ?> a").removeClass("active");
																	jQuery("#pageNum<?php print $vn_set_id;?>" + id).addClass("active");
																}
																function nextSlide<?php print $vn_set_id; ?>(){
																	showLoading<?php print $vn_set_id; ?>();
																	i<?php print $vn_set_id; ?> = (i<?php print $vn_set_id; ?>+1)%slides<?php print $vn_set_id; ?>.length;
																	jQuery(".digExhSlide<?php print $vn_set_id; ?>").load("<?php print caNavUrl($this->request, '', 'Gallery', 'ajaxGetDigExhibitionSlide', array('set_id' => $vn_set_id)); ?>/set_item_id/" + slides<?php print $vn_set_id; ?>[i<?php print $vn_set_id; ?>]);	
																	highlightPagination<?php print $vn_set_id; ?>(slides<?php print $vn_set_id; ?>[i<?php print $vn_set_id; ?>]);
																}
																function previousSlide<?php print $vn_set_id; ?>(){
																	showLoading<?php print $vn_set_id; ?>();
																	i<?php print $vn_set_id; ?> = (i<?php print $vn_set_id; ?>-1);
																	if(i<?php print $vn_set_id; ?> < 0){
																		i<?php print $vn_set_id; ?> = slides<?php print $vn_set_id; ?>.length - 1;
																	}
																	jQuery(".digExhSlide<?php print $vn_set_id; ?>").load("<?php print caNavUrl($this->request, '', 'Gallery', 'ajaxGetDigExhibitionSlide', array('set_id' => $vn_set_id)); ?>/set_item_id/" + slides<?php print $vn_set_id; ?>[i<?php print $vn_set_id; ?>]);	
																	highlightPagination<?php print $vn_set_id; ?>(slides<?php print $vn_set_id; ?>[i<?php print $vn_set_id; ?>]);
																}
														</script>
	<?php																								
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
					}
					# --- out put link to next/previous section if available
					$vn_section_index = array_search($pn_content_block_id, $va_section_ids);
					$vs_next_section_link = $vs_previous_section_link = "";
					if($va_section_ids[$vn_section_index + 1]){
						$vs_next_section_link = caDetailLink($this->request, 'Next: '.$va_section_names[$va_section_ids[$vn_section_index + 1]]." <i class='fa fa-caret-right' aria-hidden='true'></i>", 'btn btn-default', 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("section" => $va_section_ids[$vn_section_index + 1]));
					}
					if(($vn_section_index > 0) && ($va_section_ids[$vn_section_index - 1])){
						$vs_previous_section_link = caDetailLink($this->request, "<i class='fa fa-caret-left' aria-hidden='true'></i> Previous: ".$va_section_names[$va_section_ids[$vn_section_index - 1]], 'btn btn-default', 'ca_occurrences', $t_item->get("ca_occurrences.occurrence_id"), array("section" => $va_section_ids[$vn_section_index - 1]));
					}
					if($vs_next_section_link || $vs_previous_section_link){
						print "<p class='text-center sectionNavigationLinks'>".$vs_previous_section_link.(($vs_next_section_link && $vs_previous_section_link) ? "&nbsp;&nbsp;&nbsp;" : "").$vs_next_section_link."</p><br/>";
					}
				}
				if ($vn_comments_enabled && $vb_include_discussion) {
?>				
					<div class="digExhContentBlock discussion">
						<a name="comments" class="digExhAnchors offset"></a>
<?php
						if(!$vb_show_related){
?>
							<HR/>
<?php						
						}
?>
						
							<div id="detailDiscussion">
								<h2>Discussion</h2>
								Do you have a story or comment to contribute?<br/>
<?php								
								if($this->request->isLoggedIn()){
									print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_occurrences", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")."</button>";
								}else{
									print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment")."</button>";
								}
?>
							</div>
<?php
							if($vn_num_comments){
?>
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
<?php
							}
?>
					</div>
<?php
				}
				if($vb_related && $vb_show_related){
?>
						<div class="digExhContentBlock digExhRelated">
							<a name="related" class="digExhAnchors"></a>
							<h2>Related Resources</h2>
							{{{<ifdef code="ca_occurrences.relatedResourcesIntro">
								<div class="relatedBlock">^ca_occurrences.relatedResourcesIntro</div>
							</ifdef>}}}
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
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'all_objects', array('facet' => 'detail_occurrence_dig_exhibition', 'id' => '^ca_occurrences.occurrence_id', 'detailNav' => 'digital_exhibition', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
			var scrollLimit = jQuery('.digExhContent').offset();
			jQuery(window).scroll(function () {
				var scrollTop = $(window).scrollTop();
				var bodyHeight = jQuery('body').height();
				var footerHeight = jQuery('#footer').height() + 40;
				// check the visible top of the browser
				if ((scrollTop > scrollLimit.top - jQuery('nav').height()) && (scrollTop < (bodyHeight - (jQuery(window).height() - 130)))) { // 83 = height of header
					jQuery('.digExhSideNav').addClass('fixed');
					jQuery('.digExhSideNav').width(jQuery('.digExhSideNav').parent().width());
					$('.digExhSideNav').css('max-height', jQuery(window).height() - jQuery('nav').height() + 'px');
				} else {
					jQuery('.digExhSideNav').removeClass('fixed');
					$('.digExhSideNav').css('max-height', 'auto');
				}
			});
			$(window).resize(function() {
				jQuery('.digExhSideNav').width(jQuery('.digExhSideNav').parent().width());
			});
		}
	});
</script>
