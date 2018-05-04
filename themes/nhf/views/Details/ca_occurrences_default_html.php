<?php
	$t_occurrence 		= $this->getVar('item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 			= $t_occurrence->get('ca_occurrences.preferred_labels.name');
	
	$va_comments 		= $this->getVar("comments");
	$pn_numRankings 	= $t_occurrence->getNumRatings();;
	$va_access_values 	= $this->getVar('access_values');
	
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
			$vs_video = "";
			# --- get the object related with "primary"
			if($vs_primary_video_object_id = $t_occurrence->get("ca_objects.object_id", array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array("primary"), "limit" => 1))){
				$t_object_video = new ca_objects($vs_primary_video_object_id);
				$vs_video = $t_object_video->get('ca_object_representations.media.original', array("checkAccess" => $va_access_values));
				if($vs_video){
					$vs_video .= "<div style='float:right; margin-top:3px;'><a href='#' style='text-decoration:none; font-size:16px;' onclick='pauseVideo(); caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $t_object_video->get("object_id"), 'representation_id' => $t_object_video->get('ca_object_representations.representation_id'), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in orange'></span></a></div>\n";
				}
			}

			$va_objects_ids = $t_occurrence->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
			$qr_hits = caMakeSearchResult("ca_objects", $va_objects_ids);
			$vn_num_results = $qr_hits->numHits();
			if($vn_num_results > 0){
?>
				<div style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
<?php
				print "<div id='searchResultHeadingCollection'>"._t("%1 %2 of This Film", $vn_num_results, (($vn_num_results == 1) ? "Copy" : "Copies"))."</div>";
?>
				<div id="itemResults">
<?php
				$vn_item_num_label = 1;
				while($qr_hits->nextHit()) {
					$vn_object_id = $qr_hits->get('ca_objects.object_id');
					
					print  "<div class='result'>".$vn_item_num_label.") ";
					print "<b>".$qr_hits->get("ca_objects.preferred_labels.name")."</b>";
					
					# --- if primary video not available, default to any
					if(!$vs_video && ($vs_video = $qr_hits->get('ca_object_representations.media.original', array("checkAccess" => $va_access_values)))){
						$vs_video .= "<div style='float:right; margin-top:3px;'><a href='#' style='text-decoration:none; font-size:16px;' onclick='pauseVideo(); caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $qr_hits->get('ca_object_representations.representation_id'), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in orange'></span></a></div>\n";
					}
					print "<div class='resultDescription'>";
					#if($vs_video){
						#print "<div style='float:right;'><a href='#' style='text-decoration:none; font-size:16px;' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $qr_hits->get('ca_object_representations.representation_id'), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in orange'></span></a></div>\n";
					#}
					$va_desc = array();
					# --- pbcoreFormatStandard
					if($vs_format_standards = $qr_hits->get("ca_objects.pbcoreFormatStandard", array("delimiter" => ", ", 'convertCodesToDisplayText' => true))){
						$va_desc[] = $vs_format_standards;
					}
					# --- physical format
					if($vs_formatPhysical_nhf = $qr_hits->get("ca_objects.formatPhysical_nhf", array("delimiter" => ", ", 'convertCodesToDisplayText' => true))){
						$va_desc[] = $vs_formatPhysical_nhf;
					}
					
					# --- Duration
					if($qr_hits->get("ca_objects.pbcoreFormatDuration")){
						$va_desc[] = $qr_hits->get("ca_objects.pbcoreFormatDuration");
					}
					# --- SoundSilent
					if($vs_soundSilent = $qr_hits->get("ca_objects.SoundSilent", array("delimiter" => ", ", 'convertCodesToDisplayText' => true))){
						$va_desc[] = $vs_soundSilent;
					}
					
					# --- pbcoreFormatColors
					if($vs_colors = $qr_hits->get("ca_objects.pbcoreFormatColors", array("delimiter" => ", ", 'convertCodesToDisplayText' => true))){
						$va_desc[] = $vs_colors;
					}
					
					print implode("; ", $va_desc);
					print "</div><!-- end description -->";
					
					print "</div>\n";
					$vn_item_num_label++;
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
					<?php print $pn_numRankings." ".(($pn_numRankings == 1) ? "Person likes this" : "People like this"); ?> <span class="gray">&nbsp;|&nbsp;</span> <?php print caGetThemeGraphic($this->request, 'b_like_this.gif', array("style" => "margin: 0px 5px -3px 0px")).caNavLink($this->request, 'I like this too', '', '', 'Detail', 'saveCommentTagging', array('item_id' => $vn_occurrence_id, 'rank' => 5, 'tablename' => 'ca_occurrences', 'inline' => 1, 'name' => 'anonymous', 'email' => 'anonymous')); ?>
				</div><!-- end counts -->
			</div><!-- end detailBodyTopInfo -->

<?php
			if($vs_video){
				print "\n<div class='unit'>".$vs_video."<br/></div>";
			}
			# --- idno
			if($t_occurrence->get('ca_occurrences.idno')){
				print "\n<div class='unit'><div class='infoButton' id='idno' data-toggle='popover' data-content='Identifier description.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Identifier")."</div><div>".$t_occurrence->get('ca_occurrences.idno')."</div></div><!-- end unit -->";

			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if($va_collections){
				print "\n<div class='unit'><div class='infoButton' id='collection' data-toggle='popover' data-content='Collection description'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Collection")."</div>";
				foreach($va_collections as $va_collection_info){
					print "<div>".caDetailLink($this->request, $va_collection_info['label'], '', 'ca_collections', $va_collection_info['collection_id'])."</div>";
				}
				print "</div><!-- end unit -->";
				
			}
			
			if($vs_date = $t_occurrence->get('ca_occurrences.occ_date', array("delimiter" => ", "))){
				print "\n<div class='unit'><div class='infoButton' data-toggle='popover' data-content='Associated dates.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Date(s)")."</div><div>".$vs_date."</div></div><!-- end unit -->";		
			}else{			
				# --- coverage
				$va_coverage = $t_occurrence->get('ca_occurrences.pbcoreCoverage', array("returnWithStructure" => 1, 'convertCodesToDisplayText' => true));
				if(is_array($va_coverage) && sizeof($va_coverage)){
					$va_dates = array();
					$va_coverage = array_pop($va_coverage);
					foreach($va_coverage as $va_coverage_info){
						if($va_coverage_info["coverageType"] == "Temporal"){
							$va_dates[] = $va_coverage_info["coverage"];
						}
					}
					if(sizeof($va_dates)){
						print "\n<div class='unit'><div class='infoButton' data-toggle='popover' data-content='Associated dates.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Date(s)")."</div><div>".(implode(", ", $va_dates))."</div></div><!-- end unit -->";
					}
				}
			}
			# --- image
			if($t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media')){
				print "\n<div class='unit'><div>".$t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "medium", "showMediaInfo" => false))."</div>";
				if($t_occurrence->get('ca_occurrences.ic_stills.ic_stills_credit')){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_occurrence->get('ca_occurrences.ic_stills.ic_stills_credit')."</div>";
				}
				print "</div><!-- end unit -->";
			}
			
			# --- video clip
			if($vs_player = $t_occurrence->get("ca_occurrences.ic_moving_images.ic_moving_images_media", array('version' => 'h264_hi', 'showMediaInfo' => false, 'viewer_width'=> 400, 'viewer_height' => 300, 'poster_frame_version' => 'medium'))){
				print "\n<div class='unit'><div>".$vs_player."</div>";
				if($t_occurrence->get("ca_occurrences.ic_moving_images.ic_moving_images_credit")){
					print "<div class='imageCaption'>"._t("Credit:")." ".$t_occurrence->get("ca_occurrences.ic_moving_images.ic_moving_images_credit")."</div>";
				}
				print "</div><!-- end unit -->";
			}
			
			# --- descriptions
			$va_descriptions = array_shift($t_occurrence->get('ca_occurrences.pbcoreDescription', array("returnWithStructure" => 1, "convertLineBreaks" => true, 'convertCodesToDisplayText' => true)));
			$va_desc_labels = array();
			$va_desc_text = array();
			if(is_array($va_descriptions) && sizeof($va_descriptions)){
				foreach($va_descriptions as $va_description){
					if($va_description["descriptionType"]){
						$va_desc_labels[] = $va_description["descriptionType"];
					}
					if($va_description["description_text"]){
						$va_desc_text[] = str_ireplace($vs_last_search, $vs_last_search_replace, $va_description["description_text"]);
					}
				}
				$i = 0;
				foreach($va_desc_labels as $vs_desc_label){
					print "\n<div class='unit'><div class='infoButton' data-toggle='popover' data-content='".$vs_desc_label."'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>".$vs_desc_label."</div><div>".$va_desc_text[$i]."</div></div><!-- end unit -->";
					$i++;
				}
			}
			
			$va_genre_names = $t_occurrence->get("ca_occurrences.genre_terms", array("returnWithStructure" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => true));
			if (sizeof($va_genre_names)) {
				$va_genre_item_ids = $t_occurrence->get("ca_occurrences.genre_terms", array("returnWithStructure" => 1, 'useSingular' => true, 'convertCodesToDisplayText' => false));
?>
					<div class="unit"><div class='infoButton' id='genre' data-toggle='popover' data-content='Term(s) identifying the genre or form of the work, e.g., amateur, interview.'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Genre"); ?>(s)</div>
<?php				
				$t_lists = new ca_lists();
				$va_genre_links = array();
				foreach($va_genre_names as $vs_k => $va_term){
					$va_genre_term[] = caNavLink($this->request, $va_term["genre_terms"], '', '', 'Browse', 'collections', array('facet' => 'genre_facet', 'id' => $va_genre_item_ids[$vs_k]['genre_terms']));
					
				}
				print implode(", ", $va_genre_term);
?>
					</div><!-- end unit -->
<?php
			}
			
			$va_entities_output = array();
			# --- creator(s) 
			$va_creators = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('creator'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
			if(is_array($va_creators) && sizeof($va_creators) > 0){
?>
				<div class="unit"><div class='infoButton' id='creators' data-toggle='popover' data-content='The primary person or organization responsible for creating the content of a work'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Creator(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_creators as $va_creator) {
					$va_entities_output[] = $va_creator['entity_id'];
					print caNavLink($this->request, $va_creator["label"], '', '', 'Browse', 'collections', array('facet' => 'entity_facet', 'id' => $va_creator['entity_id']));
					if(sizeof($va_creators) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
				
?>
				</div><!-- end unit --->
<?php

			}
			# --- contributor(s) 
			$va_contributors = $t_occurrence->get("ca_entities", array('restrict_to_relationship_types' => array('contributor'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
			if(is_array($va_contributors) && sizeof($va_contributors) > 0){
?>
				<div class="unit"><div class='infoButton' id='contributors'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Contributor(s)"); ?></div>
<?php
				$vn_i = 1;
				foreach($va_contributors as $va_contributor) {
					$va_entities_output[] = $va_contributor['entity_id'];
					print caNavLink($this->request, $va_contributor["label"], '', '', 'Browse', 'collections', array('facet' => 'entity_facet', 'id' => $va_contributor['entity_id']));
					if(sizeof($va_contributors) > $vn_i){
						print ", ";
					}
					$vn_i++;
				}
?>
				</div><!-- end unit --->
<?php

			}

			# --- entities(s) 
			$va_entities = $t_occurrence->get("ca_entities", array('checkAccess' => $va_access_values, "returnWithStructure" => 1));
			if(is_array($va_entities) && sizeof($va_entities) > 0){
				$va_entity_by_type = array();
				foreach($va_entities as $va_entity){
					if(!in_array($va_entity["entity_id"], $va_entities_output)){
						$va_entity_by_type[$va_entity["relationship_typename"]][] = array("entity_id" => $va_entity["entity_id"], "relationship_typename" => $va_entity["relationship_typename"], "label" => $va_entity["label"]);
					}
				}
				foreach($va_entity_by_type as $vs_relationship_typename => $va_entities_by_type){
?>
					<div class="unit"><div class='infoButton'  data-toggle='popover' data-content='Entity descriptions'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print caUcFirstUTF8Safe($vs_relationship_typename); ?></div>
<?php
					$vn_i = 1;
					foreach($va_entities_by_type as $va_entity) {
						print caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'collections', array('facet' => 'entity_facet', 'id' => $va_entity['entity_id']));
						if(sizeof($va_entities_by_type) > $vn_i){
							print ", ";
						}
						$vn_i++;
					}
?>
					</div><!-- end unit --->
<?php					
				}
			}
			
			$va_subjects = $t_occurrence->get("ca_list_items", array('restrict_to_relationship_types' => array('subject'), 'checkAccess' => $va_access_values, "returnWithStructure" => 1));
			if (sizeof($va_subjects)) {
?>
					<div class="unit"><div class='infoButton' id='subject' data-toggle='popover' data-content='Term(s) identifying what the work or collection is about'><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?></div><div class='heading'><?php print _t("Subject"); ?>(s)</div>
<?php				
				$va_subject_links = array();
				foreach($va_subjects as $va_term){
					$va_subject_links[] = caNavLink($this->request, $va_term["label"], '', '', 'Browse', 'collections', array('facet' => 'subject_facet', 'id' => $va_term['item_id']));
				}
				print implode(", ", $va_subject_links);
?>
					</div><!-- end unit -->
<?php
			}
			# --- places
			$va_geoferences = $t_occurrence->getAttributesByElement('georeference');
			if(is_array($va_geoferences) && (sizeof($va_geoferences) > 0)){	
				print "\n<div class='unit'><div class='infoButton' id='place' data-toggle='popover' data-content='Places associated with this work.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Place(s)")."</div>";
				$o_map = new GeographicMap(390, 300, 'map');
				$o_map->mapFrom($t_occurrence, 'georeference');
				print "<div class='collectionMap'>".$o_map->render('HTML')."</div>";
				print "<div class='collectionMapLabel'>";
				foreach($va_geoferences as $o_georeference) {
					foreach($o_georeference->getValues() as $o_value) {
						$va_coord = $o_value->getDisplayValue(array('coordinates' => true));
						print caNavLink($this->request, trim($va_coord['label']), '', '', 'Browse', 'collections', array('facet' => 'geoloc_facet', 'id' => trim($va_coord['label'])));
					}
					print "<br/>";
				}
				print "</div>";
				
				
				print "</div><!-- end unit -->";	
			}
			# --- rights
			if($vs_tmp = $t_occurrence->get("ca_occurrences.RightsSummaryNHF.NHFRightsSummaryPub", array('convertCodesToDisplayText' => true))){
				print "\n<div class='unit'><div class='infoButton' id='rights' data-toggle='popover' data-content='Rights description.'>".caGetThemeGraphic($this->request, 'b_info.gif')."</div><div class='heading'>"._t("Rights")."</div><div>{$vs_tmp}</div></div><!-- end unit -->";
			}

		# --- user data --- comments - ranking - tagging	
?>
		<a name="comments"></a>
		<div class="divide" style="margin: 0px 0px 25px 0px;"><!-- empty --></div>
		<div id="objUserData" >
<?php
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<div id="objUserDataCommentsTitle"><?php print caGetThemeGraphic($this->request, 'b_comment.jpg', array("style" => "0px 5px -3px 0px")).sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment"))._t(" on ")."\"".$vs_title."\""; ?></div><!-- end title -->
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
				<form method="post" action="<?php print caNavUrl($this->request, '', 'Detail', 'saveCommentTagging'); ?>" name="comment">
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
	pauseVideo = function(){
		$('.video-js video').each(function() {
			$(this).get(0).pause();
		});
	}

</script>