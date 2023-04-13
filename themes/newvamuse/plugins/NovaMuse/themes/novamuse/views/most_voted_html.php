<?php
	$qr_res = $this->getVar("results");
	$va_access_values 	= $this->getVar('access_values');
	$va_counts = $this->getVar('counts');
?>
<div id='pageBody'>
	<div class="textContent">
		<H1>
			#Canada150
		</H1>
	</div>
	
	
	
	
<?php
if(is_array($va_counts) && sizeof($va_counts)){
	$vn_c = 0;
	if($qr_res->numHits()){
		while(($qr_res->nextHit()) && ($vn_c <= 600)) {
			if(($qr_res->get("ca_object_representations.access") == 1) && ($qr_res->get("ca_object_representations.deleted") == 0)){
						$vn_id 					= $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("ca_objects.idno"), '', 'ca_objects', $vn_id);
						$vs_label_detail_link 	= "<p>".caDetailLink($this->request, $qr_res->get("ca_objects.preferred_labels.name"), '', 'ca_objects', $vn_id)."</p>";
						$vs_thumbnail = "";
						$vs_type_placeholder = "";
						$vs_typecode = "";
							if(!($vs_thumbnail = $qr_res->getMediaTag('ca_object_representations.media', 'medium', array("checkAccess" => $va_access_values)))){
								# --- get the placeholder graphic from the novamuse theme
								$va_themes = caExtractValuesByUserLocale($qr_res->get("novastory_category", array("returnAsArray" => true)));
								$vs_placeholder = "";
								if(sizeof($va_themes)){
									$t_list_item = new ca_list_items();
									foreach($va_themes as $k => $vs_list_item_id){
										$t_list_item->load($vs_list_item_id);
										if(caGetThemeGraphic($this->request, 'placeholders/'.$t_list_item->get("idno").'.png')){
											$vs_thumbnail = caGetThemeGraphic($this->request, 'placeholders/'.$t_list_item->get("idno").'.png');
											$vn_padding_top_bottom = 5;
										}
									}
								}
								if(!$vs_image){
									$vs_image = caGetThemeGraphic($this->request, 'placeholders/placeholder.png');
									$vn_padding_top_bottom = 5;
								}
							}					
							$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $vn_id);				

							$vs_label_detail_link .= "<p>".$qr_res->get('ca_objects.idno')."</p>";
							$vs_label_detail_link .= "<p>".$qr_res->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('repository')))."</p>";
				
						$vs_add_to_set_url		= caNavUrl($this->request, '', 'Sets', 'addItemForm', array('object_id' => $vn_id));

						$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

						print "
			<div class='bResultItemCol col-sm-3 col-md-2'>
				<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
					<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
					<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
						<div class='bResultItemText'>
							{$vs_label_detail_link}
							".$va_counts[$vn_id]." votes
						</div><!-- end bResultItemText -->
					</div><!-- end bResultItemContent -->
					<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
						<hr>
						{$vs_expanded_info}
						".((($this->request->config->get("disable_my_collections"))) ? "" : "<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'>".$vs_lightbox_icon."</i></a>")."
					</div><!-- bResultItemExpandedInfo -->
				</div><!-- end bResultItem -->
			</div><!-- end col -->";
				
						$vn_c++;
			}
		}
	}
}else{
	print "No items have been voted for yet.<br/><br/>";
}

?>
	
	
</div>