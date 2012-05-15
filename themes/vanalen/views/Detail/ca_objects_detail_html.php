<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
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
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$t_rep = 							$this->getVar('t_primary_rep');
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	$va_access_values = 				$this->getVar('access_values');

	# --- need to get the competition and competition series and program info here
	# --- occurrences
	$va_occurrences_for_display = array();
	$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
	$va_sorted_occurrences = array();
	if(sizeof($va_occurrences) > 0){
		$t_occ = new ca_occurrences();
		foreach($va_occurrences as $va_occurrence) {
			$t_occ->load($va_occurrence['occurrence_id']);
			$va_occurrences_for_display[$t_occ->get("type_id")][] = array("occurrence_id" => $va_occurrence["occurrence_id"], "name" => $va_occurrence["name"], "heading" => $t_occ->getTypeName());
			
			$vn_parent_id = $t_occ->get("parent_id");
			# --- get parent occ
			if($t_occ->load($vn_parent_id)){
				$vn_grandparent_id = $t_occ->get("parent_id");
				$va_occurrences_for_display[$t_occ->get("type_id")][] = array("occurrence_id" => $vn_parent_id, "name" => $t_occ->getLabelForDisplay(), "heading" => $t_occ->getTypeName());
			}
			# --- get grandparent occ
			if($vn_grandparent_id && $t_occ->load($vn_grandparent_id)){
				$va_occurrences_for_display[$t_occ->get("type_id")][] = array("occurrence_id" => $vn_grandparent_id, "name" => $t_occ->getLabelForDisplay(), "heading" => $t_occ->getTypeName());
			}		
		}
	}
	# --- get the competition name
	$t_list = new ca_lists();
	$vn_comp_occ_type_id = $t_list->getItemIDFromList('occurrence_types', 'competitions');
	
	$va_competition_info = array();
	if($va_occurrences_for_display[$vn_comp_occ_type_id]){
		$va_competition_info = $va_occurrences_for_display[$vn_comp_occ_type_id];
	}

?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back to Search"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous Entry"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next Entry")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}
			}
?>
		</div><!-- end nav -->
		<div id="leftCol">
<?php
			if(sizeof($va_competition_info) > 0){
				print "<H1>";
				$i = 0;
				foreach($va_competition_info as $va_competition){
					print $va_competition["name"];
					$i++;
					if($i < sizeof($va_competition_info)){
						print "; ";
					}
				}
				print "</H1>";
			}
			if($t_object->get("ca_objects.creation_date")){
				print "<div class='unit'><b>"._t("Year").":</b> ".caNavLink($this->request, $t_object->get("ca_objects.creation_date"), '', '', 'Search', 'Index', array('search' => "ca_objects.creation_date:".$t_object->get("ca_objects.creation_date")))."</div>";
			}
			$va_display_creator = array();
			$va_creators = $t_object->get("ca_entities", array("restrict_to_relationship_types" => array("created"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			foreach($va_creators as $va_creator){
				$va_display_creator[] = caNavLink($this->request, $va_creator['label'], '', '', 'Search', 'Index', array('search' => "entity_id:".$va_creator['entity_id']));
			}
			if(sizeof($va_display_creator) > 0){
				print "<div class='unit'><b>".((sizeof($va_display_creator) > 1) ? _t("Creators") : _t("Creator")).":</b> ".join($va_display_creator, ", ")."</div>";
			}
			$va_display_creator_aff = array();
			$va_creator_affs = $t_object->get("ca_entities", array("restrict_to_relationship_types" => array("affiliation"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			foreach($va_creator_affs as $va_creator_aff){
				$va_display_creator_aff[] = caNavLink($this->request, $va_creator_aff['label'], '', '', 'Search', 'Index', array('search' => "entity_id:".$va_creator_aff['entity_id']));
			}
			if(sizeof($va_display_creator_aff) > 0){
				print "<div class='unit'><b>"._t("Creator affiliation").":</b> ".join($va_display_creator_aff, ", ")."</div>";
			}
			if($t_object->get("ca_objects.award")){
				print "<div class='unit'><b>"._t("Award").":</b> ".caNavLink($this->request, $t_object->get("ca_objects.award"), '', '', 'Search', 'Index', array('search' => "ca_objects.award:".$t_object->get("ca_objects.award")))."</div>";
			}
			#if($t_object->get('dimensions_2d')){
			#	print "<div class='unit'><b>"._t("Format").":</b> ".$t_object->get('dimensions_2d', array("template" => "^dimensions_2d_width X ^dimensions_2d_height"))."</div>";
			#}
			$vn_comp_series_occ_type_id = $t_list->getItemIDFromList('occurrence_types', 'competition_series');
			foreach($va_occurrences_for_display as $vn_occ_type_id => $va_occ_by_type){
				# --- do not show competition or series
				if(($vn_occ_type_id != $vn_comp_occ_type_id) && ($vn_occ_type_id != $vn_comp_series_occ_type_id)){					
					print "<div class='unit'>";
					$i = 0;
					$vs_heading = "";
					foreach($va_occ_by_type as $va_occ_info){					
						if($vs_heading != $va_occ_info["heading"]){
							$vs_heading = unicode_ucfirst($va_occ_info["heading"]);
							print "<b>".$vs_heading.":</b> ";
						}
						print caNavLink($this->request, $va_occ_info["name"], '', '', 'Search', 'Index', array('search' => '"'.$va_occ_info["name"].'"'));
						$i++;
						if($i < sizeof($va_occ_by_type)){
							print ", ";
						}
					}
					print "</div>";
				}
			}
			
			# --- places
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><b>"._t("Place").((sizeof($va_places) > 1) ? "s" : "").":</b> ";
				$i = 0;
				foreach($va_places as $va_place_info){
					print caNavLink($this->request, $va_place_info['label'], '', '', 'Search', 'Index', array('search' => "place_id:".$va_place_info['place_id']));
					$i++;
					if($i < sizeof($va_places)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><b>"._t("Keyword").((sizeof($va_terms) > 1) ? "s" : "").":</b> ";
				$i = 0;
				foreach($va_terms as $va_term_info){
					print caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => "term_id:".$va_term_info['item_id']));
					$i++;
					if($i < sizeof($va_terms)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(300, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}			
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h2>"._t("Related Objects")."</h2>";
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
			
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit" style="margin-top:100px;"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
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
				if(in_array("application/pdf", $va_display_options["mimetypes"])){
					print caNavLink($this->request, $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options')), '', 'Detail', 'Object', 'DownloadRepresentation', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()));
				}else{
					print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
				}
			}else{
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
			}
?>
			</div><!-- end objDetailImage -->
			<div id="objDetailImageNav">
				<div style="float:right;">
<?php
					if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("Add to Collection +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id), array('style' => 'margin-right:20px;'));
						}else{
							print caNavLink($this->request, _t("Add to Collection +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id), array('style' => 'margin-right:20px;'));
						}
					}
					if($va_display_options['no_overlay'] && in_array("application/pdf", $va_display_options["mimetypes"])){
						print caNavLink($this->request, _t("Download Program PDF &rsaquo;"), '', 'Detail', 'Object', 'DownloadRepresentation', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()));
					}else{
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >"._t("Zoom/more media")." +</a>";
					}
?>
				</div>			
			</div><!-- end objDetailImageNav -->
<?php
		}
if (!$this->request->config->get('dont_allow_registration_and_login')) {
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
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment">
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
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
