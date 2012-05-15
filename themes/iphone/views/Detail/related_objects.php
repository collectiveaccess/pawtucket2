<?php
	$qr_hits = $this->getVar('browse_results');
	$vn_itemc = 0;
	if($qr_hits->numHits() > 0){
		if (!$this->request->isAjax()) {
			print "<div class='collapseListHeading'><a href='#' onclick='$(\"#relatedObjects\").slideToggle(250); return false;'>"._t("Related Objects")."</a></div><!-- end collapseListHeading -->";
			print "<div id='relatedObjects' class='listItems' style='display:none;'>";
			print "<div class='itemList'>";
		}
			while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
				$vn_object_id = $qr_hits->get('object_id');
				$va_labels = $qr_hits->getDisplayLabels();
				$vs_caption = "";
				foreach($va_labels as $vs_label){
					$vs_caption .= $vs_label;
				}
				# --- get the height of the image so can calculate padding needed to center vertically
				print "<div class='item'><div class='thumb'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'tiny'), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')))."</div>";
				
				// Get thumbnail caption
				$this->setVar('object_id', $vn_object_id);
				$this->setVar('caption_title', $vs_caption);
				$this->setVar('caption_idno', $qr_hits->get('idno'));
				
				print $this->render('../Results/ca_objects_result_caption_html.php');
				print "<div style='clear:left;'><!--empty --></div></div><!-- end item -->\n";
				$vn_itemc++;
			}
			print $this->render('paging_controls_html.php');
		if (!$this->request->isAjax()) {
			print "</div><!-- end itemList --></div><!-- end relatedObjects -->";
		}
	}
?>