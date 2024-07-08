<?php
/* ----------------------------------------------------------------------
 * views/Browse/list_facet_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2022 Whirl-i-Gig
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
$va_facet_content = 	$this->getVar('facet_content');
$vs_facet_name = 		$this->getVar('facet_name');
$vs_view = 				$this->getVar('view');
$vs_key = 				$this->getVar('key');
$va_facet_info = 		$this->getVar("facet_info");
$vb_is_nav = 			(bool)$this->getVar('isNav');
$vn_start =				$this->getVar('start');
$vn_items_per_page =	$this->getVar('limit');
$vn_facet_size =		$this->getVar('facet_size');

$va_letter_bar = array();
$vs_facet_list = "";	

$vn_c = 0;
?>
<div class="h-100 position:relative p-3 overflow-y-hidden">
<?php	
foreach($va_facet_content as $vn_id => $va_item) {
	$vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
	
	if($va_facet_info["group_mode"]== "alphabetical"){
		$vs_first_letter = "";
		if(is_array($va_facet_info["order_by_label_fields"]) && sizeof($va_facet_info["order_by_label_fields"])){
			$vs_first_letter = mb_strtoupper(mb_substr($va_item[$va_facet_info["order_by_label_fields"][0]], 0, 1));
		}
		if(!$vs_first_letter){
			$vs_first_letter = mb_strtoupper(mb_substr($va_item['label_sort_'], 0, 1));
		}
		if(!$vs_first_letter){
			$vs_first_letter = mb_strtoupper(mb_substr($va_item["label"], 0, 1));
		}
		if(!in_array($vs_first_letter, $va_letter_bar)){
			$va_letter_bar[$vs_first_letter] = $vs_first_letter;
			$vs_facet_list .= "<dt id='facetList".$vs_first_letter."'>".$vs_first_letter."</dt>";
		}
	}			
	$vs_facet_list .= "<dd>".caNavLink($this->request, $va_item['label'].$vs_content_count, '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."</dd>\n";
	$vn_c++;
}
print '<div class="position-absolute end-0 w-auto pe-3"><button type="button" class="btn-close" aria-label="'._t("Close").'" data-bs-toggle="collapse" data-bs-target="#bMorePanel" aria-controls="bMorePanel"></button></div>';
print "<div class='fw-bold fs-5 text-uppercase'>".$va_facet_info["label_plural"]."<span class='fw-normal  fs-5'> (".sizeof($va_facet_content)." total)</span></div>";
if($va_facet_info["group_mode"]== "alphabetical"){
	print "<div class='position-absolute end-0 w-auto p-3 text-center'><nav class='nav nav-pills flex-column' id='bRefineLetterBar'>";
	foreach($va_letter_bar as $vs_letter){
		print "<a href='#facetList".$vs_letter."' class='nav-link py-1 px-1' aria-label='"._t("Skip to section %1", $vs_letter)."'>".$vs_letter."</a>";
	}
	print "</nav></div><!-- end bRefineLetterBar -->";
}
print "<div class='pt-3 pe-1 me-4 overflow-y-scroll h-100 mb-5 pb-5' data-bs-spy='scroll' data-bs-target='#bRefineLetterBar' data-bs-smooth-scroll='true'><dl>".$vs_facet_list."</dl></div><!-- end bScrollList -->";
print "<div style='clear:both;'></div>";
?>
</div>
