<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_detail_list_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$q_set_items = $this->getVar("result");
	$t_set = $this->getVar("set");
	$vb_write_access = $this->getVar("write_access");
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	$vn_object_table_num = $this->request->datamodel->getTableNum("ca_objects");
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
?>
			<div class="row" id="sortable">
<?php
	if($q_set_items->numHits()){
		$vn_c = 0;
		while($q_set_items->nextHit() && ($vn_c < $vn_hits_per_block)){
			$t_set_item = new ca_set_items(array("row_id" => $q_set_items->get("object_id"), "set_id" => $t_set->get("set_id"), "table_num" => $vn_object_table_num));
			if($t_set_item->get("item_id")){
				$vs_rep = $vs_caption = $vs_label_artist = $vs_label_detail_link = $vs_idno_detail_link = $vs_art_idno_link = $vs_library_info = "";
				$vn_id = $q_set_items->get("ca_objects.object_id");
				if ($q_set_items->get('ca_objects.type_id') == 30) {
					# --- library - book
					$vs_label_author	 	= "<p class='artist'>".caNavLink($this->request, $q_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname')), '', '', 'Detail', 'library/'.$vn_id)."</p>";
					$vs_label_detail 	= "<p style='text-decoration:underline;'>".caNavLink($this->request, $q_set_items->get("ca_objects.preferred_labels.name"), '', '', 'Detail', 'library/'.$vn_id)."</p>";
					$vs_label_pub 	= "<p>".$q_set_items->get("ca_objects.publication_description")."</p>";
					$vs_label_call 	= "<p>".$q_set_items->get("ca_objects.call_number")."</p>";
					$vs_label_status 	= "<p>".$q_set_items->get("ca_objects.purchase_status")."</p>";
					$vs_idno_detail_link 	= "";
					$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;
				} elseif ($q_set_items->get('ca_objects.type_id') == 1903) {
					# --- library - copy
					$vs_label_author	 	= "<p class='artist'>".caNavLink($this->request, $q_set_items->get("ca_entities.parent.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.parent.preferred_labels.forename ^ca_entities.parent.preferred_labels.middlename ^ca_entities.parent.preferred_labels.surname')), '', '', 'Detail', 'library/'.$q_set_items->get('ca_objects.parent_id'))."</p>";
					$vs_label_detail 	= "<p style='text-decoration:underline;'>".caNavLink($this->request, $q_set_items->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'library/'.$q_set_items->get('ca_objects.parent_id'))."</p>";

					$vs_label_pub 	= "<p>".$q_set_items->get("ca_objects.parent.publication_description")."</p>";
					$vs_label_call 	= "<p>".$q_set_items->get("ca_objects.parent.call_number")."</p>";
					$vs_label_status 	= "<p>".$q_set_items->get("ca_objects.parent.purchase_status", array('convertCodesToDisplayText' => true))."</p>";
					$vs_idno_detail_link 	= "";
					$vs_label_detail_link = "";
					$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;
				} elseif ($q_set_items->get('ca_objects.type_id') == 28) {
					# --- artwork
					$vs_label_artist	 	= "<p class='artist lower'>".$q_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
					$vs_label_detail_link 	= "<p><i>".$q_set_items->get("ca_objects.preferred_labels.name")."</i>, ".$q_set_items->get("ca_objects.creation_date")."</p>";
					if ($q_set_items->get('is_deaccessioned') && ($q_set_items->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
						$vs_idno_detail_link = "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $q_set_items->get('deaccession_date'))."</div>\n";
					} else {
						$vs_idno_detail_link = "";
					}
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new")  || $this->request->user->hasUserRole("library_new")){
						$vs_art_idno_link = "<p class='idno'>".$q_set_items->get("ca_objects.idno")."</p>";
					} else {
						$vs_art_idno_link = "";
					}				
				}else {
					# --- archive
					#$vs_label_artist	 	= "<p class='artist lower'>".$q_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
					if ($q_set_items->get('ca_objects.dc_date.dc_dates_value')) {
						$vs_date_link = "<p>".$q_set_items->get('ca_objects.dc_date', array('returnAsLink' => true, 'delimiter' => '; ', 'template' => '^dc_dates_value'))."</p>";
					}else {
						$vs_date_link = "";
					}
					if ($q_set_items->get('ca_objects.type_id') == 23 || $q_set_items->get('ca_objects.type_id') == 26 || $q_set_items->get('ca_objects.type_id') == 25 || $q_set_items->get('ca_objects.type_id') == 24 || $q_set_items->get('ca_objects.type_id') == 27){
						$vs_type_link = "<p>".$q_set_items->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</p>";
					} else {
						$vs_type_link = "";
					}
					if ($q_set_items->get('ca_objects.type_id') == 23 || $q_set_items->get('ca_objects.type_id') == 26 || $q_set_items->get('ca_objects.type_id') == 25 || $q_set_items->get('ca_objects.type_id') == 24 || $q_set_items->get('ca_objects.type_id') == 27){
						$va_collection_id = $q_set_items->get('ca_collections.collection_id');
						$t_collection = new ca_collections($va_collection_id);
						$vn_parent_ids = $t_collection->getHierarchyAncestors($va_collection_id, array('idsOnly' => true));
						$vn_highest_level = end($vn_parent_ids);
						$t_top_level = new ca_collections($vn_highest_level);
						$vs_collection_link = "<p>".caNavLink($this->request, $t_top_level->get('ca_collections.preferred_labels'), '', 'Detail', 'collections', $vn_highest_level)."</p>";					
					}					
					$vs_label_detail_link 	= "<p>".caNavLink($this->request, $q_set_items->get("ca_objects.preferred_labels.name"), '', '', 'Detail', 'archives/'.$q_set_items->get('ca_objects.object_id'))."</p>{$vs_collection_link}<p>".$q_set_items->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</p><p>".$q_set_items->get('ca_objects.dc_date', array('returnAsLink' => true, 'delimiter' => '; ', 'template' => '^dc_dates_value'))."</p>";

					#$vs_idno_detail_link 	= "<p class='idno'>".$q_set_items->get("ca_objects.idno")."</p>";
				}				
				$vs_caption = $vs_label_artist.$vs_label_detail_link.$vs_idno_detail_link.$vs_art_idno_link.$vs_library_info;
				
				if ($q_set_items->get('ca_objects.type_id') == 25) {
					$va_icon = "<i class='glyphicon glyphicon-volume-up'></i>";
				} elseif ($q_set_items->get('ca_objects.type_id') == 26){
					$va_icon = "<i class='glyphicon glyphicon-film'></i>";
				} elseif ($q_set_items->get('ca_objects.type_id') == 1903){
					$vn_parent_id = $q_set_items->get('ca_objects.parent_id');
					$t_copy = new ca_objects($vn_parent_id);
				} else {
					$va_icon = "";
				}
				if($va_icon && ($q_set_items->get('ca_objects.type_id') == 25 || !$q_set_items->getMediaTag('ca_object_representations.media', 'icon', array('checkAccess' => $va_access_values)))){
					$va_icon = "<div class='lbSetImgPlaceholder'>".$va_icon."</div>";
				}
				if ($q_set_items->get('ca_objects.type_id') == 1903){
					$vs_rep 	= $va_icon.$t_copy->get('ca_object_representations.media.icon', array('checkAccess' => $va_access_values));				
					#$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon.$t_copy->get('ca_object_representations.media.icon', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_parent_id);				
				} elseif ($q_set_items->get('ca_objects.type_id') == 25) {
					$vs_rep 	= $va_icon;										
					#$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon, '', $vs_table, $vn_id);										
				} else {
					$vs_rep 	= $va_icon.$q_set_items->getMediaTag('ca_object_representations.media', 'icon', array('checkAccess' => $va_access_values));				
					#$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon.$q_set_items->getMediaTag('ca_object_representations.media', 'icon', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_id);				
				}
				print "<div class='col-xs-12 col-sm-4 lbItem".$t_set_item->get("item_id")."' id='row-".$q_set_items->get("object_id")."'><div class='lbItemContainerList'>";
				print caLightboxSetDetailItem($this->request, (($q_set_items->get('ca_objects.type_id') == 1903) ? $t_copy : $q_set_items), $t_set_item, array("write_access" => $vb_write_access, "view" => "list", "caption" => $vs_caption, "representation" => $vs_rep));
				print "</div></div><!-- end col 3 -->";
			}
			$vn_c++;
		}
	}else{
		print "<div class='col-sm-12'>"._t("There are no items in this %1", $vs_lightbox_displayname)."</div>";
	}
?>
			</div><!-- end row -->
<?php
if($vb_write_access){
?>
	<script type='text/javascript'>
		 jQuery(document).ready(function() {
			 jQuery(".lbItemDeleteButton").click(
				function() {
					var id = this.id.replace('lbItemDelete', '');
					jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Lightbox', 'AjaxDeleteItem'); ?>', {'set_id': '<?php print $t_set->get("set_id"); ?>', 'item_id':id} , function(data) { 
						if(data.status == 'ok') { 
							jQuery('.lbItem' + data.item_id).fadeOut(500, function() { jQuery('.lbItem' + data.item_id).remove(); });
						} else {
							alert('Error: ' + data.errors.join(';')); 
						}
					});
					return false;
				}
			);
		 
			$("#sortable").sortable({ 
				cursor: "move",
				opacity: 0.8,
				helper: 'clone',
  				appendTo: 'body',
 				zIndex: 10000,
				update: function( event, ui ) {
					var data = $(this).sortable('serialize');
					// POST to server using $.post or $.ajax
					$.ajax({
						type: 'POST',
						url: '<?php print caNavUrl($this->request, "", "Lightbox", "AjaxReorderItems"); ?>/row_ids/' + data
					});
				}
			});
			//$("#sortable").disableSelection();
		});
	</script>
<?php
}
?>