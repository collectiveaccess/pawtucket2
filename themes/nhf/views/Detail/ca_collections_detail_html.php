<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
	$t_collection 		= $this->getVar('t_item');
	$vn_collection_id 	= $t_collection->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');
	$va_comments 		= $this->getVar("comments");
	$pn_numRankings 	= $this->getVar("numRankings");
	$va_access_values = 			$this->getVar('access_values');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="leftCol">	
			<div id="title"><?php print $t_collection->get("idno"); ?></div>
			<div id="counts">
				<a href="#comments"><?php print sizeof($va_comments); ?> comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></a><br/> 
				<?php print $pn_numRankings." ".(($pn_numRankings == 1) ? "Person likes this" : "People like this"); ?> <span class="gray">&nbsp;|&nbsp;</span> <?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_like_this.gif' width='17' height='18' border='0' style='margin: 0px 5px -3px 0px;'>".caNavLink($this->request, 'I like this too', '', 'Detail', 'Collection', 'saveCommentRanking', array('collection_id' => $vn_collection_id, 'rank' => 5)); ?>
			</div><!-- end counts -->
<?php
			# --- Accession Number(s)
			$va_related_lots = $t_collection->get("ca_object_lots", array('checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_related_lots) && sizeof($va_related_lots) > 0){
				print "<div class='unit'><div class='infoButton' id='accessionNo'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Collection Identifier(s)")."</div>";
				foreach($va_related_lots as $id => $va_info){
					print "<div>".$va_info["label"].", ".$va_info["idno_stub"]."</div>";
				}
				print "</div><!-- end unit -->";
				TooltipManager::add(
					"#accessionNo", "<div class='infoTooltip'>An identifier applied to a collection when it arrives at the archives. </div>"
				);
			}
			# --- creator(s) 
			$va_creators = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('created_by'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_creators) && sizeof($va_creators) > 0){
?>
				<div class="unit"><div class='infoButton' id='creators'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Creator(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_creators as $va_creator) {
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
			
			# --- donor(s) 
			$va_donors = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('donated'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_donors) && sizeof($va_donors) > 0){
?>
				<div class="unit"><div class='infoButton' id='donors'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Donor"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_donors as $va_donor) {
					print caNavLink($this->request, $va_donor["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_donor['entity_id']));
					if(sizeof($va_donors) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
				TooltipManager::add(
					"#donors", "<div class='infoTooltip'>The person or organization who donated or deposited the collection at Northeast Historic Film.</div>"
				);
?>
				</div><!-- end unit --->
<?php

			}
			# --- image
			if($t_collection->get('ca_collections.collection_still')){
				print "\n<div class='unit'><div>".$t_collection->get('ca_collections.collection_still', array('version' => "medium", "showMediaInfo" => false))."</div>";
				if($t_collection->get('ca_collections.collection_still_credit')){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get('ca_collections.collection_still_credit')."</div>";
				}
				print "</div><!-- end unit -->";
			}
			
			# --- video clip
			if($vs_player = $t_collection->get("ca_collections.collection_moving_image_media", array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
				print "\n<div class='unit'><div>".$vs_player."</div>";
				if($t_collection->get("ca_collections.collection_moving_image_credit")){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get("ca_collections.collection_moving_image_credit")."</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- primary_format
			if($t_collection->get('ca_collections.collection_primary_format')){
				print "\n<div class='unit'><div class='infoButton' id='primary_format'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Primary Format and Extent")."</div><div>".$t_collection->get('ca_collections.collection_primary_format')."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#primary_format", "<div class='infoTooltip'>Type and quantity of the majority of materials in the collection. </div>"
				);
			}
			# --- secondary_format
			if($t_collection->get('ca_collections.secondary_format')){
				print "\n<div class='unit'><div class='infoButton' id='secondary_format'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Secondary Format and Extent")."</div><div>".$t_collection->get('ca_collections.secondary_format')."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#secondary_format", "<div class='infoTooltip'>Type and quantity of the second largest group of materials.</div>"
				);
			}
			# --- collection_datespan
			if($t_collection->get('ca_collections.collection_datespan')){
				print "\n<div class='unit'><div class='infoButton' id='collection_datespan'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Collection Date Range")."</div><div>".$t_collection->get('ca_collections.collection_datespan')."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#collection_datespan", "<div class='infoTooltip'>Date span of the content.</div>"
				);
			}
			# --- collection_summary
			if($t_collection->get('ca_collections.collection_summary')){
				print "\n<div class='unit'><div class='infoButton' id='collection_summary'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Summary")."</div><div>".$t_collection->get('ca_collections.collection_summary', array("convertLineBreaks" => true))."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#collection_summary", "<div class='infoTooltip'>Basic information about the nature of the collection. </div>"
				);
			}
			# --- collection_biographical_notes
			if($t_collection->get('ca_collections.collection_biographical_notes')){
				print "\n<div class='unit'><div class='infoButton' id='collection_biographical_notes'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Biographical/Historical Notes")."</div><div>".$t_collection->get('ca_collections.collection_biographical_notes', array("convertLineBreaks" => true))."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#collection_biographical_notes", "<div class='infoTooltip'>Information about the creator, donor, and content.</div>"
				);
			}
			# --- entities - relationship type depicts
			$va_entities = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('depicts'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_entities) && sizeof($va_entities) > 0){
?>
				<div class="unit"><div class='infoButton' id='entities'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("People and Organizations"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_entities as $va_entity) {
					print caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
					if(sizeof($va_entities) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
				TooltipManager::add(
					"#entities", "<div class='infoTooltip'>Individuals and groups depicted in or associated with the collection.</div>"
				);
?>
				</div><!-- end unit --->
<?php

			}
			
			
			$va_genres = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('genre'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if (sizeof($va_genres)) {
?>
					<div class="unit"><div class='infoButton' id='genre'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'><?php print _t("Genre"); ?>(s)</div>
<?php				
				$va_genre_links = array();
				foreach($va_genres as $va_term){
					$va_genre_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'genre_facet', 'id' => $va_term['item_id']));
				}
				print implode(", ", $va_genre_links);
?>
					</div><!-- end unit -->
<?php
					TooltipManager::add(
						"#genre", "<div class='infoTooltip'>Term(s) identifying the genre or form of the work, e.g., amateur, interview.</div>"
					);

			}
			
			$va_subjects = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
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
			#$va_geonames = $t_collection->getAttributesByElement('geonames');
			$va_geoferences = $t_collection->getAttributesByElement('georeference');
			#if((is_array($va_geonames) && (sizeof($va_geonames) > 0)) || (is_array($va_geoferences) && (sizeof($va_geoferences) > 0))){	
			if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
				print "\n<div class='unit'><div class='infoButton' id='place'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Place(s)")."</div>";
				$o_map = new GeographicMap(390, 300, 'map');
				$o_map->mapFrom($t_collection, 'georeference');
				print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
				print "<div class='collectionMapLabel'>";
				// foreach($va_geonames as $o_geoname) {
