<?php print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; ?>
<H4><?php print $this->getVar("label"); ?></H4>

{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Catalog Number</H6>^ca_objects.idno</div></ifdef>}}}
{{{<ifdef code="ca_objects.fmp_date_of_origin"><div class="unit"><H6>Date of Origin</H6>^ca_objects.fmp_date_of_origin</div></ifdef>}}}
{{{<ifdef code="ca_objects.manufacturer"><div class="unit"><H6>Manufacturer</H6>^ca_objects.manufacturer</div></ifdef>}}}
{{{<ifdef code="ca_objects.author.auth"><div class="unit"><H6>Artist/Author</H6>^ca_objects.author.auth</div></ifdef>}}}
{{{<ifdef code="ca_objects.material"><div class="unit"><H6>Materials</H6>^ca_objects.material%delimiter=,_</div></ifdef>}}}

{{{<ifdef code="ca_objects.descriptions">
	<div class='unit'><h6>Description</h6>^ca_objects.descriptions</div>
</ifdef>}}}
<br/>
<p class="text-center">
<?php print caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); ?>
</p>