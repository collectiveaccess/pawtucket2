<div class="container">
	<div class="row">
		<div class="col-sm-7">
			<div class="bmacSearchContainer">				
					<h2>Search Brown Media Archives</h2>
					<p>This search does not include Newsfilm or the Peabody Awards Collection.</p>
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
		
	<div class="col-sm-4">
		<h1>Search Our Other Databases</h1>
					
			<div class="advancedContainer col-sm-12">
			
			<H2>Newsfilm Database Search</H2>
			
			<form method="post" action="https://newsfilm.libs.uga.edu/cgi/news">
			<input type="hidden" name="action" value="query">
			<input type="text" name="term_a" value="" size="37" placeholder="Enter Keywords">
			<div style="height:10px"></div>
			<select name="index_a">
			<option value="keyword">Keywords Anywhere</option>
			<option value="subject">Subject(s) of Clip</option>
			
			<option value="person">Persons</option>
			<option value="place">Place</option>
			<option value="date">Date</option>
			
			<option value="year">Year</option>
			<option value="id">Item ID</option>
			<option value="rl">Reel#</option>
			<option value="ln">Length</option>
			<option value="tm">Time In</option>
			
			<option value="br">B-Roll</option>
			<option value="sc">Script</option>
			<option value="ti">Title</option>
			<option value="_ti">Title phrase</option>
			
			<option value="sp">Spatial Coverage</option>
			<option value="_sp">Spatial Coverage phrase</option>
			<option value="sm">Summary</option>
			<option value="_sm">Summary phrase</option>
			
			<option value="sl">Slug Title</option>
			<option value="_sl">Slug Title phrase</option>
			<option value="pp">Persons</option>
			<option value="_pp">Persons phrase</option>
			<option value="ps">Person(s) in Clip</option>
			
			<option value="_ps">Person(s) in Clip phrase</option>
			<option value="de">Subject(s) of Clip</option>
			<option value="_de">Subject(s) of Clip phrase</option>
			
			<option value="dp">Subject, Persons</option>
			<option value="_dp">Subject, Persons phrase</option>
			<option value="do">Subject, Topics</option>
			<option value="_do">Subject, Topics phrase</option>
			<option value="dg">Subject, Locations</option>
			<option value="_dg">Subject, Locations phrase</option>
			
			<option value="dr">Subject, Corporate</option>
			<option value="_dr">Subject, Corporate phrase</option>
			
			<option value="rp">Reporter</option>
			<option value="_rp">Reporter phrase</option>
			<option value="tp">Type</option>
			<option value="pn">Public Notes</option>
			<option value="cn">Condition Notes</option>
			<option value="gr">Grant</option>
			<option value="so">Newsfilm Source</option>
			
			<option value="vc">Viewing Copy</option>
			
			<option value="dc">Digitized Copy</option>
			<option value="ge">Genre</option>
			<option value="_ge">Genre phrase</option>
			<option value="up">Update Date</option>
			</select>
			<h5><a href="https://newsfilm.libs.uga.edu/cgi/news">Search the Newsfilm Database</a>
			</h5>
			<div style="height:10px"></div>
			<button type="submit" class="btn btn-primary">Search</button>
			</form>
			</div>

		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
