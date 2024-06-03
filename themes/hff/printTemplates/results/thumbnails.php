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
		$vs_table = "ca_objects";
		while($vo_result->nextHit()) {
			if($vn_lines_on_page == 0){
				print "<div class='pageContainer'>";
			}
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			
			<?php				
					$vs_typecode = "";
					$t_list_item = new ca_list_items($vo_result->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					
					$vs_idno = "";
					$vs_label = "";
					switch($vs_typecode){
						# ------------------------
						case "archival":
							# --- no idno link
							$vs_label 	= $vo_result->get("{$vs_table}.preferred_labels").(($vo_result->get("{$vs_table}.unitdate.dacs_date_text")) ? ", ".$vo_result->get("{$vs_table}.unitdate.dacs_date_text") : "");
							$vs_tmp = $vo_result->getWithTemplate("<unit relativeTo='ca_collections' delimiter=', '>^ca_collections.preferred_labels</unit>", array("checkAccess" => $va_access_values));				
							if($vs_tmp){
								$vs_label .= "<br/>Part of: ".$vs_tmp;
							}
							#title, display date, DB#, Extent and Medium, Caption, Rights, and location (including the collection level)
							#$va_parts = array();
							#if($vs_tmp = $vo_result->get("ca_objects.preferred_labels")){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("ca_objects.unitdate.dacs_date_text", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("ca_objects.idno", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("<unit relativeTo='ca_objects.extentDACS' delimiter='<br/>'><ifdef code='ca_objects.extentDACS.extent_number'>^ca_objects.extentDACS.extent_number </ifdef><ifdef code='ca_objects.extentDACS.extent_type'>^ca_objects.extentDACS.extent_type: </ifdef><ifdef code='ca_objects.extentDACS.physical_details'>^ca_objects.extentDACS.physical_details</ifdef><ifdef code='ca_objects.extentDACS.physical_details,ca_objects.extentDACS.extent_dimensions'>; </ifdef><ifdef code='ca_objects.extentDACS.extent_dimensions'>^ca_objects.extentDACS.extent_dimensions </ifdef></unit>", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("ca_object_representations.caption", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("ca_object_representations.copyright_statement", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#if($vs_tmp = $vo_result->get("<unit relativeTo='ca_collections' delimiter=' > '>^ca_collections.hierarchy.preferred_labels</unit>", array("delimiter" => ", "))){
							#	$va_parts[] = $vs_tmp;
							#}
							#$vs_idno 	= "";
							#$vs_label = join("<br/>", $va_parts);
						break;
						# ------------------------
						case "artwork":
						case "art_HFF":
						case "art_nonHFF":
						case "edition":
						case "edition_HFF":
						case "edition_nonHFF":
							$vs_idno 	= "<small>".$vo_result->get("{$vs_table}.idno")."</small><br/>";
							$vs_label 	= italicizeTitle($vo_result->get("{$vs_table}.preferred_labels")).(($vo_result->get("{$vs_table}.common_date")) ? ", ".$vo_result->get("{$vs_table}.common_date") : "");
						break;
						# ------------------------
						case "library":
							# --- no idno link
							# --- title, author, publisher, year, library, LC classification, Tags, Public Note
							$va_tmp = array();
							if($vs_tmp = $vo_result->get("ca_objects.preferred_labels")){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.author.author_name", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values))){
								$va_tmp[] = $vs_tmp;
							}elseif($vs_tmp = $vo_result->get("ca_objects.publisher", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.common_date", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.library", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.call_number", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.artwork_status", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.remarks", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							$vs_label 	.= join("<br/>", $va_tmp);
						
# --- should the publisher be the text field or the rel entity
						break;
						# ------------------------
						default:
							$vs_idno 	= "<small>".$vo_result->get("{$vs_table}.idno")."</small><br/>";
							$vs_label 	= $vo_result->get("{$vs_table}.preferred_labels");
					
						break;
						# ------------------------
					}
					
?>
			
			
			
			
			<div class="thumbnail" style="left: <?php print $vn_left; ?>px; top: <?php print $vn_top; ?>px;">
				<?php print "<div class='imgThumb'><img src='".$vo_result->getMediaPath('ca_object_representations.media', 'preview170')."'/></div>"; ?>
				<?php print "<div class='caption'>".$vs_idno.$vs_label."</div>"; ?>
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
