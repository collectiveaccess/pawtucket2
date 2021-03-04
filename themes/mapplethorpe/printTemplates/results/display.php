<?php
/* ----------------------------------------------------------------------
 * app/templates/display.php
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
 * @name PDF display
 * @type omit
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * 
 *
 * @marginTop 0.75in
 * @marginLeft 0.25in
 * @marginBottom 0.5in
 * @marginRight 0.25in
 *
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vn_num_items			= (int)$vo_result->numHits();
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	#print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td style="width:250px;">
<?php	
					if ($va_rep = $vo_result->get('ca_object_representations.media.small', ['usePath' => true, 'scaleCSSWidthTo' => '250px', 'scaleCSSHeightTo' => '200px'])) {
						print "<div class='objThumb'>".$va_rep."</div>";
					} else {
						print "<div class='imageTinyPlaceholder'></div> ";
						$va_rep = null;
					}
?>				
				</td>
				<td>
					<div class="metaBlock">
<?php				
					#print "<div class='title'>".$vo_result->getWithTemplate('^ca_occurrences.preferred_labels.name (^ca_occurrences.idno)')."</div>"; 
					if (is_array($va_display_list)) {
                        foreach($va_display_list as $vn_placement_id => $va_display_item) {
                            if (!strlen($vs_display_value = $t_display->getDisplayValue($vo_result, $vn_placement_id, array('forReport' => true, 'purify' => true)))) {
                                if (!(bool)$t_display->getSetting('show_empty_values')) { continue; }
                                $vs_display_value = "&lt;"._t('not defined')."&gt;";
                            } 
                            print "<div class='metadata'><span class='displayHeader'>".$va_display_item['display']."</span>: <span class='displayValue' >".(strlen($vs_display_value) > 1200 ? strip_tags(substr($vs_display_value, 0, 1197))."..." : $vs_display_value)."</span></div>";		
                        }	
                    }						
?>
					</div>				
				</td>	
			</tr>
			</table>	
			</div>
<?php
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>
