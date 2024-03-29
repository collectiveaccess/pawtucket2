<?php
$id = $this->getVar('id').'_'.$this->getVar('displayClass');
?>
<div class="mediaviewer" style="width: 100%; height: 400px;">
	<div data-plyr-provider='html5'>
		<video class='plyr__video-embed' preload='metadata' id='<?= $id; ?>_plyr' playsinline='1' controls data-poster='' width='400' height='400'>
			
		</video>
	</div>
</div>
