<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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

$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
$va_facets 			= $this->getVar('facets');				// array of available browse facets
$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
$vn_row_id		 	= (int)$this->getVar('row_id');			// id of last visited detail item so can load to and jump to that result - passed in back button
$vb_row_id_loaded 	= false;
if(!$vn_row_id){
	$vb_row_id_loaded = true;
}

$va_views			= $this->getVar('views');
$vs_current_view	= $this->getVar('view');
$va_view_icons		= $this->getVar('viewIcons');
$vs_current_sort	= $this->getVar('sort');

$t_instance			= $this->getVar('t_instance');
$vs_table 			= $this->getVar('table');
$vs_pk				= $this->getVar('primaryKey');
$va_access_values = caGetUserAccessValues($this->request);
$o_config = $this->getVar("config");

#TG added: boolean value set true if page is browsing Collections
$vb_is_collection = ($vs_table=='ca_collections');

$va_options			= $this->getVar('options');
$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

$vb_ajax			= (bool)$this->request->isAjax();


$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

$o_icons_conf = caGetIconsConfig();
$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
	$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
}
$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";


	$vn_col_span = 3;
	$vn_col_span_sm = 4;
	$vn_col_span_xs = 6; # Added by TG to make icons default to always show two across on small screens
	$vb_refine = false;
	if(is_array($va_facets) && sizeof($va_facets)){
		$vb_refine = true;
		$vn_col_span = 3;
		$vn_col_span_sm = 6;
		$vn_col_span_xs = 6;
	}
	if ($vn_start < $qr_res->numHits()) {
		$vn_c = 0;
		$vn_results_output = 0;
		$qr_res->seek($vn_start);

		if ($vs_table != 'ca_objects') {
			$va_ids = array();
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$va_ids[] = $qr_res->get($vs_pk);
				$vn_c++;
			}
			$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));

			$vn_c = 0;
			$qr_res->seek($vn_start);
		}

		$t_list_item = new ca_list_items();
		$rcriteria = $this->getVar('criteria_raw');
		$terms = caExtractTermsForSearch(join(' ', array_keys($rcriteria['_search'] ?? [])), ['metsaltoOnly' => true]);
		$terms = array_map(function($v) {
			$v = preg_replace('!["\']+!', '', $v);
			$v = preg_replace('![^A-Za-z0-9]+[0-9]*!', '', $v);
			return $v;
		}, $terms);
		
		while($qr_res->nextHit()) {
			if($vn_c == $vn_hits_per_block){
				if($vb_row_id_loaded){
					break;
				}else{
					$vn_c = 0;
				}
			}
			$vn_id = $qr_res->get("{$vs_table}.{$vs_pk}");
			if($vn_id == $vn_row_id){
				$vb_row_id_loaded = true;
			}

			# --- check if this result has been cached
			# --- key is MD5 of table, id, list, refine(vb_refine)
			$vs_cache_key = md5($vs_table.$vn_id."images".$vb_refine);
			if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
				print ExternalCache::fetch($vs_cache_key, 'browse_result');
			}else{
				#Added by TG 5/21 to change collection link to browse page (so collection is browsable) and create hover text
				# ---  But if there are sub collections, link to detail page so can see the sub collections
				if ($vb_is_collection){
					# Get hover text
					if ($vs_brief = $qr_res->get("{$vs_table}.brief_description")){
						$vs_hover_text = "data-toggle='popover' data-trigger='hover' data-content='".$vs_brief;
						if ($vs_cover_dates = $qr_res->get("{$vs_table}.date.date_value")) {
							$vs_hover_text .= " (".$vs_cover_dates.")'";
						}else{
							$vs_hover_text .= "'";
						}
					}
				}
				if ($vb_is_collection && !$qr_res->get("ca_collections.children.collection_id")){
					$vs_label_detail_link = caNavLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => $vn_id, "view" => "images"));
					$vs_idno_detail_link 	= caNavLink($this->request, $qr_res->get("{$vs_table}.idno"), "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => $vn_id, "view" => "images"));
				}else{
					$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
					$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				}

				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				$has_anno = '';
				if ($vs_table == 'ca_objects') {
					$type_code = $qr_res->get('ca_objects.type_id', ['convertCodesToIdno' => true]);
					$rep_ids = $qr_res->get('ca_object_representations.representation_id', ['returnAsArray' => true]);
					if($anno_count = ca_user_representation_annotations::find(['representation_id' => ['IN', $rep_ids]], ['returnAs' => 'count'])) {
						if(strToLower($this->request->getAction()) == "publications"){
							$has_anno = caDetailLink($this->request, "<i class='fa fa-clipboard' alt='Has clippings' title='Has clippings'></i> <small>Has Clippings</small>", 'clippingsLink', $vs_table, $vn_id);
						}else{
							$has_anno = "<div style='position: absolute; top: 5px; right: 20px; text-shadow: 0px 0px 5px white;'><i class='fa fa-clipboard fa-2x' alt='Has clippings' title='Has clippings'></i></div>";
						}
					}
					
					if($type_code === 'newspaper') {
						$rep_id = $qr_res->get('ca_object_representations.representation_id');
						$vs_thumbnail = "<img src='/service.php/IIIF/representation:{$rep_id}/full/250,150/0/default.jpg?highlight=".urlencode(join(' ', $terms))."'/>";
					} elseif(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
						$t_list_item->load($qr_res->get("type_id"));
						$vs_typecode = $t_list_item->get("idno");
						if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
							$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
						}else{
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
					}
					$vs_info = null;
					# TG added: use browse link if a collection, otherwise details
					if ($vb_is_collection){
						$vs_rep_detail_link 	= caNavLink($this->request, $vs_thumbnail, "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => $vn_id, "view" => "images"));

					}
					else{
							$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);
					}
				} else {
					if($va_images[$vn_id]){
						$vs_thumbnail = $va_images[$vn_id];
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
					# TG added: use browse link if a collection and there are no sub collections, otherwise details
					if ($vb_is_collection && !$qr_res->get("ca_collections.children.collection_id")){
						$vs_rep_detail_link 	= caNavLink($this->request, $vs_thumbnail, "", "", "Browse", "Objects", array("facet" => "collection_facet", "id" => $vn_id, "view" => "images"));
					}
					else{
							$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);
					}
				}
				$vs_add_to_set_link = "";
				if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
					$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
				}
				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);
				# TG Added to string below: 1) hover text if collection 2) remove collection id
