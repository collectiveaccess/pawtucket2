<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="leadImg">
<?php
		print caGetThemeGraphic($this->request, 'works_banner.jpg');
?>	
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h2>Search all Works</h2>
			<div class="searchForm">
				<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'catalogue'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>			
			</div>
			<h2>Works by Decade</h2>
<?php
			$o_browse = caGetBrowseInstance('ca_objects');
			$o_browse->setTypeRestrictions(['artwork', 'cast', 'edition', 'element', 'group', 'study', 'version']);
			$va_facets = $o_browse->getFacetContent('decade_facet', array("checkAccess" => $va_access_values));
			foreach ($va_facets as $vs_facet_id => $va_facet_info) {
				print "<div class='browseButton'>".caNavLink($this->request, $va_facet_info['label'], '', '', 'Browse', 'catalogue', array('facet' => 'decade_facet', 'id' => $va_facet_info['id']))."</div>";
			}
?>						
		</div>
		<div class="col-sm-8">
			<h2>Works by Isamu Noguchi</h2>
			<h6>Overview</h6>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sodales purus vitae porttitor tempor. Maecenas vitae dignissim nisi, a iaculis turpis. Donec a luctus massa. Morbi venenatis sem nunc, sed mollis libero rhoncus id. Sed in libero in nunc mattis efficitur. In varius suscipit mi semper scelerisque. Proin ultricies porta quam, fermentum lobortis arcu ullamcorper vestibulum. Phasellus consectetur dapibus diam non efficitur. Donec tristique ullamcorper erat, a posuere eros dictum ornare. Sed sed libero odio. In vitae viverra libero, vitae scelerisque magna. Praesent ornare, ante non semper maximus, lacus tortor sagittis velit, posuere blandit nisl enim a nunc. Aliquam eu varius libero.</p>
		</div>		
	</div>
</div>	