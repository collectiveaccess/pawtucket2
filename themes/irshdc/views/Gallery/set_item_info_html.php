<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<div class="galleryTombstoneScroll">

	{{{<ifdef code="ca_objects.preferred_labels.name"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}
	{{{<ifdef code="ca_objects.dc_website"><div class='unit'><a href="^ca_objects.dc_website" target="_blank">View Website <span class="glyphicon glyphicon-new-window"></span></a></div></ifdef>}}}
	
	{{{<ifdef code="ca_objects.displayDate"><div class='unit'><h6>Date</h6>^ca_objects.displayDate</div></ifdef>}}}
	{{{<ifdef code="ca_objects.MARC_copyrightDate"><div class='unit'>&copy; ^ca_objects.MARC_copyrightDate</div></ifdef>}}}

	{{{<ifdef code="ca_objects.dc_description"><div class='unit'>^ca_objects.dc_description</div></ifdef>}}}


	{{{<ifdef code="ca_objects.curators_comments.comments">
		<div class="unit" data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.curators_comments.comment_reference"><h6>Curatorial comment</h6>
			<span class="trimText">^ca_objects.curators_comments.comments</span>
		</div>
	</ifdef>}}}

	{{{<ifcount code="ca_entities" restrictToTypes="school" min="1"><div class="unit"><ifcount code="ca_entities" restrictToTypes="school" min="1" max="1"><h6>School</h6></ifcount><ifcount code="ca_entities" restrictToTypes="school" min="2"><h6>Schools</h6></ifcount><unit relativeTo="ca_entities" restrictToTypes="school" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}

</div>
<?php print "<div class='unit text-center'>".caDetailLink($this->request, _t("More Information"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id"))."</div>"; ?>