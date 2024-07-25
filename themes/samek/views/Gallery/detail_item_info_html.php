<?php
	# --- display the media item
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
?>
<div class="row mb-2 align-items-center">
	<div class="col-2 col-sm-1 text-center align-self-start" style="margin-top: 25%">
<?php
	if($pn_previous_item_id > 0){
		print "<button class='btn btn-sm btn-primary align-content-center' hx-target='#galleryDetailItemInfo' hx-trigger='click' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."'><i class='bi bi-chevron-left' role='graphics-document' aria-label='previous'></i></button>";
	}else{
		print "<button class='btn btn-sm btn-primary' disabled><i class='bi bi-chevron-left' role='graphics-document' aria-label='previous'></i></button>";
	}
?>
	</div>
	<div class="col-8 col-sm-6 align-self-start">
<?php
	print "<div id='galleryDetailImageWrapper' class='object-fit-contain'>".caDetailLink($this->request, $this->getVar("rep"), 'text-center w-100 h-100 d-block', $ps_table,  $this->getVar("row_id"))."</div>";	
?>
	</div>
	<div class="col-2 col-sm-1 text-center align-self-start" style="margin-top: 25%">
<?php
	if($pn_next_item_id > 0){
		print "<button class='btn btn-sm btn-primary' hx-target='#galleryDetailItemInfo' hx-trigger='click' hx-get='".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."'><i class='bi bi-chevron-right' role='graphics-document' aria-label='next'></i></button>";
	}else{
		print "<button class='btn btn-sm btn-primary' disabled><i class='bi bi-chevron-right' role='graphics-document' aria-label='next'></i></button>";
	}
?>
	</div><!--end col-sm-1-->
	<div class="col-12 col-sm-4">
<?php
	# --- display the metadata fro the item
	$t_item = $this->getVar("instance");
	$t_set_item = $this->getVar("set_item");
	$config = $this->getVar("config");
	
	$views = $config->get('views');
	$views_info = $views['slideshow'][$this->getVar("table")];
	
	$vs_label = $t_item->getWithTemplate($views_info["labelTemplate"]);
	$vs_content = $t_item->getWithTemplate($views_info["contentTemplate"]);
	$vs_set_item_content = $t_set_item->getWithTemplate($views_info["setItemContentTemplate"]);
	

	print "<div class='small mb-1'>(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")</div>";

	print "<H2>".$vs_label."</H2>";

	print $vs_content;
	
	if($vs_set_item_content != "[BLANK]"){
		print $vs_set_item_content;
	}
	
	print "<div class='text-center py-2 text-capitalize'>".caDetailLink($this->request, _t("View Detail")." <i class='bi bi-arrow-right'></i>", 'btn btn-primary', $this->getVar("table"), $this->getVar("row_id"))."</div>";
?>	
	</div>
</div><!-- end row -->
