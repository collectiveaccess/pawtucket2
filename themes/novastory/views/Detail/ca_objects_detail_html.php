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
	
	# --- get similar items by category
	$va_categories = explode(",", $t_object->get('ns_category'));
	$va_sim_items = array();
	if(sizeof($va_categories)){
		$vn_category = trim($va_categories[0]);
		require_once(__CA_LIB_DIR__.'/ca/Browse/ObjectBrowse.php');
		$o_browse = new ObjectBrowse();
		$o_browse->removeAllCriteria();
		$o_browse->addCriteria("category_facet", $vn_category);
		$o_browse->addCriteria("has_media_facet", 1);
		$o_browse->execute(array('checkAccess' => $va_access_values));
		$qr_sim_items = $o_browse->getResults();
		if($qr_sim_items->numHits()){
			# --- grab the first 100 items and shuffle array to randomize a bit
			$i = 0;
			while($qr_sim_items->nextHit() && $i < 100){
				$va_labels = array();
				$va_labels = $qr_sim_items->getDisplayLabels($this->request);
				$vs_label = join("; ", $va_labels);
				$va_media_info = array();
				$va_media_info = $qr_sim_items->getMediaInfo('ca_object_representations.media', 'icon', null, array('checkAccess' => $va_access_values));
				$vn_padding_top_bottom =  ((120 - $va_media_info["HEIGHT"]) / 2);
				$va_sim_items[] = array("object_id" => $qr_sim_items->get("ca_objects.object_id"), "label" => $vs_label, "media" => $qr_sim_items->getMediaTag('ca_object_representations.media', 'icon', array('checkAccess' => $va_access_values)), "idno" => $qr_sim_items->get("ca_objects.idno"), "padding" => $vn_padding_top_bottom);	
				$i++;
			}
			# -- shuffle array
			shuffle($va_sim_items);
			# --- grab first 3 values in array
			$va_sim_items = array_slice($va_sim_items, 0, 3);
		}
	}

?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<div id="titleBar"><h1><?php print $vs_title; ?></h1></div>
		<div id="leftCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="objDetailImage">
<?php
			if($va_display_options['no_overlay']){
				print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
			}else{
				$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'objDetailImageContainer');
				print "<div id='objDetailImageContainer'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</a></div>";
			}
?>
			</div><!-- end objDetailImage -->
			<div id="objDetailImageNav">
				<div style="float:right;">
					<!-- bookmark link BEGIN -->
<?php
					if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){

						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("+ Bookmark item"), '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
						}else{
							print caNavLink($this->request, _t("+ Bookmark item"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
						}
					}
?>					
					<!-- bookmark link END -->
<?php
					if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections'))) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, _t("+ Add to Lightbox"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
						}else{
							print caNavLink($this->request, _t("+ Add to Lightbox"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
						}
					}

					# --- output download link? 
					if(caObjectsDisplayDownloadLink($this->request)){
						print caNavLink($this->request, _t("+ Download Media"), '', 'Detail', 'Object', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $vn_object_id, "download" => 1));
					}

					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >+ ".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))."</a>";
?>
				</div>			
			</div><!-- end objDetailImageNav -->
<?php
		}

			print "<div class='unit'><span style='margin-right:10px;'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/thumb.jpeg' border='0'> Like This!", '', 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id, 'rank' => 5))."</span>";
			if($this->getVar("ranking")){
				$vn_numRankings = $this->getVar("numRankings");
				print _t("%1 %2 liked this object", $vn_numRankings, ($vn_numRankings == 1) ? "person" : "people");
			}
			print "</div>";
			
?>
			<!-- AddThis Button BEGIN -->
			<div class='unit'>
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fb28b34285e728d"></script>
			</div>
			<!-- AddThis Button END -->
<?php
if (!$this->request->config->get('dont_allow_registration_and_login')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData">		
<?php
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
					$vs_login_message = _t("Login/register to be the first to comment on this object!");
				}
			}
			if((is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<h2 style="margin-top:10px; margin-bottom:10px;"><?php print _t("Add Your Comments"); ?></h2>

			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment" enctype='multipart/form-data'>
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
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
			}
		}
