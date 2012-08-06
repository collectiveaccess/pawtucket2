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
 
	require_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	$o_rc = new ResultContext($this->request, 'ca_objects', 'basic_search');

	
	# -- get the various object types so we can display different attributes based on type
	$o_lists = new ca_lists;
	$vn_collection_id = $o_lists->getItemIDFromList('object_types', 'collection');
	$vn_series_id = $o_lists->getItemIDFromList('object_types', 'series');
			
?>	
	<div id="detailBody">
<?php
		if(!$o_rc->getParameter("collection_list_search") && ($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', '<img src="'.$this->request->getThemeUrlPath().'/graphics/cfa/leftArrow.png" border="0"  alt="Back" /> '._t("Back"), ''))){
			print '<div id="backButton">';
			print $vs_back_link;
			print '</div>';
		}
?>
		<div id="pageNav">
<?php
			if ($this->getVar('is_in_result_list')) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/cfa/leftArrow.png" border="0"  alt="Previous" /> '._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}
				if ($this->getVar('previous_id') && $this->getVar('next_id')) {
					print "&nbsp;&nbsp;|&nbsp;&nbsp;";
				}
				if ($this->getVar('next_id')) {
					print caNavLink($this->request, _t("Next").' <img src="'.$this->request->getThemeUrlPath().'/graphics/cfa/rightArrow.png" border="0"  alt="Next" />', '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
				}
			}
?>
		</div><!-- end nav -->
		<h3 class="entry-title" style="clear:both;"><?php print $vs_title; ?></h3>
<?php
			if($this->request->config->get('show_add_this')){
?>
				<!-- AddThis Button BEGIN -->
				<div class="unit" style="float:right;"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
				<!-- AddThis Button END -->
<?php
			}			
			# --- identifier
			if($t_object->get('idno')){
				print "<div class='unit'><b>".unicode_ucfirst($this->getVar('typename'))." "._t("Identifier").":</b> ".$t_object->get('idno')."</div><!-- end unit -->";
			}

			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}
			
			switch($t_object->get("type_id")){
				# --- COLLECTION --------------------------------
				case $vn_collection_id:
					# [cfaOrganizationArrangement]
					if($t_object->get('ca_objects.cfaIntellectualArrangement')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaIntellectualArrangement").":</b> ".$t_object->get('ca_objects.cfaIntellectualArrangement')."</div><!-- end unit -->";
					}
					
					# --- preservation sponsor
					if($t_object->get('ca_objects.cfaPreservationSponsor')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaPreservationSponsor").":</b> ".$t_object->get('ca_objects.cfaPreservationSponsor')."</div><!-- end unit -->";
					}
					
					if ($t_rep && $t_rep->getPrimaryKey()) {
?>
						<div class="unit">
<?php
						if($va_display_options['no_overlay']){
							print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
						}else{
						//	print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
							
							$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
							print "<div id='cont'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					$va_md_elements = array("cfaRepository", "cfaCollectionExtent", "cfaInclusiveDates", "cfaBulkDates", "cfaAbstract", "cfadescription");
					foreach($va_md_elements as $vs_attribute_code){
						if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
							print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
						}
					}
					
					# --- creator
					$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("creator", "source", "compiler")));
					if(sizeof($va_entities) > 0){
						$t_related_entity = new ca_entities();
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Creators") : _t("Creator")); ?></b><br/>
<?php
						$i = 1;
						foreach($va_entities as $va_entity) {
							$t_related_entity->load($va_entity["entity_id"]);
							print "<div".(($i < sizeof($va_entities) ? " style='margin-bottom:10px;'" : "")).">".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))." (".$va_entity['relationship_typename'].")";
							if($t_related_entity->get("biography")){
								print "<br/>".$t_related_entity->get("biography");
							}
							print "</div>";
							$i++;
						}
?>
						</div><!-- end unit -->
