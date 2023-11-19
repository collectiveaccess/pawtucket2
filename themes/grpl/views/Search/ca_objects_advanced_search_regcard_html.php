
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Search World War I registration cards</h1>

<?php
print "<p>Enter your search terms in the fields below (learn more about the collection <a href='/Detail/collections/171'>here</a>).</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields">Keyword</span>
			{{{_fulltext%width=200px&height=1}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by name">Registrant name</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search file identifiers">File ID</span>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search for address">Address</span>
			{{{ca_objects.address_info.address%width=200px&height=1}}}
		</div>
	</div>

	<div class='row'>
				<hr></hr>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel'>Demographic information</span>
			<div class="subform_label">
				<i><span class="subform_label" data-toggle="popover" data-trigger="hover" data-content="Age of card subject">Age</span></i>
				{{{ca_objects.demographics.age}}}
			</div>
			<div class="subform_label">
				<i><span data-toggle="popover" data-trigger="hover" data-content="Marital status of card subject">Marriage</span></i>
				{{{ca_objects.demographics.marriage}}}
			</div>
			<div class="subform_label">
				<i><span data-toggle="popover" data-trigger="hover" data-content="Racial identitity of card subject">Color or Race</span></i>
				{{{ca_objects.demographics.color_or_race}}}
			</div>
			<div class="subform_label">
				<i><span data-toggle="popover" data-trigger="hover" data-content="Country of birth of card subject">Birth Country</span></i>
				{{{ca_objects.demographics.birth_country}}}
			</div>
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel'>Skills information</span>
			<div class="subform_label">
				<i><span data-toggle="popover" data-trigger="hover" data-content="Skill type">Type</span></i>
				{{{ca_objects.skills.sk_category}}}
			</div>
			<div class="subform_label">
				<i><span data-toggle="popover" data-trigger="hover" data-content="Skill name">Name</span></i>
				{{{ca_objects.skills.sk_name}}}
			</div>
		</div>
	</div>
	<br style="clear: both;"/>
	<div class='advancedFormSubmit'>
		<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
		<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
	</div>
</div>

{{{/form}}}

	</div>
	<div class="col-sm-4" >
		<h1>Other searches</h1>
			<p><a href="objects">Search entire collection</a></p>
			<p><a href="all_images">Search for images</a></p>
			<p><a href="publications">Search newspapers and magazines</a></p>

	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover();
	});

</script>
