<?php	
/* ----------------------------------------------------------------------
 * themes/white/views/Results/search_secondary_results/ca_entities_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
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
	
	if ($this->request->config->get('do_secondary_search_for_ca_entities')) {
		$qr_entities = $this->getVar('secondary_search_ca_entities');
		if (($vn_num_hits = $qr_entities->numHits()) > 0) {
			$vn_num_hits_per_page 	= $this->getVar('secondaryItemsPerPage');
			$vn_page 				= $this->getVar('page_ca_entities');
			
			if (!$this->request->isAjax()) {
?>

			<div class="divide" style="margin:5px 0px 10px 0px; clear:both;">&nbsp;</div>
			<div class="searchSecSpacer">&nbsp;</div>
			
			<div class="searchSec" id="entitiesSecondaryResults">
<?php
			}
?>
				<h1>Artists</h1>
				<div class="searchSecNav">
<?php
					print "<div class='nav'></div><!-- end nav -->";
					print _t("(%1 results found)", $qr_entities->numHits());
					
					if ($vn_page > 0) {
						print "<a href='#' onclick='jQuery(\"#entitiesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page - 1, 'type' => 'ca_entities'))."\"); return false;'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a>";
					}
					if (($vn_page > 0) && ($vn_page < (ceil($vn_num_hits/$vn_num_hits_per_page) - 1))) {
						print " | ";
					}
					if ($vn_page < (ceil($vn_num_hits/$vn_num_hits_per_page) - 1)) {
						print "<a href='#' onclick='jQuery(\"#entitiesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page + 1, 'type' => 'ca_entities'))."\"); return false;'>"._t("Next")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a>";
					}
?>
				</div><!-- end searchSecNav -->
				<div class="results">
<?php	
					$vn_c = 0;
					$vb_link_to_entity_detail = (int)$this->request->config->get('allow_detail_for_ca_entities') ? true : false;
					while($qr_entities->nextHit()) {
						$vs_name = join('; ', $qr_entities->getDisplayLabels($this->request));
						if ($vb_link_to_entity_detail) { 
							print caNavLink($this->request, $vs_name, '', 'Detail', 'Entity', 'Show', array('entity_id' => $qr_entities->get("entity_id")));
						} else {
							print caNavLink($this->request, $vs_name, '', '', 'Search', 'Index', array('search' => '"'.$vs_name.'"'));
						}
						print "<br/>\n";
						$vn_c++;
						
						if ($vn_c >= $vn_num_hits_per_page) { break; }
					}
?>
				</div><!-- end results -->
<?php
	if (!$this->request->isAjax()) {
?>
			</div>
<?php
	}
?>
<?php
		}
	}
?>