<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
?>

	<div id='searchNavBg'><div class='searchNav'>
<?php		
		# --- mapped results are not paged
		if(($this->getVar('num_pages') > 1)){
			print "<div class='nav'>";
			if ($this->getVar('page') > 1) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lsaquo; "._t("Previous")."</a>";
			}else{
				print "<span class='linkOff'>&lsaquo; "._t("Previous")."</span>";
			}
			print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('num_pages').'&nbsp;&nbsp;&nbsp;';
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("Next")." &rsaquo;</a>";
			}else{
				print "<span class='linkOff'>"._t("Next")." &rsaquo;</span>";
			}
			print '</div>';
			print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#resultBox").load("'.caNavUrl($this->request, '', $this->request->getController(), 'Index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>&rsaquo;</a></form>';
		}
		
		$vn_num_hits = $this->getVar('num_hits');
		print '<div style="margin-top:2px;">'._t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->