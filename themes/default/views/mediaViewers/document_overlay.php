<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass').'_overlay';
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-document-overlay-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
		
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
	
	div.mediaviewer-document-overlay-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		margin: 10px 0 10px 0;
	}
</style>


</style>

<div class="mediaviewer-document-overlay-control-bar">
	<div id="documentviewer-overlay-currentpage"></div>
	<a href="#" id="documentviewer-overlay-zoom-in" class="documentviewer-control"><i class="bi bi-zoom-in"></i></a>
	<a href="#" id="documentviewer-overlay-zoom-out" class="documentviewer-control"><i class="bi bi-zoom-out"></i></a>
	<a href="#" id="documentviewer-overlay-home" class="documentviewer-control"><i class="bi bi-house"></i></a>
	<!--<a href="#" id="documentviewer-overlay-full-page" class="documentviewer-control"><i class="bi bi-fullscreen"></i></a>-->
	
	<a href="#" id="documentviewer-overlay-previous" class="documentviewer-control"><i class="bi bi-arrow-left"></i></a>
	<a href="#" id="documentviewer-overlay-next" class="documentviewer-control"><i class="bi bi-arrow-right"></i></a>
</div>

<div class="mediaviewer mediaviewer-document-overlay-container"></div>


