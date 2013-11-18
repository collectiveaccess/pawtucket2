<?php
	$va_set_items = $this->getVar("set_items");
	$t_set = $this->getVar("set");
?>
<H1>Lightbox: <?php print $t_set->get("ca_sets.preferred_labels.name"); ?></H1>
	<div class="row">
		<div class='col-sm-10 col-md-10 col-lg-10'>
<?php
	if(sizeof($va_set_items)){
		$vn_i_col = 0;
		$vn_num_cols = 4;
		foreach($va_set_items as $va_set_item){
			if($vn_i_col == 0){
				print "<div class='row'>";
			}
			$vn_i_col++;
			
			
			print "<div class='col-sm-4 col-md-3 col-lg-3'>";
//			print "<div style='height:275px; border:1px solid #666666; position:relative;'>";
			print caLightboxSetDetailItem($this->request, $va_set_item);
			// print $va_set_item["representation_tag_preview"]."<br/>";
// 			print $va_set_item["set_item_label"];
// 			$t_set_item = new ca_set_items();
// 			$t_set_item->load($va_set_item["item_id"]);
// 			print "<div><a href='#' onclick='jQuery(\"#comment".$va_set_item["item_id"]."\").load(\"".caNavUrl($this->request, '', 'Sets', 'AjaxListComments', array('item_id' => $va_set_item["item_id"], 'tablename' => 'ca_set_items'))."\", function(){jQuery(\"#comment".$va_set_item["item_id"]."\").show();}); return false;'>"._t("Comments")."</a></div>";
// 			print "<div>Num comments: ".$t_set_item->getRatingsCount()."</div>";
// 			print "<div id='comment".$va_set_item["item_id"]."' style='display:none; width:180px; height:275px; background-color:#FFF; position:absolute; left:180px; top:0px; z-index:1000;'><!-- load comments here --></div>";
// 			print "</div>";
			print "</div><!-- end col 3 -->";
			if($vn_i_col == $vn_num_cols){
				print "</div><!-- end row -->";
				$vn_i_col = 0;
			}
		}
		# --- complete cols in row if necessary
		
		if($vn_i_col && ($vn_i_col < $vn_num_cols)){
			while($vn_i_col < $vn_num_cols){
				print "<div class='col-sm-4 col-md-3 col-lg-3'></div>\n";
				$vn_i_col++;
			}
			print "</div><!-- end row -->\n";
		}
	}else{
		print "<div>No items in set</div>";
	}
?>
		</div><!-- end col 10 -->
		<div class="col-sm-2 col-md-2 col-lg-2">
			<h3>comments/ info</h3>
		</div><!-- end col-md-2 -->
	</div><!-- end row -->