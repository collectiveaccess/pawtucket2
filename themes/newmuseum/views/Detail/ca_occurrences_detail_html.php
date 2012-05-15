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
	$va_related 		= $this->getVar('related');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');
		
	$o_browse 			= $this->getVar('opo_browse');
	$qr_hits 			= $this->getVar('browse_results');

	$t_list = new ca_lists();
			
	

if (!$this->request->isAjax()) {
	// --------------------------------------------------------------------------------
?>
<div id="detailBody">
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
		<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
		<div id="splashBrowsePanelContent">
		
		</div>
	</div>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, 'Detail', 'Occurrence', 'getFacet', array('occurrence_id' => intval($vn_occurrence_id))); ?>'});
	</script>
<?php
	// --------------------------------------------------------------------------------
?>	
	<div id="leftColNarrow">
		<div id="detailTitleLabel"><?php print $t_occurrence->getTypeName(); ?>:</div>
		<div id="detailTitle"><?php print $vs_title; ?></div>
<?php
		if($this->getVar('date_of_creation')){
?>
			<div class="detailTextHeader"><?php print _t("Date"); ?></div><div class="detailText"><?php print $this->getVar('date_of_creation'); ?></div>
<?php
		}
		if($this->getVar('exhibition_type')){
?>
			<div class="detailTextHeader"><?php print _t("Exhibition Type"); ?></div><div class="detailText"><?php print $this->getVar('exhibition_type'); ?></div>
<?php
		}
		# --- place
		if($this->getVar('places')){
			print "<div class='detailTextHeader'>"._t("Location").((sizeof($this->getVar('places') > 1)) ? "s": "")."</div>";
			$t_place = new ca_places();
			foreach($this->getVar('places') as $va_place_info){
				$va_hier = $t_place->getHierarchyAncestors($va_place_info['place_id'], array(
					'additionalTableToJoin' => 'ca_place_labels',
					'additionalTableSelectFields' => array('name'),
					'additionalTableWheres' => array('is_preferred = 1')
				));
				$va_hier = array_reverse($va_hier);
				array_shift($va_hier);
				$va_names = array();
				foreach($va_hier as $vn_i => $va_hier_item) {
					$va_names[] = $va_hier_item['NODE']['name'];
				}
				$vs_hier = join(' &gt; ', $va_names);
				print "<div class='detailText'>".$vs_hier.($vs_hier ? ' &gt; ' : '').$va_place_info['label']."</div>";
			}
		}
		# --- date
		if($vs_date = $t_occurrence->get('ca_occurrences.dates.dates_value')){
			print "<div class='detailTextHeader'>"._t("Date")."</div><div class='detailText'>".$vs_date."</div>";
		}
		# -- description				
		if($vs_description = $t_occurrence->get('ca_occurrences.description_public')){
			print "<div class='detailTextHeader'>"._t("Description")."</div><div class='detailText' id='occDescription'>".$vs_description."</div>";

?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#occDescription').expander({
						slicePoint: 500,
						expandText: '<?php print _t('[more]'); ?>',
						userCollapse: false
					});
				});
			</script>
<?php
		}
		# --- entities
		$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
		# --- occurrences
		$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
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
?>
						<div class="detailTextHeader"><?php print $va_item_types[$vn_occurrence_type_id]['name_singular']; ?></div>
<?php
					
					foreach($va_occurrence_list as $vn_related_occurrence_id => $va_info) {
?>
						<div class="detailText"><?php print caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_related_occurrence_id)); ?>
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
		
		# --- credit
		if($vs_credit = $t_occurrence->get('ca_occurrences.credit_text')){
			print "<div class='detailTextHeader'>"._t("Credit")."</div><div class='detailText'>".$vs_credit."</div>";
		}
		# --- copyright
		if($vs_copyright = $t_occurrence->get('ca_occurrences.copyright_text')){
			print "<div class='detailTextHeader'>"._t("Copyright")."</div><div class='detailText'>".$vs_copyright."</div>";
		}
		# --- identifier
		if($vs_idno = $t_occurrence->get('ca_occurrences.idno')){
			print "<div class='detailTextHeader'>"._t("Identifier")."</div><div class='detailText'>".$vs_idno."</div>";
		}
		# --- store link
			if($vs_store_link = $t_occurrence->get('ca_occurrences.store_link')){
				print "<div class='detailTextHeader'><a href='{$vs_store_link}'>"._t("Buy item from store")."</a></div>";
			}	
				
