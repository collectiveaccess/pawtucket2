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
		object-fit: contain;
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
		<a href="#" id="documentviewer-zoom-in" class="documentviewer-control"><i class="bi bi-zoom-in"></i></a>
		<a href="#" id="documentviewer-zoom-out" class="documentviewer-control"><i class="bi bi-zoom-out"></i></a>
		<a href="#" id="documentviewer-home" class="documentviewer-control"><i class="bi bi-house"></i></a>
		<!--<a href="#" id="documentviewer-full-page" class="documentviewer-control"><i class="bi bi-fullscreen"></i></a>-->
		
		<a href="#" id="documentviewer-previous" class="documentviewer-control"><i class="bi bi-arrow-left"></i></a>
		<a href="#" id="documentviewer-next" class="documentviewer-control"><i class="bi bi-arrow-right"></i></a>
	</div>
<?php
	}
?>
	<div class="mediaviewer"></div>
</div>
