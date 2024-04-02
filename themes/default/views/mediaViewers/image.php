<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass');
$options = $this->getVar('options');
?>
<style>
	div.imageviewer-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		overflow: clip;
	}
	
	div.imageviewer-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		margin-bottom: 5x;
	}
	
	div.imageviewer-container div.mediaviewer {
		overflow: hidden;
		width: 100%; height: 100%;
	}
	
	div.imageviewer-container div.mediaviewer img {
		object-fit: contain;
		width: 100%;
		height: 100%;
	}
</style>

<div class="imageviewer-container">
<?php
	if($options['zoom'] ?? false) {
?>
	<div class="imageviewer-control-bar">
		<a href="#" id="imageviewer-zoom-in" class="imageviewer-control"><i class="bi bi-zoom-in"></i></a>
		<a href="#" id="imageviewer-zoom-out" class="imageviewer-control"><i class="bi bi-zoom-out"></i></a>
		<a href="#" id="imageviewer-home" class="imageviewer-control"><i class="bi bi-house"></i></a>
		<!--<a href="#" id="imageviewer-full-page" class="imageviewer-control"><i class="bi bi-fullscreen"></i></a>-->
	</div>
<?php
	}
?>
	<div class="mediaviewer"></div>
</div>
