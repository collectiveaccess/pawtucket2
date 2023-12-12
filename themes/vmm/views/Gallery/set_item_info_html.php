<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Identifer</H6>^ca_objects.idno</div></ifdef>}}}

{{{<ifdef code="ca_objects.archive_dates.archive_display"><div class="unit"><H6>Date</H6>^ca_objects.archive_dates.archive_display</div></ifdef>}}}
				
{{{<ifdef code="ca_objects.date.dates_value"><unit relativeTo="ca_objects.date"><if rule="^ca_objects.date.dc_dates_types =~ /Date made/"><div class="unit"><H6>Date Made</H6>^ca_objects.date.dates_value</div></if></unit></ifdef>}}}
				

{{{<ifdef code="ca_objects.description">^ca_objects.description</ifdef>}}}

{{{<ifdef code="ca_objects.scope_content"><div class="unit"><H6>Scope & Content</H6>^ca_objects.scope_content</div></ifdef>}}}

<br/><br/>
<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>