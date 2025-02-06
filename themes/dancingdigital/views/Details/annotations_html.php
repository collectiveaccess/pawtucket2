<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/annotations_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
$player_name = 				$this->getVar('player_name');
$subject_id = 				$this->getVar('id');
$context = 					$this->getVar('context');
$annotations = 				$this->getVar('annotation_list');
$annotation_times = 		$this->getVar('annotation_times');
$user_annotations = 		$this->getVar('user_annotation_list');
$user_annotation_times = 	$this->getVar('user_annotation_times');
$representation_id = 		$this->getVar('representation_id');
$t_rep =					$this->getVar('representation');

if(!in_array($t_rep->getAnnotationType(), ['TimeBasedAudio', 'TimeBasedVideo'])) { return ; }
if (sizeof($annotations) > 0) {
?>
<div class='object-info-label'><?= _t('Featured clips (%1)', sizeof($annotations)); ?></div>
<div class='detailAnnotationList'>
	<ul class='detailAnnotation'>
<?php
		foreach($annotations as $annotation) {
			print "<li class='detailAnnotation'>{$annotation}</li>\n";
		}
?>
	</ul>
<?php
}
if ((sizeof($user_annotations) > 0) && $this->request->isLoggedIn()) {
?>
<div class='object-info-label'><?= _t('Your clips (%1)', sizeof($user_annotations)); ?></div>
<div class='detailUserAnnotationList'>
	<div class='row detailUserAnnotation'>
<?php
		foreach($user_annotations as $id => $annotation) {
			$delete = "<a href='#' class='clipDeleteButton' data-id='{$id}'>".caNavIcon(__CA_NAV_ICON_TRASH__, '12px')."</a>";
			$lightbox =  "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Lightbox', 'addItemForm', ['object_id' => $subject_id, 'representation_id' => $representation_id, 'annotation_id' => $id])."\"); return false;' aria-label='"._t("Add item to lightbox")."' title='"._t("Add item to lightbox")."'>".caNavIcon(__CA_NAV_ICON_FOLDER__, '12px')."</a>\n";
			print "<div class='detailUserAnnotation col-md-10'><span class='clipTitle'>{$annotation}</span></div><div class='col-md-1'>{$lightbox}</div><div class='col-md-1'>{$delete}</div>\n";
		}
?>
	</div>
<?php
}

if($this->request->isLoggedIn()) {
?>
<form style="margin-top: 15px;">
	<div class='object-info-label'><?= _t('Add clip'); ?></div>
	<div class="row align-items-center h-100">
		<div class="col-md-7">
			<?= _t('Label').':<br/>'.caHTMLTextInput('label', ['id' => 'clipLabel'], ['width' => '420px', 'height'=> '1']); ?>
		</div>
		<div class="col-md-2">
			<?= _t('Start').':<br/>'.caHTMLTextInput('start', ['id' => 'clipStart'], ['width' => '80px', 'height'=> '1']); ?>
				
			<a href="#" id='clipStartSetTime'><?= caNavIcon(__CA_NAV_ICON_CLOCK__, '14px'); ?></a>
		</div>
		<div class="col-md-2">
			<?= _t('End').':<br/>'.caHTMLTextInput('end', ['id' => 'clipEnd'], ['width' => '80px', 'height'=> '1']); ?>
				 
			<a href="#" id='clipEndSetTime'><?= caNavIcon(__CA_NAV_ICON_CLOCK__, '14px'); ?></a>
		</div>
		<div class="col-md-1" style="margin-top:14px;">
			<a href="#" id='clipAddButton'><?= caNavIcon(__CA_NAV_ICON_GO__, '24px'); ?></a>
		</div>
	</div>
</form>
<?php
}
?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var detailAnnotationTimes = <?= json_encode($annotation_times); ?>;
		jQuery('li.detailAnnotation').on('click', function(e) {
			var i = jQuery('li.detailAnnotation').index(e.target); 
			
			caUI.mediaPlayerManager.seek('<?= $player_name; ?>', detailAnnotationTimes[i][0]);
		});
		
		var detailUserAnnotationTimes = <?= json_encode($user_annotation_times); ?>;
		jQuery('.detailUserAnnotation').on('click', function(e) {
			var i = jQuery('.detailUserAnnotation span.clipTitle').index(e.target); 
			if(i >= 0) {
				caUI.mediaPlayerManager.seek('<?= $player_name; ?>', detailUserAnnotationTimes[i][0]);
			}
			e.preventDefault();
		});
		
		caUI.mediaPlayerManager.onTimeUpdate('<?= $player_name; ?>', function() {
			var ct = caUI.mediaPlayerManager.currentTime('<?= $player_name; ?>');
			
			jQuery('li.detailAnnotation').removeClass('active');
			jQuery.each(detailAnnotationTimes, function(i, v) {
				if ((ct > v[0]) && (ct <= v[1])) {
					jQuery('li.detailAnnotation:eq(' + i + ')').addClass('active');
				}
			});
		});
		
		jQuery('#clipAddButton').on('click', function(e) {
			let label = jQuery('#clipLabel').val();
			let start = jQuery('#clipStart').val();
			let end = jQuery('#clipEnd').val();
			let data = {'representation_id': <?= $representation_id; ?>, 'save': [{
				'label': label, 'startTimecode': start, 'endTimecode': end
			}]};
			jQuery.getJSON(<?= json_encode(caNavUrl($this->request, '*', '*', 'saveAnnotations')); ?>, data, function(e) {
				jQuery('#detailAnnotations').load(<?= json_encode(caNavUrl($this->request, '*', '*', 'GetTimebasedRepresentationAnnotationList', array('id' => $subject_id, 'context' => $context, 'representation_id' => $representation_id))); ?>);
			});
			e.preventDefault();
		});
		
		jQuery('.clipDeleteButton').on('click', function(e) {
			let target = jQuery(e.target).parent();
			jQuery.getJSON(<?= json_encode(caNavUrl($this->request, '*', '*', 'saveAnnotations')); ?>, {representation_id: <?= $representation_id ?>, delete: [target.data('id')]}, function(e) {
				jQuery('#detailAnnotations').load(<?= json_encode(caNavUrl($this->request, '*', '*', 'GetTimebasedRepresentationAnnotationList', array('id' => $subject_id, 'context' => $context, 'representation_id' => $representation_id))); ?>);
			});
			e.preventDefault();
		});
		
		jQuery('#clipStartSetTime, #clipEndSetTime').on('click', function(e) {
			let target = jQuery(e.target).parent();
			let id = target.attr('id')
			if(!id) { return false; }
			id = id.replace(/SetTime$/, '');
			jQuery('#' + id).val(Math.floor(caUI.mediaPlayerManager.currentTime('<?= $player_name; ?>')) + 's');
			e.preventDefault();
		});
	});
</script>