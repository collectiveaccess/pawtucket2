<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
?>

	<div id='searchNavBg'><div class='searchNav'>
<?php		
		if($this->getVar('num_pages') > 1){
			print "<div class='nav'>";
			if ($this->getVar('page') > 1) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS")."</a>";
			}
			print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('num_pages').'&nbsp;&nbsp;&nbsp;';
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_black_right.gif' width='10' height='10' border='0'></a>";
			}
			print '</div>';
			print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#resultBox").load("'.caNavUrl($this->request, '', $this->request->getController(), 'Index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'._t("GO").'</a></form>';
		}
		
		$vn_num_hits = $this->getVar('num_hits');
		print '<div style="margin-top:2px;">'._t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->