<?php
	if($this->getVar('num_pages') > 1){
		$qr_hits = $this->getVar('browse_results');
		$vn_num_results = $qr_hits->numHits();
		$vn_first_hit = ($this->getVar('items_per_page') * ($this->getVar('page') - 1)) + 1;
		$vn_last_hit = ($vn_num_results < ($this->getVar('items_per_page') * ($this->getVar('page')))) ? $vn_num_results : $this->getVar('items_per_page') * ($this->getVar('page'));
		
		$va_other_paging_parameters = $this->getVar('other_paging_parameters');
		if (!is_array($va_other_paging_parameters)) { $va_other_paging_parameters = array(); }
		$va_other_paging_parameters['show_type_id'] = intval($this->getVar('current_type_id'));
?>
		<div id='detailNavBar'>
<?php	
		if ($this->getVar('page') > 1) {
			print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') - 1), $va_other_paging_parameters))."\"); return false;'>&lsaquo; "._t("Previous")."</a>";
		}else{
			print "&lsaquo; "._t("Previous");
		}
		print "&nbsp;&nbsp;&nbsp;"._t("%1-%2 of %3", $vn_first_hit, $vn_last_hit, $vn_num_results)."&nbsp;&nbsp;&nbsp;";
		if ($this->getVar('page') < $this->getVar('num_pages')) {
			print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("Next")." &rsaquo;</a>";
		}else{
			print _t("Next")." &rsaquo;";
		}
?>
		</div><!-- end searchNav -->
<?php
	}
?>