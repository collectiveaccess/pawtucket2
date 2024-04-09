<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-video-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
	div.mediaviewer-video-container > div{
		width:100%; /* makes the preview full width while loading the video */
	}
</style>
<div class="mediaviewer mediaviewer-video-container d-flex justify-content-center align-items-center">
</div>
