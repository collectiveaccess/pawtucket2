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
						print "<div class='unit text-center'><i id='playPronunciation".$vs_rep_id."' class='fa fa-play-circle-o audioButton' aria-hidden='true'></i></div>";				
?>
						<script type='text/javascript'>
							$(document).ready(function() {
								var audioElement<?php print $vs_rep_id; ?> = document.createElement('audio');
								audioElement<?php print $vs_rep_id; ?>.setAttribute('src', '<?php print $vs_rep_url; ?>');
								$('#playPronunciation<?php print $vs_rep_id; ?>').click(function() {
									//return audioElement<?php print $vs_rep_id; ?>.paused ? audioElement<?php print $vs_rep_id; ?>.play() : audioElement<?php print $vs_rep_id; ?>.pause();
							
									if(audioElement<?php print $vs_rep_id; ?>.paused){
										$('#playPronunciation<?php print $vs_rep_id; ?>').removeClass('fa-play-circle-o');
										$('#playPronunciation<?php print $vs_rep_id; ?>').addClass('fa-pause-circle-o');
										return audioElement<?php print $vs_rep_id; ?>.play();
									}else{
										$('#playPronunciation<?php print $vs_rep_id; ?>').removeClass('fa-pause-circle-o');
										$('#playPronunciation<?php print $vs_rep_id; ?>').addClass('fa-play-circle-o');
										return audioElement<?php print $vs_rep_id; ?>.pause();
									}
								});
							});
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