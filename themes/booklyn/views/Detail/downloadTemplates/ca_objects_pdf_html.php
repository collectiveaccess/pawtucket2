<?php
/* ----------------------------------------------------------------------
 * /views/Detail/downloadTemplates/ca_objects_pdf_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
	$t_item = $this->getVar("t_item");
	$va_access_values = $this->getVar("access_values");
	
?>
<HTML>
	<HEAD>
		<style type="text/css">
			<!--
			div, p { font-size: 11px; font-family: Helvetica, sans-serif;}
			.unit { padding:0px 0px 10px 0px;}
			H1 { font-weight:bold; font-size: 13px; font-family: Helvetica, sans-serif; margin:0px 0px 10px 0px; }
			H2 { font-weight:bold; font-size: 11px; font-family: Helvetica, sans-serif; margin-bottom:2px; }
			.media { float:right; padding:0px 0px 10px 10px; width:400px; }
			.pageHeader { margin: 0px 10px 20px 0px; padding: 0px 5px 0px 5px; width: 100%; font-family: Helvetica, sans-serif; }
			.pageHeader img{ vertical-align:middle;  }
			.notes { font-style:italic; color:#828282; margin-top:20px; }
			-->
		</style>
	</HEAD>
	<BODY>
		
<?php
		if(file_exists($this->request->getThemeDirectoryPath().'/graphics/CAlogo.gif')){
			print '<div class="pageHeader"><img src="'.$this->request->getThemeDirectoryPath().'/graphics/CAlogo.gif"/></div>';
		}
		if($t_rep = $t_item->getPrimaryRepresentationInstance(array('return_with_access' => $va_access_values))){
			$va_rep_display_info = caGetMediaDisplayInfo("summary", $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			if (!($vs_version = $va_rep_display_info['display_version'])) { $vs_version = "large"; }
?>
			<div class="media"><img src="<?php print $t_rep->getMediaPath("media", $vs_version); ?>"></div>
<?php
		}
		print "<H1>".$t_item->getLabelForDisplay()."</H1>";
		# --- identifier
		if($t_item->get('idno')){
			print "<div class='unit'><b>"._t("Identifier").":</b> ".$t_item->get('idno')."</div><!-- end unit -->";
		}
		# --- parent hierarchy info
		if($t_item->get('parent_id')){
			print "<div class='unit'><b>"._t("Part Of")."</b>: ".$t_item->get("ca_objects.parent.preferred_labels.name")."</div>";
		}
		# --- attributes
		$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
		if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
			foreach($va_attributes as $vs_attribute_code){
				if($vs_value = $t_item->get("ca_objects.{$vs_attribute_code}")){
					print "<div class='unit'><b>".$t_item->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
				}
			}
		}
		# --- description
		if($this->request->config->get('ca_objects_description_attribute')){
			if($vs_description_text = $t_item->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
				print "<div class='unit'><b>".$t_item->getDisplayLabel("ca_objects.".$this->request->config->get('ca_objects_description_attribute')).":</b> {$vs_description_text}</div><!-- end unit -->";				
			}
		}
		# --- child hierarchy info
		$va_children = $t_item->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_children) > 0){
			print "<div class='unit'><h2>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h2> ";
			foreach($va_children as $va_child){
				print "<div>".$va_child['name']."</div>";
			}
			print "</div><!-- end unit -->";
		}
		# --- entities
		$va_entities = $t_item->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
		if(sizeof($va_entities) > 0){	
?>
			<div class="unit"><h2><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("Entities") : _t("Entity")); ?></h2>
<?php
			foreach($va_entities as $va_entity) {
				print "<div>".$va_entity["label"]." (".$va_entity['relationship_typename'].")</div>";
			}
?>
			</div><!-- end unit -->
<?php
		}
		
		# --- occurrences
		$va_occurrences = $t_item->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
					print "<div>".$va_info["label"]." (".$va_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
		}
		# --- places
		$va_places = $t_item->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		
		if(sizeof($va_places) > 0){
			print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
			foreach($va_places as $va_place_info){
				print "<div>".$va_place_info['label']." (".$va_place_info['relationship_typename'].")</div>";
			}
			print "</div><!-- end unit -->";
		}
		# --- collections
		$va_collections = $t_item->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_collections) > 0){
			print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
			foreach($va_collections as $va_collection_info){
				print "<div>".$va_collection_info['label']." (".$va_collection_info['relationship_typename'].")</div>";
			}
			print "</div><!-- end unit -->";
		}
		# --- lots
		$va_object_lots = $t_item->get("ca_object_lots", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_object_lots) > 0){
			print "<div class='unit'><h2>"._t("Related Lot").((sizeof($va_object_lots) > 1) ? "s" : "")."</h2>";
			foreach($va_object_lots as $va_object_lot_info){
				print "<div>".$va_object_lot_info['label']." (".$va_object_lot_info['relationship_typename'].")</div>";
			}
			print "</div><!-- end unit -->";
		}
		# --- vocabulary terms
		$va_terms = $t_item->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_terms) > 0){
			print "<div class='unit'><h2>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</h2>";
			foreach($va_terms as $va_term_info){
				print "<div>".$va_term_info['label']."</div>";
			}
			print "</div><!-- end unit -->";
		}
		print "<div class='notes'><b>Downloaded:</b> ".caGetLocalizedDate(null, array('dateFormat' => 'delimited'))."</unit>";
?>	
	
	
	</BODY>
</HTML>