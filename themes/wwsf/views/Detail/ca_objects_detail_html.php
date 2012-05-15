<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 	$va_map_options = array(
 				'showScaleControls' => true, 
 				'showMapTypeControls' => false,
 				'mapType' => 'TERRAIN',
 				'minZoomLevel' => 5,
 				'maxZoomLevel' => 13
 			);
 			
	$t_object = 				$this->getVar('t_item');
	$vn_object_id = 			$t_object->get('object_id');
	$vs_title = 				$this->getVar('label');
	
	$t_rep = 					$this->getVar('t_primary_rep');
	$vs_display_version =		$this->getVar('primary_rep_display_version');
	$va_display_options =		$this->getVar('primary_rep_display_options');
	
	$va_access_values = 		$this->getVar('access_values');
	$vn_next_id = 				$this->getVar('next_id');
	$vn_previous_id = 			$this->getVar('previous_id');
	$vn_is_in_result_list = 	$this->getVar("is_in_result_list");
	global $g_ui_locale;
	
	if (!$vs_default_image_version = $this->request->config->get('ca_objects_representation_default_image_display_version')) { $vs_default_image_version = 'mediumlarge'; }

	$t_list = new ca_lists();
	$vn_set_type_memory = $t_list->getItemIDFromList('set_types', 'memory');
	$vn_set_type_theme = $t_list->getItemIDFromList('set_types', 'theme');
	$vn_set_type_city = $t_list->getItemIDFromList('set_types', $this->request->config->get("places_set_type_city"));
	$vn_set_type_village = $t_list->getItemIDFromList('set_types', $this->request->config->get("places_set_type_village"));	
	
	$pn_set_id = $this->request->getParameter('set_id', pInteger);
	if($pn_set_id){
		$t_set = new ca_sets($pn_set_id);
		$vs_set_intro_text = $t_set->get('ca_sets.set_intro', array('convertLineBreaks' => true));
		$vs_set_name = $t_set->get("ca_sets.preferred_labels");
		$va_set_item_ids = array_keys($t_set->getItems(array("returnRowIdsOnly" => 1)));
		if($t_set->get("type_id") == $vn_set_type_memory){
			# --- this is a mempry set - display heading above set text beneath image
			$vn_memory_set = 1;
		}
	}
	if($pn_set_id && $pn_set_id != $this->request->session->getVar("last_set_id")){
		# --- only set result context if the set has changed
		$this->request->session->setVar("last_set_id", $pn_set_id);
		# --- make a new result context item based on the set's type
		switch($t_set->get("type_id")){
			case $vn_set_type_memory:
				$o_resultContext = new ResultContext($this->request, 'ca_objects', 'memories');
			break;
			# -----------------------------
			case $vn_set_type_theme:
				$o_resultContext = new ResultContext($this->request, 'ca_objects', 'themes');
			break;
			# -----------------------------
			case $vn_set_type_city:
			case $vn_set_type_village:
				$o_resultContext = new ResultContext($this->request, 'ca_objects', 'places');
			break;
			# -----------------------------
		}
		$o_resultContext->setAsLastFind();
		# --- get items from set
		$o_resultContext->setResultList($va_set_item_ids);
		$o_resultContext->saveContext();
		$vn_next_id = $o_resultContext->getNextID($vn_object_id);
		$vn_previous_id = $o_resultContext->getPreviousID($vn_object_id);
		$vn_is_in_result_list = ($o_resultContext->getIndexInResultList($vn_object_id) != '?');
	}

?>	
	<div id="detailBody">
		<h1>
<?php
		if($pn_set_id){
			print $vs_set_name.": ";
		}
		print $vs_title;
		if($pn_set_id){
			print " [".(array_search($vn_object_id, $va_set_item_ids) + 1)."/".sizeof($va_set_item_ids)."]";
		}		
?>
		</h1>
		<div id="rightCol">
		<div id="objRightColHeading"><?php print _t("OBJECT INFORMATION"); ?></div><!-- end objRigthColHeading -->
