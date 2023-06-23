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
		<H1>Sentences and Phrases: <?php print $t_set->get("ca_sets.preferred_labels.name"); ?></H1>
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
				print "<div class='unit'><i id='playPronunciation".$vs_rep_id."' class='fa fa-play-circle-o audioButton' aria-hidden='true'></i></div>";				
?>
				</div>
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