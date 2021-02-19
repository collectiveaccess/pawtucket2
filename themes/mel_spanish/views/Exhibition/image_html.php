<?php
	$t_object = $this->getVar("t_object");


	print $t_object->getWithTemplate("<unit relativeTo='ca_objects' length='1'><l>^ca_object_representations.media.mediumlarge</l></unit>");
	print "<div class='mainImageCaption'>".$t_object->get("ca_objects.preferred_labels.name")."</div>";

?>