<?php
	$va_access_values = $this->getVar("access_values");
	$t_object = $this->getVar("object");
?>
<div class='row'>
	<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
		<div class='row'>
			<div class="col-sm-6">
				<div class='alphabetLetter'>
					<?php print $t_object->getWithTemplate("^ca_objects.preferred_labels.name"); ?>
				</div>
			</div>
			<div class="col-sm-6">
				<div class='alphabetLetterInfo'>
<?php
					print $t_object->getWithTemplate("<ifdef code='ca_objects.sounds_like'><div class='unit'><label>Sounds Like</label>^ca_objects.sounds_like</unit></ifdef>
															<ifdef code='ca_objects.example'><div class='unit'><label>Example</label>^ca_objects.example</unit></ifdef>
															<ifdef code='ca_objects.meaning'><div class='unit'><label>Meaning</label>^ca_objects.meaning</unit></ifdef>");
					$vs_rep_id = $t_object->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values));
					$vs_rep_url = $t_object->get("ca_object_representations.media.mp3.url", array("checkAccess" => $va_access_values));
					$vs_caption = $t_object->get("ca_object_representations.caption", array("checkAccess" => $va_access_values));
					if($vs_caption){
						print "<div class='unit'><label>Credit</label>".$vs_caption."</div>";
					}
					if($vs_rep_url){
						print "<div class='unit text-center'><i id='playPronunciationIcon".$vs_rep_id."' onClick='playAudio(\"".$vs_rep_id."\")' class='far fa-play-circle audioButton' aria-hidden='true'></i></div>";
						print "<audio id='playPronunciation".$vs_rep_id."' class='audioPlayer' controls='' onended='audioEnded(".$vs_rep_id.")' style='display: none'><source src='".$vs_rep_url."' type='audio/mp3'>Your browser does not support the audio element.</audio>";				
?>
						
						<script type='text/javascript'>
							function playAudio(audioId) {
								var audio = document.getElementById("playPronunciation" + audioId);
								var audios = document.getElementsByTagName('audio');
								if($(".audioButton").hasClass('fa-stop-circle-o')){
									$(".audioButton").addClass('fa-play-circle-o');
									$(".audioButton").removeClass('fa-stop-circle-o');
								}
								if(audio.paused){
									$("#playPronunciationIcon" + audioId).addClass('fa-stop-circle');
									$("#playPronunciationIcon" + audioId).removeClass('fa-play-circle');
									for(var i = 0, len = audios.length; i < len;i++){
										if(!audios[i].paused){
											audios[i].pause();
											audios[i].currentTime = 0;
										}
									}
									audio.play();
		
								}else{
									$("#playPronunciationIcon" + audioId).removeClass('fa-stop-circle');
									$("#playPronunciationIcon" + audioId).addClass('fa-play-circle');
									audio.pause();
									audio.currentTime = 0;
								}
							}
							function audioEnded(audioId){
								$("#playPronunciationIcon" + audioId).removeClass('fa-stop-circle');
								$("#playPronunciationIcon" + audioId).addClass('fa-play-circle');
							}

						</script>
<?php
					}

					#print $t_object->getWithTemplate("<unit relativeTo='ca_object_representations' delimiter=''><div class='unit'>^ca_object_representations.media.original</div><ifdef code='ca_object_representations.caption'><div class='unit'><small>^ca_object_representations.caption</small></div></ifdef></unit>", array("checkAccess" => $va_access_values));
?>
				</div>
			</div>
		</div>
	</div>
</div>