if (!$this->request->config->get('dont_show_see_also')) {	
	

		
}				

?>
	</div><!-- end leftCol -->
			
	<div id="browseCol">
<?php
		if ($this->getVar('show_browse') && $qr_hits && $qr_hits->numHits() > 0) {
			$va_facets = $o_browse->getInfoForAvailableFacets();
			$va_criteria = $o_browse->getCriteriaWithLabels();
			$va_facet_info = $o_browse->getInfoForFacets();
			
			if ((sizeof($va_criteria) > 0) || (sizeof($va_facets) > 0)) {
	?>
		<div id="detailFilterControlBox">			
				<form>
<?php
						$vn_facet_count = 0;
						$vn_criteria_count = 0;
						foreach($va_criteria as $vs_facet_name => $va_row_ids) {
							$vn_row = 0;
							foreach($va_row_ids as $vn_row_id => $vs_label) {
								$vn_row++;
								if (($vn_facet_count  == 0) && ($vn_row == 1)) { continue; } // skip first row of first facet (occurrence_id)
								$vs_facet_label = (isset($va_facet_info[$vs_facet_name]['label_singular'])) ? unicode_ucfirst($va_facet_info[$vs_facet_name]['label_singular']) : '???';
?>
							<div class='browseBox'>
							<select name="facet_<?php print $vn_facet_count;?>" style="width: 140px;"><option><?php print $vs_facet_label; ?></option></select><br/>
<?php 			
								print "<div class='browsingBy'>{$vs_label}</div>\n";
?>
							</div><!-- end browseBox -->
<?php
								$vn_criteria_count++;
							}
							$vn_facet_count++;
							if(($vn_facet_count > 1) && ($vn_facet_count < sizeof($va_criteria))){
?>
								<div class="browseWith">with</div>
<?php
							}

						}
				
						if (sizeof($va_facets)) { 
							if($vn_criteria_count > 0){
?>
								<div class="browseArrow"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browseArrow.png' width='16' height='24' border='0'></div>
								<div class='browseBox'>
									<?php print $o_browse->getAvailableFacetListAsHTMLSelect('facet', array('id' => 'browseFacetSelect'), array( 'select_message' => _t('Refine Results By...'))); ?>
									<div class="startOver">or <?php print caNavLink($this->request, _t('Start Over'), '', $this->request->getModulePath(), $this->request->getController(), 'clearCriteria', array('occurrence_id' => $vn_occurrence_id)); ?></div>
								</div>
<?php
							}else{
?>
								<div class='browseBox'>
									<?php print $o_browse->getAvailableFacetListAsHTMLSelect('facet', array('id' => 'browseFacetSelect'), array( 'select_message' => _t('Refine Results By...'))); ?>
								</div>
<?php
							}
						}elseif($vn_criteria_count > 0){
?>
								<div class="startOver" style="margin:0px 0px 0px 25px; float:left;"><?php print caNavLink($this->request, _t('Start Over'), '', $this->request->getModulePath(), $this->request->getController(), 'clearCriteria', array('occurrence_id' => $vn_occurrence_id)); ?></div>
<?php						
						}else{
							print "&nbsp;";
						}

?>
				</form>
				<div style="clear:both; height:1px;">&nbsp;</div>
		</div><!-- end detailFilterControlBox -->
<?php
		}
	}
?>
	</div><!-- end browseCol -->
	<div id="rightColWide">
		<div id="resultBox">
<?php
}
		$vn_c = 0;
		$vn_itemc = 0;
		if(sizeof($va_criteria) > 1){
?>
			<div id="resultsTitle">Results For&nbsp;&nbsp;
				<span id="browsingFor">
<?php 
					$vn_c = 0;
					foreach($this->getVar('browse_criteria') as $vs_facet_name => $vs_criteria) {
						if($vn_c){
							print "&nbsp;&nbsp;|&nbsp;&nbsp;";
						}
						print "{$vs_facet_name}: <b>{$vs_criteria}</b>";
						$vn_c = 1;
					}
?>
				</span>
			</div>
<?php
		}
