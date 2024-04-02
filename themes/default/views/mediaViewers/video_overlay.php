<?php	
$id = $this->getVar('id').'_'.$this->getVar('displayClass').'_overlay';
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-video-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
		
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
</style>
<div class="mediaviewer mediaviewer-video-container">
	<div data-plyr-provider='html5'></div>
</div>
