
<div class="row">
	<div class="col-sm-12 " style='border-right:1px solid #ddd;'>
		<h1>Related Resources</h1>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="col-sm-6">
			<div class='menuLink first'><?php print caNavLink($this->request, 'Browse', '', '', 'Search', 'advanced/dutch'); ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'About the Project', '', '', 'Search', 'advanced/dutch_about'); ?></div> | 
			<div class='menuLink'><?php print 'Related Resources'; ?></div>
		</div>
		<div class="advancedSearchField dutch col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Search Dutch Colonial Records</span>
			{{{_fulltext%width=200px&height=1}}}<span class='btn btn-default' >{{{submit%label=Search}}}</span>
		</div>
		<div class="advancedSearchField col-sm-2 dutchbadge">
			<?php print caGetThemeGraphic($this->request, 'dutchbadge.jpg');?>
		</div>			
	</div>		
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<div class="container">
	<div class="row">
		<div class="col-sm-12 bodytext">
			{{{dutchRelated}}}		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

