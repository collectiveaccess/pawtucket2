<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_entities_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
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
	$vs_block 			= $this->getVar('block');
	$vn_num_items_to_show 	= (int)$this->getVar('numItemsToShow');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$o_config = $this->getVar("config");
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$vs_caption_template = $this->getVar('resultCaption');
	$va_access_values = caGetUserAccessValues($this->request);
	

	if ($qr_results->numHits() > 0) {
		$vn_i = 0;
		print "<dl class='row'><dt class='col-12 mt-3 mb-2 text-capitalize'>".$qr_results->numHits()." ".(($qr_results->numHits() == 1) ? $va_block_info["labelSingular"] : $va_block_info["labelPlural"])."</dt>";
		while($qr_results->nextHit()) {
			print "<dd class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>";
			print $qr_results->getWithTemplate($vs_caption_template, array("checkAccess" => $va_access_values));
			print "</dd>";
			$vn_i++;
			if($vn_i == $vn_num_items_to_show){
				if($qr_results->numHits() > $vn_num_items_to_show){
					print "<dd class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>".caNavLink($this->request, _t("Full Results")."  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-dark h-100 w-100 text-white", "", "Search", $vs_block, array("search" => $vs_search))."</dd>";
				}
				break;
			}
		}
		print "</dl>";
	}
?>