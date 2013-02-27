<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_collections_detail_html.php : 
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
	$t_collection 			= $this->getVar('t_item');
	$vn_collection_id 		= $t_collection->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');


?>
	<div id="detailBody" class="findingAid">
		<div id="pageNav">
<?php
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_collections', _t("Back"), ''))) {
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Collection', 'Show', array('collection_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Collection', 'Show', array('collection_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
		<?php print "<p>".caNavLink($this->request, 'Return to Finding Aid', '', 'FindingAids', 'Collection', 'index')."</p>"; ?>
		<?php print "<p>".caNavLink($this->request, "+ Download PDF Summary", "", "FindingAids", "Collection", "downloadSummary", array('collection_id' => $vn_collection_id))."</p>";?>

		<h1><?php print unicode_ucfirst($t_collection->getTypeName()).': '.$vs_title; ?></h1>
		<div id="leftCol">	
<?php
			$va_anchors = array();
			$va_anchors[] = '<p><a href="#collection">'._t('Collection Overview').'</a></p>';
			print "<div class='header'><a name='collection'>"._t('Collection Overview')."</a></div>";
			if($vs_title){
				print "<div class='unit'><span class='unitTitle'>"._t("Collection Title")."</span>: ".$vs_title."</div><!-- end unit -->";
			}			
			# --- identifier
			if($t_collection->get('idno')){
				print "<div class='unit'><span class='unitTitle'>"._t("Identifier")."</span>: ".$t_collection->get('idno')."</div><!-- end unit -->";
			}
			# --- dates
			if($va_dates = $t_collection->get('ca_collections.inclusive_dates')){
				print "<div class='unit'><span class='unitTitle'>"._t("Inclusive Dates")."</span>: ".$va_dates."</div><!-- end unit -->";
			}
			# --- extent
			if($t_collection->get('ca_collections.extent.extent_collection')){
				$va_extent = $t_collection->get('ca_collections.extent', array('convertCodesToDisplayText' => true, 'template' => '^extent_collection ^type_collection'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$va_extent."</div><!-- end unit -->";
			}
			# --- extent
			if($t_collection->get('ca_collections.extent_folder.folder_extent')){
				$va_extent = $t_collection->get('ca_collections.extent_folder', array('convertCodesToDisplayText' => true, 'template' => '^folder_extent ^type_folder'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$va_extent."</div><!-- end unit -->";
			}			
			# --- scope
			if($va_scope = $t_collection->get('ca_collections.scope_note')){
				print "<div class='header'><a name='scope'>"._t("Scope and Content")."</a></div><div class='unit'>".$va_scope."</div><!-- end unit -->";
				$va_anchors[] = '<p><a href="#scope">'._t('Scope and Content').'</a></p>';

			}
			if ($t_collection->get('ca_collections.Access_restrictions') | $t_collection->get('ca_collections.material_boxes') | $t_collection->get("ca_list_items")) {
				print "<div class='header'><a name='admin'>"._t('Administrative Information')."</a></div>";
				$va_anchors[] = '<p><a href="#admin">'._t('Administrative Information').'</a></p>';	
			}
			# --- access restrictions
			if($va_access = $t_collection->get('ca_collections.Access_restrictions')){
				print "<div class='unit'><span class='unitTitle'>"._t("Access Restrictions")."</span>: ".$va_access."</div><!-- end unit -->";
			}	
			# --- materials
			if($va_materials = $t_collection->get('ca_collections.material_boxes', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><span class='unitTitle'>"._t("Types of Materials")."</span>: ".$va_materials."</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_collection->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='unit'><span class='unitTitle'>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "").": </span>";
				$subjects = array();
				foreach($va_terms as $va_term_info){
					$subjects[] = caNavLink($this->request, ucfirst($va_term_info['label']), '', '', 'Search', 'Index', array('search' => $va_term_info['name_singular']));
				}
				print join(', ', $subjects);
				print "</div><!-- end unit -->";
			}
			if ($va_lcshs = $t_collection->get('ca_collections.lcsh_terms', array('returnAsArray' => true, 'delimiter' => '<br/>'))) {
				print "<div class='unit'><span class='unitTitle'>"._t("Subjects").((sizeof($va_terms) > 1) ? "s" : "")." </span><br/>";
				foreach ($va_lcshs as $va_lcshst) {
					foreach ($va_lcshst as $va_lcsh) {
						$va_lcsh_short = explode(" [",$va_lcsh);
						$va_lcsh_shorter = preg_replace("![^\w\d]+!", "+", $va_lcsh_short[0]);
				 		print caNavLink($this->request, $va_lcsh, '', '', 'Search', 'Index', array('search' => urlencode($va_lcsh_shorter)))."<br/>";
				 	}
				 }
				print "</div>";
			}
			# --- occurrences
			$va_occurrences = $t_collection->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
						<div class="unit"><span class='unitTitle'><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></span>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";				
					}
					print "</div><!-- end unit -->";
				}
			}						
			if ($va_parent = $t_collection->get('ca_collections.parent.preferred_labels')){
				$va_parent_id = $t_collection->get('ca_collections.parent_id');
				print "<div class='header'><a name='parent'>"._t("Parent Collection")."</a></div><div class='unit'>".caNavLink($this->request, $va_parent, '', 'FindingAids', 'Collection', 'Show', array('collection_id' => $va_parent_id))."</div><!-- end unit -->";				
				$va_anchors[] = '<p><a href="#parent">'._t("Parent Collection").'</a></p>';

			}					
			# --- attributes
			$va_attributes = $this->request->config->get('ca_collections_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_collection->get("ca_collections.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$t_collection->getDisplayLabel("ca_collections.{$vs_attribute_code}").":</b> {$vs_value}</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_collections_description_attribute')){
				if($vs_description_text = $t_collection->get("ca_collections.".$this->request->config->get('ca_collections_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_collection->getDisplayLabel("ca_collections.".$this->request->config->get('ca_collections_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
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
			

			# --- places
			$va_places = $t_collection->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				print "<div class='unit'><h2>"._t("Related Place").((sizeof($va_places) > 1) ? "s" : "")."</h2>";
				foreach($va_places as $va_place_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".$va_place_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			if ($va_contents = $t_collection->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', 'returnAsLink' => true, "sort" => "preferred_labels.name"))) {
				print "<div class='header'><a name='contents'>".unicode_ucfirst($t_collection->getTypeName())." "._t('Contents')."</a></div>";
				$va_anchors[] = '<p><a href="#contents">'.unicode_ucfirst($t_collection->getTypeName())." "._t('Contents').'</a></p>';

				print "<div class='unit'>".$va_contents."</div>";
			}
			# --- collections
			$va_collections = $t_collection->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, "sort" => "preferred_labels.name"));
			if(sizeof($va_collections) > 0){
				print "<div class='header'><a name='relcollection'>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</a></div><div class='unit'>";
				$va_anchors[] = '<p><a href="#relcollection">'._t('Related Collection').'</a></p>';

				foreach($va_collections as $va_collection_info){

					print "<div class='col'>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'FindingAids', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label']);
					print "</div>";
					#$va_collection_id = $va_collection_info['collection_id'];
					#$t_collection = new ca_collections($va_collection_id);
					#print "<div class='subCol'>".$t_collection->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', 'returnAsLink' => true, "sort" => "preferred_labels.name"))."</div>";
					#print "<div style='height:15px;width:100%;'></div>";
				}
				print "</div><!-- end unit -->";
			}
		
			
?>
	</div><!-- end leftCol -->
	<div id="rightCol" class="promo-block">
	<div class="shadow"></div>

<?php 
	foreach ($va_anchors as $link) {
	print $link;
	}	
?>	
	</div>		
<!-- 	<div id="rightCol">
		<div id="resultBox">
<?php
		// set parameters for paging controls view
#		$this->setVar('other_paging_parameters', array(
#			'collection_id' => $vn_collection_id
#		));
#		print $this->render('related_objects_grid.php');
?>
		</div>


	</div>end rightCol -->
</div><!-- end detailBody -->
