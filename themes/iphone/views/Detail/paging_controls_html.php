<?php
	if($this->getVar('num_pages') > 1){
		$va_other_paging_parameters = $this->getVar('other_paging_parameters');
		if (!is_array($va_other_paging_parameters)) { $va_other_paging_parameters = array(); }
		$va_other_paging_parameters['show_type_id'] = intval($this->getVar('current_type_id'));
		if ($this->getVar('page') < $this->getVar('num_pages')) {
			print "<div id='moreItems".$this->getVar('page')."'><div class='item'><a href='#' onclick='jQuery(\"#moreItems".$this->getVar('page')."\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("More Items")."</a></div></div>";
		}
	}
?>