<?php
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="leadImg">
<?php
		print caGetThemeGraphic($this->request, 'library_banner_short.jpg');
?>	
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h2>Search the Library</h2>
			<div class="searchForm">
				<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'library'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>			
			</div>
			<h2>Library Items by Category</h2>
<?php
			$o_browse = caGetBrowseInstance('ca_objects');
			$o_browse->setTypeRestrictions(['library']);
			$va_facets = $o_browse->getFacetContent('library_facet', array("checkAccess" => $va_access_values));
			foreach ($va_facets as $vs_facet_id => $va_facet_info) {
				print "<div class='browseButton'>".caNavLink($this->request, $va_facet_info['label'], '', '', 'Browse', 'library', array('facet' => 'library_facet', 'id' => $va_facet_info['id']))."</div>";
			}
			print "<div class='browseButton'>".caNavLink($this->request, 'view all', '', '', 'Browse', 'library')."</div>";
?>					
		</div>
		<div class="col-sm-8">
			<h2>Isamu Noguchi Personal Library </h2>
			<h6>Overview</h6>
				<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales blandit quam, sed volutpat felis efficitur vitae. Aenean commodo eu leo eleifend rutrum. Nam in arcu at lorem facilisis laoreet id a turpis. Fusce elementum tortor id lectus consequat, in mattis ligula mollis. Cras euismod volutpat ante. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse nec dolor vitae sapien consequat tristique. Cras velit mi, ultrices at velit rhoncus, lacinia auctor massa. Proin quis mi ullamcorper, pretium lacus non, interdum neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus at fringilla erat. Nulla lacus sem, faucibus eu dolor luctus, luctus efficitur quam.</div>

		</div>		
	</div>
</div>	