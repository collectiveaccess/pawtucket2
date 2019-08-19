<div role="main" id="main">
<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<H1><?php print _t("About"); ?> Florissant World</H1>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<p>The Florissant fossil beds of central Colorado have attracted attention around the world for more than 150 years. Known as one of the richest fossil deposits in the world, more than 1800 fossil species have been discovered from ancient lake deposits. These include fossil insects, plants, spiders, fish, birds, and mammals. Although many of the species identified in the Florissant Formation are now extinct, their modern relatives are scattered throughout the world today. The collections of fossil species found at the Florissant fossil beds provide a glimpse into what was once a very different world.</p>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<p>Thirty-four million years ago, near the end of the Eocene epoch, the Earth was much warmer than today, although it was on the brink of undergoing a significant global cooling event (Eocene-Oligocene transition). Prior to this cooling event, the Florissant valley was covered by an ancient lake that stretched approximately 12 miles long and 1 mile wide. Volcanoes dominated the skyline, frequently erupting clouds of gray ash that blanketed the landscape. The volcanic eruptions helped to fossilize the diversity of life that once flourished in the area, including tall redwood trees, butterflies, and fish.</p>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<p>Today, there are more than 50,000 fossil specimens from the Florissant Formation in 25 museums across North America and Europe. The vast majority of the specimens, however, are tucked away in museum cabinets for preservation. By using digital records of these collections, we aim to provide students, educators, scientists, and the general public with easy access to the fossils of the Florissant Formation and their associated data. Click on the curriculum tab for access to K-12 curriculum for classroom use. Scientific researchers can start here but may also want to access our more detailed database websites at: <a href="flfo-search.colorado.edu" target="_blank">flfo-search.colorado.edu</a> and <a href="planning.nps.gov/flfo" target="_blank">planning.nps.gov/flfo</a>.</p>
	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1 text-center">
		<?php print caGetThemeGraphic($this->request, 'flfoContent/about_1.jpg', array(
		"alt" => "Lake Florissant Painting")); ?>
		<p>Artist’s reconstructed image of the ancient Lake Florissant during the late Eocene with the Guffey volcanic complex in the background.</p>
	</div>
</div>
</div>