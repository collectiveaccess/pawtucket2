<?php
	$t_set_item = $this->getVar("set_item");
	$o_context = new ResultContext($this->request, 'ca_list_items', 'gallery');
	$o_context->setAsLastFind(false);
	$o_context->setParameter('set_id', $t_set_item->get('ca_set_items.set_id'));
	$o_context->setResultList([]);
	$o_context->saveContext();

# Added by TG 9/25/2021 to create object based on row (if presentation consists in archival objects)
	if ($this->getVar("table")=='ca_objects') {
		$t_object = new ca_objects($this->getVar("row_id"));
		$n_object_type = $t_object->get('ca_objects.type_id');
	}
?>
<?php # print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>

<H4>{{{^ca_set_items.set_item_slide_title}}}</H4>

{{{<ifdef code="ca_set_items.set_item_description">^ca_set_items.set_item_description</ifdef>}}}
{{{<ifdef code="ca_set_items.related_set_subject"> ^ca_set_items.related_set_subject.term_id  View <b><a href="https://digital.grpl.org/Detail/terms/^ca_set_items.related_set_subject.item_value">^ca_set_items.related_set_subject</a></b></ifdef>}}}
<!-- {{{<ifdef code="ca_objects.idno"><H6>File identifer:</H6>^ca_objects.idno</ifdef>}}}
{{{<ifdef code="ca_objects.rights.copyright_logo"><H6>Rights:</H6>^ca_objects.rights.copyright_logo</ifdef>}}}

{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>}}} -->

<?php # create link to object for all items except for site_asset
	if ($n_object_type != 522) {
		print "<br><br><p>".caDetailLink($this->request, _t("VIEW THIS ITEM"), '', $this->getVar("table"),  $this->getVar("row_id"))."</p>";
	}
?>
