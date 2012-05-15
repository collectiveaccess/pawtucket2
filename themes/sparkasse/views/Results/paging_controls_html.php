<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
	$vn_num_hits = $vo_result->numHits();
?>

	<div id='searchNavBg'><div class='searchNav'>
<?php		
	print '<div style="margin-top:2px; float:left; color:#666;">'.$vn_num_hits." ".(($vn_num_hits == 1) ? "Fundstück" : "Fundstücke");
	print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('num_pages').'&nbsp;&nbsp;&nbsp;';
	print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#resultBox").load("'.caNavUrl($this->request, '', $this->request->getController(), 'Index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'."gehen".'</a></form></div>';		
		# --- mapped results are not paged
		if(($this->getVar('num_pages') > 1)){
			print "<div class='nav'>";
			if ($this->getVar('page') > 1) {
				print "<a href='#' style='margin:10px;' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'>zurück &nbsp;<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='16' width='14'></a>";
			}else{
				print "<span class='linkOff' style='margin:10px;'>zurück &nbsp;<img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' border='0' height='16' width='14'></span>";
			}
			
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'><img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='16' width='14'>&nbsp;"._t("vor")."</a>";
			}else{
				print "<span class='linkOff'><img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' border='0' height='16' width='14'>&nbsp;"._t("vor")."</span>";
			}
			print '</div>';
			
		}
		
		$vn_num_hits = $this->getVar('num_hits');
		
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->