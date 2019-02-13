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
			<address>Rob Deglau<br/>
						Community Coordinator<br/>
						Civic Museum of Regina<br/>
						1231 Broad St<br/>			
						Regina, SK. S4R 1Y2</address>
		
			<address><span class="info">Phone</span> — (306) 780-9435			</address>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<?php print "<div class='logo'>".caGetThemeGraphic($this->request, 'CMoR_Logo_Colour.jpg')."</div><br/>"; ?>
		</div>
	</div>