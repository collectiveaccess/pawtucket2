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
   # $vs_caption_long = $this->getVar('caption_long');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
?>
<div class="row"><div class="col-sm-12"><hr/></div></div>
<div class="row lbListItem">
	<div class="col-sm-2 text-center">
		{{{representation}}}
<?php
			if($vn_representation_id || $vb_write_access){
				print "<div class='lbListItemButtons'>";
			}
			if($vn_representation_id){
				print "<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
			if($vn_representation_id || $vb_write_access){
				print "</div>";
			}
?>

	</div>
	<div class="col-sm-3">
		<div><?php print caDetailLink($this->request, $this->getVar("caption"), '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?></div>

	</div>
	<div class="col-sm-6">
<?php
	if($vb_write_access){
?>
		<form id="setItemForm{{{item_id}}}">					
			<div class='form-group'>
				<label for='notes' class='control-label'>Caption</label>
				<input type='text' name='set_item_caption' value='{{{set_item_caption}}}' class='form-control'>
			</div>
			<div class='form-group'>
				<input type="submit" value="save" class="btn btn-default">
			</div>
			<input type="hidden" name="item_id" value="{{{item_id}}}">
			<p class="saving" style="display:none;">
				saving....
			</p>
		</form>	
<?php
	}else{
		print "<b>Caption</b><br/>".(($vs_tmp = $this->getVar("set_item_caption")) ? $vs_tmp : "<small>No caption available</small>");
	}
?>	
	</div>
	<div class="col-sm-1">
<?php
		if($vb_write_access) {
?>
		   	<a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><span class='glyphicon glyphicon-remove-circle'></span></a>
<?php
		}
?>
	</div>
</div>

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

