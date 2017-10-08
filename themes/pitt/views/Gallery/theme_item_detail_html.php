<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_id = $this->getVar("set_id");
	$va_set_items = $this->getVar("set_items");
	$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);;
	$rep_width = $this->getVar("rep_height");
	$rep_height = $this->getVar("rep_width");

	$t_set = new ca_sets($pn_set_id);
	$t_set_item = new ca_set_items($pn_set_item_id);
	$t_object = $t_set_item->getItemInstance();
		
	$vs_title = $t_set_item->get('ca_set_items.preferred_labels');
	$vs_description = $t_set_item->get('ca_set_items.set_item_description');
	if ($t_set_item->get('ca_set_items.set_item_text_color', array('convertCodesToDisplayText' => true)) == 'Black') {
		$vs_color = 'style="color:#000000;"';
	} elseif ($t_set_item->get('ca_set_items.set_item_text_color', array('convertCodesToDisplayText' => true)) == 'White') {
		$vs_color = 'style="color:#ffffff;"';
	} elseif ($t_set_item->get('ca_set_items.set_item_text_color', array('convertCodesToDisplayText' => true)) == 'Gray') {
		$vs_color = 'style="color:#666666;"';
	} elseif ($t_set_item->get('ca_set_items.set_item_text_color', array('convertCodesToDisplayText' => true)) == 'Navy Blue') {
		$vs_color = 'style="color:#1c2957;"';
	}
	

		print "<div class='exName'>".caNavLink($this->request, $t_set->get('ca_sets.preferred_labels'), '', '', 'Gallery', $t_set->get('ca_sets.set_id'), array('theme' => 1))."</div>";
		print "<div class='container objectSlide'><div class='row'>";
		print "<div class='col-sm-5' style='margin-left:-15px;'>";
		print "<div class='themeImage'>".$t_object->get('ca_object_representations.media.large')."</div>";
		print "<div class='setItemCaption'>".$t_set_item->get('ca_set_items.preferred_labels')."</div>";
		print "</div>";
		print "<div class='col-sm-3' >";
		print "<div class='setItemDescription background'><h3>Description</h3>".$t_set_item->get('ca_set_items.set_item_description')."</div>";	
		print "</div>";
		print "<div class='col-sm-4' ><div class='container'><div class='row themes'>";
		
		if ($va_set_item_topics = $t_set_item->get('ca_set_items.set_item_theme', array('returnAsArray' => true))) {
			print "<div class='col-sm-12'><h3>Related Themes</h3></div>";
			foreach ($va_set_item_topics as $va_key => $va_set_item_topic) {
				print "<div class='col-sm-12'><div class='galleryItem'>".caNavLink($this->request, caGetListItemByIDForDisplay($va_set_item_topic), '', '', 'Gallery', $pn_set_id, array('theme_id' => $va_set_item_topic))."</div></div>";
			}
		}
		print "</div><!-- end row -->";
		print "<div class='row'>";
		
		print "<h3 style='padding-left:15px;'>Related Objects</h3>";
			$vn_i = 1;
			foreach ($va_set_items as $va_key => $va_set_item) {
				if ($va_set_item['item_id'] == $pn_set_item_id) {continue;}
				print "<div class='col-sm-6 themeThumb item'>";
				print caNavLink($this->request, $va_set_item['representation_tag_iconlarge']."<div class='setItemCaption'>".$va_set_item['set_item_label']."</div>", '', '', 'Gallery', $pn_set_id, array('theme_item' => 1, 'set_item_id' => $va_set_item['item_id']));
				print "</div>";
				if ($vn_i == 2) {
					print "</div><div class='row'>";
					$vn_i = 0;
				}
				$vn_i++;
			}
		print "</div>";
		print "<div class='row'>";
		print "<hr><div class='col-sm-12'>";
		print "<div class='slideNav'>";
		if($pn_previous_item_id){
			print caNavLink($this->request, "<div class='galleryDetailPrevious'><i class='fa fa-angle-left'></i></div>", '', '', 'Gallery', $pn_set_id, array('theme_item' => 1, 'set_item_id' => $pn_previous_item_id));
		}else{
			print "<a href='#' class='galleryDetailPrevious inactive'><i class='fa fa-angle-left'></i></a>";
		}
		print caNavLink($this->request, 'Back to Gallery', 'backToGrid', '', 'Gallery', $pn_set_id, array('theme' => 1)); 
		if($pn_next_item_id){
			print caNavLink($this->request, '<div class="galleryDetailNext"><i class="fa fa-angle-right"></i></div>', '', '', 'Gallery', $pn_set_id, array('theme_item' => 1, 'set_item_id' => $pn_next_item_id));
		}else{
			print "<a href='#' class='galleryDetailNext inactive'><i class='fa fa-angle-right'></i></a>";
		}		
		print "</div><!-- end slideNav -->";
		print "</div><!-- end col -->";
		print "</div><!-- end row -->";
		print "</div><!-- end container --></div><!-- end col -->";				
		print "</div><!-- end row --></div><!-- end container -->";

?>