?>	
<div style="height:20px; clear:both; width: 100%;"></div>

		</div><!-- end objUserData-->
<?php
	}
?>
		</div><!-- end leftCol -->
		<div id="rightCol">
			
			<div class="subCol">
<?php

				# --- type
				if($this->getVar('typename')){
					print "<div class='unit'><b>"._t("Type").":</b> ".$this->getVar('typename')."</div><!-- end unit -->";
				}
				# --- identifier
				if($t_object->get('idno')){
					print "<div class='unit'><b>"._t("Identifier").":</b> ".$t_object->get('idno')."</div><!-- end unit -->";
				}
				# --- source
				if($t_object->get('source_id')){
					print "<div class='unit'><b>"._t("Source").":</b> ".$t_object->get('source_id', array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
				}
				# --- category
				if($t_object->get('ns_category')){
					print "<div class='unit'><b>"._t("Category").":</b> ".$t_object->get('ns_category', array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
				}
				# --- novastory_category
				if($t_object->get('novastory_category')){
					print "<div class='unit'><b>"._t("NS - Category").":</b> ".$t_object->get('novastory_category', array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
				}
				# --- parent hierarchy info
				if($t_object->get('parent_id')){
					print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
				}
				# --- attributes
				$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
				if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
					foreach($va_attributes as $vs_attribute_code){
						if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array('convertCodesToDisplayText' => true))){
							print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
						}
					}
				}				
				# --- description
				if($this->request->config->get('ca_objects_description_attribute')){
					if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
						print "<div class='unit'><div id='description'><b>".$t_object->getDisplayLabel("ca_objects.".$this->request->config->get('ca_objects_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
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
?>
			</div>
			<div class="subCol">
<?php

				
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
						if(($i >= 5) && ($i == sizeof($va_children))){
							print "</div><!-- end moreChildren -->";
						}
					}
					print "</div><!-- end unit -->";
				}
				# --- entities
				$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
				if(sizeof($va_entities) > 0){	
	?>
					<div class="unit"><h2><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("Entities") : _t("Entity")); ?></h2>
	<?php
					foreach($va_entities as $va_entity) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";
					}
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
						$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
					}
					
					foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
	?>
							<div class="unit"><h2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h2>
	<?php
						foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
							print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
						}
						print "</div><!-- end unit -->";
					}
				}
				# --- places
				$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				
				if(sizeof($va_places) > 0){
					print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
					foreach($va_places as $va_place_info){
						print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
				# --- collections
				$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				if(sizeof($va_collections) > 0){
					print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
					foreach($va_collections as $va_collection_info){
						print "<div>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
				# --- lots
				$va_object_lots = $t_object->get("ca_object_lots", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				if(sizeof($va_object_lots) > 0){
					print "<div class='unit'><h2>"._t("Related Lot").((sizeof($va_object_lots) > 1) ? "s" : "")."</h2>";
					foreach($va_object_lots as $va_object_lot_info){
						print "<div>".(($this->request->config->get('allow_detail_for_ca_object_lots')) ? caNavLink($this->request, $va_object_lot_info['label'], '', 'Detail', 'ObjectLots', 'Show', array('lot_id' => $va_object_lot_info['lot_id'])) : $va_object_lot_info['label'])." (".$va_object_lot_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
				# --- vocabulary terms
				$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				if(sizeof($va_terms) > 0){
					print "<div class='unit'><h2>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h2>";
					foreach($va_terms as $va_term_info){
						print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
					}
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
?>
			</div><!-- end subCol -->

			<div id="similarItems">
<?php
				if(sizeof($va_sim_items)){
					print "<H2>"._t("Similar Items")."</H2>";
					foreach($va_sim_items as $va_similar_item){
						print "<div class='similarItem'>".caNavLink($this->request, $va_similar_item["media"], "", "Detail", "Object", "Show", array("object_id" => $va_similar_item["object_id"]))."</div>";
					}
				}
?>
			</div><!-- end similarItems -->
		</div><!-- end rightCol-->
	</div><!-- end detailBody -->
<?php
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	
?>