// 					foreach($o_geoname->getValues() as $o_value) {
// 						$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
// 						//print caNavLink($this->request, trim($va_coord['label']), '', '', 'Search', 'Index', array('search' => '"'.trim($va_coord['label']).'"', 'target' => 'ca_collections'));
// 					}
// 					print "<br/>";
// 				}
				foreach($va_geoferences as $o_georeference) {
					foreach($o_georeference->getValues() as $o_value) {
						$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
						//print caNavLink($this->request, trim($va_coord['label']), '', '', 'Search', 'Index', array('search' => '"'.trim($va_coord['label']).'"', 'target' => 'ca_collections'));
						print caNavLink($this->request, trim($va_coord['label']), '', '', 'Browse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'geoloc_facet', 'id' => trim($va_coord['label'])));
					}
					print "<br/>";
				}
				print "</div>";
				//print_r($va_geonames);
				
				
				print "</div><!-- end unit -->";	
			}
					
			# --- collection_access_repos
			if($vs_tmp = $t_collection->get('ca_collections.collection_access_repos', array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><div class='infoButton' id='collection_access_repos'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Repository")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
				TooltipManager::add(
					"#collection_access_repos", "<div class='infoTooltip'>Location where the collection is stored.</div>"
				);
			}
			# --- access
			if($vs_tmp = $t_collection->get('ca_collections.collection_access', array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><div class='infoButton' id='access'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Availability")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
				TooltipManager::add(
					"#access", "<div class='infoTooltip'>Whether or not the collection is open for research.</div>"
				);
			}
			# --- repro_use
			if($t_collection->get('ca_collections.collection_repro_cond')){
				print "<div class='unit'><div class='infoButton' id='repro_use'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Condition Governing Reproduction and Use")."</div><div>".$t_collection->get('ca_collections.collection_repro_cond')."</div></div><!-- end unit -->";
				TooltipManager::add(
					"#repro_use", "<div class='infoTooltip'>Information regarding the use of the collection.</div>"
				);
			}
			
			# --- download
			print "<div class='unit'><div class='infoButton' id='download'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("Encoded archival description")."</div><div style='padding-top:5px;'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_download.jpg' width='90' height='33' border='0' style='vertical-align:middle;'> "._t("(EAD XML file)"), '', 'Detail', 'Collection', 'exportItem', array('collection_id' => $vn_collection_id, 'mapping' => 'nhf_standard_ead','download' => 1))."</div></div><!-- end unit -->";
			TooltipManager::add(
				"#download", "<div class='infoTooltip'>Encoded Archival Description is an XML standard for encoding archival finding aids.</div>"
			);	
		# --- dislay list of items in this collection
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
				print "<div id='searchResultHeading'>"._t("Items in this collection: %1", $vn_num_results)."</div>";
				print "<div id='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_results)."</div>";
?>
				<div id="itemResults">
<?php
				$vn_item_num_label = $vn_start_result;
				while(($vn_itemc < $vn_items_per_page) && ($qr_hits->nextHit())) {
					$vs_idno = $qr_hits->get('ca_occurrences.idno');
		
					$vn_occurrence_id = $qr_hits->get('ca_occurrences.occurrence_id');
					$vs_description =  $qr_hits->get('ca_occurrences.pbcoreDescription.description_text');
					if(strlen($vs_description) > 185){
						$vs_description = trim(unicode_substr($vs_description, 0, 185))."...";
					}
					$va_labels = $qr_hits->getDisplayLabels($this->request);
					print "<div class='result'>".$vn_item_num_label.") ";
					print caNavLink($this->request, join($va_labels, ", "), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
					print "<div class='resultDescription'>".$vs_description;
					print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/cross.gif' width='8' height='8' border='0' style='margin: 0px 3px 0px 15px;'>";
					print caNavLink($this->request, _t("more"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
					print "</div><!-- end description -->";
					print "</div>\n";
					$vn_itemc++;
					$vn_item_num_label++;
				}
				if($vn_total_pages > 1){
					$va_other_paging_parameters = array('collection_id' => $vn_collection_id, 'show_type_id' => intval($this->getVar('current_type_id')));
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
				<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Collection', 'saveCommentRanking', array('collection_id' => $vn_collection_id)); ?>" name="comment">
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