<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");

	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'reading.png')."</div>";
?>

<H1><?php print _t("Browse"); ?></H1>
<div class="row">
	<div class="col-sm-12">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent augue nunc, gravida a augue non, tincidunt sagittis justo. Phasellus euismod, elit ac condimentum elementum, ante nisl blandit lorem, sit amet malesuada odio enim id urna. Fusce egestas lacus at pellentesque tristique. In id purus eget metus pellentesque mattis ut ac ligula. Phasellus eu luctus neque. Fusce sagittis condimentum condimentum. Donec ut nunc porttitor, volutpat ligula ut, fermentum nisi. Quisque at hendrerit tortor.</p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 ">
		<div class="band">
			<div>Explore the Archives</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-5 col-sm-offset-1">
		<div class='browseImg'>
<?php
		print caNavLink($this->request, caGetThemeGraphic($this->request, 'badge2.jpg'), '', '', 'Browse', 'objects');
?>	
		</div>
		<div class='browseText' style="background-color:#3eb7ea;">
			<h3><?php print caNavLink($this->request, 'Explore Objects', '', '', 'Browse', 'objects');?></h3>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent augue nunc, gravida a augue non, tincidunt sagittis justo. 
		</div>
	</div>
	<div class="col-sm-5">
		<div class='browseImg'>
<?php
		print caNavLink($this->request, caGetThemeGraphic($this->request, 'girls.jpg'), '', '', 'Browse', 'entities');
?>
		</div>
		<div class='browseText' style='background-color:#ec008b;'>
			<h3><?php print caNavLink($this->request, 'Explore People and Organizations', '', '', 'Browse', 'objects');?></h3>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent augue nunc, gravida a augue non, tincidunt sagittis justo. 
		</div>			
	</div>
</div>
</div>