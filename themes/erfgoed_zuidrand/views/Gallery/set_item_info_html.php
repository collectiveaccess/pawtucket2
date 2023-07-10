<?php
	$t_item = $this->getVar("instance");
?>
<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>
<?php
		if($vn_collection_id = $t_item->get("ca_objects.object_collection.collection_id")){
			print "<div class='unit'><H6>Collectie</H6>";
			print caDetailLink($this->request, $t_item->get("ca_objects.object_collection.preferred_labels.name"), '', 'ca_collections', $vn_collection_id);
			print "</div>";
		}
		print $t_item->getWithTemplate('
			<ifdef code="ca_objects.idno"><div class="unit"><H6>Inventarisnummer</H6>^ca_objects.idno</div></ifdef>
			<ifdef code="ca_objects.content_description">
				<div class="unit"><h6>Beschrijving</h6>
					<span class="trimText">^ca_objects.content_description</span>
				</div>
			</ifdef>
			<ifcount code="ca_list_items" min="1"><div class="unit"><H6>Objecttype</H6><unit relativeTo="ca_list_items" delimiter=", ">^ca_list_items.preferred_labels.name_plural</unit></div></ifcount>
		');
?>
	
<br/>

<div class='text-center'><?php print caDetailLink($this->request, _t("Bekijk Details"), 'btn btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?></div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 130,
		  moreLink: '<a href="#">Lees meer</a>',
          lessLink: '<a href="#">Lees Minder</a>'
		});
	});
</script>