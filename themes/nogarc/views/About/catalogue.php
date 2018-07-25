<?php
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="leadImg">
<?php
		print caGetThemeGraphic($this->request, 'catalogue_banner.png');
?>	
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h2>Search the Catalogue Raisonné</h2>
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
			print "<div class='browseButton'>".caNavLink($this->request, 'view all', '', '', 'Browse', 'catalogue')."</div>";
?>			
			<h2>Catalogue Raisonné Features</h2>		
		</div>
		<div class="col-sm-8">
			<h2>Isamu Noguchi Catalogue Raisonné </h2>
			<h6>Overview</h6>
				<b>The Publication</b>
				<p>The Isamu Noguchi Foundation and Garden Museum is pleased to present the digital Isamu Noguchi Catalogue Raisonné, an ideal tool for scholars, educators, arts professionals, and anyone wishing to gain a refined knowledge of the work of Isamu Noguchi (1904–1988). As a web-based publication-in-progress, the digital Isamu Noguchi Catalogue Raisonné features a wide range of comprehensive information on Noguchi's artwork, exhibitions, and bibliography. The digital Isamu Noguchi Catalogue Raisonné is made available free of charge to scholars and the public.</p>
				<b>The Project</b>
				<p>The Isamu Noguchi Catalogue Raisonné is an ongoing project of The Isamu Noguchi Foundation and Garden Museum, New York, committed to documenting the artistic practice of Isamu Noguchi . The project’s ongoing research is made accessible to the public through regular updates to the digital Isamu Noguchi Catalogue Raisonné. Learn more about the project’s history and goals by visiting the publication’s website.</p>
				<b>Information for Collectors</b>
				<p>The Isamu Noguchi Catalogue Raisonné depends on the assistance of collectors and institutions around the world to help locate works and finalize cataloging of Noguchi’s artistic practice. Collectors of artworks by Isamu Noguchi and others willing to help are invited to contact The Isamu Noguchi Catalogue Raisonné project via email at catalogue@noguchi.org. The Isamu Noguchi Catalogue Raisonné project is committed to privacy and keeps private collection information in strict confidence.</p>
				<p>Please note, The Isamu Noguchi Foundation and Garden Museum does not authenticate or offer opinions on attribution.</p>
			<h6>Structure</h6>
				<b>Content and Scope</b>
				<p>While research for the project advances, the content of the digital Isamu Noguchi Catalogue Raisonné includes a combination of finalized entries (indicated as “published”) for which research has been completed, and temporary entries (indicated as “research pending”) for which research is ongoing or outstanding. Together, these entries represent the majority of The Isamu Noguchi Catalogue Raisonné project’s scope of research. For specific information on the project’s scope of research, please review the project’s Qualifications for Inclusion.</p>
				<b>Publication Schedule</b>
				<p>The present program of research for The Isamu Noguchi Catalogue Raisonné is scheduled through 2018. As research progresses, new works are added on an ongoing basis.</p>
				<b>Subject to Change</b>
				<p>While the project makes every effort to ensure that information provided in the digital Isamu Noguchi Catalogue Raisonné is accurate at the time of publication, the ongoing status of research necessitates that information in all areas of the publication is subject to change as new facts emerge. When changes occur, the nature of and reason for those revisions may be noted and dated. Additionally, content may be added to or removed from the digital publication at any time in accordance with the project’s Qualifications for Inclusion. For more information, please review the publication’s Terms and Conditions of Use.</p>
				<b>Published Entries</b>
				<p>Artwork, exhibition, and bibliography entries categorized as “published” provide the complete cataloging for a given record. This information has been verified as accurate at the date of publication indicated at the bottom of each record.</p>
				<b>Research Pending Entries</b>
				<p>Artwork, exhibition, and bibliography entries categorized as “research pending” provide partial information on a given record for which research is currently ongoing or outstanding. Research-pending entries represent anticipated content of the digital Isamu Noguchi Catalogue Raisonné, but do not guarantee inclusion in future editions of the publication.</p>
				<b>Exhibitions and Publications</b>
				<p>A published artwork entry may include links to exhibitions in which it was included and literature in which it was cited. However, these lists are subject to change as new research on exhibitions and bibliography is finalized. Therefore, a published artwork entry's exhibition history and bibliography should not be interpreted as finalized.</p>
				<b>Images</b>
				<p>Every effort is made to provide one or more high-quality images for every artwork. Images presently available are the best or only available images of artworks and exhibitions.</p>
			<h6>Current Status</h6>
		</div>		
	</div>
</div>	