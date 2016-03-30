<?php
	$t_object = $this->getVar("item");
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": ".$t_object->getTypeName().": ".$t_object->get('preferred_labels'));
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$va_tags = $this->getVar("tags_array");
	$vb_files_require_login = $vb_files = false;
	$va_component_ids = $t_object->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
		if(sizeof($va_component_ids)){
			$va_components = array("learn" => array(), "explore" => array(), "practice" => array(), "teach" => array());
			$t_list = new ca_lists();
			$va_component_types = array(
				"learn" => $t_list->getItemIDFromList("object_types", "Synthesis"),
				"explore" => $t_list->getItemIDFromList("object_types", "CaseStudies"),
				"practice" => $t_list->getItemIDFromList("object_types", "Exercise"),
				"teach" => array($t_list->getItemIDFromList("object_types", "Presentation"), $t_list->getItemIDFromList("object_types", "EvaluationTool"), $t_list->getItemIDFromList("object_types", "Solutions"), $t_list->getItemIDFromList("object_types", "TeachingNotes")),
				"resource" => $t_list->getItemIDFromList("object_types", "Resource")
			);
			$va_requires_login = array($t_list->getItemIDFromList("object_types", "Presentation"), $t_list->getItemIDFromList("object_types", "EvaluationTool"), $t_list->getItemIDFromList("object_types", "Solutions"), $t_list->getItemIDFromList("object_types", "TeachingNotes"));
			$q_components = caMakeSearchResult("ca_objects", $va_component_ids);
			$t_representation = new ca_object_representations();
			$q_components->filterNonPrimaryRepresentations(false);
			while($q_components->nextHit()){
				# --- put the component display info in an array
				$va_component_info = array();
				$va_component_info["name"] = $q_components->get("ca_objects.preferred_labels.name");
				$va_component_info["type"] = $q_components->get("ca_objects.type_id", array("convertCodesToDisplayText" => true));
				$va_component_info["author"] = $q_components->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("author"), "checkAccess" => $va_access_values));
				$va_component_info["translator"] = $q_components->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("translator"), "checkAccess" => $va_access_values));
				$va_component_info["adapter"] = $q_components->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("adapter"), "checkAccess" => $va_access_values));
				$va_component_info["abstract"] = $q_components->get("ca_objects.abstract");
				$va_component_info["source"] = $q_components->get("ca_objects.source");
				$va_component_info["usage"] = $q_components->get("usage_license");
				$va_rep_ids = array();
				$va_rep_ids = $q_components->get('ca_object_representations.representation_id', array("checkAccess" => $va_access_values, "returnWithStructure" => true));
				if(sizeof($va_rep_ids) > 0){
					if(sizeof($va_rep_ids) == 1){
						$va_component_info["rep_id"] = $va_rep_ids[0];
					}else{
						$va_component_info["rep_ids"] = $va_rep_ids;
					}
				}
				$va_component_info["num_files"] = sizeof($va_rep_ids);
				#print $q_components->get("object_id")." - ".$va_component_info["rep_id"];
				if($va_component_info["rep_id"] || $va_component_info["rep_ids"]){
					$vb_files = 1;
					# --- does this resource require you to be logged in to download?
					if(!in_array($q_components->get("ca_objects.type_id"), $va_requires_login) || (in_array($q_components->get("ca_objects.type_id"), $va_requires_login) && ($this->request->isLoggedIn() && $this->request->user->getPreference("user_profile_classroom_role") == "EDUCATOR"))){
						if($va_component_info["rep_id"]){
							$t_representation->load($va_component_info["rep_id"]);
							$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
							$vs_download_version = $va_download_display_info['display_version'];
							$va_component_info["download"] = caNavLink($this->request, "<i class='fa fa-download'></i>", 'btn-default btn-orange btn-icon', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $q_components->get("ca_objects.object_id"), "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
							$va_component_info["preview"] = "<a href='#' class='btn-default btn-orange btn-icon' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $q_components->get("ca_objects.object_id"), 'representation_id' => $t_representation->getPrimaryKey(), 'overlay' => 1))."\"); return false;' title='"._t("Preview")."'><i class='fa fa-search-plus'></i></span></a>";
						}elseif(is_array($va_component_info["rep_ids"]) && sizeof($va_component_info["rep_ids"])){
							#download the all reps for the component
							$va_component_info["download"] = caNavLink($this->request, "<i class='fa fa-download'></i>", 'btn-default btn-orange btn-icon', 'Detail', 'DownloadMedia', '', array("object_id" => $q_components->get("ca_objects.object_id"), "download" => 1, "exclude_ancestors" => 1), array("title" => _t("Download %1 files", sizeof($va_component_info["rep_ids"]))));
							$va_component_info["preview"] = "<a href='#' class='btn-default btn-orange btn-icon' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $q_components->get("ca_objects.object_id"), 'representation_id' => $va_component_info["rep_ids"][0], 'overlay' => 1))."\"); return false;' title='"._t("Preview")."'><i class='fa fa-search-plus'></i></span></a>";
						}
					}else{
						# --- if not logged in provide a login link instead
						if(!$this->request->isLoggedIn()){
							$va_component_info["download"] = "<a class='btn-default btn-orange' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login to download")."</a>";
						}elseif($this->request->user->getPreference("user_profile_classroom_role") != "EDUCATOR"){
							$va_component_info["download"] = "<H6>* You must be registered as an educator to download this resource</H6>";
						}
						$vb_files_require_login = 1;
					}
				}
				$va_component_info["youtube"] = $q_components->get("ca_objects.youtube");
				$va_component_info["resource_link"] = $q_components->get("ca_objects.resource_link");
				switch($q_components->get("type_id")){
					case $va_component_types["learn"]:
						$va_components["learn"][] = $va_component_info;
					break;
					# --------------------------------------
					case $va_component_types["practice"]:
						$va_components["practice"][] = $va_component_info;
					break;
					# --------------------------------------
					case $va_component_types["explore"]:
						$va_components["explore"][] = $va_component_info;
					break;
					# --------------------------------------
					case $va_component_types["resource"]:
						if($vs_ncep_theme = $q_components->get("ca_objects.ncep_theme", array("convertCodesToDisplayText" => true))){
							$va_components[strtolower($vs_ncep_theme)][] = $va_component_info;
						}
					break;
					# --------------------------------------
					default:
						$va_components["teach"][] = $va_component_info;
					break;
					# --------------------------------------					
				}
			}
		}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end navTop -->
	<div class='col-xs-12'>
		<div class="detailBox detailBoxTop">
			<div class="detailNav pull-right">
				{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
			</div><!-- end detailNav -->
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
					
			<div class="row">
<?php
				# --- is this object in a gallery/featured set?
				$t_set = new ca_sets();
				$va_sets = caExtractValuesByUserLocale($t_set->getSets(array("table" => "ca_objects", "row_id" => $t_object->get("ca_objects.object_id"), "setType" => "public_presentation", "checkAccess" => $va_access_values)));
				$vs_translations = $t_object->getWithTemplate("<unit relativeTo='ca_objects.related' delimiter='<br/>' restrictToRelationshipTypes='translation'><l>^ca_objects.preferred_labels.name</l> (^ca_objects.language)</unit>");
				if($t_object->get("ca_objects.abstract") || $vs_translations || (is_array($va_sets) && sizeof($va_sets))){
					print "<div class='col-xs-12 col-sm-8'>";
					print ($t_object->get("ca_objects.abstract")) ? "<p>".$t_object->get("ca_objects.abstract")."</p>" : "";
					if($vs_translations){
						print "<p><b>View this module in other languages:</b><br/>".$vs_translations."</p>";
					}
					if(is_array($va_sets) && sizeof($va_sets)){
						print "<p><b>Featured in:</b> ";
						$va_feature_links = array();
						foreach($va_sets as $va_set){
							$va_feature_links[] = caNavLink($this->request, $va_set["name"], "", "", "Gallery", $va_set["set_id"]);
						}
						print join(", ", $va_feature_links);
					}
					print "</div>";
				}
?>
				<div class='col-xs-12 col-sm-4'>
					{{{<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="related"><p><b>See Also:</b><br/>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToRelationshipTypes="related"><l>^ca_objects.preferred_labels.name</l></unit>
					</p></ifcount>}}}
<?php
					$t_list_items = new ca_list_items();
							
					if($va_themes = $t_object->get("ca_objects.themes", array("returnWithStructure" => true))){
						if(is_array($va_themes) && sizeof($va_themes)){
							$va_themes = array_pop($va_themes);
							print "<p><b>Theme".((sizeof($va_themes) > 1) ? "s" : "")."</b>: ";
							$va_theme_links = array();
							foreach($va_themes as $vn_key => $va_theme){
								$t_list_items->load($va_theme["themes"]);
								$va_theme_links[] = caNavLink($this->request, $t_list_items->get("ca_list_items.preferred_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "theme", "id" => $va_theme["themes"]));					
							}
							print join(", ", $va_theme_links);
							print "</p>";
						}
					}
					if($va_languages = $t_object->get("ca_objects.language", array("returnWithStructure" => true))){
						if(is_array($va_languages) && sizeof($va_languages)){
							$va_languages = array_pop($va_languages);
							print "<p><b>Language".((sizeof($va_languages) > 1) ? "s" : "")."</b>: ";
							$va_language_links = array();
							foreach($va_languages as $vn_key => $va_language){
								$t_list_items->load($va_language["language"]);
								$va_language_links[] = caNavLink($this->request, $t_list_items->get("ca_list_items.preferred_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "language", "id" => $va_language["language"]));					
							}
							print join(", ", $va_language_links);
							print "</p>";
						}
					}
					if($va_regions = $t_object->get("ca_objects.regions", array("returnWithStructure" => true))){
						if(is_array($va_regions) && sizeof($va_regions)){
							$va_regions = array_pop($va_regions);
							print "<p><b>Region".((sizeof($va_regions) > 1) ? "s" : "")."</b>: ";
							$va_region_links = array();
							foreach($va_regions as $vn_key => $va_region){
								$t_list_items->load($va_region["regions"]);
								$va_region_links[] = caNavLink($this->request, $t_list_items->get("ca_list_items.preferred_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "region", "id" => $va_region["regions"]));					
							}
							print join(", ", $va_region_links);
							print "</p>";
						}
					}
				if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("keywords")))){
					if(is_array($va_subjects) && sizeof($va_subjects)){
						print "<p><b>Keyword".((sizeof($va_subjects) > 1) ? "s" : "").":</b> ";
						$va_tmp = array();
						foreach($va_subjects as $va_subject){
							$va_tmp[] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "keyword_facet", "id" => $va_subject["item_id"]));
						}
						print join(", ", $va_tmp);
						print "</p>";
					}
				}
?>
					{{{<ifdef code="ca_objects.date"><p><b>Date:</b> <unit relativeTo="ca_objects.date" delimiter=", ">^ca_objects.date.dates_value (^ca_objects.date.dc_dates_types)</unit></p></ifdef>}}}
					<p><b>Components:</b> <?php print sizeof($va_component_ids); ?></p>
<?php
					if($vb_files){
						print "<p class='componentButtonCol'>".caNavLink($this->request, "Download All".(($vb_files_require_login) ? "*" : "")."&nbsp; <i class='fa fa-download'></i>", 'btn-default btn-orange btn-icon', 'Detail', 'DownloadMedia', '', array("object_id" => $t_object->get("ca_objects.object_id"), "download" => 1), array("title" => _t("Download All")));
						if($vb_files_require_login){
							print "<br/><small>* Educators must login to download all files</small>";
						}
						print "</p>";
					}
?>		
				</div>
			</div>
		</div><!-- end detailBox -->
<?php
		#print "<pre>";
		#print_r($va_components);
		#print "</pre>";
		if(is_array($va_components) && sizeof($va_components)){
?>
		<div class="row">
			<div class='col-sm-3'>
				<div class="compViewAll">
					<a href="#" onClick="$('.componentSection').show(); $('.sectionHR').show(); $('.compTab').removeClass('highlightTab'); return false;"><i class='fa fa-arrow-circle-down'></i> View All</a>
				</div>
<?php
					if(sizeof($va_components["learn"])){
?>
					<a href="#" onClick="clickTab('learn'); return false;">
<?php
					}
?>
				<div class="compTab learn <?php print (sizeof($va_components["learn"])) ? "" : "inactiveTab"; ?>">
<?php
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_learn.png', array('title' => _t('Learn')))."</div><span>"._t("Learn")."</span>";
?>
				</div>
<?php
					if(sizeof($va_components["learn"])){
						print "</a>";
					}
					if(sizeof($va_components["explore"])){
?>
					<a href="#" onClick="clickTab('explore'); return false;">
<?php
					}

?>
				<div class="compTab explore <?php print (sizeof($va_components["explore"])) ? "" : "inactiveTab"; ?>">
<?php
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_explore.png', array('title' => _t('Explore')))."</div><span>"._t("Explore")."</span>";
?>
				</div>
<?php
					if(sizeof($va_components["explore"])){
						print "</a>";
					}
					if(sizeof($va_components["practice"])){
?>
					<a href="#" onClick="clickTab('practice'); return false;">
<?php
					}
?>
				<div class="compTab practice <?php print (sizeof($va_components["practice"])) ? "" : "inactiveTab"; ?>">
<?php
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_practice.png', array('title' => _t('Practice')))."</div><span>"._t("Practice")."</span>";
?>
				</div>
<?php
					if(sizeof($va_components["practice"])){
						print "</a>";
					}
					if(sizeof($va_components["teach"])){
?>
					<a href="#" onClick="clickTab('teach'); return false;">
<?php
					}
?>
				<div class="compTab teach <?php print (sizeof($va_components["teach"])) ? "" : "inactiveTab"; ?>">
<?php
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_teach.png', array('title' => _t('Teach')))."</div><span>"._t("Teach")."</span>";
?>
				</div>
<?php
					if(sizeof($va_components["teach"])){
						print "</a>";
					}
?>
				<a href="#" onClick="clickTab('connect'); return false;">
				<div class="compTab connect">
					<?php print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_connect.png', array('title' => _t('Connect'))); ?></div><span>Connect</span>
				</div>
				</a>
			</div><!-- end col-3 -->
			<div class='col-xs-12 col-sm-9'>
				<div class="detailBox bottom">
<?php
					$vs_first_section = "";
					foreach($va_components as $vs_section => $va_section_components){
						if(sizeof($va_section_components)){
							if(!$vs_first_section){
								$vs_first_section = $vs_section;
							}
							print "<div id='section_".$vs_section."' class='componentSection'>";
							print "<H1>".$vs_section."</H1>";
							foreach($va_section_components as $va_section_component){
								if($va_section_component["download"] || $va_section_component["preview"]){
									print "<div class='row'><div class='col-sm-10 col-xs-12'>";
								}
								print "<H2>".(($va_section_component["resource_link"]) ? "<a href='".$va_section_component["resource_link"]."' target='_blank'>".$va_section_component["type"].": ".$va_section_component["name"]."</a>" : $va_section_component["type"].": ".$va_section_component["name"])."</H2>";
								if($va_section_component["num_files"] > 1){
									print "<p>".$va_section_component["num_files"]." files</p>";
								}
								$va_author_credits = array();
								if($va_section_component["author"]){
									$va_author_credits[] = _t("Author").": ".$va_section_component["author"];
								}
								if($va_section_component["adapter"]){
									$va_author_credits[] = _t("Adapted by").": ".$va_section_component["adapter"];
								}
								if($va_section_component["translator"]){
									$va_author_credits[] = _t("Translator").": ".$va_section_component["translator"];
								}
								
								if(sizeof($va_author_credits)){
									print "<p>";
									print join("<br/>", $va_author_credits);
									print "</p>";
								}
								print ($va_section_component["source"]) ? "<p>"._t("Source").": ".$va_section_component["source"]."</p>" : "";
								if($va_section_component["download"] || $va_section_component["preview"]){
									print "</div><div class='col-sm-2 col-xs-12 componentButtonCol'>";
									if($va_section_component["preview"]){
										print $va_section_component["preview"]."&nbsp;&nbsp;&nbsp;";
									}
									print $va_section_component["download"]."</div></div>";
								}
								print ($va_section_component["abstract"]) ? "<p>".$va_section_component["abstract"]."</p>" : "";
								if ($va_section_component["youtube"]){
									if(strpos($va_section_component["youtube"], "youtube")){
										$vs_youtube_id = substr($va_section_component["youtube"], strpos($va_section_component["youtube"], "=") + 1);	
										if($vs_youtube_id){
											print '<iframe width="100%" height="385" src="https://www.youtube.com/embed/'.$vs_youtube_id.'" frameborder="0" allowfullscreen></iframe>';
										}
									}elseif(strpos($va_section_component["youtube"], "vimeo")){
										$vs_vimeo_id = substr($va_section_component["youtube"], strpos($va_section_component["youtube"], "com/") + 4);	
										if($vs_vimeo_id){
											print '<iframe src="https://player.vimeo.com/video/'.$vs_vimeo_id.'?title=0&byline=0" width="100%" height="385" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
										}
									}
								}
								print ($va_section_component["usage"]) ? "<p>"._t("Usage License").": ".$va_section_component["usage"]."</p>" : "";
							}
							print "<HR class='sectionHR'/>";
							print "</div><!-- end section -->";
						}
					}
?>
					<div id='section_connect' class='componentSection'>
						<div class='row'>
							<div class='col-sm-8 col-xs-12'>
								<H1>Connect</H1>
								<H2><?php print sizeof($va_comments); ?> Comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></H2><br/>
							</div>
							<div class='col-sm-4 col-xs-12 componentButtonCol'><?php print "<a href='#' class='btn-default btn-blue' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'ShareForm', array("tablename" => "ca_objects", "item_id" => $t_object->getPrimaryKey()))."\"); return false;'>Share <span class='glyphicon glyphicon-share-alt'></a>"; ?></div>
						</div>
						
<?php
						if(is_array($va_comments) && (sizeof($va_comments) > 0)){
							foreach($va_comments as $va_comment){
								print "<blockquote>";
								if($va_comment["media1"]){
									print '<div class="pull-right" id="commentMedia'.$va_comment["comment_id"].'">';
									print $va_comment["media1"]["tiny"]["TAG"];
									print "</div><!-- end pullright commentMedia -->\n";
									TooltipManager::add(
										"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
									);
								}
								if($va_comment["comment"]){
									print $va_comment["comment"];
								}
								print "<small>".$va_comment["author"].", ".$va_comment["date"]."</small></blockquote>";
							}
						}
						if(is_array($va_tags) && sizeof($va_tags) > 0){
							$va_tag_links = array();
							foreach($va_tags as $vs_tag){
								$va_tag_links[] = caNavLink($this->request, $vs_tag, '', '', 'Search', 'objects', array('search' => $vs_tag));
							}
							print "<h2>"._t("Tags")."</h2>\n
								<div id='tags'>".implode($va_tag_links, ", ")."</div><br/>";
						}
						if($this->request->isLoggedIn()){
							print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->getPrimaryKey()))."\"); return false;' >"._t("Add your comment")." <span class='glyphicon glyphicon-comment'></span></button>";
						}else{
							print "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment")." <span class='glyphicon glyphicon-comment'></span></button>";
						}
?>
					</div><!-- end section_connect -->
				</div><!-- end detailBox -->
			</div><!-- end col-9 -->
		</div><!-- end row -->
<?php
		}
?>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.componentSection').hide();
		jQuery('.sectionHR').hide();
<?php
		if($this->request->getParameter('contributed', pInteger)){
?>
			$('#section_connect').show();
<?php
		}else{
?>
			jQuery('.componentSection:first').show();
<?php
		}
?>
		jQuery('.<?php print $vs_first_section; ?>').addClass('highlightTab');
	});
	function clickTab(tabname){
		$('.componentSection').hide();
		$('.sectionHR').hide();
		$('#section_' + tabname).show();
		$('.compTab').removeClass('highlightTab');
		$('.' + tabname).addClass('highlightTab');
	}

</script>