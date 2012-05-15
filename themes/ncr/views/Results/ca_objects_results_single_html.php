<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2010 Whirl-i-Gig
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
 
$va_access_values =  	$this->getVar('access_values');	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');

if($vo_result) {
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$va_caption = array();
		$va_caption[] = "<span class='resultidno'>".trim($vo_result->get("ca_objects.idno"))."</span>";
		$va_caption[] = "<i>".join('; ', $va_labels)."</i>";
		$va_caption[] = $vo_result->get("ca_objects.date.display_date");
		$va_caption[] = $vo_result->get("ca_objects.technique");
		$vs_caption = join(', ', $va_caption);
		print "<div class='searchSingleImageContainer result".$vn_object_id."'>";
		if($vo_result->getMediaTag('ca_object_representations.media', 'mediumlarge', array('checkAccess' => $va_access_values))){
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'mediumlarge', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		}else{
			print "<div class='searchSingleImageContainerPlaceHolder'>&nbsp;</div>";
		}
		print "</div><!-- END searchSingleImageContainer -->";
		print "<div class='searchSingleText result".$vn_object_id."'>";
		print caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		print "</div><!-- END searchSingleText --></td>";

		$vn_item_count++;
	}
}
?>