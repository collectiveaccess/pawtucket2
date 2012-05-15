<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
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
	$t_occurrence 		= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');
	$va_comments 		= $this->getVar("comments");
	$pn_numRankings 	= $this->getVar("numRankings");
	$va_access_values = 			$this->getVar('access_values');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="leftCol">	
			<div id="title"><?php print $vs_title; ?></div>
			<div id="counts">
				<a href="#comments"><?php print sizeof($va_comments); ?> comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></a><br/> 
				<?php print $pn_numRankings." ".(($pn_numRankings == 1) ? "Person likes this" : "People like this"); ?> <span class="gray">&nbsp;|&nbsp;</span> <?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_like_this.gif' width='17' height='18' border='0' style='margin: 0px 5px -3px 0px;'>".caNavLink($this->request, 'I like this too', '', 'Detail', 'Occurrence', 'saveCommentRanking', array('occurrence_id' => $vn_occurrence_id, 'rank' => 5)); ?>
			</div><!-- end counts -->
<?php
			# --- idno
			if($t_occurrence->get('ca_occurrences.idno')){
				print "\n<div class='unit'><div class='infoButton' id='idno'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Identifier")."</div><div>".$t_occurrence->get('ca_occurrences.idno')."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#idno", "<div class='infoTooltip'>Identifier description.</div>"
				);
			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if($va_collections){
				print "\n<div class='unit'><div class='infoButton' id='collection'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Collection")."</div>";
				foreach($va_collections as $va_collection_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."</div>";
				}
				print "</div><!-- end unit -->";
				TooltipManager::add(
					"#collection", "<div class='infoTooltip'>Collection description.</div>"
				);
			}
			
			# --- coverage
			$va_coverages = $t_occurrence->get('ca_occurrences.pbcoreCoverage', array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
			if(sizeof($va_coverages) > 0){
				$i = 1;
				$va_dates = array();
				foreach($va_coverages as $va_coverage){
					# --- grab the dates and don't diplay the places since we're displaying the georeference below
					if($va_coverage['coverageType'] == "Temporal"){
						$va_dates[] = $va_coverage['coverage'];
					}
				}
				
				print "\n<div class='unit'><div class='infoButton' id='Temporal'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Date(s)")."</div><div>".(implode(", ", $va_dates))."</div></div><!-- end unit -->";
				TooltipManager::add(
					"Temporal", "<div class='infoTooltip'>".$vs_label." description.</div>"
				);
			}
			
			# --- descriptions
			$va_descriptions = $t_occurrence->get('ca_occurrences.pbcoreDescription', array("returnAsArray" => 1, "convertLineBreaks" => true, 'convertCodesToDisplayText' => true));
			if(sizeof($va_descriptions) > 0){
				$i = 1;
				foreach($va_descriptions as $va_description){
					print "\n<div class='unit'><div class='infoButton' id='description".$i."'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>".$va_description['descriptionType']."</div><div>".$va_description['description_text']."</div></div><!-- end unit -->";
					TooltipManager::add(
						"#description".$i, "<div class='infoTooltip'>".$va_description['descriptionType']." description.</div>"
					);
				}
					$i++;
			}
			
			$va_genre_names = $t_occurrence->get("ca_occurrences.genre_terms", array("returnAsArray" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => true));
			if (sizeof($va_genre_names)) {
				$va_genre_item_ids = $t_occurrence->get("ca_occurrences.genre_terms", array("returnAsArray" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => false));
?>
					<div class="unit"><div class='infoButton' id='genre'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Genre"); ?>(s)</div>
<?php				
				$t_lists = new ca_lists();
				$va_genre_links = array();
				foreach($va_genre_names as $vs_k => $va_term){
					#$va_genre_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'genre_facet', 'id' => $va_term['item_id']));
					#$va_genre_term[] = $va_term["genre_terms"];
					$va_genre_term[] = caNavLink($this->request, $va_term["genre_terms"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_occurrences', 'facet' => 'genre_facet', 'id' => $va_genre_item_ids[$vs_k]['genre_terms']));
					
				}
				print implode(", ", $va_genre_term);
?>
					</div><!-- end unit -->
<?php
					TooltipManager::add(
						"#genre", "<div class='infoTooltip'>Term(s) identifying the genre or form of the work, e.g., amateur, interview.</div>"
					);

			}
			
			$va_entities_output = array();
			# --- creator(s) 
			$va_creators = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('creator'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_creators) && sizeof($va_creators) > 0){
?>
				<div class="unit"><div class='infoButton' id='creators'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Creator(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_creators as $va_creator) {
					$va_entities_output[] = $va_creator['entity_id'];
					print caNavLink($this->request, $va_creator["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_creator['entity_id']));
					if(sizeof($va_creators) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
				TooltipManager::add(
					"#creators", "<div class='infoTooltip'>The primary person or organization responsible for creating the content of a work.</div>"
				);
?>
				</div><!-- end unit --->
<?php

			}
			# --- contributor(s) 
			$va_contributors = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('contributor'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_contributors) && sizeof($va_contributors) > 0){
?>
				<div class="unit"><div class='infoButton' id='contributors'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Contributor(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_contributors as $va_contributor) {
					$va_entities_output[] = $va_contributor['entity_id'];
					print caNavLink($this->request, $va_contributor["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_contributor['entity_id']));
					if(sizeof($va_contributors) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
				TooltipManager::add(
					"#contributors", "<div class='infoTooltip'>contributor description.</div>"
				);
?>
				</div><!-- end unit --->
<?php

			}

			# --- entities(s) 
			$va_entities = $t_occurrence->get("ca_entities", array('checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_entities) && sizeof($va_entities) > 0){
				$va_entity_by_type = array();
				foreach($va_entities as $va_entity){
					if(!in_array($va_entity["entity_id"], $va_entities_output)){
						$va_entity_by_type[$va_entity["relationship_typename"]][] = array("entity_id" => $va_entity["entity_id"], "relationship_typename" => $va_entity["relationship_typename"], "label" => $va_entity["label"]);
					}
				}
				foreach($va_entity_by_type as $vs_relationship_typename => $va_entities_by_type){
?>
					<div class="unit"><div class='infoButton' id='<?php print $vs_relationship_typename; ?>'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print unicode_ucfirst($vs_relationship_typename); ?></div>
<?php
					$vn_i = 1;
					foreach($va_entities_by_type as $va_entity) {
						print caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
						if(sizeof($va_entities_by_type) > $vn_i){
							print ", ";
						}
						$vn_i++;
					}
					TooltipManager::add(
						"#".$vs_relationship_typename, "<div class='infoTooltip'>Entity descriptions</div>"
					);
?>
					</div><!-- end unit --->
<?php					
				}
			}
			
			$va_subjects = $t_occurrence->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if (sizeof($va_subjects)) {
?>
					<div class="unit"><div class='infoButton' id='subject'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Subject"); ?>(s)</div>
<?php				
				$va_subject_links = array();
				foreach($va_subjects as $va_term){
					$va_subject_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'subject_facet', 'id' => $va_term['item_id']));
				}
				print implode(", ", $va_subject_links);
?>
					</div><!-- end unit -->
<?php
					TooltipManager::add(
						"#subject", "<div class='infoTooltip'>Term(s) identifying what the work or collection is about.</div>"
					);

			}
			# --- places
			$va_geoferences = $t_occurrence->getAttributesByElement('georeference');
			if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
				print "\n<div class='unit'><div class='infoButton' id='place'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Place(s)")."</div>";
				$o_map = new GeographicMap(390, 300, 'map');
				$o_map->mapFrom($t_occurrence, 'georeference');
				print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
				print "<div class='collectionMapLabel'>";
				foreach($va_geoferences as $o_georeference) {
					foreach($o_georeference->getValues() as $o_value) {
						$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
						print caNavLink($this->request, trim($va_coord['label']), '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'geoloc_facet', 'id' => trim($va_coord['label'])));
					}
					print "<br/>";
				}
				print "</div>";
				
				
				print "</div><!-- end unit -->";	
			}
			# --- rights
			if($vs_tmp = $t_occurrence->get("ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub", array('convertCodesToDisplayText' => true))){
				print "\n<div class='unit'><div class='infoButton' id='rights'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Rights")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
				TooltipManager::add(
					"#rights", "<div class='infoTooltip'>Rights description.</div>"
				);
			}
		# --- dislay list of items associated to this occ - film
?>
		<div id="resultBox">
<?php
}
			$qr_hits = $this->getVar('browse_results');
			$vn_num_results = $qr_hits->numHits();
			$vn_current_page = $this->getVar('page');
			$vn_items_per_page = $this->getVar('items_per_page');
			$vn_total_pages = $this->getVar('num_pages');
			if($vn_num_results > 0){
				$vn_itemc = 0;
?>
				<div class="divide" style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
<?php
				$vn_start_result = (($vn_current_page - 1) * $vn_items_per_page) + 1;
				$vn_end_result = ($vn_current_page * $vn_items_per_page);
				if($vn_end_result > $vn_num_results){
					$vn_end_result = $vn_num_results;
				}
				print "<div id='searchResultHeading'>"._t("Copies of this film: %1", $vn_num_results)."</div>";
				print "<div id='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_results)."</div>";
?>
				<div id="itemResults">
<?php
				$vn_item_num_label = $vn_start_result;
				while(($vn_itemc < $vn_items_per_page) && ($qr_hits->nextHit())) {
					$vn_object_id = $qr_hits->get('ca_objects.object_id');
					
					$va_labels = $qr_hits->getDisplayLabels($this->request);
					print "<div class='result'>".$vn_item_num_label.") ";
					print $qr_hits->get('ca_objects.idno');
					#print caNavLink($this->request, $qr_hits->get('ca_objects.idno'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
					print "<div class='resultDescription'>";
					$va_desc = array();
					# --- pbcoreFormatStandard
					$va_format_standards = $qr_hits->get("ca_objects.pbcoreFormatStandard", array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
					if(sizeof($va_format_standards) > 0){
						$va_temp = array();
						foreach($va_format_standards as $va_format_standard){
							$va_temp[] = $va_format_standard["pbcoreFormatStandard"];
						}
						$va_desc[] = implode(", ", $va_temp);
					}
					# --- physical format
					$va_formats = $qr_hits->get("ca_objects.formatPhysical_nhf", array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
					if(sizeof($va_formats) > 0){
						$va_temp = array();
						foreach($va_formats as $va_format){
							$va_temp[] = $va_format["formatPhysical_nhf"];
						}
						$va_desc[] = implode(", ", $va_temp);
					}
					# --- Duration
					if($qr_hits->get("ca_objects.pbcoreFormatDuration")){
						$va_desc[] = $qr_hits->get("ca_objects.pbcoreFormatDuration");
					}
					# --- SoundSilent
					$va_SoundSilent = $qr_hits->get("ca_objects.SoundSilent", array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
					if(sizeof($va_SoundSilent) > 0){
						$va_temp = array();
						foreach($va_SoundSilent as $va_ss){
							$va_temp[] = $va_ss["SoundSilent"];
						}
						$va_desc[] = implode(", ", $va_temp);
					}
					# --- pbcoreFormatColors
					$va_colors = $qr_hits->get("ca_objects.pbcoreFormatColors", array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
					if(sizeof($va_colors) > 0){
						$va_temp = array();
						foreach($va_colors as $va_c){
							$va_temp[] = $va_c["pbcoreFormatColors"];
						}
						$va_desc[] = implode(", ", $va_temp);
					}
					print implode("; ", $va_desc);
					#print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/cross.gif' width='8' height='8' border='0' style='margin: 0px 3px 0px 15px;'>";
					#print caNavLink($this->request, _t("more"), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
					print "</div><!-- end description -->";
					print "</div>\n";
					$vn_itemc++;
					$vn_item_num_label++;
				}
				if($vn_total_pages > 1){
					$va_other_paging_parameters = array('occurrence_id' => $vn_occurrence_id, 'show_type_id' => intval($this->getVar('current_type_id')));
?>
					<div id='searchNavBg'><div class='searchNav'>
<?php		
					print "<div class='nav'>";
					if ($this->getVar('page') > 1) {
						print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') - 1), $va_other_paging_parameters))."\"); return false;'>&lt; "._t("Previous")."</a>&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;";
					}else{
						print "&lt;&lt; "._t("Previous")."&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;";
					}
					
					
					$vn_p = $vn_current_page;
					if($vn_p > ($vn_total_pages-3)){
						$vn_p = $vn_total_pages-3;
						if($vn_p < 1){
							$vn_p = 1;
						}
					}
					$vn_link_count = 1;
					print _t("Page: ");
					while(($vn_p <= $vn_total_pages) && ($vn_link_count <= 4)){
						if($vn_p == $vn_current_page){
							print $vn_p;
						}else{
							print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $vn_p), $va_other_paging_parameters))."\"); return false;'>".$vn_p."</a>";
						}
						if($vn_p != $vn_total_pages){
							print "&nbsp;&nbsp;";
						}
						$vn_p++;
						$vn_link_count++;
					}
					#print $vn_p;
					if($vn_p <= $vn_total_pages){
						print "<span class='turq'>...</span>";
					}
					if ($this->getVar('page') < $vn_total_pages) {
						print "&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("Next")." &gt;&gt;</a>";
					}else{
						print "&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;"._t("Next")." &gt;&gt;";
					}
					print '</div>';						
?>
					</div><!-- end searchNav --></div><!-- end searchNavBg -->
					<div style='margin: 0px 0px 25px 0px;'><!-- empty --></div>
<?php
				}
?>
				</div><!-- end itemResults -->
<?php
			}
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
<?php
		# --- user data --- comments - ranking - tagging	
?>
		<a name="comments"></a>
		<div class="divide" style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
		<div id="objUserData" >
<?php
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<div id="objUserDataCommentsTitle"><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_comment.jpg' width='34' height='25' border='0' style='margin: 0px 5px -3px 0px;'>".sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment"))._t(" on ")."\"".$vs_title."\""; ?></div><!-- end title -->
<?php
				foreach($va_comments as $va_comment){
?>
					<div id="objUserDataComment" >
						<div class="byLine">
	<?php
							if($va_comment['name']){
								if($va_comment['name']){
									print $va_comment['name']._t(" says").":";
								}
							}else{
								print _t("Anonymous says").":";
							}
	?>
						</div>
						<div class="dateLine">
							<?php print date("M jS Y, g:sA", $va_comment["created_on"]); ?>
						</div>
						<div class="comment">
							<?php print $va_comment["comment"]; ?>
						</div>
					</div>
<?php
				}
			}#else{
				#$vs_login_message = _t("Login/register to be the first to rank, tag and comment on this object!");
			#}
		#if($this->request->isLoggedIn()){
?>
			<div id="objUserDataFormTitle"><?php print _t("Post new comment"); ?></div><!-- end title -->
			<div id="objUserDataForm">
				<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Occurrence', 'saveCommentRanking', array('ocurrence_id' => $vn_occurrence_id)); ?>" name="comment">
					<div class="formLabel"><?php print _t("Your name"); ?></div>
					<input type="text" name="name">
					<div class="formLabel"><?php print _t("E-mail"); ?></div>
					<input type="text" name="email"><div class="formCaption"><?php print _t("Your email address will be kept private");?></div>
					<div class="formLabel"><?php print _t("Comment"); ?></div>
					<textarea name="comment" rows="5"></textarea>
					<br><br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_go.jpg' width='36' height='23' border='0'>"; ?></a>
				</form>
			</div>
<?php
		#}else{
		#	if (!$this->request->config->get('dont_allow_registration_and_login')) {
		#		print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail'))."</p>";
		#	}
		#}

?>		
		</div><!-- end objUserData-->
	
	</div><!-- end leftCol -->
			
	<div id="rightCol">
<?php
	print $this->render('../pageFormat/right_col_html.php');
?>
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>