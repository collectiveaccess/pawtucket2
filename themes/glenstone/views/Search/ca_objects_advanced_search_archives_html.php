<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Archives Advanced Search</h1>

<?php			
	print "<span class='faLink'><i class='fa fa-archive' style='padding-right:5px;'></i>".caNavLink($this->request, 'Browse archival collections', '', '', 'FindingAid', 'Collection/Index')."</span>";
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
		<div class="advancedSearchField">
			Keyword<br/>
			{{{_fulltext%width=200px&height=25px}}}
			{{{_fulltext:boolean}}}
		</div>
	</div>
	<div class='advancedContainer'>
		<div class="advancedSearchField">
			Type:<br/>
			{{{ca_objects.type_id%restrictToTypes=audio;document;ephemera;image;moving_image}}}
		</div>
	
		<div class="advancedSearchField">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.dc_date.dc_dates_value%width=200px&height=40px&useDatePicker=0}}}
		</div>
		
		<div class="advancedSearchField">
			Collection <br/>
			{{{ca_collections.collection_id%restrictToTypes=collection%width=200px&height=40px&select=1&sort=ca_collections.preferred_labels.name}}}
		</div>
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Archival Research Assistance</h1>
			<h3><a href='mailto:ray.barker@glenstone.org'>Contact the Archives</a></h3>
			<h3>SOCIETY OF AMERICAN ARCHIVISTS GUIDES</h3>
				<p><a href='http://www2.archivists.org/usingarchives' target='_blank'>Guide to Archival Research</a></p>
				<p><a href='http://www2.archivists.org/glossary' target='_blank'>Glossary of Terminology</a></p>
				<p><a href='http://www2.archivists.org/statements/saa-core-values-statement-and-code-of-ethics' target='_blank'>Archivist Code of Ethics</a></p>
			<h3>OTHER ART MUSEUM ARCHIVES</h3>
				<p><a href='http://www.aaa.si.edu/' target='_blank'>Archives of American Art</a></p>
				<p><a href='http://metmuseum.org/research/libraries-and-study-centers/museum-archives' target='_blank'>Metropolitan Museum of Art Archives</a></p>
				<p><a href='http://www.moma.org/learn/resources/archives/index' target='_blank'>Museum of Modern Art Archives</a></p>
				<p><a href='http://www.nga.gov/resources/gadesc.shtm' target='_blank'>National Gallery of Art Archives</a></p>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->