
	<div class='advancedContainer container'>
		<div class="row">
			<div class="col-sm-12">
			<h1>Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}			
			</div?
			<div class="col-sm-12">
				<div class="advancedSearchField">
					Full text<br/>
					{{{_fulltext%width=200px&height=25px}}}
				</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">	
				<div class="advancedSearchField">
					Title:<br/>
					{{{ca_objects.preferred_labels.name%width=220px}}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="advancedSearchField">
					Type:<br/>
					{{{ca_occurrences.workType%width=210px}}}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="advancedSearchField">
					Date range <i>(e.g. 1970-1979)</i><br/>
					{{{ca_objects.date%width=200px&height=40px&useDatePicker=0}}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<div class="advancedSearchField">
				Frame Size (Resolution)<br/>
				{{{ca_objects.essenceTrack.essenceTrackFrameSize%width=200px&height=40px}}}
			</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<div class="advancedSearchField">
				Keyword<br/>
				{{{ca_list_items.preferred_labels%width=200px&height=1}}}
			</div>	
			</div>
		</div>							
	</div>	
	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}

