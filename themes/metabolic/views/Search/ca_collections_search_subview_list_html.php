<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_collections_search_subview_html.php : 
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
	
	if ($qr_results->numHits() > 0) {
?>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12 col-md-6">
<?php
		if(in_array($vs_block, $va_browse_types)){
			print '<H2>'.caNavLink($va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Search', '{{{block}}}', array('search' => $vs_search)).'</H2>';
		}else{
?>
			<H2><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H2>
<?php
		}
?>
					</div>
					<div class="col-sm-12 col-md-6 text-right">
<?php
		if(in_array($vs_block, $va_browse_types)){
			print caNavLink('<span class="glyphicon glyphicon-list"></span> '._t('Full results'), 'btn btn-primary', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search)));
		}
?>
					</div>
				</div>
<?php
		$vn_count = 0;
		$vn_col_count = 0;
?>
				<div class="row {{{block}}}Set multiSearchList">
<?php
		$va_block_info["resultTemplate"];
		while($qr_results->nextHit()) {
			if ($vn_col_count == 0) { 
				print "<div class='col-sm-12 col-md-3 col-lg-2'>";
			}
			print "<div class='multiSearchListResult py-2 my-2'>".$qr_results->getWithTemplate($va_block_info["resultTemplate"], array('returnAsLink' => true))."</div>";
			$vn_count++;
			$vn_col_count++;
			if ($vn_col_count == $vn_items_per_column) {
				print "</div><!-- end col -->\n";
				$vn_col_count = 0;
			}
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
		
		if ($vn_col_count < $vn_items_per_column) {
			print "</div><!-- end Col -->";		// closing div if we stop short of a full col
		}
		
?>
				</div>
			</div>
		</div>
<?php
	}
?>
