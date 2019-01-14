<?php  
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; 

?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.description"><div class="trimText">^ca_objects.description</div><br/><br/></ifdef>}}}

{{{<ifcount code="ca_entities" min="1" max="1"><b>Related person: </b></ifcount>}}}
{{{<ifcount code="ca_entities" min="2"><b>Related people: </b></ifcount>}}}
{{{<unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit><br/><br/>}}}


<?php print caDetailLink($this->request, _t("VIEW RECORD"), '', $this->getVar("table"),  $this->getVar("row_id")); ?>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>