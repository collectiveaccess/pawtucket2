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
$o_rc = new ResultContext($this->request, 'ca_objects', 'basic_search');
$o_rc->setParameter('collection_list_search', 0);
$o_rc->saveContext();

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		print "<div class='resultUnit'>";
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_title = join('<br/>', $va_labels);
		$vs_media = $vo_result->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values));
?>
		<div><?php print caNavLink($this->request, $vs_title, 'listHeading', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></div>
<?php
		if($vs_media){
			print "<div class='listMedia'>".caNavLink($this->request, $vs_media, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			if($vo_result->get("ca_object_representations.caption")){
				print "<div class='imagecaption'>".$vo_result->get("ca_object_representations.caption")."</div>";
			}
			print "</div>";
		}
?>
		<div><?php print $vo_result->get("ca_objects.cfaAbstract"); ?></div>
		</div><!-- end resultUnit -->
<?php		
		$vn_item_count++;
		
	}
}
?>
