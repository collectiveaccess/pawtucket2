<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About the Gallery");
?>
<div class="row">
	<div class="col-sm-6 fullWidthImg">
		<?php print caGetThemeGraphic($this->request, 'SEFA-HUDSON.jpg', array('alt' => 'Exterior of Susan Eley Fine Art Hudson NY')); ?>
		<small>Hudson, NY</small>
	</div>
	<div class="col-sm-6 fullWidthImg">
		<?php print caGetThemeGraphic($this->request, 'SEFA_NYC_2022.JPG', array('alt' => 'Exterior of Susan Eley Fine Art NYC')); ?>
		<small>NYC</small>
	</div>
</div>
<div class="row contentbody_sub aboutPages">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-8">
				<H1>About Susan Eley Fine Art</H1>
				{{{about_text}}}
			</div>
			<div class="col-sm-4 col-md-3 col-md-offset-1">
				<H1>Staff</H1>
				{{{staff_text}}}
			</div>
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-8">
				<br/>
				<H1>Director Biography</H1>
				<div class="row">
					<div class="col-sm-6 fullWidthImg">
						<?php print caGetThemeGraphic($this->request, 'Susan_Eley.jpg', array('alt' => 'Portrait of Susan Eley')); ?>
					</div>
					<div class="col-sm-6">
						{{{director_bio_text}}}
					</div>
				</div>
				<br/><br/>
				<H1>Accessibility Statement</H1>
				{{{accessibility_text}}}
				<div class="row" style="margin-top:50px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2 fullWidthImg" style="padding-top:30px;">
						<a href="https://www.hudsongallerycrawl.com" target="_blank"><?php print caGetThemeGraphic($this->request, '2econdSaturday.png', array('alt' => '2econd Saturday Hudson Gallery Crawl')); ?></a>
					</div>
					<div class="col-xs-2 fullWidthImg" style="padding-top:30px;">
						<a href="https://www.arttable.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'arttable-logo.png', array('alt' => 'Art Table')); ?></a>
					</div>
					<div class="col-xs-2 fullWidthImg" style="padding-top:30px;">
						<a href="http://womenartdealers.org/" target="_blank"><?php print caGetThemeGraphic($this->request, 'awad-logo.jpg', array('alt' => 'Association of Women Art Dealers')); ?></a>
					</div>
					<div class="col-xs-2 fullWidthImg" style="padding-top:30px;">
						<a href="https://www.artmoney.com/us" target="_blank"><?php print caGetThemeGraphic($this->request, 'art-money-logo.png', array('alt' => 'Art Money')); ?></a>
						<!--<br/><small>10 Payments. 10 Months. No Interest.</small>-->
					</div>
				</div>

			</div>
			<div class="col-sm-4 col-md-3 col-md-offset-1">		
			</div>
		</div><!-- end row -->
	</div>
</div><!-- end row -->