<?php
/* ----------------------------------------------------------------------
 * app/templates/checklist.php
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
 * @name Bibliography (Library)
 * @type page
 * @pageSize letter
 * @restrictToTypes book
 * @pageOrientation portrait
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
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("../footer.php");
	
	$t_list = new ca_lists();
	$vn_book_type_id = $t_list->getItemIDFromList("object_types", "book");
	$vn_copy_type_id = $t_list->getItemIDFromList("object_types", "copy");
?>
		<div class="criteria"><?php print $this->getVar('title'); ?></div>
		<div id='body'>
<?php
		if(file_exists($this->request->getThemeDirectoryPath()."/assets/pawtucket/graphics/".$this->request->config->get('report_img'))){
			print '<img src="'.$this->request->getThemeDirectoryPath().'/assets/pawtucket/graphics/'.$this->request->config->get('report_img').'" class="headerImg"/>';
		}
		if($this->request->config->get('report_show_search_term')) {
			print "<span class='footerText'>".$this->getVar('criteria_summary_truncated')."</span>";
		}
		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			if(!in_array($vo_result->get("ca_objects.type_id"), array($vn_copy_type_id, $vn_book_type_id))){
				continue;
			}
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td>
<?php 
					if ($vs_tag = $vo_result->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '80px', 'scaleCSSHeightTo' => '80px'))) {
						print "<div class=\"imageTiny\">{$vs_tag}</div>";
					} else {
?>
						<div class="imageTinyPlaceholder">&nbsp;</div>
<?php					
					}	
?>								

				</td>
				<td>
					<div class="metaBlock">
<?php
					if ($vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author')))) {
						print "<span >".$vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname')).". </span>"; 				
					}
					print "<span><i>".$vo_result->get('ca_objects.preferred_labels.name').". </i></span>"; 
					print "<span>".$vo_result->get('ca_objects.publication_description')."</span>"; 																								
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
	print $this->render("../pdfEnd.php");
?>