<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
	require_once(__CA_MODELS_DIR__."/ca_entities.php");
?>
<div class="container"><div class="row"><div class="col-sm-12">

<H1><?php print _t("About"); ?></H1>
<div class="row">
	<div class="col-sm-12">
		{{{about_page_intro}}}
		<br>
	</div>
</div>

<hr style='margin-top:30px;' />

</div></div></div>