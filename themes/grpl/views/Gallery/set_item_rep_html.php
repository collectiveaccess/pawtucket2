<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_previous_row_id = $this->getVar("previous_row_id");
	$pn_next_row_id = $this->getVar("next_row_id");
	$pn_previous_rep_id = $this->getVar("previous_representation_id");
	$pn_next_rep_id = $this->getVar("next_representation_id");

	$pn_set_id = $this->getVar("set_id");
	$pn_row_id = $this->getVar("row_id");
	$ps_table = $this->getVar("table");
	$pn_rep_id = $this->getVar("representation_id");

	$vo_set_item = new ca_set_items($this->getVar("set_item_id"));
	$ps_caption = $vo_set_item->get('ca_set_items.preferred_labels.caption');

	# Added by TG 9/25/2021 to create object based on row (if presentation consists in archival objects)
		if ($ps_table=='ca_objects') {
			$t_object = new ca_objects($pn_row_id);
		#	$n_object_type = $t_object->get('ca_objects.type_id');
		}

	if($pn_previous_item_id > 0){
		print "<a href='#' class='galleryDetailPrevious' onclick='caGalleryNav(\"previous\"); return false;'><i class='fa fa-angle-left'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive' onClick='return false;'><i class='fa fa-angle-left'></i></a>";
	}
	if($pn_next_item_id > 0){
		print "<a href='#' class='galleryDetailNext' onclick='caGalleryNav(\"next\"); return false;'><i class='fa fa-angle-right'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive' onClick='return false;'><i class='fa fa-angle-right'></i></a>";
	}
	print "<div id='galleryDetailImageWrapper'>".$this->getVar("rep")."<p>".$ps_caption."</p></div>"; # TG REPLACED <div> CONTENTS (orig in this comment) TO REMOVE LINK .caDetailLink($this->request, $this->getVar("rep"), '', $ps_table,  $this->getVar("row_id")).$this->getVar("repToolBar")."</div>";
?>


<script type="text/javascript">
	function caGalleryNav(mode) {
<?php
	if($pn_previous_item_id > 0) {
?>
		if(mode == 'previous') {
			<?= "jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); jQuery(\"#\caMediaPanelContentArea:visible\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'gallery', 'id' => $pn_previous_row_id, 'representation_id' => $pn_previous_rep_id, 'set_id' => $pn_set_id, 'overlay' => 1))."\");"; ?>
		}
<?php
	}
	if($pn_next_item_id > 0) {
?>
		if(mode == 'next') {
			<?= "jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); jQuery(\"#\caMediaPanelContentArea:visible\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'gallery', 'id' => $pn_next_row_id, 'representation_id' => $pn_next_rep_id, 'set_id' => $pn_set_id, 'overlay' => 1))."\");"; ?>
		}
<?php
	}
?>
	}
</script>
