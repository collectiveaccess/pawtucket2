<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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

	require_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
	
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$t_rep = 							$this->getVar('t_primary_rep');
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	$va_access_values = 				$this->getVar('access_values');
	$vo_result_context = 				$this->getVar('result_context');
	
	$vo_search = new ObjectSearch();
?>
	<div id="pageAreaLeft">
<?php
		$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_related_objects) > 0){
			$t_rel_object = new ca_objects();
?>
			<div id="relatedObjects">
<?php
			if ($t_object->get('type_id') != 23) {
				foreach($va_related_objects as $vn_rel_id => $va_info){
					if ($va_info['item_type_id'] == 23) {
						$t_rel_object->load($va_info["object_id"]);
						$t_rep_rel_obj = $t_rel_object->getPrimaryRepresentationInstance();
						
						print "<div style='margin-bottom: 8px;'>".$t_rep_rel_obj->getMediaTag('media', 'h264_lo', array('viewer_width' => 169, 'viewer_height' => 127, 'always_use_flash' => 1))."</div>\n";
						break;
					}
				}
			}


			$va_related_objects_by_type = array();
			foreach($va_related_objects as $vn_rel_id => $va_info){
				$t_rel_object->load($va_info["object_id"]);
				$vs_icon = "";
				switch($va_info["item_type_id"]){
					case 23:
						$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_video.gif' border='0'>";
					break;
					# --------------------
					case 21:
						$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_script.gif' border='0'>";
					break;
					# --------------------
					case 22:
						$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_continuity.gif' border='0'>";
					break;
					# --------------------
				}
				$va_related_objects_by_type[$va_info["item_type_id"]][] = caNavLink($this->request, $vs_icon."&gt; "._t("Einstellungs-Nr.")."<br/>".(($t_rel_object->get('ca_objects.einstellungs_nr')) ? $t_rel_object->get('ca_objects.einstellungs_nr') : $t_rel_object->get('ca_objects.idno')), '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
			}
			# --- add the current object to the array
			$vs_icon = "";
			switch($t_object->get("type_id")){
				case 23:
					$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_video.gif' border='0'>";
				break;
				# --------------------
				case 21:
					$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_script.gif' border='0'>";
				break;
				# --------------------
				case 22:
					$vs_icon = "<img src='".$this->request->getThemeUrlPath()."/graphics/type_continuity.gif' border='0'>";
				break;
				# --------------------
			}
			$va_related_objects_by_type[$t_object->get("type_id")][] = $vs_icon."<span class='current'>&gt; "._t("Einstellungs-Nr.")."<br/>".(($t_object->get('ca_objects.einstellungs_nr')) ? $t_object->get('ca_objects.einstellungs_nr') : $t_object->get('ca_objects.idno'))."</span>";
			# --- output related links and current obj in order: take, script report, continuity report
			if(is_array($va_related_objects_by_type[23]) && (sizeof($va_related_objects_by_type[23]) > 0)){
				$vs_link = "";
				foreach($va_related_objects_by_type[23] as $vs_link){
					print "<div>".$vs_link."</div>";
				}
			}
			if(is_array($va_related_objects_by_type[21]) && (sizeof($va_related_objects_by_type[21]) > 0)){
				$vs_link = "";
				foreach($va_related_objects_by_type[21] as $vs_link){
					print "<div>".$vs_link."</div>";
				}
			}
			if(is_array($va_related_objects_by_type[22]) && (sizeof($va_related_objects_by_type[22]) > 0)){
				$vs_link = "";
				foreach($va_related_objects_by_type[22] as $vs_link){
					print "<div>".$vs_link."</div>";
				}
			}
?>
			</div><!-- end relatedObjects -->
<?php
		}else{
?>
			<img src='<?php print $this->request->getThemeUrlPath() ?>/graphics/spear.jpg' border='0'>
<?php
		}
?>
	</div><div id="pageArea"><div id="contentArea">
	<div id="tools">
		<a href="#" onclick="window.print();return false;">&gt;&gt; <?php print _t("Drucken"); ?></a>
<?php
		if (!$this->request->config->get('dont_allow_registration_and_login')) {
			if($this->request->isLoggedIn()){
				print caNavLink($this->request, "&gt;&gt; "._t("Lesezeichen setzen"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
			}else{
				print caNavLink($this->request, "&gt;&gt; "._t("Anmelden/Registrieren um Lesezeichen zu setzen"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
			}
		}		
?>
	</div><!-- end tools -->
	<div id="breadcrumbTrail">
<?php
	switch(ResultContext::getLastFind($this->request, 'ca_objects')){
		case "basic_search":
			print caNavLink($this->request, "&gt; "._t("Ergebnisliste"), '', '', 'Search', 'Index');
		break;
		# -------------------------------------------------------
		case "advanced_search":
			print caNavLink($this->request, "&gt; "._t("Erweiterte Suche"), '', '', 'AdvancedSearch', 'Index');
			print caNavLink($this->request, "&gt; "._t("Ergebnisliste"), '', '', 'AdvancedSearch', 'Index');
		break;
		# -------------------------------------------------------
		case "basic_browse":
			print caNavLink($this->request, "&gt; "._t("Themensuche"), '', '', 'Browse', 'clearCriteria');
			print caNavLink($this->request, "&gt; "._t("Ergebnisliste"), '', '', 'Browse', 'Index');
		break;
		# -------------------------------------------------------
	}
	print "<a href='#'>&gt; ".(($t_object->get('ca_objects.einstellungs_nr')) ? (_t("Einstellungs-Nr.")." ".$t_object->get('ca_objects.einstellungs_nr')) : _t("untitled"))."</a>";
?>
	</div><!-- end breadcrumbTrail -->
	<div id="detailBody">
		<h1><?php print (($t_object->get('ca_objects.einstellungs_nr')) ? (_t("Einstellungs-Nr.")." ".$t_object->get('ca_objects.einstellungs_nr')) : _t("untitled")); ?></h1>
		<div id="leftCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="objDetailImageContainer"><div id="objDetailImage">
<?php
			if($va_display_options['no_overlay']){
				print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
			}else{
				$va_img_info = $t_rep->getMediaInfo('media', $vs_display_version);
				$vn_width = $va_img_info["WIDTH"];
				$vn_height = $va_img_info["HEIGHT"];
				$vn_top = $vn_height - 28;
				$vn_left = ($vn_width + ((605 - $vn_width)/2) - 28);
				print "<div id='zoom' style='left:".$vn_left."px; top:".$vn_top."px;'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' ><img src='".$this->request->getThemeUrlPath()."/graphics/zoom.gif' border='0'></a></div>";
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
			}
?>
				</div><!-- end objDetailImage -->
<?php					$va_related_objects_by_type = array();
					switch($t_object->get("type_id")){
						case 21: // report
							$vo_result = $vo_search->search("type_id:21",array("sort"=>"ca_objects.date_translated"));
							break;
						case 22: // continuity
							$vo_result = $vo_search->search("type_id:22",array("sort"=>"ca_objects.einstellungs_nr"));
							break;
						case 23: // take
							$vo_result = $vo_search->search("type_id:23",array("sort"=>"ca_objects.einstellungs_nr"));
							break;
						default:
							break;
					}
					$va_all_results = array();
					while($vo_result->nextHit()){
						$va_all_results[] = intval($vo_result->get("object_id"));
					}
					if ((sizeof($va_all_results) > 1)) {
						$vn_current_obj_index =  array_search($vn_object_id, $va_all_results);
						$vn_last_obj_index = (sizeof($va_all_results) - 1);
						
						
						# --- calc indices
						$vn_start_index = 0;
						if ($vn_current_obj_index > 0) {
							$vn_start_index = $vn_current_obj_index - 1;
						}
						if ($vn_current_obj_index == $vn_last_obj_index) {
							if($vn_current_obj_index > 1){
								$vn_start_index = $vn_current_obj_index - 2;
							}elseif($vn_current_obj_index > 0){
								$vn_start_index = $vn_current_obj_index - 1;
							}else{
								$vn_start_index = $vn_current_obj_index;
							}
							
						}
						$vn_end_index = $vn_start_index + 2;
						# -----------------
?>
						<div id="objDetailImageNav">
<?php
						print caNavLink($this->request, "|&lt;", '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[0]));
						print "&nbsp;&nbsp;&nbsp;&nbsp;";
						if ($vn_current_obj_index>0) {
							if($vn_current_obj_index==$vn_last_obj_index){
								$vn_prev_index = $vn_start_index + 1;
							} else {
								$vn_prev_index = $vn_start_index;
							}
							print caNavLink($this->request, "&lt;", '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[$vn_prev_index]), array('id' => 'previous'));
						}else{
							print "&lt;";
						}
												
						
						while(($vn_start_index <= $vn_end_index) && ($vn_start_index <= $vn_last_obj_index)){
							if($vn_current_obj_index == $vn_start_index){
								print "&nbsp;&nbsp;&nbsp;&nbsp;<b>".($vn_start_index + 1)."</b>";
							}else{
								print "&nbsp;&nbsp;&nbsp;&nbsp;".caNavLink($this->request, ($vn_start_index + 1), '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[$vn_start_index]));
							}
							$vn_start_index++;
						}
						if($vn_end_index < $vn_last_obj_index){
							print "&nbsp;&nbsp;&nbsp;...&nbsp;&nbsp;&nbsp;".caNavLink($this->request, ($vn_last_obj_index + 1), '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[$vn_last_obj_index]));
						}
						
						print "&nbsp;&nbsp;&nbsp;&nbsp;";
						if ($vn_end_index < $vn_last_obj_index) {
							if($vn_current_obj_index==0) $vn_end_index -=1;
							print caNavLink($this->request, "&gt;", '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[$vn_end_index]), array('id' => 'next'));
						}else{
							print "&gt;";
						}
						print "&nbsp;&nbsp;&nbsp;&nbsp;";
						print caNavLink($this->request, "&gt;|", '', 'Detail', 'Object', 'Show', array('object_id' => $va_all_results[(sizeof($va_all_results) - 1)]));
?>
				</div><!-- end objDetailImageNav -->
<?php	
					}
					if(in_array($t_object->get("type_id"),array(21,22))){
						switch($t_object->get("type_id")){
							case 21:
								$vs_and = "(ca_objects.einstellungs_nr:\"' + jQuery('#jumpToEinstellungNr').val() + '\" OR ca_objects.date_translated:\"' + jQuery('#jumpToEinstellungNr').val() + '\")";
								break;
							case 22:
								$vs_and = "(ca_objects.einstellungs_nr:\"' + jQuery('#jumpToEinstellungNr').val() + '\" OR ca_objects.page_number_on_paper:\"' + jQuery('#jumpToEinstellungNr').val() + '\")";
							default:
								break;
						}
?>
<script type="text/javascript">
	function doJump() {
		jQuery.getJSON('<?php print caNavUrl($this->request, 'Detail', 'Object', 'jumpToDetail'); ?>', 
		{search: 'ca_objects.type_id:<?php print $t_object->get("type_id"); ?> AND <?php print $vs_and; ?>'},
		function(data, status, xhr) {
			if (data && data.length > 0) {
				document.location = '<?php print caNavUrl($this->request, 'Detail', 'Object', 'Show', array('object_id' => '')); ?>' + data[0];
			}
		});
	}
</script>
				<div id="objDetailImageJumpTo">
					<div id="jumpToLabel"><?php print _t("Zur Einstellungs-Nr."); ?></div><input type="text" id="jumpToEinstellungNr"><a href='#' onclick='doJump(); return false;'><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/buttonJumpTo.gif" border="0"></a>
				</div><!-- end objDetailImageJumpTo -->
<?php
					}
?>
				<div style="clear:both;"><!-- empty --></div>
			</div><!-- end objDetailImageContainer -->
<?php
		}
			# --- attributes under image based on object type
			switch($t_object->get("ca_objects.type_id")){
				case 23:
					#clip
					$va_attributes = array("take_description" => array(), "action" => array("italicHeading" => 1), "comments_on_report" => array(), "materialdetails" => array("convertLineBreaks" => 1));
				break;
				# -------------
				case 21:
					# script report
					$va_attributes = array("costume_details" => array("italicHeading" => 1, "convertLineBreaks" => 1), "action" => array("italicHeading" => 1), "notes" => array(), "comments_on_report" => array());
				break;
				# -------------
				case 22:
					# continuity report
					$va_attributes = array("action" => array("italicHeading" => 1), "notes" => array(), "comments_on_report" => array());
				break;
				# -------------
			}
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code => $va_displayOptions){
					if($t_object->get("ca_objects.{$vs_attribute_code}")){
						$va_options = array();
						if($va_displayOptions["convertLineBreaks"] == 1){
							$va_options = array('convertLineBreaks' => true);
						}
						print "<div class='unit'><span class='textHeading'>".(($va_displayOptions["italicHeading"] == 1) ? "<i>" : "").$t_object->getAttributeLabel($vs_attribute_code).(($va_displayOptions["italicHeading"] == 1) ? "</i>" : "")."</span><br/>".$t_object->get("ca_objects.{$vs_attribute_code}", $va_options)."</div><!-- end unit -->";
					}
				}
			}
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}
			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><span class='textHeading'>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</span> ";
				$i = 0;
				foreach($va_children as $va_child){
					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>["._t("More")."]</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					print "<div>".caNavLink($this->request, $va_child['name'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_child['object_id']))."</div>";
					$i++;
					if($i == sizeof($va_children)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}
			# --- entities
			//$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_entities = array();
			if(sizeof($va_entities) > 0){	
?>
				<div class="unit"><span class='textHeading'><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("Entities") : _t("Entity")); ?></span>
<?php
				foreach($va_entities as $va_entity) {
					print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";
				}
?>
				</div><!-- end unit -->
<?php
			}
			
			# --- occurrences
			//$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_occurrences = array();
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><span class='textHeading'><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></span>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- places
			//$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_places = array();
			if(sizeof($va_places) > 0){
				print "<div class='unit'><span class='textHeading'>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</span>";
				foreach($va_places as $va_place_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- collections
			//$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_collections = array();
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><span class='textHeading'>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</span>";
				foreach($va_collections as $va_collection_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			//$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_terms = array();
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><span class='textHeading'>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</span>";
				foreach($va_terms as $va_term_info){
					print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(300, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}
?>
		</div><!-- end leftCol-->
		<div id="rightCol">
<?php
			print "<div class='unit'><span class='textHeading'>".$t_object->getAttributeLabel("record_type")."</span><br/>".$t_object->get("ca_objects.record_type")."</div><!-- end unit -->";
			print "<div class='unit'><span class='textHeading'>"._t("Datensatz-Nr.")."</span><br/>".$t_object->get("ca_objects.idno")."</div><!-- end unit -->";

			# --- attributes for right column based on type
			switch($t_object->get("ca_objects.type_id")){
				case 23:
					#clip
					$va_attributes = array("cameraman" => array(), "lens_number" => array("italicHeading" => 1), "location" => array("italicHeading" => 1), "date_translated" => array("italicHeading" => 1), "people" => array());
				break;
				# -------------
				case 21:
					# script report
					$va_attributes = array("sdk_number" => array(), "production_number" => array(), "director" => array("italicHeading" => 1), "sequence" => array("italicHeading" => 1), "num_of_takes" => array("italicHeading" => 1), "scene_number" => array("italicHeading" => 1), "long_shot" => array("italicHeading" => 1), "semi_shot" => array("italicHeading" => 1), "medium_shot" => array("italicHeading" => 1), "close_up" => array("italicHeading" => 1), "lens_number" => array("italicHeading" => 1), "footage" => array("italicHeading" => 1), "props_on_set" => array("italicHeading" => 1), "location" => array("italicHeading" => 1), "date_translated" => array(), "fade_in" => array("italicHeading" => 1), "fade_out" => array("italicHeading" => 1), "day" => array("italicHeading" => 1), "night" => array("italicHeading" => 1));
				break;
				# -------------
				case 22:
					# continuity report
					$va_attributes = array("page_number_on_paper" => array(), "sdk_number" => array(), "header" => array(), "shot_number" => array("italicHeading" => 1), "scene_number" => array("italicHeading" => 1), "number_continuity" => array("italicHeading" => 1), "number_continuity_old" => array("italicHeading" => 1), "number" => array("italicHeading" => 1), "temp_slate_number" => array("italicHeading" => 1), "footage" => array("italicHeading" => 1), "location" => array("italicHeading" => 1), "props" => array("italicHeading" => 1), "date_translated" => array());
				break;
				# -------------
			}
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code => $va_displayOptions){
					if($t_object->get("ca_objects.{$vs_attribute_code}")){
						print "<div class='unit'><span class='textHeading'>".(($va_displayOptions["italicHeading"] == 1) ? "<i>" : "").$t_object->getAttributeLabel($vs_attribute_code).(($va_displayOptions["italicHeading"] == 1) ? "</i>" : "")."</span><br/>".$t_object->get("ca_objects.{$vs_attribute_code}")."</div><!-- end unit -->";
					}
				}
			}
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