<?php
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit" style="float:right;"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
			}
			print "<h2>"._t("Info")."</h2>\n";
			if($t_object->get('ca_objects.wann_aufgen')){
				print $t_object->get('ca_objects.wann_aufgen')."<br/>";
			}
			if($t_object->get('ca_objects.wo_aufgen')){
				print $t_object->get('ca_objects.wo_aufgen')."<br/>";
			}
			if($t_object->get('material')){
				print _t("Material").": ".$t_object->get('material')."<br/>";
			}
			if($t_object->get('dimensions')){
				print _t("Dimensions").": ".$t_object->get('dimensions')."<br/>";
			}
			$va_creators = $t_object->get('ca_entities', array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('creator')));
			if(sizeof($va_creators) > 0){
				print _t("Created By").": ";
				$va_creators_display = array();
				foreach($va_creators as $va_creator){
					$va_creators_display[] = caNavLink($this->request, $va_creator["label"], '', '', 'Search', 'Index', array('search' => $va_creator["label"]));
				}
				print implode(", ", $va_creators_display);
				print "<br/>";
			}
			
			$va_productions = $t_object->get('ca_entities', array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('production')));
			if(sizeof($va_productions) > 0){
				print _t("Production").": ";
				$va_productions_display = array();
				foreach($va_productions as $va_production){
					$va_productions_display[] = caNavLink($this->request, $va_production["label"], '', '', 'Search', 'Index', array('search' => $va_production["label"]));
				}
				print implode(", ", $va_productions_display);
				print "<br/>";
			}
			
			$vn_license_text = $t_object->get("ca_objects.license_type");
 			$vn_show_download_link = 0;
 			if ($vn_license_text != 729) {
 				if ($g_ui_locale == 'en_US') {
 					print '<br/>'._t("License").': <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/de/deed.en_US" ntarget="_blank"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/de/80x15.png" /></a>';
 				}else{
 					print '<br/>'._t("License").': <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/de/" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/de/80x15.png" /></a>';
 				}
 				print "<br/>";
 				$vn_show_download_link = 1;
 			}else{
				print '<br/>'._t("License").": ";
				print _t("Not Creative Commons")."<br/>";
			}
			$t_sets = new ca_sets();
			$va_memory = caExtractValuesByUserLocale($t_sets->getSetsForItem("ca_objects", $vn_object_id, array("checkAccess" => $va_access_values, "setType" => "memory")));
			if(sizeof($va_memory) > 0){
				$vs_memories_list = "";
				foreach($va_memory as $va_memory_info){
					if($pn_set_id != $va_memory_info["set_id"]){
						$vs_memories_list .= "<div>".caNavLink($this->request, $va_memory_info["name"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id, 'set_id' => $va_memory_info["set_id"]))."</div>";
					}
				}
				if($vs_memories_list){
					print "<H2 style='margin-top:18px;'><img src='".$this->request->getThemeUrlPath()."/graphics/memories_icon.gif' width='29' height='28' border='0' style='float:left; margin:-8px 5px 0px 0px;'>"._t("From the Set")."</H2>";
					print $vs_memories_list;
				}
			}
			$va_themes = caExtractValuesByUserLocale($t_sets->getSetsForItem("ca_objects", $vn_object_id, array("checkAccess" => $va_access_values, "setType" => $vn_set_type_theme)));
			if(sizeof($va_themes) > 0){
				$vs_themes_list = "";
				foreach($va_themes as $va_themes_info){
					if($pn_set_id != $va_themes_info["set_id"]){
						$vs_themes_list .= "<div>".caNavLink($this->request, $va_themes_info["name"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id, 'set_id' => $va_themes_info["set_id"]))."</div>";
					}
				}
				if($vs_themes_list){
					print "<H2 style='margin-top:18px;'><img src='".$this->request->getThemeUrlPath()."/graphics/themes_icon.gif' width='29' height='28' border='0' style='float:left; margin:-8px 5px 0px 0px;'>"._t("From the Set")."</H2>";
					print $vs_themes_list;
				}
			}

			if($t_object->get('ca_objects.description')){
				print "<br/>".nl2br($t_object->get('ca_objects.description'))."<br/>";
			}
			
			# --- output map if available
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(245, 170, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div id='location'>".$o_map->render('HTML', $va_map_options)."</div>";
			}
	
			$va_output_terms = array();
			$va_terms_depicts = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('hasGenericConcept')));
			if(sizeof($va_terms_depicts) > 0){
				print "<h2>"._t("Depicts")."</h2>";
				$va_terms = array();
				foreach($va_terms_depicts as $va_depicts_info){
					$va_output_terms[] = $va_depicts_info["item_id"];
					$va_terms[caNavLink($this->request, $va_depicts_info['label'], '', '', 'Search', 'Index', array('search' => $va_depicts_info['label']))] = $va_depicts_info['label'];
				}
				natcasesort($va_terms);
				print implode(", ", array_keys($va_terms));
			}
			$va_terms_context = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('isAssociatedWith')));
			if(sizeof($va_terms_context) > 0){
				print "<h2 id='contextHeader'>"._t("Context")."</h2>";
				$va_terms = array();
				foreach($va_terms_context as $va_context_info){
					$va_output_terms[] = $va_context_info["item_id"];
					$va_terms[caNavLink($this->request, $va_context_info['label'], '', '', 'Search', 'Index', array('search' => $va_context_info['label']))] = $va_context_info['label'];
				}
				natcasesort($va_terms);
				print implode(", ", array_keys($va_terms));
				
				TooltipManager::add(
					"#contextHeader", "<div>Contextual information taken from the creator&apos;s memories.</div>"
				);
			}
			$va_all_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_all_terms) > 0){
				$va_terms = array();
				foreach($va_all_terms as $va_all_term_info){
					if(!in_array($va_all_term_info["item_id"], $va_output_terms)){
						$va_terms[caNavLink($this->request, $va_all_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_all_term_info['label']))] = $va_depicts_info['label'];
					}
					$va_output_terms[] = $va_all_term_info["item_id"];
				}
				if(sizeof($va_terms) > 0){
					print "<h2>"._t("Themes")."</h2>";
					natcasesort($va_terms);
					print implode(", ", array_keys($va_terms));
				}
			}
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('depicts', 'context')));
			if(sizeof($va_entities) > 0){
				print "<h2>"._t("People/Organizations")."</h2>\n";
				$va_tmp = array();
				foreach($va_entities as $va_entity) {
					$va_tmp[caNavLink($this->request, $va_entity["label"] , '', '', 'Search', 'Index', array('search' => $va_entity["label"]))] = $va_entity["label"];				
				}
				
				natcasesort($va_tmp);
				print join(', ', array_keys($va_tmp));
				print "<br/>";
			}
			
			
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places)){
				print "<h2>"._t("Places")."</h2>\n";
				
				$va_tmp = array();
				foreach($va_places as $va_places) {
					$va_tmp[caNavLink($this->request, $va_places['label'], '', '', 'Search', 'Index', array('search' => rawurlencode('place_id:"'.$va_places['place_id'].'"')))] = $va_places['label'];
				}
				natcasesort($va_tmp);
				print join(', ', array_keys($va_tmp));
				print "<br/>";
			}
			$vs_text_in_image = trim($t_object->get('texte_im_bild', array("delimiter" => ' ')));
			if($vs_text_in_image){
				print "<h2>"._t("Text in image")."</h2>\n";
				print "<div id='textInImage'>".caConvertHTMLBreaks($vs_text_in_image)."</div>";
			}
			
			$va_tags = $this->getVar("tags_array");
			if(sizeof($va_tags) > 0){
				print "<h2>"._t("Tags")."</h2>\n";
				$va_tmp = array();
				foreach($va_tags as $vs_tag) {
					$va_tmp[caNavLink($this->request, $vs_tag, '', '', 'Search', 'Index', array('search' => $vs_tag))] = $vs_tag;
				}
				natcasesort($va_tmp);
				print join(', ', array_keys($va_tmp));
				print "<br/>";
			}
			

			if($pn_set_id && is_array($va_set_item_ids) && (sizeof($va_set_item_ids) > 0)){
				$va_related_ids = $va_set_item_ids;
				$vs_related_heading = _t("Other items in this set");
			}else{
				$vs_related_heading = _t("Related");
				# --- output related object images as links - based on voc terms
				$va_related_ids = array();
				if (sizeof($va_output_terms)) {
					$o_db = new Db();
					$qr_rels = $o_db->query("
						SELECT coxvt.object_id
						FROM ca_objects_x_vocabulary_terms coxvt
						INNER JOIN ca_objects AS o ON o.object_id = coxvt.object_id
						WHERE
							coxvt.item_id IN (".join(',', $va_output_terms).") AND o.access = 1
						ORDER BY rand()
						LIMIT 9
					");
					
					while($qr_rels->nextRow()) {
						$va_related_ids[] = $qr_rels->get('object_id');
					}
				}
			}			
			
			#$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_ids) > 0) {
				print "<h2>".$vs_related_heading."</h2>";
				print "<div id='related'><table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 3;
				foreach($va_related_ids as $vn_id){
					$t_rel_object = new ca_objects($vn_id);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					if($col == 0){
						print "<tr>";
					}
					print "<td align='center' valign='middle' class='imageIcon icon".$vn_id."'>";
					$va_params = array('object_id' => $vn_id);
					$vs_img_class = "";
					if($pn_set_id){
						$va_params["set_id"] = $pn_set_id;
						$vs_img_class = (($vn_id == $vn_object_id) ? "current" : "");
					}
					print caNavLink($this->request, $va_reps['tags']['icon'], $vs_img_class, 'Detail', 'Object', 'Show', $va_params);
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_reps['tags']['small']);
					$this->setVar('tooltip_title', $t_rel_object->getLabelForDisplay());
					$this->setVar('tooltip_idno', $t_rel_object->get("idno"));
					TooltipManager::add(
						".icon".$vn_id, $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
					
					print "</td>";
					$col++;
					if($col < $vn_numCols){
						print "<td align='center'><!-- empty --></td>";
					}
					if($col == $vn_numCols){
						print "</tr>";
						$col = 0;
					}
				}
				if(($col != 0) && ($col < $vn_numCols)){
					while($col <= $vn_numCols){
						if($col < $vn_numCols){
							print "<td><!-- empty --></td>";
						}
						$col++;
						if($col < $vn_numCols){
							print "<td align='center'><!-- empty --></td>";
						}
					}
				}
				print "</table></div><!-- end related -->";
			}
