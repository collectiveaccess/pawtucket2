<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_collections_search_subview_html.php : 
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
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'>".$vs_default_placeholder."</div>";
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);


	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list" role="button" aria-label="list icon"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?></span> 
<?php
				}
				if($x){
?>
				
				<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}
<?php
				}
?>
			</small>
			<H2><?php print caNavLink($this->request, $va_block_info['displayName']."&nbsp;&nbsp;<span class='highlight'>(".$qr_results->numHits().")</span>", '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search), 'facet' => 'has_media_facet', 'id' => 1)); ?></H2>
			<div id='browseResultsContainer'>
<?php
		}
		$vn_count = 0;
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
				$vn_id 					= $qr_results->get("ca_collections.collection_id");
				$vs_date = $qr_results->getWithTemplate("<ifdef code='ca_collections.display_date'>^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>");

				$vs_label_detail_link 	= caDetailLink($this->request, $qr_results->get("ca_collections.preferred_labels.name").(($vs_date) ? ", ".$vs_date : ""), '', 'ca_collections', $vn_id);
				
				$vs_thumbnail = "";
				if(!($vs_thumbnail = $qr_results->getMediaTag('ca_object_representations.media', 'small', array("checkAccess" => $va_access_values)))){
					$vs_thumbnail = $vs_default_placeholder_tag;
				}
				
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_collections', $vn_id);
				$vs_multiple_media = '';
				if($qr_results->getWithTemplate("<unit relativeTo='ca_object_representations' filterNonPrimaryRepresentations='0' length='1'>^count</unit>", array("checkAccess" => $va_access_values)) > 1){
					$vs_multiple_media = '<div class="multipleMediaIcon"><i class="fa fa-files-o" aria-hidden="true" title="multiple media"></i></div>';
				}
				$vs_rep_id = $qr_results->get("ca_object_representations.representation_id");
				
				#$vs_parent_path = $qr_results->getWithTemplate("<unit relativeTo='ca_collections.parent'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></unit></unit>");
				#if($vs_parent_path){
				#	$vs_parent_path .= " ><br/>";
				#}
				#$vs_tmp = $qr_results->getWithTemplate("<l>".$vs_parent_path."<b>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></b></l>", array('returnAsLink' => true));

				print "
	<div class='bResultItemCol col-xs-12 col-sm-3 col-lg-2'>
		<div class='bResultItem'>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_multiple_media}{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>
					<div class='objectTitle'>{$vs_label_detail_link}</div>".$vs_tmp."
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
				

			$vn_count++;
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
		print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $this->getVar("cacheKey"), 'block' => $vs_block, 'search'=> $vs_search));
		
		if (!$this->request->isAjax()) {
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