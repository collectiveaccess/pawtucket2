<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="leadImg">
<?php
		print caGetThemeGraphic($this->request, 'biography_banner.jpg');
?>	
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h2>Search Noguchi's life</h2>
			<div class="searchForm">
				<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'chronology'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>			
			</div>			
			<h2>Browse Chronology</h2>
<?php
			$o_browse = caGetBrowseInstance('ca_occurrences');
			$o_browse->setTypeRestrictions(['chronology']);
			$va_facets = $o_browse->getFacetContent('decade_facet', array("checkAccess" => $va_access_values));
			foreach ($va_facets as $vs_facet_id => $va_facet_info) {
				print "<div class='browseButton'>".caNavLink($this->request, $va_facet_info['label'], '', '', 'Browse', 'chronology', array('facet' => 'decade_facet', 'id' => $va_facet_info['id']))."</div>";
			}
			print "<div class='browseButton'>".caNavLink($this->request, 'view all', '', '', 'Browse', 'chronology')."</div>";
?>
		</div>
		<div class="col-sm-8">
			<h2>Chronology</h2>
			<p>Isamu Noguchi (1904–1988) was one of the twentieth century’s most important and critically acclaimed sculptors. Through a lifetime of artistic experimentation, he created sculptures, gardens, furniture and lighting designs, ceramics, architecture, and set designs. His work, at once subtle and bold, traditional and modern, set a new standard for the reintegration of the arts.</p>
			<p>Noguchi, an internationalist, traveled extensively throughout his life. (In his later years he maintained studios both in Japan and New York.) He discovered the impact of large-scale public works in Mexico, earthy ceramics and tranquil gardens in Japan, subtle ink-brush techniques in China, and the purity of marble in Italy. He incorporated all of these impressions into his work, which utilized a wide range of materials, including stainless steel, marble, cast iron, balsa wood, bronze, sheet aluminum, basalt, granite, and water...</p>
		</div>
	</div>
</div>