<?php
/* ----------------------------------------------------------------------
 * views/Browse/list_facet_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	# -----------------------------------------------------------
	# --- facet view for group_mode = alphabetical, none
	# -----------------------------------------------------------

	$va_facet_content = 	$this->getVar('facet_content');
	$vs_facet_name = 		$this->getVar('facet_name');
	$vs_view = 				$this->getVar('view');
	$vs_key = 				$this->getVar('key');
	$va_facet_info = 		$this->getVar("facet_info");
	$vb_is_nav = 			(bool)$this->getVar('isNav');
	
	$va_letter_bar = array();
	$vs_order_by = $va_facet_info["order_by_label_fields"][0];
	$vs_facet_list = "";	
	
	if($vb_is_nav){
		foreach($va_facet_content as $vn_id => $va_item) {
			print "<div class='browseFacetItem'>".caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."</div>";
		}
	} else {
		foreach($va_facet_content as $vn_id => $va_item) {
			$vs_first_letter = mb_strtoupper(mb_substr($va_item[$vs_order_by], 0, 1));
			if(!in_array($vs_first_letter, $va_letter_bar)){
				$va_letter_bar[$vs_first_letter] = $vs_first_letter;
				$vs_facet_list .= "<div id='facetList".$vs_first_letter."'><strong>".$vs_first_letter."</strong></div>";
			}
			
			$vs_facet_list .= "<div>".caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."</div>\n";
		}
		
		print "<H1>".$va_facet_info["label_plural"]."<span class='bFilterCount'> (".sizeof($va_facet_content)." total)</span></H1>";
		print "<div id='bLetterBar'>";
		foreach($va_letter_bar as $vs_letter){
			print "<a href='#' onclick='jumpToLetter(\"facetList".$vs_letter."\"); return false;'>".$vs_letter."</a><br/>";
		}
		print "</div><!-- end bLetterBar -->";
		print "<div id='bScrollList'>".$vs_facet_list."</div><!-- end bScrollList -->";
		print "<div style='clear:both;'></div>";

	}
?>