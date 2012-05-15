<?php
	if($this->getVar('num_pages') > 1){
		$va_other_paging_parameters = $this->getVar('other_paging_parameters');
		if (!is_array($va_other_paging_parameters)) { $va_other_paging_parameters = array(); }
		$va_other_paging_parameters['show_type_id'] = intval($this->getVar('current_type_id'));
?>
		<div class='searchNav'>
<?php	
		if ($this->getVar('page') > 1) {
			print "<a href='#' class='nextPrevious' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') - 1), $va_other_paging_parameters))."\"); return false;'>&lt; "._t("Prev")."</a>&nbsp;&nbsp;";
		}
		$p = 1;
		if($this->getVar('num_pages') > 30){
			$p = $this->getVar('page') - 15;
		}
		if($p < 1){
			$p = 1;
		}
		$p_count = 0;
		while(($p <= $this->getVar('num_pages')) && ($p_count < 25)){
			if($p == $this->getVar('page')){
				if($p > 99){
					$vs_class = "pageNumExtraWideOn";
				}elseif($p > 9){
					$vs_class = "pageNumWideOn";
				}else{
					$vs_class = "pageNumOn";
				}
				print "<a href='#' class='$vs_class' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $p), $va_other_paging_parameters))."\"); return false;'>".$p."</a>";
			}else{
				print "<a href='#' class='pageNum' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $p), $va_other_paging_parameters))."\"); return false;'>".$p."</a>";
			}
			$p++;
			$p_count++;
		}
		if ($this->getVar('page') < $this->getVar('num_pages')) {
			print "&nbsp;&nbsp;<a href='#' class='nextPrevious' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("Next")." &gt;</a>";
		}
?>
		</div><!-- end searchNav -->
<?php
	}
?>