<div id="frontPageText">

	<div class='blockTitle'>About</div>
	<div class='blockAbout'>
		<div class='aboutText'>
			<p>Muddy shorts. Bird nests. Artists' sketches. Curator's notes. Fragments of hard candy. Installation models. </p>

			<p>Welcome to <b>P[art]icipate</b> the Mattress Factory's <b>Active Archive</b>. Chronicling artwork, documentation and objects, this archive was created to capture the museum’s evolution since 1977—and to record its story in real time for decades to come.  </p>

			<p>CollectiveAccess software enables the museum to relate user-generated content to artwork, objects, images, media, library collections, in a searchable format.</p>
			
			<p>Together, these records tell the history of the Mattress Factory, its impact on contemporary installation and performance artworks, and the development of these ephemeral art forms. Over 37 years of museum history and site-specific artwork has been preserved and digitized, which includes 15,000 images, AV assets, documents, anecdotes—and muddy shorts and bird nests.</p>
		
			<p><b>Not sure where to begin?</b> Browsing <b>P[art]icipate</b> in a variety of ways allows you to discover new content and gain a broader sense of what is contained in the archival collections, all while providing a holistic view of the museum. </p>
			
			<p>Explore <b>P[art]icipate</b> through the following categories: </p>
			<ul>
				<li>Artists – Searchable by name, decade, nationality</li>
				<li>Artworks – Searchable by name, date and type  </li>
				<li>Exhibitions + Events – Searchable by date and type</li>
			</ul>
			<p style='padding-top:40px;'><small>powered by <a href='http://www.collectiveaccess.org' target='_blank'>CollectiveAccess</a></small></p>
		</div>
		<div class='homeLinks'>
<?php
			print "<div>".caNavLink($this->request, _t('Browse Artists'), '', '', 'Browse', 'Artists')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Artworks'), '', '', 'Browse', 'Collections')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Exhibitions + Events'), '', '', 'Browse', 'Exhibitions')."</div>";
			print "<div>".caNavLink($this->request, _t('Research'), '', '', 'Listing', 'collections')."</div>";			
			print "<div>".caNavLink($this->request, _t('Contribute'), '', '', 'Browse', 'Artists')."</div>";
?>			
		</div>
	</div>
	
	<div class='clearfix'></div>
</div>