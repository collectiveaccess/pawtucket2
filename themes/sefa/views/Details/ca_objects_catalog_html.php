<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row contentbody">
	<div class='col-sm-6'>
		{{{representationViewer}}}
		{{{<ifdef code="ca_objects.caption">
			<div class="caption">^ca_objects.caption</caption>
		</ifdef>}}}
	</div><!-- end col -->
	<div class='col-sm-6'>
		{{{<ifdef code="ca_objects.preferred_labels.name">
			<h4>^ca_objects.preferred_labels.name</h4>
		</ifdef>}}}
		{{{<ifdef code="ca_objects.description">
			<p>^ca_objects.description</p>
		</ifdef>}}}
		
		{{{<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="related">
			<br/><strong>Artists: </strong>
		</ifcount>}}}
		{{{<ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="related">
			<br/><strong>Artist: </strong>
		</ifcount>}}}
		{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="related">
			<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="related"><l>^ca_entities.preferred_labels.displayname</l></unit>
		</ifcount>}}}
		
		{{{<ifcount code="ca_occurrences" min="1" restrictToRelationshipTypes="related">
			<unit relativeTo="ca_occurrences" delimiter="" restrictToRelationshipTypes="related">
				<br/><h2><l>^ca_occurrences.preferred_labels.name</l></h2>
				<h2>^ca_occurrences.exhibition_subtitle</h2>
				<h4>^ca_occurrences.opening_closing</h4>
			</unit>
		</ifcount>}}}
			
	</div><!-- end col -->
</div><!-- end row -->
