

<div class="row">
	<div class="col-md-12 col-lg-12 collectionsList">
		<h1>Collections</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sem in erat varius dapibus. Aliquam nec magna eget ligula efficitur ultrices. Donec sollicitudin massa in posuere viverra.</p>
	</div>
</div>	
<div class="row">		
	<div class="col-sm-6">
		<div class="collectionTile">
			<div class="title"><?php print caNavLink($this->request, 'Special Collections', '', '', 'Collections', 'Index');?></div>
			<div>{{{special_collections_text}}}</div>
		</div>
	</div><!-- end col -->
	<div class="col-sm-6">
		<div class="collectionTile">
			<div class="title"><?php print caNavLink($this->request, 'NWS Archives', '', '', 'Collections', 'records');?></div>
			<div>{{{archives_text}}}</div>
		</div>
	</div><!-- end col -->					
</div><!-- end row -->