?>
			<table border="0" cellpadding="0px" cellspacing="0px" width="100%">
<?php
			$pn_exhibition_list_item_id = $t_list->getItemIDFromList("date_types", "exhibition");
			$pn_publication_date_list_item_id = $t_list->getItemIDFromList("date_types", "publication");
			$pn_document_type_id = $t_list->getItemIDFromList("object_types", "physical_object");
			$pn_image_type_id = $t_list->getItemIDFromList("object_types", "image");
			$pn_moving_image_type_id = $t_list->getItemIDFromList("object_types", "moving_image");
			
			$vn_c = 0;
			while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
				if ($vn_c == 0) { print "<tr>\n"; }
				$vn_object_id = $qr_hits->get('object_id');
				$va_labels = $qr_hits->getDisplayLabels();
				$vs_caption = "";
				foreach($va_labels as $vs_label){
					#$vs_label = ((unicode_strlen($vs_label) > 26) ?unicode_substr($vs_label, 0, 23)."..." : $vs_label);
					$vs_caption .= $vs_label;
				}
				print "<td align='center' valign='top' style='padding:20px 0px 2px 0px;' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."'>";
				if($qr_hits->get("ca_objects.type_id") == $pn_moving_image_type_id && $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values))){
					print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/videoPlay.png" border="0" width="43" height="43" class="movingImgResult">', '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
				}
				print caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
			
				// Get thumbnail caption
				if (!is_array($va_entities = $qr_hits->get('ca_entity_labels.displayname', array('restrict_to_relationship_types' => 'artist', 'returnAsArray' => true, 'checkAccess' => $va_access_values)))) { $va_entities = array(); }
				if (!is_array($va_all_dates = $qr_hits->get('ca_objects.dates', array('returnAsArray' => true)))) { $va_dates = array(); }
				$va_display_dates = array();
				switch($qr_hits->get("type_id")){
					case $pn_image_type_id:
						# --- show only exhibition date
						foreach($va_all_dates as $vn_i => $va_date_info){
							if($va_date_info['dates_type'] == $pn_exhibition_list_item_id){
								$va_display_dates[] = $va_date_info['dates_value'];
							}
						}
					break;
					# --------------------------------
					case $pn_document_type_id:
						# --- show only publication date
						foreach($va_all_dates as $va_date_info){
							if($va_date_info['dates_type'] == $pn_publication_date_list_item_id){
								$va_display_dates[] = $va_date_info['dates_value'];
							}
						}
					break;
					# --------------------------------
				}
				$this->setVar('object_id', $vn_object_id);
				$this->setVar('caption_title', $vs_caption);
				$this->setVar('caption_entities', $vs_artist_list = join(', ', $va_entities));
				$this->setVar('caption_date_list', $vs_date_list = join(', ', $va_display_dates));
				$this->setVar('caption_object_type', $t_list->getItemFromListForDisplayByItemID('object_types', $qr_hits->get('ca_objects.type_id')));
				
				print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";
	
				
				$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small'));
				$this->setVar('tooltip_title', $vs_caption);
				$this->setVar('tooltip_entities', $vs_artist_list);
				$this->setVar('tooltip_date_list', $vs_date_list);
				$this->setVar('tooltip_description', $qr_hits->get('ca_objects.description_public'));
				TooltipManager::add(
					".searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
				);
					
				$vn_c++;
				$vn_itemc++;
				
				if ($vn_c == 4) {
					print "</tr>\n";
					$vn_c = 0;
				}else{
					print "<td><!-- empty for spacing --></td>";
				}
			}
			if(($vn_c > 0) && ($vn_c < 4)){
				while($vn_c < 4){
					print "<td><!-- empty --></td>\n";
					$vn_c++;
					if($vn_c < 4){
						print "<td><!-- empty for spacing --></td>";
					}
				}
				print "</tr>\n";
			}
?>
			</table>
<?php

			// set parameters for paging controls view
			$this->setVar('other_paging_parameters', array(
				'occurrence_id' => $vn_occurrence_id
			));
			print $this->render('../Results/paging_controls_html.php');
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->


	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>