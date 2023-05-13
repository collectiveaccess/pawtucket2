<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_search_cascading_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
	$va_options 		= $va_block_info["options"];
	$vs_block 			= $this->getVar('block');
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block 	= (int)$this->getVar('itemsPerPage');
	$vn_items_per_column = (int)$this->getVar('itemsPerColumn');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values = caGetUserAccessValues();
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$o_config = caGetSearchConfig();
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	
	if ($qr_results->numHits() > 0) {
?>
				<div class="row mb-2">
					<div class="col-sm-12 col-md-12">
<?php
		if(in_array($vs_block, $va_browse_types)){
			print '<H2>'.caNavLink('<span>'.$qr_results->numHits().' '.(($qr_results->numHits() == 1) ? $va_block_info['labelSingular'] : $va_block_info['labelPlural']).' </span><ion-icon name="open"></ion-icon>', '', '', 'Search', '{{{block}}}', array('search' => $vs_search)).'</H2>';
		}else{
?>
			<H2><?php print $qr_results->numHits().' '.(($qr_results->numHits() == 1) ? $va_block_info['labelSingular'] : $va_block_info['labelPlural']); ?></H2>
<?php
		}
?>
					</div>
				</div>
<?php
		$vn_count = 0;
		$vn_col_count = 0;
?>
	<div class="row {{{block}}}Set multiSearchObjectsCascading">
		<div class='col-sm-12'><div class='card-columns'>
<?php
		$va_block_info["resultTemplate"];
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
			$vn_count++;
			if(!($vs_thumbnail = $qr_results->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => "card-img-top")))){
				$t_list_item->load($qr_results->get("type_id"));
				$vs_typecode = $t_list_item->get("idno");
				if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
					$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
				}else{
					$vs_thumbnail = $vs_default_placeholder_tag;
				}
			}
			$vs_info = null;
			$vs_rep_detail_link 	= caDetailLink($vs_thumbnail, '', $va_block_info["table"], $qr_results->getPrimaryKey());
?>
			<div class='card mb-4'>
				<?php print $vs_rep_detail_link; ?>
				<div class='card-body mb-2'><?php print $qr_results->getWithTemplate($va_block_info["resultTemplate"]); ?></div>
			</div>
<?php					
			if ($vn_count == $vn_hits_per_block) {break;} 
		}
?>
		</div></div>
	</div>
<?php
		if ($qr_results->numHits() > $vn_hits_per_block) {	
?>
	<div class="row">
		<div class="col-12 text-center">
			<?php print caNavLink(_t('Full results').'&nbsp;<ion-icon name="open"></ion-icon>', 'btn btn-primary', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?>
		</div>
	</div>
<?php
		}
	}
?>
