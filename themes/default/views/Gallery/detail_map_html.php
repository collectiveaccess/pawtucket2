<?php
	$set_items = $this->getVar("set_items");
	$set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$label = $this->getVar("label");
	$description = $this->getVar("description");
	$table = $this->getVar("table");
	$t_instance = $this->getVar("instance");
	$access_values = $this->getVar("access_values");
$map_options = $this->getVar('mapOptions') ?? [];
$config = $this->getVar('config');
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<div class="row">
	<div class='col-12'>
		<h1><?php print $this->getVar("label")."</h1>"; ?>
<?php
		if($description){
			print "<div class='my-3 fs-4'>".$description."</div>";
		}
?>	
	</div>
</div>
<div class="row"><div class="col mb-4">
	<div id="map" style="width: 100%; min-height: 400px;" class="map">{{{map}}}</div>
</div></div>
<div class="row"><div class="col mb-4">
	<?php print sizeof($set_items)." ".((sizeof($set_items) == 1) ? "Item" : "Items"); ?>
</div></div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'all_artworks', array('search' => 'ca_sets.set_id:'.$set_id, 'view' => 'images', 'dontSetFind' => 1)); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</div>