?>
		</div><!-- end leftCol-->
		<div id="leftCol">
<?php
		if($t_rep && $t_rep->getPrimaryKey()) { 
?>
			<div id="objDetailImage">
<?php
			if($va_display_options['no_overlay']){
				print $t_rep->getDisplayMediaWithAnnotationsHTMLBundle($this->request, $vs_display_version, $this->getVar('primary_rep_display_options'));
			}else{
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
			}
?>
			</div><!-- end objDetailImage -->
		<div id="objDetailImageNav">
					
<?php
			
		if (($vn_is_in_result_list) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_lg.gif' width='13' height='12' border='0' id='buttonBack'>", ''))) {
			if ($vn_previous_id) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_left_lg.gif' width='11' height='14' border='0' id='buttonPrevious'>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_previous_id, 'set_id' => $pn_set_id), array('id' => 'previous'));
			}else{
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/spacer.gif' width='11' height='14' border='0'>";
			}
			print "&nbsp;&nbsp;&nbsp;".$vs_back_link."&nbsp;&nbsp;&nbsp;";
			if ($vn_next_id) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_lg.gif' width='11' height='14' border='0' id='buttonNext'>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_next_id, 'set_id' => $pn_set_id), array('id' => 'next'));
			}else{
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/spacer.gif' width='11' height='14' border='0'>";
			}
		}
		TooltipManager::add(
			"#buttonBack", "<div><b>"._t("Back")."</b></div>"
		);
		TooltipManager::add(
			"#buttonNext", "<div><b>"._t("Next")."</b></div>"
		);
		TooltipManager::add(
			"#buttonPrevious", "<div><b>"._t("Previous")."</b></div>"
		);
