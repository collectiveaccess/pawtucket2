<?php	
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-embed-container-overlay {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
	div.mediaviewer-embed-container-overlay > div{
		width:100%; 
	}
</style>
<div class="mediaviewer mediaviewer-embed-container-overlay">

</div>
