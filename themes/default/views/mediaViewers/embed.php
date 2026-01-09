<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-embed-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
	div.mediaviewer-embed-container > div{
		width:100%; 
	}
</style>
<div class="mediaviewer mediaviewer-embed-container d-flex justify-content-center align-items-center">
</div>
