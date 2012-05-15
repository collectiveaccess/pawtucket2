<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_places_detail_html.php : 
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
	$t_place 		= $this->getVar('t_item');
	$vn_place_id 	= $t_place->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_places', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), '');

			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Place', 'Show', array('place_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Place', 'Show', array('place_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
?>
		</div><!-- end nav -->
		<h1><?php print unicode_ucfirst($t_place->getTypeName()).': '.$vs_title; ?></h1>
		<div id="leftCol">	
<?php
			# --- identifier
			if($this->getVar('idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b>: ".$this->getVar('idno')."</div><!-- end unit -->";
			}
?>	
			<div class="unit">
				<H2>Heading</H2>
				<div><a href="#">list item</a></div>
				<div><a href="#">list item</a></div>
			</div><!-- end unit -->
			
			<div class="unit"><b>Heading:</b> info</div><!-- end unit -->
<?php
			# --- description
			#if($this->getVar('description')){
				print "<div class='unit'><div id='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec nisl arcu, quis faucibus mauris. Donec vestibulum, justo et commodo hendrerit, mi risus accumsan urna, eu molestie massa diam a erat. Proin sapien diam, adipiscing at semper ut, vehicula eget libero. Suspendisse potenti. Donec id nunc et odio commodo suscipit rhoncus sit amet urna. Donec dictum, velit eu scelerisque venenatis, mi ante aliquam neque, eu suscipit metus ipsum at velit. Aenean vitae arcu ac risus laoreet faucibus in a neque. Nulla id nibh augue. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque vulputate, tortor id commodo volutpat, justo libero euismod libero, ac ultrices lacus est eget lacus. Praesent gravida dictum aliquam. Morbi ac ante vel magna accumsan vehicula. Aenean at auctor libero. Mauris nibh nunc, pharetra eu pretium sed, vestibulum vitae risus. Duis sollicitudin felis condimentum nibh facilisis vitae sollicitudin urna tempus.</div></div><!-- end unit -->";				
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
				<div class="unit"><H2><?php print _t("Related")." ".((sizeof($this->getVar('entities') > 1)) ? _t("Entities") : _t("Entity")); ?></H2>
<?php
				$va_entity_rel_types = $t_rel_types->getRelationshipInfo('ca_entities_x_places');
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
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_places_x_occurrences');
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
				$va_place_rel_types = $t_rel_types->getRelationshipInfo('ca_places_x_places');
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
				$va_collection_rel_types = $t_rel_types->getRelationshipInfo('ca_places_x_collections');
				foreach($this->getVar('collections') as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_rel_types[$va_collection_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}		
			
?>
	</div><!-- end leftCol -->
			
	<div id="rightCol">
		<div id="resultBox">
<?php
}
		// set parameters for paging controls view
		$this->setVar('other_paging_parameters', array(
			'place_id' => $vn_place_id
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