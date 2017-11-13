<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>


	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 contentArea">
			<H1><?php print _t("About"); ?></H1>
			<div class="row">
				<div class="col-sm-8 ">	
					<h3>Contact The Archives</h3>
					<p>{{{about_text}}}</p>
				</div>
				<div class="col-sm-4 ">
					{{{contact_text}}}
				</div>
			</div>
		</div>
	</div>