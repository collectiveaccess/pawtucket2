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
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	JavascriptLoadManager::register('smoothDivScrollVertical');
?>
	<div id="subnav">
<?php
		if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
			print "<ul><li>";
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "&laquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}else{
				print "&laquo; "._t("Previous");
			}
			print "</li>";
			print "<li>&nbsp;&nbsp;&nbsp;".$vs_back_link."</li>";
			print "<li>";
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, "&raquo; "._t("Next"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
			}else{
				print "&raquo; "._t("Next");
			}
			print "</li></ul>";
		}else{
			print "<ul><li>".caNavLink($this->request, "&laquo; "._t("Artist Browser"), "", "eastend", "ArtistBrowser", "Index")."</li></ul>";
		}
?>
	</div><!--end subnav-->

	<div id="art_content">
<?php
		if($t_object->get("creation_date")){
			$vs_date = ", ".$t_object->get("creation_date");
		}
		print "<div id='art_title'><span class='listhead caps'>".$vs_title;
		if($vs_date){
			print $vs_date;
		}
		print "</div>";
		
		print "<div style='clear:both;'>";
		if ($t_rep && $t_rep->getPrimaryKey()) {
			$vs_vaga_class = "";
			if($t_object->get("object_status") == 349){
				$vs_vaga_class = "vagaDisclaimer";
			}
			$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
			$vn_width = $va_media_info["WIDTH"];;
			if($vn_width > 580){
				$vn_width = 580;
			}
?>
			<div id="art_detail" <?php print ($vs_vaga_class) ? "class='".$vs_vaga_class."'" : ""; ?> style="width:<?php print $vn_width; ?>px;">
<?php
			if($t_object->get("object_status") == 348){
				# --- VAGA ARS do not show image
				print "<div id='imgPlaceholderDetail'>Image not available for view</div>";
			}else{
				if($va_display_options['no_overlay']){
					print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
				}else{
					$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
					print "<div id='cont'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";
				}
			}
			if($t_object->get("caption")){
				print "<div class='caption' style='margin-bottom:3px;'>";
				if($vs_vaga_class){
					print "<a href='http://www.vagarights.com' target='_blank'>";
				}
				print $t_object->get("caption");
				if($vs_vaga_class){
					print "</a>";
				}
				print "</div><!-- end caption -->";
			}
			if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections'))) {
				$vs_lightbox_link = "<div class='caption'>";
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("+ Add to Lightbox"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
				}else{
					print caNavLink($this->request, _t("+ Add to Lightbox"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
				}
				print "</div>";
			}
?>
			</div><!-- end art_detail -->
<?php
			# --- increase width of art_detail_info if the image is less than 580 px wide
			$vn_info_width = 200;
			if($va_media_info["WIDTH"] < 580){
				$vn_info_width = $vn_info_width + (580 - $va_media_info["WIDTH"]);
			}
		}
?>
		<div id="art_detail_info" <?php print ($vn_info_width) ? "style='width:".$vn_info_width."px;'" : ""; ?>>	
<?php			
			# --- creator
			$va_creator = $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("maker", "artist"), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			$t_creator = new ca_entities();
			if(sizeof($va_creator) > 0){	
				foreach($va_creator as $va_entity) {
					$vs_creator = (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"]);
					# --- load the entity record for the creator so can grab the portrait
					$t_creator->load($va_entity["entity_id"]);
				}
				# --- get the portrait of the creator
	// 			$va_portraits = $t_creator->get("ca_objects", array("restrictToRelationshipTypes" => array("portrait"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
	// 			foreach($va_portraits as $va_portrait){
	// 				$t_object = new ca_objects($va_portrait["object_id"]);
	// 				if($va_portrait = $t_object->getPrimaryRepresentation(array('tiny'), null, array('return_with_access' => $va_access_values))){
	// 					print "<div id='portrait'>".$va_portrait['tags']['tiny']."</div><!-- end portrait -->";
	// 					break;
	// 				}
	// 			}
				if($t_creator->get("lifespans_date")){
					$vs_lifespan = $t_creator->get("lifespans_date");
				}
				print "<span class='caption listhead caps'>".$vs_creator;
				if($vs_lifespan){
					print " (".$vs_lifespan.")";
				}
				print "</span><br/>";
			}
			
			# --- identifier
			if($t_object->get('idno')){
				print "<span class='caption'>Identifier: ".$t_object->get('idno')."</span><br/>";
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array('delimiter' => ', ', 'convertCodesToDisplayText' => true))){
						print "<span class='caption'>".$vs_value."</span><br/>";
					}
				}
			}

			# if($this->request->config->get('ca_objects_description_attribute')){