if(strToLower($this->request->getAction()) == "publications"){
				$vs_result_output = "
					<div class='row publicationResult'>
						<div class='col-xs-8 col-sm-7 col-md-5' {$vs_hover_text}>
							<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
							<div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
							<div>{$vs_add_to_set_link}</div>
						</div>
						<div class='col-xs-4 col-sm-5 col-md-7'>
							<div>
								<small>{$vs_idno_detail_link}</small>
								<div class='pubTitle'>{$vs_label_detail_link}</div>
								<div>{$has_anno}</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<hr>
					</div>
				";
}else{
				$vs_result_output = "
	<div class='bResultItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}' {$vs_hover_text}>
		<div class='bResultItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>".(($vs_table=='ca_collections') ? "" : "<small>{$vs_idno_detail_link}</small><br/>")."{$vs_label_detail_link}
				</div><!-- end bResultItemText -->
				{$has_anno}
			</div><!-- end bResultItemContent -->
			<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}{$vs_add_to_set_link}
			</div><!-- bResultItemExpandedInfo -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";

}
				ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
				print $vs_result_output;
				$vs_hover_text = ""; #erase hover text before next round
			}
			$vn_c++;
			$vn_results_output++;
		}

		print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, '_advanced' => $this->getVar('is_advanced') ? 1  : 0));
	}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>
<script>
	jQuery(document).ready(function() {
		$('.bResultItemCol').popover();
	});

</script>
