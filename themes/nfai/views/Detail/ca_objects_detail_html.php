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
		<h1><?php print unicode_ucfirst($this->getVar('typename')).': '.$vs_title; ?></h1>
		<div id="leftCol">
<?php
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
			}
			# --- identifier
			if ($alt_id = $t_object->get('ca_objects.alternate_idnos', array('convertCodesToDisplayText' => true, 'template' => "^id_value (^id_source)", 'delimiter' => '<br/>'))) {	
				print "<div class='unit'><b>"._t("Identifier")."</b><br/> ".$alt_id."</div><!-- end unit -->"; 
			} elseif ($t_object->get('idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b><br/> ".$t_object->get('idno')."</div><!-- end unit -->";
			}
			if($va_repository = $t_object->get('ca_occurrences.preferred_labels', array('returnAsArray' => true))){
				print "<div class='unit'><b>"._t("Repository")."</b><br/> ";
				foreach($va_repository as $va_term => $va_metadata) {
					
						print caNavLink($this->request, $va_metadata, '', '', 'Search', 'Index', array('search' => urlencode($va_metadata)))."<br/>";
					
				}
				print "</div>";
			}
			if($va_hierarchy = $t_object->get('ca_objects.hierarchy.preferred_labels', array('returnAsArray' => true))){
				$va_hierarchy_id = $t_object->get('ca_objects.hierarchy.object_id', array('returnAsArray' => true));
				$va_hierarchy_path = array_combine($va_hierarchy_id, $va_hierarchy);
				$va_count = count($va_hierarchy_path);
				$i = 0;
				print "<div class='unit'><b>"._t("Hierarchical Path")."</b><br/> ";
				foreach($va_hierarchy_path as $va_id => $va_name) {
					print caNavLink($this->request, $va_name, '', 'Detail', 'Object', 'Show', array('object_id' => $va_id));
					if($i+1 != $va_count) {
						print " > ";
					}
					$i++;
				}
				print "</div><!-- end unit -->";
			}
			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><b>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</b> ";
				$i = 0;
				foreach($va_children as $va_child){
				$child_idno = $va_child['object_id'];
					$the_child = new ca_objects($child_idno);
					$child_type = $the_child->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));

					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>["._t("More")."]</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					
					print "<div>".caNavLink($this->request, $va_child['name']." (".$child_type.") ", '', 'Detail', 'Object', 'Show', array('object_id' => $va_child['object_id']))."</div>";
					$i++;
					if(($i >= 5) && ($i == sizeof($va_children))){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}			

			if($va_alttitle = $t_object->get('ca_objects.nonpreferred_labels', array('convertCodesToDisplayText' => true, 'template' => "^nonpreferred_labels.name (^type_id)", 'delimiter' => '<br/>'))){
				print "<div class='unit'><b>"._t("Alternate Title")."</b><br/> ".$va_alttitle."</div><!-- end unit -->";
			}
			#print $t_object->get('ca_objects.nonpreferred_labels.type_id', array('convertCodesToDisplayText' => true));
			if($t_object->get("ca_objects.date.dates_value")) {
				$va_date = $t_object->get("ca_objects.date", array('convertCodesToDisplayText' => true, 'template' => "^dates_value (^dc_dates_types)", 'delimiter' => '<br/>'));
				print "<div class='unit'><b>"._t("Date")."</b><br/> ".$va_date."</div><!-- end unit -->";
			}
			if($va_summary = $t_object->get('ca_objects.summary')){
				print "<div class='unit' style='margin-top:15px;'><b>"._t("Summary")."</b><br/> ".$va_summary."</div><!-- end unit -->";
			}
			# --- entities
			$va_entities = $t_object->get("ca_entities", array('restrict_to_relationship_types' => array('actor', 'adaptor', 'arranger', 'artist', 'commentator', 'conductor', 'creator', 'collector', 'contributor', 'dancer', 'donor', 'editor', 'engineer', 'funder', 'illustrator', 'instrumentalist', 'interviewee', 'interviewer', 'librettist', 'lyricist', 'moderator', 'musician', 'narrator', 'originator', 'other', 'performer', 'photographer', 'producer', 'production_personnel', 'publisher', 'puppeteer', 'recordist', 'scribe', 'speaker', 'storyteller', 'transcriber', 'translator', 'videographer', 'vocalist'), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			if(sizeof($va_entities) > 0){	
?>
				<div class="unit"><b><?php print _t("Creator and/or Contributor") ?></b><br/>
<?php
				$va_entity_count = count($va_entities);
				$j = 0;
				foreach($va_entities as $va_entity) {
					
						print caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"]))." (".$va_entity['relationship_typename'].")";
						if($j+1 != $va_entity_count) {
							print ", ";
						}
						$j++;
					
				}
?>
				</div><!-- end unit -->
<?php
			}
			if(($t_object->get("ca_objects.dacs_element_note.aacs_dropdown", array('convertCodesToDisplayText' => true)) != 'General Note') && ($t_object->get("ca_objects.dacs_element_note.Dacs_Detail"))) {
				$va_dacs = $t_object->get("ca_objects.dacs_element_note", array('convertCodesToDisplayText' => true, 'template' => "<b>^aacs_dropdown</b><br/>^Dacs_Detail", 'delimiter' => '<br/><br/>'));
				print "<div class='unit'>".$va_dacs."</div><!-- end unit -->";
			}
			if($va_finding_url = $t_object->get('ca_objects.finding_aid_url', array('delimiter' => '<br/>'))){
				print "<div class='unit'><b>"._t('Finding Aid URL')." </b><br/><a href='".$va_finding_url."' target='_blank'>".$va_finding_url."</a></div><!-- end unit -->";
			}		
			if($t_object->get("ca_objects.extent_nfai.extent_number")) {
				$va_extentnum = $t_object->get("ca_objects.extent_nfai", array( 'template' => "^extent_number (^extent_type)", 'delimiter' => '<br/>'));
				print "<div class='unit'><b>"._t("Extent")."</b><br/> ".$va_extentnum."</div><!-- end unit -->";
			}
			if($va_adminbiohist = $t_object->get('ca_objects.adminbiohist')){
				print "<div class='unit'><b>"._t("Administrative/Biographical History Element")."</b><br/> ".$va_adminbiohist."</div><!-- end unit -->";
			}
			if($va_scopecontent = $t_object->get('ca_objects.scopecontent')){
				print "<div class='unit'><b>"._t("Scope and content note")."</b><br/> ".$va_scopecontent."</div><!-- end unit -->";
			}
			if($va_accessrestrict = $t_object->get('ca_objects.accessrestrict')){
				print "<div class='unit'><b>"._t("Conditions Governing Access")."</b><br/> ".$va_accessrestrict."</div><!-- end unit -->";
			}
			if($va_reproduction = $t_object->get('ca_objects.reproduction')){
				print "<div class='unit'><b>"._t("Conditions Governing Reproduction")."</b><br/> ".$va_reproduction."</div><!-- end unit -->";
			}
			if($va_copyright_notice = $t_object->get('ca_objects.copyright_notice')){
				print "<div class='unit'><b>"._t("Copyright Notice")."</b><br/> ".$va_copyright_notice."</div><!-- end unit -->";
			}
			if($va_language = $t_object->get('ca_objects.language', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true, 'template' => "^language_text (^language_type)"))){
				print "<div class='unit'><b>"._t("Language")."</b><br/> ".$va_language."</div><!-- end unit -->";
			}	
			if($va_lcsh_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray'=> true))){
				print "<div class='unit'><b>"._t("LCSH Terms")."</b><br/> ";
				foreach($va_lcsh_terms as $va_term => $va_metadata) {
					foreach($va_metadata as $v_i => $va_thing) {
						print caNavLink($this->request, $va_thing, '', '', 'Search', 'Index', array('search' => urlencode($va_thing)))."<br/>";
					}
				}
				print "</div>";
			}	
			if($va_subject = $t_object->get('ca_objects.subject', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true, 'template' => "^subject_text (^subject_source)"))){
				print "<div class='unit'><b>"._t("Other Subject Headings")."</b><br/> ".$va_subject."</div><!-- end unit -->";
			}	
			if($va_temporal = $t_object->get('ca_objects.temporal_coverage', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true, 'template' => "^temporal_coverage_date (^temporal_coverage_note)"))){
				print "<div class='unit'><b>"._t("Temporal Coverage")."</b><br/> ".$va_temporal."</div><!-- end unit -->";
			}	

			if($va_geo = $t_object->get('ca_objects.geographic_coverage', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true, 'template' => "^geo_coverage_text (^geo_coverage_source)"))){
				print "<div class='unit'><b>"._t("Geographic Coverage")."</b><br/> ".$va_geo."</div><!-- end unit -->";
			}				
			if($va_link = $t_object->get('ca_objects.external_link', array('returnAsArray'=> true))){
				print "<div class='unit'><b>"._t("URL")."</b><br/> ";
				foreach($va_link as $va_term => $va_metadata) {
					foreach($va_metadata as $v_i => $va_thing) {
						print "<a href='".$va_thing."' target='_blank'>".$va_thing."</a>";
					}
				}
				print "</div>";
			}	
			if($va_arrangement = $t_object->get('ca_objects.arrangement')){
				print "<div class='unit'><b>"._t("System of Arrangement")."</b><br/> ".$va_arrangement."</div><!-- end unit -->";
			}	
			if($va_originalsloc = $t_object->get('ca_objects.originalsloc')){
				print "<div class='unit'><b>"._t("Existence and Location of Originals")."</b><br/> ".$va_originalsloc."</div><!-- end unit -->";
			}	
			if($va_altformavail = $t_object->get('ca_objects.altformavail')){
				print "<div class='unit'><b>"._t("Existence and Location of Copies")."</b><br/> ".$va_altformavail."</div><!-- end unit -->";
			}	
			if($va_relatedmaterial = $t_object->get('ca_objects.relatedmaterial')){
				print "<div class='unit'><b>"._t("Related Archival Materials")."</b><br/> ".$va_relatedmaterial."</div><!-- end unit -->";
			}	
			if($va_preferred_citation = $t_object->get('ca_objects.preferred_citation')){
				print "<div class='unit'><b>"._t("Preferred Citation")."</b><br/> ".$va_preferred_citation."</div><!-- end unit -->";
			}	
			if($va_custohist = $t_object->get('ca_objects.custohist')){
				print "<div class='unit'><b>"._t("Custodial History")."</b><br/> ".$va_custohist."</div><!-- end unit -->";
			}	
			if($va_materials_designation = $t_object->get('ca_objects.materials_designation', array('returnAsArray'=> true, 'convertCodesToDisplayText' => true))){
				print "<div class='unit'><b>"._t("Materials Designation")."</b><br/> ";
				foreach($va_materials_designation as $va_term => $va_metadata) {
					foreach($va_metadata as $v_i => $va_thing) {
						print caNavLink($this->request, $va_thing, '', '', 'Search', 'Index', array('search' => urlencode($va_thing)))."<br/>";
					}
				}
				print "</div>";
			}			
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b><br/> ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_objects_description_attribute')){
				if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_object->getDisplayLabel("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))."</b><br/> {$vs_description_text}</div></div><!-- end unit -->";				
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


			# --- entities
			$va_entities = $t_object->get("ca_entities", array('restrict_to_relationship_types' => array('actor', 'adaptor', 'arranger', 'artist', 'commentator', 'conductor', 'creator', 'dancer', 'donor', 'editor', 'engineer', 'funder', 'illustrator', 'instrumentalist', 'interviewee', 'interviewer', 'librettist', 'lyricist', 'moderator', 'musician', 'narrator', 'originator', 'other', 'performer', 'photographer', 'producer', 'production_personnel', 'publisher', 'puppeteer', 'recordist', 'scribe', 'speaker', 'storyteller', 'transcriber', 'translator', 'videographer', 'vocalist'), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			if(sizeof($va_entities) > 0){	
?>
				<div class="unit"><h2><?php print _t("Related Entities:") ?></h2>
<?php
				foreach($va_entities as $va_entity) {
					
						print "<div>".caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"]))." (".$va_entity['relationship_typename'].")</div>";
					
				}
?>
				</div><!-- end unit -->
<?php
			}
			
		    # --- subject
			$va_subjects = $t_object->get("ca_entities", array('restrict_to_relationship_types' => array('subject'), "returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname'));
			if(sizeof($va_subjects) > 0){	
?>
				<div class="unit"><h2><?php print _t("Related Subjects:") ?></h2>
<?php
				foreach($va_subjects as $va_subject) {
					
						print "<div>".caNavLink($this->request, $va_subject["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_subject["entity_id"]))." (".$va_subject['relationship_typename'].")</div>";
					
				}
?>
				</div><!-- end unit -->
<?php
			}
/*			
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
*/
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
		</div><!-- end leftCol-->
		<div id="rightCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
		$va_height_info = $t_rep->getMediaInfo('ca_object_representations.media', 'medium', null, array('checkAccess' => $va_access_values));
		$padding = ((440 - $va_height_info["HEIGHT"])/2);
?>
			<div id="objDetailImage" >
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

		# --- user data --- comments - ranking - tagging
?>			
		<div id="objUserData">
<?php
			if($this->getVar("ranking")){
?>
				<h2 id="ranking"><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0" style="margin-left: 20px;"></h2>
<?php
			}
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
					$vs_login_message = _t("Login/register to be the first to rank, tag and comment on this object!");
				}
			}
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<h2><?php print _t("Add your rank, tags and comment"); ?></h2>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment" enctype='multipart/form-data'>
				<div class="formLabel">Rank
					<select name="rank">
						<option value="">-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
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
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
			}
		}
?>		
		</div><!-- end objUserData-->

		</div><!-- end rightCol -->
	</div><!-- end detailBody -->
<?php
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	
?>
