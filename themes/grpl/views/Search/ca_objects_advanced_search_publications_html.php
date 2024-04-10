
<div class="row">
	<div class="col-sm-8 " style='border-right:1px solid #ddd;'>
		<h1>Search newspapers and magazines</h1>

<?php
print "<p>Enter your search terms in the fields below</p>";
?>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields including publication contents">Full Text</span>
			{{{metsalto%height=1}}}
		</div>
	</div>
<!--	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search issue titles">Title</span>
			{{{ca_objects.preferred_labels.name%width=220px}}}
		</div>
	</div> -->
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit search to a single date or date range">Date range <i>(e.g. 1970-1979)</i></span>
			{{{ca_objects.date.date_value%useDatePicker=0}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-12">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit search by publication">Publication title</span>
			{{{ca_objects.serial_name%width=200px}}}
		</div>
	</div>
	<div class='row'>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search file identifiers">File ID</span>
			{{{ca_objects.idno}}}
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
		<p><a href="regcard">Search WWI registration cards</a></p>
		<hr></hr>
		<h1>Newspaper and magazine titles</h1>
		<p><?php print caNavLink($this->request, "Furniture periodicals, 1906-1910, 1937-1937", "", "", "Detail", "collections/13"); ?></p>
		<p><?php print caNavLink($this->request, "Grand Rapids Herald, 1893-1917", "", "", "Detail", "collections/24"); ?></p>
		<p><?php print caNavLink($this->request, "New River Free Press, 1973-1977", "", "", "Detail", "collections/6"); ?></p>
		<p><?php print caNavLink($this->request, "Peninsular Club News, 1934-1943", "", "", "Detail", "collections/7"); ?></p>
		<p><?php print caNavLink($this->request, "Woman magazine, 1908", "", "", "Detail", "collections/11"); ?></p>

	</div><!-- end col -->
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover();
	});

</script>
