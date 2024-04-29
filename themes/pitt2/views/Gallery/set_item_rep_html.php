<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_id = $this->getVar("set_id");
	$pn_set_item_id = $this->getVar("set_item_id");
	$pn_object_id = $this->getVar("object_id");
	$rep_width = $this->getVar("rep_height");
	$rep_height = $this->getVar("rep_width");
	$t_object = new ca_objects($pn_object_id);
	$vs_rep_id = $this->getVar("representation_id");
	$t_representation = new ca_object_representations($vs_rep_id);
	$va_access_values = caGetUserAccessValues($this->request);
	
	$t_set_item = new ca_set_items($pn_set_item_id);
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
	

	if($pn_previous_item_id){
		print "<a href='#' class='galleryDetailPrevious' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); return false;'><i class='fa fa-angle-left'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive'><i class='fa fa-angle-left'></i></a>";
	}
	if($pn_next_item_id){
		print "<a href='#' class='galleryDetailNext' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); return false;'><i class='fa fa-angle-right'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive'><i class='fa fa-angle-right'></i></a>";
	}
	if ($t_set_item->get('ca_set_items.set_item_template', array('convertCodesToDisplayText' => true)) == 'Title Slides') {
		print "<div class='container slideTitle'><div class='row'><div class='col-sm-12' >";
		print "<div id='galleryDetailImageWrapper'>".$this->getVar("rep")."</div>";
		print "<div class='titleSlideText'>";
		print "<h2 {$vs_color}>".$vs_title."</h2>";
		print "<div {$vs_color}>".$vs_description."</div>";		
		print "</div>";
		print "</div><!-- end col --></div><!-- end row --></div><!-- end container -->";
	} elseif ($t_set_item->get('ca_set_items.set_item_template', array('convertCodesToDisplayText' => true)) == 'Section Divider') {
		print "<div class='container slideTitle'><div class='row'><div class='col-sm-12' >";
		print "<div id='galleryDetailImageWrapper'>".$this->getVar("rep")."</div>";
		print "<div class='titleSlideText'>";
		print "<h2 {$vs_color}>".$vs_title."</h2>";
		print "<div {$vs_color}>".$vs_description."</div>";		
		print "</div>";
		print "</div><!-- end col --></div><!-- end row --></div><!-- end container -->";
	#} elseif ($t_set_item->get('ca_set_items.set_item_template', array('convertCodesToDisplayText' => true)) == 'Object Record') {
	} else {
		print "<div class='container objectSlide'><div class='row'><div class='col-sm-8'>";
	
		print "<div id='galleryDetailImageWrapper'>";
		$va_options = array();
		$va_media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE'));
		#print caObjectDetailMedia($this->request, $object_id, $t_representation, $t_object, array_merge($va_media_display_info, array("primaryOnly" => true)));		
		require_once(__CA_LIB_DIR__."/Media/MediaViewerManager.php");
		print caRepresentationViewer($this->request, $t_object, $t_object, array_merge($va_options, $va_media_display_info, 
							array(
								'display' => 'detail',
								'showAnnotations' => true, 
								'primaryOnly' => false, 
								'dontShowPlaceholder' => true, 
								'captionTemplate' => ''
							)
						)
					);		
		
		print "</div>";	
	
		print "</div><!-- end col -->";
		print "<div class='col-sm-4' style='padding-bottom:60px;'>";
		print "<div class='galleryTextArea'>";	
		print "<h2 {$vs_color}>".$vs_title."</h2>";
		print "<div {$vs_color}>".$vs_description."</div>";
		print "</div>";
				
		print "<div class='galleryThumbnail'>";
		#print "<div class='image'>".$t_object->get('ca_object_representations.media.icon')."</div>";
		print "<div class='text'>";
		print "<p>".$t_object->get('ca_objects.preferred_labels')."</p>";
		#print "<p>".$t_object->get('ca_objects.description')."</p>";
		print "<p>".$t_object->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true, 'excludeRelationshipTypes' => array('donor'), 'checkAccess' => $va_access_values))."</p>"; 

		print "</div>";
		print "</div>";	
			
		print "</div><!-- end col --></div><!-- end row --></div><!-- end container -->";
	}
?>
<!--<script>


$(document).ready(function() {
    $(window).resize(function() {
        var divheight = $('#galleryDetailImageArea').height();
        var imgheight = $("#galleryDetailImageWrapper img").height();
        if (640 < imgheight) {
       		$("#galleryDetailImageWrapper img").height(divheight);
       		$("#galleryDetailImageWrapper img").css("width", "auto");
        } else {
        	$("#galleryDetailImageWrapper img").css("height", "auto");
        	$("#galleryDetailImageWrapper img").css("width", "100%");
        }
    }).resize();
});		
	
</script>-->
