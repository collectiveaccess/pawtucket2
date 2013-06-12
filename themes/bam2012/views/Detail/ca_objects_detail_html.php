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

?>	
	<div id="detailBody" class='detailBodyObject'>
		<div id="objectTopArea">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->

		<div id="leftCol">
			<div id="objectType"><?php print unicode_ucfirst($this->getVar('typename'))?></div>
			<h1><?php print $vs_title; ?></h1>
<?php

			# --- identifier
			if ($va_idno = $t_object->get('idno')) {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Identifier')."</div>{$va_idno}</div><!-- end mdItemHeading -->";
			}
			# --- subtypes
			if ($va_subtypepress = $t_object->get('ca_objects.pressSubTypes', array('convertCodesToDisplayText' => true)) && $va_subtypepress != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypepress}</div><!-- end mdItemHeading -->";
			}
			if ($va_subtypeadmin = $t_object->get('ca_objects.adminSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypeadmin != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypeadmin}</div><!-- end mdItemHeading -->";
			}	
			if ($va_subtypephoto = $t_object->get('ca_objects.photoSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypephoto != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypephoto}</div><!-- end mdItemHeading -->";
			}	
			if ($va_subtypepromo = $t_object->get('ca_objects.promotionalSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypepromo != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypepromo}</div><!-- end mdItemHeading -->";
			}
			if ($va_subtypeeph = $t_object->get('ca_objects.ephemeraSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypeeph != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypeeph}</div><!-- end mdItemHeading -->";
			}	
			if ($va_subtypeaudio = $t_object->get('ca_objects.audioSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypeaudio != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypeaudio}</div><!-- end mdItemHeading -->";
			}	
			if ($va_subtypefilm = $t_object->get('ca_objects.filmSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypefilm != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypefilm}</div><!-- end mdItemHeading -->";
			}
			if ($va_subtypevideo = $t_object->get('ca_objects.videoSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypevideo != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypevideo}</div><!-- end mdItemHeading -->";
			}
			if ($va_subtypeother = $t_object->get('ca_objects.otherSubTypes', array('convertCodesToDisplayText' => true)) && $va_subtypeother != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypeother}</div><!-- end mdItemHeading -->";
			}
			if ($va_subtypeobject = $t_object->get('ca_objects.objectSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypeobject != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypeobject}</div><!-- end mdItemHeading -->";
			}	
			if ($va_subtypememo = $t_object->get('ca_objects.memoSubtypes', array('convertCodesToDisplayText' => true)) && $va_subtypememo != "") {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Subtype')."</div>{$va_subtypememo}</div><!-- end mdItemHeading -->";
			}
			if ($va_date = $t_object->get('ca_objects.sourceDate')) {
				print "<div class='mdItem'><div class='mdItemHeading'>"._t('Date')."</div>{$va_date}</div><!-- end mdItemHeading -->";
			}
			$va_caption = $t_object->get("ca_objects.image_caption.image_caption_text", array('returnAsArray' => true));
			if (sizeof($va_caption) > 1){
				foreach ($va_caption as $caption){
					if ($caption['image_caption_type'] == "543") {
						print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Caption')."</div>".$caption["image_caption_text"]."</div>";
					}
				}
			} elseif ($va_caption){
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Caption')."</div>".$t_object->get("ca_objects.image_caption.image_caption_text")."</div>";
			}			
			if ($va_description = $t_object->get('ca_objects.description.description_text', array('convertCodesToDisplayText' => true))) {
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Description')."</div>{$va_description}</div><!-- end mdItemHeading -->";
			}	
			if ($va_source = $t_object->get('ca_objects.sourceDescription', array('convertCodesToDisplayText' => true))) {
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Source Description')."</div>{$va_source}</div><!-- end mdItemHeading -->";
			}	
			if ($va_rights = $t_object->get('ca_objects.rights', array('convertCodesToDisplayText' => true))) {
				print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Rights')."</div>{$va_rights}</div><!-- end mdItemHeading -->";
			}
			if ($t_object->get('ca_objects.use_history.use_history_date') != ""){
				if ($va_use = $t_object->get('ca_objects.use_history', array('template' => '^use_history_date: ^use_history_notes'))) {
					print "<div class='mdItemLong'><div class='mdItemHeading'>"._t('Use History')."</div>{$va_use}</div><!-- end mdItemHeading -->";
				}		
			}	
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}

			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><h2>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h2> ";
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
			
			
			# --- places
			$va_places = $t_object->get("ca_places", array("template" => "<l>^ca_places.preferred_labels.name</l> (^relationship_typename)", "returnAsLink" => true, "returnAsArray" => true, 'checkAccess' => $va_access_values));
			
			if(sizeof($va_places) > 0){
				print "<div class='unit'><h2>"._t("Related places")."</h2>";
				print join("<br/>\n", $va_places);
				print "</div><!-- end unit -->";
			}

			
			# --- lots
			$va_object_lots = $t_object->get("ca_object_lots", array("template" => "<l>^preferred_labels.name</l> (^idno_stub)", "returnAsLink" => true, "returnAsArray" => true, 'checkAccess' => $va_access_values));
			if(sizeof($va_object_lots) > 0){
				print "<div class='unit'><h2>"._t("Related lot")."</h2>";
				print join("<br/>\n", $va_object_lots);
				print "</div><!-- end unit -->";
			}
			
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("template" => "<l>^ca_list_items.preferred_labels.name_plural</l> (^relationship_typename)", "returnAsLink" => true, "returnAsArray" => true, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><h2>"._t("Subjects")."</h2>";
				print join("<br/>\n", $va_terms);
				print "</div><!-- end unit -->";
			}
			
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}	
					
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h2>"._t("Related objects")."</h2>";
				print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 4;
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					if($col == 0){
						print "<tr>";
					}
					print "<td align='center' valign='middle' class='imageIcon icon".$va_info["object_id"]."'>";
					print caNavLink($this->request, $va_reps['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_reps['tags']['small']);
					$this->setVar('tooltip_title', $va_info['label']);
					$this->setVar('tooltip_idno', $va_info["idno"]);
					TooltipManager::add(
						".icon".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
					
					print "</td>";
					$col++;
					if($col < $vn_numCols){
						print "<td align='center'><!-- empty --></td>";
					}
					if($col == $vn_numCols){
						print "</tr>";
						$col = 0;
					}
				}
				if(($col != 0) && ($col < $vn_numCols)){
					while($col <= $vn_numCols){
						if($col < $vn_numCols){
							print "<td><!-- empty --></td>";
						}
						$col++;
						if($col < $vn_numCols){
							print "<td align='center'><!-- empty --></td>";
						}
					}
				}
				print "</table></div><!-- end unit -->";
			}
?>
		</div><!-- end leftCol-->

		<div id="rightCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="objDetailImage">
<?php
			if($va_display_options['no_overlay']){
				print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
			}else{
				$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
				print "<div id='cont'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";
			}
?>
			</div><!-- end objDetailImage -->
<?php
		}
		

?>
		<div id="objDetailToolbar">
<?php
			
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if(!$this->request->isLoggedIn()){
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/comment.png' border='0' title='"._t("Login/register to rank, tag and comment on this item.")."'>", "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id));
				}
			}
			print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/email.png' border='0' title='"._t("Email this record")."'>", "", "Share", "Share", "objectForm", array('object_id' => $vn_object_id));
			if ($this->request->config->get('show_facebook_share')) {
				print "<a href='http://www.facebook.com/sharer.php?u=".urlencode($this->request->config->get("site_host").caNavUrl($this->request, "Detail", "Object", "Show", array("object_id" => $vn_object_id)))."&t=".urlencode($vs_title)."'><img src='".$this->request->getThemeUrlPath()."/graphics/icons/facebook.png' border='0' title='"._t("Share on Facebook")."'></a>";	
			}
			# --- bookmark link
			if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){

				if($this->request->isLoggedIn()){
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='"._t("Bookmark Item")."'>", '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
				}else{
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/bookmark.png' border='0' title='"._t("Bookmark Item")."'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
				}
			}
			if($t_rep && $t_rep->getPrimaryKey()){
				# --- add to lightbox link
				if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections'))) {
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/lightbox.png' border='0' title='"._t("Add to Lightbox")."'>", '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
					}else{
						print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/lightbox.png' border='0' title='"._t("Add to Lightbox")."'>", '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
					}
				}
				# --- output download link? 
				if(caObjectsDisplayDownloadLink($this->request)){
					# -- get version to download configured in media_display.conf
					$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
					$vs_download_version = $va_download_display_info['display_version'];
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/icons/download.png' border='0' title='"._t("Download Media")."'>", '', 'Detail', 'Object', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $vn_object_id, "download" => 1, "version" => $vs_download_version));
				}
				# --- zoom link
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' ><img src='".$this->request->getThemeUrlPath()."/graphics/icons/zoom.png' border='0' title='".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))."'></a>";

			}
?>
		</div><!-- end objDetailToolbar -->
<?php
if (!$this->request->config->get('dont_allow_registration_and_login')) {
		$va_tags = $this->getVar("tags_array");
		$va_comments = $this->getVar("comments");
		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData">
<?php
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
			if($this->getVar("ranking")){
?>
				<h2 id="ranking"><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;"></h2>
<?php
			}
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

		if($this->request->isLoggedIn()){
?>

			<div class="divide" style="margin:0px 0px 10px 0px;"><!-- empty --></div>
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
				if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
					print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
				}
			}
		}
