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
 * @filename Thumbnails
 * @type page
 * @pageSize letter
 * @pageOrientation landscape
 * @tables ca_objects
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.5in
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
	
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_lines_on_page = 0;
		$vn_items_in_line = 0;
		
		$vn_left = $vn_top = 0;
		while($vo_result->nextHit()) {
			if($vn_lines_on_page == 0){
				print "<div class='pageContainer'>";
			}
			$vn_object_id = $vo_result->get('ca_objects.object_id');
								
			$vs_caption = "";
			$vs_caption .= $vo_result->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))." &rsaquo; ";
			if($vs_tmp = $vo_result->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				$vs_caption .= $vs_tmp;
				if($vo_result->get("ca_objects.brand")){
					$vs_caption .= "<br/>";
				}
			}
			$vs_brand = $vo_result->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			$vs_subbrand = $vo_result->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "));
			if(($vs_brand) || ($vs_subbrand)){
				$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? " &rsaquo; " : "").$vs_subbrand;
			}
			if($vs_idno = $vo_result->get("ca_objects.idno")){
				$vs_caption .= ", Object ID: ".$vs_idno;
			}
			$vs_caption .= "<br/>";
			$vs_caption .= trim($vo_result->get('ca_objects.preferred_labels'));
			$vs_tmp = $vo_result->getWithTemplate('^ca_objects.manufacture_date');
			if(!$vo_result->get("ca_objects.manufacture_date")){
				$vs_tmp .= "undated";
			}
			if(trim($vs_tmp)){
				$vs_caption .= ", ".$vs_tmp;
			}
			if($vs_tmp = $vo_result->get("ca_objects.codes.product_code")){
				$vs_caption .= " (".$vs_tmp.")";
			}
			if($vs_tmp = $vo_result->get("ca_objects.shade")){
				$vs_caption .= ", ".$vs_tmp;
			}			
?>
			<div class="thumbnail" style="left: <?php print $vn_left; ?>px; top: <?php print $vn_top; ?>px;">
				<?php print "<div class='imgThumb'><img src='".$vo_result->getMediaPath('ca_object_representations.media', 'preview170')."'/></div>"; ?>
				<?php print "<div class='caption'>".$vs_caption."</div>"; ?>
			</div>
<?php

			$vn_items_in_line++;
			$vn_left += 220;
			if ($vn_items_in_line >= 4) {
				$vn_items_in_line = 0;
				$vn_left = 0;
				$vn_top += 225;
				$vn_lines_on_page++;
				print "<div class=\"clear\"/></div>\n";
			}
			
			if ($vn_lines_on_page >= 3) { 
				$vn_lines_on_page = 0;
				$vn_left = $vn_top = 0;
				print "</div><!-- end pageContainer -->";
				print "<div class=\"pageBreak\">&nbsp;</div>\n";
			}
		}
		if($vn_lines_on_page > 0){
			print "</div><!-- end pageContainer -->";
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>
