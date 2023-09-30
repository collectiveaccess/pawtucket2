<?php
$t_object = $this->getVar("item");
$reps = $t_object->getRepresentations(['small', 'mp3', 'h264_hi', 'original'], null, ['checkAccess' => [1]]);
?>
<div id="carouselIndicators" class="carousel slide collection-carousel" data-bs-interval="false">
	<div class="carousel-inner">
		<?php
			$active = true;
			foreach($reps as $r) {
		?>
				<div class="carousel-item carousel-object-item <?= ($active ? 'active' : ''); ?>" style="height: auto;">
					<?php
						switch(caGetMediaClass($r['mimetype'])) {
							case 'audio':
								print $r['tags']['mp3'];
								break;
							case 'video':
								print $r['tags']['h264_hi'];
								break;
							case 'document':
								print "<div style='height: 500px; width: 300px;'>".caRepresentationViewer(
									$this->request, 
									$t_object, 
									$t_object,
									array_merge($options, ['viewer' => 'pdfjs'], 
										[
											'display' => 'detail',
											'primaryOnly' => true, 
											'dontShowPlaceholder' => '', 
											'captionTemplate' => '',
											'checkAccess' => [1]
										]
									)
								)."</div>";
								break;
							default:
								print $r['tags']['small'];
								break;
						}
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
				<p>Digitized media for this item is not currently available, please email info@chicagofilmarchives.org to inquire.</p>
			</div>
		<?php
			}
		?>
	</div>
	<div class="carousel-indicators collection-indicators">
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

	{{{<ifdef code="ca_object_representations.caption">
		<div class="max__640 text__body-3 color__white block-sm text-center">^ca_object_representations.caption</div>
	</ifdef>}}}
</div>   