<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": Join");
?>
<div role="main">
<H1><?php print _t("Register"); ?></H1>
<div class="row">
	<div class="col-sm-6 col-md-5">
		<p>Are you interested in contributing collections data to iDigPaleo or developing educational activities and tools for iDigPaleo?</p>
		<p>Please contact <a href="mailto:susan.butts@yale.edu">Susan Butts</a> and <a href="mailto:christopher.norris@yale.edu">Chris Norris</a> to discuss collaborations.</p>
	<div class="col-sm-6 col-md-5">
		<?php #$this->render("LoginReg/form_register_html.php"); ?>
	</div>
</div>
</div>
