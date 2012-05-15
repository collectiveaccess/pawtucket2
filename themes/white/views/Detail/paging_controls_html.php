<?php
	if($this->getVar('num_pages') > 1){
		$va_other_paging_parameters = $this->getVar('other_paging_parameters');
		if (!is_array($va_other_paging_parameters)) { $va_other_paging_parameters = array(); }
		$va_other_paging_parameters['show_type_id'] = intval($this->getVar('current_type_id'));
?>
		<div id='detailNavBar'>
<?php	
		if ($this->getVar('page') > 1) {
			print "<div id='previous'><a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') - 1), $va_other_paging_parameters))."\"); return false;'>"._t("<< previous")."</a></div>";
		}
		
		if ($this->getVar('page') < $this->getVar('num_pages')) {
			print "<div id='next'><a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array_merge(array('page' => $this->getVar('page') + 1), $va_other_paging_parameters))."\"); return false;'>"._t("next >>")."</a></div>";
		}
?>
		</div><!-- end searchNav -->
<?php
	}
?>