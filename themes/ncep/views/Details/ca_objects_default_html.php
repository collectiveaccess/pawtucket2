<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$va_tags = $this->getVar("tags_array");
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
				$vs_translations = $t_object->getWithTemplate("<unit relativeTo='ca_objects.related' delimiter='<br/>' restrictToRelationshipTypes='translation'><l>^ca_objects.preferred_labels.name</l> (^ca_objects.language)</unit>");
				if($t_object->get("ca_objects.abstract") || $vs_translations){
					print "<div class='col-xs-12 col-sm-8'>";
					print ($t_object->get("ca_objects.abstract")) ? "<p>".$t_object->get("ca_objects.abstract")."</p>" : "";
					if($vs_translations){
						print "<p><b>View this module in other languages:</b><br/>".$vs_translations."</p>";
					}
					print "</div>";
				}
?>
				<div class='col-xs-12 col-sm-4'>
					{{{<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="related"><p><b>See Also:</b><br/>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToRelationshipTypes="related"><l>^ca_objects.preferred_labels.name</l></unit>
					</p></ifcount>}}}
<?php
					if($va_themes = $t_object->get("ca_objects.themes", array("returnWithStructure" => true))){
						if(is_array($va_themes) && sizeof($va_themes)){
							$t_list_items = new ca_list_items();
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
					$va_component_ids = $t_object->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => $va_access_values));
?>
					{{{<ifdef code="ca_objects.language"><p><b>Language:</b> ^ca_objects.language%delimiter=,_</p></ifdef>}}}
					{{{<ifdef code="ca_objects.regions"><p><b>Region:</b> ^ca_objects.regions%delimiter=,_</p></ifdef>}}}
					{{{<ifdef code="ca_objects.date"><p><b>Date:</b> <unit relativeTo="ca_objects.date" delimiter=", ">^ca_objects.date.dates_value (^ca_objects.date.dc_dates_types)</unit></p></ifdef>}}}
					<p><b>Components:</b> <?php print sizeof($va_component_ids); ?></p>
				</div>
			</div>
		</div><!-- end detailBox -->
