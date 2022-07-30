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
 * @name PDF (full page)
 * @type page
 * @filename full_page_results
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
			$vn_c++;
?>
		<br/>
			<div class="fullpageRepresentationList">
		
<?php
				if($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'mediumcontain')){
					print "<div class='fullpageRepresentationListLargeImage'><img src='".$vs_path."'/></div>\n";
				
				}
?>
			</div>
		
<?php
			print "<p class='fullpageTombstone'>".$vo_result->getWithTemplate("<ifdef code='ca_objects.preferred_labels|ca_objects.date'><b><ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i>, </ifdef>^ca_objects.date<br/></b></ifdef><ifdef code='ca_objects.idno'><if rule='^ca_objects.idno !~ /[a-zA-Z]/'>MAP # </if>^ca_objects.idno<br/></ifdef><ifdef code='ca_objects.dimensions'>^ca_objects.dimensions inches<br/></ifdef><ifdef code='ca_objects.medium'>^ca_objects.medium</ifdef>")."</p>";
			if($vn_c < $vo_result->numHits()){
				print "<div class='pageBreak'></div>";
			}
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>
