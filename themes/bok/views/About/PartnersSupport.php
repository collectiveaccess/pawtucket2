<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Partners and Support");
?>
<div class="container containerTextPadding">
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("Partners and Support"); ?></H1>
		</div>
	</div>
	<div class="row partnersSupportLogoRow">
		<div class="col-sm-4 text-center"><a href="http://www.amnh.org/our-research/center-for-biodiversity-conservation" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_AMNH_CBC.jpg'); ?></a></div>
		<div class="col-sm-4 text-center"><a href="http://www.iucn.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_iucn.gif'); ?></a></div>
		<div class="col-sm-4 text-center"><a href="http://www.iucn.org/about/work/programmes/gpap_home/gpap_wcpa/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_WCPA.jpg'); ?></a></div>
	</div>
	<div>
		<div class="col-sm-4 text-center"><a href="http://www.crc.uri.edu/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_uri_crc.jpg'); ?></a></div>
	</div>
</div>