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
	
	$t_rel_types = 					$this->getVar('t_relationship_types');

?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}else{
				print "&lsaquo; "._t("Previous");
			}
			print "&nbsp;&nbsp;&nbsp;";
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), '');
			print "&nbsp;&nbsp;&nbsp;";
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
			}else{
				print _t("Next")." &rsaquo;";
			}
?>
		</div><!-- end nav -->
		<h1><?php print unicode_ucfirst($this->getVar('typename')).': '.$vs_title; ?></h1>
		<div id="leftCol">
<?php
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
			}
			# --- identifier
			if($this->getVar('idno')){
				print "<div class='unit'><b>"._t("Identifier").":</b> ".$this->getVar('idno')."</div><!-- end unit -->";
			}
			
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_val = $t_object->get($vs_attribute_code, array('delimiter' => '; ', 'convertCodesToDisplayText' => true))){
						$vs_label = $t_object->getAttributeLabel($vs_attribute_code);
						print "<div class='unit'><b>".$vs_label."</b> {$vs_val}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_objects_description_attribute')){
				if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_object->getAttributeLabel($this->request->config->get('ca_objects_description_attribute')).":</b> ".$vs_description_text."</div></div><!-- end unit -->";				
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#description').expander({
								slicePoint: 300,
								expandText: '<?php print _t('[more]'); ?>',
								userCollapse: false
							});
						});
					</script>
<?php
				}
			}

			# --- entities
			$va_entities = array();
			if(sizeof($this->getVar('entities'))){	
?>
				<div class="unit"><H2><?php print _t("Related")." ".((sizeof($this->getVar('entities') > 1)) ? _t("Entities") : _t("Entity")); ?></H2>
<?php
				$va_entity_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_entities');
				foreach($this->getVar('entities') as $va_entity) {
?>
					<div><?php print (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".unicode_ucfirst($va_entity_rel_types[$va_entity['relationship_type_id']]['typename']).")"; ?></div>
<?php					
				}
?>
				</div><!-- end unit -->
<?php
			}
			
			# --- occurrences
			$va_occurrences = array();
			if(sizeof($this->getVar('occurrences'))){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($this->getVar('occurrences') as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "date" => $t_occ->getAttributesForDisplay("dates", '^dates_value'), "relationship_type_id" => $va_occurrence['relationship_type_id']);
				}
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_occurrences');
				foreach($va_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><H2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></H2>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
?>
						<div><?php print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".unicode_ucfirst($va_occ_rel_types[$va_info['relationship_type_id']]['typename']).")"; ?></div>
<?php					
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- places
			if($this->getVar('places')){
				print "<div class='unit'><H2>"._t("Related Place").((sizeof($this->getVar('places')) > 1) ? "s" : "")."</H2>";
				$va_place_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_places');
				foreach($this->getVar('places') as $va_place_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".unicode_ucfirst($va_place_rel_types[$va_place_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- collections
			if($this->getVar('collections')){
				print "<div class='unit'><H2>"._t("Related Collection").((sizeof($this->getVar('collections')) > 1) ? "s" : "")."</H2>";
				$va_collection_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_collections');
				foreach($this->getVar('collections') as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_rel_types[$va_collection_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
		

			
			# --- vocabulary terms
			$va_terms = array();
			if(sizeof($this->getVar('terms'))){
				foreach($this->getVar('terms') as $va_term) {
					$va_terms[$va_term['item_id']] = $va_term['name_singular'];
				}
				
				if (sizeof($va_terms)) {
?>
					<div class="unit"><H2><?php print _t('Subjects'); ?></H2>
<?php				
					foreach($va_terms as $vn_item_id => $vs_term) {
?>
						<div><?php print caNavLink($this->request, $vs_term, '', '', 'Search', 'Index', array('search' => $vs_term)); ?></div>
<?php				
					}
?>
					</div><!-- end unit -->
<?php
				}
			}
			
			# --- hierarchy info
			if($this->getVar('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $this->getVar('parent_title'), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('parent_id')))."</div>";
			}
			if($this->getVar('num_children') > 0){
				print "<div class='unit'><b>"._t("Parts")."</b>: ".caNavLink($this->request, $this->getVar('num_children')." parts of this ".$this->getVar('object_type'), '', '', 'Search', 'Search', array('search' => "children:".$vn_object_id))."</div>";
			}
			
			
			# --- output related object images as links
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h2>"._t("Related Objects")."</h2>";
				print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 4;
				foreach($va_related_objects as $vn_rel_object_id => $va_info){
					if($col == 0){
						print "<tr>";
					}
					print "<td align='center' valign='middle' class='imageIcon icon".$vn_rel_object_id."'>";
					print caNavLink($this->request, $va_info['reps']['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id));
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_info['reps']['tags']['small']);
					$this->setVar('tooltip_title', $va_info['label']);
					$this->setVar('tooltip_idno', $va_info["idno"]);
					TooltipManager::add(
						".icon{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
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
			print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
?>
			</div><!-- end objDetailImage -->
			<div id="objDetailImageNav">
				<div style="float:right;">
<?php
					if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id), array('style' => 'margin-right:20px;'));
						}else{
							print caNavLink($this->request, _t("Add to Set +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets'), array('style' => 'margin-right:20px;'));
						}
					}
					
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >"._t("Zoom/more media")." +</a>";
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
				<h2><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;"></h2>
			
<?php
			}
			$va_comments = $this->getVar("comments");
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
				if($this->getVar("ranking")){
?>
					<div class="divide" style="margin:10px 0px 10px 0px;"><!-- empty --></div>
<?php
				}
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
				$vs_login_message = _t("Login/register to be the first to rank, tag and comment on this object!");
			}
		if($this->request->isLoggedIn()){
			if($this->getVar("ranking") || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin: 0px 0px 10px 0px;"><!-- empty --></div>
<?php
			}
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
