<?php
	$t_object = $this->getVar("item");
	$reps = $t_object->getRepresentations(['small', 'large', 'mp3', 'h264_hi', 'original'], null, ['poster_frame_url' => $t_object->get('ca_object_representations.media.small.url'),'checkAccess' => [1]]);


	// We might need to alter how we output media if any audio or video is present...  but for now 
	// just determine if there's audio/video and set var until FOUO tells us what the real fix is (it's not removing the slider - tested that)
	$has_av = (sizeof(array_filter($reps, function($v) {
		return in_array(caGetMediaClass($v['mimetype']), ['audio', 'video']);
	})) > 0);	
?>
<div class="slider-container module_slideshow slideshow-single-collection over-black autoplay fade-captions">
    <div class="slick-slider dots-white dots-centered">
        <!-- slide -->
        <div class="slide-wrap">
            <div class="image-sizer ">
                <div class="img-wrapper">
					<?php
						$active = true;
						foreach($reps as $r) {
							$t_rep = ca_object_representations::findAsInstance($r['representation_id']);
							$viewer = MediaViewerManager::getViewerForMimetype('detail', $r['mimetype']);
						
							print $viewer::getViewerHTML(
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
							);
							$active = false;
						}
						
						if(count($reps) == 0 && count($reps) == 0){
					?>
						<div class="d-flex align-items-center p-5" style="height: 400px;">
							<div class="no-media">Digitized media for this item is not currently available online, please email info@chicagofilmarchives.org to inquire.</div>
						</div>
					<?php
						}
					?>
				
				</div>
            </div>
        </div>
        <!-- slide -->
    </div>
    <ul class="captions text__caption img-caption">
		{{{<ifdef code="ca_object_representations.caption">		
			<li>^ca_object_representations.caption</li>
		</ifdef>}}}
    </ul>
</div>