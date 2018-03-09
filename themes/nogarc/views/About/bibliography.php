<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="leadImg">
<?php
		print caGetThemeGraphic($this->request, 'bibliography_banner.jpg');
?>	
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h2>Search Bibliography</h2>
			<div class="searchForm">
				<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'bibliography'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>			
			</div>
			<h6>Bibliographic Features</h6>
			<p>Noguchi's Introductions for Others' Books</p>
			<p>Noguchi Cover Stories</p>
			<p>A Selection of Noguchi's Writing</p>
		</div>
		<div class="col-sm-4" style='border-left:1px solid #ccc; border-right:1px solid #ccc;'>
			<h2 style='margin-bottom:20px;'>Explore Bibliography</h2>
<?php
			$t_list = new ca_lists();
			$va_browse_list_items = $t_list->getItemsForList('citation_formats');
			foreach ($va_browse_list_items as $vn_list_item_id => $va_browse_list_item) {
				foreach ($va_browse_list_item as $va_key => $va_browse_item) {
					print "<div class='browseButton'>".caNavLink($this->request, $va_browse_item['name_singular'], '', '', 'Browse', 'bibliography', array('facet' => 'biblio_type', 'id' => $vn_list_item_id))."</div>";
				}
			}
			
?>			
		</div>
		<div class="col-sm-4">
			<h2>Select Bibliography</h2>
			<h6>Primary Sources</h6>
			<p>Noguchi, Isamu. The Isamu Noguchi Garden Museum. New York: H.N. Abrams, 1999.</p>
			<p>Noguchi, Isamu, and R. Buckminster Fuller. Isamu Noguchi: A Sculptor's World. Göttingen: Steidl, 2015.</p>
			<p>Noguchi, Isamu, Diane Apostolos-Cappadona, and Bruce Altshuler. Isamu Noguchi: Essays and Conversations. New York, NY: Harry N. Abrams/The Isamu Noguchi Foundation, 1994.</p>

			<h6>Monographs</h6>
			<p>Ashton, Dore. Noguchi, East and West. Berkeley: University of California Press, 1993.</p>
			<p>Torres, Ana Maria. Isamu Noguchi: A Study of Space. New York, NY: Monacelli Press, 2000.</p>	
			
			<h6>Exhibition Catalogues</h6>
			<p>Fourteen Americans. New York: The Museum of Modern Art, 1946.</p>
			<p>Isamu Noguchi. New York: F. A. Praeger for Whitney Museum of American Art, 1968.</p>	
			<p>Noguchi's Imaginary Landscapes. Minneapolis: Walker Art Center, 1978.</p>	
			<p>Isamu Noguchi: The Sculpture of Spaces. New York: Whitney Museum of American Art, 1980.</p>
			<p>Isamu Noguchi: Sculptural Design. Weil am Rhein: Vitra Design Museum, 2001.</p>	
			<p>Isamu Noguchi: Master Sculptor. London: Scala, VIEW COMPLETE BIBLIOGRAPHY 2005.</p>	
			<p>Isamu Noguchi and Isamu Kenmochi. New York: Five Ties/Isamu Noguchi Foundation and Garden Museum, 2007.</p>
			<p>Return to Earth: Ceramic Sculpture of Fontana, Melotti, Miró, Noguchi, and Picasso 1943-1963. Dallas, Tex.: Nasher Sculpture Center, 2013.</p>	
			<p>Isamu Noguchi Archaic/Modern. Washington, D.C: Smithsonian American Art Museum/D Giles Limited, 2016.</p>	
			
			<h6>Secondary Sources</h6>
			<h6>Articles</h6>
			<h6>Reviews</h6>							
		</div>
	</div>
</div>