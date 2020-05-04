<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	#$qr_collections = $t_item->makeSearchResult("ca_collections", array_keys(517,430));
	$this->opo_config = caGetCollectionsConfig();
	$va_home_links = $this->opo_config->get('home_links');
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1>Research</h1>
			<p>Select an option below to dive deeper into the collection.</p>

			
<?php
			$vn_i = 0;
			foreach ($va_home_links as $va_link_code => $va_home_link) {
				if ($vn_i == 0) {
					print "<div class='row'>";
				}
?>						 
				<div class='col-sm-6'>
					<div class='collectionTile'>
						<div class='row'>
							<div class='col-sm-6 collectionImage'>
<?php
								if ($va_home_link['controller'] != "") {
									print caNavLink($this->request, caGetThemeGraphic($this->request, $va_home_link['image']), '', '', $va_home_link['controller'], $va_home_link['action']);
								} else {
									print caGetThemeGraphic($this->request, $va_home_link['image']);
								}
?>
							</div>		
							<div class='col-sm-6'>
<?php	
								if ($va_home_link['controller'] != "") {						
									print "<div class='title'>".caNavLink($this->request, $va_home_link['label'], '', '', $va_home_link['controller'], $va_home_link['action'])."</div>";
								} else {
									print "<div class='title'>".$va_home_link['label']."</div>";
								}
?>								
								<div class='intro'><?php print $va_home_link['intro']; ?></div>
							</div>
						</div>
					</div>				
				</div>
<?php
				$vn_i++;
				if ($vn_i == 2) {
					print "</div><!-- end row -->";
					$vn_i = 0;
				}
			}
			if ($vn_i != 0) {
				print "</div><!-- end row -->";
			}
?>				
			 
		</div><!-- end collectionList -->
	</div><!-- end row -->	



