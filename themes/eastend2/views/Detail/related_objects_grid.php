<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/related_objects_grid.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 2;
	if($this->getVar('num_cols')){
		$vn_numCols = $this->getVar('num_cols');
	}
	$va_other_params = $this->getVar('other_paging_parameters');
	# --- exclude the portrait on entity detail pages
	$vn_exclude_object_id = $this->getVar('exclude_object_id');
	$vs_detailType = $this->getVar('detailType');
	$va_access_values	= $this->getVar('access_values');
	$va_related_objects = array();
	if($qr_hits->numHits()){
		# --- loop through all results and build 3 columns to output later
		$va_col1 = array();
		$va_col2 = array();
		$va_col3 = array();
		$vn_col = 1;
		while($qr_hits->nextHit()){
			$vn_object_id = $qr_hits->get('object_id');
			if(($vn_object_id != $vn_exclude_object_id) && ($qr_hits->get("ca_objects.object_status") != 348)){
				$vs_caption = join("; ", $qr_hits->getDisplayLabels());
				$vs_vaga_class = "";
				if($qr_hits->get("object_status") == 349){
					$vs_vaga_class = " vagaDisclaimer";
					$vn_vaga_disclaimer_output = 1;
				}
				$va_media_info_orig = $qr_hits->getMediaInfo('ca_object_representations.media', 'original');
				$va_media_info_grid = $qr_hits->getMediaInfo('ca_object_representations.media', 'relatedGrid');
				$vs_icon = "";
				if(caGetMediaClass($va_media_info_orig["MIMETYPE"]) == "video"){
					$vs_icon = "<span class='videoIconRelatedGrid' style='width:".$va_media_info_grid["WIDTH"]."px; height:".$va_media_info_grid["HEIGHT"]."px;'><!-- empty --></span>";
				}
				${"va_col".$vn_col}[] = "<span style='position:relative;'>".caNavLink($this->request, $vs_icon.$qr_hits->getMediaTag('ca_object_representations.media', 'relatedGrid', array('checkAccess' => $va_access_values)), $vs_vaga_class, 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')), array("id" => "searchThumbnail".$qr_hits->get('ca_objects.object_id')))."</span>";
					
				// set view vars for tooltip
				//$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)));
				//$this->setVar('tooltip_title', $vs_caption);
				//$this->setVar('tooltip_idno', $qr_hits->get('idno'));
				//TooltipManager::add(
				//	"#searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
				//);
		
				$vn_col++;
				if($vn_col > $vn_numCols){
					$vn_col = 1;
				}
				$va_related_objects[] = $vn_object_id;
			}
		}
		# save object id's in result context
		$o_search_result_context = new ResultContext($this->request, "ca_objects", $va_other_params['detail_type']);
		$o_search_result_context->setAsLastFind();
		if($va_other_params['entity_id']){
			$o_search_result_context->setParameter("entity_id", $va_other_params['entity_id']);
		}
		if($va_other_params['occurrence_id']){
			$o_search_result_context->setParameter("occurrence_id", $va_other_params['occurrence_id']);
		}
		$o_search_result_context->setResultList($va_related_objects);
		$o_search_result_context->saveContext();
?>
		<div class="ad_thumbs" <?php print ($vn_numCols == 3) ? "style='width:555px;'" : ""; ?>><div>	
<?php
			$i = 1;
			while($i <= $vn_numCols ){
				print '<div class="col">'.join("<br/>", ${"va_col".$i}).'</div>';
				$i++;
			}
?>
		<div style="clear:both;"><!-- empty --></div></div></div><!--end ad_thumbs-->
		<script type="text/javascript">
			// Initialize the plugin
			$(document).ready(function () {
				$("div.ad_thumbs").smoothDivScroll({
					visibleHotSpotBackgrounds: "always"
				});
			});
		</script>
<?php
	}
?>