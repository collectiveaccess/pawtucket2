<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-image-overlay-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
	
	div.mediaviewer-image-overlay-control-bar {
		
	}
	
	div.mediaviewer-image-overlay-container img {
		width: 100%;
		height: 100%;
	}
</style>
<?php
	if($options['zoom'] ?? false) {
?>
<div class="mediaviewer-image-overlay-control-bar text-center bg-white py-2">
	<div class="btn-group" role="group" aria-label="Viewer Controls">
		<a href="#" id="imageviewer-overlay-zoom-in" class="btn btn-white imageviewer-control" role="button" aria-label="Zoom in"><i class="bi bi-zoom-in"></i></a>
		<a href="#" id="imageviewer-overlay-zoom-out" class="btn btn-white imageviewer-control" role="button" aria-label="Zoom out"><i class="bi bi-zoom-out"></i></a>
		<a href="#" id="imageviewer-overlay-home" class="btn btn-white imageviewer-control" role="button" aria-label="Fit"><i class="bi bi-arrows-angle-contract"></i></a>
	</div>
</div>
<?php
	}
?>
<div class="mediaviewer mediaviewer-image-overlay-container"></div>


