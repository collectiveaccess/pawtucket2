<form class="g-3 mt-3" action="<?= caNavUrl($this->request, 'search', '', 'objects'); ?>" id="advSearch" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_advanced" value="1">
	<div class="row mb-3 justify-content-center">
		<div class="col-auto">
			{{{_fulltext%width=400px&height=1&height=1&placeholder=Keyword&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto">
			{{{ca_objects.preferred_labels.name%id=title&placeholder=Title&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto">
			{{{ca_collections.collection_id%id=collectiontitle&select=1&placeholder=Collection%20Title&class=browseMoreSearchOptsField%20form-control}}}
		</div>
	</div>
	<div class="row mb-3 justify-content-center">
		<div class="col-auto">
			{{{ca_objects.idno%id=identifier&placeholder=Identifier&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto">
			{{{ca_occurrences.cfaDateProduced%width=200px&useDatePicker=0&placeholder=Date%20of%20Production&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto">
			{{{ca_objects.type_id%width=200px&id=ca_objects_type_id&class=browseMoreSearchOptsField%20form-control%20adv-search-select}}}
		</div>
	</div>
	<div class="row mb-3 justify-content-end">
		<div class="col-auto">
			<button type="submit" class="btn btn-warning mb-3">Search <i class="bi bi-arrow-right-short"></i></button>
		</div>
	</div>
{{{/form}}}