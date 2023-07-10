<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
{{{aboutcol}}}
		</div>
		<div class="col-sm-6">
		{{{aboutcol2}}}
		</div>
	</div>