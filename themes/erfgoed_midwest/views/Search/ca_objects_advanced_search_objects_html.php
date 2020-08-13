
<div class="row">
	<div class="col-sm-12 col-md-8">
		<h1><?php print _t("Advanced Search"); ?></h1>

{{{advanced_search_intro}}}
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
			{{{ca_places.preferred_labels.name%width=210px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek doorheen de collectie.">Collectie</span>
			{{{ca_entities.preferred_labels.name%height=30px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Zoek objecten met een specificieke datum of periode .">Periode <i>(vb. 1970-1979)</i></span>
			{{{ca_objects.object_creation_date%width=200px&height=40px&useDatePicker=0}}}
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