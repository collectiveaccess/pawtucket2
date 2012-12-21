<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/set_info_html.php : 
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

$va_access_values = caGetUserAccessValues($this->request);
$t_set 				= $this->getVar('t_set');
$va_items = caExtractValuesByUserLocale($t_set->getItems(array('thumbnailVersions' => array('small', 'medium'), "checkAccess" => $va_access_values)));
#$va_items 		= $this->getVar('items');

$va_set_list 		= $this->getVar('sets');
$va_first_items_from_sets 	= $this->getVar('first_items_from_sets');
?>
<div id="right-col">
<?php
# --- make column on right with all sets
	if(sizeof($va_set_list) > 1){
?>
	<div class="promo-block">
		<div class="shadow"></div>
		<h3><?php print _t("More Galleries"); ?></h3>
<?php
	foreach($va_set_list as $vn_set_id => $va_set_info){
		if($vn_set_id == $t_set->get("set_id")){ continue; }
		print 	"<ul class='gallery-more-thumbs-list'>";
		print		'<li>';	
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];	
		print 			caNavLink($this->request, $va_item["representation_tag"], 'thumb-link', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id));		
		print 			"<div>";
		print				(strlen($va_set_info["name"]) > 120 ? substr($va_set_info["name"], 0, 120)."..." : $va_set_info["name"]);
		print			"</div>";
		print		'</li>';
		print '</ul>';
	}
?>
		<div class="clearfix"></div>
	</div><!-- end promo-block -->
<?php
	}
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
</div> <!--end #right-col-->

<div id="left-col">
	<H1><?php print $this->getVar('set_title'); ?></H1>
	<div id='setItemsGrid'>
<?php
	if($vs_set_description = $this->getVar('set_description')) {
?>
		<div class="textContent"><?php print $vs_set_description; ?></div>
		
<?php } ?>
		<ul class="gallery-thumb-list">
<?php
		foreach($va_items as $va_item) {
?>
		<li>
			<a href="#" class="thumb-link" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['item_id'], 'set_id' => $t_set->get("set_id"))); ?>'); return false;"><?php print $va_item['representation_tag_small']; ?></a>
		</li>
<?php } //end foreach ?>

		</ul><!--end media-gallery-list-->
	</div><!-- end setItemsGrid -->
</div><!--end #left-col-->		
		
		
		
		
		
		
		