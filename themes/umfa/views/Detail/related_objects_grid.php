<?php
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 5;
	$va_access_values	= $this->getVar('access_values');
?>
	<table border="0" cellpadding="0px" cellspacing="0px" width="100%">
<?php
	$t_object = new ca_objects();
	while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
		if ($vn_c == 0) { print "<tr>\n"; }
		$vn_object_id = $qr_hits->get('object_id');
		$va_labels = $qr_hits->getDisplayLabels();
		$vs_caption = "";
		foreach($va_labels as $vs_label){
			$vs_caption .= $vs_label;
		}
		# --- get the height of the image so can calculate padding needed to center vertically
		$va_media_info = $qr_hits->getMediaInfo('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values));
		$vn_padding_top = 0;
		$vn_padding_top_bottom =  ((130 - $va_media_info["HEIGHT"]) / 2);
		print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
		if($this->request->config->get('allow_detail_for_ca_objects')){
			print caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
		}else{
			print $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values));
		}
		# -- get artist name for caption and rollovers
		$va_creators = array();
		$t_object->load($vn_object_id);
		$va_creators = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('creator')));
		$va_creator_name = array();
		foreach($va_creators as $va_creator_info){
			$va_creator_name[] = $va_creator_info["label"];
		}
		$vs_artist = "";
		$vs_artist = implode($va_creator_name, ", ");
		$vs_origin = "";
		$vs_origin = $t_object->get("origin");
		$vs_date = "";
		$vs_date = $t_object->get("creation_date");
		
		// Get thumbnail caption
		$this->setVar('object_id', $vn_object_id);
		$this->setVar('caption_title', $vs_caption);
		$this->setVar('caption_idno', $qr_hits->get('idno'));
		$this->setVar('caption_object_type', $qr_hits->get('ca_objects.object_type'));
		$this->setVar('caption_artist', $vs_artist);
		
		print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";

		
		// set view vars for tooltip
		$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media','small', array('checkAccess' => $va_access_values)));
		$this->setVar('tooltip_title', $vs_caption);
		$this->setVar('tooltip_artist', $vs_artist);
		$this->setVar('tooltip_idno', $qr_hits->get('idno'));
		$this->setVar('tooltip_origin', $vs_origin);
		$this->setVar('tooltip_date', $vs_date);
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