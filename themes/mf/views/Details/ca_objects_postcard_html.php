<?php
	$t_item = $this->getVar('item');
?>
<h2>I am a detail for a postcard only: <?php print $t_item->get('ca_objects.preferred_labels.name'); ?></h2>
<?php
	$t_item->dump();
?>