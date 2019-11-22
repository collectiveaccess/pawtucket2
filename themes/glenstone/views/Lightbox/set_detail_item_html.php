<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_detail_item_html.php :
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
 
    $vb_write_access = $this->getVar('write_access');
    $vs_view = $this->getVar('view');
    $vn_item_id = $this->getVar('item_id');
    $vn_set_id = $this->getVar('set_id');
    $vn_object_id = $this->getVar('object_id');

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
    
    $qr_set_items = $this->getVar('qr_set_items');
    # --- Glenstone specific caption
    if ($qr_set_items) {
		$vn_id = $qr_set_items->get('ca_objects.object_id');
		$vs_rep = $vs_caption = $vs_label_artist = $vs_label_detail_link = $vs_date_link = $vs_art_idno_link = $vs_library_info = $vs_collection_link = $vs_type_link = "";
		if ($qr_set_items->get('ca_objects.type_id') == 30) {
			# --- library --- book
			$vs_label_author	 	= "<p class='artist'>".$qr_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname'))."</p>";
			$vs_label_detail 	= "<p style='text-decoration:underline;'>".caDetailLink($this->request, $qr_set_items->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id)."</p>";

			$vs_label_pub 	= "<p>".$qr_set_items->get("ca_objects.publication_description")."</p>";
			$vs_label_call 	= "<p>".$qr_set_items->get("ca_objects.call_number")."</p>";
			$vs_label_status 	= "<p>".$qr_set_items->get("ca_objects.purchase_status", array('convertCodesToDisplayText' => true))."</p>";
			$vs_idno_detail_link 	= "";
			$vs_label_detail_link = "";
			$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;
		} elseif ($qr_set_items->get('ca_objects.type_id') == 1903) {
			# --- library - copy
			$vs_label_author	 	= "<p class='artist'>".$qr_set_items->get("ca_entities.parent.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.parent.preferred_labels.forename ^ca_entities.parent.preferred_labels.middlename ^ca_entities.parent.preferred_labels.surname'))."</p>";
			$vs_label_detail 	= "<p style='text-decoration:underline;'>".$qr_set_items->get("ca_objects.parent.preferred_labels.name")."</p>";

			$vs_label_pub 	= "<p>".$qr_set_items->get("ca_objects.parent.publication_description")."</p>";
			$vs_label_call 	= "<p>".$qr_set_items->get("ca_objects.parent.call_number")."</p>";
			$vs_label_status 	= "<p>".$qr_set_items->get("ca_objects.parent.purchase_status", array('convertCodesToDisplayText' => true))."</p>";
			$vs_idno_detail_link 	= "";
			$vs_label_detail_link = "";
			$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;				
		} elseif ($qr_set_items->get('ca_objects.type_id') == 28) {
			# --- artwork
			$vs_label_artist	 	= "<p class='artist lower'>".caDetailLink($this->request, $qr_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist')), '', 'ca_objects', $vn_id)."</p>";
			$vs_label_detail_link 	= "<p><i>".caDetailLink($this->request, $qr_set_items->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id)."</i>, ".$qr_set_items->get("ca_objects.creation_date")."</p>";
			if ($qr_set_items->get('is_deaccessioned') && ($qr_set_items->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
				$vs_deaccessioned = "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $qr_set_items->get('deaccession_date'))."</div>\n";
			} else {
				$vs_deaccessioned = "";
			}
			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_advanced") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new")  || $this->request->user->hasUserRole("library_new")){
				$vs_art_idno_link = "<p class='idno'>".$qr_set_items->get("ca_objects.idno")."</p>";
			} else {
				$vs_art_idno_link = "";
			}
		}else {
			#$vs_label_artist	 	= "<p class='artist lower'>".$qr_set_items->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
			$vs_label_detail_link 	= "<p>".caDetailLink($this->request, $qr_set_items->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id)."</p>";
			$vs_idno_detail_link 	= "<p class='idno'>".$qr_set_items->get("ca_objects.idno")."</p>";
			if ($qr_set_items->get('ca_objects.dc_date.dc_dates_value')) {
				$vs_date_link = "<p>".$qr_set_items->get('ca_objects.dc_date', array('returnAsLink' => true, 'delimiter' => '; ', 'template' => '^dc_dates_value'))."</p>";
			}else {
				$vs_date_link = "";
			}
			if ($qr_set_items->get('ca_objects.type_id') == 23 || $qr_set_items->get('ca_objects.type_id') == 26 || $qr_set_items->get('ca_objects.type_id') == 25 || $qr_set_items->get('ca_objects.type_id') == 24 || $qr_set_items->get('ca_objects.type_id') == 27){
				$vs_type_link = "<p>".$qr_set_items->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</p>";
			} else {
				$vs_type_link = "";
			}
			if ($qr_set_items->get('ca_objects.type_id') == 23 || $qr_set_items->get('ca_objects.type_id') == 26 || $qr_set_items->get('ca_objects.type_id') == 25 || $qr_set_items->get('ca_objects.type_id') == 24 || $qr_set_items->get('ca_objects.type_id') == 27){
				$va_collection_id = $qr_set_items->get('ca_collections.collection_id');
				$t_collection = new ca_collections($va_collection_id);
				$vn_parent_ids = $t_collection->getHierarchyAncestors($va_collection_id, array('idsOnly' => true));
				$vn_highest_level = end($vn_parent_ids);
				$t_top_level = new ca_collections($vn_highest_level);
				$vs_collection_link = "<p>".caNavLink($this->request, $t_top_level->get('ca_collections.preferred_labels'), '', 'Detail', 'collections', $vn_highest_level)."</p>";					
			}					
		}
		$vs_caption = $vs_label_artist.$vs_label_detail_link.$vs_collection_link.$vs_type_link.$vs_date_link.$vs_art_idno_link.$vs_library_info.$vs_deaccessioned;
		
		
		
		if ($qr_set_items->get('ca_objects.type_id') == 25) {
			$vs_icon = "<i class='glyphicon glyphicon-volume-up'></i>";
		} elseif ($qr_set_items->get('ca_objects.type_id') == 26){
			$vs_icon = "<i class='glyphicon glyphicon-film'></i>";
		} elseif ($qr_set_items->get('ca_objects.type_id') == 1903){
			$vn_parent_id = $qr_set_items->get('ca_objects.parent_id');
			$t_copy = new ca_objects($vn_parent_id);
		} else {
			$vs_icon = "";
		}
		if($vs_icon && ($qr_set_items->get('ca_objects.type_id') == 25 || !$qr_set_items->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)))){
			$vs_icon = "<div class='lbSetImgPlaceholder'>".$vs_icon."</div>";
		}
		if ($qr_set_items->get('ca_objects.type_id') == 1903){
			$vs_rep 	= $vs_icon.$t_copy->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values));				
			#$vs_rep_detail_link 	= caDetailLink($this->request, $vs_icon.$t_copy->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_parent_id);				
		} elseif ($qr_set_items->get('ca_objects.type_id') == 25) {
			$vs_rep 	= $vs_icon;										
			#$vs_rep_detail_link 	= caDetailLink($this->request, $vs_icon, '', $vs_table, $vn_id);										
		} else {
			$vs_rep 	= $vs_icon.$qr_set_items->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values));				
			#$vs_rep_detail_link 	= caDetailLink($this->request, $vs_icon.$qr_set_items->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_id);				
		}
	}
