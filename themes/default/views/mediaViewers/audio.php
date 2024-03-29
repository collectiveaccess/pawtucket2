<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass');
?>
<div class="mediaviewer" style="width: 100%; height: 400px;">
	<div data-plyr-provider='html5'>
		<audio class='plyr__audio-embed' preload='metadata' id='<?= $id; ?>_plyr' playsinline='1' controls width='400' height='400'>
			
		</audio>
	</div>
</div>
