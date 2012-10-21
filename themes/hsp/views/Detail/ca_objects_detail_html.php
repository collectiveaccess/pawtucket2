<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/hsp/views/Detail/ca_objects_detail_html.php : 
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
	$va_access_values = 			$this->getVar('access_values');	
	$t_rep = 						$this->getVar('t_primary_rep');
	$vn_num_reps = 					$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =			$this->getVar('primary_rep_display_version');
	$va_display_options =			$this->getVar('primary_rep_display_options');
	
	$o_plugin = new ApplicationPluginManager();
?>	
	<div id="detailBody">
<?php
		if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
?>
		<div id="pageNav">
<?php
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}else{
				print "&lsaquo; "._t("Previous");
			}
			print "&nbsp;&nbsp;&nbsp;".$vs_back_link."&nbsp;&nbsp;&nbsp;";
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
			}else{
				print _t("Next")." &rsaquo;";
			}
?>
		</div><!-- end nav -->
<?php
		}
?>
		<h1><?php print unicode_ucfirst($this->getVar('typename')).': '.$vs_title; ?></h1>
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="rightCol">
				<div id="addToLightbox">
<?php
					if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections'))) {
						if($this->request->isLoggedIn()){
							print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/hsp/addToCart.png'> "._t("Purchase Image"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id));
						}else{
							print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/hsp/addToCart.png'> "._t("Purchase Image"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id));
						}
					}			
?>
				</div>
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
				<div id="objDetailImageNav">
<?php				
						print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))." +</a>";

?>			
				</div><!-- end objDetailImageNav -->
			</div><!-- end rightCol -->
<?php
		}
?>
		<div id="leftCol">
