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
 
	$vb_sortChange		= $this->request->getParameter('sortChange', pInteger);
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
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'>".$vs_default_placeholder."</div>";
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);


	if ($qr_results->numHits() > 0) {
		if ($vb_sortChange || !$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">
<?php
				$vs_sort_icon = "";
				if($this->getVar('sortDirection') == "desc"){
					$vs_sort_icon = '<span class="glyphicon glyphicon-sort-by-attributes-alt" aria-label="list"></span>';
				}else{
					$vs_sort_icon = '<span class="glyphicon glyphicon-sort-by-attributes" aria-label="list"></span>';
				}
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list" aria-label="list"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?></span> 
<?php
				}
?>
				
				 | <span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				<a href="#" id="objects_sort_direction"><?php print $vs_sort_icon; ?></a>
			</small>
			<script type='text/javascript'>
				jQuery(document).ready(function() {			
					$("#objects_sort a").click(function() {
						jQuery("#objectsBlock").load("<?php print caNavUrl($this->request, '', 'MultiSearch', 'index', array('block' => 'objects', 'sortChange' => 1), array('dontURLEncodeParameters' => true)); ?>/objectsSort/" + $(this).attr('rel'));
						return false;
					});
					$("#objects_sort_direction").click(function() {
						jQuery("#objectsBlock").load("<?php print caNavUrl($this->request, '', 'MultiSearch', 'index', array('block' => 'objects', 'objectsSortDirection' => (($this->getVar('sortDirection') == "desc") ? "asc" : "desc" ), 'sortChange' => 1), array('dontURLEncodeParameters' => true)); ?>");
						return false;
					});
				});					
			</script>
			
			<H2><?php print caNavLink($this->request, $va_block_info['displayName']."&nbsp;&nbsp;<span class='highlight'>(".$qr_results->numHits().")</span>", '', '', 'Search', '{{{block}}}', array('search' => $vs_search)); ?></H2>
			<div id='browseResultsContainer'>
<?php
		}
		$vn_count = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
				$vn_id 					= $qr_results->get("ca_objects.object_id");
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_results->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id);
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_results->get("ca_objects.idno"), '', 'ca_objects', $vn_id);
				$vs_link_text = ($qr_results->get("ca_objects.preferred_labels")) ? "<b>Title: </b>".$qr_results->get("ca_objects.preferred_labels") : $qr_results->get("ca_objects.idno");

				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				#$t_list_item->load($qr_results->get("type_id"));
				$t_list_item->load($qr_results->get("instantiationMediaType"));
				$vs_typecode = $t_list_item->get("idno");
				$vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon");
				if(!($vs_thumbnail = $qr_results->getMediaTag('ca_object_representations.media', 'small', array("checkAccess" => $va_access_values)))){
					if($vs_type_placeholder){
						$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
				}
				
				if(!$this->request->getParameter("openResultsInOverlay", pInteger)){
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);
				}else{
					$vs_rep_detail_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'objects', $vn_id, array('overlay' => 1))."\"); return false;'>".$vs_thumbnail."</a>";
				}
				$vs_add_to_set_link = "<div class='addTo'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array('object_id' => $vn_id))."\"); return false;' title='Add to lightbox'><i class='fa fa-suitcase'></i></a></div>";
				
				$vs_rep_id = $qr_results->get("ca_object_representations.representation_id");
				$vs_obj_id = $qr_results->get("ca_objects.object_id");
				$vs_expanded_info = "";
				if($vs_extended_info_template){
					$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);		
				}
				print "
	<div class='bResultItemCol col-xs-12 col-sm-3 col-lg-2'>
		<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>
					<small>{$vs_idno_detail_link}</small><br/>{$vs_label_detail_link}
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
			<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}{$vs_add_to_set_link}
			</div><!-- bResultItemExpandedInfo -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
				

			$vn_count++;
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
		print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $this->getVar("cacheKey"), 'block' => $vs_block, 'search'=> $vs_search));
		
		if ($vb_sortChange || !$this->request->isAjax()) {
?>
					</div><!-- end browseResultsContainer -->

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