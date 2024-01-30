
<div class="row">
	<div class="col-sm-12">
		<h1>Objects Advanced Search</h1>

<?php			
print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Object Titles only.">Title</span><br>
			{{{ca_objects.preferred_labels.name%width=320px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to Description only.">Description</span>
			{{{ca_objects.work_description%width=320px}}}
		</div>
	</div>
		<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records of a particular date or date range.">Date</span>
			{{{ca_objects.work_date%width=320px&height=40px&useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by medium.">Medium</span>
			{{{ca_objects.work_medium%width=320px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by LCSH.">Library of Congress Subject Headings</span>
			{{{ca_objects.lcsh%width=320px}}}
		</div>			
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by AAT.">Art and Architecture Thesaurus</span><br/>
			{{{ca_list_items%width=320px}}}
		</div>			
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6 col-xs-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by TGN.">Thesaurus of Geographic Names</span>
			{{{ca_objects.tgn%width=320px}}}
		</div>			
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit col-sm-6 col-xs-12'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
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