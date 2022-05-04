<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Generic summary
 * @type omit
 * @pageSize letter
 * @pageOrientation portrait
 * @tables *
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item 				= $this->getVar('t_subject');
	$va_bundle_displays 	= $this->getVar('bundle_displays');
	$t_display 				= $this->getVar('t_display');
	$va_placements 			= $this->getVar("placements");
	
	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
<?php
	foreach($va_placements as $vn_placement_id => $va_bundle_info){
		if (!is_array($va_bundle_info)) break;
		
		if (!strlen($vs_display_value = $t_display->getDisplayValue($t_item, $vn_placement_id, array('forReport' => true, 'purify' => true)))) {
			if (!(bool)$t_display->getSetting('show_empty_values')) { continue; }
			$vs_display_value = "&lt;"._t('not defined')."&gt;";
		} 
		
		print '<div class="data"><span class="label">'."{$va_bundle_info['display']} </span><span> {$vs_display_value}</span></div>\n";
	}

	print $this->render("pdfEnd.php");