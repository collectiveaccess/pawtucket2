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
 * @name Checklist [SIMPLE]
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @disabled true
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
	$va_library_type_ids = array($t_list->getItemIDFromList("object_types", "book"), $t_list->getItemIDFromList("object_types", "copy"));
	$va_archive_type_ids = array($t_list->getItemIDFromList("object_types", "audio"), $t_list->getItemIDFromList("object_types", "document"), $t_list->getItemIDFromList("object_types", "ephemera"), $t_list->getItemIDFromList("object_types", "image"), $t_list->getItemIDFromList("object_types", "moving_image"));
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
		$t_collection = new ca_collections();
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td>
<?php 
					if ($vs_tag = $vo_result->get('ca_object_representations.media.medium', array('scaleCSSWidthTo' => '80px', 'scaleCSSHeightTo' => '80px'))) {
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
				if(in_array($vo_result->get('ca_objects.type_id'), $va_library_type_ids)){
					# --- library
					# --- Chicago style -> Pollan, Michael. The Omnivore�s Dilemma: A Natural History of Four Meals. New York: Penguin, 2006.
					$vs_author = $vo_result->get('ca_entities.preferred_labels.name', array('delimiter' => ", ", 'restrictToRelationshipTypes' => array('author'), 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname')).". ";
					$vs_publisher = $vo_result->get("ca_objects.publication_description");
					print $vs_author."<i>".$vo_result->get("ca_objects.preferred_labels.name").". </i>".$vs_publisher;
				}elseif(in_array($vo_result->get('ca_objects.type_id'), $va_archive_type_ids)){
					# --- archive
					print "<div><i>".$vo_result->get('ca_objects.preferred_labels').",</i>";
					
					if ($vo_result->get('ca_objects.dc_date.dc_dates_value')) {
						print ", ".$vo_result->get('ca_objects.dc_date', array('returnAsLink' => true, 'delimiter' => '; ', 'template' => '^dc_dates_value')).". ";
					}
					print $vo_result->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)).". ";
					print " Glenstone Archives. ";
					
					$vn_collection_id = $vo_result->get('ca_collections.collection_id');
					if($vn_collection_id){
						$t_collection->load($vn_collection_id);
						$va_parent_ids = $t_collection->getHierarchyAncestors($vn_collection_id, array('idsOnly' => true));
						$vn_highest_level = end($va_parent_ids);
						$t_collection->load($vn_highest_level);
						print $t_collection->get('ca_collections.preferred_labels').".";
					}					
					print "</div>";
				}else{

					print "<div class='title'>".$vo_result->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('artist')))."</div>"; 				
					print "<div><i>".$vo_result->get('ca_objects.preferred_labels.name')."</i>, ".$vo_result->getWithTemplate('^ca_objects.creation_date_display')."</div>"; 
					print "<div>".$vo_result->get('ca_objects.medium')."</div>"; 	
					print "<div>".$vo_result->get('ca_objects.dimensions.display_dimensions', array('delimiter' => '<br/>'))."</div>"; 				
					if ($vo_result->get('ca_objects.edition.edition_number')) {
						print "<div class='unit'>Edition ".$vo_result->get('ca_objects.edition.edition_number')." / ".$vo_result->get('ca_objects.edition.edition_total');
						if ($vo_result->get('ca_objects.edition.ap_total')) {
							print " + ".$vo_result->get('ca_objects.edition.ap_total')." AP";
						}
						print "</div>";
					} elseif ($vo_result->get('ca_objects.edition.ap_number')) {
						print "<div class='unit'>AP ".(count($vo_result->get('ca_objects.edition.ap_total')) >= 2 ? $vo_result->get('ca_objects.edition.ap_number') : "")." from an edition of ".$vo_result->get('ca_objects.edition.edition_total')." + ".$vo_result->get('ca_objects.edition.ap_total')." AP";
						print "</div>";					
					}
				if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_advanced") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
						if ($vo_result->get('is_deaccessioned') && ($vo_result->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
							print "<div style='font-style:italic; font-size:10px; color:red;'>"._t('Deaccessioned %1', $vo_result->get('deaccession_date'))."</div>\n";
						}						
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
	print $this->render("../pdfEnd.php");
?>