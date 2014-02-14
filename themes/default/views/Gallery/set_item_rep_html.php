<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_id = $this->getVar("set_id");
	if($pn_previous_item_id){
		print "<a href='#' class='galleryDetailPrevious' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); return false;'>&lsaquo;</a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive'>&lsaquo;</a>";
	}
	if($pn_next_item_id){
		print "<a href='#' class='galleryDetailNext' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); return false;'>&rsaquo;</a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive'>&rsaquo;</a>";
	}
	print $this->getVar("rep");
	print "<div id='galleryDetailMediaToolbar'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $this->getVar("object_id"), 'representation_id' => $this->getVar("representation_id"), 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>";
	if(!$this->request->config->get("disable_my_collections")){
		if ($this->request->isLoggedIn()) {
			print " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Sets', 'addItemForm', array("object_id" => $this->getVar("object_id")))."\"); return false;' ><span class='glyphicon glyphicon-folder-open'></span></a>\n";
		}
	}
	print "</div>";
?>