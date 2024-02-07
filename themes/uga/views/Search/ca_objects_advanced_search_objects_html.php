<div class="container">
	<div class="row">
		<div class="col-sm-7">
			<div class="bmacSearchContainer">				
					<h2>Search Brown Media Archives</h2>
					 <form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" class="form-inline">
							<input class="form-control query" id="brownSearch" name="search" placeholder="Enter Keywords" type="text">
							<button class="btn btn-primary" id="searchButton" name="rows" type="submit" value="20">Search</button>
					</form>				
			</div>
			
			<h2>Advanced Search</h2>
<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class="advancedContainer">
		<div class="advancedSearchField">
                        Media Type<br/>
                        {{{ca_objects.instantiationMediaType%width=300px&height=40}}}
                </div>
		<div class="advancedSearchField">
                        Format <br/>
                        {{{ca_objects.instantiationPhysical%width=300px&height=40}}}
                </div>
		<div class="advancedSearchField">
			Title<br/>
			{{{ca_objects.preferred_labels.name%width=300px}}}
		</div>
		<div class="advancedSearchField">
			Item number<br/>
			{{{ca_objects.idno%width=300px}}}
		</div>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=300px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
		<div class="advancedSearchField">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.instantiationDate.instantiationDateText%width=300px&height=40px&useDatePicker=0}}}
		</div>
		<div class="advancedSearchField">
			Collection <br/>
			{{{collection%width=300px}}}
		</div>
	</div>	
	
	<br style="clear: both;"/>
	<input class="btn btn-primary" type="submit" value="Search">
	<input class="btn btn-primary" type="reset" value="Reset">

{{{/form}}}

		</div>
</div><!-- end container -->
