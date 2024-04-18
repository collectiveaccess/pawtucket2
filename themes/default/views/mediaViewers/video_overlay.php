<?php	
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-video-container-overlay {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
	div.mediaviewer-video-container-overlay > div{
		width:100%; /* makes the preview full width while loading the video */
	}
</style>
<div class="mediaviewer mediaviewer-video-container-overlay">
	<div data-plyr-provider='html5'></div>
</div>
