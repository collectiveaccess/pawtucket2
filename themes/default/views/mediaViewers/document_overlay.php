<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-document-overlay-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
	}
</style>


</style>

<div class="mediaviewer-document-overlay-control-bar text-center bg-white py-2">
	<div class="btn-group align-items-center" role="group" aria-label="Viewer Controls">
		<a href="#" id="documentviewer-overlay-zoom-in" class="btn btn-white documentviewer-control" role="button" aria-label="Zoom in"><i class="bi bi-zoom-in"></i></a>
		<a href="#" id="documentviewer-overlay-zoom-out" class="btn btn-white documentviewer-control" role="button" aria-label="Zoom out"><i class="bi bi-zoom-out"></i></a>
		<a href="#" id="documentviewer-overlay-home" class="btn btn-white documentviewer-control" role="button" aria-label="Fit"><i class="bi bi-arrows-angle-contract"></i></a>
	
		<a href="#" id="documentviewer-overlay-previous" class="btn btn-white documentviewer-control" role="button" aria-label="Previous page"><i class="bi bi-arrow-left"></i></a>
		<span id="documentviewer-overlay-currentpage"></span>
		<a href="#" id="documentviewer-overlay-next" class="btn btn-white documentviewer-control" role="button" aria-label="Next Page"><i class="bi bi-arrow-right"></i></a>
	</div>
</div>

<div class="mediaviewer mediaviewer-document-overlay-container"></div>


