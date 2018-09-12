<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" >
			<h1>Advanced Works Search <small>or search <?php print caNavLink($this->request, 'exhibitions', '', 'Search', 'advanced', 'exhibitions');?>, <?php print caNavLink($this->request, 'references', '', 'Search', 'advanced', 'references');?>, or <?php print caNavLink($this->request, 'provenance', '', 'Search', 'advanced', 'provenance');?></small></h1>

<?php			
	print "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pharetra venenatis lorem, sit amet ornare tortor molestie quis. Ut commodo in elit sit amet lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla facilisi. Proin iaculis at nisl nec ultricies. Vivamus commodo commodo dui nec efficitur. </p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Limit your search to object titles only.">Object Title</span>
				{{{ca_objects.preferred_labels.name%width=220px&label=Object_Title}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="The year, or range of years if a precise date is unknown, when a work was made.">Date</span>
				{{{ca_objects.creation_date%width=210px&height=1&label=_Date}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Description, based on physical examination, of the materials used to create a work.">Medium</span>
				{{{ca_objects.medium.medium_list%height=30px&label=Medium}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Description of the type of paper to which medium has been applied.">Support</i></span>
				{{{ca_objects.paper%width=200px&height=1&label=Support}}} <input type="hidden" name="ca_objects_paper_label" value="Support"/>
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Documentation of any portion of a watermark (a design formed during the papermaking process that usually includes the manufacturer’s name or trademark) visible in the paper support.">Watermark</i></span>
				{{{ca_objects.watermark.watermark_list%width=200px&height=1&inUse=1&label=Watermark}}}
			</div>
		</div>			
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Description of the material characteristics of a secondary support—original, of aesthetic integrity, and/or historical significance—to which a work has been attached.">Mount</i></span>
				{{{ca_objects.mount%width=200px&height=1&label=Mount}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search by Institional accession number.">Institution Accession Number </span>
				{{{ca_objects.institutional_id%width=200px&height=30px&label=Institution_Accession_Number}}}
			</div>
		</div>						
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search records within a particular collection.">Collection </span>
				{{{ca_collections.preferred_labels%width=200px&height=1&label=Collection}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the catalog.">Tags </span>
				{{{_fulltext%width=200px&height=1&label=Tags}}} <input type="hidden" name="_fulltext_label" value="Tags"/>
			</div>			
		</div>				
		<br style="clear: both;"/>
		<div class='advancedFormSubmit'>
			<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
			<span class='btn btn-default' style="margin-left: 10px;">{{{submit%label=Search}}}</span>
		</div>
	</div>	

{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>