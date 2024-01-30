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
	if($pn_previous_item_id > 0){
		print "<a href='#' class='galleryDetailPrevious' onclick='caGalleryNav(\"previous\"); return false;'><i class='fa fa-chevron-left' role='graphics-document' aria-label='previous'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive' onClick='return false;'><i class='fa fa-chevron-left' role='graphics-document' aria-label='previous'></i></a>";
	}
	if($pn_next_item_id > 0){
		print "<a href='#' class='galleryDetailNext' onclick='caGalleryNav(\"next\"); return false;'><i class='fa fa-chevron-right' role='graphics-document' aria-label='next'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive' onClick='return false;'><i class='fa fa-chevron-right' role='graphics-document' aria-label='next'></i></a>";
	}
	#print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $this->getVar("rep"), '', $ps_table,  $this->getVar("row_id")).$this->getVar("repToolBar")."</div>";	

	$vs_rep_record_table = $this->getVar("rep_record_table");
	$vn_rep_record_row_id = $this->getVar("rep_record_row_id");
	if($vs_rep_record_table && $vn_rep_record_row_id){
		$t_rep_record = Datamodel::getInstanceByTableName($vs_rep_record_table);
		$t_rep_record->load($vn_rep_record_row_id);
		$this->request->setParameter('context', 'objects');
		print "<div id='galleryDetailImageWrapper'>".caRepresentationViewer(
					$this->request, 
					$t_rep_record, 
					$t_rep_record,
					array(
						'display' => 'detail',
						'showAnnotations' => false, 
						'primaryOnly' => true, 
						'dontShowPlaceholder' => true, 
						'captionTemplate' => ''
					)
				)."</div>";
	}

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
