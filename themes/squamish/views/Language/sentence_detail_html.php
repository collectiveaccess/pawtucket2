<?php

	$va_access_values = $this->getVar("access_values");
	
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$va_set_item_row_ids = $this->getVar("set_item_row_ids");
	$va_row_to_item_ids = $this->getVar("row_to_item_ids");
	$va_set_items = $this->getVar("set_items");
	$qr_objects = $this->getVar("set_items_as_search_result");
?>
<div class="row bg_dark_eye pageHeaderRow">
	<div class="col-sm-12">
		<H1><?php print caNavLink($this->request, "<i class='fa fa-angle-left' role='button' aria-label='back'></i> Sentences and Phrases", "", "", "Language", "Sentences"); ?>: <?php print $t_set->get("ca_sets.preferred_labels.name"); ?></H1>
<?php
		if($vs_desc = $t_set->get("ca_sets.set_description")){
			print "<p>".$vs_desc."</p>";
		}
?>
	</div>
</div>
<div class='row'>
	<div class="col-lg-10 col-lg-offset-1 col-md-12">
<?php	
	$vn_i = 0;
	$vn_cols = 2;
	if($qr_objects->numHits()){
		print "<div class='row'>";
		while($qr_objects->nextHit()) {
			if($vn_i == $vn_cols){
				$vn_i = 0;
				print "</div><div class='row'>";
			}
			print "\n<div class='col-sm-12 col-md-6'><div class='beigeCard'>";
			print "<div class='cardTitle'>".$qr_objects->getWithTemplate("^ca_objects.preferred_labels.name")."</div>";
			print "<div class='row'><div class='col-sm-9'>";
			print $qr_objects->getWithTemplate("<ifdef code='ca_objects.meaning'><div class='unit'><label>Meaning</label>^ca_objects.meaning</unit></ifdef>");
			$vs_rep_id = $qr_objects->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values));
			$vs_rep_url = $qr_objects->get("ca_object_representations.media.mp3.url", array("checkAccess" => $va_access_values));
			$vs_caption = $qr_objects->get("ca_object_representations.caption", array("checkAccess" => $va_access_values));
			if($vs_caption){
				print "<div class='unit'><label>Credit</label>".$vs_caption."</div>";
			}
			print "</div><!-- end col 9-->\n";
			if($vs_rep_url){				
?>
				<div class="col-sm-3 text-center">
<?php
				print "<div class='unit'><i id='playPronunciationIcon".$vs_rep_id."' onClick='playAudio(\"".$vs_rep_id."\")' class='fa fa-play-circle-o audioButton' aria-hidden='true'></i></div>";				
				print "<audio id='playPronunciation".$vs_rep_id."' class='audioPlayer' controls='' onended='audioEnded(".$vs_rep_id.")' style='display: none'><source src='".$vs_rep_url."' type='audio/mp3'>Your browser does not support the audio element.</audio>";				

?>
				</div>
				<script type='text/javascript'>
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
<?php
			}
			
			print "</div></div></div>\n";
			$vn_i++;
		}
		if($vn_i > 0){
			print "</div>";
		}
	}
?>
	</div>
</div>