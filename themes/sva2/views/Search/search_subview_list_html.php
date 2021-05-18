<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/search_subview_list_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
 
	$qr_results = $this->getVar('result');
	$va_block_info = $this->getVar('blockInfo');
	$va_options = $va_block_info["options"];
	$vs_block = $this->getVar('block');
	$vn_start	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block = (int)$this->getVar('itemsPerPage');
	$vn_items_per_column = (int)$this->getVar('itemsPerColumn');
	$vb_has_more = (bool)$this->getVar('hasMore');
	$vs_search = (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values = caGetUserAccessValues();
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$o_config = caGetSearchConfig();
	
	if ($qr_results->numHits() > 0) {
?>
		<div class="sub-list col-12 p-0">
				<?php
					if(in_array($vs_block, $va_browse_types)){
						print '<h2 class="block-heading">'.caNavLink($va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Browse', '{{{block}}}', array('search' => $vs_search)).'</h2><div class="line-border"></div>';
					}else{
				?>
			<h2><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></h2>
				<?php
					}
				?>
		</div>

		<?php
			$vn_count = 0;
			$vn_col_count = 0;
		?>

		<!-- <div class="container-fluid"> -->
			<div class="row justify-content-start row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 multisearch-results col-12 p-0 m-0 {{{block}}}Set">
				<?php
					$va_block_info["resultTemplate"];
					$vs_full_link = caNavLink('<div class="full-results text-center">'._t('Full results').'</div>', '', '', 'Browse', '{{{block}}}', array('search' => str_replace("/", "", $vs_search)));
	
					while($qr_results->nextHit()) {
						$vn_count++;
				?>
						<div class='col card search-item'>
							<?php
								print caDetailLink($qr_results->getWithTemplate($va_block_info["resultTemplate"]), "", $va_block_info["table"], $qr_results->getPrimaryKey());
							?>
						</div>
					<?php					
						if ($vn_count == $vn_hits_per_block) {break;} 
					}
					?>
			</div>
		<!-- </div> -->
		<div class='row justify-content-center col-12 p-0 m-0'><?php print $vs_full_link; ?></div>
<?php
	}
?>
