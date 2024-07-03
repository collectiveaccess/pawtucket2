<?php					
								$vn_item_id = $this->getVar("set_item_id");
								$t_set_item = new ca_set_items($vn_item_id);
								# --- display the rep viewer for the featured object so if it's video, it will play
								$vn_row_id = $t_set_item->get("ca_set_items.row_id");
								$t_object = new ca_objects($vn_row_id);
								$vb_link_to_object = false;
								if(($t_object->get("ca_objects.type_id") != $vn_digital_exhibit_object_type_id) || (($t_object->get("ca_objects.type_id") == $vn_digital_exhibit_object_type_id) && ($t_object->get("ca_objects.display_detail_page", array("convertCodesToDisplayText" => true)) == "Yes"))){
									$vb_link_to_object = true;
								}
								$t_representation = $t_object->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
								if($t_representation){
									$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
									$vs_version = $va_media_display_info["display_version"];
									$vs_caption = "";
									if($t_set_item->get("ca_set_items.preferred_labels") != "[BLANK]"){
										$vs_caption = $t_set_item->get("ca_set_items.preferred_labels");
									}
									if(!$vs_caption){
										$vs_caption = $t_object->get("ca_objects.preferred_labels.name");
									}
									if($vs_caption){
										#if($vb_link_to_object){
										#	$vs_caption = "<div class='mediaViewerCaption text-center'>".caDetailLink($this->request, $vs_caption, '', "ca_objects", $vn_row_id)."</div>";
										#}else{
											$vs_caption = "<div class='mediaViewerCaption text-center'>".$vs_caption."</div>";
										#}
									}
									if($vs_version == "large"){
										$vs_media = $t_representation->get("ca_object_representations.media.".$vs_version);
										#if($vb_link_to_object){
										#	$vs_media = caDetailLink($this->request, $vs_media, '', "ca_objects", $vn_row_id);
										#}
										$vs_media = '<a href="#" onclick="caMediaPanel.showPanel(\''.caNavUrl($this->request, "", "Detail", "GetMediaOverlay", array("context" => "objects", "id" => $t_object->get("ca_objects.object_id"), "representation_id" => $t_representation->get("ca_object_representations.representation_id"), "overlay" => 1)).'\'); return false;">'.$vs_media.'</a>';
									
										if($vs_caption){
											$vs_media .= $vs_caption;
										};
									}else{
										$vs_media =  caRepresentationViewer(
																	$this->request, 
																	$t_object, 
																	$t_object,
																	array(
																		'display' => 'detail',
																		'showAnnotations' => true, 
																		'primaryOnly' => true, 
																		'dontShowPlaceholder' => true, 
																		#'captionTemplate' => "<unit relativeTo='ca_objects'><l><ifdef code='ca_object_representations.preferred_labels.name'><div class='mediaViewerCaption text-center'>^ca_object_representations.preferred_labels.name</div></ifdef></l></unit>"
																		'captionTemplate' => $vs_caption
																	)
																);
									}
									print $vs_media;
								}
?>