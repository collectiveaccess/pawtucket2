<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$va_access_values = $this->getVar("access_values");
	
	#
	# --- if there is a set configured to on browse page
	# --- it will be an occurrence set
	#
	$vs_title = "";
	$va_featured_ids = array();
	if($vs_set_code = $this->request->config->get("browse_page_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		$vs_title = $t_set->getLabelForDisplay();
		$vn_shuffle = 0;
		if($this->request->config->get("front_page_set_random")){
			$vn_shuffle = 1;
		}
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			$qr_res = caMakeSearchResult('ca_occurrences', $va_featured_ids);
		}
	}
	if($qr_res && $qr_res->numHits()){
?>
		<div class="row">
			<div class="col-sm-12">
				<div class="browseGrid">
<?php
	if($vs_title){
		print '<div class="featuredTitle">'.$vs_title.'</div><HR/>';
	}

		$i = $vn_col = 0;
		while($qr_res->nextHit()){
				if($vn_col == 0){
					print "<div class='row'>";
				}
				print "<div class='col-sm-6 col-xs-12'>";
				print $qr_res->getWithTemplate("<l><div class='browseGridItem'><div>^ca_occurrences.preferred_labels.name</div></div></l>");
				print "</div>";
				$i++;
				$vn_col++;
				if($vn_col == 2){
					print "</div>";
					$vn_col = 0;
				}
			if($i == 4){
				break;
			}
		}
		if($vn_col > 0){
			print "</div><!-- end row -->";
		}
?>
			</div>
		</div>
	</div>
<?php
		
	}
?>