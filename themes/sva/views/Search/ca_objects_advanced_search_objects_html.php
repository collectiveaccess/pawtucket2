<?php

include_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");

$va_access_values = caGetUserAccessValues($this->request);
	
?>
<div class="container" style='clear:both;'>
	<div class="row collection">
		<div class="col-sm-12">	
			<div class="advSearch">
				<h1>Advanced Search</h1>
				{{{form}}}

					<div class="advancedSearchField">
						<span class='advTitle'>Title</span>
						<span class='advField'>{{{ca_objects.preferred_labels.name%width=400px}}}</span>
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Identifier</span>
						<span class='advField'>{{{ca_objects.idno%width=650px}}}</span>
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Date</span>
						<span class='advField'>{{{ca_objects.dates.dates_value%width=400px}}}</span>
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Exhibition Date</span>
						<span class='advField'>{{{ca_occurrences.dates.dates_value%width=400px}}}</span>
					</div>					
					<div class="advancedSearchField">
						<span class='advTitle'>Classification</span>
						<span class='advField'>{{{ca_objects.series%width=400px}}}</span>
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Location</span>
						<span class='advField'>{{{ca_objects.location.location_description%width=400px}}}</span> 
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Related person</span>
						<span class='advField'>{{{ca_entities.preferred_labels%width=400px}}}</span>
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Related collection</span>
						<span class='advField'>{{{ca_collections.preferred_labels%width=400px}}}</span>
					</div>					

					<br style="clear: both;"/>

					<div class='advsubmit'>{{{submit%label=Search}}}</div>
					<div class='advreset'>{{{reset%label=Reset}}}</div>
					
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div><!--end col-sm-12-->
	</div><!--end row-->
</div> <!--end container-->

