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