<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$map = $this->getVar("map");

?>
<div class="row">
	<div class="col-md-12 col-lg-10 col-md-offset-1">
		<h1>Explore by Place</h1>
		<div class="placesIntro">
			{{{explore_places_intro}}}
		</div>
<?php
		print $map;
?>	
	</div>
</div>
