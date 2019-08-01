<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("Contact"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<address>Location:<br>
			107 Administration Pl<br>
			University of Saskatchewan Campus<br/>
			Saskatoon, SK S7N 5A2<br/>
			(306) 966-4571</address>
		
			<address>Contact:<br/> Blair Barbeau<br>			<span class="info">Phone</span> — (306) 966 4571<br><a href="mailto:blair.barbeau@usask.ca">blair.barbeau@usask.ca</a></address>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<?php print "<div class='logo'>".caGetThemeGraphic($this->request, 'logo 2013.jpg')."</div>"; ?>
		</div>
	</div>