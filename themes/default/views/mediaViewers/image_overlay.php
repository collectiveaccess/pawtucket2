<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-image-overlay-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
		
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
	
	div.mediaviewer-image-overlay-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		padding: 10px 0 10px 0;
	}
	
	div.mediaviewer-image-overlay-container img {
		object-fit: contain;
		width: 100%;
		height: 100%;
	}
</style>
<?php
	if($options['zoom'] ?? false) {
?>
<div class="mediaviewer-image-overlay-control-bar">
	<a href="#" id="imageviewer-overlay-zoom-in" class="imageviewer-control"><i class="bi bi-zoom-in"></i></a>
	<a href="#" id="imageviewer-overlay-zoom-out" class="imageviewer-control"><i class="bi bi-zoom-out"></i></a>
	<a href="#" id="imageviewer-overlay-home" class="imageviewer-control"><i class="bi bi-house"></i></a>
</div>
<?php
	}
?>
<div class="mediaviewer mediaviewer-image-overlay-container"></div>


