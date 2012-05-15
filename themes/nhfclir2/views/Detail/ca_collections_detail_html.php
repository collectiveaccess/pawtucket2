<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_collections_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
	$t_collection 			= $this->getVar('t_item');
	$vn_collection_id 		= $t_collection->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_collections', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Collection', 'Show', array('collection_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Collection', 'Show', array('collection_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<h1><?php print $t_collection->get("idno"); ?></h1>
		<!--<div id="leftCol">	-->
<?php		
			# --- image
			if($t_collection->get('ca_collections.collection_still')){
				print "\n<div class='collectionStill'><div>".$t_collection->get('ca_collections.collection_still', array('version' => "medium", "showMediaInfo" => false))."</div>";
				if($t_collection->get('ca_collections.collection_still_credit')){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get('ca_collections.collection_still_credit')."</div>";
				}
				print "</div><!-- end collectionStill -->";
			}
			
			# --- video clip
			if($vs_player = $t_collection->get("ca_collections.collection_moving_image_media", array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
				print "\n<div class='clip'><div>".$vs_player."</div>";
				if($t_collection->get("ca_collections.collection_moving_image_credit")){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get("ca_collections.collection_moving_image_credit")."</div>";
				}
				print "</div><!-- end clip -->";
			}
?>
			<div class="unit"><span style="font-weight:bold; font-size:14px; color:#666666;">&raquo;</span> <a href="#reels"><b>Jump to reel inventory below</b></a></div><!-- end unit -->
<?php
			# --- creator(s) 
			$va_creators = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('created_by'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_creators) && sizeof($va_creators) > 0){
?>
				<div class="unit"><div class='heading'><?php print _t("Creator(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_creators as $va_creator) {
					print caNavLink($this->request, $va_creator["label"], '', 'clir2', 'PFCollectionsBrowse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_creator['entity_id']));
					if(sizeof($va_creators) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
?>
				</div><!-- end unit -->
<?php

			}
			
			# --- donor(s) 
			$va_donors = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('donated'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_donors) && sizeof($va_donors) > 0){
?>
				<div class="unit"><div class='heading'><?php print _t("Donor"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_donors as $va_donor) {
					#print caNavLink($this->request, $va_donor["label"], '', 'clir2', 'PFCollectionsBrowse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_donor['entity_id']));
					print $va_donor["label"];
					if(sizeof($va_donors) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
?>
				</div><!-- end unit --->
<?php

			}
			# --- primary_format
			if($t_collection->get('ca_collections.collection_primary_format')){
				print "\n<div class='unit'><div class='heading'>"._t("Primary Format and Extent")."</div><div>".$t_collection->get('ca_collections.collection_primary_format')."</div></div><!-- end unit -->";
			}
			# --- secondary_format
			if($t_collection->get('ca_collections.secondary_format')){
				print "\n<div class='unit'><div class='heading'>"._t("Secondary Format and Extent")."</div><div>".$t_collection->get('ca_collections.secondary_format')."</div></div><!-- end unit -->";
			}
			# --- collection_datespan
			if($t_collection->get('ca_collections.collection_datespan')){
				print "\n<div class='unit'><div class='heading'>"._t("Collection Date Range")."</div><div>".$t_collection->get('ca_collections.collection_datespan')."</div></div><!-- end unit -->";
			}
			# --- collection_summary
			if($t_collection->get('ca_collections.collection_summary')){
				print "\n<div class='unit'><div class='heading'>"._t("Summary")."</div><div>".$t_collection->get('ca_collections.collection_summary', array("convertLineBreaks" => true))."</div></div><!-- end unit -->";
			}
			# --- collection_biographical_notes
			if($t_collection->get('ca_collections.collection_biographical_notes')){
				print "\n<div class='unit'><div class='heading'>"._t("Biographical/Historical Notes")."</div><div>".$t_collection->get('ca_collections.collection_biographical_notes', array("convertLineBreaks" => true))."</div></div><!-- end unit -->";
			}
			# --- entities - relationship type depicts
			$va_entities = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('depicts'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if(is_array($va_entities) && sizeof($va_entities) > 0){
?>
				<div class="unit"><div class='heading'><?php print _t("People and Organizations"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_entities as $va_entity) {
					print caNavLink($this->request, $va_entity["label"], '', 'clir2', 'PFCollectionsBrowse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
					if(sizeof($va_entities) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
?>
				</div><!-- end unit --->
<?php

			}
			
			
			$va_genres = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('genre'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if (sizeof($va_genres)) {
?>
					<div class="unit"><div class='heading'><?php print _t("Genre"); ?>(s)</div>
<?php				
				$va_genre_links = array();
				foreach($va_genres as $va_term){
					$va_genre_terms[] = $va_term["label"];
				}
				print implode(", ", $va_genre_terms);
?>
					</div><!-- end unit -->
<?php
			}
			
			$va_subjects = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
			if (sizeof($va_subjects)) {
?>
					<div class="unit"><div class='heading'><?php print _t("Subject"); ?>(s)</div>
<?php				
				$va_subject_links = array();
				foreach($va_subjects as $va_term){
					$va_subject_links[] = caNavLink($this->request, $va_term["label"], '', 'clir2', 'PFCollectionsBrowse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'subject_facet', 'id' => $va_term['item_id']));
				}
				print implode(", ", $va_subject_links);
?>
					</div><!-- end unit -->
<?php
			}

			# --- places
			$va_geoferences = $t_collection->getAttributesByElement('georeference');
			if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
				print "\n<div class='unit'><div class='heading'>"._t("Place(s)")."</div>";
				$o_map = new GeographicMap(450, 250, 'map');
				$o_map->mapFrom($t_collection, 'georeference');
				print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
				print "<div class='collectionMapLabel'>";
				foreach($va_geoferences as $o_georeference) {
					foreach($o_georeference->getValues() as $o_value) {
						$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
						//print caNavLink($this->request, trim($va_coord['label']), '', '', 'Search', 'Index', array('search' => '"'.trim($va_coord['label']).'"', 'target' => 'ca_collections'));
						print caNavLink($this->request, trim($va_coord['label']), '', 'clir2', 'PFCollectionsBrowse', 'clearAndAddCriteria', array('target' => 'ca_collections', 'facet' => 'geoloc_facet', 'id' => trim($va_coord['label'])));
					}
					print "<br/>";
				}
				print "</div>";
				
				
				print "</div><!-- end unit -->";	
			}
					
			# --- collection_access_repos
			if($vs_tmp = $t_collection->get('ca_collections.collection_access_repos', array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><div class='heading'>"._t("Repository")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
			}
			# --- access
			if($vs_tmp = $t_collection->get('ca_collections.collection_access', array('convertCodesToDisplayText' => true))){
				print "<div class='unit'><div class='heading'>"._t("Availability")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
			}
			# --- repro_use
			if($t_collection->get('ca_collections.collection_repro_cond')){
				print "<div class='unit'><div class='heading'>"._t("Condition Governing Reproduction and Use")."</div><div>".$t_collection->get('ca_collections.collection_repro_cond')."</div></div><!-- end unit -->";
			}
			
			# --- download
			print "<div class='unit'><div class='heading'>"._t("Encoded archival description")."</div><div style='padding-top:5px;'>".caNavLink($this->request, _t("(EAD XML file)"), '', 'Detail', 'Collection', 'exportItem', array('collection_id' => $vn_collection_id, 'mapping' => 'nhf_standard_ead','download' => 1))."</div></div><!-- end unit -->";	
			# --- add this
?>
			<div class='unit'><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
<?php	
			# --- user data --- comments - tagging
?>			
			<div id="objUserData">
				<div class="divide" style="margin:20px 0px 10px 0px;"><!-- empty --></div>
<?php
				$va_tags = $this->getVar("tags_array");
				$va_comments = $this->getVar("comments");
				if(is_array($va_tags) && sizeof($va_tags) > 0){
					$va_tag_links = array();
					foreach($va_tags as $vs_tag){
						#$va_tag_links[] = caNavLink($this->request, $vs_tag, '', '', 'Search', 'Index', array('search' => $vs_tag));
						$va_tag_links[] = $vs_tag;
					}
?>
					<h2><?php print _t("Tags"); ?></h2>
					<div id="tags">
						<?php print implode($va_tag_links, ", "); ?>
					</div>
<?php
				}
				if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
					<h2><?php print _t("User Comments"); ?> <div id="numComments" style="float:none; display:inline;">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div></h2>
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
					if(!$vs_tags){
						$vs_login_message = _t("Login/register to be the first to tag and comment!");
					}
				}
				if((is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
					<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
				}
			if($this->request->isLoggedIn()){
?>
				<h2><?php print _t("Add your tags and comment"); ?></h2>
				<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Collection', 'saveCommentRanking', array('collection_id' => $vn_collection_id)); ?>" name="comment">
					<div class="formLabel"><?php print _t("Tags (separated by commas)"); ?></div>
					<input type="text" name="tags">
					<div class="formLabel"><?php print _t("Comment"); ?></div>
					<textarea name="comment" rows="5"></textarea>
					<br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save")." &raquo;"; ?></a>
				</form>
<?php
			}else{
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'CollectionDetail', 'collection_id' => $vn_collection_id))."</p>";
				}
			}
?>		
			</div><!-- end objUserData-->


<?php			
		# --- dislay list of items in this collection
?>
		<a name="reels"></a>
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
				<div class="divide" style="margin: 10px 0px 25px 0px;"><!-- empty --></div>
<?php
				$vn_start_result = (($vn_current_page - 1) * $vn_items_per_page) + 1;
				$vn_end_result = ($vn_current_page * $vn_items_per_page);
				if($vn_end_result > $vn_num_results){
					$vn_end_result = $vn_num_results;
				}
				print "<H4>"._t("Reel Inventory")."</H4>";
				print "<div id='searchResultHeading'>"._t("Items in this collection: %1", $vn_num_results)."</div>";
				print "<div id='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_results)."</div>";
?>
				<div id="itemResults">
<?php
				$vn_item_num_label = $vn_start_result;
				while(($vn_itemc < $vn_items_per_page) && ($qr_hits->nextHit())) {
					$vs_idno = $qr_hits->get('ca_occurrences.idno');
					# --- coverage
					$vs_date = "";
					$va_coverages = $qr_hits->get('ca_occurrences.pbcoreCoverage', array("returnAsArray" => 1, 'convertCodesToDisplayText' => true));
					if(sizeof($va_coverages) > 0){
						$i = 1;
						$va_dates = array();
						foreach($va_coverages as $va_coverage){
							# --- grab the dates and don't diplay the places since we're displaying the georeference below
							if($va_coverage['coverageType'] == "Temporal"){
								$va_dates[] = $va_coverage['coverage'];
							}
						}
						$vs_date = implode(", ", $va_dates);
					}
					$t_list = new ca_lists();
					$va_abstract_info = $t_list->getItemFromList('pbcore_description_types', 'abstract');
					$vn_abstract_id = $va_abstract_info["idno"];
					# --- descriptions
					$vs_description = "";
					$va_descriptions = $qr_hits->get('ca_occurrences.pbcoreDescription', array("returnAsArray" => 1, "convertLineBreaks" => true, 'convertCodesToDisplayText' => true));
					$va_content_desc = array();
					if(sizeof($va_descriptions) > 0){
						foreach($va_descriptions as $va_description){
							if($va_description["descriptionType"] == $vn_abstract_id){
								$vs_description = $va_description['description_text'];
							}
						}
					}
					$vn_occurrence_id = $qr_hits->get('ca_occurrences.occurrence_id');
					if(strlen($vs_description) > 185){
						$vs_description = trim(unicode_substr($vs_description, 0, 255))."... ";
					}
					$va_labels = $qr_hits->getDisplayLabels($this->request);
					print "<div class='result'>".$vn_item_num_label.") ";
					print caNavLink($this->request, join($va_labels, ", "), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
					if($vs_date){
						print ", ".$vs_date; 
					}
					print "<div class='resultDescription'>".$vs_description;
					#print " ".caNavLink($this->request, _t("more"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
					print "</div><!-- end description -->";
					print "</div>\n";
					$vn_itemc++;
					$vn_item_num_label++;
				}
				if($vn_total_pages > 1){
					$va_other_paging_parameters = array('collection_id' => $vn_collection_id, 'show_type_id' => intval($this->getVar('current_type_id')));
?>
					<div class='searchNavDetail'>
<?php		
					print "<div class='nav'>";
					if ($this->getVar('page') > 1) {
						print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') - 1), $va_other_paging_parameters))."\"); return false;'>&lsaquo; "._t("Previous")."</a>&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;";
					}else{
						print "&lsaquo; "._t("Previous")."&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;";
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
						print "&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("Next")." &rsaquo;</a>";
					}else{
						print "&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;"._t("Next")." &rsaquo;";
					}
					print '</div>';						
?>
					</div><!-- end searchNavDetail -->
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
	<!--</div>--><!-- end leftCol -->
</div><!-- end detailBody -->
<?php
}
?>