<?php
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
			}
			if($t_object->get('ca_objects.ca_old_db_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("ca_old_db_number").":</b> ".$t_object->get('ca_objects.ca_old_db_number')."</div><!-- end unit -->";
			}
			if($t_object->get('idno')){
				print "<div class='unit'><b>"._t("Record Number").":</b> ".$t_object->get('idno')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.call_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("call_number").":</b> ".$t_object->get('ca_objects.call_number')."</div><!-- end unit -->";
			}
			$va_collections = array();
			$va_collections_ids = array();
			$va_collections = $t_object->get('ca_collections', array('restrict_to_relationship_types' => array('is_part_of'), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(is_array($va_collections) && sizeof($va_collections) > 0){
				$va_collection_links = array();
				foreach($va_collections as $vn_i => $va_collection_info){
					$va_collection_links[] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." [".$va_collection_info['idno']."]";
					$va_collections_ids[] = $va_collection_info['collection_id'];
				}
				print "<div class='unit'><b>"._t("Collection").":</b> ".implode($va_collection_links, ", ")."</div><!-- end unit -->";
			}
			
			if($t_object->get('ca_objects.box_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("box_number").":</b> ".$t_object->get('ca_objects.box_number')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.folder_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("folder_number").":</b> ".$t_object->get('ca_objects.folder_number')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.volume_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("volume_number").":</b> ".$t_object->get('ca_objects.volume_number')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.page_number')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("page_number").":</b> ".$t_object->get('ca_objects.page_number')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.reproduction_restrictions')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("reproduction_restrictions").":</b> ".$t_object->get('ca_objects.reproduction_restrictions')."</div><!-- end unit -->";
			}
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
				$va_entities_by_type = array();
				foreach($va_entities as $va_entity) {
					$va_entities_by_type[$va_entity['relationship_typename']][] = (($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"]);
				}
				ksort($va_entities_by_type);
				foreach($va_entities_by_type as $vs_type => $va_ent_links){
					print "<div class='unit'><b>".unicode_ucfirst($vs_type).": </b>".join($va_ent_links, ", ")."</div><!-- end unit -->";
				}
			}
			if($t_object->get('ca_objects.address.address1') || $t_object->get('ca_objects.address.address2') || $t_object->get('ca_objects.address.city') || $t_object->get('ca_objects.address.stateprovince') || $t_object->get('ca_objects.address.postalcode') || $t_object->get('ca_objects.address.country')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("address").":</b> ";
				if($t_object->get('ca_objects.address.address1')){
					print $t_object->get('ca_objects.address.address1')."<br/>";
				}
				if($t_object->get('ca_objects.address.address2')){
					print $t_object->get('ca_objects.address.address2')."<br/>";
				}
				if($t_object->get('ca_objects.address.city')){
					print $t_object->get('ca_objects.address.city').", ";
				}
				if($t_object->get('ca_objects.address.stateprovince')){
					print $t_object->get('ca_objects.address.stateprovince')." ";
				}
				if($t_object->get('ca_objects.address.postalcode')){
					print $t_object->get('ca_objects.address.postalcode').", ";
				}
				if($t_object->get('ca_objects.address.country')){
					print $t_object->get('ca_objects.address.country');
				}
				print "</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.date_view')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("date_view").":</b> ".$t_object->get('ca_objects.date_view')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.date_item')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("date_item").":</b> ".$t_object->get('ca_objects.date_item')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.view_format')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("view_format").":</b> ".$t_object->get('ca_objects.view_format', array('convertCodesToDisplayText' => true, 'showHierarchy' => true, 'direction' => 'ASC', 'hierarchicalDelimiter' => ' &rsaquo; '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.item_format')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("item_format").":</b> ".$t_object->get('ca_objects.item_format', array('convertCodesToDisplayText' => true, 'showHierarchy' => true, 'direction' => 'ASC', 'hierarchicalDelimiter' => ' &rsaquo; '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.dimensions.dimensions_height') || $t_object->get('ca_objects.dimensions.dimensions_width') || $t_object->get('ca_objects.dimensions.dimensions_depth')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("dimensions").":</b> ";
				$va_dimensions = $t_object->get('ca_objects.dimensions', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				foreach($va_dimensions as $va_dimension_info){
					if($va_dimension_info["dimensions_phys"]){
						print "Dimensions of ".$va_dimension_info["dimensions_phys"].", ";
					}
					print $va_dimension_info["dimensions_width"]." by ".$va_dimension_info["dimensions_height"];
					
					if($va_dimension_info["dimensions_depth"]){
						print " by ".$va_dimension_info["dimensions_depth"];
					}
					print " ".$va_dimension_info["dimensions_unit"]."<br/>";
				}
				print "</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.map_scale')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("map_scale").":</b> ".$t_object->get('ca_objects.map_scale', array('template' => '^mapScale_line1 miles/kilometers : ^mapScale_line2 inches/centimeters'))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.inscription.inscription_text')){
				$va_inscriptions = $t_object->get('ca_objects.inscription', array('returnAsArray' => 1, array('convertLineBreaks' => true)));
				foreach($va_inscriptions as $va_inscription_info){
					print "<div class='unit'><b>".$t_object->getAttributeLabel("inscription_text").":</b> ".$va_inscription_info["inscription_text"];
					if($va_inscription_info["inscription_location"]){
						print "<br/><b>".$t_object->getAttributeLabel("inscription_location").":</b> ".$va_inscription_info["inscription_location"];
					}
					print "</div><!-- end unit -->";		
				}
			}
			if($t_object->get('ca_objects.image_description')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("image_description").":</b> ".$t_object->get('ca_objects.image_description', array('convertLineBreaks' => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.subject')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel("subject").":</b> ".$t_object->get('ca_objects.subject')."</div><!-- end unit -->";
			}

			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
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
				$va_collections_to_display = array();
				foreach($va_collections as $va_collection_info){
					if(!in_array($va_collection_info['collection_id'], $va_collections_ids)){
						$va_collections_to_display[] = (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")";
					}
				}
				if(sizeof($va_collections_to_display) > 0){
					print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
					foreach($va_collections_to_display as $vs_collection){
						print "<div>".$vs_collection."</div>";
					}
					print "</div><!-- end unit -->";
				}
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
				$o_map = new GeographicMap(300, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}			
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit' style='border-bottom:1px solid #ccc; width:300px;'><h2>"._t("Related Objects")."</h2>";
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					print "<table border='0' cellpadding='0' cellspacing='0' id='objDetailRelObjects' style='width:300px;'><tr>";
					if($va_reps['tags']['icon']){
						print "<td class='imageIcon icon".$va_info["object_id"]."'>";
						print caNavLink($this->request, $va_reps['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
						
						// set view vars for tooltip
						$this->setVar('tooltip_representation', $va_reps['tags']['small']);
						$this->setVar('tooltip_title', $va_info['label']);
						$this->setVar('tooltip_idno', $va_info["idno"]);
						TooltipManager::add(
							".icon".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
						);
						
						print "</td>";
					}
					print "<td valign='middle' align='left' style='padding-bottom:5px; padding-top:5px;'>".caNavLink($this->request, $va_info['label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
					print "</td></tr></table>";
				}
				print "</div><!-- end unit -->";
			}
?>
		</div><!-- end leftCol-->
	</div><!-- end detailBody -->
