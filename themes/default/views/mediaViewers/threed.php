<?php
$options = $this->getVar('options');
?>
<style>
	div.threedviewer-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		overflow: clip;
	}
	
	div.threedviewer-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		margin-bottom: 5x;
	}
	
	div.threedviewer-container div.mediaviewer {
		overflow: hidden;
		width: 100%; height: 100%;
	}
	
	div.threedviewer-container div.mediaviewer img {
		object-fit: contain;
		width: 100%;
		height: 100%;
	}
</style>

<div class="threedviewer-container">
<?php
	if($options['zoom'] ?? false) {
?>
	<div class="threedviewer-control-bar">
	
	</div>
<?php
	}
?>
	<div class="mediaviewer"></div>
</div>
