<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass');
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-audio-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
		
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
	
	div.mediaviewer-audio {
		width: 100%;
		height: 100%;
  	}
</style>

<div class="mediaviewer mediaviewer-audio-container">
	<div class="mediaviewer-audio" data-plyr-provider='html5'></div>
</div>
