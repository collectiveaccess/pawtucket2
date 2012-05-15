<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_chronology_detail_html.php : 
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
	$vn_year = $this->getVar("year");
	$vn_period = $this->getVar("period");
	$vn_num_more_link = $this->request->config->get("num_items_before_more_link");
	$va_access_values = caGetUserAccessValues($this->request);
	$va_periods = $this->getVar("periods");
	$va_years_info = $this->getVar("years_info");
	$va_jumpToList = $this->getVar("jumpToList");
	
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_images = 					$this->getVar('num_images');
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	$vn_image_object_id	=				$this->getVar("image_object_id");
if (!$this->request->isAjax()) {
?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_chronology.gif' width='141' height='23' border='0'></div><!-- end pageHeading -->
	<div id="detailBody">
<?php
}
if($this->getVar("show_back_button")){
	$vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', _t("Back"), '');
}
?>
		<div id="jumpTo">
			<?php print ($vs_back_link) ? $vs_back_link."&nbsp;&nbsp;<span class='lineDivide'>|</span>&nbsp;&nbsp;" : ""; ?><span class="subTitle"><?php print _t("Jump to:"); ?>&nbsp;</span><!-- end subTitle -->
<?php
			print caFormTag($this->request, 'Detail', 'caChronJumpToFormYear');
			print "<select name='year' onchange='this.form.submit();' style='width:70px;'>";
			print "<option value=''>Year</option>";
			for($year = 1904; $year <= 1988; $year++){
				print "<option value='$year'>".$year."</option>";	
			}
			print "</select>&nbsp;or&nbsp;";
			print "</form>";
			print caFormTag($this->request, 'Detail', 'caChronJumpToFormPeriod');
			print "<select name='year' onchange='this.form.submit();' style='width:120px;'>";
			print "<option value=''>"._t("Period")."</option>";
			foreach($va_jumpToList as $vs_JumpToLabel => $vn_jumpToYear){
				print "<option value='".$vn_jumpToYear."'>".$vs_JumpToLabel."</option>";
			}
			print "</select>";
			print "</form>";
?>
		</div><!-- end jumpTo -->
<?php			
		$vs_year_label = "";
		if($va_periods[$vn_period]['displayAllYears'] == 1){
			# we're displaying multiple years, show the period name as the title
			$vs_year_label = $va_periods[$vn_period]["label"];
			$vn_next = 0;
			$vn_previous = 0;
			if($va_periods[$vn_period - 1]["start"]){
				$vn_previous = $vn_period - 1;
			}
			if($va_periods[$vn_period + 1]["start"]){
				$vn_next = $vn_period + 1;
			}
			print "<div id='chronTitle'>";
			if ($vn_previous) {
				print "<a href=\"#\" onclick='jQuery(\"#detailBody\").load(\"".caNavUrl($this->request, '', 'Chronology', 'Detail', array('period' => $vn_previous))."\"); return false;'>&lsaquo;</a>";
			}else{
				print "<span class='noLink'>&lsaquo;</span>";
			}
			print " ".$vs_year_label." ";
			if ($vn_next > 0) {
				print "<a href=\"#\" onclick='jQuery(\"#detailBody\").load(\"".caNavUrl($this->request, '', 'Chronology', 'Detail', array('period' => $vn_next))."\"); return false;'>&rsaquo;</a>";
			}else{
				print "<span class='noLink'>&rsaquo;</span>";
			}
			print "</div><!-- end chronTitle -->";
		}else{
			# we're only displaying one year, so show the year as the title with navigation to the next year
			$vs_year_label = $vn_year;
			$vn_next = 0;
			$vn_previous = 0;
			if(($vn_year - 1) >= 1904){
				$vn_previous = $vn_year - 1;
			}
			if(($vn_year + 1) <= 1988){
				$vn_next = $vn_year + 1;
			}
			print "<div id='chronTitle'>";
			if ($vn_previous) {
				print "<a href=\"#\" onclick='jQuery(\"#detailBody\").load(\"".caNavUrl($this->request, '', 'Chronology', 'Detail', array('year' => $vn_previous))."\"); return false;'>&lsaquo;</a>";
			}else{
				print "<span class='noLink'>&lsaquo;</span>";
			}
			print " ".$vs_year_label." ";
			if ($vn_next > 0) {
				print "<a href=\"#\" onclick='jQuery(\"#detailBody\").load(\"".caNavUrl($this->request, '', 'Chronology', 'Detail', array('year' => $vn_next))."\"); return false;'>&rsaquo;</a>";
			}else{
				print "<span class='noLink'>&rsaquo;</span>";
			}
			print "</div><!-- end chronTitle -->";
		}
		# --- IMAGE - display 1 image associated with the year or years
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="rightCol"><div id="objDetailImage">
<?php
				if($va_display_options['no_overlay']){
					print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
				}else{
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('object_id' => $vn_image_object_id, 'representation_id' => $t_rep->getPrimaryKey(), 'year' => $vn_year))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
				}
