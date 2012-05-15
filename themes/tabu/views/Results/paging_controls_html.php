<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
	$vo_result_context 		= $this->getVar('result_context');
	$vn_items_per_page		= $this->getVar('current_items_per_page');
?>
	<div id='searchNav'>
<?php		
		print "<b>"._t("Ergebnisse pro Seite").":</b><br/>";
		$va_items_per_page = $this->getVar("items_per_page");
		$vs_current_items_per_page = $vo_result_context->getItemsPerPage();
		if(is_array($va_items_per_page) && sizeof($va_items_per_page) > 0){
			foreach($va_items_per_page as $vn_items_per_p){
				if($vn_items_per_p == $vs_current_items_per_page){
					print "<b><img src='".$this->request->getThemeUrlPath()."/graphics/box_on_black.gif' border='0'>&nbsp;".$vn_items_per_p."</b>&nbsp;&nbsp;";
				}else{
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/box_off.gif' border='0'>&nbsp;".$vn_items_per_p, '', $this->request->getController(), 'Index', '', array('n' => $vn_items_per_p))."&nbsp;&nbsp;";
				}
			}
		}
		# --- mapped results are not paged
		if(($this->getVar('num_pages') > 1)){
			print "<div class='nav'>";
			print "<a href='#'  onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => 1))."\"); return false;'>|&lt;</a>";
			print "&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($this->getVar('page') > 1) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lt;</a>";
			}else{
				print "<span class='linkOff'>&lt;</span>";
			}
			# --- show a range of 3 pages
			$vn_start_page = 1;
			if ($this->getVar('page') > 1) {
				$vn_start_page = $this->getVar('page') - 1;
			}
			if ($this->getVar('page') == $this->getVar('num_pages')) {
				if($this->getVar('page') > 2){
					$vn_start_page = $this->getVar('page') - 2;
				}elseif($this->getVar('page') > 1){
					$vn_start_page = $this->getVar('page') - 1;
				}else{
					$vn_start_page = $this->getVar('page');
				}
				
			}
			$vn_end_page = $vn_start_page + 2;
			while(($vn_start_page <= $vn_end_page) && ($vn_start_page <= $this->getVar('num_pages'))){
				if($this->getVar('page') == $vn_start_page){
					print "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$vn_start_page."</b>";
				}else{
					print "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'  onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $vn_start_page))."\"); return false;'>".$vn_start_page."</a>";
				}
				$vn_start_page++;
			}
			if($vn_end_page < $this->getVar('num_pages')){
				print "&nbsp;&nbsp;&nbsp;...&nbsp;&nbsp;&nbsp;<a href='#'  onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('num_pages')))."\"); return false;'>".$this->getVar('num_pages')."</a>";
			}
			
			print "&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>&gt;</a>";
			}else{
				print "<span class='linkOff'>&gt;</span>";
			}
			print "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'  onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('num_pages')))."\"); return false;'>&gt;|</a>";
			print '</div>';
		}
?>
	</div><!-- end searchNav -->
	<div id="searchFound">
<?php
		$vn_num_hits = $this->getVar('num_hits');
		if($vn_num_hits > 0){
			$vn_count_start = (($this->getVar('page') - 1) * $vn_items_per_page) + 1;
		}else{
			$vn_count_start = 0;
		}
		$vn_count_end = (($this->getVar('page') - 1) * $vn_items_per_page) + $vn_items_per_page;
		if($vn_count_end > $vn_num_hits){
			$vn_count_end = $vn_num_hits;
		}
		print _t("Suchergebnis %1 von %2 von %3", $vn_count_start, $vn_count_end, $vn_num_hits);
?>
	</div>