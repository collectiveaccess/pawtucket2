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
	$va_related_objects = 	$this->getVar('related_objects');
	
	$va_reps = $t_object->getRepresentations(array('large'));
	
	$t_rel_types = 			$this->getVar('t_relationship_types');
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	if (!$vs_default_image_version = $this->request->config->get('ca_objects_representation_default_image_display_version')) { $vs_default_image_version = 'mediumlarge'; }
?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("back to results"), '');

			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
?>
		</div><!-- end nav -->
		<h1><?php print unicode_ucfirst($this->getVar('typename')).': '.$vs_title; ?></h1>

<div id="rightCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
			
?>
			<div id="objDetailImage">
				<div id="objDetailRepScrollingViewer">
					<div id="objDetailRepScrollingViewerImageContainer"></div>
				</div>
				<div id="objDetailImageNav">
					<div >

<?php
#		if ($vn_num_reps > 1) {
#			print "(Click to view ".($vn_num_reps - 1)." additional images)";
#		}

				if (sizeof($va_reps) > 1) {
?>
					<a href="#" onclick="caObjDetailRepScroller.scrollToPreviousImage(); return false;" id="previousImage"><?php print _t("< previous"); ?></a>
					&nbsp;<span id='objDetailRepScrollingViewerCounter'></span>&nbsp;
					<a href="#" onclick="caObjDetailRepScroller.scrollToNextImage(); return false;" id="nextImage"><?php print _t("next >"); ?></a>
<?php
				}
				
				
?>				
				</div>

					<script type="text/javascript">
<?php
foreach($va_reps as $va_rep) {
       $va_imgs[] = "{url:'".$va_rep['urls']['large']."', width: ".$va_rep['info']['large']['WIDTH'].", height: ".
       $va_rep['info']['large']['HEIGHT'].", link: '#', onclick: 'caMediaPanel.showPanel(\\'".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\\');', onclickZoom:'', rel: '#objectInfoRepresentationOverlay'}";
}
?>

						var caObjDetailRepScroller = caUI.initImageScroller([<?php print join(",", $va_imgs); ?>], 'objDetailRepScrollingViewerImageContainer', {
								containerWidth: 700, containerHeight: 600,
								imageCounterID: 'objDetailRepScrollingViewerCounter',
								scrollingImageClass: 'objDetailRepScrollerImage',
								scrollingImagePrefixID: 'objDetailRep'
								
						});
					</script>
					<div id="objectInfoRepresentationOverlay"> 
						<div id="objectInfoRepresentationOverlayContentContainer">
							
						</div>
					</div>
			</div><!-- end objDetailImage -->
<?php
		}
?>
		</div><!-- end rightCol -->
		
		
		<div id="leftCol" ><div class="primaryinfo">		
<?php
			# --- identifier
			if($vs_idno = $t_object->get('ca_objects.idno')){
				print "<div class='unit'><h2>"._t("Title")."</h2> ".$vs_title."</div><!-- end unit -->";
				print "<div class='unit'><h2>"._t("Date")."</h2> ".$t_object->get('ca_objects.dates.dates_value')."</div><!-- end unit -->";
			}
			if($vs_materials = $t_object->get('ca_objects.materials')){
				print "<div class='unit'><h2>"._t("Materials")."</h2> ".$vs_materials."</div><!-- end unit -->";
			}
			if($vs_image_format = $t_object->get('ca_objects.image_format')){
				print "<div class='unit'><h2>"._t("Image Format")."</h2> ".$vs_image_format."</div><!-- end unit -->";
			}
			if($vs_description = $t_object->get('ca_objects.description')){
				print "<div class='unit'><h2>"._t("Description")."</h2> ".$vs_description."</div><!-- end unit -->";
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
	
	</div><!-- end primaryInfo -->
	<div class="relatedinfo">
<?php
			#}

			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
?>
				<div class="relatedinfo"><div class="unit">
<?php
				
				$va_entities_by_rel_type = array();
				foreach($va_entities as $va_entity) {
					if (!is_array($va_entities_by_rel_type[$va_entity['relationship_typename']])) { $va_entities_by_rel_type[$va_entity['relationship_typename']] = array(); }
					array_push($va_entities_by_rel_type[$va_entity['relationship_typename']], $va_entity);
				}
				
				// Loop through types
				foreach($va_entities_by_rel_type as $vs_type => $va_entities) {
					// Print type name
					print "<div class=\"unit\"><h2>".unicode_ucfirst($vs_type)."</h2>\n";
					
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
					print "</div>";
				}
?>
				</div><!-- end unit -->
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_occurrences)){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				$va_occurrences_by_type = array();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_occurrences_by_type[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "date" => $t_occ->getAttributesForDisplay("dates", '^dates_value'), "relationship_typename" => $va_occurrence['relationship_typename']);
				}
				
				foreach($va_occurrences_by_type as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><H2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></H2>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
?>
						<div><?php print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".unicode_ucfirst($va_info['relationship_typename']).")"; ?><br /></div>
<?php					
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
			
			# --- hierarchy info
			if($this->getVar('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $this->getVar('parent_title'), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('parent_id')))."</div>";
			}
			if($this->getVar('num_children') > 0){
				print "<div class='unit'><b>"._t("Parts")."</b>: ".caNavLink($this->request, $this->getVar('num_children')." parts of this ".$this->getVar('object_type'), '', '', 'Search', 'Search', array('search' => "children:".$vn_object_id))."</div>";
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
			</div><!-- end relatedinfo-->
		</div><!-- end leftCol--> 
		
	</div><!-- end detailBody -->