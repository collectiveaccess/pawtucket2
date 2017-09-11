<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class='detailHead'>
			<div class='leader'>About</div>
			<h2>Archival Services</h2>
			<p style="margin-top:15px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, ligula ut semper fermentum, lacus ante semper odio, in euismod neque elit et dui.</p>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-xs-12 text-center">
		<hr class="divide">
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">	
		<p class='staticTitle'>Title</p>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, ligula ut semper fermentum, lacus ante semper odio, in euismod neque elit et dui. Aliquam metus mi, egestas id ullamcorper nec, consequat vel ante. Etiam vehicula sit amet diam eget varius. Praesent vitae ligula ipsum. Maecenas luctus iaculis tellus ac gravida. Vivamus sed consequat purus. Duis dictum magna sit amet faucibus pulvinar. In rhoncus varius lectus ut ultrices. Suspendisse elementum lacus a velit mattis, quis semper nisi accumsan. Aenean aliquet efficitur tellus at sagittis. 
		</p>
		<hr class="divide">
		<p class='staticTitle'>Title</p>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam imperdiet, ligula ut semper fermentum, lacus ante semper odio, in euismod neque elit et dui. Aliquam metus mi, egestas id ullamcorper nec, consequat vel ante. Etiam vehicula sit amet diam eget varius. Praesent vitae ligula ipsum. Maecenas luctus iaculis tellus ac gravida. Vivamus sed consequat purus. Duis dictum magna sit amet faucibus pulvinar. In rhoncus varius lectus ut ultrices. Suspendisse elementum lacus a velit mattis, quis semper nisi accumsan. Aenean aliquet efficitur tellus at sagittis. 
		</p>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
		<div class="staticImg"><?php print caGetThemeGraphic($this->request, 'ArchivesHero-Options5.jpg'); ?></div>
		<br/><p class='staticTitle'>CONTACT THE ARCHIVES</p>
		<address>BAM Hamm Archives<br/>
		1000 Dean Street, #317<br/>
		Brooklyn, NY 11237<br/><br/>
		<p class='linkInfo'><i class="icon icon-map-marker"></i> <a href="https://goo.gl/maps/XXT8KQPdGuQ2" target='_blank'>Google Maps</a></p>
		<p class='linkInfo'><i class="icon fa fa-phone"></i> 718.724.8150</p>			
		<p class='linkInfo'><i class="icon icon-envelope"></i> <a href="mailto:bamarchive@bam.org">bamarchive@bam.org</a></p>
		</address>
	</div>
</div>
</div>