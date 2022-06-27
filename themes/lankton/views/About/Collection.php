<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
	<div class="row">
		<div class="col-sm-12 col-md-4 col-md-offset-1">
			<H1><?php print _t("About the Collection"); ?></H1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		</div>
		<div class="col-sm-12 col-md-6 col-md-offset-1">
<?php
			print caGetThemeGraphic($this->request, 'LanktonInstallation.jpg', array("alt" => "Lankton installation"), "", "", "","");
?>
		</div>
	</div>