<?php
	$t_object = $this->getVar("item");
?>
{{{<ifcount code="ca_objects.related" min="1">
<div class="row">
	<div class="col-sm-12 relatedObjectsContainer">
	<H3>Other related records in Ta X̱ay Sxwimálatncht</H3>
	<hr/>
		<div class="row">
			<unit relativeTo="ca_objects.related" delimiter=" ">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
					<l><div class="bg_beige relatedObjectsCard">
						<ifdef code="^ca_object_representations.media.iconlarge">^ca_object_representations.media.iconlarge</ifdef>^ca_objects.preferred_labels.name
					</div></l>
				</div>
			</unit>
		</div>
	</div>
</div></ifcount>}}}
