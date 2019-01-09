<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			{{{about_text}}}
			<br/><br/>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<h6>&nbsp;</h6><address>Swift Current Museum<br>44 Robert St. W<br>Swift Current, SK</address>
		
			<address>William Shepherd<br>
			Collections Officer<br/>
			<span class="info">Phone</span> — 306-778-4815<br>			
			<span class="info">Email</span> — <a href="mailto:w.shepherd@swiftcurrent.ca">w.shepherd@swiftcurrent.ca</a></address>
		</div>
	</div>