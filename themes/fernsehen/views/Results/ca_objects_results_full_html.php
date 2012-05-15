<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	print "<div class='searchFullResults' ".(($this->request->getController() == "Browse") ? "style='padding-top:10px;'" : "").">";
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		$vn_object_id = $vo_result->get('ca_objects.object_id');
?>
		<table border="0" cellpadding="0" cellspacing="0"><tr><td class="searchFullImage">
<?php		
		print "<div class='searchFullImageContainer'>";
		print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'widepreview', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		print "</div><!-- END searchFullImageContainer -->";
?>
		</td><td>
<?php
		print "<div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		# --- get the director
		$va_directors = $vo_result->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array("5249_avw")));
		$vs_director = "";
		if(sizeof($va_directors) > 0){
			$va_director_list = array();
			foreach($va_directors as $vn_i => $va_director){
				$va_director_list[] = $va_director["displayname"];
			}
			$vs_director = implode(", ", $va_director_list);
		}
		
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		print "<div class='searchFullTextTextBlock'>";
		if($vo_result->get("ca_objects.production_year")){
			print _t("Produktionsjahr").": ".$vo_result->get("ca_objects.production_year")."<br/>";
		}
		if($vs_director){
			print _t("Regie").": ".((strlen($vs_director) > 100) ? substr($vs_director, 0, 97)."..." : $vs_director);
		}
		print "</div>";
		print "</div><!-- END searchFullText -->\n";
		$vn_item_count++;
?>
		</td></tr></table>
<?php
	}
	# --- print out spacers if have not already reached items_per_page so page bar will get pushed to bottom of window
	while($vn_item_count < $vn_items_per_page){
		print "<div style='height:160px;'><!-- empty --></div>\n";
		$vn_item_count++; 
	}
	print "</div><!-- end searchFullResults -->";
}
?>