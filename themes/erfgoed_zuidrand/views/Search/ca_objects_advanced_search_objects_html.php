
<div class="row">
	<div class="col-sm-12 col-md-8 col-md-offset-2">
		<h1>Zoeken</h1>

<p>{{{advanced_search_intro}}}</p>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoeken in alle velden.">Zoekterm</span>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Enkel zoeken op titel.">Titel</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek doorheen plaatsen.">Plaats</span>
			{{{ca_places.place_id%width=210px&autocomplete=1&inUse=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek doorheen de collectie.">Collectie</span>
			{{{ca_collections.collection_id%width=200px&autocomplete=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek objecten met een specificieke datum of periode .">Periode <i>(vb. 1970-1979)</i></span>
			{{{ca_objects.production_dating.production_period%width=200px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek op beschrijving.">Beschrijving</span>
			{{{ca_objects.content_description%width=220px}}}
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Zoeken}}}</span>
	</div>
</div>	
<input type="hidden" name="view" value="images">

{{{/form}}}

	</div>
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>