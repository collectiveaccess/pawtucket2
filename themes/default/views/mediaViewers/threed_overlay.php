<?php
$options = $this->getVar('options');
?>
<style>
	div.mediaviewer-threed-overlay-container {
		width: <?= caGetOption('width', $options, '100%'); ?>; 
		height: <?= caGetOption('height', $options, '100%'); ?>;
		
		overflow: clip;
		
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
	
	div.mediaviewer-threed-overlay-control-bar {
		display: flex;
		flex-direction: row;
		justify-content: space-evenly;
		padding: 10px 0 10px 0;
	}
	
	div.mediaviewer-threed-overlay-container img {
		object-fit: contain;
		width: 100%;
		height: 100%;
	}
</style>
<?php
	if($options['zoom'] ?? false) {
?>

<?php
	}
?>
<div class="mediaviewer mediaviewer-threed-overlay-container"></div>


