<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/search_secondary_results/ca_occurrences_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source occurrences management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
	
	if ($this->request->config->get('do_secondary_search_for_ca_occurrences')) {
		$qr_occurrences = $this->getVar('secondary_search_ca_occurrences');
		if (($vn_num_hits = $qr_occurrences->numHits()) > 0) {
			$vn_num_hits_per_page 	= $this->getVar('secondaryItemsPerPage');
			$vn_page 				= $this->getVar('page_ca_occurrences');
			
?>
			<div class="searchSec" id="occurrencesSecondaryResults">
<?php
			
?>
				<h1><?php print _t('Occurrences'); ?></h1>
				<div class="searchSecNav">
<?php
					if ($vn_num_hits > $vn_num_hits_per_page) {
						print "<div class='nav'>";
						if ($vn_page > 0) {
							print "<a href='#' onclick='jQuery(\"#occurrencesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page - 1, 'type' => 'ca_occurrences'))."\"); return false;'>&lsaquo; "._t("Previous")."</a>";
						}
						if (($vn_page > 0) && ($vn_page < (ceil($vn_num_hits/$vn_num_hits_per_page) - 1))) {
							print " | ";
						}
						if ($vn_page < (ceil($vn_num_hits/$vn_num_hits_per_page) - 1)) {
							print "<a href='#' onclick='jQuery(\"#occurrencesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page + 1, 'type' => 'ca_occurrences'))."\"); return false;'>"._t("Next")." &rsaquo;</a>";
						}
						print "</div><!-- end nav -->\n";
					}
					
					print _t("Your search found %1 %2.", $qr_occurrences->numHits(), ($qr_occurrences->numHits() == 1) ? _t('result') : _t('results'));
?>
				</div><!-- end searchSecNav -->
				<div class="results">
<?php
					$vn_c = 0;
					$vb_link_to_occurrence_detail = (int)$this->request->config->get('allow_detail_for_ca_occurrences') ? true : false;
					while($qr_occurrences->nextHit()) {
						$vs_name = join('; ', $qr_occurrences->getDisplayLabels($this->request));
						
						if ($vb_link_to_occurrence_detail) {
							print caNavLink($this->request, $vs_name, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $qr_occurrences->get("occurrence_id")));
						} else {
							print caNavLink($this->request, $vs_name, '', '', 'Search', 'Index', array('search' => $vs_name));
						}
						
						print "<br/>\n";
						$vn_c++;
						
						if ($vn_c >= $vn_num_hits_per_page) { break; }
					}
?>
				</div><!-- end results -->
<?php
			
?>
			</div><div class="searchSecSpacer">&nbsp;</div>
<?php
			
			
		}
	}
?>