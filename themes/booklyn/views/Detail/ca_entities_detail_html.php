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

if (!$this->request->isAjax()) {		
?>
	<div id="detailBody">
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
		<h1><?php print $vs_title; ?></h1>
		<div id="leftCol">		
<?php
			if($this->request->config->get('enable_bookmarks')){
?>
				<!-- bookmark link BEGIN -->
				<div class="unit">
<?php
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark +"), 'button', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}else{
					print caNavLink($this->request, _t("Bookmark +"), 'button', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_entity_id, 'tablename' => 'ca_entities'));
				}
?>
				</div><!-- end unit -->
				<!-- bookmark link END -->
<?php
			}
			if ($t_entity->get('ca_entities.type_id') != 79) {
				if ($va_company = $t_entity->get('ca_entities.company.companyName')) {
					print "<div class='unit'><span class='metatitle'>Press Name</span><br/>".$va_company."</div>";
				}
			}
			if(($va_origin = $t_entity->get('ca_entities.address', array('template' => '^city<ifdef code="city,stateprovince">, </ifdef>^stateprovince ^country', 'delimiter' => '<br/>')))){
				print "<div class='unit'><span class='metatitle'>"._t("Location")."</span><br/> ".$va_origin."</div><!-- end unit -->";
			}		
			if ($va_bio = $t_entity->get('ca_entities.artist_bio')) {
				print "<div class='unit' id='bio'><span class='metatitle'>Biography</span><br/>".$va_bio."</div>";
			}
			if ($va_instit = $t_entity->get('ca_entities.related.preferred_labels', array('restrictToRelationshipTypes' => array('in_collection'), 'returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values, 'sort' => 'surname'))) {
				print "<div class='unit'><span class='metatitle'>In Collection</span><br/>".$va_instit."</div>";
			}				
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#bio').expander({
								slicePoint: 400,
								expandText: '<?php print _t('[more]'); ?>',
								userCollapseText: '[less]'
							});
						});
					</script>
<?php			
			# --- attributes
			$va_attributes = $this->request->config->get('ca_entities_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_entity->get("ca_entities.{$vs_attribute_code}")){
						print "<div class='unit'><span class='metatitle'>".$t_entity->getDisplayLabel("ca_entities.{$vs_attribute_code}")."</span><br/> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_entities_description_attribute')){
				if($vs_description_text = $t_entity->get("ca_entities.".$this->request->config->get('ca_entities_description_attribute'))){
					print "<div class='unit'><span class='metatitle'>".$t_entity->getDisplayLabel('ca_entities.'.$this->request->config->get('ca_entities_description_attribute'))."</span><br/> {$vs_description_text}</div><!-- end unit -->";				
?>


<?php
				}
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
						<div class="unit"><span class='metatitle'><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></span><br/>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<p>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])."</p>";
					}
					print "</div><!-- end unit -->";
				}
			}
			if ($va_url = $t_entity->get('ca_entities.external_link.url_entry')){
				if ($va_name = $t_entity->get('ca_entities.external_link.url_source')){
					print "<div class='unit'><span class='metatitle'>"._t('Website')."</span><br/><a href='".$va_url."' target='_blank'>".$va_name."</a></div>";
				} else {
			   		print "<div class='unit'><span class='metatitle'>"._t('Website')."</span><br/><a href='".$va_url."' target='_blank'>".$va_url."</a></div>";
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

?>
	</div><!-- end leftCol -->
	<div id="rightCol">
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
	<div class='seeMore' style='margin:10px 0px 25px 0px'><a href='#'>Back to Top</a></div>
</div><!-- end detailBody -->
<?php
}
?>