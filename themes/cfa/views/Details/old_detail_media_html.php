<?php
	$t_object = $this->getVar("item");
	$reps = $t_object->getRepresentations(['small', 'mp3', 'h264_hi', 'original'], null, ['poster_frame_url' => $t_object->get('ca_object_representations.media.small.url'),'checkAccess' => [1]]);
?>

<div id="carouselIndicators" class="carousel slide" data-bs-interval="false">
	<div class="carousel-inner">
		<?php
			$active = true;
			foreach($reps as $r) {
		?>
				<div class="carousel-item <?= ($active ? 'active' : ''); ?>">
					<?php
						$t_rep = ca_object_representations::findAsInstance($r['representation_id']);
						$viewer = MediaViewerManager::getViewerForMimetype('detail', $r['mimetype']);
						
						print $viewer::getViewerHTML(
							$this->request, 
							"representation:".$r['representation_id'], 
							[
								't_instance' => $t_rep, 't_subject' => $t_object, 
								'display' => $display_info = caGetMediaDisplayInfo('detail', $r['mimetype']), 
								'display_type' => 'detail'
							]
						);
					?>
				</div>
		<?php
				$active = false;
			}
		?>

		<?php
			if(count($reps) == 0 && count($reps) == 0){
		?>
			<div class="d-flex align-items-center p-5" style="height: 400px;">
				<div class="no-media">Digitized media for this item is not currently available online, please email info@chicagofilmarchives.org to inquire.</div>
			</div>
		<?php
			}
		?>
	</div>

	{{{<ifdef code="ca_object_representations.caption">
		<div class="max__640 text__body-3 color__white block-sm text-center">^ca_object_representations.caption</div>
	</ifdef>}}}

	<div class="carousel-indicators">
		<?php
			$active = true;
			$index = 0;
			foreach($reps as $m) {
				if(count($reps) > 1 ){
		?>
					<button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?>"></button>
		<?php
				}
				$index++;
				$active = false;
			}
		?>
	</div>

	<?php
		if(count($reps) > 1 ){
	?>
			<button type="button" class="carousel-control-prev" data-bs-target="#carouselIndicators" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>
			</button>
			<button type="button" class="carousel-control-next" data-bs-target="#carouselIndicators" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>
			</button>
	<?php
		}
	?>

</div>   





<!-- collection carousel -->

<!-- <div id="carouselIndicators" class="carousel slide" data-bs-interval="false">
	<div class="carousel-inner carousel-inner-coll">
	<?php
		$active = true;
		foreach($media as $m) {
	?>
		<div class="carousel-item carousel-coll-item <?= ($active ? 'active' : ''); ?>" >
		<?= $m; ?>
		</div>
	<?php
		$active = false;
		}
	?>

	<?php
		if(count($media) == 0 ){
	?>
		<div class="d-flex align-items-center p-5" style="height: 400px;">
		<p>Digitized media for this item is not currently available, please email info@chicagofilmarchives.org to inquire.</p>
		</div>
	<?php
		}
	?>
	</div>

	{{{<ifdef code="ca_object_representations.caption">
	<small class="color__gray text-start">^ca_object_representations.caption</small>
	</ifdef>}}}

	<div class="carousel-indicators">
	<?php
		$active = true;
		$index = 0;
		foreach($media as $m) {
			if(count($media) > 1 ){
	?>
			<button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?>"></button>
	<?php
			}
		$index++;
		$active = false;
		}
	?>
	</div>
</div> -->