?>
				</div><!-- end objDetailImage -->
<?php
				if($this->getVar("image_description") || $this->getVar("image_photographer")){
					# --- get width of image so caption matches
					$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
					print "<div class='chronologyImageCaption' style='width:".$va_media_info["WIDTH"]."px'>";
					if($this->getVar("image_description")){
						print "<i>".$this->getVar("image_description")."</i>";
					}
					if($this->getVar("image_description") && $this->getVar("image_photographer")){
						print " &ndash; ";
					}
					if($this->getVar("image_photographer")){
						print _t("Photograph").": ".$this->getVar("image_photographer");
					}
					print " &ndash; &copy; INFGM</div>";
				}
?>
				<div id="objDetailImageNav">
<?php
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('object_id' => $vn_image_object_id, 'representation_id' => $t_rep->getPrimaryKey(), 'year' => $vn_year))."\"); return false;' >".(($vn_num_images > 1) ? _t("Zoom/more media") : _t("Zoom"))." +</a>";
?>		
				</div><!-- end objDetailImageNav -->
			</div><!-- end rightCol -->
<?php
		}		
		# --- EVENTS
		$q_events = $va_years_info["events"];
		if($q_events->numHits() > 0){
			print "<div class='unit'>";
			$t_chronology = new ca_occurrences();
			$vn_item_count = 0;
			$i = 0;
			while($q_events->nextHit()) {				
				if($i == $vn_num_more_link){
					print "<div id='eventsMore' class='relatedMoreItems'>";
				}
					
				print "<div class='chronologyText result".$q_events->get("ca_occurrences.occurrence_id")."'>";
				if($q_events->get("ca_occurrences.date.display_date")){
					print "<i>".$q_events->get("ca_occurrences.date.display_date")."</i> &ndash; ";
				}
				print $q_events->get("ca_occurrences.event_text");
				# --- check for footnotes
				$va_footnotes = array();
				$va_footnotes = $q_events->get("ca_occurrences.event_footnotes", array("returnAsArray" => 1));
				if(is_array($va_footnotes) && (sizeof($va_footnotes) > 0)){
					$n = 0;
					foreach($va_footnotes as $va_footnote){
						if($va_footnote["event_footnotes"]){
						print "<a href='#' class='footnote' id='footnote".$q_events->get("ca_occurrences.occurrence_id").$n."'>";
						$vn_stars = $n+1;
						$stars = 0;
						while($stars < $vn_stars){
							print "*";
							$stars++;
						}
						print "</a>";
						TooltipManager::add(
							"#footnote".$q_events->get("ca_occurrences.occurrence_id").$n, "<div class='footnoteOverlay'>".$va_footnote["event_footnotes"]."</div>"
						);
						$n++;
						}
					}
				}
				print "</div><!-- END chronologyText -->";
				$vn_item_count++;
				$i++;
			}
			if($i > $vn_num_more_link){
				print "</div>";
				print "<div class='moreLink'><a href='#' id='eventsMoreLink' onclick='jQuery(\"#eventsMore\").slideDown(250); jQuery(\"#eventsMoreLink\").hide(); return false;'>".($q_events->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			}
			print "</div><!-- end unit -->";
		}	
		
		# --- output exhibitions from the year
		$qr_exhibitions = $va_years_info["exhibitions"];
		if($qr_exhibitions->numHits() > 0){
			print "<div class='unit'><div class='chronologyHeading'>"._t("Exhibitions in %1", $vs_year_label)."</div>";
			$t_occ = new ca_occurrences();
			$i = 0;
			while($qr_exhibitions->nextHit()){
				if($i == $vn_num_more_link){
					print "<div id='exhibitionsMore' class='relatedMoreItems'>";
				}
				$vn_occurrence_id = $qr_exhibitions->get("ca_occurrences.occurrence_id");
				$t_occ->load($vn_occurrence_id);
				$va_labels = $qr_exhibitions->getDisplayLabels($this->request);
				$vs_label = "\"".join("; ", $va_labels).",\" ";
				$vs_venue = "";
				$va_venues = array();
				$va_venues = $t_occ->get('ca_entities', array('returnAsArray' => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('primary_venue')));
				if(sizeof($va_venues) > 0){
					$va_venue_name = array();
					foreach($va_venues as $va_venue_info){
						$va_venue_name[] = $va_venue_info["displayname"];
					}
					$vs_venue = implode($va_venue_name, ", ");
				}
				if($vs_venue){
					$vs_label .= $vs_venue;
				}
				if($qr_exhibitions->get("ca_occurrences.date.display_date")){
					$vs_label .= ", ".$qr_exhibitions->get("ca_occurrences.date.display_date");
				}
				print "<div class='indent'>";
				print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $vs_label, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id)) : $vs_label);
				
				print "</div>";
				$i++;
			}
			if($i > $vn_num_more_link){
				print "</div>";
				print "<div class='moreLink'><a href='#' id='exhibitionsMoreLink' onclick='jQuery(\"#exhibitionsMore\").slideDown(250); jQuery(\"#exhibitionsMoreLink\").hide(); return false;'>".($qr_exhibitions->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			}
			print "</div><!-- end unit -->";
		}
		
		# --- output bibliographies from the year
		$qr_bibliographies = $va_years_info["bibliographies"];
		if($qr_bibliographies->numHits() > 0){
			print "<div class='unit'><div class='chronologyHeading'>"._t("Publications from %1", $vs_year_label)."</div>";
			$i = 0;
			while($qr_bibliographies->nextHit()){
				if($i == $vn_num_more_link){
					print "<div id='bibliographiesMore' class='relatedMoreItems'>";
				}
				$vn_occurrence_id = $qr_bibliographies->get("ca_occurrences.occurrence_id");
				print "<div class='indent'>";
				print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $qr_bibliographies->get("ca_occurrences.bib_full_citation"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id)) : $vs_label);
				print "</div>";
				$i++;
			}
			if($i > $vn_num_more_link){
				print "</div>";
				print "<div class='moreLink'><a href='#' id='bibliographiesMoreLink' onclick='jQuery(\"#bibliographiesMore\").slideDown(250); jQuery(\"#bibliographiesMoreLink\").hide(); return false;'>".($qr_bibliographies->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			}
			print "</div><!-- end unit -->";
		}
		
		
		
		# --- output objects for the year - sorted as completed in the year and in progress
		$qr_artworks = $va_years_info["artworks"];
		if($qr_artworks->numHits() > 0){
			$va_artworks_completed = array();
			$va_artworks_in_progress = array();
			$vn_end_year_artworks_completed = "";
			if($va_periods[$vn_period]['displayAllYears'] == 1){
				# -- displaying year range so end date for completed artworks should be the end date of the period
				$vn_end_year_artworks_completed = $va_periods[$vn_period]["end"];
			}else{
				$vn_end_year_artworks_completed = $vn_year;
			}					
			while($qr_artworks->nextHit()){
				$vs_artwork = "";
				$va_date_info = array();
				$va_date_info = array_pop($qr_artworks->get("ca_objects.date.parsed_date", array("rawDate" => true, "returnAsArray" => true)));												
				$vn_rel_object_id = $qr_artworks->get("object_id");
				if($vs_tiny_image = $qr_artworks->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values))){
					$vs_artwork .= "<div class='relArtworkImage' id='relArtworkImage".$vn_rel_object_id."'>".caNavLink($this->request, $vs_tiny_image, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
				}else{
					$vs_artwork .= "<div class='relArtworkImagePlaceHolder'><!-- empty --></div>";
				}
				$vs_artwork .= "<div>";
				if($qr_artworks->get("ca_objects.idno")){
					$vs_artwork .= "<span class='resultidno'>".trim($qr_artworks->get("ca_objects.idno"))."</span><br/>";
				}
				$va_labels = $qr_artworks->getDisplayLabels($this->request);
				$vs_title = join('; ', $va_labels);
				if($this->request->config->get('allow_detail_for_ca_objects')){
					$vs_artwork .= caNavLink($this->request, "<i>".$vs_title."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
				}else{
					$vs_artwork .= "<i>".$vs_title."</i><br/>";
				}
				if($qr_artworks->get("ca_objects.date.display_date")){
					$vs_artwork .= $qr_artworks->get("ca_objects.date.display_date")."<br/>";
				}
				if($qr_artworks->get("ca_objects.technique")){
					$vs_artwork .= $qr_artworks->get("ca_objects.technique");
				}
				$vs_caption_image = "";
				if($vs_caption_image = $qr_artworks->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values))){
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $vs_caption_image);
					TooltipManager::add(
						"#relArtworkImage{$vn_rel_object_id}", $this->render('/Results/ca_objects_result_tooltip_html.php')
					);
				}
				if(intval($va_date_info["end"]) <= $vn_end_year_artworks_completed){
					$va_artworks_completed[$vn_rel_object_id] = $vs_artwork;
				}else{
					$va_artworks_in_progress[$vn_rel_object_id] = $vs_artwork;
				}
			}
		}
		if(sizeof($va_artworks_completed) > 0){
			if(sizeof($va_artworks_completed) > 1){
				$vs_title = _t("Artworks from %1", $vs_year_label);
			}else{
				$vs_title = _t("Artwork from %1", $vs_year_label);
			}
			print "<div class='unit' style='clear:right;'><div class='chronologyHeading'>".$vs_title."</div>";
			$i = 0;
			foreach($va_artworks_completed as $vn_rel_object_id => $vs_artwork_completed_info){
				if($i == $vn_num_more_link){
					print "<div id='artworkMore' class='relatedMoreItems'>";
				}
				print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
				print $vs_artwork_completed_info;
				print "</div><div style='clear:left;'><!-- empty --></div></div>";
				$i++;
			}
			if($i > $vn_num_more_link){
				print "</div>";
				print "<div class='moreLink'><a href='#' id='artworkMoreLink' onclick='jQuery(\"#artworkMore\").slideDown(250); jQuery(\"#artworkMoreLink\").hide(); return false;'>".(sizeof($va_artworks_completed) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			}
			print "<div style='clear:left;'><!-- empty --></div></div><!-- end unit -->";
		}
		if(sizeof($va_artworks_in_progress) > 0){
			if(sizeof($va_artworks_in_progress) > 1){
				$vs_title = _t("Artworks In Progress during %1", $vs_year_label, sizeof($va_artworks_in_progress));
			}else{
				$vs_title = _t("Artwork In Progress during %1", $vs_year_label);
			}
			print "<div class='unit' style='clear:right;'><div class='chronologyHeading'>".$vs_title."</div>";
			$i = 0;
			foreach($va_artworks_in_progress as $vn_rel_object_id => $vs_artwork_in_progress_info){
				if($i == $vn_num_more_link){
					print "<div id='artworkInProgressMore' class='relatedMoreItems'>";
				}
				print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
				print $vs_artwork_in_progress_info;
				print "</div><div style='clear:left;'><!-- empty --></div></div>";
				$i++;
			}
			if($i > $vn_num_more_link){
				print "</div>";
				print "<div class='moreLink'><a href='#' id='artworkInProgressMoreLink' onclick='jQuery(\"#artworkInProgressMore\").slideDown(250); jQuery(\"#artworkInProgressMoreLink\").hide(); return false;'>".(sizeof($va_artworks_in_progress) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			}
			print "<div style='clear:left;'><!-- empty --></div></div><!-- end unit -->";
		}
				
				
if($all_artwork){			
				# --- output objects for the year
				$qr_artworks = $va_years_info["artworks"];
				if($qr_artworks->numHits() > 0){
					if($qr_artworks->numHits() > 1){
						$vs_title = _t("Artworks from $vn_y (%1 artworks)", $qr_artworks->numHits());
					}else{
						$vs_title = _t("Artwork from $vn_y");
					}
					print "<div class='unit'><div class='chronologyHeading'>".$vs_title."</div>";
					$i = 0;
					while($qr_artworks->nextHit()){
						if($i == $vn_num_more_link){
							print "<div id='artworkMore".$vn_y."' class='relatedMoreItems'>";
						}
						# --- gather caption info for tooltip
						$vn_rel_object_id = $qr_artworks->get("object_id");
						print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
						if($vs_tiny_image = $qr_artworks->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values))){
							if($this->request->config->get('allow_detail_for_ca_objects')){
								print "<div class='relArtworkImage'>".caNavLink($this->request, $vs_tiny_image, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
							}else{
								print "<div class='relArtworkImage'>".$vs_tiny_image."</div>";
							}
						}
						print "<div>";
						if($qr_artworks->get("ca_objects.idno")){
							print "<span class='resultidno'>".trim($qr_artworks->get("ca_objects.idno"))."</span><br/>";
						}
						$va_labels = $qr_artworks->getDisplayLabels($this->request);
						$vs_title = join('; ', $va_labels);
						if($this->request->config->get('allow_detail_for_ca_objects')){
							print caNavLink($this->request, "<i>".$vs_title."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
						}else{
							print "<i>".$vs_title."</i><br/>";
						}
						if($qr_artworks->get("ca_objects.date.display_date")){
							print $qr_artworks->get("ca_objects.date.display_date")."<br/>";
						}
						if($qr_artworks->get("ca_objects.technique")){
							print $qr_artworks->get("ca_objects.technique");
						}
						print "</div><div style='clear:left;'><!-- empty --></div></div>";
						$vs_caption_image = "";
						if($vs_caption_image = $qr_artworks->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values))){
							// set view vars for tooltip
							$this->setVar('tooltip_representation', $vs_caption_image);
							TooltipManager::add(
								"#relArtwork{$vn_rel_object_id}", $this->render('/Results/ca_objects_result_tooltip_html.php')
							);
						}
						$i++;
					}
					if($i > $vn_num_more_link){
						print "</div>";
						print "<div class='moreLink'><a href='#' id='artworkMoreLink".$vn_y."' onclick='jQuery(\"#artworkMore".$vn_y."\").slideDown(250); jQuery(\"#artworkMoreLink".$vn_y."\").hide(); return false;'>".($qr_artworks->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
					}
					print "</div><!-- end unit -->";
				}
}
		
		
if (!$this->request->isAjax()) {
?>
</div><!-- end detailBody -->
<?php
}
?>