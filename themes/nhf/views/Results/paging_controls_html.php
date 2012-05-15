<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
	$vn_current_page = 		$this->getVar('page');
	$vn_total_pages = $this->getVar('num_pages');
?>

	<div id='searchNavBg'><div class='searchNav'>
<?php		
		if($vn_total_pages > 1){
			print "<div class='nav'>";
			if ($this->getVar('page') > 1) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lt; "._t("Previous")."</a>&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;";
			}else{
				print "&lt;&lt; "._t("Previous")."&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;";
			}
			
			
			$vn_p = $vn_current_page;
			if($vn_p > ($vn_total_pages-3)){
				$vn_p = $vn_total_pages-3;
				if($vn_p < 1){
					$vn_p = 1;
				}
			}
			$vn_link_count = 1;
			print _t("Page: ");
			while(($vn_p <= $vn_total_pages) && ($vn_link_count <= 4)){
				if($vn_p == $vn_current_page){
					print $vn_p;
				}else{
					print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $vn_p))."\"); return false;'>".$vn_p."</a>";
				}
				if($vn_p != $vn_total_pages){
					print "&nbsp;&nbsp;";
				}
				$vn_p++;
				$vn_link_count++;
			}
			#print $vn_p;
			if($vn_p <= $vn_total_pages){
				print "<span class='turq'>...</span>";
			}
			if ($this->getVar('page') < $vn_total_pages) {
				print "&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("Next")." &gt;&gt;</a>";
			}else{
				print "&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;"._t("Next")." &gt;&gt;";
			}
			print '</div>';
		}
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->