<?php
	$t_object = $this->getVar("object");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H2><?php print $this->getVar("label"); ?></H2>
<?php

		if ($va_date = $t_object->getWithTemplate('<ifcount min="1" code="ca_objects.date.date_value"><unit delimiter="<br/>"><ifdef code="ca_objects.date.date_value">^ca_objects.date.date_value (^ca_objects.date.date_types)</ifdef></unit></ifcount>')) {
			print "<div class='unit'><h6>Date</H6>".$va_date."</div>";
		}
				
		print "<br/>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id"));
?>