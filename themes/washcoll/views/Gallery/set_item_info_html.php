<?php
	$t_item = $this->getVar("instance");
	$t_set_item = $this->getVar("set_item");
	$vs_set_item_description = $t_set_item->get("ca_set_items.preferred_labels");
?>
<div class="row">
	<div class="col-sm-12">
<?php
	if($vs_set_item_description != "[BLANK]"){
		print "<div class='unit'>".$vs_set_item_description."</div>";
	}
?>

		<H2><?php print caDetailLink($this->request, $this->getVar("label").", ".$t_item->get("ca_objects.idno"), '', $this->getVar("table"),  $this->getVar("row_id")); ?></H2>	

		{{{<ifdef code="ca_objects.description">^ca_objects.description%truncate=250%ellipsis=1<br/><br/></ifdef>}}}
	</div>
</div>