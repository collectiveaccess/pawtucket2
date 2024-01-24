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
 * @name PDF (thumbnails)
 * @type page
 * @filename thumbnails_results
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * @marginTop 1in
 * @marginLeft 0.25in
 * @marginBottom 0.5in
 * @marginRight 0.25in
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
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_c = 0;
		while($vo_result->nextHit()) {
			if($vn_c == 0){
?>
			<div class="row thumbnailRow">
				<table style="width:100%;">
					<tr>
<?php
			}
			$vn_c++;
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
				<td style="vertical-align:top; text-align:middle; width:50%;">
<?php 
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'medium')) {
						print "<div class=\"thumbnailImage\"><img src='{$vs_path}'/></div>";
					} else {
?>
						<div class="thumbnailPlaceholder">&nbsp;</div>
<?php					
					}
					print "<div class='thumbnailTombstone'>".$vo_result->getWithTemplate("<ifdef code='ca_objects.preferred_labels|ca_objects.date'><b><ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i>, </ifdef>^ca_objects.date</b><br/></ifdef><ifdef code='ca_objects.idno'><if rule='^ca_objects.idno !~ /[a-zA-Z]/'>MAP # </if>^ca_objects.idno</ifdef>")."</div>"; 							
?>
				</td>
<?php
			if($vn_c == 2){
?>	
			
					</tr>
				</table>	
			</div>
<?php
				$vn_c = 0;
			}
		}
		if($vn_c > 0){
?>
				<td style="vertical-align:top; text-align:middle; width:50%;"></td>	
			
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
