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
			<h6>&nbsp;</h6><address>Museums Association of Saskatchewan<br>			424 McDonald Street<br>			Regina, SK S4N 6E1</address>
		
			<address>Kathleen Watkin, Museums Advisor<br>			<span class="info">Phone</span> — (306) 780-9266<br>			<span class="info">Fax</span> — (306)- 780- 9463<br>			<span class="info">Email</span> — <a href="mailto:advisor@saskmuseums.org">advisor@saskmuseums.org</a></address>
		</div>
	</div>