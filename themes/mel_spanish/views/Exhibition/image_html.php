<?php
	$t_object = $this->getVar("t_object");

	print $t_object->getWithTemplate("<l>^ca_object_representations.media.mediumlarge</l><div class='mainImageCaption'><l>^ca_objects.preferred_labels.name<ifdef code='ca_objects.preferred_labels.name'><br/></ifdef><small>To find out more click on the image above</small></l></div>");

?>