{{{<ifdef code="ca_objects.idno"><H3>^ca_objects.preferred_labels.name</H3></ifdef>}}}

{{{<ifdef code="ca_objects.idno"><div class="uppercase">Identifer:</div>^ca_objects.idno<br/><br/></ifdef>}}}

{{{<ifdef code="ca_objects.idno">^ca_objects.description<br/><br/></ifdef>}}}

<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', 'ca_objects',  $this->getVar("object_id")); ?>