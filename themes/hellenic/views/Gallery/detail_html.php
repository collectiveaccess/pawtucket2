<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_object_ids =	$t_set->getItemRowIDs();
	$qr_items = caMakeSearchResult("ca_objects", array_keys($va_object_ids));
?>
	<div class="row">
		<div class="col-sm-12">
<?php		
			print "<H1>".$this->getVar("label")."</H1>";
			print "<div>".$t_set->get('ca_sets.set_description')."</div>";
?>			
		</div>
	</div>
	<div class="row galleryArea">
<?php	
			if ($qr_items){
				$vn_count = 0;
				while ($qr_items->nextHit()){
					print "<div class='col-sm-3'><div class='galleryTile'>";
					print caDetailLink($this->request, $qr_items->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $qr_items->get('ca_objects.object_id'));					
					print "<h6>".caDetailLink($this->request, $qr_items->get('ca_objects.preferred_labels'), '', 'ca_objects', $qr_items->get('ca_objects.object_id'))."</h6>";
					print "<div class='tileText'>".$qr_items->get('ca_objects.description')."</div>";
					print "<div class='readMore'>".caDetailLink($this->request, 'Read More', '', 'ca_objects', $qr_items->get('ca_objects.object_id'))."</div>";
					print "</div></div>";
					$vn_count++;
					if ($vn_count == 4) {
						print "</div><div class='row'>";
						$vn_count = 0;
					}
				}			
			}
			if ($vn_count < 4) {
				print "</div><!-- end row -->";
			}
?>		
	</div><!-- end row -->
	
