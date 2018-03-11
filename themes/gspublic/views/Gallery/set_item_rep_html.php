<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_id = $this->getVar("set_id");
	if($pn_previous_item_id){
		print "<a href='#' class='galleryDetailPrevious' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); return false;'>".caGetThemeGraphic($this->request, 'leftArrow.png')."</a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive'>".caGetThemeGraphic($this->request, 'leftArrow.png')."</a>";
	}
	if($pn_next_item_id){
		print "<a href='#' class='galleryDetailNext' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); return false;'>".caGetThemeGraphic($this->request, 'rightArrow.png')."</a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive'>".caGetThemeGraphic($this->request, 'rightArrow.png')."</a>";
	}
	print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $this->getVar("rep"), '', 'ca_objects',  $this->getVar("object_id")).$this->getVar("repToolBar")."</div>";	
?>