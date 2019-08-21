
<div class="row">
	<div class="col-sm-12 col-md-8">
		<h1>Zoeken</h1>

<p>{{{advanced_search_intro}}}</p>

{{{form}}}


<div class='advancedContainer'>
	
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Collectie</span>
			{{{ca_objects.object_collection%width=200px}}}
		</div>
	</div>			
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Titel</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Inventarisnummer</span>
			{{{ca_objects.idno%width=220px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Inhoudelijke Beschrijving</span>
			{{{ca_objects.content_description%width=220px}}}
		</div>
	</div>			
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Plaatsen die verwant zijn met de inhoud</span>
			{{{ca_places.preferred_labels.name%width=220px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Vervaardigers</span>
			{{{ca_objects.production_maker.maker%width=220px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Datum</span>
			{{{ca_objects.production_dating.earliest_date%width=220px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Objecttype</span>
			{{{ca_list_items.preferred_labels%width=220px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover">Trefwoord</span>
			{{{ca_objects.object_keywords%width=220px}}}
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Zoeken}}}</span>
	</div>
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>