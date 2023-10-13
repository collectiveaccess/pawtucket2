<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
	#print_r($t_object->representationsOfClass("image", array("checkAccess" => $va_access_values, "version" => "large")));
	#print_r($t_object->representationsOfClass("audio", array("checkAccess" => $va_access_values)));

	$va_images = $t_object->representationsOfClass("image", array("version" => "large"));
	$va_image_tags = $va_audio_files = array();
	$vb_image = $vb_audio = false;
	if(is_array($va_images) && sizeof($va_images)){
		foreach($va_images as $va_image){
			if(in_array($va_image["access"], $va_access_values)){
				$va_image_tags[] = $va_image["tags"]["large"];
				$vb_image = true;
			}
		}
	}
	$va_audio = $t_object->representationsOfClass("audio", array("version" => "original"));
	if(is_array($va_audio) && sizeof($va_audio)){
		foreach($va_audio as $va_audio_file){
			if(in_array($va_audio_file["access"], $va_access_values)){
				$va_audio_files[$va_audio_file["representation_id"]]["url"] = $va_audio_file["urls"]["original"];
				$vb_audio = true;
				$t_representation = new ca_object_representations($va_audio_file["representation_id"]);
				$vs_caption = $t_representation->getWithTemplate("<ifdef code='ca_object_representations.speaker'><unit relativeTo='ca_object_representations.speaker' delimiter='<br>'><ifdef code='ca_object_representations.speaker.speaker_name'>^ca_object_representations.speaker.speaker_name</ifdef><ifdef code='ca_object_representations.speaker.speaker_name,ca_object_representations.speaker.speaker_type'>, </ifdef><ifdef code='ca_object_representations.speaker.speaker_type'>^ca_object_representations.speaker.speaker_type</ifdef></unit></ifdef>");
				$va_audio_files[$va_audio_file["representation_id"]]["caption"] = $vs_caption;
			}
		}
	}
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
<?php
		if($vb_image){
?>
			<div class="col-sm-12 col-md-4 col-md-offset-1 detailImage">
<?php
				print implode("<br/><br/>", $va_image_tags);
?>			
			</div>
<?php
		}
?>
			<div class="col-sm-12 <?php print ($vb_image) ? "col-md-6" : "col-md-10 col-md-offset-1"; ?> bgLtBrown">
				<div class="detailLanguageInfo">
					<H1>{{{^ca_objects.preferred_labels.name<ifdef code="ca_objects.meaning"> &mdash; ^ca_objects.meaning</ifdef>}}}</H1>
					{{{<ifdef code="ca_objects.word_morpheme_type"><div class="unit">Part of speech: ^ca_objects.word_morpheme_type</div></ifdef>}}}
					{{{<ifdef code="ca_objects.sentence"><div class="unit"><b><unit relativeTo="ca_objects.sentence" delimiter="<br/>">^ca_objects.sentence</unit></b><ifdef code="ca_objects.sentence_translation"><br><unit relativeTo="ca_objects.sentence_translation" delimiter="<br/>">^ca_objects.sentence_translation</unit></div></ifdef>}}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1">
				<div class="row">
<?php
			
			if(is_array($va_audio_files) && sizeof($va_audio_files)){	
				foreach($va_audio_files as $vn_rep_id => $va_audio_file){
					print "<div class='text-center col-sm-6 col-md-4 col-lg-3'>";
					print "<div class='unit audioPlayerContainer bgLtBeige'><i id='playPronunciationIcon".$vn_rep_id."' onClick='playAudio(\"".$vn_rep_id."\")' class='fa fa-play-circle-o audioButton' aria-hidden='true'></i>";
					if($va_audio_file["caption"]){
						print "<br/>".$va_audio_file["caption"];
					}
					print "<audio id='playPronunciation".$vn_rep_id."' class='audioPlayer' controls='' onended='audioEnded(".$vn_rep_id.")' style='display: none'><source src='".$va_audio_file["url"]."' type='audio/mp3'>Your browser does not support the audio element.</audio>";
					print "</div></div>";
				}
			}			
?>
				</div>
			</div>
		</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
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
		
	function playAudio(audioId) {
		var audio = document.getElementById("playPronunciation" + audioId);
		var audios = document.getElementsByTagName('audio');
		if($(".audioButton").hasClass('fa-stop-circle-o')){
			$(".audioButton").addClass('fa-play-circle-o');
			$(".audioButton").removeClass('fa-stop-circle-o');
		}
		if(audio.paused){
			$("#playPronunciationIcon" + audioId).addClass('fa-stop-circle-o');
			$("#playPronunciationIcon" + audioId).removeClass('fa-play-circle-o');
			for(var i = 0, len = audios.length; i < len;i++){
				if(!audios[i].paused){
					audios[i].pause();
					audios[i].currentTime = 0;
				}
			}
			audio.play();
			
		}else{
			$("#playPronunciationIcon" + audioId).removeClass('fa-stop-circle-o');
			$("#playPronunciationIcon" + audioId).addClass('fa-play-circle-o');
			audio.pause();
			audio.currentTime = 0;
		}
	}
	function audioEnded(audioId){
		$("#playPronunciationIcon" + audioId).removeClass('fa-stop-circle-o');
		$("#playPronunciationIcon" + audioId).addClass('fa-play-circle-o');
	}
	
	
</script>
