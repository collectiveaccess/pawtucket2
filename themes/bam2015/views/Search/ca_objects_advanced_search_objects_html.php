<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-6 col-lg-6">
			<h2>Advanced Search</h2>

		

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="form-group advancedSearchField">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%height=25px&width=400px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=400px&height=35px&class=form-control}}}
		</div>		
		<div class="form-group advancedSearchField identifier">
			Object Identifier:<br/>
			{{{ca_objects.idno%width=100px&height=35px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Type:<br/>
			{{{ca_objects.type_id%height=25px&width=400px&class=form-control}}}
		</div>
		<div class="form-group advancedSearchField">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.sourceDate%width=400px&height=25px&useDatePicker=0&class=form-control}}}
		</div>
	</div>	
	
	<br style="clear: both;"/>
	<div style="width:400px;">
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	</div>
{{{/form}}}

		</div>
		<div class="col-sm-4 col-md-6 col-lg-6" style='border-left:1px solid #ddd;'>
			<h2>For Researchers</h2>
			
				<p>Researchers can digitally access information from much of the collection housed in the BAM Hamm Archives. All known performances dating from the institution’s founding in 1861 have been catalogued, and all existing playbills have been scanned. These provide detailed information about individual performances, including dates of performance, genre, cast lists, companies, production credits, and BAM venue.</p>
				<p>The digital archive also allows researchers to track relationships and connections, for instance multiple appearances by individuals or companies, or multiple performances of specific works. It includes narrative text about iconic artists, productions, series, and BAM history, providing a frame of reference for the performances, and a sense of historical context. Researchers can also access images related to BAM and its performances, for instance photographs and posters.</p>
				<p>For a list of all collections, see "Browse Archival Collections."</p>
			
			</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->