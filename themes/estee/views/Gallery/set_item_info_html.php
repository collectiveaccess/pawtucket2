<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_set_item = $this->getVar("set_item");
	$vs_set_item_description = $t_set_item->get("ca_set_items.preferred_labels");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<p><?php print $this->getVar("label"); ?></p>
{{{<ifdef code="ca_objects.season_list|ca_objects.manufacture_date"><p>^ca_objects.season_list<ifdef code="ca_objects.season_list,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</p></ifdef>}}}

<?php
	if($vs_set_item_description && (strToLower($vs_set_item_description) != '[blank]')){
		print "<br/><div class='trimText'><p>".$vs_set_item_description."</p></div>";
	}
?>

<br/><br/><div class="text-center"><?php print caDetailLink($this->request, _t("View Record"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 190
		});
	});
</script>