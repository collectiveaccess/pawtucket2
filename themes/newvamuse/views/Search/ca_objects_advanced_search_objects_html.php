
<div class="row">
	<div class="col-sm-9 " style='border-right:1px solid #ddd;'>
		<h1><?= _t('Objects Advanced Search'); ?></h1>

<p><?= _t('Use one or more fields below to search for specific terms found in object records. Hover over the name of a field to find out more.'); ?></p>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database."><?= _t('Keyword'); ?></span>
			{{{_fulltext%width=200px&height=1}}}
		</div>			
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by an object’s proper name."><?= _t('Object Name'); ?>></span>
			{{{ca_objects.preferred_labels.name%height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search for a particular date or date range that an object was made, such as 1867, or 1970 to 1979"><?= _t('Date range'); ?></span>
			{{{ca_objects.date%width=200px&height=40px&useDatePicker=0&height=1}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by what an object is made of. You may enter multiple materials."><?= _t('Materials'); ?></span>
			{{{ca_objects.materials%height=1&width=200px}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by terms related to an object’s history, such as a particular use or event."><?= _t('History'); ?></span>
			{{{ca_objects.description%width=210px&height=1}}}
		</div>	
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Find objects associated with specific cultures, such as Acadian, Mi’kmaq, or Scottish."><?= _t('Culture'); ?></span>
			{{{ca_objects.culture%height=1}}}
		</div>		
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Find objects associated with specific military units by using the full name of the battalion, regiment, company, squadron, etc."><?= _t('Military Unit'); ?></span>
			{{{ca_objects.militUnit%height=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Find objects related to a ship or watercraft by entering the vessel name, such as HMCS Sackville."><?= _t('Vessel Name'); ?></span>
			{{{ca_objects.vesName%height=1}}}
		</div>		
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by the brand name of manufactured products."><?= _t('Brand'); ?></span>
			{{{ca_objects.brand%height=1}}}
		</div>
	</div>	
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by model names and/or numbers found on objects."><?= _t('Model'); ?></span>
			{{{ca_objects.model%height=1}}}
		</div>	
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by terms that refer to iconographic content of the object, such as in paintings, photographs or postcards. For archival records, this field contains terms which briefly describe the main topic of the item, such as streetscape, farming, etc."><?= _t('Subject'); ?></span>
			{{{ca_objects.subject%height=1}}}
		</div>
	</div>		
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Find records contributed by a specific institution.  "><?= _t('Contributor'); ?></span>
			{{{ca_entities.preferred_labels%restrictToTypes=member_inst%width=200px&height=1}}}
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=<?= _t('Reset'); ?>}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=<?= _t('Search'); ?>}}}</span>
	</div>
</div>	

{{{/form}}}

	</div>
	<div class="col-sm-3 image" >
<?php
		print caGetThemeGraphic($this->request, 'womanwithbook.jpg');
?>
	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>