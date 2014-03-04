{{{<ifdef code="ca_objects.idno"><H4>^ca_objects.preferred_labels.name</H4></ifdef>}}}

{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.idno">^ca_objects.description<br/><br/></ifdef>}}}

<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>