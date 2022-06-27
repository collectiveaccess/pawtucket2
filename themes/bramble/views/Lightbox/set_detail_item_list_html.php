<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_detail_item_html.php :
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
 
    $vb_write_access = $this->getVar('write_access');
    $vs_view = $this->getVar('view');
    $vn_item_id = $this->getVar('item_id');
    $vn_set_id = $this->getVar('set_id');
    $vn_object_id = $this->getVar('object_id');
    $vn_item_id = $this->getVar('item_id');

    $vs_caption = $this->getVar('caption');
    $vs_caption_long = $this->getVar('caption_long');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
?>
<div class="row lbListItem">
	<div class="col-sm-2 text-center">
		{{{representation}}}
<?php
			if($vn_representation_id || $vb_write_access){
				print "<div class='lbListItemButtons'>";
			}
			if($vn_representation_id){
				print caNavLink($this->request, "<span class='glyphicon glyphicon-download'></span>", "", "", "Lightbox", "getLightboxMedia", array("object_id" => $vn_object_id, "set_id" => $vn_set_id, "download" => true), array("title" => _t("Download Media")));
				print "&nbsp;&nbsp;&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
			if($vb_write_access) {
?>
		   	&nbsp;&nbsp;<a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><span class='glyphicon glyphicon-trash'></span></a>
<?php
			}
			if($vn_representation_id || $vb_write_access){
				print "</div>";
			}
?>

	</div>
	<div class="col-sm-3">
		<H2><?php print caDetailLink($this->request, $this->getVar("caption_long"), '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?></H2>

	</div>
	<div class="col-sm-7">
		<form id="setItemForm{{{item_id}}}">
			<div class="row">
				<div class="col-sm-3">
					<div class='form-group'>
						<label for='size' class='control-label'>Size</label>
						<input type='text' name='size' value='{{{size}}}' class='form-control'>
					</div>
				</div>
				<div class="col-sm-3">
					<div class='form-group'>
						<label for='quantity' class='control-label'>Quantity</label>
						<input type='text' name='quantity' value='{{{quantity}}}' class='form-control'>
					</div>
				</div>
				<div class="col-sm-5">
					<div class='form-group'>
						<label for='notes' class='control-label'>Notes</label>
						<input type='text' name='notes' value='{{{notes}}}' class='form-control'>
					</div>
				</div>
				<div class="col-sm-1">
					<div class='form-group'>
						<label></label>
						<input type="submit" value="save" class="btn btn-default">
					</div>
					<input type="hidden" name="item_id" value="{{{item_id}}}">
					<p class="saving" style="display:none;">
						saving....
					</p>
				</div>
			</div>
		</form>		
	</div>
</div>
<div class="row"><div class="col-sm-12"><hr/></div></div>


<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#setItemForm{{{item_id}}}').on('submit', function(e){		
			jQuery('#setItemForm{{{item_id}}} .saving').show();
			jQuery.getJSON(
				'<?php print caNavUrl($this->request, '', 'Lightbox', 'ajaxSaveSetItemInfo', null); ?>',
				jQuery('#setItemForm{{{item_id}}}').serializeObject(), function(data) {
					jQuery('#setItemForm{{{item_id}}} .saving').hide();
					
					
					
				}
			);
			e.preventDefault();
			return false;
		});
	});
</script>

