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

	# --- this overrides what is passed from DetailController so the timecode can be formatted how client wants
	if($vn_representation_id){
 		$t_rep = new ca_object_representations($vn_representation_id);
 		$vs_current_rep_title = "";
 		if($t_rep->get("ca_object_representations.preferred_labels.name") != "[BLANK]"){
 			$vs_current_rep_title = $t_rep->get("ca_object_representations.preferred_labels.name");
 		}
 		$vn_object_id = $t_rep->get("ca_objects.object_id");
 		if (!($vs_template = $va_detail_options['displayAnnotationTemplate'])) { $vs_template = '^ca_representation_annotations.preferred_labels.name'; }
 			
 			$va_annotation_list = array();
 			if (
				is_array($va_annotations = $t_rep->getAnnotations(array('idsOnly' => true))) //$t_rep->get('ca_representation_annotations.annotation_id', array('returnAsArray' => true))) 
				&& 
				sizeof($va_annotations)
				&&
				($qr_annotations = caMakeSearchResult('ca_representation_annotations', $va_annotations))
			) {
				while($qr_annotations->nextHit()) {
					if (!preg_match('!^TimeBased!', $qr_annotations->getAnnotationType())) { continue; }
					#$va_annotation_list[] = $qr_annotations->getWithTemplate($vs_template);
					$vs_tmp = $qr_annotations->getWithTemplate("<b>^ca_representation_annotations.preferred_labels.name</b> (");
					$vs_start = $qr_annotations->getWithTemplate("^ca_representation_annotations.start%asTimecode=delimited");
					if(strpos($vs_start, ".") !== false){
						$vs_start = substr($vs_start, 0, strpos($vs_start, "."));
					}
					$vs_tmp .= $vs_start;
					$vs_tmp .= $qr_annotations->getWithTemplate(")<ifdef code='ca_representation_annotations.description'><br/>^ca_representation_annotations.description</ifdef>");
					$va_annotation_list[] = $vs_tmp;
				}
			}
	}
	if (sizeof($va_annotation_list) > 0) {
?>
<div class="unit">
<?php
	print "<div class='downloadIndex'>".caDetailLink($this->request, "<span class='glyphicon glyphicon-download' aria-label='"._t("Download")."'></span> Download Index", "", "ca_objects",  $vn_object_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary', 'representation_id' => $vn_representation_id))."</div>";
?>
	<label><?php print 'Index'.(($vs_current_rep_title) ? ' for <i>'.$vs_current_rep_title.'</i>' : '').' ('.sizeof($va_annotation_list).')'; ?></label>
<div class='detailAnnotationList'>
	<ul class='detailAnnotation'>
<?php
		foreach($va_annotation_list as $vs_annotation) {
			print "<li class='detailAnnotation'>{$vs_annotation}</li>\n";
		}
?>
	</ul>
<?php
	}
	

?>
</div></div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var detailAnnotationTimes = <?php print json_encode($va_annotation_times); ?>;
		jQuery('li.detailAnnotation').on('click', function(e) {
			//var i = jQuery('li.detailAnnotation').index(e.target); 
			var i = jQuery('li.detailAnnotation').index($(this));
			caUI.mediaPlayerManager.seek('<?php print $vs_player_name; ?>', detailAnnotationTimes[i][0]);
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