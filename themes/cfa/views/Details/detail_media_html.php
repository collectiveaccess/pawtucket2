<?php
	$t_object = $this->getVar("item");
	$reps = $t_object->getRepresentations(['small', 'large', 'mp3', 'h264_hi', 'original'], null, ['poster_frame_url' => $t_object->get('ca_object_representations.media.small.url'),'checkAccess' => [1]]);


	// We might need to alter how we output media if any audio or video is present...  but for now 
	// just determine if there's audio/video and set var until FOUO tells us what the real fix is (it's not removing the slider - tested that)
	$has_av = (sizeof(array_filter($reps, function($v) {
		return in_array(caGetMediaClass($v['mimetype']), ['audio', 'video']);
	})) > 0);	
?>
<div class="slider-container module_slideshow slideshow-single-collection over-black fade-captions">
    <div class="slick-slider dots-white dots-centered">
					<?php
						$active = true;
						foreach($reps as $r) {
?>
        <!-- slide -->
        <div class="slide-wrap">
<?php
							$media_class = caGetMediaClass($r['mimetype']);
							$t_rep = ca_object_representations::findAsInstance($r['representation_id']);
							$viewer = MediaViewerManager::getViewerForMimetype('detail', $r['mimetype']);
							
							$class = caGetMediaClass($r['mimetype']);
							
							
							switch($class) {
								case 'video':
?><div class="video-container-black">
	<div class="video-embed-player is-plyr">
        <div class="ratio-sizer">
            <video playsinline="" controls="" class="plyr__video-embed" data-poster="<?= $t_rep->getMediaUrl('media', 'large'); ?>">
                <source src="<?= $t_rep->getMediaUrl('media', 'original'); ?>" type="video/mp4">
            </video>
        </div>
	</div>
 </div>
<?php
									break;
								case 'audio':
?><div class="plyr-container plyr-container-audio audio-plyr-player video-embed-player is-plyr color-class-orange">
    <audio src="<?= $t_rep->getMediaUrl('media', 'mp3'); ?>" type="audio/mp3" controls="controls" class="audio-plyr"></audio>
</div><?php
									break;
								case 'image':
?> <div class="sizer">
        <div class="item">
            <div style="margin: 0 50% 0 50%;"><?= $t_rep->getMediaTag('media', 'mediumlarge'); ?></div>
        </div>
    </div><?php
									break;
								case 'document':
									print "<div style='height: 700px;'>".$viewer::getViewerHTML(
										$this->request, 
										"representation:".$r['representation_id'], 
										[
											't_instance' => $t_rep, 't_subject' => $t_object, 
											'display' => $display_info = caGetMediaDisplayInfo('detail', $r['mimetype']), 
											'display_type' => 'detail'
										],
										[ 
											'hideAllOverlayControls' => true, 'dontInitPlyr' => true
										]
									)."</div>"; 
									break;
							}
?>
        </div>
        <!-- slide -->
<?php
						}
						
						if(count($reps) == 0 && count($reps) == 0){
					?>
						<div class="d-flex align-items-center p-5 no-media-wrapper" style="height: 400px;">
							<div class="no-media">Digitized media for this item is not currently available online, please email info@chicagofilmarchives.org to inquire.</div>
						</div>
					<?php
						}
					?>
				
    </div>
    <ul class="captions text__caption img-caption">
		{{{<ifdef code="ca_object_representations.caption">		
			<li>^ca_object_representations.caption</li>
		</ifdef>}}}
    </ul>
</div>