<?php
					}
					
					# --- custodial history
					if($t_object->get('ca_objects.cfaCustodialHistory')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaCustodialHistory")."</b><br/>".$t_object->get('ca_objects.cfaCustodialHistory')."</div><!-- end unit -->";
					}	
					# --- Language
					if($t_object->get('ca_objects.cfaLanguageMaterials')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaLanguageMaterials")."</b><br/>".$t_object->get('ca_objects.cfaLanguageMaterials', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
					}	
					# --- Genre?

					# --- vocabulary terms
					$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
					if(sizeof($va_terms) > 0){
						print "<div class='unit'><b>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</b><br/>";
						foreach($va_terms as $va_term_info){
							print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
						}
						print "</div><!-- end unit -->";
					}	
					# --- places
					$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
					
					if(sizeof($va_places) > 0){
						print "<div class='unit'><b>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</b><br/>";
						foreach($va_places as $va_place_info){
							print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
						}
						print "</div><!-- end unit -->";
					}		
					
					$va_md_elements = array("cfaAccessRestrictions", "cfaUseRestrictions", "cfaRelatedMaterials", "cfaGeneralNote", "cfaPublicationDate");
					foreach($va_md_elements as $vs_attribute_code){
						if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
							print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
						}
					}
					
					# --- publisher
					$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("publisher")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Publishers") : _t("Publisher")); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))."</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
				break;
				# --------------------------------
				# --- SERIES --------------------------------
				case $vn_series_id:
					# --- preservation sponsor
					if($t_object->get('ca_objects.cfaPreservationSponsor')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaPreservationSponsor").":</b> ".$t_object->get('ca_objects.cfaPreservationSponsor')."</div><!-- end unit -->";
					}
					# --- repository
					if($t_object->get('ca_objects.cfaRepository')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaRepository")."</b><br/>".$t_object->get('ca_objects.cfaRepository', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
					}
					# --- extent
					if($t_object->get('ca_objects.cfaExtent')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaExtent")."</b><br/>".$t_object->get('ca_objects.cfaExtent.extentAmount')." ".$t_object->get('ca_objects.cfaExtent.extentType', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
					}
					$va_md_elements = array("cfaInclusiveDates", "cfaBulkDates", "cfaAbstract", "cfadescription");
					foreach($va_md_elements as $vs_attribute_code){
						if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
							print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
						}
					}
					# --- Language
					if($t_object->get('ca_objects.cfaLanguageMaterials')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaLanguageMaterials")."</b><br/>".$t_object->get('ca_objects.cfaLanguageMaterials', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
					}

					# --- vocabulary terms
					$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
					if(sizeof($va_terms) > 0){
						print "<div class='unit'><b>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</b><br/>";
						foreach($va_terms as $va_term_info){
							print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
						}
						print "</div><!-- end unit -->";
					}	
					# --- places
					$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
					
					if(sizeof($va_places) > 0){
						print "<div class='unit'><b>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</b><br/>";
						foreach($va_places as $va_place_info){
							print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
						}
						print "</div><!-- end unit -->";
					}		
					
					$va_md_elements = array("cfaAccessRestrictions", "cfaUseRestrictions", "cfaGeneralNote", "cfaPublicationDate");
					foreach($va_md_elements as $vs_attribute_code){
						if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
							print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
						}
					}
					
					# --- publisher
					$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("publisher")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Publishers") : _t("Publisher")); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))."</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
				break;
				# --------------------------------
				# --- ITEM --------------------------------
				default:
					# --- get the related work record (occurrence with linked with rel type instantiation)
					$t_work = new ca_occurrences();
					$va_works = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("instantiation")));
					if(sizeof($va_works) > 0){
						# -- assume there is one related work, just load the first one in the array
						foreach($va_works as $vn_rel_id => $va_work_info){
							$t_work->load($va_work_info['occurrence_id']);
							break;
						}
					}
					
					if ($t_rep && $t_rep->getPrimaryKey()) {
?>
						<div class="unit">
<?php
						if($va_display_options['no_overlay']){
							print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
						}else{
						//	print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
							
							$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
							print "<div id='cont'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					# --- attributes
					$va_attributes = array("cfaRunTime", "cfaFormat");
					if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
						foreach($va_attributes as $vs_attribute_code){
							if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
								print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
							}
						}
					}
					# --- extent
					if($t_object->get('ca_objects.cfaExtent')){
						print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.cfaExtent")."</b><br/>".$t_object->get('ca_objects.cfaExtent.extentAmount')." - ".$t_object->get('ca_objects.cfaExtent.extent', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
					}
					# --- attributes
					$va_attributes = array("cfaColor", "cfaSoundAudio", "cfaSoundVideo", "cfaSoundFilm");
					if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
						foreach($va_attributes as $vs_attribute_code){
							if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
								print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
							}
						}
					}
					
					# --- work record attribute - Date produced
					if($vs_value = $t_work->get("ca_occurrences.cfaDateProduced", array("convertCodesToDisplayText" => true))){
						print "<div class='unit'><b>"._t("Date Produced")."</b><br/> {$vs_value}</div><!-- end unit -->";
					}
					# --- work record attribute - Abstract
					if($vs_value = $t_work->get("ca_occurrences.cfaAbstract", array("convertCodesToDisplayText" => true))){
						print "<div class='unit'><b>"._t("Abstract")."</b><br/> {$vs_value}</div><!-- end unit -->";
					}
					# --- work record attribute - Description
					if($vs_value = $t_work->get("ca_occurrences.cfaDescription", array("convertCodesToDisplayText" => true))){
						print "<div class='unit'><b>"._t("Description")."</b><br/> {$vs_value}</div><!-- end unit -->";
					}
					
					# --- work record attribute - log
					if($vs_value = $t_work->get("ca_occurrences.cfaShotLog", array("convertCodesToDisplayText" => true))){
						print "<div class='unit'><b>"._t("Log")."</b><br/> {$vs_value}</div><!-- end unit -->";
					}
					
					# --- more attributes
					$va_attributes = array("cfaPreservationSponsor");
					if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
						foreach($va_attributes as $vs_attribute_code){
							if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
								print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
							}
						}
					}
					$va_entities_output = array();
					# --- distributor - from related occ work record
					$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("distributor")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Distributor") : _t("Distributors")); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							$va_entities_output[] = $va_entity['relation_id'];
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))."</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					# --- main credits - from related occ work record
					$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("director", "producer", "exec_producer", "co_producer", "production_co", "animator", "filmmaker", "videomaker", "writter")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Main Credit") : _t("Main Credits")); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							$va_entities_output[] = $va_entity['relation_id'];
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))." (".$va_entity['relationship_typename'].")</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					# --- additional credits - from related occ work record
					$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("editor", "composer", "sound", "music", "translator", "choreographer", "lighting_director", "casting", "post_prod")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print ((sizeof($va_entities) > 1) ? _t("Additional Credit") : _t("Additional Credits")); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							$va_entities_output[] = $va_entity['relation_id'];
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))." (".$va_entity['relationship_typename'].")</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					# --- Participants and performers - from related occ work record
					$va_entities = $t_work->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => 'surname', 'restrict_to_relationship_types' => array("participant", "performer", "actor", "narrator", "commentator", "interviewer", "interviewee", "musician", "vocalist", "announcer", "panelist", "host", "moderator", "reporter", "performing_group")));
					if(sizeof($va_entities) > 0){	
?>
						<div class="unit"><b><?php print _t("Actors, Performers and Participants"); ?></b><br/>
<?php
						foreach($va_entities as $va_entity) {
							$va_entities_output[] = $va_entity['relation_id'];
							print "<div>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : caNavlink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => 'entity_id:'.$va_entity["entity_id"])))." (".$va_entity['relationship_typename'].")</div>";
						}
?>
						</div><!-- end unit -->
<?php
					}
					# --- vocabulary terms - genre - from work record
					$va_terms = $t_work->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("genre")));
					if(sizeof($va_terms) > 0){
						print "<div class='unit'><b>"._t("Genre").((sizeof($va_terms) > 1) ? "s" : "")."</b><br/>";
						foreach($va_terms as $va_term_info){
							print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
						}
						print "</div><!-- end unit -->";
					}
					# --- vocabulary terms - form - from work record
					$va_terms = $t_work->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("form")));
					if(sizeof($va_terms) > 0){
						print "<div class='unit'><b>"._t("Form").((sizeof($va_terms) > 1) ? "s" : "")."</b><br/>";
						foreach($va_terms as $va_term_info){
							print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
						}
						print "</div><!-- end unit -->";
					}	
					
					# --- vocabulary terms - subjects - from work record
					$va_terms = $t_work->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("subject")));
					if(sizeof($va_terms) > 0){
						print "<div class='unit'><b>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "")."</b><br/>";
						foreach($va_terms as $va_term_info){
							print "<div>".caNavLink($this->request, $va_term_info['label'], '', '', 'Search', 'Index', array('search' => $va_term_info['label']))."</div>";
						}
						print "</div><!-- end unit -->";
					}	
					# --- places - from work record
					$va_places = $t_work->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
					
					if(sizeof($va_places) > 0){
						print "<div class='unit'><b>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</b><br/>";
						foreach($va_places as $va_place_info){
							print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
						}
						print "</div><!-- end unit -->";
					}	
					
					# --- attributes
					$va_attributes = array("cfaAccessRestrictions", "cfaUseRestrictions", "cfaRepository", "cfaRelatedMaterials");
					if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
						foreach($va_attributes as $vs_attribute_code){
							if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array("convertCodesToDisplayText" => true))){
								print "<div class='unit'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}")."</b><br/> {$vs_value}</div><!-- end unit -->";
							}
						}
					}
					
				break;
				# --------------------------------
			}
			
			# --- child hierarchy info Items
			# --- we need to get records with access set to accessible tot he public AND restricted.  Restricted records will not link to detail page.
			$va_access_values_for_children = $va_access_values;
			# --- add restricted to array
			$va_access_values_for_children[] = 2;
			$va_children_ids = array_values($t_object->get("ca_objects.children.object_id", array('returnAsArray' => 1, 'checkAccess' => $va_access_values_for_children, 'sort' => 'ca_objects.preferred_labels.name_sort', 'sort_direction' => 'ASC')));

			if(sizeof($va_children_ids) > 0){
				$t_child = new ca_objects();
				$qr_children = $t_child->makeSearchResult('ca_objects', $va_children_ids);
				print "<div class='unit'><b>"._t("%1 Item%2", unicode_ucfirst($this->getVar('typename')), ((sizeof($va_children) > 1) ? "s" : ""))."</b><br/>";
				$i = 0;
				
				while($qr_children->nextHit()) {
					$vn_object_id = $qr_children->get('ca_objects.object_id');
					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>"._t("%1 More &rsaquo;", sizeof($va_children_ids))."</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					if($qr_children->get("access") == 1){
						print "<div>".caNavLink($this->request, $qr_children->get('ca_objects.preferred_labels.name'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
					}else{
						print "<div>".$qr_children->get('ca_objects.preferred_labels.name')."</div>";
					}
					$i++;
					if($i == sizeof($va_children_ids)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}

if (!$this->request->config->get('dont_allow_registration_and_login')) {
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
<?php
	}
?>
	</div><!-- end detailBody -->
<?php
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	
?>
