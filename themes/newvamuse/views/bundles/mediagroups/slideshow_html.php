<?php
AssetLoadManager::register("ca", "slideshow");
$subject = $this->getVar('subject');
$rep_ids = $this->getVar('representation_ids');
$qr_reps = $this->getVar('representations');
$media_group = $this->getVar('media_group');
$group = $this->getVar('group');

$slideshow_id = 'storySlideshow'.$subject->tableName().'_'.$subject->getPrimaryKey().'_'.$group;

$slide_list = [];
foreach($media_group as $media_item) {
	$slide_list[] = "<span class='storySlideshowSlide'>{$media_item['display']}</span>";
}

if(!is_array($media_group) || !sizeof($media_group)) { return; }
?>

<div id="<?= $slideshow_id; ?>" class="storySlideshow">
	<div class="row">
		<div class="col-md-2 storySlideshowMediaNavPrevious">
			<a href='#' class='storySlideshowMediaNavPrevious storySlideshowNav' title='<?= _t("Previous"); ?>' aria-label='Previous'><span class='glyphicon glyphicon-arrow-left'></span></a> 
		</div>
		<div class="storySlideshowMedia col-md-<?= (sizeof($media_group) > 1) ? 8 : 12; ?>" style="height: <?= $this->getVar('height') ?? '400px'; ?>;"></div>
		<div class="col-md-2 storySlideshowMediaNavNext">
			<a href='#' class='storySlideshowMediaNavNext storySlideshowNav' title='<?= _t("Next"); ?>' aria-label='Next'><span class='glyphicon glyphicon-arrow-right'></span></a>
		</div>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		let slideshow = caUI.initSlideshow({
			'containerID': <?= json_encode($slideshow_id); ?>,
			'prevClass': 'storySlideshowMediaNavPrevious',
			'nextClass': 'storySlideshowMediaNavNext',
			'mediaClass': 'storySlideshowMedia',
			'slideList': <?= json_encode($slide_list); ?>,
		});
	});
</script>