<?php
		if(sizeof($va_component_ids)){
			$va_components = array("learn" => array(), "teach" => array(), "practice" => array(), "explore" => array());
			$t_list = new ca_lists();
			$va_component_types = array(
				"learn" => $t_list->getItemIDFromList("object_types", "Synthesis"),
				"teach" => array($t_list->getItemIDFromList("object_types", "Presentation"), $t_list->getItemIDFromList("object_types", "EvaluationTool"), $t_list->getItemIDFromList("object_types", "Solutions"), $t_list->getItemIDFromList("object_types", "TeachingNotes")),
				"practice" => $t_list->getItemIDFromList("object_types", "Exercise"),
				"explore" => $t_list->getItemIDFromList("object_types", "CaseStudies"),
				"resource" => $t_list->getItemIDFromList("object_types", "Resource")
			);
			$va_requires_login = array($t_list->getItemIDFromList("object_types", "Presentation"), $t_list->getItemIDFromList("object_types", "EvaluationTool"), $t_list->getItemIDFromList("object_types", "Solutions"), $t_list->getItemIDFromList("object_types", "TeachingNotes"));
			$q_components = caMakeSearchResult("ca_objects", $va_component_ids);
			$t_representation = new ca_object_representations();
			while($q_components->nextHit()){
				# --- put the component display info in an array
				$va_component_info = array();
				$va_component_info["name"] = $q_components->get("ca_objects.preferred_labels.name");
				$va_component_info["type"] = $q_components->get("ca_objects.type_id", array("convertCodesToDisplayText" => true));
				$va_component_info["author"] = $q_components->get("ca_entities.preferred_labels.displayname", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("author"), "checkAccess" => $va_access_values));
				$va_component_info["abstract"] = $q_components->get("ca_objects.abstract");
				$va_component_info["source"] = $q_components->get("ca_objects.source");
				$va_component_info["rep_id"] = $q_components->get('ca_object_representations.representation_id', array("checkAccess" => $va_access_values));
				if($va_component_info["rep_id"]){
					# --- does this resource require you to be logged in to download?
					if(!in_array($q_components->get("ca_objects.type_id"), $va_requires_login) || (in_array($q_components->get("ca_objects.type_id"), $va_requires_login) && $this->request->isLoggedIn())){
						$t_representation->load($va_component_info["rep_id"]);
						$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
						$vs_download_version = $va_download_display_info['display_version'];
						$va_component_info["download"] = caNavLink($this->request, _t("Download")."<i class='fa fa-arrow-circle-down'></i>", 'btn-default btn-orange', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $t_object->get("object_id"), "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
					}else{
						# --- provide a login link instead
						$va_component_info["download"] = "<a class='btn-default btn-orange' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login to download")."</a>";
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
		#print "<pre>";
		#print_r($va_components);
		#print "</pre>";
		if(is_array($va_components) && sizeof($va_components)){
?>
		<div class="row">
			<div class='col-sm-3'>
				<div class="compViewAll">
					<a href="#" onClick="$('.componentSection').show(); $('.sectionHR').show(); return false;"><i class='fa fa-arrow-circle-down'></i> View All</a>
				</div>
				<div class="compTab learn <?php print (sizeof($va_components["learn"])) ? "" : "inactiveTab"; ?>">
<?php
					if(sizeof($va_components["learn"])){
?>
					<a href="#" onClick="$('.componentSection').hide(); $('.sectionHR').hide(); $('#section_learn').show(); return false;">
<?php
					}
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_learn.png', array('title' => _t('Learn')))."</div><span>"._t("Learn")."</span>";
					if(sizeof($va_components["learn"])){
						print "</a>";
					}
?>
				</div>
				<div class="compTab teach <?php print (sizeof($va_components["teach"])) ? "" : "inactiveTab"; ?>">
<?php
					if(sizeof($va_components["teach"])){
?>
					<a href="#" onClick="$('.componentSection').hide(); $('.sectionHR').hide(); $('#section_teach').show(); return false;">
<?php
					}
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_teach.png', array('title' => _t('Teach')))."</div><span>"._t("Teach")."</span>";
					if(sizeof($va_components["teach"])){
						print "</a>";
					}
?>
				</div>
				<div class="compTab practice <?php print (sizeof($va_components["practice"])) ? "" : "inactiveTab"; ?>">
<?php
					if(sizeof($va_components["practice"])){
?>
					<a href="#" onClick="$('.componentSection').hide(); $('.sectionHR').hide(); $('#section_practice').show(); return false;">
<?php
					}
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_practice.png', array('title' => _t('Practice')))."</div><span>"._t("Practice")."</span>";
					if(sizeof($va_components["practice"])){
						print "</a>";
					}
?>
				</div>
				<div class="compTab explore <?php print (sizeof($va_components["explore"])) ? "" : "inactiveTab"; ?>">
<?php
					if(sizeof($va_components["explore"])){
?>
					<a href="#" onClick="$('.componentSection').hide(); $('.sectionHR').hide(); $('#section_explore').show(); return false;">
<?php
					}
					print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_explore.png', array('title' => _t('Explore')))."</div><span>"._t("Explore")."</span>";
					if(sizeof($va_components["explore"])){
						print "</a>";
					}
?>
				</div>
				<div class="compTab connect">
					<a href="#" onClick="$('.componentSection').hide(); $('.sectionHR').hide(); $('#section_connect').show(); return false;"><?php print "<div class='imgContainer'>".caGetThemeGraphic($this->request, 'icon_connect.png', array('title' => _t('Connect'))); ?></div><span>Connect</span></a>
				</div>
			</div><!-- end col-3 -->
			<div class='col-xs-12 col-sm-9'>
				<div class="detailBox bottom">
<?php
					foreach($va_components as $vs_section => $va_section_components){
						if(sizeof($va_section_components)){
							print "<div id='section_".$vs_section."' class='componentSection'>";
							print "<H1>".$vs_section."</H1>";
							foreach($va_section_components as $va_section_component){
								if($va_section_component["download"]){
									print "<div class='row'><div class='col-sm-8 col-xs-12'>";
								}
								print "<H2>".(($va_section_component["resource_link"]) ? "<a href='".$va_section_component["resource_link"]."' target='_blank'>".$va_section_component["type"].": ".$va_section_component["name"]."</a>" : $va_section_component["type"].": ".$va_section_component["name"])."</H2>";
								print ($va_section_component["author"]) ? "<p>"._t("Author").": ".$va_section_component["author"]."</p>" : "";
								print ($va_section_component["source"]) ? "<p>"._t("Source").": ".$va_section_component["source"]."</p>" : "";
								if($va_section_component["download"]){
									print "</div><div class='col-sm-4 col-xs-12 componentButtonCol'>".$va_section_component["download"]."</div></div>";
								}
								print ($va_section_component["abstract"]) ? "<p>".$va_section_component["abstract"]."</p>" : "";
								if ($va_section_component["youtube"]){
									$vs_youtube_id = substr($va_section_component["youtube"], strpos($va_section_component["youtube"], "=") + 1);	
									if($vs_youtube_id){
										print '<iframe width="100%" height="385" src="https://www.youtube.com/embed/'.$vs_youtube_id.'" frameborder="0" allowfullscreen></iframe>';
									}
								}
								
							}
							print "<HR class='sectionHR'/>";
							print "</div><!-- end section -->";
						}
					}
?>
					<div id='section_connect' class='componentSection'>
						<div class='pull-right'><?php print "<a href='#' class='btn-default btn-blue' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'ShareForm', array("tablename" => "ca_objects", "item_id" => $t_object->getPrimaryKey()))."\"); return false;'>Share <span class='glyphicon glyphicon-share-alt'></a>"; ?></div>
						<H1>Connect</H1>
						<H2><?php print sizeof($va_comments); ?> Comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></H2><br/>
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
<!--
				{{{<if rule="(length(^ca_objects.abstract) > 0) or (length(^ca_objects.related%restrictToRelationshipTypes=translation) > 0)">
				<div class="col-xs-12 col-sm-6" style="border:1px solid #333;">xxxx
					<ifdef code="ca_objects.abstract"><p>^ca_objects.abstract</p></ifdef>
					<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="translation">
						<p><b>View this module in other languages:</b><br/>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToRelationshipTypes="translation"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.language)</unit>
						</p>
					</ifcount>
				</div>
				</if>}}}
-->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.componentSection').hide();
		jQuery('.sectionHR').hide();
		jQuery('.componentSection:first').show();
	});

</script>