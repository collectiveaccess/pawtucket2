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
	$t_object = 					$this->getVar('t_item');
	$vn_object_id = 				$t_object->get('object_id');
	$vs_title = 					$this->getVar('label');
	$va_related_objects = 			$this->getVar('related_objects');
	
	$t_rep = 						$this->getVar('t_primary_rep');
	$vs_display_version =			$this->getVar('primary_rep_display_version');
	$va_display_options	 			= $this->getVar('primary_rep_display_options');
	
	$va_access_values	= $this->getVar('access_values');

?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			if(($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), ''))){
				print $vs_back_link;
				if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
					print "&nbsp;&nbsp;&nbsp;";
				}
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}
				if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
					print "&nbsp;&nbsp;|&nbsp;&nbsp;";
				}
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}
			}
?>
		</div><!-- end nav -->
<?php
		$va_artist = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('creator')));
		$vs_artist = "";
		$va_artist_links = array();
		$va_relation_ids = array();
		foreach($va_artist as $i => $va_entity){
			$va_relation_ids[] = $va_entity["relation_id"];
			$va_artist_links[] = (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"]);
		}
		$vs_artist = implode(", ", $va_artist_links);

		print "<div id='objArtist'>".$vs_artist.(($vs_artist && $t_object->get('ca_objects.origin')) ? ", " : "").(($t_object->get('ca_objects.origin')) ? $t_object->get('ca_objects.origin') : "")."</div><!-- end objTitle -->";

		print "<div id='objTitle'>".$vs_title."</div><!-- end objTitle -->";
?>
		<div id="leftCol">		
<?php
			if($t_object->get('ca_objects.object_type')){
				print "<div class='unit'><b>"._t("Object type")."</b>: ".$t_object->get('ca_objects.object_type')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.materials')){
				print "<div class='unit'><b>"._t("Materials")."</b>: ".$t_object->get('ca_objects.materials', array("delimiter" => ", "))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.medium')){
				print "<div class='unit'><b>"._t("Medium")."</b>: ".$t_object->get('ca_objects.medium', array("delimiter" => ", "))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.technique')){
				print "<div class='unit'><b>"._t("Technique")."</b>: ".$t_object->get('ca_objects.technique')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.creation_date')){
				print "<div class='unit'><b>"._t("Date of creation")."</b>: ".$t_object->get('ca_objects.creation_date')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.copyright_date')){
				print "<div class='unit'><b>"._t("Copyright")."</b>: ".$t_object->get('ca_objects.copyright_date')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.period')){
				print "<div class='unit'><b>"._t("Period")."</b>: ".$t_object->get('ca_objects.period')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.dimensions_text')){
				print "<div class='unit'><b>"._t("Dimensions")."</b>: ".$t_object->get('ca_objects.dimensions_text')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.credit_line')){
				print "<div class='unit'><b>"._t("Credit")."</b>: ".$t_object->get('ca_objects.credit_line')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.rights_restrictions')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("rights_restrictions").":</b> ".$t_object->get('ca_objects.rights_restrictions', array('convertLineBreaks' => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b>: ".$t_object->get('ca_objects.idno')."</div><!-- end unit -->";
			}
			if($vs_link = $t_object->get("ca_objects.external_link", array("delimiter" => ", ", "template" => "<a href='^url_entry'>^url_source</a>"))){
				print "<div class='unit'><b>"._t("Link")."</b>: ".$vs_link."</div><!-- end unit -->";
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if($va_collections){
				print "<div class='unit'><b>"._t("Collection").((sizeof($va_collections) > 1) ? "s" : "")."</b>: ";
				$i = 0;
				foreach($va_collections as $va_collection_info){
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
					$i++;
					if($i < sizeof($va_collections)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}

			$t_list = new ca_lists();
			$vn_yes_id = $t_list->getItemIdFromList('yes_no', 'yes'); /* list_id, item code */
			if($t_object->get('ca_objects.on_exhibition') == $vn_yes_id){
				print "<div class='unit'><b>"._t("On exhibition")."</b></div><!-- end unit -->";
			}else{
				print "<div class='unit'><b>"._t("Currently not on exhibition")."</b> ".$t_object->get('ca_objects.on_view')."</div><!-- end unit -->";
			}
			
			# --- entities
			$va_all_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_entities = array();
			if(sizeof($va_all_entities)){	

				foreach($va_all_entities as $va_entity) {
					if(!in_array($va_entity["relation_id"], $va_relation_ids)){

						$va_entities[] = "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";
					
					}
				}
				if(sizeof($va_entities) > 0){
?>
				<div class="unit"><h2><?php print _t("Related"); ?></h2>
<?php
					print implode($va_entities, "<br/>");
?>
				</div><!-- end unit -->
<?php
				}

			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences)){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><H2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></H2>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
?>
						<div><?php print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")"; ?></div>
<?php					
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- places
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><H2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</H2>";
				foreach($va_places as $va_place_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><H2>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</H2>";
				foreach($va_terms as $va_term_info){
					print "<div>";
					print caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']));
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
			
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h2>"._t("Related Objects")."</h2>";
				print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 2;
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
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
			}
?>
			</div><!-- end objDetailImage -->
			<div id="objDetailImageNav">
				<div style="float:right;">
<?php
					if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id), array('style' => 'margin-right:20px;'));
						}else{
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id), array('style' => 'margin-right:20px;'));
						}
					}
					
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >"._t("Zoom")." +</a>";
?>
				</div>			
			</div><!-- end objDetailImageNav -->
<?php
		}else{
			# --- place holder image
?>
			<div>
				<?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/umfa_graphics/place_holder_image.gif' width='580' height='450' style='border:2px solid #ababab;'>"; ?>
			</div>
			<div id="objDetailImageNavNoImage">
<?php
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, _t("ADD TO SET +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
					}else{
						print caNavLink($this->request, _t("ADD TO SET +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets'));
					}
?>
			</div>
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
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail'))."</p>";
			}
		}
?>		
		</div><!-- end objUserData-->
<?php
	}
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
