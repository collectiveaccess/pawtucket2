<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>
<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>

{{{^ca_set_items.description}}}

