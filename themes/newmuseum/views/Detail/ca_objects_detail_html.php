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
	$t_object = 			$this->getVar('t_item');
	$vn_object_id = 		$t_object->get('object_id');
	$vs_title = 			$this->getVar('label');
	$va_related = 			$this->getVar('related_objects');
	$va_see_also = 			$this->getVar('suggested_objects');
	
	$t_rep = 				$this->getVar('t_primary_rep');
	$vs_display_version =	$this->getVar('primary_rep_display_version');
	$va_display_options	= 	$this->getVar('primary_rep_display_options');
	
	$t_rel_types = 			$this->getVar('t_relationship_types');
	$t_list = new ca_lists();
	
?>	
	<div id="detailBody">
		<!--<div id="back">-->
<?php
		#print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("&lt; Back To Results"), '');
?>
		<!--</div>-->
		<div id="leftCol">
			<div id="detailTitleLabel"><?php print $this->getVar('typename'); ?>:</div>
			<div id="detailTitle"><?php print $vs_title; ?></div>
<?php
			# --- date of creation
			if($vs_date = $t_object->get('ca_objects.creation_date')){
				print "<div class='detailTextHeader'>"._t("Date")."</div><div class='detailText'>{$vs_date}</div>";
			}
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
				$va_entities_by_type = array();
				foreach($va_entities as $va_entity) {
					$va_entities_by_type[$va_entity['relationship_typename']][$va_entity['entity_id']] = $va_entity['label'];
				}
				
				foreach($va_entities_by_type as $vs_entity_rel_type => $va_entity_list) {
?>
					<div class="detailTextHeader"><?php print unicode_ucfirst($vs_entity_rel_type).((sizeof($va_entity_list) > 1) ? "s" : ""); ?></div>
<?php
					foreach($va_entity_list as $vn_entity_id => $vs_entity) {
?>
						<div class="detailText"><?php print caNavLink($this->request, $vs_entity, '', 'Detail', 'Entity', 'Show', array('entity_id' => $vn_entity_id)); ?></div>
<?php					
					}
				}
			}
			
			
			# --- materials
			if($vs_materials = $t_object->get('ca_objects.materials')){
				print "<div class='detailTextHeader'>"._t("Materials")."</div><div class='detailText'>{$vs_materials}</div>";
			}
			# --- measurements
			if($vs_dimensions = $t_object->get('ca_objects.dimensions_as_text')){
				print "<div class='detailTextHeader'>"._t("Measurements")."</div><div class='detailText'>{$vs_dimensions}</div>";
			}elseif($vs_dimensions = $t_object->get('ca_objects.dimensions')){
				print "<div class='detailTextHeader'>"._t("Measurements")."</div><div class='detailText'>{$vs_dimensions}</div>";
			}
			
			# --- description
			if($vs_description = $t_object->get('ca_objects.description_public')){
				print "<div class='detailTextHeader'>"._t("Description")."</div><div class='detailText' id='objectDescription'>{$vs_description}</div>";
				
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#objectDescription').expander({
				slicePoint: 500,
				expandText: '<?php print _t('[more]'); ?>',
				userCollapse: false
			});
		});
	</script>
<?php
			}
			# --- credit
			if($vs_credit = $t_object->get('ca_objects.credit_text')){
				print "<div class='detailTextHeader'>"._t("Credit")."</div><div class='detailText'>{$vs_credit}</div>";
			}
			# --- copyright
			//if($this->getVar('copyright')){
			//	print "<div class='detailTextHeader'>"._t("Copyright")."</div><div class='detailText'>".$this->getVar('copyright')."</div>";
			//}
			
			# --- identifier
			if($vs_idno = $t_object->get('ca_objects.idno')){
				print "<div class='detailTextHeader'>"._t("Identifier")."</div><div class='detailText'>{$vs_idno}</div>";
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
				
				$vs_occ_heading = "";
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
					if($va_item_types[$vn_occurrence_type_id]['name_singular'] == "exhibition"){
						$vs_occ_heading = _t("Part of")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'];
						if(sizeof($va_occurrence_list) > 1){
							$vs_occ_heading .= "s";
						}
					}else{
						$vs_occ_heading = _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'];
						if(sizeof($va_occurrence_list) > 1){
							$vs_occ_heading .= "s";
						}
					}
					
?>
						<div class="detailTextHeader"><?php print $vs_occ_heading; ?></div>
<?php
					
					foreach($va_occurrence_list as $vn_occurrence_id => $va_info) {
?>
						<div class="detailText"><?php print caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id)); ?>
<?php
						if($va_info["date"]){
							print ", ".$va_info["date"];
						}
?>
						</div>
<?php					
					}
				}
			}
			
			
			# --- store link
			if($vs_store_link = $t_object->get('ca_objects.store_link')){
				print "<div class='detailTextHeader'><a href='{$vs_store_link}'>"._t("Buy item from store")."</a></div>";
			}	
			
			
