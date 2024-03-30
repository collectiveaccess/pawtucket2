<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass');
?>
<style>
	.mediaviewer-audio-container {
		display: flex;
  		align-items: center;
  		justify-content: center;
	}
	.mediaviewer-audio {
		width: 100%;
		height: 100%;
  	}
</style>
<div class="mediaviewer mediaviewer-audio-container" style="width: 100%; height: 400px;">
	<div class="mediaviewer-audio" data-plyr-provider='html5'>
		<audio class='plyr__audio-embed' preload='metadata' id='<?= $id; ?>_plyr' playsinline='1' controls></audio>
	</div>
</div>
