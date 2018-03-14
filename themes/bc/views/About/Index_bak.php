<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

<div class="container">
	<div class="row">
		<div class="col-sm-7 col-sm-offset-1 col-md-8">
			<H1><?php print _t("About"); ?></H1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		</div>
		<div class="col-sm-3 col-md-2">
			<div class='sideMenu'>
				<div class="aboutMenu">FAQ</div>
				<div class="aboutMenu">Site Stats</div>
				<div class="aboutMenu">Contributors</div>
				<div class="aboutMenu">Terms of Use</div>
			</div>
		
		</div>
	</div>
</div>