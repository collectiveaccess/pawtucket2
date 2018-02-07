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
<H1><?php print _t("About GSUSA Cultural Resources"); ?></H1>
<div class="row">
	<div class="col-sm-8">
		
			<p>The Cultural Resources Department brings together the places, objects, and stories of GSUSA to fully leverage them in support of the organization’s mission “to build girls of courage, confidence, and character who make the world a better place.”</p>
			<p>Harnessing the power of place and its continuum of memory and narrative as a tangible platform from which to support growing the Movement, the resources include nationally significant historic sites  –  the  Juliette Gordon Low Birthplace in Savannah, GA and the Edith Macy Conference Center in Westchester County, NY – as well as GSUSA archives and the Manhattan Visitor Experience at headquarters.</p> 
			<p>These resources combined welcome more than 100,000 visitors annually from around the world, and encompass over 400 acres, 50 roofed structures, and tens of thousands of curatorial objects, decorative arts, media, photographs, archives, memorabilia, and other historically significant documents related to the history of the Girl Scouts.</p>
		<br/>
		<br/>
		<p class="green text-center">
			<small>Girl Scouting builds girls of courage, confidence, and character, who make the world a better place.</small>
		</p>
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