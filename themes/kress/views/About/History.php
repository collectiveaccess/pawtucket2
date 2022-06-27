<?php
AssetLoadManager::register('timeline');
?>
<div class="row">
	<div class="col-sm-12 col-lg-8 col-lg-offset-2">
		<H1>Kress Collection History</H1>
		{{{history_page_intro}}}
	</div>
</div>
<div class="row hpTimeline">
	<div class="col-sm-12">
		<div id="frontTimelineContainer">
			<div id="timeline-embed"></div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				createStoryJS({
					type:       'timeline',
					width:      '100%',
					height:     '600px',
					source:     '<?php print caNavUrl($this->request, '', 'Front', 'timelinejson'); ?>',
					embed_id:   'timeline-embed',
					initial_zoom: '1',
					font:		'medula-lato'
				});
			});
		</script>
	</div>
</div>