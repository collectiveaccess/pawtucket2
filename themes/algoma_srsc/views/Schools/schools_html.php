<?php
$map_options = $this->getVar('mapOptions') ?? [];
$config = $this->getVar('config');
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<div class="row">
	<div class='col-12'>
		<h1><?php print _t("Schools"); ?></h1>
<?php
	if($vs_intro_global_value = $config->get("intro_text_global_value")){
		if($vs_tmp = $this->getVar($vs_intro_global_value)){
			print "<div class='mb-4 mt-3 fs-4'>".$vs_tmp."</div>";
		}
	}
?>
	</div>
</div>
<div class="row"><div class="col mb-4">
	<div id="map" style="width: 100%; min-height: 300px;" class="map">{{{map}}}</div>
</div></div>
<div class="row mb-4">
	<div class="col-md-6 col-lg-4 col-xl-3">
		<form role="search" id="searchWithin" hx-post="<?= caNavUrl($this->request, '', 'Search', 'schools', ['view' => 'list', 'dontSetFind' => 1]); ?>" hx-target="#browseResultsContainer" hx-swap="innerHTML" hx-on::after-request="if(event.detail.successful) document.getElementById('clear-search').classList.toggle('d-none')">
			<div class="input-group">
				<label for="search-within" class="form-label visually-hidden"><?= _t('Search within'); ?></label>
				<input name="search" id="search-within" type="text" class="form-control rounded-0 border-end-0" placeholder="<?= _t('Search within...'); ?>" value="<?= $this->getVar('search'); ?>">
				<button type="submit" class="btn rounded-0 border border-start-0" aria-label="<?= _t('Submit search'); ?>"><i class="bi bi-search"></i></button>
			</div>
		</form>
		<input type="hidden" name="selection" id="selection" value=""/>
		<input type="hidden" name="omitSelection" id="omitSelection" value=""/>
	</div>
	<div class="col-md-6 col-lg-4">
		<button id='clear-search' class='btn btn-primary d-none' hx-trigger='click' hx-target="#browseResultsContainer" hx-swap='innerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'schools', array('search' => '*', 'view' => 'list', 'dontSetFind' => 1)); ?>" hx-on::after-request="if(event.detail.successful) document.getElementById('search-within').value = ''; this.classList.toggle('d-none')">Clear Search</button>
	</div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'schools', array('search' => '*', 'view' => 'list', 'dontSetFind' => 1)); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</div>