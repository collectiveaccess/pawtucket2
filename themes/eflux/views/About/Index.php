<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>
<H1><?php print _t("About the reading room"); ?></H1>
<div class="row">
	<div class="col-sm-12 col-md-12">
<?php	
	print caGetThemeGraphic($this->request, 'readingroom.jpg');
?>	
	<p></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<p>The e-flux reading room opened in 2008 at <a href='http://www.e-flux.com/announcements/the-building-2/' target='_blank'>the building</a> in Berlin to build a public archive documenting international exhibitions, ephemera, and symposia on contemporary art through donated publications from both institutions and individuals. After moving to e-flux’s 41 Essex Street location in 2009, the reading room library found its current home in the e-flux office on the 3rd floor of 311 East Broadway, NY in 2011. The library currently holds over 4000 publications from over 700 contributors. </p>
		<p>In 2015, the reading room website was created to provide access to a browsable catalog and digital publications available PDF format. The online catalog establishes a public database, drawing relationships between not only books and their contributors, but also authors, editors, publishers, formats, and more.</p>
		<p>If you would like to add a publication to the reading room, please email <a href='mailto:erin@e-flux.com'>erin@e-flux.com</a> or send books by mail to e-flux at 311 East Broadway FL 3 New York, NY 10002. The reading room is open by appointment Monday, Wednesday, and Thursday 10am-6pm.</p>

		<h3>Timeline</h3>
		<p>2008: <a href='http://www.e-flux.com/announcements/e-flux-reading-room-home-alone-fluxforum-and-party/' target='_blank'>the reading room</a> opens to the public at the building in <a href='http://www.e-flux.com/announcements/the-building-in-january/' target='_blank'>Berlin</a></p>

		<p>2009: <a href='http://www.e-flux.com/announcements/reading-room-2000-books-on-contemporary-art/' target='_blank'>the reading room moves to New York at 41 Essex Street</a></p>

		<p>2010:  <a href='http://www.e-flux.com/program/in-print-2/' target='_blank'>e-flux presents In-Print, a series of exhibitions, presentations and other projects, based in and around the reading room</a></p>

		<p>2011: the reading room moves to 311 east broadway</p>

		<p>2015: the reading room website goes online</p>
	</div>
</div>