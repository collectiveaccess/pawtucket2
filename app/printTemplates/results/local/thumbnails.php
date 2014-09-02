<?php
/* ----------------------------------------------------------------------
 * app/templates/thumbnails.php
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
 * @name Thumbnails
 * @type omit
 * @pageSize letter
 * @pageOrientation landscape
 * @tables ca_objects
 *
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar					= $this->getVar('access_restrictions');
	$vo_result_context 		= $this->getVar('result_context');
	$vn_num_items			= (int)$vo_result->numHits();
	$vs_color 				= ($this->request->config->get('report_text_color')) ? $this->request->config->get('report_text_color') : "FFFFFF";;
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("../header.php");
	print $this->render("../footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_lines_on_page = 0;
		$vn_items_in_line = 0;
		
		$vn_left = $vn_top = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="thumbnail" style="left: <?php print $vn_left; ?>px; top: <?php print $vn_top; ?>px;">
				<?php print "<div>".$vo_result->get('ca_object_representations.media.large', array('scaleCSSWidthTo' => '190px', 'scaleCSSHeightTo' => '160px'))."</div>"; ?>
				
<?php
				print "<div class='caption'>";
					print "<div class='title'>".$vo_result->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('artist')))."</div>"; 				
					print "<div class='title'><i>".$vo_result->getWithTemplate('^ca_objects.preferred_labels.name')."</i>, ".$vo_result->getWithTemplate('^ca_objects.creation_date')."</div>"; 
					print "<div>".$vo_result->get('ca_objects.medium')."</div>"; 	
					print "<div>".$vo_result->get('ca_objects.dimensions.display_dimensions')."</div>"; 				
					if ($vo_result->get('ca_objects.edition.edition_number')) {
						print "<div>".$vo_result->get('ca_objects.edition.edition_number')." / ".$vo_result->get('ca_objects.edition.edition_total')."</div>"; 	
					}
					if ($vo_result->get('ca_objects.edition.ap_number')) {
						print "<div>".$vo_result->get('ca_objects.edition.ap_number')." / ".$vo_result->get('ca_objects.edition.ap_total')."</div>"; 	
					}	
				print "</div>"; 
?>
			</div>
<?php

			$vn_items_in_line++;
			$vn_left += 220;
			if ($vn_items_in_line >= 3) {
				$vn_items_in_line = 0;
				$vn_left = 0;
				$vn_top += 240;
				$vn_lines_on_page++;
				print "<br class=\"clear\"/>\n";
			}
			
			if ($vn_lines_on_page >= 2) { 
				$vn_lines_on_page = 0;
				$vn_left = $vn_top = 0;
				
				if (!$vo_result->isLastHit()) {
					print "<div class=\"pageBreak\">&nbsp;</div>\n";
				}
			}
		}
?>
		</div>
<?php
	print $this->render("../pdfEnd.php");
?>
