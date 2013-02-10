<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/landing_html.php : 
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
 
	$va_set_list 								= $this->getVar('sets');
	$va_first_items_from_sets 		= $this->getVar('first_items_from_sets');
	$va_set_descriptions					= $this->getVar('set_descriptions');
?>
<h1><?php print _t("Favorites"); ?></H1>
<div id="galleryLanding">

<?php

	foreach($va_set_list as $vn_set_id => $va_set_info){
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $va_item["representation_tag"], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 60 ? substr($va_set_info["name"], 0, 60)."..." : $va_set_info["name"]), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div>";
		$vs_set_text = "";
		if(isset($va_set_descriptions[$vn_set_id]) && $va_set_descriptions[$vn_set_id]){
			$vs_set_text = $va_set_descriptions[$vn_set_id][0]; // is array because fields could (but usually don't) repeat - just grab the first desc
			if(strlen(utf8_decode($vs_set_text)) > 150){
				$vs_set_text = substr($vs_set_text, 0, 147)."...";
			}
			print "<div class='setText'>".$vs_set_text."</div>";	
		}
		print "<div class='setMoreLink'>".caNavLink($this->request, _t('More'), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id))." &rsaquo;</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
</div>
