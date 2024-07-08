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
			<button type="button"  id="imageviewer-zoom-in" class="btn btn-white imageviewer-control" aria-label="zoom in"><i class="bi bi-zoom-in"></i></button>
			<button type="button"  id="imageviewer-zoom-out" class="btn btn-white imageviewer-control" aria-label="zoom out"><i class="bi bi-zoom-out"></i></button>
			<button type="button"  id="imageviewer-home" class="btn btn-white imageviewer-control" aria-label="fit image"><i class="bi bi-house"></i></button>
			<!--<button type="button"  id="imageviewer-full-page" class="btn btn-white imageviewer-control" aria-label="expand"><i class="bi bi-fullscreen"></i></button>-->
		</div>
	</div>
<?php
	}
?>
	<div class="mediaviewer object-fit-contain w-100 h-100 overflow-hidden"></div>
</div>
