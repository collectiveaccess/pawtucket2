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
    $t_item = $this->getVar('item');
    $vn_container_id = $this->getVar('container_id');

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
    $t_set = $this->getVar("set");
	$o_lightbox_config 				= $this->getVar("set_config");
	$vn_download_access				= ($o_lightbox_config->get("lightbox_download_access")) ? $o_lightbox_config->get("lightbox_download_access") : 2;
	$vb_download = false;
	if($t_set->get("ca_sets.access") == $vn_download_access){
		$t_rep = new ca_object_representations($vn_representation_id);
		$vs_mimetype = $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE');
		$va_download_display_info = caGetMediaDisplayInfo('download_high_res', $vs_mimetype);
		$vs_download_version = caGetOption(['download_version', 'display_version'], $va_download_display_info);
		$vb_download = true;
	}
?>
<div class='lbItem'>
	<div class='lbItemContent'>
		{{{representation}}}
		<div id='comment{{{item_id}}}' class='lbSetItemComment'><!-- load comments here --></div>
		<div class='caption'>{{{caption}}}</div>
	</div><!-- end lbItemContent -->
	<div class='lbExpandedInfo' id='lbExpandedInfo{{{item_id}}}'><hr/>
<?php
		if($vb_write_access) {
?>
		   <div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><span class='glyphicon glyphicon-trash'></span></a></div>
<?php
		}
?>
		<div>
<?php 
			# --- is this bulk media?  We need to use the url of the container the bulk media is linked to
			if($vn_container_id){
				print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_container_id, "", array("title" => _t("View Item Detail")));
			}else{
				print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail")));
			}
			
			if($vn_representation_id){
				print "&nbsp;&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
?>
			&nbsp;&nbsp;<a href='#' title='Comments' onclick='jQuery(".lbSetItemComment").hide(); jQuery("#comment{{{item_id}}}").load("<?php print caNavUrl($this->request, '', '*', 'AjaxListComments', array()); ?>", {item_id: <?php print (int)$vn_item_id; ?>, type: "ca_set_items", set_id: <?php print (int)$vn_set_id; ?>}, function(){jQuery("#comment{{{item_id}}}").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small id="lbSetCommentCount{{{item_id}}}">{{{commentCount}}}</small></a>
			&nbsp;&nbsp;<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span>", "", "", "contact", "form", array('object_id' => $vn_object_id, 'contactType' => 'inquiry'), array("title" => _t("Inquire about this item"))); ?>
<?php
			if($vb_download){
?>
				&nbsp;&nbsp;<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-download'></span>", "", "", "Detail", "DownloadMedia", array('context' => 'products', 'object_id' => $vn_object_id, 'download' => 1, 'version' => $vs_download_version), array("title" => _t("Download"))); ?>
<?php
			}
?>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->
