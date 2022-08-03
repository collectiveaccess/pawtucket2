<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_previous_row_id = $this->getVar("previous_row_id");
	$pn_next_row_id = $this->getVar("next_row_id");
	$pn_previous_rep_id = $this->getVar("previous_representation_id");
	$pn_next_rep_id = $this->getVar("next_representation_id");
	$t_rep = $this->getVar("rep_object");
	$pn_set_item_id = $this->getVar("set_item_id");
	$va_media_info = $t_rep->getMediaInfo("media");	
	$vn_height = $va_media_info["INPUT"]["HEIGHT"];
	$vn_width = $va_media_info["INPUT"]["WIDTH"];
	$pn_set_id = $this->getVar("set_id");
	$pn_row_id = $this->getVar("row_id");
	$ps_table = $this->getVar("table");
	$pn_rep_id = $this->getVar("representation_id");
	if($pn_previous_item_id > 0){
		print "<a href='#' class='galleryDetailPrevious' onclick='caGalleryNav(\"previous\"); return false;'><i class='fa fa-angle-left' role='button' aria-label='previous'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive' onClick='return false;'><i class='fa fa-angle-left' role='button' aria-label='previous'></i></a>";
	}
	if($pn_next_item_id > 0){
		print "<a href='#' class='galleryDetailNext' onclick='caGalleryNav(\"next\"); return false;'><i class='fa fa-angle-right' role='button' aria-label='next'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive' onClick='return false;'><i class='fa fa-angle-right' role='button' aria-label='next'></i></a>";
	}
	if($vn_height > $vn_width){
?>
	<div class="row galleryVertical">
		<div class="col-sm-7" style="position:relative;">
<?php
		print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $t_rep->getMediaTag("media", "page"), '', $ps_table,  $this->getVar("row_id")).$this->getVar("repToolBar")."</div>";	
?>
		</div>
		<div class="col-sm-5" id="galleryDetailObjectInfo"> </div>	
	</div><!-- end row -->
<?php	
	}else{
?>
<div class="row galleryHorizontal">
	<div class="col-sm-12">
<?php
	print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $t_rep->getMediaTag("media", "page"), '', $ps_table,  $this->getVar("row_id")).$this->getVar("repToolBar")."</div>";	
?>
	</div>
</div>
<div class="row galleryHorizontal">
	<div class="col-sm-12 col-md-8 col-md-offset-2" id="galleryDetailObjectInfo"> </div>	
</div><!-- end row -->
<?php
	}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {	
		jQuery("#galleryDetailObjectInfo").load("<?php print caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_set_item_id, 'set_id' => $pn_set_id)); ?>");
	});
	function caGalleryNav(mode) {
<?php
	if($pn_previous_item_id > 0) {
?>
		if(mode == 'previous') {
			<?= "jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); jQuery(\"#\caMediaPanelContentArea:visible\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'gallery', 'id' => $pn_previous_row_id, 'representation_id' => $pn_previous_rep_id, 'set_id' => $pn_set_id, 'overlay' => 1))."\");"; ?>
		} 
<?php 
	}
	if($pn_next_item_id > 0) {
?>
		if(mode == 'next') {
			<?= "jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); jQuery(\"#\caMediaPanelContentArea:visible\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'gallery', 'id' => $pn_next_row_id, 'representation_id' => $pn_next_rep_id, 'set_id' => $pn_set_id, 'overlay' => 1))."\");"; ?>
		}
<?php
	}
?>
	}
</script>
