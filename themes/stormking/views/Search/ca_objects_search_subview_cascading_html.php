<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$qr_results 		= $this->getVar('result');
	$va_block_info 		= $this->getVar('blockInfo');
	$vs_block 			= $this->getVar('block');
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block 	= (int)$this->getVar('itemsPerPage');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = caGetSearchConfig();
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>";
	
	$vn_col_span = 4;
	$vn_col_span_sm = 4;
	$vb_refine = false;
	if(is_array($va_facets) && sizeof($va_facets)){
		$vb_refine = true;
		$vn_col_span = 4;
		$vn_col_span_sm = 6;
		$vn_col_span_xs = 12;
	}

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?></span> | 
<?php
				}
?>
				
				<!--<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}-->
			</small>
			<H3><?php print $va_block_info['displayName']."&nbsp;&nbsp;<span class='highlight'>(".$qr_results->numHits().")</span>"; ?></H3>
			<div class="row"><div id='browseResultsContainer'>
<?php
		}
		$vn_count = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
			$vn_id = $qr_results->get("ca_objects.object_id");
			$vs_record_title = $qr_results->get("ca_objects.preferred_labels");		
			$vs_idno_detail_link 	= caDetailLink($this->request, $qr_results->get("ca_objects.idno"), '', 'ca_objects', $vn_id);
			$vs_label_detail_link 	= caDetailLink($this->request, $vs_record_title, '', 'ca_objects', $vn_id);
			$vs_thumbnail = "";
			$vs_type_placeholder = "";
			$vs_typecode = "";
			$t_list_item->load($qr_results->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
			if(!($vs_thumbnail = $qr_results->get('ca_object_representations.media.widepreview', array("checkAccess" => $va_access_values)))){
				
				$vs_thumbnail = $vs_default_placeholder_tag;

			}
			if ($vs_artist = $qr_results->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'delimiter' => ', '))) {
				$vs_artist_text = $vs_artist."<br/>";
			} else {
				$vs_artist_text = null;
			}
			if ($vs_art_date = $qr_results->get('ca_objects.display_date')) {
				$vs_date_text = ", ".$vs_art_date ;
			} else {
				$vs_date_text = null;
			}
			if (($vs_typecode != "archival") && ($vs_record_title != "Untitled")) {
				$vs_style = "style='font-style:italic';";
			} else {
				$vs_style = "";
			}
			/*$t_list = new ca_lists();
			$vn_object_type_id = $t_list->getItemIDFromList("object_types", "archival");
			if ($qr_results->get('ca_objects.type_id') == $vn_object_type_id) {
				$vs_entity_date_text = "<p>".$qr_results->get('ca_objects.idno')."</p>";
			}
			*/
			$vs_info = null;
			$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				
		
			$vs_add_to_set_link = "";
			if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
				$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
			}
			$vs_expanded_info = $qr_results->getWithTemplate($vs_extended_info_template);

			print "
<div class='bResultItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
	<div class='bResultItem' id='row{$vn_id}'>
		<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
		<div class='bResultItemContent'>
			<div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
			
		</div><!-- end bResultItemContent -->
		<div class='bResultItemText'><div class='bResultItemTextInner'>
			{$vs_artist_text}<span {$vs_style}>{$vs_label_detail_link}</span>{$vs_date_text}{$vs_entity_date_text}
		</div></div><!-- end bResultItemText -->
	</div><!-- end bResultItem -->
</div><!-- end col -->";
		
	
			$vn_count++;
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
		print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $this->getVar("cacheKey"), 'block' => $vs_block, 'search'=> $vs_search));
		
		if (!$this->request->isAjax()) {
?>
					</div><!-- end browseResultsContainer --></div><!-- end row-->
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 60,
			nextSelector: 'a.jscroll-next'
		});
	});

</script><?php
		}
	}
	
?>