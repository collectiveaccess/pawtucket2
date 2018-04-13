<!--<H1><?php print _t("About"); ?></H1>-->
<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
		$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/about/";
		$vn_filecount = 0;
		$va_files = glob($vs_directory . "*");
		if ($va_files){
		 $vn_filecount = count($va_files);
		}

		print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'about/'.rand(1,$vn_filecount).'.jpg')."</div>";
?>
	<div class="row">
		<div class="col-sm-12 ">
			<div class="band">
				<div>Learn More</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("About the Cultural & Property Assets Department"), "", "", "About", "Collection"); ?></div>
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("About Girl Scouts of the USA"), "", "", "About", "GSUSA"); ?></div>
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("Girl Scout Gold Award"), "", "", "About", "GoldAward"); ?></div>
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("Rights, Reproduction and Usage"), "", "", "About", "Usage"); ?></div>
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("Research Services"), "", "", "About", "Services"); ?></div>
			<div class="aboutLandingBlocks"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php print caNavLink($this->request, _t("Internship and Volunteer Opportunities"), "", "", "About", "Opportunities"); ?></div>
			<br/>
			<br/>
			<br/>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<h2><b>Contact Us</b></h2>
			<address>
				<b>Cultural & Property Assets</b><br/>
				420 Fifth Avenue<br/>
				New York, NY 10018
				<br/><br/>
				<a href="mailto:culturalresourcesrequests@girlsscouts.org" class="btn-default" title="culturalresourcesrequests@girlsscouts.org">Email <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
			</address>
		
		</div>
	</div>