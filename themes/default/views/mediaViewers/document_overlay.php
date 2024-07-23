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
		<button type="button" id="documentviewer-overlay-zoom-in" class="btn btn-white documentviewer-control" aria-label="Zoom in"><i class="bi bi-zoom-in"></i></button>
		<button type="button" id="documentviewer-overlay-zoom-out" class="btn btn-white documentviewer-control" aria-label="Zoom out"><i class="bi bi-zoom-out"></i></button>
		<button type="button" id="documentviewer-overlay-home" class="btn btn-white documentviewer-control" aria-label="Fit"><i class="bi bi-arrows-angle-contract"></i></button>
	
		<button type="button" id="documentviewer-overlay-previous" class="border-0 btn btn-white documentviewer-control documentviewer-control-page-nav-previous" aria-label="Previous page"><i class="bi bi-arrow-left"></i></button>
		<span id="documentviewer-overlay-currentpage"></span>
		<button type="button" id="documentviewer-overlay-next" class="border-0 btn btn-white documentviewer-control documentviewer-control-page-nav" aria-label="Next page"><i class="bi bi-arrow-right"></i></button>
	</div>
</div>

<div class="mediaviewer mediaviewer-document-overlay-container"></div>