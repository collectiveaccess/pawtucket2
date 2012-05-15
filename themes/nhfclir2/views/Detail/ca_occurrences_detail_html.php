<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
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
	$t_occurrence 		= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');

	$va_access_values	= $this->getVar('access_values');
 	JavascriptLoadManager::register('tabUI');
?>
	<div id="detailBody">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', _t("Back"), ''))) {
?>
		<div id="pageNav">
<?php
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
?>
		</div><!-- end nav -->
<?php
			}
?>
		<h1><?php print $vs_title; ?></h1>
		<div id="leftCol">
<?php
			$va_still_medium = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "medium", "showMediaInfo" => false, "returnAsArray" => true));
			$va_image_caption = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_credit', array("returnAsArray" => true));
			# --- video - if no video display still if available
			if($vs_video = $t_occurrence->get('ca_occurrences.ic_moving_images.ic_moving_images_media', array('version' => 'original', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
				print '<div class="unit">';
				print $vs_video;
				# -- check for caption
				if($vs_video_caption = $t_occurrence->get('ca_occurrences.ic_moving_images.ic_moving_images_credit')){
					print "<div class='caption'>".$vs_video_caption."</div>";
				}
				print "</div><!-- end unit -->";
			}else{
				# --- stills and caption are grabbed above so can be reused below if necessary
				if((is_array($va_still_medium)) && (sizeof($va_still_medium) > 0)){
					$vs_still_medium = array_shift($va_still_medium);
					print '<div class="unit">';
					print $vs_still_medium;
					if(is_array($va_image_caption) && (sizeof($va_image_caption) > 0)){
						$vs_image_caption = array_shift($va_image_caption);
						print "<div class='caption'>".$vs_image_caption."</div>";
					}
					print "</div><!-- end unit -->";
					$vn_displayedStillInPlaceOfVideo = 1;
				}
			}
			# stills - do not show first still if was displayed above
			$va_still_thumbnail = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "icon", "showMediaInfo" => false, "returnAsArray" => true));
			if((is_array($va_still_thumbnail)) && (sizeof($va_still_thumbnail) > 0)){
				if($vn_displayedStillInPlaceOfVideo){
					$vs_first_still = array_shift($va_still_thumbnail);
				}
				if(sizeof($va_still_thumbnail) > 0){
					print "<div class='unit'><div class='heading'>Frame Enlargements</div><!-- end heading -->";
					foreach($va_still_thumbnail as $vn_stillId => $vs_thumbnail){
						print "<div class='ICStills' id='thumb".$vn_stillId."'>".$vs_thumbnail."</div>";
						TooltipManager::add(
							"#thumb".$vn_stillId, "<div style='width:400px;'>".$va_still_medium[$vn_stillId]."<br/><class='caption'>".$va_image_caption[$vn_stillId]."</span></div>"
						);
					}
					print "<div style='clear:both; height:1px;'><!-- empty --></div></div><!-- end unit -->";
				}
			}
?>
			<!-- AddThis Button, download link, bookmark link -->
			<div class="unit">
				<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script>
<?php
			print "&nbsp;&nbsp;&nbsp;".caNavLink($this->request, _t("(Download PBCore XML file)"), '', 'Detail', 'Occurrence', 'exportItem', array('occurrence_id' => $vn_occurrence_id, 'mapping' => 'nhf_pbcore_export','download' => 1));	
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "&nbsp;&nbsp;&nbsp;";
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Add to My Sets"), '', 'clir2', 'MySets', 'addItem', array('occurrence_id' => $vn_occurrence_id));
				}else{
					print caNavLink($this->request, _t("Add to My Sets"), '', '', 'LoginReg', 'form', array('site_last_page' => 'MySets', 'occurrence_id' => $vn_occurrence_id));
				}
			}
?>
			</div><!-- end unit -->
			<!-- end AddThis Button, download link, bookmark link -->
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
				<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Occurrence', 'saveCommentRanking', array('occurrence_id' => $vn_occurrence_id)); ?>" name="comment">
					<div class="formLabel"><?php print _t("Tags (separated by commas)"); ?></div>
					<input type="text" name="tags">
					<div class="formLabel"><?php print _t("Comment"); ?></div>
					<textarea name="comment" rows="5"></textarea>
					<br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save")." &raquo;"; ?></a>
				</form>
<?php
			}else{
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'OccurrenceDetail', 'occurrence_id' => $vn_occurrence_id))."</p>";
				}
			}
?>		
			</div><!-- end objUserData-->
			
		</div><!-- end leftCol -->
		<div id="rightCol">
