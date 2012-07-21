<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	
	$t_list = new ca_lists();
 	$vn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 	$vn_organization_id = $t_list->getItemIDFromList('entity_types', 'org');
 	$vn_individual_id = $t_list->getItemIDFromList('entity_types', 'ind');
 	$vn_family_id = $t_list->getItemIDFromList('entity_types', 'fam');

if (!$this->request->isAjax()) {		
?>
	<div style="width: 100%; clear:both; height:15px;"></div>
	<div id="detailBody" style="clear:both;">
	<h1 style="float:left;"><?php print unicode_ucfirst($this->getVar('typename')).': '.$vs_title; ?></h1>
		<div id="pageNav">
		
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<div style="width: 100%; clear:both; height:10px;"></div>
		
		<div id="leftCol" class="entity">		
<?php
			if((!$this->request->config->get('dont_allow_registration_and_login')) && $this->request->config->get('enable_bookmarks')){
?>
				<!-- bookmark link BEGIN -->
				<div class="unit">
<?php
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}else{
					print caNavLink($this->request, _t("Bookmark item +"), 'button', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}
?>
				</div><!-- end unit -->
				<!-- bookmark link END -->
<?php
			}
			# --- identifier
			if($t_entity->get('idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b>: ".$t_entity->get('idno')."</div><!-- end unit -->";
			}
			# --- description
			if($this->request->config->get('ca_entities_description_attribute')){
				if($vs_description_text = $t_entity->get("ca_entities.".$this->request->config->get('ca_entities_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_entity->getDisplayLabel('ca_entities.'.$this->request->config->get('ca_entities_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
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
			switch($t_entity->get("type_id")){
				case $vn_member_institution_id:
					if($t_entity->get("ca_entities.mem_inst_image")){
						print "<div class='unit'>".$t_entity->get("ca_entities.mem_inst_image", array("version" => "small", "return" => "tag"))."</div>";
					}
					if($t_entity->get("ca_entities.address")){
						print "<div class='unit'><b>"._t("Address").":</b><br/>";
						if($t_entity->get("ca_entities.address.address1")){
							print $t_entity->get("ca_entities.address.address1")."<br/>";
						}
						if($t_entity->get("ca_entities.address.address2")){
							print $t_entity->get("ca_entities.address.address2")."<br/>";
						}
						$va_address_line3 = array();
						if($t_entity->get("ca_entities.address.city")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.city");
						}
						if($t_entity->get("ca_entities.address.county")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.county");
						}
						if($t_entity->get("ca_entities.address.stateprovince")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.stateprovince");
						}
						if($t_entity->get("ca_entities.address.postalcode")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.postalcode");
						}
						if($t_entity->get("ca_entities.address.country")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.country");
						}
						if(sizeof($va_address_line3) > 0){
							print join(", ", $va_address_line3);
						}
						print "</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.external_link.url_entry")){
						print "<div class='unit'><b>"._t("Link").":</b> <a href='".$t_entity->get("ca_entities.external_link.url_entry")."'>".$t_entity->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
					}
					
				break;
				# --------------------------
				case $vn_organization_id:
					if($t_entity->get("ca_entities.business_type")){
						print "<div class='unit'><b>"._t("Business Type").":</b> ".$t_entity->get("ca_entities.business_type")."</div>";
					}
					if($t_entity->get("ca_entities.entity_founded")){
						print "<div class='unit'><b>"._t("Date Founded").":</b> ".$t_entity->get("ca_entities.entity_founded")."</div>";
					}
					if($t_entity->get("ca_entities.entity_incorporated")){
						print "<div class='unit'><b>"._t("Date Incorporated").":</b> ".$t_entity->get("ca_entities.entity_incorporated")."</div>";
					}
					if($t_entity->get("ca_entities.entity_liquidated")){
						print "<div class='unit'><b>"._t("Date Liquidated").":</b> ".$t_entity->get("ca_entities.entity_liquidated")."</div>";
					}
					if($t_entity->get("ca_entities.entity_brands")){
						$va_brands = array();
						foreach($t_entity->get("ca_entities.entity_brands", array("returnAsArray" => 1)) as $i => $va_brand_info){
							$va_brands[] = $va_brand_info["entity_brands"];
						}
						print "<div class='unit'><b>"._t("Brand(s)").":</b> ".join(", ", $va_brands)."</div>";
					}
					if($t_entity->get("ca_entities.products")){
						print "<div class='unit'><b>"._t("Product(s)").":</b> ".$t_entity->get("ca_entities.products")."</div>";
					}
					if($t_entity->get("ca_entities.add_info")){
						print "<div class='unit'><b>"._t("Additional Info").":</b> ".$t_entity->get("ca_entities.add_info")."</div>";
					}
					if($t_entity->get("ca_entities.remarks")){
						print "<div class='unit'><b>"._t("Remarks").":</b> ".$t_entity->get("ca_entities.remarks")."</div>";
					}
					if($t_entity->get("ca_entities.remarks_source")){
						print "<div class='unit'><b>"._t("Remarks Source").":</b> ".$t_entity->get("ca_entities.remarks_source")."</div>";
					}
					if($t_entity->get("ca_entities.address")){
						print "<div class='unit'><b>"._t("Address").":</b><br/>";
						if($t_entity->get("ca_entities.address.address1")){
							print $t_entity->get("ca_entities.address.address1")."<br/>";
						}
						if($t_entity->get("ca_entities.address.address2")){
							print $t_entity->get("ca_entities.address.address2")."<br/>";
						}
						$va_address_line3 = array();
						if($t_entity->get("ca_entities.address.city")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.city");
						}
						if($t_entity->get("ca_entities.address.county")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.county");
						}
						if($t_entity->get("ca_entities.address.stateprovince")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.stateprovince");
						}
						if($t_entity->get("ca_entities.address.postalcode")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.postalcode");
						}
						if($t_entity->get("ca_entities.address.country")){
							$va_address_line3[] = $t_entity->get("ca_entities.address.country");
						}
						if(sizeof($va_address_line3) > 0){
							print join(", ", $va_address_line3);
						}
						print "</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.external_link.url_entry")){
						print "<div class='unit'><b>"._t("Link").":</b> <a href='".$t_entity->get("ca_entities.external_link.url_entry")."'>".$t_entity->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
					}
				break;
				# --------------------------
				# --- individuals and families
				default:
					if($t_entity->get("ca_entities.lifespan")){
						print "<div class='unit'><b>"._t("Lifetime").":</b> ".$t_entity->get("ca_entities.lifespan")."</div><!-- end unit -->";
					}
					if($t_entity->get("ca_entities.nationality")){
						print "<div class='unit'><b>"._t("Nationality").":</b> ".$t_entity->get("ca_entities.nationality")."</div><!-- end unit -->";
					}
					
				break;
				# --------------------------
			}
			
			# --- entities
			$va_entities = $t_entity->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
			$va_occurrences = $t_entity->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
			$va_places = $t_entity->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
				foreach($va_places as $va_place_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- collections
			$va_collections = $t_entity->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
				foreach($va_collections as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_entity->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><h2>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h2>";
				foreach($va_terms as $va_term_info){
					print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
				}
				print "</div><!-- end unit -->";
			}
			print "<div class='unit'>";
			if($this->request->config->get('ca_entities_map_attribute') && $t_entity->get($this->request->config->get('ca_entities_map_attribute'))){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_entity, $this->request->config->get('ca_entities_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}
			print "</div>";
?>
		<div id="objUserData" class="entity">
			<!-- AddThis Button BEGIN -->
			<div class='unit'>
				<div class="addthis_toolbox addthis_default_style" style="width:300px;">
					<a class="addthis_button_facebook_like" style="width:85px;" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet" style="width:85px;"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium" style="width:70px;"></a>
					<a class="addthis_button_compact addthis_pill_style" style="width:20px;"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fb28b34285e728d"></script>
			</div>
			<!-- AddThis Button END -->	
<?php

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
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<h2><?php print _t("Add Your Comments"); ?></h2>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Entity', 'saveCommentRanking', array('entity_id' => $vn_entity_id)); ?>" name="comment" enctype='multipart/form-data'>

				<div class="formLabel"><?php print _t("Media"); ?></div>
				<input type="file" name="media1">
				<div class="formLabel"><?php print _t("Comment"); ?></div>
				<textarea name="comment" rows="5"></textarea>
				<br><a href="#" name="commentSubmit" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
			</form>
<?php
		}else{
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'EntityDetail', 'entity_id' => $vn_entity_id))."</p>";
			}
		}
?>	
<div style="height:20px; clear:both; width: 100%;"></div>

	</div><!-- end objUserData-->	
	</div><!-- end leftCol -->
	<div id="rightCol" class="entity">
		<div id="resultBox">
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	print $this->render('related_objects_grid.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
	
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>