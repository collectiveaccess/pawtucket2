<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_thumbnail_html.php :
 * 		thumbnail search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2010 Whirl-i-Gig
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
 
 	
$vo_result 				= $this->getVar('result');
$vs_search 				= $this->getVar('search');
$vn_items_per_page 		= $this->getVar('current_items_per_page');
$va_counts_by_type 		= $this->getVar('counts_by_type');
$vn_current_type_id 	= $this->getVar('show_type_id');

$va_access_values = caGetUserAccessValues($this->request);

if($vo_result) {
		$va_exhibitions = array();
		$vs_buf = '<table border="0" cellpadding="0px" cellspacing="0px" width="100%">'."\n<tr>\n";
	
	
		if ($vo_result->numHits() == 0) {
			$vs_buf .= "<tr><td align='center' valign='top' style='padding:20px 0px 2px 0px;' class='searchResultTd'><strong>No items available for this criteria</strong></td></tr>\n";
		} else {
			$vn_display_cols = 6;
			$vn_col = $vn_item_count = 0;
			
			$t_list = new ca_lists();
			$pn_exhibition_list_item_id = $t_list->getItemIDFromList("date_types", "exhibition");
			$pn_publication_date_list_item_id = $t_list->getItemIDFromList("date_types", "publication");
			$pn_document_type_id = $t_list->getItemIDFromList("object_types", "physical_object");
			$pn_image_type_id = $t_list->getItemIDFromList("object_types", "image");
			$pn_moving_image_type_id = $t_list->getItemIDFromList("object_types", "moving_image");
			
			while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
				if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
					$vs_idno = "???";
				}
				$vn_object_id = $vo_result->get('object_id');
				$vs_caption = join(' ', $vo_result->getDisplayLabels());
				
				# --- get the height of the image so can calculate padding needed to center vertically
				$va_media_info = $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail');
				$vs_buf .= "<td align='center' valign='top' style='padding:20px 0px 2px 0px;' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."'>";
				if($vo_result->get("type_id") == $pn_moving_image_type_id && $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values))){
					$vs_buf .= caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/videoPlay.png" border="0" width="43" height="43" class="movingImgResult">', '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
				}
				$vs_buf .= caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
	
				
				// Get thumbnail caption
				if (!is_array($va_entities = $vo_result->get('ca_entity_labels.displayname', array("restrict_to_relationship_types" => "artist", "returnAsArray" => 1, 'checkAccess' => $va_access_values)))) { $va_entities = array(); }
				if (!is_array($va_all_dates = $vo_result->get('ca_objects.dates', array('returnAsArray' => true)))) { $va_dates = array(); }
				$va_display_dates = array();
				switch($vo_result->get("type_id")){
					case $pn_image_type_id:
						# --- show only exhibition date
						foreach($va_all_dates as $vn_i => $va_date_info){
							if($va_date_info['dates_type'] == $pn_exhibition_list_item_id){
								$va_display_dates[] = $va_date_info['dates_value'];
							}
						}
					break;
					# --------------------------------
					case $pn_document_type_id:
						# --- show only publication date
						foreach($va_all_dates as $va_date_info){
							if($va_date_info['dates_type'] == $pn_publication_date_list_item_id){
								$va_display_dates[] = $va_date_info['dates_value'];
							}
						}
					break;
					# --------------------------------
				}
				
				$this->setVar('object_id', $vn_object_id);
				$this->setVar('caption_title', $vs_caption);
				$this->setVar('caption_entities', $vs_artist_list = join(', ', $va_entities));
				$this->setVar('caption_date_list', $vs_date_list = join(', ', $va_display_dates));
				$this->setVar('caption_object_type', $t_list->getItemFromListForDisplayByItemID('object_types', $vo_result->get('ca_objects.type_id')));
				
				$vs_buf .= "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";
				
				// set view vars for tooltip
				$this->setVar('tooltip_representation', $vo_result->getMediaTag('ca_object_representations.media', 'small'));
				$this->setVar('tooltip_title', $vs_caption);
				$this->setVar('tooltip_entities', $vs_artist_list);
				$this->setVar('tooltip_date_list', $vs_date_list);
				$this->setVar('tooltip_description', $vo_result->get('ca_objects.description_public'));
				TooltipManager::add(
					".searchThumbnail{$vn_object_id}", $this->render('Results/ca_objects_result_tooltip_html.php')
				);
				
				$vn_col++;
				if($vn_col < $vn_display_cols){
					$vs_buf .= "<td align='center'>&nbsp;</td>\n";
				}
				if($vn_col == $vn_display_cols){
					$vs_buf .= "</tr>\n<tr>";
					$vn_col = 0;
				}
				
				$vn_item_count++;
			}
			if($vn_col > 0){
				while($vn_col < $vn_display_cols){
					$vs_buf .= "<td><!-- empty --></td>\n";
					$vn_col++;
					if($vn_col < $vn_display_cols){
						$vs_buf .= "<td><!-- empty --></td>\n";
					}
				}
				$vs_buf .= "</tr>\n";
			}
		}
		$vs_buf .= "\n</table>\n";
	
	
		if (($this->request->getController() == "Search")) {
			if ($this->request->config->get('do_secondary_searches')) {
				$va_hits_by_type = array();
				if ($this->request->config->get('do_secondary_search_for_ca_entities')) {
					$qr_ent_results = $this->getVar('secondary_search_ca_entities');
					if($qr_ent_results->numHits()){
						while($qr_ent_results->nextHit()) {
							$va_hits_by_type[1][_t("People")][$qr_ent_results->get('entity_id')] = caNavLink($this->request, join('; ', $qr_ent_results->getDisplayLabels()), '', 'Detail', 'Entity', 'Show', array('entity_id' => $qr_ent_results->get('entity_id')));
						}
					}
				}
				if ($this->request->config->get('do_secondary_search_for_ca_occurrences')) {
					$qr_occ_results = $this->getVar('secondary_search_ca_occurrences');
					$t_occ = new ca_occurrences();
					$va_type_list = $t_occ->getTypeList();
					if($qr_occ_results->numHits()){
						while($qr_occ_results->nextHit()) {
							$va_hits_by_type[$qr_occ_results->get('type_id')][$va_type_list[$qr_occ_results->get('type_id')]['name_plural']][$qr_occ_results->get('occurrence_id')] = caNavLink($this->request, join('; ', $qr_occ_results->getDisplayLabels()), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $qr_occ_results->get('occurrence_id')));
						}
					}
				}
				
				
				print "<div id='secondaryResultsBox'>";
				print "<table><tr>\n";
				
				$vn_width_in_percent = floor(100/sizeof($va_hits_by_type));
				
				
				$va_type_id_list = array(1, 68, 69, 71, 70);
				//foreach($va_hits_by_type as $vs_type => $va_hits) {
				foreach($va_type_id_list as $vn_type_id) {
					foreach($va_hits_by_type[$vn_type_id] as $vs_type => $va_hits) {
						print "<td valign='top' width='{$vn_width_in_percent}%'><div class='header'>".$vs_type."</div>\n";
						foreach($va_hits as $vn_occ_id => $vs_link) {
							print $vs_link."<br/>\n";
						}
						print "</td>\n";
					}
				}
				print "</tr></table>\n";
				print "</div>\n";
			}
			
			if ((bool)$this->request->config->get('search_results_partition_by_type')) {
				$t_list = new ca_lists();
				$pn_document_type_id = $t_list->getItemIDFromList("object_types", "physical_object");
				$pn_image_type_id = $t_list->getItemIDFromList("object_types", "image");
				$pn_moving_image_type_id = $t_list->getItemIDFromList("object_types", "moving_image");
				$pn_sound_type_id = $t_list->getItemIDFromList("object_types", "sound");
				$pn_source_code_type_id = $t_list->getItemIDFromList("object_types", "source_code");
				$va_tab_order = array($pn_image_type_id, $pn_document_type_id, $pn_moving_image_type_id, $pn_sound_type_id, $pn_source_code_type_id);
?>	
				<a name="tabResults"></a><div id="searchResultsTabs">
					<ul class="ui-tabs-nav">
<?php
					$t_list = new ca_lists();
					foreach($va_tab_order as $vn_type_id){
						if($va_counts_by_type[$vn_type_id]){
						#foreach($va_counts_by_type as $vn_type_id => $vn_count) {
?>
						<li class="<?php print ($vn_type_id == $vn_current_type_id) ? "ui-tabs-selected" : ""; ?>"><a href="<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('page' => 1, 'show_type_id' => intval($vn_type_id))); ?>#tabResults"><span><?php print $t_list->getItemForDisplayByItemID($vn_type_id, true); ?> (<?php print $va_counts_by_type[$vn_type_id]; ?>)</span></a></li>
<?php
						}
					}
?>
					</ul>				
				</div>
<?php
			}
?>
			<div id="searchResults" class="ui-tabs-panel">
<?php
				print $this->render('Results/paging_controls_html.php')."<br/>";
				print $vs_buf;
				print $this->render('Results/paging_controls_html.php');
?>			
			</div><!-- end searchResults -->
<?php
		} else {
			print $this->render('Results/paging_controls_html.php');
			print $vs_buf;
			print $this->render('Results/paging_controls_html.php');
		}
	}
?>