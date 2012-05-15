<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
		
		# --- mapped results are not paged
		if(($this->getVar('num_pages') > 1)){
?>
	<div class='searchNav'>
<?php
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<div class='navNext'>";
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>&gt;</a>";
				print "</div>";
			}
			
			$vn_page_range_start = "";
			$vn_page_range_end = "";
			$vn_page_range_start = $this->getVar('page') - 10;
			if($vn_page_range_start < 1){
				$vn_page_range_start = 1;
			}
			$vn_page_range_end = $this->getVar('page') + 10;
			if($vn_page_range_end > $this->getVar('num_pages')){
				$vn_page_range_end = $this->getVar('num_pages');
			}
			$p = $vn_page_range_start;
			if($vn_page_range_start > 1){
				print "...";
			}
			while($p <= $vn_page_range_end){
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $p))."\"); return false;'".(($p == $this->getVar('page')) ? " class='currentPage' ": "").">".$p."</a>";
				if($p < $vn_page_range_end){
					print ", ";
				}
				$p++;
			}
			if($vn_page_range_end < $this->getVar('num_pages')){
				print "...";
			}
			
			if ($this->getVar('page') > 1) {
				print "<div class='navPrevious'>";
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lt;</a>";
				print "</div>";
			}
?>
	</div><!-- end searchNav -->
<?php
		}		
?>