// 			#	if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
// 			#		print "<p class='caption'>".$vs_description_text."</p>";
// 			#	}
// 			#}
			
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("excludeRelationshipTypes" => array("maker", "artist"), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			if(sizeof($va_entities) > 0){	
				print "<p class='caption'>";
				foreach($va_entities as $va_entity) {
					print $va_entity['relationship_typename'].": ".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])."<br/>";
				}
				print "</p>";
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$vn_scrollOccurrences = 0;
			if(sizeof($va_occurrences) > 0){	
				if(sizeof($va_occurrences) > 6){
					$vn_scrollOccurrences = 1;
				}
				if(sizeof($va_entities) == 0){
					print "<br/>";
				}
?>
				<div class='listhead caps' style='padding-bottom:0px;'><?php print _t("Related Exhibitions & Events"); ?></div>
<?php
				$va_occurrences_sorted = array();
				foreach($va_occurrences as $va_occurrence) {
					$va_occurrences_sorted[$va_occurrence['relationship_typename']][] = "<div style='padding-bottom:5px;'>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_occurrence["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_occurrence["occurrence_id"])) : $va_occurrence["label"])."</div>";
				}
?>
				<div class='art_related_list' style='<?php print ($vn_scrollOccurrences) ? "" : " height:auto;"; print ($vn_info_width) ? " width: ".$vn_info_width."px;" : ""; ?>'>
<?php
					foreach($va_occurrences_sorted as $vs_relationship_type => $va_links){
						print "<div class='caption'><i>".$vs_relationship_type."</i></div>";
						foreach($va_links as $vs_link){
							print $vs_link;
						}
					}
					if($vn_scrollOccurrences){
?>
					<script type="text/javascript">
						// Initialize the plugin
						$(document).ready(function () {
							$("div.art_related_list").smoothDivScroll({
								visibleHotSpotBackgrounds: "always",
								hotSpotScrollingInterval: 45
							});
						});
					</script>
<?php
					}
?>
				</div><!-- end ex_related_list -->
<?php
			}
			
			# --- places
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			
			if(sizeof($va_places) > 0){
				print "<p class='caption'>";
				foreach($va_places as $va_place_info){
					print $va_place_info['relationship_typename'].": ".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])."<br/>";
				}
				print "</p>";
			}
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(200, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<p class='caption'>".$o_map->render('HTML')."</p>";
			}
			
?>
		</div> <!--end art_detail_info-->
		</div>
	</div><!--end art_content-->


<?php
# --- $x is a hack to hide comment form - not sure if this is needed
if ($x && !$this->request->config->get('dont_allow_registration_and_login')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData">
<?php
			if($this->getVar("ranking")){
?>
				<h2 id="ranking"><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;"></h2>
<?php
			}
			$va_tags = $this->getVar("tags_array");
			if(is_array($va_tags) && sizeof($va_tags) > 0){
				$va_tag_links = array();
				foreach($va_tags as $vs_tag){
					$va_tag_links[] = caNavLink($this->request, $vs_tag, '', '', 'Search', 'Index', array('search' => $vs_tag));
				}
?>
				<h2><?php print _t("Tags"); ?></h2>
				<div id="tags">
					<?php print implode($va_tag_links, ", "); ?>
				</div>
<?php
			}
			$va_comments = $this->getVar("comments");
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<h2><div id="numComments">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div><?php print _t("User Comments"); ?></h2>
<?php
				foreach($va_comments as $va_comment){
					if($va_comment["media1"]){
?>
						<div class="commentImage" id="commentMedia<?php print $va_comment["comment_id"]; ?>">
							<?php print $va_comment["media1"]["tiny"]["TAG"]; ?>							
						</div><!-- end commentImage -->
<?php
						TooltipManager::add(
							"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
						);
					}
					if($va_comment["comment"]){
?>					
					<div class="comment">
						<?php print $va_comment["comment"]; ?>
					</div>
<?php
					}
?>					
					<div class="byLine">
						<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
					</div>
<?php
				}
			}else{
				if(!$vs_tags && !$this->getVar("ranking")){
					$vs_login_message = _t("Login/register to be the first to rank, tag and comment on this object!");
				}
			}
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<h2><?php print _t("Add your rank, tags and comment"); ?></h2>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment" enctype='multipart/form-data'>
				<div class="formLabel">Rank
					<select name="rank">
						<option value="">-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<div class="formLabel"><?php print _t("Tags (separated by commas)"); ?></div>
				<input type="text" name="tags">
				<div class="formLabel"><?php print _t("Media"); ?></div>
				<input type="file" name="media1">
				<div class="formLabel"><?php print _t("Comment"); ?></div>
				<textarea name="comment" rows="5"></textarea>
				<br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
			</form>
<?php
		}else{
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
			}
		}
?>		
		</div><!-- end objUserData-->
<?php
	}

	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	
?>
