<?php
$representations = $this->getVar('representations');
$start_times = $this->getVar('startTimes');
$end_times = $this->getVar('endTimes');
if(is_array($representations)) {
	$percent = "50";
?>
<div id="caMediaOverlayContent" >
	<table style="width: 100%">
		<tr>
<?php
	$init = true;
	foreach($representations as $i => $rep) {
		$mimetype = $rep->getMediaInfo('media', 'original', 'MIMETYPE');
		if(!in_array(caGetMediaClass($mimetype), ['audio', 'video'], true)) { continue; }
		if(($i > 0) && (($i % 2) == 0))  {
			print "</tr><tr>";
		}
		print "<td style='width:{$percent}% !important;'>".$rep->getMediaTag('media', 'original', [
			'class' => '', 'width' => "{$percent}%", 'id' => 'comparePlayer_'.$i,
			'start' => $start_times[$i], 'end' => $end_times[$i], 'autoplay' => true, 'init' => $init
		])."</td>";
		$init = false;
	}
}
?>
		</tr>
	</table>
	
	<div class="caMediaOverlayControls">
		<a href="#" id="compareAllControl" data-mode="stop"><?= _t('Stop all'); ?></a>
		<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><i class="fa fa-times" aria-hidden="true"></i></a></div>
	</div>
</div>

<script type="text/javascript">
	caUI.initMediaPlayerManager();
	jQuery('#compareAllControl').on('click', function(e) {
		let l = jQuery('#compareAllControl');
		let m = l.data('mode');
		
		if(m === "stop") {
			caUI.mediaPlayerManager.stopAll();
			l.text("<?= _t('Play all'); ?>").data('mode', 'play');
		} else {
			caUI.mediaPlayerManager.playAll();
			l.text("<?= _t('Stop all'); ?>").data('mode', 'stop');
		}
	});
</script>
