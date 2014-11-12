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
		<div class="col-sm-12 text-left">
			<H2>Support Provided By</H2>
			<div style="float:left;">
				<a href="http://www.iucn.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_IUCN_WCPA.jpg'); ?></a>
			</div>
			<div style="text-align:right;">
				<a href="http://www.biopama.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_BIOPAMA.jpg', array("style" => "margin:15px 0px 25px 0px;")); ?></a>
				<div>
					BIOPAMA is implemented by:<br/>
					<?php print caGetThemeGraphic($this->request, 'logo_biopama_initiative.jpg', array("style" => "margin:0px 0px 5px 0px;")); ?>
					<br/><small><i>An initiative of the ACP Secretariat funded by the European Union under the 10th EDF</i></small>
				</div>
			</div>
		</div>
	</div>
	<div class="row partnersSupportLogoRow">
		<div class="col-sm-12">
			<hr/><br/>
			<H2>Project Partners</H2>
			<div class="row">
				<div class="col-sm-4 text-center"><?php print caGetThemeGraphic($this->request, 'logo_UCI.jpg'); ?></div>
				<div class="col-sm-4 text-center"><a href="http://www.amnh.org/our-research/center-for-biodiversity-conservation" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_AMNH_CBC.jpg'); ?></a></div>
				<div class="col-sm-4 text-center"><a href="http://www.crc.uri.edu/" target="_blank"><?php print caGetThemeGraphic($this->request, 'logo_uri_crc.jpg'); ?></a></div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center"><br/><?php print caGetThemeGraphic($this->request, 'logo_globalParks.jpg'); ?></div>
			</div>
		</div>
	</div>
</div>