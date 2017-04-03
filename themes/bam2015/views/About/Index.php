<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class='detailHead'>
			<div class='leader'>About</div>
			<h2>The BAM Hamm Archives</h2>
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
		
		<p>
			The BAM Hamm Archives tell the story of the 150+ year history of BAM, and of the communities—civic and artistic—that built the institution. <a href="http://www.bam.org/about/history/bam-hamm-archives" target="_blank">Learn more about both the digital and physical archives here</a>. The Archives and its staff provide a rich and unique resource for researchers interested in BAM artists and productions, the history of performing arts in the US, and Brooklyn's social history.
		</p>
		<p>
			The Archives contain approximately 3,000 linear feet of materials dating from 1857 to the present, including newspaper clippings, photographs, books, playbills, promotional material, video, architectural plans, posters, administrative records, production elements, art, and other materials. The collection is currently housed in Crown Heights, with plans to relocate to a state-of-the-art facility on the BAM campus in 2018. The digitization of significant portions of the collection enables researchers and the public to search and view materials online.
		</p>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
		<div class="staticImg"><?php print caGetThemeGraphic($this->request, 'ArchivesHero-Option2.jpg'); ?></div>
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