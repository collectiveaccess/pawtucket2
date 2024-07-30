<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/annotations_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
	$vs_player_name = 			$this->getVar('player_name');
	$va_annotations = 			$this->getVar('annotation_list');
	$va_annotation_times = 		$this->getVar('annotation_times');
	$vn_representation_id = 	$this->getVar('representation_id');
	$qr_annotations =			$this->getVar('annotations_search_results');
	$va_access_values = $this->getVar("access_values");
	if ($qr_annotations && $qr_annotations->numHits()) {
?>
<h6><?php print _t('Featured clips (%1)', $qr_annotations->numHits()); ?></h6>
<div class='detailAnnotationList'>
	<ul class='detailAnnotation'>
<?php
		$t_list_item = new ca_list_items();
		$i = 0;
		while($qr_annotations->nextHit()) {
			$vs_themes = "";
			print "<li class='detailAnnotation' id='".$i."'>";
			print "<div class='detailAnnotationTitle'><i class='fa fa-play-circle-o' aria-hidden='true'></i><i class='fa fa-play-circle' aria-hidden='true'></i> ".$qr_annotations->get("ca_representation_annotations.preferred_labels.name")." <span>(".gmdate("H:i:s", $va_annotation_times[$i][0])."-".gmdate("H:i:s", $va_annotation_times[$i][1]).")</span></div>";
			# --- themes
			if($va_themes = $qr_annotations->get("ca_representation_annotations.themes", array("returnAsArray" => true, "checkAccess" => $va_access_values))){
				foreach($va_themes as $vn_theme_id){
					$t_list_item->load($vn_theme_id);
					$va_theme_hier = $t_list_item->get("ca_list_item_labels.hierarchy", array("returnWithStructure" => true));
					$va_theme_breadcrumb = array();
					foreach($va_theme_hier as $va_theme){
						foreach($va_theme as $vn_hier_theme_id => $va_theme_info){
							$va_theme_info = array_pop($va_theme_info);
							$va_theme_breadcrumb[] = caNavLink($this->request, $va_theme_info["name_singular"], "", "", "browse", "objects", array("facet" => "theme_facet", "id" => $vn_hier_theme_id));
						}
					}
					$vs_themes .= "<div><i class='fa fa-angle-right' aria-hidden='true'></i> ".join(" > ", $va_theme_breadcrumb)." <span>(themes)</span></div>";
				}
			}
			$vs_entities = $qr_annotations->getWithTemplate("<ifcount code='ca_entities'><unit relativeTo='ca_entities' delimiter=' '><div><i class='fa fa-angle-right' aria-hidden='true'></i> <l>^ca_entities.preferred_labels.displayname</l> <span>(^ca_entities.type_id)</span></div></unit></ifcount>");
			$vs_transcription = $qr_annotations->get("ca_representation_annotations.transcription_text");
			if($vs_themes || $vs_entities || $vs_transcription){
				print "<div class='annotationMD'>";
				if($vs_themes || $vs_entities){
					print "<div class='unit annotationLinks'><h6>Themes</h6>".$vs_themes.$vs_entities."</div>";
				}
				if($vs_transcription){
					print "<div class='annotationTranscription unit'><h6>Transcription</h6>".$vs_transcription."</div>";
				}
				print "</div>";
			}
			print "</li>\n";
			$i++;
		}
?>
	</ul>
<?php
	}
?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var detailAnnotationTimes = <?php print json_encode($va_annotation_times); ?>;
		jQuery('.detailAnnotationTitle').on('click', function(e) {
			i = $(this).parent().attr("id");
			//var i = jQuery('.detailAnnotation .detailAnnotationTitle').index(e.target); 
			$(".jcarousel").jcarousel("scroll", $("#slide<?php print $vn_representation_id; ?>"), false);
			caUI.mediaPlayerManager.seek('<?php print $vs_player_name; ?>', detailAnnotationTimes[i][0]);
		
			$('#detailRepresentationThumbnails .active').removeClass('active');
			$('#detailRepresentationThumbnails #detailRepresentationThumbnail<?php print $vn_representation_id; ?>').addClass('active');
			$('#detailRepresentationThumbnails #detailRepresentationThumbnail<?php print $vn_representation_id; ?> a').addClass('active');		
		});
		
		caUI.mediaPlayerManager.onTimeUpdate('<?php print $vs_player_name; ?>', function() {
			var ct = caUI.mediaPlayerManager.currentTime('<?php print $vs_player_name; ?>');
			
			jQuery('li.detailAnnotation').removeClass('active');
			jQuery.each(detailAnnotationTimes, function(i, v) {
				if ((ct > v[0]) && (ct <= v[1])) {
					jQuery('li.detailAnnotation:eq(' + i + ')').addClass('active');
				}
			});
		});
	});
</script>