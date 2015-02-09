<?php
/** ---------------------------------------------------------------------
 * themes/default/Sets/set_detail_thumbnail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$q_set_items = $this->getVar("result");
	$t_set = $this->getVar("set");
	$vb_write_access = $this->getVar("write_access");
	$va_lightbox_display_name = caGetSetDisplayName();
	$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
	$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
	$vn_object_table_num = $this->request->datamodel->getTableNum("ca_objects");
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
?>
			<div class="row" id="sortable">
<?php
	if($q_set_items->numHits()){
		$vn_c = 0;
		while($q_set_items->nextHit() && ($vn_c < $vn_hits_per_block)){
			$t_set_item = new ca_set_items(array("row_id" => $q_set_items->get("object_id"), "set_id" => $t_set->get("set_id"), "table_num" => $vn_object_table_num));
			if($t_set_item->get("item_id")){
				print "<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3 lbItem".$t_set_item->get("item_id")."' id='row-".$q_set_items->get("object_id")."'><div class='lbItemContainer'>";
				print caLightboxSetDetailItem($this->request, $q_set_items, $t_set_item, array("write_access" => $vb_write_access));
				print "</div></div><!-- end col 3 -->";
				$vn_c++;
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