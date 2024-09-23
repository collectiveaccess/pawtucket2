<?php
$options = $this->getVar('options');
?>
<style>
	div.documentviewer-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		overflow: clip;
	}
	
	div.documentviewer-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		margin-bottom: 5px;
	}
	
	div.documentviewer-container div.mediaviewer {
		overflow: hidden;
		width: 100%; height: 100%;
	}
	
	div.documentviewer-container div.mediaviewer img {
		/*object-position:top;*/
		width: 100%;
		height: 100%;
	}
</style>

<div class="documentviewer-container">
<?php
	if($options['zoom'] ?? false) {
?>
	<div class="documentviewer-control-bar">
		<div id="documentviewer-currentpage"></div>
		<button type="button" id="documentviewer-zoom-in" class="btn btn-white documentviewer-control" aria-label="zoom in"><i class="bi bi-zoom-in"></i></button>
		<button type="button" id="documentviewer-zoom-out" class="btn btn-white documentviewer-control" aria-label="zoom out"><i class="bi bi-zoom-out"></i></button>
		<button type="button" id="documentviewer-home" class="btn btn-white documentviewer-control" aria-label="fit"><i class="bi bi-arrows-angle-contract"></i></button>
		<!--<button id="documentviewer-full-page" class="documentviewer-control" aria-label="expand"><i class="bi bi-fullscreen"></i></button>-->
		
		<button type="button" id="documentviewer-previous" class="border-0 btn btn-white documentviewer-control" aria-label="previous page"><i class="bi bi-arrow-left"></i></button>
		<button type="button" id="documentviewer-next" class="border-0 btn btn-white documentviewer-control" aria-label="next page"><i class="bi bi-arrow-right"></i></button>
	</div>
<?php
	}
?>
	<div class="mediaviewer object-fit-contain w-100 h-100"></div>
</div>
