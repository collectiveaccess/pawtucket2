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
            <video playsinline="" controls="" class="plyr__video-embed" data-poster="<?= $t_rep->getMediaUrl('media', 'large'); ?>" id="mainPlayer">
                <source src="<?= $t_rep->getMediaUrl('media', 'original'); ?>" type="video/mp4">
<?php
					
						$captions = $t_rep->getCaptionFileList();
						if(is_array($captions)) {
							foreach($captions as $locale_id => $caption_track) {
								print '<track kind="captions" src="'.$caption_track['url'].'" srclang="'.substr($caption_track["locale_code"], 0, 2).'" label="'.$caption_track['locale'].'" default>';	
							}
						}
?>
            </video>
        </div>
	</div>
 </div>
<?php
									break;
								case 'audio':
?><div class="plyr-container plyr-container-audio audio-plyr-player video-embed-player is-plyr color-class-orange">
    <audio src="<?= $t_rep->getMediaUrl('media', 'mp3'); ?>" type="audio/mp3" controls="controls" class="audio-plyr" id="mainPlayer">
<?php
					
						$captions = $t_rep->getCaptionFileList();
						if(is_array($captions)) {
							foreach($captions as $locale_id => $caption_track) {
								print '<track kind="captions" src="'.$caption_track['url'].'" srclang="'.substr($caption_track["locale_code"], 0, 2).'" label="'.$caption_track['locale'].'" default>';	
							}
						}
?>
</audio>
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
							
							//if($t_rep->get('show_transcript')
	if(($t_rep->get('show_transcript', ['convertCodesToIdno' => true]) === 'yes') && ($t_rep->numSidecarFiles() > 0)) {
?>
<div class="max__640 text__eyebrow color__light_gray block-xxxs" style="margin-top:20px;">
    Transcript (<?= caNavLink($this->request, 'Download', '', '*', '*', 'downloadVTT', ['table' => 'ca_objects', 'representation_id' => $t_rep->getPrimaryKey()]); ?>)
    <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="Some transcriptions are generated automatically by computer and may contain errors.">
        <div class="trigger-icon color-icon-orange">
        <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
            <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
            <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
        </svg>
        </div>
    </span>
</div>

		<div id="transcript" style="height: 400px; font-size: 14px; line-height: 19px; margin-top:10px; overflow: auto;">
<?php
	if(is_array($caption_list = $t_rep->getCaptionFileList())) {
		$captions = array_shift($caption_list);
		$transcript = json_decode($captions['caption_content'] ?? null, true);
		$acc = [];
		foreach($transcript as $t) {
			$acc[] = "<a href='#' class='search-term-timecode' onclick='seek(this, {$t['start']})'>{$t['word']}</a>";
			if(preg_match("!\.$!", $t['word'])) { 
				print "<p style='margin-bottom: 10px;'>".join(' ', $acc)."</p>\n"; 
				$acc = [];
			}
		}
		if(sizeof($acc)) {
			print "<p>".join(' ', $acc)."</p>\n";
		}
	};
?>
							</div>
<?php
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
<script>
	jQuery(document).ready(function() {
		let player = document.getElementById("mainPlayer").plyr;
	});
	
	seek = function(e, t) {
		document.querySelectorAll('.search-term-timecode').forEach(el => el.setAttribute('aria-current', 'false'));
		document.querySelectorAll('.search-term-timecode').forEach(el => el.classList.remove('active'));
		e.classList.add('active');
		const m = document.getElementById("mainPlayer").plyr;
		
		// Seek to just before word
		m.currentTime = t-1;
		
		// Make sure video is now playing
		m.play();
	}
</script>
