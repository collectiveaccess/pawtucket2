<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_item_id = $this->getVar("set_item_id");
	$pn_set_id = $this->getVar("set_id");
	
	$t_set_item = new ca_set_items($pn_set_item_id);
	if  ($t_set_item->get('ca_set_items.set_item_media', array('version' => 'mediumlarge'))) {
		$vs_rep = $t_set_item->get('ca_set_items.set_item_media', array('version' => 'mediumlarge'));
	} else {
		$vs_rep = $this->getVar("rep");
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
	print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $vs_rep, '', 'ca_objects',  $this->getVar("object_id")).$this->getVar("repToolBar")."</div>";	
?>