if (!$this->request->config->get('dont_show_see_also')) {			
			# --- output see also links
			if (sizeof($va_see_also)) {
				print "<div id='seeAlsoHeading'>"._t("See Also")."</div>";
				#print "<div class='detailTextHeader'>"._t("Related objects")."</div>";
				foreach($va_see_also as $vn_sa_object_id => $va_info){
					$t_item = new ca_objects($vn_sa_object_id);
					print "<div id='relatedItem'>";
					print caNavLink($this->request, $va_info["image_thumbnail"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_sa_object_id), array('id' => "detail_related_{$vn_sa_object_id}"));
					$va_entities = array();
					if(sizeof($t_item->getRelatedItemsForDisplay('ca_entities')) > 0){
						foreach($t_item->getRelatedItemsForDisplay('ca_entities') as $key => $va_entity_info){
							$va_entities[] = $va_entity_info["displayname"];
						}
					}
					
					$this->setVar('object_id', $vn_sa_object_id);
					$this->setVar('caption_title', $va_info["title"]);
					$this->setVar('caption_entities', join(', ', $va_entities));
					$this->setVar('caption_date_list', $t_item->getAttributesForDisplay("dates", '^dates_value'));
					$this->setVar('caption_object_type', $t_list->getItemFromListForDisplayByItemID('object_types', $t_item->get("type_id")));
					print "<div class='caption'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>";
					print "</div>";
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_info["image_small"]);
					$this->setVar('tooltip_title', $va_info["title"]);
					$this->setVar('tooltip_entities', join(', ', $va_entities));
					$this->setVar('tooltip_date_list', $t_item->getAttributesForDisplay("dates", '^dates_value'));
					$this->setVar('tooltip_description', $t_item->getAttributesForDisplay("description_public", null, array('convertLinkBreaks' => true)));
					TooltipManager::add(
						"#detail_related_{$vn_sa_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
				}
				print "<div style='clear:both; height:1px;'>&nbsp;</div>";
			}
}
?>
			</div><!-- end leftCol -->
			<div id="rightCol">
<?php
		$va_access_values = caGetUserAccessValues($this->request);
		#print_r($va_access_values);
		$pn_document_type_id = $t_list->getItemIDFromList("object_types", "physical_object");
		$va_primary_rep_display_options = $this->getVar('primary_rep_display_options');
		$va_primary_rep_display_options["id"] = "objectMedia";
		if($t_object->get("type_id") == $pn_document_type_id){
			if ($t_primary_rep = $t_object->getPrimaryRepresentationInstance()) {
				# --- documents
				if($va_display_options['no_overlay']){
					print $t_primary_rep->getMediaTag('media', $vs_display_version, $va_primary_rep_display_options);
				}else{
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_primary_rep->getPrimaryKey()))."\"); return false;' >".$t_primary_rep->getMediaTag('media', $vs_display_version, $va_primary_rep_display_options)."</a>";
				}
 				$va_display_options = caGetMediaDisplayInfo('detail', $t_primary_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
 				# --- always display the image unless it's marked as internal - access == 0
 				if($t_primary_rep->get('access') != 0){
 					# --- if you have full access include a link to the bookview/media overlay
 					if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) {
 					//	print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_primary_rep->getPrimaryKey()))."\"); return false;' >".$t_primary_rep->getMediaTag('media', $va_display_options["display_version"], $va_display_options)."</a>";
 					}else{
 					//	print $t_primary_rep->getMediaTag('media', $va_display_options["display_version"], $va_display_options);
 					}
 				}
 				if (!sizeof($va_access_values) || in_array($t_primary_rep->get('access'), $va_access_values)) { 		// check rep access
					# --- full access - download link if it's a pdf or word doc
					$va_rep_info = $t_primary_rep->getMediaInfo('media', 'original', 'MIMETYPE');
					switch($va_rep_info) {
						case 'application/pdf':
						case 'application/msword':
							print '<br/>'.caNavLink($this->request, 'Download full-quality PDF', '', 'Detail', 'Object', 'DownloadRepresentation', array('object_id' => $vn_object_id, 'representation_id' => $t_primary_rep->getPrimaryKey(), 'download' => 1));
							break;
					}
				}
			}
		}else{
			if ($t_rep && $t_rep->getPrimaryKey()) {
?>
				<div id="objDetailImage">
<?php
				if($va_display_options['no_overlay']){
					print $t_rep->getMediaTag('media', $vs_display_version, $va_primary_rep_display_options);
				}else{
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $va_primary_rep_display_options)."</a>";
				}
				// Print out download links for specific types
				if (in_array($t_rep->get("access"), $va_access_values)) {		// privileges IPs only get to download
					$va_rep_info = $t_rep->getMediaInfo('media', 'original', 'MIMETYPE');
					switch($va_rep_info) {
						case 'application/pdf':
						case 'application/msword':
							print '<br/>'.caNavLink($this->request, 'Download full-quality PDF', '', 'Detail', 'Object', 'DownloadRepresentation', array('object_id' => $vn_object_id, 'representation_id' => $t_rep->getPrimaryKey(), 'download' => 1));
							break;
					}
				}
?>
				</div><!-- end objDetailImage -->
<?php
			}
		}
		TooltipManager::add(
			"#objectMedia", "Preview web-quality image/document"
		);
?>		
		</div><!-- end rightCol -->
	</div><!-- end objectDetail -->