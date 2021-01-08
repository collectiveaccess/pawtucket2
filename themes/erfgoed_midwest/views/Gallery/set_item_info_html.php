<?php
	$t_object = $this->getVar("object");
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";
?>
<H2><?php print $this->getVar("label"); ?></H2>
<div class="infoScroll">
<?php
	print caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id"));
	print $t_object->getWithTemplate('<ifcount code="ca_entities" restrictToRelationshipTypes="owner" min="1"><div class="unit"><H6>Collectie</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="owner" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
		<ifdef code="ca_objects.idno"><div class="unit"><H6>Objectnummer</H6>^ca_objects.idno</div></ifdef>
		<ifdef code="ca_objects.object_names"><div class="unit"><H6>Objectnaam</H6>^ca_objects.object_names%delimiter=,_</div></ifdef>
		<ifdef code="ca_objects.object_keywords"><div class="unit"><H6>Trefwoorden</H6>^ca_objects.object_keywords%delimiter=,_</div></ifdef>
		<ifdef code="ca_objects.object_tags"><div class="unit"><H6>Tags</H6>^ca_objects.object_tags%delimiter=,_</div></ifdef>
		<ifdef code="ca_objects.description">
			<div class="unit"><h6>Beschrijvende notitie</h6>
				<span class="trimText">^ca_objects.description</span>
			</div>
		</ifdef>
		<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><div class="unit"><H6>Vervaardiger</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
	');
	if($t_object->get("type_id", array("convertCodesToDisplayText" => true)) != "Publication"){
		$t_object->getWithTemplate('<ifdef code="ca_objects.object_creation_date"><div class="unit"><H6>Datum</H6>^ca_objects.object_creation_date%delimiter=,_</div></ifdef>');
	}
	print $t_object->getWithTemplate('
		<ifdef code="ca_objects.object_creation_period"><div class="unit"><H6>Periode</H6>^ca_objects.object_creation_period%delimiter=,_</div></ifdef>

		<ifcount code="ca_entities" restrictToRelationshipTypes="author" min="1"><div class="unit"><H6>Auteur</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
		<ifdef code="ca_objects.nonpreferred_labels"><div class="unit"><H6>Alternatieve titel</H6>^ca_objects.nonpreferred_labels%delimiter=,_</div></ifdef>
	');
	if($t_object->get("type_id", array("convertCodesToDisplayText" => true)) == "Publication"){
		$t_object->getWithTemplate('<ifdef code="ca_objects.object_creation_date"><div class="unit"><H6>Publication Date</H6>^ca_objects.object_creation_date%delimiter=,_</div></ifdef>');
	}
	print $t_object->getWithTemplate('<ifdef code="ca_objects.publication_medium"><div class="unit"><H6>Medium</H6>^ca_objects.publication_medium%delimiter=,_</div></ifdef>
		<ifdef code="ca_objects.publication_edition"><div class="unit"><H6>Editie</H6>^ca_objects.publication_edition%delimiter=,_</div></ifdef>
		<ifcount code="ca_places" restrictToRelationshipTypes="published" min="1"><div class="unit"><H6>Plaats van uitgave</H6><unit relativeTo="ca_places" restrictToRelationshipTypes="published" delimiter=", ">^ca_places.preferred_labels</unit></div></ifcount>
		<ifcount code="ca_entities" restrictToRelationshipTypes="publisher" min="1"><div class="unit"><H6>Uitgever</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="publisher" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>
					
		<ifdef code="ca_objects.content_description">
			<div class="unit"><h6>Inhoud</h6>
				<span class="trimText">^ca_objects.content_description</span>
			</div>
		</ifdef>
	
	
				
		<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="1" max="1"><H6>Persoon</H6></ifcount>
		<ifcount code="ca_entities" restrictToRelationshipTypes="depicts" min="2"><H6>Mensen</H6></ifcount>
		<unit relativeTo="ca_entities" restrictToRelationshipTypes="depicts" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
		<ifcount code="ca_places" min="1" max="1"><H6>Plaats</H6></ifcount>
		<ifcount code="ca_places" min="2"><H6>Plaatsen</H6></ifcount>
		<unit relativeTo="ca_places" delimiter="<br/>"><unit relativeTo="ca_places.hierarchy" delimiter=" &gt; "><l>^ca_places.preferred_labels.name</l></unit> (^relationship_typename)</unit>
		<ifcount code="ca_occurrences" min="1" max="1"><H6>Gebeurtenis</H6></ifcount>
		<ifcount code="ca_occurrences" min="2"><H6>Gebeurtenissen</H6></ifcount>
		<unit relativeTo="ca_occurrences" delimiter="<br/>">^ca_occurrences.preferred_labels (^relationship_typename)</unit>
		<ifcount code="ca_objects.related" min="1" max="1"><H6>Object</H6></ifcount>
		<ifcount code="ca_objects.related" min="2"><H6>Objecten</H6></ifcount>
		<unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels</l> (^relationship_typename)</unit>
	');
?>
</div>