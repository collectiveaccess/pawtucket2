<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
		
	# --- what media should be shown on the page?
	# --- first check for a video
	$va_videos = $t_object->representationsWithMimeType(array("video/x-flv", "video/mpeg", "audio/x-realaudio", "video/quicktime", "video/x-ms-asf", "video/x-ms-wmv", "application/x-shockwave-flash", "video/x-matroska"), array("versions" => array(), "checkAccess" => $this->getVar("access_values")));
	if(!sizeof($va_videos)){
		# --- then audio/images
		$va_audios = $t_object->representationsWithMimeType(array("audio/mpeg", "audio/x-aiff", "audio/x-wav", "audio/mp4"), array("checkAccess" => $this->getVar("access_values")));
		$va_images = $t_object->representationsWithMimeType(array("image/jpeg", "image/tiff", "image/png", "image/x-dcraw", "image/x-psd", "image/x-dpx", "image/jp2", "image/x-adobe-dng"), array("checkAccess" => $this->getVar("access_values")));
	}
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					# --- media
					$t_rep = new ca_object_representations();
					$vn_audio_video_rep_id = "";
					$va_audio_video_rep = array();
					$va_audio_video_media_display_info = array();
					$vn_image_rep_id = "";
					$va_image_rep = array();
					$va_image_media_display_info = array();
					$va_annotations = array();
					if(sizeof($va_videos)){
						$va_audio_video_rep = array_shift($va_videos);
						$vn_audio_video_rep_id = $va_audio_video_rep["representation_id"];
						$va_audio_video_media_display_info = caGetMediaDisplayInfo('detail', $va_audio_video_rep["mimetype"]);
					}elseif(sizeof($va_audios)){
						$va_audio_video_rep = array_shift($va_audios);
						$vn_audio_video_rep_id = $va_audio_video_rep["representation_id"];
						$va_audio_video_media_display_info = caGetMediaDisplayInfo('detail', $va_audio_video_rep["mimetype"]);
						if(sizeof($va_images)){
							$va_image_rep = array_shift($va_images);
							$vn_image_rep_id = $va_image_rep["representation_id"];
							$va_image_media_display_info = caGetMediaDisplayInfo('detail', $va_image_rep["mimetype"]);
						}
					}
					if($vn_image_rep_id){
						$t_rep->load($vn_image_rep_id);
						print "<div id='cont'>".$t_rep->getMediaTag("media", $va_image_media_display_info["display_version"], $va_image_media_display_info)."</div>";
					}
					if($vn_audio_video_rep_id){
						$t_rep->load($vn_audio_video_rep_id);
						print $t_rep->getMediaTag("media", $va_audio_video_media_display_info["display_version"], $va_audio_video_media_display_info, array("id" => "caPlayer"));
						# --- get the annotations for this audio/video rep
						$va_annotations = $t_rep->getAnnotations(array("checkAccess" => $this->getVar("access_values")));
					}
?>
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
					<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
					<HR>
					
					{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
					
					{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<?php
	if(sizeof($va_annotations)){
?>		
			<div id="detailAnnotations">
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarousel">
						<ul>
<?php
							foreach($va_annotations as $va_annotation){
								print "<li><div class='detailAnnotation'><small>".$va_annotation["startTimecode"]." - ".$va_annotation["endTimecode"]."</small><br/>";
								$va_labels = caExtractValuesByUserLocale($va_annotation["labels"]);
								foreach($va_labels as $vs_label){
									print "<a href='#' onclick='caAnnoEditorPlayerPlay(".$va_annotation["startTimecode_raw"]."); return false;'>".$vs_label."</a><br/>";
								}
								print "<div class='annotationControls'><a href='#' onclick='$(\"#detailAnnotationMoreInfo\").load(\"".caDetailUrl($this->request, "ca_representation_annotations", $va_annotation["annotation_id"])."\")'><span class='glyphicon glyphicon-info-sign'></span></a> <a href='#' onclick='caAnnoEditorPlayerPlay(".$va_annotation["startTimecode_raw"]."); return false;'><span class='glyphicon glyphicon-play-circle'></span></a></div>";
								print "</div><!-- end detailAnnotation --></li>";
							}
?>	
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailAnnotations -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
			<div id="detailAnnotationMoreInfo"></div><!-- end detailAnnotationMoreInfo -->
<?php
	}
?>
<div class="row">
	<div class='col-sm-5 col-md-5 col-lg-5 col-sm-offset-1 col-md-offset-1 col-lg-offset-1' style='border-right:1px solid #dedede;'>
		{{{<ifdef code="ca_objects.description"><span class="trimText">^ca_objects.description</span></ifdef>}}}
<?php
		# Comment and Share Tools
		if ($vn_comments_enabled | $vn_share_enabled) {
				
			print '<div id="detailTools">';
			if ($vn_comments_enabled) {
?>				
				<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
				<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
			}
			if ($vn_share_enabled) {
				print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
			}
			print '</div><!-- end detailTools -->';
		}				
?>
	</div><!-- end col -->
	<div class='col-sm-5 col-md-5 col-lg-5'>
		{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
		{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
		{{{<unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
		
		
		{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
		{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
		{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
		
		{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
		{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
		{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items"><l>^ca_list_items.preferred_labels.name_plural</l></unit> (^relationship_typename)</unit>}}}
		
	</div><!-- end col -->
</div><!-- end row -->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
	
	
	function caAnnoEditorGetPlayer() {
		if (jQuery('#mp3player') && jQuery('#mp3player')[0] && jQuery('#mp3player')[0].player) {
			if (jQuery('#mp3player')[0].player.currentTime) {
				return jQuery('#mp3player')[0].player;
			} else if (jQuery('#mp3player')[0].player.media) {
				return jQuery('#mp3player')[0].player.media;
			}
		} 
		return null;
	}
	
	function caAnnoEditorGetMediaType() {
		if (jQuery('#mp3player') && jQuery('#mp3player')[0] && jQuery('#mp3player')[0].player) {
			if (jQuery('#mp3player')[0].player.currentTime) {
				return 'VIDEO'; // videojs
			} else if (jQuery('#mp3player')[0].player.media) {
				return 'AUDIO';	// mediaelement
			}
		} 
		return null;
	}

	function caAnnoEditorPlayerPlay(s) {
		var p = caAnnoEditorGetPlayer();
		if (!p) { return false; }
		
		var mediaType = caAnnoEditorGetMediaType();
		if (mediaType == 'AUDIO') {
			// MediaElement audio player
			if (!jQuery('#mp3player').data('hasBeenPlayed')) { 
				p.play(); 
				jQuery('#mp3player').data('hasBeenPlayed', true); 
			} 
			if ((s != null) && (s != undefined)) { jQuery('#mp3player')[0].player.setCurrentTime(s); }
			p.play(); 
		} else if (mediaType == 'VIDEO') {
			// VideoJS video player
			jQuery('#mp3player').data('hasBeenPlayed', true); 
			if ((s != null) && (s != undefined)) { p.currentTime(s); }
			p.play(); 
		}
		return false;
	}

	
	
</script>