?>		
		</div><!-- end objUserData-->
<?php
	}
?>
		</div><!-- end rightCol -->
		<div style="clear:both;"><!-- empty --></div>
	</div><!-- end objectTopArea -->
<?php	
	if (($t_object->get("ca_occurrences")) | ($t_object->get("ca_entities"))) {		
?>
	<div id="relatedInfo"><table cellpadding="0" cellspacing="0"><tr>
<?php
		# --- production
		$va_production = array();
		$va_production = $t_object->get("ca_occurrences", array("returnAsArray" => 1));
		if(sizeof($va_production) > 0){
			print "<td id='relatedProduction'><h2>"._t("Production").((sizeof($va_production) > 1) ? "s" : "")."</h2>";
			foreach($va_production as $va_prod){
				print "<div class='relatedItem'>".caNavLink($this->request, $va_prod['name'], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_prod['occurrence_id']))."</div>";
			}
			print "</td><!-- end relatedGenres -->";
		}else{
			$vn_showRelatedFiller = 1;
		}
		# --- depicts
		$va_depicts = array();
		$va_depicts = $t_object->get("ca_entities", array("returnAsArray" => 1, "restrictToRelationshipTypes" => array("depicts", "described", "sort" => "ca_entities.surname")));
		if(sizeof($va_depicts) > 0){
			print "<td id='relatedDepicts'><h2>"._t("Depicts")."</h2>";
			foreach($va_depicts as $va_depict){
				print "<div class='relatedItem'>".caNavLink($this->request, $va_depict["displayname"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_depict['entity_id']))."</div>";
			}
			print "</td><!-- end depicts -->";
		}else{
			$vn_showRelatedFiller = 1;
		}
		# -- creator
		$va_creator = array();
		$va_creator = $t_object->get("ca_entities", array("returnAsArray" => 1, "restrictToRelationshipTypes" => array("contributor", "creator", "photographer", "videographer", "donated", "owned", "publisher")));
		if(sizeof($va_creator) > 0){
			print "<td id='relatedCreator'><h2>"._t("Created By")."</h2>";
			foreach($va_creator as $va_creators){
				print "<div class='relatedItem'>".caNavLink($this->request, $va_creators['displayname'], '', 'Detail', 'Entity', 'Show', array("entity_id" => $va_creators["entity_id"]))." <br/><span class='capsText'>".$va_creators['relationship_typename']."</span></div>";
			}
			print "</td><!-- end depicts -->";
		}else{
			$vn_showRelatedFiller = 1;
		}	
		# -- rights holder
		$va_rights = array();
		$va_rights = $t_object->get("ca_entities", array("returnAsArray" => 1, "restrictToRelationshipTypes" => array("rights_holder")));
		if(sizeof($va_rights) > 0){
			print "<td id='relatedRights' style='border-left:1px solid #fff; border-right:1px solid #fff;'><h2>"._t("Rights Holder")."</h2>";
			foreach($va_rights as $va_right){
				print "<div class='relatedItem'>".caNavLink($this->request, $va_right['displayname'], '', 'Detail', 'Entity', 'Show', array("entity_id" => $va_right['entity_id']))."</div>";
			}
			print "</td><!-- end depicts -->";
		}else{
			$vn_showRelatedFiller = 1;
		}					
		
		if($vn_showRelatedFiller){
			print "<td class='H2Filler'><div class='H2Filler'><!-- empty --></div></td>";
		}	
?>	
	
	</tr></table></div><!-- end relatedInfo -->
<?php
	}
?>	
	</div><!-- end detailBody -->
<?php
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	# -- metatags for facebook sharing
	MetaTagManager::addMeta('og:title', $vs_title);
	if($t_rep && $t_rep->getPrimaryKey() && $vs_media_url = $t_rep->getMediaUrl('media', 'thumbnail')){
		MetaTagManager::addMeta('og:image', $vs_media_url);
		MetaTagManager::addLink('image_src', $vs_media_url);
	}
	if($vs_description_text){
		MetaTagManager::addMeta('og:description', $vs_description_text);
	}
	
?>