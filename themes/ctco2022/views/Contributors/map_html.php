<?php
	$vs_map = $this->getVar("map");
	$qr_contributors = $this->getVar("contributor_results");
	$o_config = $this->getVar("config");
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<H1>Institutions Map</H1>
			<br/>
			<div class="contributorIntro">{{{contributors_intro_map}}}</div>
			<div class="contributorMap"><?php print $vs_map; ?></div>
		</div>
	</div>