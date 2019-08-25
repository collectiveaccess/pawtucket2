<?php
	require_once(__CA_LIB_DIR__."/Browse/BrowseEngine.php");
	$browse = new BrowseEngine("ca_occurrences");
?> 

<div class="tab-pane" id="browse" role="tabpanel" aria-labelledby="browse-tab">
		<ul class="nav nav-pills nav justify-content-center">
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link active" id="bydate-tab" data-toggle="pill" href="#bydate" role="tab" aria-controls="bydate" aria-selected="true">By Date</a>
			</li>
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link" id="alpha-tab" data-toggle="pill" href="#alpha" role="tab" aria-controls="alpha" aria-selected="false">Alphabetical</a>
			</li>
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link" id="exhibitor-tab" data-toggle="pill" href="#exhibitor" role="tab" aria-controls="exhibitor" aria-selected="false">By Exhibitor</a>
			</li>
		</ul>
		<br/><br/>
	<div class="tab-content">
		<div class="tab-pane active" id="bydate" role="tabpanel" aria-labelledby="bydate-tab">
			<div id="dateBrowse">
				
			</div>
		</div>
		<div class="tab-pane" id="alpha" role="tabpanel" aria-labelledby="alpha-tab">
			<div id="exhibitionBrowse">
				
			</div>
		</div>
		<div class="tab-pane" id="exhibitor" role="tabpanel" aria-labelledby="exhibitor-tab">
			<div id="exhibitorBrowser">
				
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	pawtucketUIApps['exhbrowse'] = {
		'#dateBrowse': {
			'facetUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['getFacet' => 'decade', 'download' => 1]); ?>',
			'browseUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['facets' => 'decade:%value', 'sort' => 'Name']); ?>'
		},
		'#exhibitionBrowse': {
			'facetUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['getFacet' => 'exhibition', 'download' => 1]); ?>',
			'browseUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['facets' => 'exhibition:%value', 'sort' => 'Name']); ?>'
		},
		'#exhibitorBrowser': {
			'facetUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['getFacet' => 'exhibitor', 'download' => 1]); ?>',
			'browseUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['facets' => 'exhibitor:%value', 'sort' => 'Name']); ?>'
		}
	};
</script>
