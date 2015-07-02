<?php
    $vb_write_access = $this->getVar('write_access');
    $vs_view = $this->getVar('view');
    $vn_item_id = $this->getVar('item_id');
    $vn_object_id = $this->getVar('object_id');

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
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
			<?php print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?>
<?php
			if($vn_representation_id){
				print "&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $vn_object_id, 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
?>
			&nbsp;&nbsp;
			<a href='#' title='Comments' onclick='jQuery(".lbSetItemComment").hide(); jQuery("#comment{{{item_id}}}").load("<?php print caNavUrl($this->request, '', '*', 'AjaxListComments', array('item_id' => $vn_item_id, 'type' => 'ca_set_items', 'set_id' => $vn_set_id)); ?>", function(){jQuery("#comment{{{item_id}}}").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small id="lbSetCommentCount{{{item_id}}}">{{{commentCount}}}</small></a>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->
