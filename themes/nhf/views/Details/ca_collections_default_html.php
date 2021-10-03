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
	$t_collection 		= $this->getVar('item');
	$vn_collection_id 	= $t_collection->getPrimaryKey();
	
	$vs_title 			= $t_collection->get("ca_collections.preferred_labels.name");
	
	$t_rel_types 		= $this->getVar('t_relationship_types');
	$va_comments 		= $this->getVar("comments");
	$pn_numRankings 	= $t_collection->getNumRatings();
	$va_access_values = 			$this->getVar('access_values');	

	$va_occ_with_ids = nhfOccWithClips($this->request, $vn_collection_id);
	
	# --- last search term
	$o_result_context = new ResultContext($this->request, "ca_collections", "multisearch");
	$vs_last_search = $o_result_context->getSearchExpression();
	$vs_last_search_replace = "<span class='highlightSearchTerm'>".$vs_last_search."</span>";


?>
	<div class="row" style="clear:both;">
		<div class="col-xs-3">
<div id="resultBox">
	<div class="detailNavigation">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
<?php
			$va_occ_ids = $t_collection->get("ca_occurrences.occurrence_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
			$o_context = new ResultContext($this->request, 'ca_occurrences', 'detail');
			$o_context->setAsLastFind();
			$o_context->setResultList($va_occ_ids);
			$o_context->saveContext();
			$qr_hits = caMakeSearchResult("ca_occurrences", $va_occ_ids);
			$vn_num_results = $qr_hits->numHits();
			if($vn_num_results > 0){
?>
				<div style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
<?php
				print "<div id='searchResultHeadingCollection'>"._t("%1 Item%2 in This Collection", $vn_num_results, (($vn_num_results == 1) ? "" : "s"))."</div>";
				#print "<div id='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_results)."</div>";
?>
				<div id="itemResults">
<?php
				if($vn_num_results > 100){
					print "<div class='resultDescription'>Showing 100 of ".$vn_num_results.". ".caNavLink($this->request, _t("View all"), '', '', 'Browse', 'Occurrences', array('facet' => 'collection_facet', 'id' => $vn_collection_id))."</div>";
				}
				$vn_item_num_label = 1;
				while($qr_hits->nextHit()) {
					$vs_idno = $qr_hits->get('ca_occurrences.idno');
		
					$vn_occurrence_id = $qr_hits->get('ca_occurrences.occurrence_id');
					$vs_has_video = "";
					if(in_array($vn_occurrence_id, $va_occ_with_ids)){
						$vs_has_video = "<span class='glyphicon glyphicon-facetime-video'></span>";
					}
					$vs_description =  $qr_hits->get('ca_occurrences.pbcoreDescription.description_text');
					if(strlen($vs_description) > 185){
						$vs_description = trim(mb_substr(strip_tags($vs_description), 0, 185))."...";
					}
					print "<div class='result'>".$vn_item_num_label.") ";
					print caDetailLink($this->request, $qr_hits->get("ca_occurrences.preferred_labels.name"), '', 'ca_occurrences', $vn_occurrence_id)." ".$vs_has_video;
					print "<div class='resultDescription'>".$vs_description;
					print "&nbsp;&nbsp;&nbsp;".caDetailLink($this->request, caGetThemeGraphic($this->request, 'cross.gif', array("style" => "margin: 0px 3px 0px 0px;")).""._t("more"), 'moreLink', 'ca_occurrences', $vn_occurrence_id);
					print "</div><!-- end description -->";
					print "</div>\n";
					$vn_item_num_label++;
					if(($vn_item_num_label == 100) && ($vn_num_results > 100)){
						print caNavLink($this->request, _t("View all items"), '', '', 'Browse', 'Occurrences', array('facet' => 'collection_facet', 'id' => $vn_collection_id));
						
						break;
					}
				}
?>
				</div><!-- end itemResults -->
<?php
			}
?>
			</div><!-- end resultBox -->
		</div><!-- end col -->
		<div class="col-xs-6" id="detailBody">
			<div class="detailBodyTopInfo">
				<div id="title"><?php print $vs_title; ?></div>
				<div id="counts">
					<a href="#comments"><?php print sizeof($va_comments); ?> comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></a><br/> 
					<?php print $pn_numRankings." ".(($pn_numRankings == 1) ? "Person likes this" : "People like this"); ?> <span class="gray">&nbsp;|&nbsp;</span> <?php print caGetThemeGraphic($this->request, 'b_like_this.gif', array('style' => 'margin: 0px 5px -3px 0px;')).caNavLink($this->request, 'I like this too', '', '', 'Detail', 'saveCommentTagging', array('item_id' => $vn_collection_id, 'rank' => 5, 'tablename' => 'ca_collections', 'inline' => 1, 'name' => 'anonymous', 'email' => 'anonymous')); ?>
				</div><!-- end counts -->
			</div><!-- end detailBodyTopInfo -->
	<?php
				# --- Accession Number(s)
				$va_related_lots = $t_collection->get("ca_object_lots", array('checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if(is_array($va_related_lots) && sizeof($va_related_lots) > 0){
					print "<div class='unit'><div class='infoButton' id='accessionNo' data-toggle='popover' data-content='An identifier applied to a collection when it arrives at the archives.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Collection Identifier(s)")."</div>";
					foreach($va_related_lots as $id => $va_info){
						print "<div>".$va_info["label"].", ".$va_info["idno_stub"]."</div>";
					}
					print "</div><!-- end unit -->";
				}
				# --- creator(s) 
				$va_creators = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('created_by'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if(is_array($va_creators) && sizeof($va_creators) > 0){
	?>
					<div class="unit"><div class='infoButton' id='creators' data-toggle='popover' data-content='The primary person or organization responsible for creating the content of a work.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Creator(s)"); ?></div>
	<?php
					$vn_i = 1;
					foreach($va_creators as $va_creator) {
						print caNavLink($this->request, $va_creator["label"], '', '', 'Browse', 'Collections', array('facet' => 'entity_facet', 'id' => $va_creator['entity_id']));
						if(sizeof($va_creators) > $vn_i){
							print ", ";
						}
						$vn_i++;
					}
	?>
					</div><!-- end unit --->
	<?php

				}
			
				# --- donor(s) 
				$va_donors = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('donated'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if(is_array($va_donors) && sizeof($va_donors) > 0){
	?>
					<div class="unit"><div class='infoButton' id='donors' data-toggle='popover' data-content='The person or organization who donated or deposited the collection at Northeast Historic Film.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Donor"); ?></div>
	<?php
					$vn_i = 1;
					foreach($va_donors as $va_donor) {
						print caNavLink($this->request, $va_donor["label"], '', '', 'Browse', 'Collections', array('facet' => 'entity_facet', 'id' => $va_donor['entity_id']));
						if(sizeof($va_donors) > $vn_i){
							print ", ";
						}
						$vn_i++;
					}
	?>
					</div><!-- end unit --->
	<?php

				}
				# --- image
				if($vs_tag = $t_collection->get('ca_collections.collection_still.medium', array("showMediaInfo" => false))){
					print "\n<div class='unit'><div>{$vs_tag}</div>";
					if($t_collection->get('ca_collections.collection_still_credit')){
						print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get('ca_collections.collection_still_credit')."</div>";
					}
					print "</div><!-- end unit -->";
				}
			
				# --- video clip
				if($t_collection->get("ca_collections.collection_moving_image_media")){
					if($vs_player = $t_collection->get("ca_collections.collection_moving_image_media.original", array('showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
						print "\n<div class='unit'><div>{$vs_player}</div>";
						if($t_collection->get("ca_collections.collection_moving_image_credit")){
							print "<div class='imageCaption'>"._t("Credit:")." ".$t_collection->get("ca_collections.collection_moving_image_credit")."</div>";
						}
						print "</div><!-- end unit -->";
					}
				}
				# --- primary_format
				if($t_collection->get('ca_collections.collection_primary_format')){
					print "\n<div class='unit'><div class='infoButton' id='primary_format' data-toggle='popover' data-content='Type and quantity of the majority of materials in the collection.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Primary Format and Extent")."</div><div>".$t_collection->get('ca_collections.collection_primary_format')."</div></div><!-- end unit -->";
				}
				# --- secondary_format
				if($t_collection->get('ca_collections.secondary_format')){
					print "\n<div class='unit'><div class='infoButton' id='secondary_format' data-toggle='popover' data-content='Type and quantity of the second largest group of materials'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Secondary Format and Extent")."</div><div>".$t_collection->get('ca_collections.secondary_format')."</div></div><!-- end unit -->";
				}
				# --- collection_datespan
				if($t_collection->get('ca_collections.collection_datespan')){
					print "\n<div class='unit'><div class='infoButton' id='collection_datespan' data-toggle='popover' data-content='Date span of the content'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Collection Date Range")."</div><div>".$t_collection->get('ca_collections.collection_datespan')."</div></div><!-- end unit -->";
				}
				# --- collection_summary
				if($t_collection->get('ca_collections.collection_summary')){
					print "\n<div class='unit'><div class='infoButton' id='collection_summary' data-toggle='popover' data-content='Basic information about the nature of the collection'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Summary")."</div><div>".str_ireplace($vs_last_search, $vs_last_search_replace, $t_collection->get('ca_collections.collection_summary', array("convertLineBreaks" => true)))."</div></div><!-- end unit -->";	
				}
				# --- collection_biographical_notes
				if($t_collection->get('ca_collections.collection_biographical_notes')){
					print "\n<div class='unit'><div class='infoButton' id='collection_biographical_notes' data-toggle='popover' data-content='Information about the creator, donor, and content.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Biographical/Historical Notes")."</div><div>".str_ireplace($vs_last_search, $vs_last_search_replace, $t_collection->get('ca_collections.collection_biographical_notes', array("convertLineBreaks" => true)))."</div></div><!-- end unit -->";		
				}
				# --- entities - relationship type depicts
				$va_entities = $t_collection->get("ca_entities", array('restrict_to_relationship_types' => array('depicts'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if(is_array($va_entities) && sizeof($va_entities) > 0){
	?>
					<div class="unit"><div class='infoButton' id='entities' data-toggle='popover' data-content='Individuals and groups depicted in or associated with the collection.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("People and Organizations"); ?></div>
	<?php
					$vn_i = 1;
					foreach($va_entities as $va_entity) {
						print caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'Collections', array('facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
						if(sizeof($va_entities) > $vn_i){
							print ", ";
						}
						$vn_i++;
					}
	?>
					</div><!-- end unit --->
	<?php

				}
			
			
				$va_genres = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('genre'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if (sizeof($va_genres)) {
	?>
						<div class="unit"><div class='infoButton' id='genre' data-toggle='popover' data-content='Term(s) identifying the genre or form of the work, e.g., amateur, interview.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Genre"); ?>(s)</div>
	<?php				
					$va_genre_links = array();
					foreach($va_genres as $va_term){
						$va_genre_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'Collections', array('facet' => 'genre_facet', 'id' => $va_term['item_id']));
					}
					print implode(", ", $va_genre_links);
	?>
						</div><!-- end unit -->
	<?php

				}
			
				$va_subjects = $t_collection->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
				if (sizeof($va_subjects)) {
	?>
						<div class="unit"><div class='infoButton' id='subject' data-toggle='popover' data-content='Term(s) identifying what the work or collection is about.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Subject"); ?>(s)</div>
	<?php				
					$va_subject_links = array();
					foreach($va_subjects as $va_term){
						$va_subject_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'Collections', array('facet' => 'subject_facet', 'id' => $va_term['item_id']));
					}
					print implode(", ", $va_subject_links);
	?>
						</div><!-- end unit -->
	<?php

				}

				# --- places
				$va_geoferences = $t_collection->get('georeference', array("returnAsArray" => true));
				#if((is_array($va_geonames) && (sizeof($va_geonames) > 0)) || (is_array($va_geoferences) && (sizeof($va_geoferences) > 0))){	
				if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
					print "\n<div class='unit'><div class='infoButton' id='place' data-toggle='popover' data-content='Places associated with the work.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Place(s)")."</div>";
					$o_map = new GeographicMap(390, 300, 'map');
					$o_map->mapFrom($t_collection, 'georeference');
					print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
					print "<div class='collectionMapLabel'>";
					foreach($va_geoferences as $vs_georeference) {
						$vs_georeference_short = mb_substr($vs_georeference, 0, strpos($vs_georeference, "["));
						print caNavLink($this->request, $vs_georeference_short, '', '', 'Browse', 'Collections', array('facet' => 'geoloc_facet', 'id' => $vs_georeference));
						print "<br/>";
					}
					print "</div>";
					//print_r($va_geonames);
				
				
					print "</div><!-- end unit -->";	
				}
					
				# --- collection_access_repos
				if($vs_tmp = $t_collection->get('ca_collections.collection_access_repos', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><div class='infoButton' id='collection_access_repos' data-toggle='popover' data-content='Location where the collection is stored'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Repository")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
				}
				# --- access
				if($vs_tmp = $t_collection->get('ca_collections.collection_access', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><div class='infoButton' id='access' data-toggle='popover' data-content='Whether or not the collection is open for research.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Availability")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
				}
				# --- repro_use
				if($t_collection->get('ca_collections.collection_repro_cond')){
					print "<div class='unit'><div class='infoButton' id='repro_use' data-toggle='popover' data-content='Information regarding the use of the collection.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Condition Governing Reproduction and Use")."</div><div>".$t_collection->get('ca_collections.collection_repro_cond')."</div></div><!-- end unit -->";

				}	
			# --- user data --- comments - ranking - tagging	
	?>
			<a name="comments"></a>
			<div class="divide" style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
			<div id="objUserData" >
	<?php
				if(is_array($va_comments) && (sizeof($va_comments) > 0)){
	?>
					<div id="objUserDataCommentsTitle"><?php print caGetThemeGraphic($this->request, 'b_comment.jpg', array('style' => 'margin: 0px 5px -3px 0px;')).sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment"))._t(" on ")."\"".$vs_title."\""; ?></div><!-- end title -->
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
				}
	?>
				<div id="objUserDataFormTitle"><?php print _t("Post new comment"); ?></div><!-- end title -->
				<div id="objUserDataForm">
					<form method="post" action="<?php print caNavUrl($this->request, '', 'Detail', 'saveCommentTagging', ['csrfToken' => caGenerateCSRFToken($this->request)]); ?>" name="comment">
						<div class="formLabel"><?php print _t("Your name"); ?></div>
						<input type="text" name="name" value="<?php print $this->getVar("form_name"); ?>">
						<div class="formLabel"><?php print _t("E-mail"); ?></div>
						<input type="text" name="email" value="<?php print $this->getVar("form_email"); ?>"><div class="formCaption"><?php print _t("Your email address will be kept private");?></div>
						<div class="formLabel"><?php print _t("Comment"); ?></div>
						<textarea name="comment" rows="5"><?php print $this->getVar("form_comment"); ?> </textarea>
						<br><br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print caGetThemeGraphic($this->request, 'b_like_this.gif'); ?></a>						
						<input type="hidden" name="item_id" value="<?php print $vn_collection_id; ?>">
						<input type="hidden" name="tablename" value="<?php print $this->getVar("detailType"); ?>">
						<input type="hidden" name="inline" value="1">
					</form>
				</div>
			</div><!-- end objUserData-->
	
	</div><!-- end col -->
			
	<div class="col-xs-3"><div class="rightCol">
<?php
	print $this->render('pageFormat/right_col_html.php');
?>
	</div><!-- end rightCol -->
	</div><!-- end Col --></div><!-- end row -->

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#resultBox").height(jQuery("#detailBody").height() + "px");
		jQuery("#resultBox").css("padding-top", jQuery(".detailBodyTopInfo").height() + "px");
		if(jQuery("#itemResults").height() > jQuery("#resultBox").height()){
			jQuery("#itemResults").addClass("scroll");
		}
		$(function () {
		  $('[data-toggle="popover"]').popover({
			trigger: 'hover',
			title: ''
		  })
		})
	});

</script>
