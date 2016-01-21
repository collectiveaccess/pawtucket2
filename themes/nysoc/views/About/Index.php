<?php
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');

	MetaTagManager::setWindowTitle($va_home." > About This Project");
?>
<div class="page aboutPage">
	<div class="wrapper">
		<div class="sidebar">
			<div class='sideLink'><a href='#present'>Present</a></div>
			<div class='sideLink'><a href='#past'>Past</a></div>
			<div class='sideLink'><a href='#future'>Future</a></div>
			<div class='sideLink'><a href='#support'>Support</a></div>
			<div class='sideLink'><a href='#staff'>Project Staff</a></div>
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container">		
					<div class="row">
						<div class="col-sm-12">
							<H4><?php print _t("About This Project"); ?></H4>
						</div>
					</div>
					<div class='row'>	
						<div class="col-sm-12 col-md-12 col-lg-12">

<h2 id='present'>Present</h2>
<p>Welcome to City Readers, the New York Society Library’s database of historic records, books, and readers. Search, browse, and visualization tools support the discovery and analysis of over 100,000 biographic, bibliographic, and transaction data, derived from digitized content from our archives. Circulation records from 1789 to 1805, when the Library shared Federal Hall with the first American Congress, have been fully digitized and transcribed, and the data is now available for free through City Readers. By providing detailed metadata for the books and readers documented in the charging ledgers, City Readers is a virtual reconstruction of the Library as a social and literary institution in New York at the turn of the eighteenth century.</p>

<p>Content now available in City Readers represents a small portion of the resources available in the Library’s <a href='https://www.nysoclib.org/collection/introduction-special-collections' target='_blank'>Special</a> and <a href='https://www.nysoclib.org/collection' target='_blank'>Circulating</a> Collections. Researchers interested in consulting archival or printed materials from our Special Collections, or from the circulating collection, are welcome to visit the Library.  To learn more about our collections, access to the Library, and <a href='http://www.nysoclib.org/members/membership-information' target='_blank'>membership</a>, please visit our <a href='https://www.nysoclib.org/' target='_blank'>website</a>.</p>

<p>The transcription of circulation records and the detailed cataloging of books and readers is completed manually by librarians and project staff, and enhanced by contributions from individual users. Some entries in the manuscript ledger are indecipherable due to poor handwriting or physical damage to the original, and we have marked uncertain transcriptions with a <i class="fa fa-exclamation-triangle"></i> sign, pointing users to digital images of the original document.  As of January 2016, many records still require complete metadata. These are clearly marked, and we welcome corrections to our records and further information about our books and readers. As much biographical information for our readers is derived from <a href='https://en.wikipedia.org/' target='_blank'>Wikipedia</a>, please consider enhancing or creating wikis for the readers and writers in City Readers.  You can learn more about contributing to the project in our <?php print caNavLink($this->request, 'User Guide', '', '', 'About', 'userguide');?>.</p>

<h2 id='past'>Past</h2>
<p>The first charging ledger (1789-1792) was conserved and digitized in 2008. Between 2009 and 2010, 24,261 transactions were transcribed, documenting the circulation of 1,185 books among 505 readers. The Early Circulation Records site was first launched in 2010, and in 2011 the second charging ledger (1799-1805) was conserved and digitized. Since then, 78,108 transactions, 1,141 readers, and 1,591 books have been added to our dataset. These are now available online for the first time in City Readers. You can find the old Early Circulation Records (1789-1792) site in the <a href='https://web.archive.org/web/20140104232357/http://www.nysoclib.org/collection/ledger/circulation-records-1789-1792/people' target='_blank'>Wayback Machine at Internet Archive</a>.<p>

<p>In 2013, the Library expanded the early circulation records project to incorporate a wider range of materials from our archives, and offer more sophisticated tools to discover them. Working with Whirl-i-Gig, the Library built a custom configuration of <a href='http://www.collectiveaccess.org' target='_blank'>Collective Access</a>, an open source digital content management system. The profile we created is available for free download on <a href='http://www.collectiveaccess.org/configuration' target='_blank'>their website</a>.</p>


<h2 id='future'>Future</h2>
<p>The New York Society Library is committed to maintaining, updating, and enriching City Readers with digitized content from our collections and rich descriptive metadata. In the near term, the Library plans to implement a variety of metadata input projects to enrich data on the readers and early print collections in the first two charging ledgers. Collecting early members’ addresses and cataloging them with geolocation codes, documenting the lives of lesser-known member-readers both in City Readers and on Wikipedia, and supplying complete bibliographic metadata will provide users with new information and support rich visualisations. We hope to begin work on these projects as soon as funding becomes available.</p>

<p>We are pleased to announce that the New York Society Library’s institutional archive is now being <a href='http://www.nysoclib.org/blog/reporting-stack-8-processing-librarys-institutional-archive' target='_blank'>processed</a> for the first time ever. We expect to publish a finding aid in City Readers and in the <a href='http://library.nysoclib.org/' target='_blank'>Library’s online catalog</a> in the fall of 2016.</p>

<p>City Readers was designed to support the digitization and description of a wide range of materials from our archive.  In the long term, the Society Library hopes to provide digital access to acquisitions, membership and governance records from the eighteenth to late twentieth centuries, while expanding digital access to circulation records up to 1909.  We also hope to continue to provide high quality metadata for the materials available on City Readers, and to develop more data visualization tools for our users.</p>

<h2 id='support'>Support</h2>
<p>Support for the digitization and transcription of the first two charging ledgers and the development of City Readers has been generously provided by:</p>
<ul>
	<li>An Anonymous Donor</li>
	<li>The Gladys Krieble Delmas Foundation</li>
	<li>Newman’s Own Foundation</li>
	<li>The Peter Jay Sharp Foundation</li>
</ul>

<p>If you or your organization is interested in supporting this project, please contact Director of Development <a href='mailto:jzimmett@nysoclib.org'>Joan Zimmett</a>.</p>

<h2 id='staff'>Project Staff</h2>
<p>Current Project Team</p>
<ul>
	<li>Erin Schreiner, Project Manager</li>
	<li>Matthew Bright, Resource Description Specialist</li>
</ul>

<p>Related Staff</p>
<ul>
<li>Carolyn Waters - Head Librarian</li>
<li>Laura O'Keefe - Staff Coordination</li>
<li>Diane Srebnick and Joan Zimmett - Development</li>
<li>Alexanne Brown - Processing Archivist</li>
</ul>
<p>We wish to acknowledge the contributions of Arevig Caprielian, Tim Conley, Matthew Haugen, Marie Honan, Christine Karatnytsky, Caitlin McCarthy, George Muñoz, Peri Pignetti, Ingrid Richter, Derek Stadler, Brynn White, Lawry Yates, Kathryn McNally, Hanan Ohanyon, Sara Partridge, and Laurainne Ojo-Ohikuare.</p>


						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div><!-- end content inner -->
		</div><!-- end content wrapper -->
	</div><!-- end wrapper -->
</div><!-- end page -->