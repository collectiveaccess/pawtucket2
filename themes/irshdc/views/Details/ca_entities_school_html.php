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
<?php
				$vs_representationViewer = trim($this->getVar("representationViewer"));
				if($vs_representationViewer){
?>
				<div class='col-sm-12 col-md-4'>
					<?php print $vs_representationViewer; ?>
				
				
					<div id="detailAnnotations"></div>
<?php				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4"));

					if($vs_map = $this->getVar("map")){
						print "<div class='unit'>".$vs_map."</div>";
					}
?>

				</div><!-- end col -->
<?php
				}
?>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "5" : "7"; ?>'>
					<div class="stoneBg">	
						{{{<ifdef code="ca_entities.preferred_labels.displayname">
							<H4><span data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.school_name_source">^ca_entities.preferred_labels.displayname</span>
								<ifdef code="ca_entities.entity_website"><br/><a href="^ca_entities.entity_website" class='redLink' target="_blank">^ca_entities.entity_website <span class="glyphicon glyphicon-new-window"></span></a></div></ifdef>
							</H4>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.school_dates.school_dates_value">
							<div class='unit' data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.school_dates.date_source">
								<H6>Dates of operation</H6>
								<unit delimiter="<br/><br/>">
									<ifdef code="ca_entities.school_dates.school_dates_value">^ca_entities.school_dates.school_dates_value<br/></ifdef>
									<ifdef code="ca_entities.school_dates.date_narrative"><span class="trimText">^ca_entities.school_dates.date_narrative</span><br/></ifdef>
								</unit>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.description_new.description_new_txt">
							<div class="unit" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.description_new.description_new_source"><h6>Description</h6>
								<span class="trimText">^ca_entities.description_new.description_new_txt</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.community_input_objects.comments_objects">
							<div class='unit' data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.community_input_objects.comment_reference_objects"><h6>Dialogue</h6>
								<span class="trimText">^ca_entities.community_input_objects.comments_objects</span>
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.denomination"><div class='unit'><H6>Denomination</H6>^ca_entities.denomination%delimiter=,_</div></ifdef>}}}		
<!-- related organizations and individual here or with the list of related at bottom? -->					
						{{{<ifdef code="ca_entities.home_community.home_community_text"><div class='unit'><H6>Home Communities of Students</H6><unit delimiter="<br/>"><span data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.home_community.home_community_source">^ca_entities.home_community.home_community_text</span></unit></div></ifdef>}}}					
					</div><!-- end stoneBg -->
				</div>
				<div class='col-sm-12 col-md-<?php print ($vs_representationViewer) ? "3" : "5"; ?>'>
	<?php
					# Comment and Share Tools
						
					print '<div id="detailTools" class="detailToolsInline">';
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Ask a Question", "", "", "Contact", "Form", array("contactType" => "askArchivist", "entity_id" => $t_item->get("entity_id")))."</div>";
					print '</div><!-- end detailTools -->';			

							# --- themes AKA "Local" subjects
							$va_attributes = array("narrative_thread" => "narrative_threads_facet", "themes" => "theme_facet", "keywords" => "keyword_facet");
							$vs_themes = "";
							$t_list = new ca_lists();
							foreach($va_attributes as $vs_attribute => $vs_facet){
								if($va_themes = $t_item->get("ca_entities.".$vs_attribute, array("returnAsArray" => true))){
									foreach($va_themes as $vn_theme_id){
										$vs_theme_name = $t_list->getItemFromListForDisplayByItemID($vs_attribute, $vn_theme_id);
										$vs_themes .= caNavLink($this->request, "<i class='fa fa-angle-right' aria-hidden='true'></i> ".$vs_theme_name." <span>(".str_replace("_", " ", $vs_attribute).")</span>", "", "", "browse", "objects", array("facet" => $vs_facet, "id" => $vn_theme_id));
									}
								}
							}
							
							if($vs_themes){
?>							
								<div class="block">
									<h3>Themes</H3>
									<div class="blockContent trimTextSubjects">
<?php
											print $vs_themes; 
											
?>
									</div>
								</div>
<?php
							}

						if ($vn_comments_enabled) {
							$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
							<div class="collapseBlock">
								<h3>Discussion <i class="fa fa-toggle-up" aria-hidden="true"></i></H3>
								<div class="collapseContent open">
									<div id='detailDiscussion'>
										Do you have a story to contribute related to these records or a comment about this item?<br/>
<?php
										
										if($this->request->isLoggedIn()){
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_entities", "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your tags and comment")."</button>";
										}else{
											print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment on this record")."</button>";
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
							
							{{{<ifdef code="ca_entities.nonpreferred_labels.displayname">
								<div class="collapseBlock">
									<h3>Alternate Names <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent"><h6></h6>	
										<unit relativeTo="ca_entities" delimiter="<br/>">
											<div class="unit" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_entities.alt_name_source">
												^ca_entities.nonpreferred_labels.displayname
											<div>
										</unit>
									</div>
								</div>
							</ifdef>}}}
							{{{<ifdef code="ca_entities.alternate_text.alternate_desc_upload.url">
								<div class="collapseBlock">
									<h3>Research Guide <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<div class='unit icon transcription'><h6></h6><unit relativeTo="ca_entities" delimiter="<br/>"><ifdef code="ca_entities.alternate_text.alternate_desc_upload"><a href="^ca_entities.alternate_text.alternate_desc_upload.url%version=original">View ^ca_entities.alternate_text.alternate_text_type</a></ifdef><ifdef code="ca_entities.alternate_text.alternate_desc_note">^ca_entities.alternate_text.alternate_desc_note</ifdef></unit></div>
									</div>
								</div>
							</ifdef>}}}
							{{{<ifdef code="ca_entities.public_notes">
								<div class="collapseBlock">
									<h3>Notes <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
									<div class="collapseContent">
										<ifdef code="ca_entities.public_notes"><div class='unit'><h6></h6>^ca_entities.public_notes%delimiter=<br/></div></ifdef>
									</div>
								</div>
							</ifdef>}}}
							<div class="collapseBlock last">
								<h3>Permalink <i class="fa fa-toggle-down" aria-hidden="true"></i></H3>
								<div class="collapseContent">
									
<?php
						print "<div class='unit'><br/><textarea name='permalink' id='permalink' class='form-control input-sm'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'entities/'.$t_item->get("entity_id"))."</textarea></div>";
					
?>
								</div>
							</div>
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-sm-12">		
<?php
					# --- get all related authority records for tabbed presentation
					$vs_rel_schools = $vs_rel_communities = $vs_rel_places = $vs_rel_entities = $vs_rel_events = $vs_rel_exhibitions = $vs_rel_collections = $vs_rel_fonds;
					$vs_rel_schools = $t_item->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="school" restrictToRelationshipTypes="related" min="1"><div class="row relTab" id="relSchools"><unit relativeTo="ca_entities" restrictToTypes="school" restrictToRelationshipTypes="related" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_places = $t_item->getWithTemplate('<ifcount code="ca_places.related" min="1"><div class="row relTab" id="relPlaces"><unit relativeTo="ca_places" delimiter=", "><div class="col-sm-12 col-md-3"><l><span>^ca_places.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_entities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" excludeTypes="school,community" min="1"><div class="row relTab" id="relEntities"><unit relativeTo="ca_entities" excludeTypes="school,community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></div></unit></div></ifcount>');
					$vs_rel_communities = $t_item->getWithTemplate('<ifcount code="ca_entities.related" restrictToTypes="community" min="1"><div class="row relTab" id="relCommunities"><unit relativeTo="ca_entities" restrictToTypes="community" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_entities.preferred_labels.displayname (^relationship_typename)</l></div></unit></div></ifcount>');
					$vs_rel_events = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="institutional" min="1"><div class="row relTab" id="relEvents"><unit relativeTo="ca_occurrences" restrictToTypes="institutional" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_exhibitions = $t_item->getWithTemplate('<ifcount code="ca_occurrences.related" restrictToTypes="exhibitions" min="1"><div class="row relTab" id="relExhibitions"><unit relativeTo="ca_objects_x_occurrences" restrictToTypes="exhibitions" delimiter=", "><unit relativeTo="ca_occurrences" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_occurrences.preferred_labels.name (^relationship_typename)</span></l></div></unit></unit></div></ifcount>');
					$vs_rel_collections = $t_item->getWithTemplate('<ifcount code="ca_collections.related" restrictToTypes="collection" min="1"><div class="row relTab" id="relCollections"><unit relativeTo="ca_collections" restrictToTypes="collection" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					$vs_rel_fonds = $t_item->getWithTemplate('<ifcount code="ca_collections.related" excludeTypes="collection,source" min="1"><div class="row relTab" id="relFonds"><unit relativeTo="ca_collections" excludeTypes="collection,source" delimiter=" "><div class="col-sm-12 col-md-3"><l><span>^ca_collections.preferred_labels.name (^relationship_typename)</span></l></div></unit></div></ifcount>');
					
					
					if($vs_rel_schools || $vs_rel_places || $vs_rel_entities || $vs_rel_events || $vs_rel_exhibitions || $vs_rel_collections || $vs_rel_fonds){
?>				
						<div class="relatedBlock relatedBlockTabs">
							<h3>
<?php
								$vs_firstTab = "";
								if($vs_rel_schools){
									print "<div id='relSchoolsButton' class='relTabButton' onClick='toggleTag(\"relSchools\");'>Schools</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relSchools";
									}
								}
								if($vs_rel_places){
									print "<div id='relPlacesButton' class='relTabButton' onClick='toggleTag(\"relPlaces\");'>Places</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relPlaces";
									}
								}
								if($vs_rel_entities){
									print "<div id='relEntitiesButton' class='relTabButton' onClick='toggleTag(\"relEntities\");'>People/Organizations</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEntities";
									}
								}
								if($vs_rel_communities){
									print "<div id='relCommunitiesButton' class='relTabButton' onClick='toggleTag(\"relEntities\");'>Communities</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCommunities";
									}
								}
								if($vs_rel_events){
									print "<div id='relEventsButton' class='relTabButton' onClick='toggleTag(\"relEvents\");'>Events</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relEvents";
									}
								}
								if($vs_rel_exhibitions){
									print "<div id='relExhibitionsButton' class='relTabButton' onClick='toggleTag(\"relExhibitions\");'>Exhibitions</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relExhibitions";
									}
								}
								if($vs_rel_collections){
									print "<div id='relCollectionsButton' class='relTabButton' onClick='toggleTag(\"relCollections\");'>Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relCollections";
									}
								}
								if($vs_rel_collections){
									print "<div id='relFondsButton' class='relTabButton' onClick='toggleTag(\"relFonds\");'>Fonds/Archival Collections</div>";
									if(!$vs_firstTab){
										$vs_firstTab = "relFonds";
									}
								}
?>
							</h3>
							<div class="relatedBlockContent">							
<?php
								print $vs_rel_schools.$vs_rel_places.$vs_rel_entities.$vs_rel_communities.$vs_rel_events.$vs_rel_exhibitions.$vs_rel_collections.$vs_rel_fonds;
?>
							</div>
						</div>
						<script type="text/javascript">
							function toggleTag(ID){
								$('.relTab').css('display', 'none');
								$('#' + ID).css('display', 'block');
								$('.relTabButton').removeClass('selected');
								$('#' + ID + 'Button').addClass('selected');
							}
							jQuery(document).ready(function() {
								toggleTag("<?php print $vs_firstTab; ?>");
							});
						</script>
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
											jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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