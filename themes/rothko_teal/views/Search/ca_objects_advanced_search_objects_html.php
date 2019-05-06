<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" >
			<h1>Advanced Search–Works <small>or search <?php print caNavLink($this->request, 'Provenance', '', 'Search', 'advanced', 'provenance');?>, <?php print caNavLink($this->request, 'Exhibitions', '', 'Search', 'advanced', 'exhibitions');?>, or <?php print caNavLink($this->request, 'References', '', 'Search', 'advanced', 'references');?></small></h1>

<p>{{{advText}}}</p>

{{{form}}}
	
	<div class='advancedContainer'>		
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Exact title of work, including brackets and parentheses if applicable ">Object Title</span>
				{{{ca_objects.preferred_labels.name%width=220px&label=Object_Title}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="The year, or range of years if a precise date is unknown, when a work was made">Date</span>
				{{{ca_objects.creation_date%width=210px&height=1&label=_Date}}}
			</div>
			<div class="advancedSearchField col-sm-6">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Material or materials used to create a work on paper">Medium</span>
				{{{ca_objects.medium.medium_list%height=30px&label=Medium}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="The type of paper to which the medium has been applied">Support</i></span>
				{{{ca_objects.paper%width=200px&height=1&label=Support}}} <input type="hidden" name="ca_objects_paper_label" value="Support"/>
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Paper manufacturer’s name or trademark visible in the paper support">Watermark</i></span>
				{{{ca_objects.watermark.watermark_list%width=200px&height=1&inUse=1&label=Watermark}}}
			</div>
		</div>			
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Secondary support to which a work on paper has been attached">Mount</i></span>
				{{{ca_objects.mount%width=200px&height=1&label=Mount}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Accession number (or other unique number) used by a museum or institution to identify a work on paper">Institution Identifier </span>
				{{{ca_objects.institutional_id%width=200px&height=30px&label=Institution_Accession_Number}}}
			</div>
		</div>						
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Current or previous owner/holder (e.g., museum, individual) of a work on paper">Collection </span>
				{{{ca_collections.preferred_labels%width=200px&height=1&label=Collection}}}
			</div>
		</div>
		<div class='row'>
			<div class="advancedSearchField col-sm-12">
				<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Keyword(s) that describe the subject matter you wish to explore (e.g., female, reading)">Tags </span>
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