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

$va_first_item_in_set = array_shift($va_items);
?>
<div id="gallerySetDetail">
<?php
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
	<div id="galleryLeftCol">
		<div id="setInfo">
			<H2><?php print $this->getVar('set_title'); ?></H2>
<?php
	if($vs_set_description = $this->getVar('set_description')) {
?>
		<div class="textContent"><?php print $vs_set_description; ?></div>
<?php
	}
?>
		</div><!-- end setInfo -->
<?php
# --- display links to all sets
	if(sizeof($va_set_list) > 1){
?>
	<div id="allSets"><H3><?php print _t("More Slideshows"); ?></H3>
<?php
	$va_set_list = array_slice($va_set_list, 0, 5, true);
	foreach($va_set_list as $vn_set_id => $va_set_info){
		if($vn_set_id == $t_set->get("set_id")){ continue; }
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $va_item["representation_tag"], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 90 ? substr($va_set_info["name"], 0, 90)."..." : $va_set_info["name"]), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
	</div><!-- end allSets -->
<?php
	}
?>
	</div><!-- end galleryLeftCol -->
	<div id="galleryRightCol">
	<div id='setSlideShow'>

	</div><!-- end setSlideShow -->
	</div><!-- end galleryRightCol -->

<script>
	$("#setSlideShow").load("<?php print caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_first_item_in_set['item_id'], 'set_id' => $t_set->get("set_id"))); ?>");
</script>