<?php
			# --- what browse should the terms/related info be linked to?
			$vs_browse_controller = "";
			if($t_occurrence->get("curatorial_selection")){
				$va_curatorial_selection = array();
				$va_curatorial_selection_raw = $t_occurrence->get("curatorial_selection", array('returnAsArray' => 1));
				foreach($va_curatorial_selection_raw as $vn_key => $va_cs){
					$va_curatorial_selection[] = $va_cs["curatorial_selection"];
				}
				$t_list = new ca_lists();
				$vn_nywf_curatorial_selection_id = $t_list->getItemIDFromList('curatorial_selection2', 'NYWF');
				if(in_array($vn_nywf_curatorial_selection_id, $va_curatorial_selection)){
					$vs_browse_controller = "NYWFOccurrencesBrowse";
				}else{
					$vs_browse_controller = "PFOccurrencesBrowse";
				}	
			}

			if($t_occurrence->get("CLIR2_institution", array('convertCodesToDisplayText' => true))){
				$va_repository = array_pop($t_occurrence->get("CLIR2_institution", array('returnAsArray' => 1)));
				$vs_repository_id = $va_repository["CLIR2_institution"];
				print "\n<div class='unit'><div class='heading'>"._t("Repository")."</div><div>";
				if($vs_browse_controller){
					print caNavLink($this->request, $t_occurrence->get("CLIR2_institution", array('convertCodesToDisplayText' => true)), '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('target' => 'ca_occurrences', 'facet' => 'repository', 'id' => $vs_repository_id));
				}else{
					print $t_occurrence->get("CLIR2_institution", array('convertCodesToDisplayText' => true));
				}
				print "</div></div><!-- end unit -->";
			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if($va_collections){
				print "\n<div class='unit'><div class='heading'>"._t("Collection Name")."</div>";
				foreach($va_collections as $va_collection_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['idno'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])."</div>";
				}
				print "</div><!-- end unit -->";
			}
			$t_list = new ca_lists();
			$va_abstract_info = $t_list->getItemFromList('pbcore_description_types', 'abstract');
			$vn_abstract_id = $va_abstract_info["idno"];
			# --- descriptions
			$va_descriptions = $t_occurrence->get('ca_occurrences.pbcoreDescription', array("returnAsArray" => 1, "convertLineBreaks" => true, 'convertCodesToDisplayText' => true));
			$va_content_desc = array();
			if(sizeof($va_descriptions) > 0){
				foreach($va_descriptions as $va_description){
					if($va_description["descriptionType"] == $vn_abstract_id){
						print "\n<div class='unit'><div>".$va_description['description_text']."</div></div><!-- end unit -->";
					}else{
						$va_content_desc[] = array("desc" => $va_description['description_text'], "heading" => $va_description['descriptionType']);
					}
				}
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
				if(is_array($va_dates) && (sizeof($va_dates) > 0)){
					print "\n<div class='unit'><div class='heading'>"._t("Date")."</div><div>".(implode(", ", $va_dates))."</div></div><!-- end unit -->";
				}
			}
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>Content Description</span></a></li>
        <li><a href="#fragment-2"><span>Physical Description</span></a></li>
        <li><a href="#fragment-3"><span>Access Points</span></a></li>
    </ul>
    <div id="fragment-1">
<?php
		$va_entities_output = array();
		# --- creator(s) 
		$va_creators = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('creator'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
		if(is_array($va_creators) && sizeof($va_creators) > 0){
?>
			<div class="unit"><div class='heading'><?php print _t("Creator(s)"); ?></div>
<?php
			$vn_i = 1;
			foreach($va_creators as $va_creator) {
				$va_entities_output[] = $va_creator['entity_id'];
				if($vs_browse_controller){
					print caNavLink($this->request, $va_creator["label"], '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('target' => 'ca_occurrences', 'facet' => 'entity_facet', 'id' => $va_creator['entity_id']));
				}else{
					print $va_creator["label"];
				}
				if(sizeof($va_creators) > $vn_i){
					print ", ";
				}
				$vn_i++;
			}
?>
			</div><!-- end unit --->
<?php

		}
		# --- descriptive text other than abstract - grabbed above when displaying abstract
		if(sizeof($va_content_desc) > 0){
			foreach($va_content_desc as $va_desc){
				print "\n<div class='unit'><div class='heading'>".$va_desc["heading"]."</div><div>".$va_desc["desc"]."</div></div><!-- end unit -->";
			}
		}
		# --- rights
		if($vs_tmp = $t_occurrence->get("ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub", array('convertCodesToDisplayText' => true))){
			print "\n<div class='unit'><div class='heading'>"._t("Rights")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
		}
?>
    </div>
	<div id="fragment-2">
<?php
		$qr_hits = $this->getVar('browse_results');
		$vn_num_results = $qr_hits->numHits();
		print "<div class='unit'><div class='heading'>"._t("%1 %2", $vn_num_results, (($vn_num_results == 1) ? _t("item") : _t("items")))."</div></div><!-- end unit -->";
		if($vn_num_results > 0){
			$i = 1;
			while($qr_hits->nextHit()) {
				$vn_object_id = $qr_hits->get('ca_objects.object_id');
				
				$va_labels = $qr_hits->getDisplayLabels($this->request);
				
				$va_desc = array();
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
				print "<div class='numberMarker'>".$i.".</div>";
				print "<div class='relatedObjectsListItem'>";
				print "<div class='unit'>".implode("; ", $va_desc)."</div>";
				print "<div class='unit'>";
				if($qr_hits->get('ca_objects.formatGenerations_nhf')){
					print $qr_hits->get('ca_objects.formatGenerations_nhf', array('convertCodesToDisplayText' => true)).", ";
				}
				print $qr_hits->get('ca_objects.idno')."</div>";
				if($qr_hits->get('ca_objects.pbcoreAnnotation')){
					print "<div class='unit'><div class='heading'>"._t("Inspection notes")."</div> ".$qr_hits->get('ca_objects.pbcoreAnnotation', array("convertLineBreaks" => true))."</div><!-- end unit -->";
				}
				print "</div><!-- end relatedObjectsListItem -->";
				$i++;
			}
		}
?>
	</div>
    <div id="fragment-3">
<?php		
		# --- place(s) 
		$va_places = $t_occurrence->get("ca_places", array('checkAccess' => $va_access_values, "returnAsArray" => 1));
		if(is_array($va_places) && sizeof($va_places) > 0){
?>
			<div class="unit"><div class='heading'><?php print _t("New York World's Fair Features"); ?></div>
<?php
			$vn_i = 1;
			foreach($va_places as $va_place) {
				if($vs_browse_controller){
					print caNavLink($this->request, $va_place["label"], '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('facet' => 'place_facet', 'id' => $va_place['place_id']));
				}else{
					print $va_place["label"];
				}
				if(sizeof($va_places) > $vn_i){
					print ", ";
				}
				$vn_i++;
			}
?>
			</div><!-- end unit --->
<?php

		}
		# --- map
		$va_geoferences = $t_occurrence->getAttributesByElement('georeference');
		if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
			print "\n<div class='unit'><div class='heading'>"._t("Place(s)")."</div>";
			$o_map = new GeographicMap(435, 200, 'map');
			$o_map->mapFrom($t_occurrence, 'georeference');
			print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
			print "<div class='collectionMapLabel'>";
			foreach($va_geoferences as $o_georeference) {
				foreach($o_georeference->getValues() as $o_value) {
					$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
					if($vs_browse_controller){
						print caNavLink($this->request, trim($va_coord['label']), '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('facet' => 'geoloc_facet', 'id' => trim($va_coord['label'])));
					}else{
						print $va_coord['label'];
					}
					
				}
				print "<br/>";
			}
			print "</div>";
			
			
			print "</div><!-- end unit -->";	
		}
		$va_subjects = $t_occurrence->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
		if (sizeof($va_subjects)) {
?>
				<div class="unit"><div class='heading'><?php print _t("Subject(s)"); ?></div>
<?php				
			$va_subject_links = array();
			foreach($va_subjects as $va_term){
				if($vs_browse_controller){
					$va_subject_links[] = caNavLink($this->request, $va_term["label"], '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('facet' => 'subject_facet', 'id' => $va_term['item_id']));
				}else{
					$va_subject_links[] = $va_term["label"];
				}
			}
			print implode(", ", $va_subject_links);
?>
				</div><!-- end unit -->
<?php
		}
		$va_genre_names = $t_occurrence->get("ca_occurrences.genre_terms", array("returnAsArray" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => true));
		if (sizeof($va_genre_names)) {
			$va_genre_item_ids = $t_occurrence->get("ca_occurrences.genre_terms", array("returnAsArray" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => false));
?>
				<div class="unit"><div class='heading'><?php print _t("Genre(s)"); ?></div>
<?php				
			$t_lists = new ca_lists();
			$va_genre_links = array();
			foreach($va_genre_names as $vs_k => $va_term){
				$va_genre_terms[] = $va_term["genre_terms"];
			}
			print implode(", ", $va_genre_terms);
?>
				</div><!-- end unit -->
<?php
		}
		# --- contributor(s) 
		$va_contributors = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('contributor'), 'checkAccess' => $va_access_values, "returnAsArray" => 1));
		if(is_array($va_contributors) && sizeof($va_contributors) > 0){
?>
			<div class="unit"><div class='heading'><?php print _t("People and Organizations"); ?></div>
<?php
			$vn_i = 1;
			foreach($va_contributors as $va_contributor) {
				$va_entities_output[] = $va_contributor['entity_id'];
				if($vs_browse_controller){
					print caNavLink($this->request, $va_contributor["label"], '', 'clir2', $vs_browse_controller, 'clearAndAddCriteria', array('facet' => 'entity_facet', 'id' => $va_contributor['entity_id']));
				}else{
					print $va_contributor["label"];
				}
				if(sizeof($va_contributors) > $vn_i){
					print ", ";
				}
				$vn_i++;
			}
?>
			</div><!-- end unit --->
<?php

		}
?>
    </div>
</div><!-- end tabs -->
			<script>
				$(document).ready(function() {
					$("#tabs").tabs({ selected: 0 });
				});
			</script>
		</div><!-- end rightCol -->

</div><!-- end detailBody -->