?>
		
				<div style="float:right;">
<?php
					if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id), array('style' => 'margin-right:30px;'));
						}else{
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id), array('style' => 'margin-right:30px;'));
						}
					}
					
					$vn_show_zoom = true;
					if($t_rep && $t_rep->getAnnotationCount() > 0) {
						print '<a href="#" onclick="openClipList(); return false;" style="margin-right:30px;">'._t('Chapters').'</a> ';
						//$vn_show_download_link = false;
						$vn_show_zoom = false;
					}
					
					# --- download link if creative commons
					if($vn_show_download_link){
						print caNavLink($this->request, _t("DOWNLOAD +"), '', 'Detail', 'Object', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $vn_object_id, "download" => 1), array('style' => 'margin-right:30px;'));
					}
					if($pn_set_id){
						print caNavLink($this->request, _t("SLIDESHOW"), '', 'wwsf', 'Memories', 'slideshow', array('set_id' => $pn_set_id, 'object_id' => $vn_object_id), array('style' => 'margin-right:30px;'));
					}

					if ($vn_show_zoom) {
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >"._t("Zoom")." +</a>";
					}
?>
				</div>			
		</div><!-- end objDetailImageNav -->
<?php
		}
		if($vs_set_intro_text){
			if($vn_memory_set){
				print "<H2>"._t("Memory")."</H2>";
				print "<div id='setText' style='margin-top:0px;'>";
			}else{
				print "<div id='setText'>";
			}
			print $vs_set_intro_text;
			print "</div>";
		}
		# --- original caption
		if($t_object->get('ca_objects.original_caption')){
?>			
		<div id="objCaption">
<?php
			print "<h2>"._t("Original Caption")."</h2>".$t_object->get('ca_objects.original_caption')."<br/><br/>";
?>
		</div>
<?php			
		}
