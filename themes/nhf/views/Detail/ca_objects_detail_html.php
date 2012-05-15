<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
	
	$va_reps = 						$this->getVar('reps');
	
	$t_rel_types = 					$this->getVar('t_relationship_types');
	
	$vs_default_image_version = 	$this->request->config->get('ca_objects_representation_default_image_display_version');
	
	$va_comments 		= $this->getVar("comments");
	$pn_numRankings 	= $this->getVar("numRankings");
	$va_access_values = 			$this->getVar('access_values');

?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), '');

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
?>
		</div><!-- end nav -->
		<div id="leftCol">
			<div id="title"><?php print $vs_title; ?></div>
			<div id="counts">
				<a href="#comments"><?php print sizeof($va_comments); ?> comment<?php print (sizeof($va_comments) == 1) ? "" : "s"; ?></a><br/> 
				<?php print $pn_numRankings." ".(($pn_numRankings == 1) ? "Person likes this" : "People like this"); ?> <span class="gray">&nbsp;|&nbsp;</span> <?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_like_this.gif' width='17' height='18' border='0' style='margin: 0px 5px -3px 0px;'>".caNavLink($this->request, 'I like this too', '', 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id, 'rank' => 5)); ?>
			</div><!-- end counts -->
<?php
			# --- identifier
			if($this->getVar('idno')){
				print "<div class='unit'><div class='infoButton' id='idno'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div><div class='heading'>"._t("object Identifier")."</div>";
				print "<div>".$this->getVar('idno')."</div>";
				print "</div><!-- end unit -->";
				TooltipManager::add(
					"#idno", "<div class='infoTooltip'>An identifier applied to an object when it arrives at the archives. </div>"
				);
			}
?>
			<div class="unit">
				<div class='infoButton' id='test'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div>
				<div class='heading'>Heading</div>
				<div>item list</div>
				<div>item list</div>
			</div><!-- end unit -->
<?php
			TooltipManager::add(
				"#test", "<div class='infoTooltip'>Field description test here</div>"
			);

			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
?>
				<div class="unit">
					<div class='infoButton' id='entities'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div>
					<div class='heading'><?php print _t("Related")." ".((sizeof($va_entities > 1)) ? _t("Entities") : _t("Entity")); ?></div>
<?php
				$va_entity_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_entities');
				foreach($va_entities as $va_entity) {
?>
					<div><?php print (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".unicode_ucfirst($va_entity_rel_types[$va_entity['relationship_type_id']]['typename']).")"; ?></div>
<?php					
				}
				TooltipManager::add(
					"#entities", "<div class='infoTooltip'>Entities description.</div>"
				);
?>
				</div><!-- end unit -->
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "relationship_type_id" => $va_occurrence['relationship_type_id']);
				}
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_occurrences');
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
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
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if($va_places){
				print "<div class='unit'>";
				print "<div class='infoButton' id='places'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div>";
				print "<div class='heading'>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</div>";
				$va_place_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_places');
				foreach($va_places as $va_place_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".unicode_ucfirst($va_place_rel_types[$va_place_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				TooltipManager::add(
					"#places", "<div class='infoTooltip'>Place desc.</div>"
				);
				print "</div><!-- end unit -->";
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if($va_collections){
				print "<div class='unit'>";
				print "<div class='infoButton' id='collectionList'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div>";
				print "<div class='heading'>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</div>";
				$va_collection_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_collections');
				foreach($va_collections as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_rel_types[$va_collection_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				TooltipManager::add(
					"#collectionList", "<div class='infoTooltip'>Collection desc.</div>"
				);
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = array();
			if(sizeof($va_terms_info)){
				foreach($va_terms_info as $va_term) {
					$va_terms[$va_term['item_id']] = $va_term['name_singular'];
				}
				
				if (sizeof($va_terms)) {
?>
					<div class="unit">
					<div class='infoButton' id='vocab'><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/nhf/b_info.gif' width='14' height='14' border='0' style='vertical-align:sub;'></div>
					<div class='heading'><?php print _t('Subjects'); ?></div>
<?php				
					foreach($va_terms as $vn_item_id => $vs_term) {
?>
						<div><?php print caNavLink($this->request, $vs_term, '', '', 'Search', 'Index', array('search' => $vs_term)); ?></div>
<?php				
					}
					TooltipManager::add(
						"#vocab", "<div class='infoTooltip'>Vocab terms desc.</div>"
					);
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
				print "<div class='unit'><div class='heading'>"._t("Related Objects")."</div>";
				print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 4;
				foreach($va_related_objects as $vn_rel_object_id => $va_info){
					if($col == 0){
						print "<tr>";
					}
					print "<td align='center' valign='middle' class='imageIcon icon".$vn_rel_object_id."'>";
					if($this->request->config->get('allow_detail_for_ca_objects')){
						print caNavLink($this->request, $va_info['reps']['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id));
					}else{
						print $va_info['reps']['tags']['icon'];
					}
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
					<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment">
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
		</div><!-- end leftCol-->
		<div id="rightCol">
<?php
	print $this->render('../pageFormat/right_col_html.php');
?>
	</div><!-- end rightCol -->
	</div><!-- end detailBody -->