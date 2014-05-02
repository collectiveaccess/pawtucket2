<?php
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
	$vb_write_access = $this->getVar("write_access");
?>
			<div class="row" id="sortable">
<?php
	if(sizeof($va_set_items)){
		foreach($va_set_items as $va_set_item){
			print "<div class='col-sm-4 col-md-3 col-lg-3 lbItem".$va_set_item["item_id"]."' id='row-".$va_set_item["row_id"]."'><div class='lbItemContainer'>";
			print caLightboxSetDetailItem($this->request, $va_set_item, array("write_access" => $vb_write_access));
			print "</div></div><!-- end col 3 -->";
		}
	}else{
		print "<div>No items in set</div>";
	}
?>
			</div><!-- end row -->