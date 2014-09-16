<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$pn_representation_id = $this->getVar("representation_id");
	# --- media
	$va_audios = $t_object->representationsWithMimeType(array("audio/mpeg", "audio/x-aiff", "audio/x-wav", "audio/mp4"), array("checkAccess" => $this->getVar("access_values")));
	$t_rep = new ca_object_representations();
	$vn_audio_rep_id = "";
	$va_audio_rep = array();
	$va_audio_media_display_info = array();
	$va_annotations = array();
	if(sizeof($va_audios)){
		# --- if a rep_id was passed use that instead of the primary rep
		if($pn_representation_id){
			$va_audio_rep = $va_audios[$pn_representation_id];
			unset($va_audios[$pn_representation_id]);
		}else{
			$va_audio_rep = array_shift($va_audios);
		}
		$vn_audio_rep_id = $va_audio_rep["representation_id"];
		$va_audio_media_display_info = caGetMediaDisplayInfo('detail', $va_audio_rep["mimetype"]);
	}
	$va_transcript = $t_object->representationsWithMimeType(array("application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation"), array("checkAccess" => $this->getVar("access_values")));
	# --- is there a transcript/ doc to show
	if(sizeof($va_transcript)){
		$va_transcript = array_shift($va_transcript);
		$vn_transcript_rep_id = $va_transcript["representation_id"];
		$va_doc_media_display_info = caGetMediaDisplayInfo('detail', $va_transcript["mimetype"]);
		$vs_transcript_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $vn_transcript_rep_id, 'overlay' => 1))."\"); return false;' title='"._t("Transcript")."'><i class='fa fa-file-text-o'></i> TRANSCRIPT</a>\n";
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
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<H1>{{{<unit relativeTo="ca_collections" delimiter="_➔_"><l>^ca_collections.hierarchy.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
					if($vn_audio_rep_id){
						$t_rep->load($vn_audio_rep_id);
						$va_annotations = $t_rep->getAnnotations(array("checkAccess" => $this->getVar("access_values")));
						#print_r($va_annotations);
						print $t_rep->getMediaTag("media", $va_audio_media_display_info["display_version"], $va_audio_media_display_info, array("id" => "caPlayer"));
					}
?>
					<div id="detailTools">						
						<div class="detailTool detailToolRight"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
<?php
						print "<div class='detailTool'>";
						if(caObjectsDisplayDownloadLink($this->request) && ($vn_audio_rep_id)){
							# -- get version to download configured in media_display.conf
							$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
							$vs_download_version = $va_download_display_info['display_version'];
							print caNavLink($this->request, " <span class='glyphicon glyphicon-download-alt'></span>", '', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $t_object->get("object_id"), "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")))."&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						print $vs_transcript_link;
						print "</div>";
?>
					</div>
					<HR class="dark"/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12 col-md-6 col-lg-6'>
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="interviewer" delimiter=";"><H3>Interviewer:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="interviewee" delimiter=";"><H3>Interviewee:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="speaker" delimiter=";"><H3>Speaker:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="sponsoring_body" delimiter=";"><H3>Sponsoring Body:</H3><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					{{{<ifdef code="ca_objects.pbcoreDate.pbcoreDates_value"><H3>Date:</H3>^ca_objects.pbcoreDate.pbcoreDates_value<br/></ifdef>}}}
					{{{<ifcount code="ca_objects.LcshTopical" min="1" max="1"><H3>Subject Heading:</H3></ifcount>}}}
					{{{<ifcount code="ca_objects.LcshTopical" min="2"><H3>Subject Headings:</H3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshTopical</unit>}}}
					{{{<ifcount code="ca_objects.LcshNames" min="1" max="1"><H3>Term:</H3></ifcount>}}}
					{{{<ifcount code="ca_objects.LcshNames" min="2"><H3>Terms:</H3></ifcount>}}}
					{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}				
				</div><!-- end col -->
				<div class='col-sm-12 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_objects.pbcoreFormatLocation"><H3>Location:</H3>^ca_objects.pbcoreFormatLocation<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><H3>Identifier:</H3>^ca_objects.idno<br/></ifdef>}}}
					{{{<h3>MLA Citation:</h3><i>^ca_objects.preferred_labels.name</i>. <ifdef code="ca_objects.dateSet.setDisplayValue"><unit>^ca_objects.dateSet.setDisplayValue</unit>. </ifdef><ifcount code="ca_collections" min="1" max="1"><unit>^ca_collections.hierarchy.preferred_labels.name</unit>. </ifcount><i>New School Archives and Special Collections Digital Archive</i>. Web. ^DATE}}}
<?php
					if(sizeof($va_audios > 1)){
						foreach($va_audios as $va_audio){
							print "<H3>Additional Audio</H3>";
							print caDetailLink($this->request, '<span class="glyphicon glyphicon-volume-up"></span> '.$va_audio["label"], '', 'ca_objects', $t_object->get("object_id"), array("representation_id" => $va_audio["representation_id"]))."<br/>";
						}
					}
					if(sizeof($va_annotations)){
						print "<H3>Clips</H3>";
						$t_annotation = new ca_representation_annotations();
						foreach($va_annotations as $va_annotation){
							$t_annotation->load($va_annotation["annotation_id"]);
							$va_labels = caExtractValuesByUserLocale($va_annotation["labels"]);
							print "<p>";
							foreach($va_labels as $vs_label){
								print "<a href='#' onclick='caAnnoEditorPlayerPlay(".$va_annotation["startTimecode_raw"]."); return false;'><strong>".$vs_label."</strong></a><br/>";
							}
							print "<a href='#' onclick='caAnnoEditorPlayerPlay(".$va_annotation["startTimecode_raw"]."); return false;'><span class='glyphicon glyphicon-play-circle'></span></a> ".$va_annotation["startTimecode"]." - ".$va_annotation["endTimecode"];
							print "<div class='indent'>";
							if($t_annotation->get("description")){
								print "<p>".$t_annotation->get("description")."</p>";
							}
							if($t_annotation->get("ca_entities.preferred_labels")){
								print "<strong class='uppercase'>"._t("Related people/organizations")."</strong><br/>".$t_annotation->get("ca_entities.preferred_labels", array("delimiter" => ", ", "returnAsLink" => true));
							}
							print "</div></p>";
						}

					}
?>
				
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
<?php
					if($t_object->get("ca_objects.pbcoreDescription.pBdescription_text")){
?>
						<HR class="dark"/><H3>Description <span class="transcript"><?php print $vs_transcript_link; ?></span></H3><br/><?php print $t_object->get("ca_objects.pbcoreDescription.pBdescription_text"); ?><br/>				
<?php
					}
?>
					
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



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
	
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