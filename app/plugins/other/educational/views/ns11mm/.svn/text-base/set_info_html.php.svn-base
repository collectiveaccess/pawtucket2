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
 
$t_set 				= $this->getVar('t_set');
$va_items 		= $this->getVar('items');

$va_set_list 		= $this->getVar('sets');
$va_first_items_from_sets 	= $this->getVar('first_items_from_sets');
?>
<div id="gallerySetDetail">
<?php
# --- make column on right with all sets
	if(sizeof($va_set_list) > 1){
?>
	<div id="allSets"><H3><?php print _t("More Galleries"); ?></H3>
<?php
	foreach($va_set_list as $vn_set_id => $va_set_info){
		if($vn_set_id == $t_set->get("set_id")){ continue; }
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $va_item["representation_tag"], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 120 ? substr($va_set_info["name"], 0, 120)."..." : $va_set_info["name"]), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
	</div><!-- end allSets -->
<?php
	}
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
	<H1><?php print $this->getVar('set_title'); ?></H1>
<?php
	print "<div id='setItemsGrid'>";
	if($vs_set_description = $this->getVar('set_description')) {
?>
		<div class="textContent"><?php print $vs_set_description; ?></div>
<?php
	}
	foreach($va_items as $va_item) {
?>
		<div class="setItem" id="item<?php print $va_item['item_id']; ?>">
			<a href="#" onclick="caMediaPanel.showPanel('<?php print caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['item_id'], 'set_id' => $t_set->get("set_id"))); ?>'); return false;"><?php print $va_item['representation_tag_widepreview']; ?></a>
		</div>
<?php
		if($va_item['caption'] || $va_item['representation_tag_medium']){
			// set view vars for tooltip
			$this->setVar('tooltip_image_name', $va_item['name']);
			$this->setVar('tooltip_text', preg_replace('![\n\r]+!', '<br/><br/>', addslashes($va_item['caption'])));
			$this->setVar('tooltip_image', $va_item['representation_tag_medium']);
			TooltipManager::add(
				"#item{$va_item['item_id']}", $this->render('default/tooltip_html.php')
			);
		}
	}
	print "</div><!-- end setItemsGrid -->";
?>