if (!$this->request->config->get('dont_allow_registration_and_login')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData">
<?php
			if($this->getVar("ranking")){
				$vn_number_of_rankings = $this->getVar('numRankings');
?>
				<h2>
					<?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;">
					<?php print '('.$vn_number_of_rankings.' '.(($vn_number_of_rankings == 1) ? _t("ranking") : _t("rankings")).')'; ?>
				</h2>
			
<?php
			}
			$va_comments = $this->getVar("comments");
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<h2><div id="numComments">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div><?php print _t("User Comments"); ?></h2>
<?php
				foreach($va_comments as $va_comment){
?>
					<div class="comment">
						<?php print $va_comment["comment"]; ?>
					</div>
					<div class="byLine">
						<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
					</div>
<?php
				}
			}else{
				$vs_login_message = _t("Questions, remarks or further information about this image? We'd be pleased to receive your comments and tags.");
			}
			if($this->getVar("ranking") || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide"><!-- empty --></div>
<?php
			}
		if($this->request->isLoggedIn()){
?>
			<h2><?php print _t("Add your rank, tags and comment"); ?></h2>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id, 'set_id' => $pn_set_id)); ?>" name="comment">
				<div class="formLabel"><?php print _t('Rank').' '; ?>
					<select name="rank">
						<option value="">-</option>
						<option value="1">*</option>
						<option value="2">**</option>
						<option value="3">***</option>
						<option value="4">****</option>
						<option value="5">*****</option>
					</select>
				</div>
				<div class="formLabel"><?php print _t("Tags (separated by commas)"); ?></div>
				<input type="text" name="tags">
				<div class="formLabel"><?php print _t("Comment"); ?></div>
				<textarea name="comment" rows="5"></textarea>
				<br/>
				<a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
			</form>
<?php
		}else{
?>
				<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id, 'set_id' => $pn_set_id)); ?>" name="comment">
					<div class="formLabel"><?php print _t('Rank').' '; ?>
						<select name="rank">
							<option value="">-</option>
							<option value="1">*</option>
							<option value="2">**</option>
							<option value="3">***</option>
							<option value="4">****</option>
							<option value="5">*****</option>
						</select>
					</div>
					<br/>
					<a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
				</form>
<?php			
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<br/><br/>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail'));
			}
		}
?>
		</div><!-- end objUserData-->
<?php
	}
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
