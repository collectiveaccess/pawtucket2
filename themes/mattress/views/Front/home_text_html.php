<div id="frontPageText">

	<div class='blockTitle'>About</div>
	<div class='blockAbout'>
		<div class='aboutText'>
			<p>The Archives of the Mattress Factory document the history and development of the museum, its collections, exhibitions, and programs, as well as the contributions of individuals and groups associated with the museum.  Recognizing that these records a unique and irreplaceable, the Mattress Factory maintains an active, professional archives program to systematically collect, organize, preserve, and provide access to its records of enduring value.  </p>

			<p>Our collections include drawings and three-dimensional models that document the planning and creative process of exhibiting artists, correspondence highlighting the collaborative relationship between the museum and Artist Residency Program participants, photographs of education and community events, and the many, many stories about the Mattress Factory experience. </p>

			<p>For research appointments, please contact our Archivist, Molly Tighe: <a href='mailto:molly@mattress.org' style='color: #ed3e45;'>molly@mattress.org</a></p>
		</div>
		<div class='homeLinks'>
<?php
			print "<div>".caNavLink($this->request, _t('Collections'), '', '', 'Listing', 'collections')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Artists'), '', '', 'Browse', 'Artists')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Artworks'), '', '', 'Browse', 'Collections')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Exhibitions + Events'), '', '', 'Browse', 'Exhibitions')."</div>";
			print "<div>".caNavLink($this->request, _t('P{art}icipate'), '', '', 'Browse', 'Artists')."</div>";
?>			
		</div>
	</div>
	
	<div class='clearfix'></div>
</div>