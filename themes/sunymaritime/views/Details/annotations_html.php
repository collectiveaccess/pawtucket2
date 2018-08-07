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

	if (sizeof($va_annotations) > 0) {
?>
<h6><?php print _t('Featured clips (%1)', sizeof($va_annotations)); ?></h6>
<div class='detailAnnotationList'>
	<ul class='detailAnnotation'>
<?php
		foreach($va_annotations as $vs_annotation) {
			print "<li class='detailAnnotation'>{$vs_annotation}</li>\n";
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
		jQuery('li.detailAnnotation').on('click', function(e) {
			var i = jQuery('li.detailAnnotation').index(e.target); 
			
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