?>

<div class='lbItem'>
	<div class='lbItemContent'>
		<div class="lbItemImg"><?php print $vs_rep; ?></div>
		<div id='comment{{{item_id}}}' class='lbSetItemComment'><!-- load comments here --></div>
		<div class='caption'><?php print $vs_caption; ?></div>
	</div><!-- end lbItemContent -->
	<div class='lbExpandedInfo' id='lbExpandedInfo{{{item_id}}}'><hr/>
<?php
		if($vb_write_access) {
?>
		   <div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><span class='glyphicon glyphicon-trash'></span></a></div>
<?php
		}
?>
		<div>
			<?php print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?>
<?php
			if($vn_representation_id){
				print "&nbsp;&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail/artworks', 'GetMediaOverlay', array('context' => 'artworks', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
?>
			&nbsp;&nbsp;<a href='#' title='Comments' onclick='jQuery(".lbSetItemComment").hide(); jQuery("#comment{{{item_id}}}").load("<?php print caNavUrl($this->request, '', '*', 'AjaxListComments', array()); ?>", {item_id: <?php print (int)$vn_item_id; ?>, type: "ca_set_items", set_id: <?php print (int)$vn_set_id; ?>}, function(){jQuery("#comment{{{item_id}}}").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small id="lbSetCommentCount{{{item_id}}}">{{{commentCount}}}</small></a>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->
