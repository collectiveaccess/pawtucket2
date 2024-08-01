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

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $annotation_id = $this->getVar('annotation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
    
    $start = $this->getVar('startTimecode');
    $end = $this->getVar('endTimecode');
    if($start || $end) {
    	$timecode_display = ($start && $end) ? "{$start} ➜ {$end}" : "{$start}{$end}";
    }
    $av_rep_ids = $this->getVar('av_rep_ids');
?>
<div class='lbItem'>
<?php
	if($av_rep_ids[$vn_representation_id] ?? false) {
		print caHTMLCheckboxInput('compare', ['class' => 'lbCompareCheckbox', 'value' => $vn_item_id]); 
	}
?>
	<div class='lbItemContent'>
		{{{representation}}}
		<div id='comment{{{item_id}}}' class='lbSetItemComment'><!-- load comments here --></div>
		<div class='lb-caption text-center'>{{{caption}}}</div>
<?php
	if($timecode_display) {
?>
		<div class='lb-caption text-center'><?= $timecode_display; ?></div>
<?php
	}
?>
	</div><!-- end lbItemContent -->


	<div class='lbExpandedInfo' id='lbExpandedInfo{{{item_id}}}'><hr/>
<?php
		if($vb_write_access) {
?>
		   <div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><?= caNavIcon(__CA_NAV_ICON_TRASH__, '12px'); ?></a></div>
<?php
		}
?>
		<div>
			<?php print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?>
<?php
			if($vn_representation_id){
				print "&nbsp;&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
?>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->

