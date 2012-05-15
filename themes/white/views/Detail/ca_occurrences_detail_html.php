<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
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
	$t_occurrence 		= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), '');

			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
?>
		</div><!-- end nav -->
		<h1><?php print unicode_ucfirst($t_occurrence->getTypeName()).': '.$vs_title; ?></h1>
<!-- end leftCol -->
			
	<div id="rightCol">
		<div id="resultBox">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'occurrence_id' => $vn_occurrence_id
		));
		print $this->render('related_objects_grid.php');

if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->


	</div>
			<div id="leftCol"  style="margin-left: 65px; margin-top: 20px;">	<div class="primaryinfo">
<?php
			# --- identifier
			if($this->getVar('idno')){
				print "<div class='unit'><h2>"._t("Title")."</h2> ".$vs_title."</div><!-- end unit -->";
				print "<div class='unit'><h2>"._t("Date")."</h2> ".$this->getVar('date_of_creation')."</div><!-- end unit -->";
			}
			if($this->getVar('materials')){
				print "<div class='unit'><h2>"._t("Materials")."</h2> ".$this->getVar('materials')."</div><!-- end unit -->";
			}
			if($this->getVar('exhibition_type')){
				print "<div class='unit'><h2>"._t("Exhibition Type")."</h2> ".$this->getVar('exhibition_type')."</div><!-- end unit -->";
			}
			if($this->getVar('description')){
				print "<div class='unit'><h2>"._t("Description")."</h2> ".$this->getVar('description')."</div><!-- end unit -->";
			}
			if($this->getVar('contributors')){
				print "<div class='unit'><h2>"._t("Contributors")."</h2> ".$this->getVar('contributors')."</div><!-- end unit -->";
			}
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
			#}


			# --- entities
			$va_entities = array();
			if(sizeof($this->getVar('entities'))){	
?>
				</div><div class="relatedinfo"><div class="unit">
<?php
				$va_entity_rel_types = $t_rel_types->getRelationshipInfo('ca_entities_x_occurrences');
				
				$va_occurrences_by_rel_type = array();
				foreach($this->getVar('entities') as $va_entity) {
					if (!is_array($va_entities_by_rel_type[$va_entity['relationship_type_id']])) { $va_entities_by_rel_type[$va_entity['relationship_type_id']] = array(); }
					array_push($va_entities_by_rel_type[$va_entity['relationship_type_id']], $va_entity);
				}
				foreach($va_entities_by_rel_type as $vn_type_id => $va_entities) {
					// Print type name
					print "<div class=\"unit\"><h2>".unicode_ucfirst($va_entity_rel_types[$vn_type_id]['typename'])."</h2>\n";
					
					// Print entities for current type
					foreach($va_entities as $vn_index => $va_entity) {
?>
					<div><?php print (($this->request->config->get('allow_detail_for_ca_entities')) ? 
					caNavLink($this->request, $va_entity['label'], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) 
						: 
						caNavLink($this->request, $va_entity['label'], '', '', 'Search', 'Index', array('search' => '"'.$va_entity['label'].'"')));
					?></div>
<?php					
				}
				print "<br />";
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
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_occurrences_x_occurrences');
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
				$va_place_rel_types = $t_rel_types->getRelationshipInfo('ca_places_x_occurrences');
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
				$va_collection_rel_types = $t_rel_types->getRelationshipInfo('ca_occurrences_x_collections');
				foreach($this->getVar('collections') as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_rel_types[$va_collection_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
?></div>
	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>