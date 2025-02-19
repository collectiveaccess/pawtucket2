<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_entities_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2025 Whirl-i-Gig
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
$block_info 		= $this->getVar('blockInfo');
$block 				= $this->getVar('block');
$num_items_to_show 	= (int)$this->getVar('numItemsToShow');
$has_more 			= (bool)$this->getVar('hasMore');
$search 			= (string)$this->getVar('search');
$o_config 			= $this->getVar("config");
$o_browse_config 	= caGetBrowseConfig();
$browse_types 		= array_keys($o_browse_config->get("browseTypes"));
$caption_template	= $this->getVar('resultCaption');
$access_values 		= caGetUserAccessValues($this->request);

if ($qr_results->numHits() > 0) {
	$i = 0;
?>
	<dl class='row'><dt class='col-12 mt-3 mb-2 text-capitalize'><?= $qr_results->numHits()." ".(($qr_results->numHits() == 1) ? $block_info["labelSingular"] : $block_info["labelPlural"]); ?></dt>
<?php
	while($qr_results->nextHit()) {
?>
		<dd class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>
			<?= $qr_results->getWithTemplate($caption_template, array("checkAccess" => $access_values)); ?>
		</dd>
<?php
		$i++;
		if($i == $num_items_to_show){
			if($qr_results->numHits() > $num_items_to_show) {
?>
				<dd class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>
					<?= caNavLink($this->request, _t("Full Results")."  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-dark h-100 w-100 text-white", "", "Search", $block, ["search" => $search], [], ['encodeSlashesInParams'=> true]); ?>
				</dd>
<?php
			}
			break;
		}
	}
?>
	</dl>
<?php
}