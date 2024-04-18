<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-audio-container-overlay {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
</style>
<div class="mediaviewer mediaviewer-audio-container-overlay d-flex justify-content-center align-items-center">
	<div class="mediaviewer-audio w-100 h-100" data-plyr-provider='html5'></div>
</div>
