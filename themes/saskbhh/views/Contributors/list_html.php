<?php
$map_options = $this->getVar('mapOptions') ?? [];
$config = $this->getVar('config');
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<div class="row">
	<div class='col-12'>
		<h1><?php print _t("Contributors"); ?></h1>
<?php
	if($vs_intro_global_value = $config->get("intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='mb-4 mt-3 fs-4'>".$vs_tmp."</div>";
		}
	}
?>
	</div>
</div>
<div class="row"><div class="col mb-5">
	<div id="map" style="width: 100%; min-height: 300px;" class="map">{{{map}}}</div>
</div></div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Browse', 'Contributors', array('view' => 'list', 'dontSetFind' => 1)); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</div>