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




<!-- <section class="hero-single-collection wrap">
	<br/>
	<h1 class="text-align-center color__white text__headline-1 block-sm">
	{{{^ca_collections.preferred_labels}}}
	</h1>

	<div class="layout grid-flex">

	<div class="item color__white">

		<div id="carouselIndicators" class="carousel slide" data-bs-interval="false">
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
		</div>  
	</div>

	<div class="item collection-data-links">
		<div class="container-scroll" style="overflow-y: auto;">
		<div class="content-scroll">

		{{{
			<case>
			<if rule="^access = 'restricted'">
				<div class="size-column">
					<ifdef code="ca_collections.cfaInclusiveDates">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Inclusive Dates</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaInclusiveDates</div>
					</ifdef>

					<ifdef code="ca_collections.cfaAbstract">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Abstract</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaAbstract</div>
					</ifdef>

					<ifdef code="ca_collections.idno">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Collection Identifier</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.idno</div>
					</ifdef>

					<ifdef code="ca_collections.cfaCollectionExtent">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Extent of Collection</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaCollectionExtent</div>
					</ifdef>

					<ifdef code="ca_collections.cfaBulkDates">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Bulk Dates</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaBulkDates</div>
					</ifdef>

					<div class="max__640 text__body-3 color__white">This collection has been accessioned, but has not yet been fully described. 
					To inquire about this collection, email the archive at info@chicagofilmarchives.org</div>


				</div>
			</if>

			<if rule="^access = 'yes'">
				<div class="size-column">
				<ifdef code="ca_collections.cfaInclusiveDates">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Inclusive Dates</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaInclusiveDates</div>
				</ifdef>

				<ifdef code="ca_collections.cfaBulkDates">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Bulk Dates</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaBulkDates</div>
				</ifdef>

				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="cfa_sponsor">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Preservation Sponsor</div>
					<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="cfa_sponsor">
						<ifdef code="^ca_entities.file">
						<div class="max__640 text__body-3 color__white"><img src="^ca_entities.file" style="max-height: 80px; max-width: 450px;"></div>
						</ifdef>
						<ifnotdef code="^ca_entities.file">
						<div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.surname</div>
						</ifnotdef>
						<br>
					</unit>
				</ifcount>

				<ifdef code="ca_collections.cfaAbstract">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Abstract</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaAbstract</div>
				</ifdef>
				
				<ifdef code="ca_collections.cfaDescription">
					<div class="max__640 text__eyebrow color__light_gray block-xxxs">Description</div>
					<div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaDescription</div>
				</ifdef>
				</div>
			</if>
			</case>
		}}}
			<br><br>
		</div>
		</div>

		<div class="footer link" style="padding: 15px 0px 0px 0px;">
		<a href="#collection-details" class="text__eyebrow color-class-orange color__white scroll-to">
			View More collection Details 
			<span class="arrow-link down">
			<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path></svg>
			</span>
		</a>
		</div>
		<div class="shadow"></div>
	</div>
	
	</div>
</section> -->