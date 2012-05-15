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
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');

?>	
	<div id="detailBody">
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
<?php
			# --- identifier
			if($t_object->get('ca_objects.image_id')){
				print "<div class='unit'><b>"._t("Image Id").":</b> ".$t_object->get('ca_objects.image_id')."</div><!-- end unit -->";
			}
			print "<h1>".$vs_title."</h1>";
			# --- description
			if($t_object->get('ca_objects.description')){
				print "<div class='unit'><div id='description'>".$t_object->get('ca_objects.description')."</div></div><!-- end unit -->";				
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
			# --- date
			if($t_object->get('ca_objects.object_date')){
				print "<div class='unit'><b>"._t("Date")."</b>: ".$t_object->get('ca_objects.object_date')."</div><!-- end unit -->";
			}
			$va_photographer = $t_object->get('ca_entities', array('restrict_to_relationship_types' => array('photographer'), 'checkAccess' => $va_access_values, 'returnAsArray' => 1));
			$va_entities_output = array();
			if(sizeof($va_photographer) > 0){
				print "<div class='unit'><b>"._t("Photographer").((sizeof($va_photographer) > 1) ? "s" : "")."</b>: ";
				$c = 0;
				foreach ($va_photographer as $photographer) {
					$va_entities_output[] = $photographer["entity_id"];
					print $photographer["label"];
					$c++;
					if($c < sizeof($va_photographer)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.archive_category')){
				print "<div class='unit'><b>"._t("Archive Category")."</b>: ".$t_object->get('ca_objects.archive_category')."</div><!-- end unit -->";
			}
			# --- Typename
			if($this->getVar('typename')){
				print "<div class='unit'><b>"._t("Format")."</b>: ".$this->getVar('typename')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.physical_location')){
				print "<div class='unit'><b>"._t("Object Location")."</b>: ".$t_object->get('ca_objects.physical_location')."</div><!-- end unit -->";
			}

			if($t_object->get('ca_objects.content_location')){
				print "<div class='unit'><b>"._t("Location shown")."</b>: ".$t_object->get('ca_objects.content_location')."</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				$va_display_terms = array();
				foreach($va_terms as $va_term_info){
					$va_display_terms[] = caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']));
				}
				if(sizeof($va_display_terms) > 0){
					print "<div class='unit'><b>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</b>: ";
					print implode(", ", $va_display_terms);
					print "</div><!-- end unit -->";
				}
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
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
				$va_entities_filtered = array();
				foreach($va_entities as $va_entity) {
					if(!in_array($va_entity["entity_id"], $va_entities_output)){
						$va_entities_filtered[] = "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</div>";
					}
				}
				if(sizeof($va_entities_filtered) > 0){
?>
				<div class="unit"><h2><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("Entities") : _t("Entity")); ?></h2>
<?php
					print implode("", $va_entities_filtered);
?>
				</div><!-- end unit -->
<?php
				
				}
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
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(300, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}
			# --- notes
			if($t_object->get('ca_objects.notes')){
				print "<div class='unit'><b>"._t("Notes")."</b><div id='notes'>".$t_object->get('ca_objects.notes')."</div></div><!-- end unit -->";				
?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#notes').expander({
							slicePoint: 300,
							expandText: '<?php print _t('[more]'); ?>',
							userCollapse: false
						});
					});
				</script>
<?php
			}
			# --- internal_notes
			if($t_object->get('ca_objects.internal_notes')){
				print "<div class='unit'><b>"._t("Internal Notes")."</b><div id='internal_notes'>".$t_object->get('ca_objects.internal_notes')."</div></div><!-- end unit -->";				
?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#internal_notes').expander({
							slicePoint: 300,
							expandText: '<?php print _t('[more]'); ?>',
							userCollapse: false
						});
					});
				</script>
<?php
			}
			print "Contact the <a href=\"mailto:photoarchives@noguchi.org\">archivist</a> to request a high res copy of this image<br/>";
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Add image to cart"), '', '', 'Sets', 'addItem', array('object_id' => $vn_object_id), array('style' => 'margin-right:5px;'));
					print "to request multiple high res images<br />";
				}else{	
					print caNavLink($this->request, _t("Add image to cart"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_object_id), array('style' => 'margin-right:5px;'));
					print "to request multiple high res images<br /><br />";
				}
			}
			
			if($t_object->get('ca_objects.idno')){
				print "<div class='unit' style='color:#999; line-height:1em; margin-bottom:3px;'><b>"._t("ID").":</b> ".$t_object->get('ca_objects.idno')."<br/>";
			} 
			if($t_object->get('ca_objects.scan_location')){
				print "<b>"._t("Scan location").":</b> ".$t_object->get('ca_objects.scan_location')."</div><!-- end unit -->";
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
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))." +</a>";
?>
				</div>			
			</div><!-- end objDetailImageNav -->
<?php
		}
?>
		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
