<?php
	$va_featured = array();
	$va_access_values = caGetUserAccessValues($this->request);
	$t_featured = new ca_sets();
	$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
	 # Enforce access control on set
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
		$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());	// These are the occurrence ids in the set
	}
	if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
		$t_occurrence = new ca_occurrences();
		$t_list = new ca_lists();
		$vn_abstract_id = $t_list->getItemIDFromList('pbcore_description_types', 'abstract');
		$va_featured_ids = array_slice($va_featured_ids, 0, 4);
		foreach($va_featured_ids as $vn_occ_id){
			$va_temp = array();
			$t_occurrence->load($vn_occ_id);
			$va_temp["title"] = $t_occurrence->getLabelForDisplay();
			$va_temp["occurrence_id"] = $t_occurrence->get("occurrence_id");
			$va_temp["idno"] = $t_occurrence->get("idno");
			$va_temp["repository"] = $t_occurrence->get("CLIR2_institution", array('convertCodesToDisplayText' => true));
			$va_descriptions = array();
			$va_descriptions = $t_occurrence->get("pbcoreDescription", array("returnAsArray" => 1));
			if(sizeof($va_descriptions) > 0){
				foreach($va_descriptions as $vn_i => $va_description){
					if($va_description["descriptionType"] == $vn_abstract_id){
						$va_temp["abstract"] = $va_description["description_text"];
					}
				}
			}
			$va_preview_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "widepreview", "showMediaInfo" => false, "returnAsArray" => true));
			if(sizeof($va_preview_stills) > 0){
				$va_temp["mediaPreview"] = array_shift($va_preview_stills);
			}
			$va_medium_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "medium", "showMediaInfo" => false, "returnAsArray" => true));
			if(sizeof($va_medium_stills) > 0){
				$va_temp["mediaMedium"] = array_shift($va_medium_stills);
			}
			$va_temp["video"] = $t_occurrence->get('ca_occurrences.ic_moving_images.ic_moving_images_media', array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'));			
			$va_featured[] = $va_temp;
		}
	}
?>
		<div id="hpRightCol">
			<div class="boxHeading">On This Site</div><!-- end boxHeading -->
			<div class="boxBody siteStats">
<?php
		print $this->render('Splash/splash_stats_html.php');
?>
			</div><!-- end boxBody -->
			<div class="boxHeading">About the Project</div><!-- end boxHeading -->
			<div class="boxBody">
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 				
				<div class="more"><?php print caNavLink($this->request, _t("More &raquo;"), "", "", "About", "Index"); ?></div>
			</div><!-- end boxBody -->
		</div><!-- end hpRightCol -->
		<div id="hpFeatured">
			<div class="title"><?php print _t("Featured 1939-1940 New York World's Fair Film"); ?></div>
<?php
	if($va_main_feature = array_shift($va_featured)){
		$vs_media = "<div class='featurePlaceHolder'>&nbsp;</div>";
		if($va_main_feature["video"]){
			$vs_media = $va_main_feature["video"];
		}elseif($va_main_feature["mediaMedium"]){
			$vs_media = $va_main_feature["mediaMedium"];
		}
?>
			<div class="featuredImage"><?php print caNavLink($this->request, $vs_media, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' =>  $va_main_feature["occurrence_id"])); ?></div><!-- end featuredImage -->
			<div class="featuredInfo">
<?php
			if($va_main_feature["title"]){
				print "<b>".$va_main_feature["title"]."</b>";
			}
			if($va_main_feature["repository"]){
				print "<br/><br/><b>"._t("Repository").":</b> ".$va_main_feature["repository"];
			}
			if($va_main_feature["abstract"]){
				print "<br/><br/><b>"._t("Abstract")."</b><br/>".((strlen($va_main_feature["abstract"]) > 340) ? substr($va_main_feature["abstract"], 0, 340)."..." : $va_main_feature["abstract"]);
			}
			print "<div class='more'>".caNavLink($this->request, _t("More &raquo;"), "", "Detail", "Occurrence", "Show", array("occurrence_id" => $va_main_feature["occurrence_id"]))."</div>";
?>
			</div><!-- end featuredInfo -->
<?php
	}
?>
			<div style="clear:both; height:20px;"><!-- empty --></div>
		</div>
		<div id="quickLinkItems">
			<div class="qlTitle"><?php print _t("More Featured Fair Films"); ?></div>
<?php
			if(is_array($va_featured) && (sizeof($va_featured) > 0)){
				foreach($va_featured as $va_feature){
?>
				<div class="quickLinkItem" id="quickLink<?php print $va_feature["occurrence_id"]; ?>">
<?php
					print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/clir2/videoPlay.png" border="0" width="43" height="43" class="play">', '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' =>  $va_feature["occurrence_id"]));
					if($va_feature["mediaPreview"]){
						print caNavLink($this->request, $va_feature["mediaPreview"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' =>  $va_feature["occurrence_id"]));
					}else{
						print "<div class='previewPlaceHolder'>&nbsp;</div>";
					}
?>
				</div>
<?php					
					TooltipManager::add(
						"#quickLink".$va_feature["occurrence_id"], $va_feature["mediaMedium"]."<br/><b>".$va_feature["title"]."</b><br/><br/><b>"._t("Repository")."</b>: ".$va_feature["repository"]
					);
				}
			}
?>
		</div><!-- end quickLinkItems -->