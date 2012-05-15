<h1>Site Map</h1>
<div class="textContent">
	<div>
		<ul class="sitemap">
			<li><?php print caNavLink($this->request, "Home", "", "", "", ""); ?></li>
			<li><?php print caNavLink($this->request, "Explore the Collections", "", "clir2", "Collections", "Index"); ?>
				<ul>
					<li><?php print caNavLink($this->request, "Browse for NYWF amateur films", "", "clir2", "NYWFOccurrencesBrowse", "clearCriteria"); ?></li>
					<li><?php print caNavLink($this->request, "Browse for 1938-1940 film reels", "", "clir2", "PFOccurrencesBrowse", "clearCriteria"); ?></li>
					<li><?php print caNavLink($this->request, "Browse for collections containing 1938-1940 film reels", "", "clir2", "PFCollectionsBrowse", "clearCriteria"); ?></li>
				</ul>
			</li>
	
			<li><?php print caNavLink($this->request, "Engage", "", "clir2", "Engage", "Index"); ?></li>
			<li><?php print caNavLink($this->request, "News & Events", "", "clir2", "NewsEvents", "Index"); ?></li>
			<li><?php print caNavLink($this->request, "NYWF Resources", "", "clir2", "Resources", "Index"); ?>
				<ul>
					<li><?php print caNavLink($this->request, "Digital Video Online", "", "clir2", "Resources", "Index#video"); ?></li>
					<li><?php print caNavLink($this->request, "Libraries and Archives", "", "clir2", "Resources", "Index#library"); ?></li>
					<li><?php print caNavLink($this->request, "Bibliographies", "", "clir2", "Resources", "Index#bib"); ?></li>
					<li><?php print caNavLink($this->request, "Audiovisual Productions", "", "clir2", "Resources", "Index#audiovisual"); ?></li>
					<li><?php print caNavLink($this->request, "Books", "", "clir2", "Resources", "Index#books"); ?></li>
					<li><?php print caNavLink($this->request, "Web Resources", "", "clir2", "Resources", "Index#web"); ?></li>
					<li><?php print caNavLink($this->request, "Essays", "", "clir2", "Resources", "Index#essays"); ?></li>
				</ul>
			</li>
			<li><?php print caNavLink($this->request, "About", "", "", "About", "Index"); ?>
				<ul>
					<li><?php print caNavLink($this->request, "About the Project", "", "", "About", "Index"); ?></li>
					<li><?php print caNavLink($this->request, "Partners", "", "", "About", "Partners"); ?></li>
					<li><?php print caNavLink($this->request, "Participants", "", "", "About", "Participants"); ?></li>
					<li><?php print caNavLink($this->request, "Cataloging Resources", "", "", "About", "CatalogingResources"); ?></li>
				</ul>
			</li>
			<li><?php print caNavLink($this->request, "Login/Register", "", "", "LoginReg", "form"); ?></li>
		</ul>
	</div>
</div>