<?php
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 4;
?>
	<table border="0" cellpadding="0px" cellspacing="0px" width="100%">
<?php
	while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
		if ($vn_c == 0) { print "<tr>\n"; }
		$vn_object_id = $qr_hits->get('object_id');
		$va_labels = $qr_hits->getDisplayLabels();
		$vs_caption = "";
		foreach($va_labels as $vs_label){
			$vs_caption .= $vs_label;
		}
		# --- get the height of the image so can calculate padding needed to center vertically
		$va_media_info = $qr_hits->getMediaInfo('ca_object_representations.media','thumbnail');
		$vn_padding_top = 0;
		$vn_padding_top_bottom =  ((130 - $va_media_info["HEIGHT"]) / 2);
		$vs_image = $qr_hits->getMediaTag('ca_object_representations.media','thumbnail');
		if(!$vs_image){
			# --- get the placeholder graphic from the novamuse theme
			$va_themes = caExtractValuesByUserLocale($qr_hits->get("novastory_category", array("returnAsArray" => true)));
			$vs_placeholder = "";
			if(sizeof($va_themes)){
				$t_list_item = new ca_list_items();
				foreach($va_themes as $k => $vs_list_item_id){
					$t_list_item->load($vs_list_item_id);
					if(file_exists($this->request->getThemeDirectoryPath()."/graphics/novamuse/placeholders/small/".$t_list_item->get("idno").".png")){
						$vs_image = "<img src='".$this->request->getThemeUrlPath()."/graphics/novamuse/placeholders/small/".$t_list_item->get("idno").".png'>";
						$vn_padding_top_bottom = 5;
					}
				}
			}
			if(!$vs_image){
				$vs_image = "<img src='".$this->request->getThemeUrlPath()."/graphics/novamuse/placeholders/small/placeholder.png'>";
				$vn_padding_top_bottom = 5;
			}
		}
		
		print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
		if($this->request->config->get('allow_detail_for_ca_objects')){
			print caNavLink($this->request, $vs_image, '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
		}else{
			print $vs_image;
		}
		// Get thumbnail caption
		$this->setVar('object_id', $vn_object_id);
		$this->setVar('caption_title', $vs_caption);
		$this->setVar('caption_idno', $qr_hits->get('idno'));
		
		print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";

		
		// set view vars for tooltip
		$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media','small'));
		$this->setVar('tooltip_title', $vs_caption);
		$this->setVar('tooltip_idno', $qr_hits->get('idno'));
		TooltipManager::add(
			".searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
		);
		
		$vn_c++;
		$vn_itemc++;
		
		if ($vn_c == $vn_numCols) {
			print "</tr>\n";
			$vn_c = 0;
		}else{
			print "<td><!-- empty for spacing --></td>";
		}
	}
	if(($vn_c > 0) && ($vn_c < $vn_numCols)){
		while($vn_c < $vn_numCols){
			print "<td class='searchResultTd'><!-- empty --></td>\n";
			$vn_c++;
			if($vn_c < $vn_numCols){
				print "<td><!-- empty for spacing --></td>";
			}
		}
		print "</tr>\n";
	}
?>
	</table>
<?php

	print $this->render('paging_controls_html.php');
?>