<?php
$options = $this->getVar('options');
?>
<style>
	div.imageviewer-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		overflow: clip;
	}
	div.imageviewer-container div.mediaviewer img {
		/*object-position:top; */
		width:100%;
		height:100%;
	}
</style>

<div class="imageviewer-container">
<?php
	if($options['zoom'] ?? false) {
?>
	<div class="imageviewer-control-bar text-left">
		<div class="btn-group" role="group" aria-label="Viewer Controls">
			<a href="#" id="imageviewer-zoom-in" class="btn btn-white imageviewer-control" role="button" aria-label="zoom in"><i class="bi bi-zoom-in"></i></a>
			<a href="#" id="imageviewer-zoom-out" class="btn btn-white imageviewer-control" role="button" aria-label="zoom out"><i class="bi bi-zoom-out"></i></a>
			<a href="#" id="imageviewer-home" class="btn btn-white imageviewer-control" role="button" aria-label="fit image"><i class="bi bi-house"></i></a>
			<!--<a href="#" id="imageviewer-full-page" class="btn btn-white imageviewer-control" role="button" aria-label="expand"><i class="bi bi-fullscreen"></i></a>-->
		</div>
	</div>
<?php
	}
?>
	<div class="mediaviewer object-fit-contain w-100 h-100 overflow-hidden"></div>
</div>
