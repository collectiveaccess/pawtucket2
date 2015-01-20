<?php
	$q_set_items = $this->getVar("result");
	$t_set = $this->getVar("set");
	$vb_write_access = $this->getVar("write_access");
	$va_lightbox_display_name = caGetSetDisplayName();
	$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
	$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
	$vn_object_table_num = $this->request->datamodel->getTableNum("ca_objects")
?>
			<div class="row" id="sortable">
<?php
	if($q_set_items->numHits()){
		while($q_set_items->nextHit()){
			$t_set_item = new ca_set_items(array("row_id" => $q_set_items->get("object_id"), "set_id" => $t_set->get("set_id"), "table_num" => $vn_object_table_num));
			if($t_set_item->get("item_id")){
				print "<div class='col-xs-12 col-sm-4 lbItem".$t_set_item->get("item_id")."' id='row-".$q_set_items->get("object_id")."'><div class='lbItemContainerList'>";
				print caLightboxSetDetailItem($this->request, $q_set_items, $t_set_item, array("write_access" => $vb_write_access, "view" => "list"));
				print "</div></div><!-- end col 3 -->";
			}
		}
	}else{
		print "<div class='col-sm-12'>"._t("There are no items in this %1", $vs_lightbox_display_name)."</div>";
	}
?>
			</div><!-- end row -->
<?php
if($vb_write_access){
?>
	<script type='text/javascript'>
		 jQuery(document).ready(function() {
			 jQuery(".lbItemDeleteButton").click(
				function() {
					var id = this.id.replace('lbItemDelete', '');
					jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'AjaxDeleteItem'); ?>', {'set_id': '<?php print $t_set->get("set_id"); ?>', 'item_id':id} , function(data) { 
						if(data.status == 'ok') { 
							jQuery('.lbItem' + data.item_id).fadeOut(500, function() { jQuery('.lbItem' + data.item_id).remove(); });
						} else {
							alert('Error: ' + data.errors.join(';')); 
						}
					});
					return false;
				}
			);
		 
			$("#sortable").sortable({ 
				cursor: "move",
				opacity: 0.8,
				helper: 'clone',
  				appendTo: 'body',
 				zIndex: 10000,
				update: function( event, ui ) {
					var data = $(this).sortable('serialize');
					// POST to server using $.post or $.ajax
					$.ajax({
						type: 'POST',
						url: '<?php print caNavUrl($this->request, "", "Sets", "AjaxReorderItems"); ?>/row_ids/' + data
					});
				}
			});
			//$("#sortable").disableSelection();
		});
	</script>
<?php
}
?>