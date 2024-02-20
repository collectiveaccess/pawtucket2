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
 * @name Fact sheet [SIMPLE]
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @marginLeft 1 in
 * @marginRight 1 in
 * @marginTop 1 in
 * @marginBottom 1 in
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
	print $this->render("footer.php");
	$t_list = new ca_lists();
	$va_artwork_type_ids = array($t_list->getItemIDFromList("object_types", "artwork"), $t_list->getItemIDFromList("object_types", "element"));
?>
		<div id='body fullpage'>
<?php
		$vo_result->seek(0);
		while($vo_result->nextHit()) {
			if(!in_array($vo_result->get("ca_objects.type_id"), $va_artwork_type_ids)){
				continue;
			}
?>
			<div class="representationList factsheet">
<?php		
			$offset_div =  (($height = $vo_result->getMediaInfo('ca_object_representations.media', 'page', 'HEIGHT')) < 400) ? "<div style='width: 10px; height: ".($height - 100)."px;'> </div>" : "";
	
			print $offset_div.$vo_result->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '468px', 'scaleCSSHeightTo' => '234px')).$offset_div;
?>
			</div>
			<div class='tombstone factsheet'>
<?php	
			print "<div>".$vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."</div>";
			print "<div><i>".$vo_result->get('ca_objects.preferred_labels')."</i>, ".$vo_result->get('ca_objects.creation_date_display')."</div>";
			print "<div>".$vo_result->get('ca_objects.medium')."</div>"; 	
			print "<div>".$vo_result->get('ca_objects.dimensions.display_dimensions', array('delimiter' => '<br/>'))."</div>"; 				
			if ($vo_result->get('ca_objects.edition.edition_number')) {
				print "<div class='unit'>Edition ".$vo_result->get('ca_objects.edition.edition_number')." / ".$vo_result->get('ca_objects.edition.edition_total');
				if ($vo_result->get('ca_objects.edition.ap_total')) {
					print " + ".$vo_result->get('ca_objects.edition.ap_total')." AP";
				}
				print "</div>";
			} elseif ($vo_result->get('ca_objects.edition.ap_number')) {
				print "<div class='unit'>AP ".(sizeof($vo_result->get('ca_objects.edition.ap_total', ['returnAsArray' => true]) ?? []) >= 2 ? $vo_result->get('ca_objects.edition.ap_number') : "")." from an edition of ".$vo_result->get('ca_objects.edition.edition_total')." + ".$vo_result->get('ca_objects.edition.ap_total')." AP";
				print "</div>";					
			}							
	
			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_advanced") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
				if ($vo_result->get('is_deaccessioned') && ($vo_result->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
					print "<div style='font-style:italic; font-size:10px; color:red;'>"._t('Deaccessioned %1', $vo_result->get('deaccession_date'))."</div>\n";
				}	 
			}
			print "<div style='clear:both;height:20px;width:100%;'></div>";
			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new")){
				if ($va_provenance = $vo_result->get('ca_objects.artwork_provenance')) {
						print "<div class='fact'><span style='font-weight:bold;'>Provenance</span><br/><div>".$va_provenance."</div></div>";
				}
			}
			if ($va_exhibition_history = $vo_result->get('ca_objects.exhibition_history', array('returnWithStructure' => true, 'idsOnly' => true, 'sort' => 'ca_objects.exhibition_history.exhibition_date', 'sortDirection' => 'DESC'))) {
				print "<br/>";
				print "<div class='fact'><span style='font-weight: bold;'>Exhibition History</span><br/>";
				$vn_i = 0;
				foreach ($va_exhibition_history as $ex_key => $va_exhibition_t) {
					foreach ($va_exhibition_t as $ex_key => $va_exhibition) {
						$vs_tag = ($vn_i) ? "p" : "div";
						if (trim($va_exhibition['related_loan'])) {
							print "<{$vs_tag} class='exh'>".caNavLink($this->request, $va_exhibition['exhibition_name'], '', '', 'Detail', 'loans/'.$va_exhibition['related_loan'])."</{$vs_tag}>";
						} elseif(trim($va_exhibition['exhibition_name'])) {
							print "<{$vs_tag} class='exh'>".$va_exhibition['exhibition_name']."</{$vs_tag}>";
						}
						$vn_i++;
					}
				}
				print "</div>";
			}
			if ($va_literature = array_filter($vo_result->get('ca_objects.literature', ['returnAsArray' => true]), function($v) { return (bool)strlen(trim($v)); })) {
				print "<br/>";
				print "<div class='fact'><span style='font-weight: bold;'>Literature</span> <br/>";
				
				$vn_i = 0;
				foreach($va_literature as $l) {
					if(!trim($l)) { continue; }
					$vs_tag = ($vn_i) ? "p" : "div";
					print  "<{$vs_tag} class='exh'>{$l}</{$vs_tag}>\n";
					
					$vn_i++;
				}
				print "</div>";
			}				
?>	
			</div>
<?php
			if (!$vo_result->isLastHit()) {
?>
			<div class="pageBreak">&nbsp;</div>
<?php
			}
		}
?>			
		</div>
<?php
	print $this->render("pdfEnd.php");