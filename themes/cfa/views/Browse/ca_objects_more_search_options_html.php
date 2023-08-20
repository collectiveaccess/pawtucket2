<form class="g-3 mt-3" action="<?= caNavUrl($this->request, 'search', '', 'objects'); ?>" id="advSearch" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_advanced" value="1">
	<div class="row mb-3 justify-content-center">
		<div class="col-auto">
			{{{_fulltext%width=400px&height=1&height=1&placeholder=Keyword&class=browseMoreSearchOptsField%20form-control}}}
			<!--<input type="text" class="form-control" id="keyword" placeholder="Keyword"
				style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 400px; height: 40px">-->
		</div>
		<div class="col-auto">
			{{{ca_objects.preferred_labels.name%id=title&placeholder=Title&class=browseMoreSearchOptsField%20form-control}}}
			<!--<input type="text" class="form-control" id="title" placeholder="Title"
				style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 400px; height: 40px">-->
		</div>
	</div>
	<div class="row mb-3 justify-content-center">
		<div class="col-auto">
			{{{ca_objects.idno%id=identifier&placeholder=Identifier&class=browseMoreSearchOptsField%20form-control}}}
			<!--<input type="text" class="form-control" id="identifier" placeholder="Identifier #"
				style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 200px; height: 40px">-->
		</div>
		<div class="col-auto">
			{{{ca_occurrences.cfaDateProduced%width=200px&useDatePicker=0&placeholder=Date%20of%20Production&class=browseMoreSearchOptsField%20form-control}}}
			<!--<input type="text" class="form-control" id="date" placeholder="Date of Production"
				style="border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 20px; width: 200px; height: 40px">-->
		</div>
		<div class="col-auto">
			<!--<select class="adv-search-select" name="type" id="type-select"
				style="border: 1px solid lightgray; border-radius: 10px; padding: 10px; width: 200px; height: 40px">
				<option value="">Type</option>
			</select>-->
			{{{ca_objects.type_id%width=200px&id=ca_objects_type_id&class=browseMoreSearchOptsField%20adv-search-select}}}
		</div>
	</div>
	<div class="row mb-3 justify-content-end">
		<div class="col-auto">
			<button type="submit" class="btn btn-warning mb-3">Search <i class="bi bi-arrow-right-short"></i></button>
		</div>
	</div>
{{{/form}}}